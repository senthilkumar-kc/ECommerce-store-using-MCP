<?php


namespace SK\Demo;


use Illuminate\Support\ServiceProvider;
use SK\Demo\Services\DemoService;


class DemoServiceProvider extends ServiceProvider
{
public function register()
{
$this->mergeConfigFrom(__DIR__ . '/../config/demo.php', 'demo');


$this->app->singleton('demo', function () {
return new DemoService();
});
}


public function boot()
{
$this->loadRoutesFrom(__DIR__.'/../routes/web.php');
$this->publishes([
__DIR__.'/../config/demo.php' => config_path('demo.php'),
], 'demo-config');
}
}