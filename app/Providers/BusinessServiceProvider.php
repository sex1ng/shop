<?php

namespace App\Providers;

use App\Services\Business\LogService;
use App\Services\Business\RealNameService;
use App\Services\Business\ResponseService;
use App\Services\Business\TaskService;
use App\Services\Business\UserBalanceService;
use App\Services\Business\UserCardInfoService;
use App\Services\Business\UserInfoService;
use App\Services\Business\WithdrawService;
use Illuminate\Support\ServiceProvider;

class BusinessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // 单例  只会实例一个对象
        $this->app->singleton(
            LogService::class,
            LogService::class
        );

        $this->app->singleton(
            ResponseService::class,
            ResponseService::class
        );

        $this->app->singleton(
            UserBalanceService::class,
            UserBalanceService::class
        );

        $this->app->singleton(
            RealNameService::class,
            RealNameService::class
        );

        $this->app->singleton(
            WithdrawService::class,
            WithdrawService::class
        );

        $this->app->singleton(
            UserInfoService::class,
            UserInfoService::class
        );

        $this->app->singleton(
            TaskService::class,
            TaskService::class
        );
        //集卡换手机
        $this->app->singleton(
            UserCardInfoService::class,
            UserCardInfoService::class
        );
        // 绑定  多次引用会实例化多个对象
//        $this->app->bind(
//            LogService::class,
//            LogService::class
//        );
    }
}
