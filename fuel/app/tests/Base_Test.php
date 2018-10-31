<?php

use AspectMock\Test as Aspect;

abstract class Base_Test extends TestCase
{
    protected $db_transaction = false;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        if ($this->db_transaction) {
            DB::start_transaction();
        }
    }

    protected function tearDown()
    {
        Aspect::clean();
        if ($this->db_transaction) {
            DB::rollback_transaction();
        }
    }

    /**
     * Get private/protected property value
     * $this->assertEquals('views/home', $this->getObjectProperty($view, 'file_name'));
     */
    public function getObjectProperty($object, $propertyName) {
        $reflector = new \ReflectionClass($object);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * Call protected/private method of a class.
     * $this->invokeObjectMethod($view, 'getData');
     */
    public function invokeObjectMethod($object, $methodName, $parameters = [])
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
