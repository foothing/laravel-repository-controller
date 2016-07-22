<?php namespace Foothing\RepositoryController\Resources;

interface WriterInterface {

    /**
     * Update an existing entity.
     *
     * @param string $resource
     * The resource identifier, as in configuration file.
     *
     * @param array $entity
     * The entity data we want to update.
     *
     * @param int $id
     * The entity id.
     *
     * @return mixed
     */
    public function update($resource, $entity, $id);

    /**
     * Create a new entity.
     *
     * @param string $resource
     * The resource identifier, as in configuration file.
     *
     * @param array $entity
     * The entity data we want to create.
     *
     * @return mixed
     */
    public function create($resource, $entity);

    /**
     * Delete an existing entity.
     *
     * @param string $resource
     * The resource identifier, as in configuration file.
     *
     * @param int $id
     * The entity id.
     *
     * @return mixed
     */
    public function delete($resource, $id);
}
