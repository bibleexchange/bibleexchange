<?php

namespace BibleExperience\Providers;

use BibleExperience\GraphQL\Schema\GraphQL;
use BibleExperience\GraphQL\Commands\FieldMakeCommand;
use BibleExperience\GraphQL\Commands\MutationMakeCommand;
use BibleExperience\GraphQL\Commands\QueryMakeCommand;
use BibleExperience\GraphQL\Commands\SchemaCommand;
use BibleExperience\GraphQL\Commands\TypeMakeCommand;
use BibleExperience\GraphQL\Commands\CacheCommand;
use BibleExperience\GraphQL\Schema\Parser;
use BibleExperience\GraphQL\Schema\SchemaContainer;

use Illuminate\Support\ServiceProvider;

class RelayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerSchema();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('relay', function ($app) {
            return new GraphQL($app);
        });

    }

    /**
     * Register schema mutations and queries.
     *
     * @return void
     */
    protected function registerSchema()
    {
        //$this->initializeTypes();
    }

    /**
     * Initialize GraphQL types array.
     *
     * @return void
     */
    protected function initializeTypes()
    {
       foreach (config('graphql.types') as $name => $type) {
		  $this->app['relay']->addType($type, $name);            
	}

    }
}
