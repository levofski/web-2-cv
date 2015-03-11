<?php namespace Web2CV\Providers;

use Illuminate\Support\ServiceProvider;
use Web2CV\Repositories\DataDocumentFileSystemRepository;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'Web2CV\Services\Registrar'
		);

        // @todo Contextual Binding
        $this->app->bind('Web2CV\Codecs\Codec', 'Web2CV\Codecs\JSONCodec');
        $this->app->bind('Web2CV\Repositories\DataDocumentRepository',
            function($app) {
                // @todo Configurable storage directory
                return new DataDocumentFileSystemRepository($app->make('Web2CV\Codecs\Codec'), storage_path());
            }
        );
	}

}
