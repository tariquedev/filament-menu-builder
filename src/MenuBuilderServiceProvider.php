<?php

namespace Tarique\MenuBuilder;

use Filament\Facades\Filament;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Illuminate\Support\Facades\Route;
use Tarique\MenuBuilder\Http\Controllers\MenuItemController;

class MenuBuilderServiceProvider extends PackageServiceProvider
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
        // $this->publishes([
        //     __DIR__.'/tarique/menu-builder/public' => public_path('vendor/menu-builder'),
        // ], 'menu-builder-assets');

        // // Filament::registerScripts([
        // //     asset('vendor/menu-builder/js/menu-builder.js'),
        // // ], true);
        // FilamentAsset::register([
        //     Js::make('tarique/menu-builder/public/js/menu-builder.js', __DIR__ . '/vendor/menu-builder/public/js/menu-builder.js'),
        // ]);
        FilamentAsset::register([
            Js::make('menu-builder', asset('vendor/menu-builder/js/menu-builder.js')),
        ]);

        // Publish the public assets
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/menu-builder'),
        ], 'menu-builder-assets');
        
        Route::middleware('web')
            ->prefix('admin')
            ->group(function () {
                Route::post('/menu-items/reorder', [MenuItemController::class, 'reorder'])->name('menu-items.reorder');
            });
    }
}
