<?php
namespace Curder\LaravelAliyunSms;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('aliyunsms.php'),
        ], 'config');
    }
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'aliyunsms');
        $this->app->bind(AliyunSms::class, function() {
            return new AliyunSms();
        });
    }
    protected function configPath()
    {
        return __DIR__ . '/config.php';
    }
}