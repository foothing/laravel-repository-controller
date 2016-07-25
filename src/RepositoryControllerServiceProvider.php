<?php namespace Foothing\RepositoryController;

use Illuminate\Support\ServiceProvider;

class RepositoryControllerServiceProvider extends ServiceProvider {

	public function register() {
		$this->app->bind('Foothing\RepositoryController\Resources\LoaderInterface', config('resources.resourceLoader'));
		$this->app->bind('Foothing\RepositoryController\Resources\WriterInterface', config('resources.resourceWriter'));
	}

	public function boot() {
		$this->publishes( [ __DIR__ . "config/resources.php" => config_path('resources.php') ], 'config' );
	}
}
