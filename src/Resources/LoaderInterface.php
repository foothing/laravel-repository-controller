<?php namespace Foothing\RepositoryController\Resources;

use Foothing\Request\AbstractRemoteQuery;

interface LoaderInterface {
	public function loadEntity($resource, $id, $relations = array());
    public function loadEntities($resource, $page, $ipp, $relations = array() );

    // @TODO integrate remote query in this package.
    public function query(AbstractRemoteQuery $query);
}
