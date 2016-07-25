<?php
return array(

    // The loader used within the resource controller.
    'resourceLoader' => 'Foothing\RepositoryController\Resources\Eloquent\RepositoryLoader',
    'resourceWriter' => 'Foothing\RepositoryController\Resources\Eloquent\RepositoryWriter',

    'resources' => array(

        // Resources must be in the form 'resourceName' => 'resourceImplementation'
        // The implementation should be a fully qualified namespace to the model.

        // Example:
        //'person' => 'Qualified/Namespace',
    ),
);
