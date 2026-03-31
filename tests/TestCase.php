<?php

namespace Tests;

use App\Helpers\Debug;
use DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Mockery\MockInterface;
use ReflectionClass;
use ReflectionMethod;
use ReflectionObject;

/**
 * don't care how many children this class has
 *
 * @SuppressWarnings("NumberOfChildren")
 */
abstract class TestCase extends BaseTestCase {

    use CreatesApplication;
    // for some reason, around phpunit 11/;laravel 12, using RefreshDatabase got a LOT slower (they stopped caching?)
    // alas, our tests fail if we use DatabaseTransactions (which is _much_ faster).
    // The whole thing is utterly inscrutable.
    use RefreshDatabase;

    protected const CHANNEL_NAME = 'testing';

    /**
     * Capture the output from a method call (basically, just a wrapper around invokeMethod
     * Use exactly the same way, eg
     *
     * $class = new App\Class\Whatever();
     * $output = $this->captureMethodOutput($class, 'privateMethod', array('param1', 'param2'));
     * $this->assertStringContainsString("blah", $output, "output should include 'blah'");
     *
     * obviously, this doesn't return whatever invoke method does, ONLY the output (echo statements etc)
     *
     * return string[]
     *
     * @param mixed        $object
     * @param string       $methodName
     * @param array<mixed> $parameters
     */
    public function captureMethodOutput(mixed &$object, string $methodName, array $parameters=[]): string {

        ob_start();
        $this->invokeMethod($object, $methodName, $parameters);

        return '' . ob_get_clean();

    } //end captureMethodOutput()

    /**
     * A helper function for unit tests. Pass in table_name + expected Columns, this will check:
     *
     *  1. are all expected columns present in the table
     *  2. is our 'expected' list missing any columns? (ie, are our unit tests up to date)
     *
     * note: can't call this function test* or it'll get auto-called everytime we run any tests. Oops
     *
     * @param string   $tableName
     * @param string[] $expectedColumns
     */
    public function checkTableAndColumns(string $tableName, array $expectedColumns): void {

        // check table exists
        $this->assertTrue(
            Schema::hasTable($tableName),
        );

        // check all expected columns are present
        $this->assertTrue(
            Schema::hasColumns($tableName, $expectedColumns), $this->dumpTableDefinition($tableName),
        );

        // Check no unexpected columns exist
        $actualColumns     = Schema::getColumnListing($tableName);
        $unexpectedColumns = array_diff($actualColumns, $expectedColumns);

        // $this->assertEmpty(
        //     $unexpectedColumns,
        //     'Table has unexpected columns: ' . implode(', ', $unexpectedColumns),
        // );
        if ($unexpectedColumns) {
            $this->fail(
                'Table has unexpected (ie, untested) columns: ' . implode(', ', $unexpectedColumns),
            );
        }

    } //end checkTableAndColumns()

    /**
     * Create a mock cache repository
     *
     * @return \Mockery\MockInterface&\Illuminate\Contracts\Cache\Repository
     */
    public function createMockCache(): mixed {

        return $this->mock('Illuminate\Contracts\Cache\Repository');

    } //end createMockCache()

    /**
     * Create a mock Guzzle client
     *
     * @return \Mockery\MockInterface&\GuzzleHttp\Client
     */
    public function createMockGuzzleClient(): mixed {

        return Mockery::mock('GuzzleHttp\Client');

    } //end createMockGuzzleClient()

    /**
     * Create a mock Guzzle response with JSON body
     *
     * @param array<string, mixed> $data
     * @return \Mockery\MockInterface&\Psr\Http\Message\ResponseInterface
     */
    public function createMockGuzzleResponse(array $data): mixed {

        $mockBody = Mockery::mock('Psr\Http\Message\StreamInterface');
        $mockBody->shouldReceive('__toString')->andReturn(json_encode($data));

        $mockResponse = Mockery::mock('Psr\Http\Message\ResponseInterface');
        $mockResponse->shouldReceive('getBody')->andReturn($mockBody);

        return $mockResponse;

    } //end createMockGuzzleResponse()

    /**
     * Create a mock Guzzle response with both body and header
     *
     * @param array<string, mixed>      $bodyData
     * @param string                    $headerName
     * @param string|array<int, string> $headerValue
     * @return \Mockery\MockInterface&\Psr\Http\Message\ResponseInterface
     */
    public function createMockGuzzleResponseWithBodyAndHeader(array $bodyData, string $headerName,
        string|array $headerValue): mixed {

        $mockBody = Mockery::mock('Psr\Http\Message\StreamInterface');
        $mockBody->shouldReceive('__toString')->andReturn(json_encode($bodyData));

        $mockResponse = Mockery::mock('Psr\Http\Message\ResponseInterface');
        $mockResponse->shouldReceive('getBody')->andReturn($mockBody);

        $normalizedValue = is_array($headerValue) ? $headerValue : [$headerValue];
        $mockResponse->shouldReceive('getHeader')->with($headerName)->andReturn($normalizedValue);

        return $mockResponse;

    } //end createMockGuzzleResponseWithBodyAndHeader()

    /**
     * Create a mock Guzzle response with a specific header
     *
     * @param string                    $headerName
     * @param string|array<int, string> $headerValue
     * @return \Mockery\MockInterface&\Psr\Http\Message\ResponseInterface
     */
    public function createMockGuzzleResponseWithHeader(string $headerName, string|array $headerValue): mixed {

        $mockResponse    = Mockery::mock('Psr\Http\Message\ResponseInterface');
        $normalizedValue = is_array($headerValue) ? $headerValue : [$headerValue];
        $mockResponse->shouldReceive('getHeader')->with($headerName)->andReturn($normalizedValue);

        return $mockResponse;

    } //end createMockGuzzleResponseWithHeader()

    /**
     * turn the object into a succinct description, with all the bits we need for a full debug
     *
     * Debatably, this could/should be called dumpObject, to be consistent with dumpTable, below, BUT, since it'll
     * be used so commonly, it (debatably) makes more sense to keep it consistent with Debug::dump, of which it
     * is a variant (of sorts)
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
     * @SuppressWarnings("ExcessiveMethodLength")
     */
    public function dump(mixed $object, int $indent=0): string {

        // allow us to fire arrays in here, and get a sensible (ish) result
        if (is_iterable($object)) {
            $bits = [];
            foreach ($object as $singleObject) {
                $bits[] = Debug::dumpOcto($singleObject, $indent);
            }

            return implode("\n", $bits);
        }

        // otherwise, simple case
        return Debug::dumpOcto($object, $indent);

    } //end dump()

    /**
     * dump out full table information (so we can track if REALLY weird things are happening to the db, mid test)
     * fortunately, this is typically only a table with maybe a row or two (coz in memory tests wipe everything)
     */
    public function dumpTable(string $tableName): string {

        $upperName = strtoupper($tableName);
        $items     = DB::table($tableName)->get();

        $lines = [];

        $lines[] = "ONLY {$upperName}(S) AVAILABLE:";
        foreach ($items as $item) {
            $lines[] = Debug::dump($item);
        }

        return implode("\n", $lines);

    } //end dumpTable()

    /**
     * dump out the table definition (we had issues with sqlite not creating columns. This allowed triaging)
     * leaving it here coz it might be useful in the future
     *
     * return string[]
     */
    public function dumpTableDefinition(string $tableName): string {

        // turns out '.tables' doesn't work so well from here
        $sql = "SELECT sql FROM sqlite_schema WHERE name='{$tableName}';";

        $result = DB::select($sql);
        // tidy up the output a little (this is NOT perfect, but it's good enough for our purposes)
        // put whatever is after the first bracket on a new line
        // replace commas with a comma+newline (will screw up decimals, but whatever)
        // remove final ) and put a newline before it
        return str_replace(' (', " (\n  ", str_replace(', ', ", \n  ", substr($result[0]->sql, 0, -1)))."\n)"."\n";

    } //end dumpTableDefinition()

    /**
     * Allows us to test private methods, thusly:
     *
     * $object = new App\Class\Whatever();
     * $foo = $this->invokeMethod($object, 'privateMethod', array('param1', 'param2'));
     * $this->assertEquals(42, $foo);
     *
     * @param mixed        $object
     * @param string       $methodName
     * @param array<mixed> $parameters
     */
    public function invokeMethod(mixed &$object, string $methodName, array $parameters=[]): mixed {

        $reflection = new ReflectionClass($object::class);
        $method     = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);

    } //end invokeMethod()

    /**
     * Allows us to test private static methods, thusly:
     *
     * $object = new App\Class\Whatever();
     * $foo = $this->invokeMethod($object::class, 'privateStaticMethod', array('param1', 'param2'));
     * $this->assertEquals(42, $foo);
     *
     * @param string       $className
     * @param string       $methodName
     * @param array<mixed> $parameters
     */
    public function invokeStaticMethod(string $className, string $methodName, array $parameters=[]): mixed {

        $reflectionMethod = new ReflectionMethod($className, $methodName);

        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs(null, $parameters);

    } //end invokeStaticMethod()

    /**
     * Setup a Guzzle client mock to expect a method call
     *
     * @param mixed                $client       Mockery mock client
     * @param string               $method       HTTP method (get, post, patch, delete, etc)
     * @param string               $endpoint     API endpoint
     * @param array<string, mixed> $responseData Data to return in response body
     * @param int                  $count        Number of times method should be called
     */
    public function mockGuzzleMethod(mixed $client, string $method, string $endpoint, array $responseData,
        int $count=1): void {

        $mockResponse = $this->createMockGuzzleResponse($responseData);
        $client->shouldReceive($method)
            ->with($endpoint, Mockery::any())
            ->times($count)
            ->andReturn($mockResponse);

    } //end mockGuzzleMethod()

    /**
     * Remove properties defined during the test
     * hopefully, radically drop the amount of memory used (stop everything exploding)
     */
    protected function tearDown(): void {

        // so we don't miss any of the other critical things
        parent::tearDown();

        $refl = new ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if (! $prop->isStatic() && str_starts_with($prop->getDeclaringClass()->getName(), 'Tests\\')) {
                // stupid, but do everything we can to reclaim memory. SOMETHING is causing big problems
                // echo "  unsetting {$prop->getName()}\n";
                $prop->setAccessible(true);

                // only set it to null if this variable allows it (typehints, etc etc)
                // note, getName() is only available on NamedType, but ReflectionType also covers Union+Intersection
                if ($prop->getType()?->getName()[0] === '?') {
                    $prop->setValue($this, null);
                }
            }
        }

        gc_collect_cycles();

        // keep this line. it shows how much memory is in use at the end of each test. VERY helpful
        // echo floor(memory_get_usage() / 1024 / 1024).'MB';

    } //end tearDown()

} //end class
