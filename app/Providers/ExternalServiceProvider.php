<?php


namespace App\Providers;


use App\Services\External\SnowFlake\SnowFlake;
use Illuminate\Support\ServiceProvider;

class ExternalServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }


    public function register()
    {
        $this->app->singleton(
            BaiduApiService::class, function () {
            return new BaiduApiService(config('baidu'));
        });

        /**
         * 头条小程序服务
         */
        $this->app->singleton(TouTiaoService::class, function () {
            return new TouTiaoService(config('toutiao-template'));
        });

        /**
         * 阿里身份证验证服务
         */
        $this->app->singleton(IDCardValidate::class, function () {
            return new IDCardValidate(config('id-card'));
        });

        /**
         * 雪花算法生成UID
         */
        $this->app->singleton(SnowFlake::class, function() {
            return new SnowFlake();
        });

    }
}