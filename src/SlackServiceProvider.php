<?php
/**
 * Created by PhpStorm.
 * User: Vuong
 * Date: 21-Feb-16
 * Time: 12:47 PM
 */

namespace Mnking\Slack;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class SlackServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Slack', function() {
            return new SlackBot;
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/slack.php' => config_path('slack.php')
        ], 'config');
    }
}