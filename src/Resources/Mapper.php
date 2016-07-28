<?php namespace Foothing\RepositoryController\Resources;

use Foothing\Repository\Eloquent\EloquentRepository;
use Foothing\RepositoryController\Resources\Exceptions\CannotMapResourceException;

class Mapper {

	public static function map($entity) {
        // @TODO refactor to return instance?

		$config = config("resources.resources." . $entity);

        if (! $config) {
            throw new CannotMapResourceException("$entity is not mapped.");
        }

        return $config;
	}

    public static function mapRepository($resourceName, $instance = null) {
        $repository = config("resources.repositories." . $resourceName);

        if (class_exists($repository)) {
            return \App::make($repository);
        }

        if (! $instance) {
            throw new \Exception("Instance is required.");
        }

        return new EloquentRepository($instance);
    }
}
