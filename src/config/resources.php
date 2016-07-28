<?php
return [

    // The loader used within the resource controller.
    'resourceLoader' => 'Foothing\RepositoryController\Resources\Eloquent\RepositoryLoader',
    'resourceWriter' => 'Foothing\RepositoryController\Resources\Eloquent\RepositoryWriter',

    // Resources must be in the form 'resourceName' => 'resourceImplementation'
    // The implementation should be a fully qualified namespace to the model.
    'resources' => [
        // Example:
        //'person' => 'Qualified/Namespace',
    ],

    // By default, the RepositoryLoader will use an EloquentRepository
    // instance to fetch results. You can override that right here and
    // set a specific Repository for each resource.
    // Note that your repository must extend EloquentRepository.
    'repositories' => [
        // 'person' => 'My\Custom\PersonRepository'
    ]
];
