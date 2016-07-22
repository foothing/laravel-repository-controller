<?php namespace Foothing\RepositoryController\Resources;

use Foothing\RepositoryController\Resources\Exceptions\CannotMapResourceException;

class Mapper {

	public static function map($entity) {
		$config = config("repository-controller.resources." . $entity);

        if (! $config) {
            throw new CannotMapResourceException("$entity is not mapped.");
        }

        return $config;
	}
}
