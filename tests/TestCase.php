<?php

namespace GeneralSystemsVehicle\Acclaim\Tests;

use GeneralSystemsVehicle\Acclaim\AcclaimServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ReflectionClass;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test case.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /**
     * Tear down the test case.
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Configure the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.env', 'testing');
    }

    /**
     * Get the service providers for the package.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            AcclaimServiceProvider::class,
        ];
    }

    /**
     * Get the facades for the package.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //
        ];
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object
     * @param string $methodName
     * @param array  $parameters
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Set protected/private property on object.
     *
     * @param object &$object
     * @param string $propertyName
     * @param mixed $value
     *
     * @return $this
     */
    public function setProperty(&$object, $propertyName, $value)
    {
        $reflection = new ReflectionClass(get_class($object));

        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);

        return $this;
    }

    /**
     * Enable default exception handling.
     *
     * @return $this
     */
    protected function signIn($user = null, $driver = null)
    {
        $user = $user ?: create(config('auth.providers.users.model'));

        $this->actingAs($user, $driver);

        return $this;
    }
}
