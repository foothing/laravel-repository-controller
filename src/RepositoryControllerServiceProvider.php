<?php namespace Foothing\RepositoryController;

use Illuminate\Support\ServiceProvider;

class RepositoryControllerServiceProvider extends ServiceProvider {

	public function register() {
		$this->app->bind('Foothing\RepositoryController\Resources\LoaderInterface', \Config::get('repository-controller.resourceLoader'));
		$this->app->bind('Foothing\RepositoryController\Resources\WriterInterface', \Config::get('repository-controller.resourceWriter'));
	}

	public function boot() {
		$this->publishes( [ __DIR__ . "config/repository-controller.php" => config_path('repository-controller.php') ], 'config' );
	}
}
