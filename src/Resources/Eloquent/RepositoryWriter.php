<?php namespace Foothing\RepositoryController\Resources\Eloquent;

use Foothing\Repository\Eloquent\EloquentRepository;
use Foothing\RepositoryController\Resources\WriterInterface;

class RepositoryWriter implements WriterInterface {

	function update($resource, $entity, $id) {
		$repository = (new EloquentRepository(new $resource()));
		$model = $repository->find($id);
		$model->forceFill($entity);
		return $repository->update($model);
	}

	function create($resource, $entity) {
		$model = new $resource();
		$model->forceFill($entity);
		$repository = new EloquentRepository($model);
		return $repository->create($model);
	}

	function delete($resource, $id) {
		$model = new $resource();
		$repository = new EloquentRepository($model);
		$entity = $repository->find($id);
		return $repository->delete($entity);
	}

    function bulkCreate($resource, $entities) {
        $result = [];
        foreach($entities as $entity) {
            $result[] = $this->create($resource, $entity);
        }
        return $result;
    }

    function bulkUpdate($resource, $entities) {
        $result = [];
        foreach($entities as $entity) {
            $result[] = $this->update($resource, $entity, $entity['id']);
        }
        return $result;
    }
}