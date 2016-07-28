<?php namespace Tests\Foothing\RepositoryController\Resources;

use Foothing\Repository\Eloquent\EloquentRepository;
use Foothing\RepositoryController\Resources\Mapper;
use Illuminate\Database\Eloquent\Model;

class MapperTest extends \Orchestra\Testbench\TestCase {

    protected function getEnvironmentSetUp($app) {
        $app['config']->set('resources.repositories', [
            'person' => 'Tests\Foothing\RepositoryController\Resources\PersonRepository',
            'worker' => null,
        ]);
    }

    protected function getPackageProvider($app) {
        return ['Foothing\RepositoryController\RepositoryControllerServiceProvider'];
    }

    public function testMap() {
        $this->setExpectedException('Foothing\RepositoryController\Resources\Exceptions\CannotMapResourceException');
        Mapper::map('foo');
    }

    public function testMapRepositoryDefault() {
        $repository = Mapper::mapRepository('worker', new Person());
        $this->assertEquals('Foothing\Repository\Eloquent\EloquentRepository', get_class($repository));

        $this->setExpectedException('Exception');
        Mapper::mapRepository('worker');
    }

    public function testMapRepositoryFromConfig() {
        \App::shouldReceive('make')->andReturn(new PersonRepository(new Person()));
        $repository = Mapper::mapRepository('person');
        $this->assertEquals('Tests\Foothing\RepositoryController\Resources\PersonRepository', get_class($repository));
    }
}

class PersonRepository extends EloquentRepository {

    public function __construct(Person $person) {

    }

}

class Person extends Model {

}
