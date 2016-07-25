<?php namespace Foothing\RepositoryController\Resources;

use Foothing\RepositoryController\Resources\Exceptions\CannotMapResourceException;

class Mapper {

	public static function map($entity) {
        // @TODO refactor to return instance?

		$config = config("repository-controller.resources." . $entity);

        if (! $config) {
            throw new CannotMapResourceException("$entity is not mapped.");
        }

        return $config;
	}
}
