<?php namespace Tests\Foothing\RepositoryController\Controllers;

class ResourceControllerTest extends \Tests\Foothing\RepositoryController\BaseRoutingTest {
    protected $writer, $loader, $mapper;

    public function setUp() {
        parent::setUp();
        $this->writer = \Mockery::mock('Foothing\RepositoryController\Resources\WriterInterface');
        $this->loader = \Mockery::mock('Foothing\RepositoryController\Resources\LoaderInterface');
        $this->mapper = \Mockery::mock('Foothing\RepositoryController\Resources\Mapper');

        $this->app->instance('Foothing\RepositoryController\Resources\WriterInterface', $this->writer);
        $this->app->instance('Foothing\RepositoryController\Resources\LoaderInterface', $this->loader);
        $this->app->instance('Foothing\RepositoryController\Resources\Mapper', $this->mapper);
    }

    public function testGetIndex_returning_resources() {
        $this->mapper->shouldReceive('map')->with('foo')->once()->andReturn("namespace\foo");

        $this->loader
            ->shouldReceive('query')->once()
            ->shouldReceive('loadEntities')->once()->andReturn([]);

        $response = $this->call('GET', 'resources/foo');
        $this->assertResponseStatus(200);
        $this->assertContains("[]", $response->getContent());
    }

    public function testGetIndex_return_single_resource() {
        $this->mapper->shouldReceive('map')->with('foo')->once()->andReturn("namespace\foo");

        $this->loader->shouldReceive('loadEntity')->once()->with("namespace\foo", 1, null)->andReturn([]);

        $response = $this->call('GET', 'resources/foo/1');
        $this->assertResponseStatus(200);
        $this->assertContains("[]", $response->getContent());
    }

    public function testGetIndex_return_resource_relations() {
        $foo = (object)[ "bar" => 'baz'  ];
        $this->mapper->shouldReceive('map')->with('foo')->once()->andReturn("namespace\foo");

        $this->loader->shouldReceive('loadEntity')->once()->with("namespace\foo", 1, null)->andReturn($foo);

        $response = $this->call('GET', 'resources/foo/1/bar');
        $this->assertResponseStatus(200);
        $this->assertContains("baz", $response->getContent());
    }

    public function testPutIndex() {
        $payload = ['foo' => 'bar'];
        $this->mapper->shouldReceive('map')->with('foo')->once()->andReturn("namespace\foo");
        $this->writer->shouldReceive('update')->with("namespace\foo", $payload, 1)->andReturn($payload);
        $response = $this->call('PUT', 'resources/foo/1', $payload);
        $this->assertContains(json_encode($payload), $response->getContent());
    }

    public function testPutBulk() {
        $payload = ['foo' => 'bar'];
        $this->mapper->shouldReceive('map')->with('foo')->once()->andReturn("namespace\foo");
        $this->writer->shouldReceive('bulkUpdate')->with("namespace\foo", $payload)->andReturn($payload);
        $response = $this->call('PUT', 'resources/bulk/foo', $payload);
        $this->assertContains(json_encode($payload), $response->getContent());
    }

    public function testPostIndex() {
        $payload = ['foo' => 'bar'];
        $this->mapper->shouldReceive('map')->with('foo')->once()->andReturn("namespace\foo");
        $this->writer->shouldReceive('create')->with("namespace\foo", $payload)->andReturn($payload);
        $response = $this->call('POST', 'resources/foo', $payload);
        $this->assertContains(json_encode($payload), $response->getContent());
    }

    public function testPostBulk() {
        $payload = ['foo' => 'bar'];
        $this->mapper->shouldReceive('map')->with('foo')->once()->andReturn("namespace\foo");
        $this->writer->shouldReceive('bulkCreate')->with("namespace\foo", $payload)->andReturn($payload);
        $response = $this->call('POST', 'resources/bulk/foo', $payload);
        $this->assertContains(json_encode($payload), $response->getContent());
    }

    public function testDeleteIndex() {
        $this->mapper->shouldReceive('map')->with('foo')->once()->andReturn("namespace\foo");
        $this->writer->shouldReceive('delete')->with("namespace\foo", 1);
        $this->call('DELETE', 'resources/foo/1');
    }

    public function tearDown() {
        \Mockery::close();
    }
}