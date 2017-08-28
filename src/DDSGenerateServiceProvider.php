<?php namespace MspPack\DDSGenerate;

use Illuminate\Support\ServiceProvider;

class DDSGenerateServiceProvider extends ServiceProvider {


	//protected $defer = false;

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishes([
            __DIR__.'/resources' => resource_path('views'),
        ]);
        $this->publishes([
            __DIR__.'/public' => public_path(),
        ]);
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
       /*
        $settings = \DB::table('settings')->get()->first();
        if (!empty($settings)) {
        	\Config::set(['services.twitter.client_id'=>$settings->twitter_client_id]);		
        	\Config::set(['services.twitter.client_secret'=>$settings->twitter_client_secret]);		
        	
        	\Config::set(['services.google.client_id'=>$settings->google_client_id]);		
        	\Config::set(['services.google.client_secret'=>$settings->google_client_secret]);		

        	\Config::set(['services.facebook.client_id'=>$settings->facebook_client_id]);		
        	\Config::set(['services.facebook.client_secret'=>$settings->facebook_client_secret]);		

        	\Config::set(['services.pinterest.client_id'=>$settings->pinterest_client_id]);		
        	\Config::set(['services.pinterest.client_secret'=>$settings->pinterest_client_secret]);

        	\Config::set(['services.linkedin.client_id'=>$settings->linkedin_client_id]);		
        	\Config::set(['services.linkedin.client_secret'=>$settings->linkedin_client_secret]);		
        	
        	\Config::set(['mail.driver'=>$settings->mail_driver]);
        	\Config::set(['mail.host'=>$settings->mail_host]);
        	\Config::set(['mail.port'=>$settings->mail_port]);
        	\Config::set(['mail.username'=>$settings->mail_username]);
        	\Config::set(['mail.password'=>$settings->mail_password]);
        	\Config::set(['mail.encryption'=>$settings->mail_encryption]);
        }
        \Config::set(['auth.providers.users.model'=>\MspPack\DDSGenerate\User::class]);
        \Config::set(['cache.default' => 'array' ]);
        \Config::set(['entrust.role' => 'MspPack\DDSGenerate\Role' ]);
        \Config::set(['entrust.permission' => 'MspPack\DDSGenerate\Permission' ]);


        \Validator::extend('alpha_space', function ($attribute, $value) {
            return preg_match('/^[\pL\s]+$/u', $value); 
        });
        \Schema::defaultStringLength(191);*/
	}
	public function register()
    {
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Form', 'Collective\Html\FormFacade');
        $loader->alias('Html', 'Collective\Html\HtmlFacade');
	}
}
