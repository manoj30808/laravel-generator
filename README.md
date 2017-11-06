# Formbuilder for Laravel5.4

    Step 1 : php artisan make:auth (If you not already make login)
    Step 2 : add below details in your composer.json firl
    			"require": {
			        "laracasts/generators": "dev-master as 1.1.4",
			        "pack/dds-generate": "^1.5"
			    }
    Step 3 : composer require 
    Step 4 : Add service provider in config/app.php 
            	Pack\DDSGenerate\DDSGenerateServiceProvider::class,
    Step 5 : php artisan migrate

Once you installed please visit : http://<DOMAIN>/admin/generate
