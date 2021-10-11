<?php

namespace App\Providers;

use App\Helpers\RedisUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);
        // Log::useDailyFiles(storage_path() . '/logs/laravel-' . get_current_user() . '.log');

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            if (!in_array(RedisUser::get('role'), ['client', 'user'])){
                $event->menu->addBefore('documents', [
                    'key' => 'clients',
                    'text' => 'listClients',
                    'route'  => 'client::list',
                    'icon' => 'fa fa-users',
                ]);
            } else {
                $event->menu->addBefore('documents', [
                    'key' => 'clients',
                    'text' => 'anagClient',
                    'route'  => 'client::list',
                    'icon' => 'fa fa-user',
                ]);
            }
            // Rendo Le Stat ABC visibili a tutti
            $event->menu->addAfter('products', [
                'key' => 'stats_header',
                'header' => 'stats_header',
                'classes'  => 'text-bold text-center',
            ]);
            $event->menu->addAfter('stats_header', [
                'key' => 'AbcArt',
                'text' => 'AbcArt',
                'route'  => 'abcProds::list',
                'icon' => 'fa fa-sort-alpha-down',
            ]);
        });
    }
}
