<?php

namespace Phpactor\WorseReflection\Tests\Benchmarks;

use Phpactor\WorseReflection\Reflector;

/**
 * @OutputTimeUnit("milliseconds")
 * @Iterations(1)
 * @Revs(1)
 */
class ReflectionStubsBench extends BaseBenchCase
{
    /**
     * @var Reflector
     */
    private $reflector;

    public function setUp()
    {
        parent::setUp();
        $this->reflector = $this->getReflector();
    }

    /**
     * @Subject()
     */
    public function test_classes_and_methods()
    {
        $classes = $this->reflector->reflectClassesIn(file_get_contents(__DIR__ . '/../../vendor/jetbrains/phpstorm-stubs/Reflection/Reflection.php'));

        foreach ($classes as $class) {
            foreach ($class->methods() as $method) {
            }
        }
    }
}
