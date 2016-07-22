<?php
return array(

	'baseUri' => 'api/v1',

	// The loader used within the resource controller. Allowed values
	// are RepositoryLoader or ModelLoader.
	'resourceLoader' => 'Foothing\Services\Resources\Eloquent\RepositoryLoader',

	'resourceWriter' => 'Foothing\Services\Resources\Eloquent\RepositoryWriter',

	'resources' => array(

		// Resources must be in the form 'resourceName' => 'resourceImplementation'
		// The implementation should be a fully qualified namespace to the model.

        // Example:
		//'person' => 'Qualified/Namespace',
	),

);