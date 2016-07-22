<?php namespace Tests\Foothing\RepositoryController;

use Foothing\RepositoryController\Controllers\RouteInstaller;

class BaseRoutingTest extends \Orchestra\Testbench\TestCase {

    public function setUp() {
        parent::setUp();
        RouteInstaller::install();
    }

    protected function getEnvironmentSetUp($app) {
        //$app['config']->set('laravel-services.resourceLoader', 'Foothing\RepositoryController\Resources\Eloquent\RepositoryLoader');
    }

    protected function getPackageProvider($app) {
        return['Foothing\RepositoryController\RepositoryControllerServiceProvider'];
    }

    public function testVoid(){}
}
