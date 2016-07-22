<?php namespace Tests\Foothing\RepositoryController\Resources;

use Foothing\RepositoryController\Resources\Mapper;

class MapperTest extends \PHPUnit_Framework_TestCase {

    public function testMap() {
        $this->setExpectedException('Foothing\RepositoryController\Resources\Exceptions\CannotMapResourceException');
        Mapper::map('foo');
    }

}