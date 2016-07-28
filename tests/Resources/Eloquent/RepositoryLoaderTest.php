<?php namespace Tests\Foothing\RepositoryController\Resources\Eloquent;

use Foothing\RepositoryController\Resources\Eloquent\RepositoryLoader;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class RepositoryLoaderTest extends \Orchestra\Testbench\TestCase {

    protected $repository;

    /**
     * @var Foothing\RepositoryController\Resources\Eloquent\RepositoryLoader
     */
    protected $loader;

    public function setUp() {
        parent::setUp();
        $this->repository = \Mockery::mock('overload:Foothing\Repository\Eloquent\EloquentRepository');
        $this->loader = new RepositoryLoader();
    }

    public function testLoadEntity_without_relations() {
        $this->repository->shouldReceive('find')->once();
        $this->loader->loadEntity('stdClass', 1);
    }

    public function testLoadEntity_with_relations() {
        $this->repository
            ->shouldReceive('with')->with('children')->once()
            ->shouldReceive('find')->with(1)->once();

        $this->loader->loadEntity('stdClass', 1, 'children');
    }

    public function testLoadEntities_without_relations() {
        $this->repository->shouldReceive('paginate')->once()->with(15, 1);
        $this->loader->loadEntities('stdClass', 1, 15);
    }

    public function testLoadEntities_with_relations() {
        $relations = ['foo', 'bar'];
        $this->repository
            ->shouldReceive('with')->once()->with($relations)
            ->shouldReceive('paginate')->once()->with(15, 1);

        $this->loader->loadEntities('stdClass', 1, 15, $relations);
    }

    public function tearDown() {
        \Mockery::close();
    }

}