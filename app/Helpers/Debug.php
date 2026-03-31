<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use ReflectionClass;

/**
 * Various useful debugging routines (better to have these in one place than spewed everywhere
 * also, more easily checked for/removed when in production
 *
 * @SuppressWarnings("ClassComplexity")
 */
final class Debug {

    /**
     *   cheeky function to access protected elements of objects
     *
     * this is often NOT a SdtObject, sometimes laravel model, sometimes xero model, etc
     *
     * param  object $obj  Typically, in this context, a laravel model
     * param  string $prop whatever property name (usually 'attributes')
     */
    public static function accessProtected(mixed $obj, string $prop): mixed {

        $reflection = new ReflectionClass($obj);
        $property   = $reflection->getProperty($prop);
        $property->setAccessible(true);

        return $property->getValue($obj);

    } //end accessProtected()

    /**
     * A tidier version of var_dump
     *
     * Yes, the cyclomatic complexity is through the roof.
     * Simplifying it further is left as an exercise for the reader
     *
     * Simplifies the following code (which had even crazier cyclomatic complexity)
     *     if ( \is_numeric( $data ) ) {
     *       $retval .= "Number: $data";
     *     } elseif ( \is_string( $data ) ) {
     *       $retval .= "String: '$data'";
     *     } elseif ( \is_null( $data ) ) {
     *       $retval .= 'NULL';
     *     } elseif ( $data === true ) {
     *       $retval .= 'TRUE';
     *     } elseif ( $data === false ) {
     *       $retval .= 'FALSE';
     *     } elseif ( is_array( $data ) ) {
     *       $retval .= 'Array (' . count( $data ) . ')';
     *       $indent++;
     *       foreach ( $data as $key => $value ) {
     *         $retval .= PHP_EOL . "$prefix [$key] = ";
     *         $retval .= dump( $value, $indent );
     *       }
     *       $indent--;
     *     } elseif ( is_object( $data ) ) {
     *       $retval .= 'Object (' . get_class( $data ) . ')';
     *       $indent++;
     *       foreach ( $data as $key => $value ) {
     *         $retval .= PHP_EOL . "$prefix $key -> ";
     *         $retval .= dump( $value, $indent );
     *       }
     *       $indent--;
     *     }
     *
     * param  object $data        the object (etc) to be printed out - can be ANY type (class, string, int, whatever)
     *
     * @param mixed    $data
     * @param bool     $ignoreNulls
     * @param int      $indent
     * @param string[] $ignoreFields
     */
    public static function dump(mixed $data, bool $ignoreNulls=false, int $indent=0, array $ignoreFields=[]): string {

        $retval = '';
        $prefix = str_repeat(' |  ', $indent);
        $type   = gettype($data);

        $typeFunctions = [
            // adding typehinting would make this VERY hard to read. It's debugging, so less critical, and all
            // called internally. Types are as above (the dump signature), except prefix, which is a string
            'array' => static function ($data, $prefix, $ignoreNulls, &$indent, $ignoreFields): string {
                $retval = 'Array ('.count($data).')';
                return $retval.self::dumpIterable($data, $prefix, $ignoreNulls, $indent, $ignoreFields);
            },
            'boolean' => static fn ($data, $prefix, $ignoreNulls, &$indent, $ignoreFields): string => [false => 'FALSE',
                true => 'TRUE'][$data],
            'double' => static fn ($data, $prefix, $ignoreNulls, &$indent, $ignoreFields): string => "Double: $data",
            'integer' => static fn ($data, $prefix, $ignoreNulls, &$indent, $ignoreFields): string => "Integer: $data",
            'NULL' => static fn ($data, $prefix, $ignoreNulls, &$indent, $ignoreFields): string => 'null',
            'object' => static function ($data, $prefix, $ignoreNulls, &$indent, $ignoreFields): string {

                $className = $data::class;
                $retval    = 'Object ('.$className.')';
                $object    = $data;

                // allows us to infinitely expand special cases for stupid classes, without increasing complexity
                $classFunctions = [
                    'Cake\Chronos\Chronos' =>
                        static fn ($data, $retval): string => "(Chronos): {$data->format('Y-m-d H:i:s')}",
                    'Cake\Chronos\ChronosDate' =>
                        static fn ($data, $retval): string => "(Date): {$data->format('Y-m-d')}",
                    'DateTime' => static fn ($data, $retval): string => "(DateTime): {$data->format('Y-m-d H:i:s')}",
                    'GuzzleHttp\Client' => static fn ($data, $retval): string => "{$retval}",
                    'Illuminate\Support\Carbon' =>
                        static fn ($data, $retval): string => "(Carbon): {$data->format('Y-m-d H:i:s')}",
                ];

                // if we can just jump out early, then do so
                if (isset($classFunctions[$className])) {
                    return $classFunctions[$className]($data, $retval);
                }

                // laravel models are a bit special (ie, we need to look at the protected attributes property)
                if (str_starts_with($className, 'App\\Models\\')) {
                    $object = self::accessProtected($data, 'attributes');

                } elseif (str_starts_with($className, 'XeroPHP\\Models\\')) {
                    // just unhide everything. Most xero nonsense is handled in dumpIterable
                    $object = self::accessAllProtected($data);

                } else {
                    $object = (array) $data;
                }

                return $retval.self::dumpIterable($object, $prefix, $ignoreNulls, $indent, $ignoreFields);
            },
                'string' => static fn ($data, $prefix, $ignoreNulls, &$indent) => "String: \"$data\"",
        ];

        if (isset($typeFunctions[$type])) {
            if (! $ignoreNulls || $type !== 'NULL') {
                $retval .= $typeFunctions[$type]($data, $prefix, $ignoreNulls, $indent, $ignoreFields);
            } else {
                $retval .= "UNKNOWN TYPE: '$data' [$type]";
            }
        }

        // this means we can just echo dump(whatever), instead of having to add .PHP_EOL to the end
        if ($indent === 0) {
            return $retval.PHP_EOL;
        }

        return $retval;

    } //end dump()

    /**
     * explain what all the shortcuts in dumpOcto actually mean, per object type (ie, class)
     *
     * case statements are GOOD (see dumpOcto for long winded explanation)
     *
     * @SuppressWarnings("CyclomaticComplexity")
     * @SuppressWarnings("ExcessiveMethodLength")
     */
    public static function dumpExplanation(string $className): string {

        $output = '';

        if (! str_contains($className, 'App\\Models\\')) {
            $className = "App\\Models\\{$className}";
        }

        // allow for lazy coders
        $className = strtolower($className);

        switch ($className) {
            case 'app\models\credit':
                $output .= 'Cr: [id], C: [id], CS: [id] $amount, desc';
                $output .= ', SA: set_at_inv_date, dAN: do_apply_next_inv, aI: [applied_to_inv_id], aa: applied_at';
                break;
            case 'app\models\customer':
                $output .= 'C: [id], no: customer_number';
                $output .= ', [A: is_active, B: is_business, dI: do_invoice';
                $output .= ', dBtB: do_blocktime_breakdown, dCI: do_charge_interest, ccy: currency';
                $output .= ', prox mo: proximate_months, day: proximate_day';
                break;
            case 'app\models\customercontract':
                $output .= 'CC: [id], ccy, intvl: monthly_interval, next intvl: next_monthly_interval';
                $output .= ', end date: end_date, last inv date: last_invoice_date';
                $output .= "\n ".self::dumpExplanation('App\Models\CustomerService');
                break;
            case 'app\models\customerservice':
                $output .= 'CS: [id] $: unit_price, qty: quantity, disc %: discount_percent';
                $output .= ', srd: start_request_date, sd: start_date, erd: end_request_date, ed: end_date';
                $output .= "\n ".self::dumpExplanation('App\Models\Service');
                break;
            case 'app\models\invoice':
                $output .= 'I: [id] currency, [I: is_initial, A: is_adhoc, wIC: was_interest_charged, P: is_paid]';
                $output .= ', no: invoice_number, TMI: this_month_index, created_yyyymm';
                $output .= ', CD: created_date, ID: invoice_date, DD: due_date';
                $output .= "\n ".self::dumpExplanation('App\Models\InvoiceLine');
                break;
            case 'app\models\invoiceline':
                $output .= 'IL: cs_id [customer_service_id], $(quantity * unit_price)';
                $output .= ', qty: quantity, up$: unit_price, op$: original_price';
                $output .= ', disc %: display_discount_percent, prorata desc: pro_rata_description, description';
                break;
            case 'app\models\service':
                $output .= 'S: [id]  mo aligned: is_month_aligned, usage: is_usage_based, recurring: is_recurring';
                $output .= ', nzd: price_nzd, aud: price_aud, usd: price_usd, fn: billing_function';
                $output .= "\n ".self::dumpExplanation('App\Models\ServiceType');
                break;
            case 'app\models\servicetype':
                $output .= 'ST: [id] description, billing_class';
                break;
            // plus, having a case gives us this nice catch-all in case we see unexpected models
            default:
                return "Unknown class name: {$className}";
        }

        // if we get to here, $output will always have something in it
        if (substr($output, -4) !== "---\n") {
            $output .= "\n--------------------------------------------------------------------------------------\n";
        }

        return $output;

    } //end dumpExplanation()

    /**
     * turn the object into a succinct description, with all the bits we need for a full debug
     *
     * Debatably, this could/should be called dumpObject, to be consistent with dumpTable, below, BUT, since it'll
     * be used so commonly, it (debatably) makes more sense to keep it consistent with Debug::dump, of which it
     * is a variant (of sorts)
     *
     * param  object $object (typically a laravel model BUT, best to be safe just in case (hence loose typing))
     *
     * dammit, case statements are good.
     *
     * On a side note though, this code _could_ be reduced in complexity by putting each case statement in a separate
     * function, then doing some clever php-function-calling-by-variable, eg:
     *
     *     $servicetype = function($object) {
     *         return "ST: [{$object->id}] '{$object->description}'";
     *     };
     *
     *     $modelName = strtolower(str_replace("App\\Models\\", "", object::class));
     *
     *     return $modelName($object);
     *
     * but guess what? it's 11 lines longer, and significantly less readable (not to mention the horrorshow of
     * "clever" code above. Ie, it's a LOT less maintainable. So, let's not do that, "complexity" be damned.
     *
     * Which brings us back to the initial statement, above: case statements are GOOD
     *
     * @SuppressWarnings("CyclomaticComplexity")
     * @SuppressWarnings("NPathComplexity")
     * @SuppressWarnings("ExcessiveMethodLength")
     * phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function dumpOcto(?Model $object, int $indent=0, bool $doExplain=false): string {

        if (is_null($object)) {
            return 'null';
        }

        $strIndent = str_repeat('    ', $indent);

        $className = $object::class;

        $output = '';
        // only do a big title on the first one
        if (! $indent) {
            $upperClassName = self::convertPossiblePathedClassToUpperString($className);
            $output         = "============================== {$upperClassName} ==============================\n";
        }

        if ($doExplain) {
            $output .= self::dumpExplanation($className);
        }

        switch ($className) {
            case 'App\Models\Credit':
                $output  = "Cr: [{$object->id}], C: [{$object->customer_id}], CS: [{$object->customer_service_id}]";
                $output .= " \${$object->amount} '{$object->description}', SA: ".dFmt($object->set_at_invoice_date);
                $output .= ', dAN: '.bToStr($object->do_apply_next_invoice);
                $output .= ", aI: [{$object->applied_to_invoice_id}], aa: ".dFmt($object->applied_at);
                break;
            case 'App\Models\Customer':
                $output .= "{$strIndent}C: [{$object->id}] no: {$object->customer_number}, ";
                $output .= '[A:'.bToStr($object->is_active).',B:'.bToStr($object->is_business);
                $output .= ',dI:'.bToStr($object->do_invoice);
                $output .= ',dBtB:'.bToStr($object->do_blocktime_breakdown);
                $output .= ',dCI:'.bToStr($object->do_charge_interest);
                $output .= ',M:'.bToStr($object->is_managed).']';
                $output .= ", ccy: {$object->currency}";
                $output .= ", prox mo: {$object->proximate_months} day: {$object->proximate_day}";
                break;
            case 'App\Models\CustomerContract':
                $output .= "{$strIndent}CC: [{$object->id}] {$object->ccy} intvl: {$object->monthly_interval}";
                $output .= ", next intvl: {$object->next_monthly_interval}, end date: ".dFmt($object->end_date);
                $output .= ', last inv date: '.dFmt($object->last_invoice_date);
                $output .= ", type: {$object->contract_type}";
                foreach ($object->customer_services as $cService) {
                    $output .= "\n".self::dumpOcto($cService, $indent + 1, doExplain: $doExplain);
                }
                break;
            case 'App\Models\CustomerService':
                $output .= "{$strIndent}CS: [{$object->id}] $: {$object->unit_price}, qty: {$object->quantity}, ";
                $output .= 'disc %: '.floatFmt(100.0 * $object->discount_percent);
                $output .= ', srd: '.dFmt($object->start_request_date).', sd: ';
                $output .= dFmt($object->start_date).', erd: '.dFmt($object->end_request_date);
                $output .= ', ed: '.dFmt($object->end_date) . ', iIO: '. bToStr($object->is_internal_only);
                $output .= "\n".self::dumpOcto($object->service, $indent + 1, doExplain: $doExplain);
                break;
            case "App\Models\Invoice":
                $output .= "{$strIndent}I: [{$object->id}] ".strtoupper($object->currency).' ';
                $output .= number_format($object->total_amount_due, 2);
                $output .= ' [I:'.bToStr($object->is_initial).',A:'.bToStr($object->is_adhoc);
                $output .= ',wIC:'.bToStr($object->was_interest_charged).',P:'.bToStr($object->is_paid).'], ';
                $output .= "no: {$object->invoice_number} '{$object->display_invoice_number}', ";
                $output .= 'TMI:'.$object->this_month_index.', ';
                $output .= "{$object->created_yyyymm}, ";
                $output .= '{CD:'.dFmt($object->created_date).', ID:';
                $output .= dmFmt($object->invoice_date).', DD:'.dmFmt($object->due_date).'}';
                if (! $object->invoice_lines) {
                    $output .= "\n{$strIndent}[no lines]";
                }
                foreach ($object->invoice_lines as $invoiceLine) {
                    $output .= "\n".self::dumpOcto($invoiceLine, $indent + 1, doExplain: $doExplain);
                }
                $output .= "\n".self::dumpOcto($object->customer, $indent + 1, doExplain: $doExplain);
                $output .= "\n".self::dumpOcto($object->customer_contract, $indent + 1, doExplain: $doExplain);
                break;
            case 'App\Models\InvoiceLine':
                $output .= "{$strIndent}IL: cs_id [{$object->customer_service_id}] ";
                $output .= '$'.number_format($object->quantity * $object->unit_price, 2).', ';
                $output .= "qty: {$object->quantity}, up$: {$object->unit_price}, ";
                $output .= "op$: {$object->original_price}, disc %: ";
                $output .= floatFmt(100.0 * $object->display_discount_percent) . ', prorata desc: ';
                $output .= "'{$object->pro_rata_description}', iIO: ". bToStr($object->is_internal_only);
                $output .= "\n{$strIndent}    {$object->description}";
                break;
            case "App\Models\Service":
                $output .= "{$strIndent}S: [{$object->id}]  mo aligned: ".bToStr($object->is_month_aligned);
                $output .= ', usage: ';
                $output .= bToStr($object->is_usage_based).', recurring: '.bToStr($object->is_recurring);
                $output .= ", nzd: {$object->price_nzd}, aud: {$object->price_aud}, usd: {$object->price_usd}, ";
                $output .= "fn: '{$object->billing_function}'";
                $output .= "\n".self::dumpOcto($object->service_type, $indent + 1, doExplain: $doExplain);
                break;
            case 'App\Models\ServiceType':
                // note with this, we DO care about the description, because setting desc to "Mock Usage" fires off
                // the MockUsage usage based test object. SO, if the description is NOT set to that, tests may
                // fail in interesting ways. Ergo, the code below
                $output .= "{$strIndent}ST: [{$object->id}] '{$object->description}', bc: {$object->billing_class}";
                break;
            // plus, having a case gives us this nice catch-all in case we see unexpected models (or other classes)
            default:
                return $output.self::dump($object);
        }

        // and only wrap up on the last one
        if (! $indent) {
            $output .= "\n--------------------------------------------------------------------------------------\n";
        }

        return $output;

    } //end dumpOcto()

    /**
     * Output an Eloquent query, BUT! Include the parameter values (which default ->toSql() does NOT do)
     *
     * also optionally runs the output through formatSql, for tidiness (default false)
     *
     * @param EloquentBuilder<Model> $query
     */
    public static function dumpQuery(EloquentBuilder $query, bool $doFormat=false): string {

        $sql      = $query->toSql();
        $bindings = $query->getBindings();

        // Substitute bindings
        foreach ($bindings as $binding) {
            // use default Debug::dump method - a bit noisy (will output types) but stronger than eg string casting
            $strBinding = self::dump($binding);
            $sql        = preg_replace('/\?/', $strBinding, $sql, 1);
        }

        # if we're doing something complex, and want it tidied up
        if ($doFormat) {
            $sql = self::formatSql($sql);
        }

        return $sql . PHP_EOL;

    } //end dumpQuery()

    /**
     * Attempts to tidy format complex sql, so we can actually read it
     *
     * (critical when converting sql -> orm)
     *
     * @SuppressWarnings("CyclomaticComplexity")
     */
    public static function formatSql(string $sql): string {

        $keywords = ['select', 'as', 'from', 'inner', 'outer', 'left', 'right',  'join', 'on', 'where',
            'group by', 'order by', 'and', 'or', 'is', 'not', 'null', 'exists', 'sum'];

        // capitalise keywords
        foreach ($keywords as $keyword) {
            $upper = strtoupper($keyword);
            // want to be very careful not to screw up eg field names that might have "on" in them
            $sql = str_replace(" {$keyword} ", " {$upper} ", $sql);
            // but also catch new lines
            $sql = str_replace("\n{$keyword} ", "\n{$upper} ", $sql);
            // and the start of the entire thing (eg select...)
            $sql = preg_replace("/^{$keyword} /", "{$upper} ", $sql);
            // and inside brackets (of course)
            $sql = str_replace("({$keyword} ", "({$upper} ", $sql);
        }

        // these are functions that have multiple parameters (ie, commas in the param list)
        $knownFunctions = ['date_format', 'ifnull'];
        $index          = 0;
        foreach ($knownFunctions as $keyword) {
            $upper = strtoupper($keyword);
            $sql   = str_replace("{$keyword}(", "{$upper}(", $sql);
            // uppercase each function as we go, so the code below works
            $knownFunctions[$index] = $upper;
            $index++;
        }

        // new lines
        $startLines = ['FROM', 'INNER JOIN', 'OUTER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'WHERE', 'ORDER BY', 'GROUP BY'];
        foreach ($startLines as $startLine) {
            $sql = str_replace("{$startLine} ", "\n{$startLine} ", $sql);
        }

        // new lines with an indent
        $startLines = ['SELECT', 'WHERE', 'AND', 'ORDER BY', 'GROUP BY'];
        foreach ($startLines as $startLine) {
            $sql = str_replace("{$startLine} ", "{$startLine}\n  ", $sql);
        }

        // special case for commas - avoid splitting in the middle of functions
        $pos = -1;
        $pos = strpos($sql, ',', $pos + 1);
        while ($pos !== false) {
            // first, get the current line (from new line to the comma)
            $previousNewLinePos = strrpos(substr($sql, 0, $pos), "\n");
            // if no newline, just go back to the start
            if ($previousNewLinePos !== false) {
                $line = substr($sql, $previousNewLinePos, $pos - $previousNewLinePos);
            } else {
                $line = substr($sql, 0, $pos);
            }

            // then check it doesn't include a function, if so, we do NOT want to break things
            $isFunction = false;
            foreach ($knownFunctions as $keyword) {
                if (str_contains($line, $keyword)) {
                    $isFunction = true;
                    break;
                }
            }
            if (!$isFunction) {
                $sql = substr($sql, 0, $pos) . ",\n  " . substr($sql, $pos + 1);
            }
            $pos = strpos($sql, ',', $pos + 1);
        }

        return $sql . PHP_EOL;

    } //end formatSql()

    /**
     *   used by dump(), outputs iterables
     *
     * object can be any kind of iterable
     *
     * @param iterable<mixed> $object
     * @param string          $prefix
     * @param bool            $ignoreNulls
     * @param int             $indent
     * @param string[]        $ignoreFields
     */
    private static function dumpIterable(iterable $object, string $prefix, bool $ignoreNulls, int $indent,
        array $ignoreFields): string {

        $retval = '';

        /** @var string $key */
        foreach ($object as $key => $value) {
            if ($ignoreNulls && gettype($value) === 'NULL') {
                continue;
            }

            // xero! of course it's xero. puts stupid invisible characters ahead of protected fields
            $key = str_replace(chr(0x00).'*'.chr(0x00), '', $key);
            $key = str_replace(chr(0x00), '', $key);
            // and then... has multiple field names? surreal how badly they munge things
            $key = str_replace("XeroPHP\Applicationtransport", 'transport', $key);

            // <sigh> xero. Of course
            // (yes, it would be far cleverer to dynamically identify recursion, but this will do for now)
            if (str_ends_with($key, '_associated_objects')) {
                $retval .= PHP_EOL."$prefix $key => Array (recursion)";
                continue;
            }
            // if it's something we want to ignore, then skip it
            if (in_array($key, $ignoreFields, true)) {
                continue;
            }

            $retval .= PHP_EOL."$prefix $key => ".self::dump($value, $ignoreNulls, $indent + 1, $ignoreFields);
        }

        return $retval;

    } //end dumpIterable()

    /**
     *   cheeky function to access an entirely protected object
     *
     * this is often NOT a SdtObject, sometimes laravel model, sometimes xero model, etc
     *
     * @return array<string, mixed>
     */
    private static function accessAllProtected(mixed $obj): array {

        $reflection = new ReflectionClass($obj);
        $props      = $reflection->getProperties();
        $newObj     = [];
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $newObj[$prop->name] = $prop->getValue($obj);
        }

        return $newObj;

    } //end accessAllProtected()

    /**
     * converts a class like App|Models\ServiceType to SERVICE_TYPE
     *
     * BUT, allow for the fact that we might receive eg "Object" (with no backslashes)
     */
    private static function convertPossiblePathedClassToUpperString(string $className): string {

        // default to the entire string
        $lastWordPos = 0;

        // only get from the last backslash onwards if there IS actually a last backslash
        $lastSlashPos = strrpos($className, '\\');
        // note, we have to do it precisely like this, because it could be 0 (num zero) OR false, ha ha ha urk. php.
        if ($lastSlashPos !== false) {
            $lastWordPos = $lastSlashPos + 1;
        }

        $lastWord = substr($className, $lastWordPos);

        // stolen: https://stackoverflow.com/questions/40514051/using-preg-replace-to-convert-camelcase-to-snake-case
        $crazyRegex    = '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/';
        $separator     = '_';
        $separatedWord = preg_replace($crazyRegex, $separator, $lastWord);

        return strtoupper($separatedWord);

    } //end convertPossiblePathedClassToUpperString()

} //end class

/**
 * turns a boolean into a string
 *
 * we do this a LOT (in dump), so, make succinct
 */
function bToStr(?bool $bool): string {

    // obviously we could one line this, but why complexity unnecessarily? This is fine
    if ($bool) {
        return 'T';
    }

    return 'F';

} //end bToStr()

/**
 * turns a Carbon date into a string
 *
 * we do this a LOT (in dump), so, make succinct
 *
 * dumb to have to use carbon dates, but they're all pulled straight off the Models, so, we don't have a lot of choice
 */
function dFmt(?Carbon $date): string {

    if (is_null($date)) {
        return 'null';
    }

    return $date->format('Y-m-d');

} //end dFmt()

/**
 * turns a Carbon date into a 'Y'-m-d string, with 'Y' instead of the year. Ie, a date-month string
 *
 * dumb to have to use carbon dates, but they're all pulled straight off the Models, so, we don't have a lot of choice
 *
 * mostly we don't care about the year, so this saves 3 chars on an often squashed horizontal line
 * the 'Y' is left in so it's VERY clear we're talking Y-m-d, not d-m (so eg Y-02-01 is clearly 1st Feb, not Jan 2nd)
 */
function dmFmt(?Carbon $date): string {

    if (is_null($date)) {
        return 'null';
    }

    return $date->format('\Y-m-d');

} //end dmFmt()

/**
 * turns a float into a string. '0' if 0, otherwise 4dp
 */
function floatFmt(?float $float): string {

    if ($float) {
        return number_format($float, 4);
    }

    return '0';

} //end floatFmt()
