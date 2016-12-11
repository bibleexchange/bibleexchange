<?php namespace BibleExperience\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

  public function register(){

    $this->app->bind(
      'BibleExperience\Repository\User\UserRepository',
      'BibleExperience\Repository\User\EloquentUserRepository'
    );
    $this->app->bind(
      'BibleExperience\Repository\Statement\EloquentRepository',
      'BibleExperience\Repository\Statement\EloquentRepository'
    );
    $this->app->bind(
      'BibleExperience\Repository\Lrs\Repository',
      'BibleExperience\Repository\Lrs\EloquentRepository'
    );
	$this->app->bind(
      'BibleExperience\Repository\Client\Repository',
      'BibleExperience\Repository\Client\EloquentRepository'
    );
    $this->app->bind(
      'BibleExperience\Repository\Site\SiteRepository',
      'BibleExperience\Repository\Site\EloquentSiteRepository'
    );
    $this->app->bind(
      'BibleExperience\Repository\Query\QueryRepository',
      'BibleExperience\Repository\Query\EloquentQueryRepository'
    );
    $this->app->bind(
      'BibleExperience\Repository\Document\DocumentRepository',
      'BibleExperience\Repository\Document\EloquentDocumentRepository'
    );
    $this->app->bind(
      'BibleExperience\Repository\OAuthApp\OAuthAppRepository',
      'BibleExperience\Repository\OAuthApp\EloquentOAuthAppRepository'
    );
    $this->app->bind(
      'BibleExperience\Repository\Report\Repository',
      'BibleExperience\Repository\Report\EloquentRepository'
    );
    $this->app->bind(
      'BibleExperience\Repository\Export\Repository',
      'BibleExperience\Repository\Export\EloquentRepository'
    );
  }

  public function map()
	{
		
	}
  
}