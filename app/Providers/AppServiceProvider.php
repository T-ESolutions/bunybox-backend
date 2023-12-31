<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Artisan::call('migrate');
        date_default_timezone_set('Asia/Riyadh');
        $languages = ['ar', 'en'];
        $lang = request()->header('lang');

        if ($lang) {
            if (in_array($lang, $languages)) {
                App::setLocale($lang);
            } else {
                App::setLocale('ar');
            }
        }

        if (!session()->has('lang')) {
            session()->put('lang', 'en');
        }
        if (Schema::hasTable('settings')) {
            View::share('settings', Setting::get());
        }


        if (Schema::hasTable('settings')) {
            $globalSetting = Cache::get('settings');
            if (!$globalSetting) {
                $this->app->singleton('settings', function ($app) {
                    return Cache::rememberForever('settings', function () {
                        return Setting::pluck('value', 'key');
                    });
                });
                $globalSetting = $this->app->make('settings');
            }

            View::composer('*', function ($view) use ($globalSetting) {
                $view->with('globalSetting', $globalSetting);
            });

            //cron job for delete unpaid orders after 6 hours ...
            $after_six_hours = Carbon::now()->subHours(6);
            $expired_orders = Order::where('payment_status', 'unpaid')->where('created_at', '<', $after_six_hours)->get();
            if (count($expired_orders) > 0) {
                foreach ($expired_orders as $order) {
                    $order->delete();
                }
            }
        }


    }
}
