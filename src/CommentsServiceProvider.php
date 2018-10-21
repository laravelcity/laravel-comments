<?php

namespace Laravelcity\Comments;

use Illuminate\Support\ServiceProvider;
use Laravelcity\Comments\Lib\Repository;

class CommentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot ()
    {
        //lang
        $this->loadTranslationsFrom(__DIR__ . '/Lang/' , 'Comments');

        //migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        //bind
        $this->app->bind('CommentsClass' , function () {
            return new Repository();
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register ()
    {
        //configs
        $this->mergeConfigFrom(
            __DIR__ . '/Config/comments.php' , 'comments'
        );
        $this->publishes([
            __DIR__ . '/Config/comments.php' => config_path('comments.php') ,
        ] , 'comments');

        // publish lang
        $this->publishes([
            __DIR__ . '/Lang/' => resource_path('lang/vendor/comments') ,
        ]);
    }
}
