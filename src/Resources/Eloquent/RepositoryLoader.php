<?php namespace Foothing\RepositoryController\Resources\Eloquent;

use Foothing\Repository\Eloquent\EloquentCriteria;
use Foothing\Repository\Eloquent\EloquentRepository;
use Foothing\RepositoryController\Resources\LoaderInterface;
use Foothing\RepositoryController\Resources\Mapper;
use Foothing\Request\AbstractRemoteQuery;

class RepositoryLoader implements LoaderInterface {
	protected $criteria;

	function loadEntity($resource, $id, $relations = array()) {
        $instance = new $resource();

		$repository = Mapper::mapRepository($resource, $instance);

        if ($relations) {
            $repository->with($relations);
            return $repository->find($id);
        }

        else {
            return $repository->find($id);
        }
	}

	function loadEntities($resource, $page, $ipp, $relations = array()) {
        $instance = new $resource();

        $repository = Mapper::mapRepository($resource, $instance);

        if ($this->criteria) {
            $repository->criteria($this->criteria);
        }

        if ($relations) {
            $repository->with($relations);
            return $repository->paginate($ipp, $page);
        }

        else {
            return $repository->paginate($ipp, $page);
        }
	}

	function query(AbstractRemoteQuery $query) {
		$this->criteria = (new EloquentCriteria())->make($query);
		return $this;
	}
}
