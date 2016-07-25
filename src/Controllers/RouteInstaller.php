<?php namespace Foothing\RepositoryController\Controllers;

class RouteInstaller {

    /**
     * Install route patterns.
     *
     * @param null $baseUri
     */
    public static function install($baseUri = null) {
		$baseUri = $baseUri ? "$baseUri/" : "";
        \Route::post($baseUri . "resources/bulk/{resource}", "Foothing\RepositoryController\Controllers\ResourceController@postBulk");
        \Route::put($baseUri . "resources/bulk/{resource}", "Foothing\RepositoryController\Controllers\ResourceController@putBulk");
        \Route::put($baseUri . "resources/{resource}/{id?}/link/{relation}/{related}/{relatedId}", "Foothing\RepositoryController\Controllers\ResourceController@putLink");
        \Route::delete($baseUri . "resources/{resource}/{id?}/link/{relation}/{related}/{relatedId}", "Foothing\RepositoryController\Controllers\ResourceController@deleteLink");
        \Route::get($baseUri . "resources/{resource}/{id?}/{args?}", "Foothing\RepositoryController\Controllers\ResourceController@getIndex")->where('args', '[a-zA-Z0-9/_]*');
		\Route::put($baseUri . "resources/{resource}/{id}", "Foothing\RepositoryController\Controllers\ResourceController@putIndex");
		\Route::delete($baseUri . "resources/{resource}/{id}", "Foothing\RepositoryController\Controllers\ResourceController@deleteIndex");
		\Route::post($baseUri . "resources/{resource}", "Foothing\RepositoryController\Controllers\ResourceController@postIndex");
	}
}
