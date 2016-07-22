<?php namespace Tests\Foothing\RepositoryController\Resources\Eloquent;

use Foothing\RepositoryController\Resources\Eloquent\RepositoryWriter;

class RepositoryWriterTest extends \PHPUnit_Framework_TestCase {
    protected $repository;

    protected $writer;

    public function setUp() {
        parent::setUp();
        $this->repository = \Mockery::mock('overload:Foothing\Repository\Eloquent\EloquentRepository');
        $this->writer = new RepositoryWriter();
    }

    public function testUpdate() {
        $mock = new MockModel();

        $this->repository
            ->shouldReceive('find')->once()->with(1)->andReturn($mock)
            ->shouldReceive('update')->once()->with($mock);

        $this->writer->update('stdClass', [], 1);
    }

    public function testCreate() {
        $this->repository->shouldReceive('create')->once();
        $this->writer->create('Tests\Foothing\RepositoryController\Resources\Eloquent\MockModel', []);
    }

    public function testDelete() {
        $mock = new MockModel();

        $this->repository
            ->shouldReceive('find')->once()->with(1)->andReturn($mock)
            ->shouldReceive('delete')->once()->with($mock);

        $this->writer->delete('stdClass', 1);
    }

    public function _testBulkCreate() {
        // @FIXME!
        $this->repository->shouldReceive('create')->twice();
        $this->writer->bulkCreate('Tests\Foothing\RepositoryController\Resources\Eloquent\MockModel', [new MockModel(), new MockModel()]);
    }

    public function _testBulkUpdate() {
        // @FIXME!
        $this->repository->shouldReceive('update')->twice();
        $this->writer->bulkUpdate('Tests\Foothing\RepositoryController\Resources\Eloquent\MockModel', [new MockModel(), new MockModel()]);
    }

    public function tearDown() {
        \Mockery::close();
    }

}

class MockModel {
    public function forceFill($args) {}
}
