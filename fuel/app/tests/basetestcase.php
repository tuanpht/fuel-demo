<?php

abstract class BaseTestCase extends TestCase
{
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
