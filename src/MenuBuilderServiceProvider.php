<?php

namespace Tarique\MenuBuilder;

use Filament\Facades\Filament;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Illuminate\Support\Facades\Route;
use Tarique\MenuBuilder\Http\Controllers\MenuItemController;

class MenuManagementServiceProvider extends PackageServiceProvider
{
    public static string $name = 'menu-builder';

    protected array $resources = [
        Resources\MenuItemResource::class,
    ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)
                ->hasMigration('create_menu_items_table')
                ->hasRoute('web');
    }

    public function boot()
    {
        parent::boot();

        // if ($this->app->runningInConsole()) {
        //     $this->publishes([
        //         __DIR__.'/../public/js' => public_path('tarique/menu-builder/js'),
        //     ], 'menu-builder-assets');
        // }

        $$this->publishes([
            __DIR__.'/../public/js' => public_path('vendor/menu-builder/js'),
        ], 'menu-builder-assets');

        Filament::registerScripts([
            asset('vendor/menu-builder/js/menu-builder.js'),
        ], true);

        Route::middleware('web')
            ->prefix('admin')
            ->group(function () {
                Route::post('/menu-items/reorder', [MenuItemController::class, 'reorder'])->name('menu-items.reorder');
            });
    }
}
