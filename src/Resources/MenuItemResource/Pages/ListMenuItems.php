<?php

namespace Tarique\MenuBuilder\Resources\MenuItemResource\Pages;

use Filament\Actions\CreateAction;;
use Filament\Resources\Pages\ListRecords;
use Tarique\MenuBuilder\Resources\MenuItemResource;

class ListMenuItems extends ListRecords
{
    protected static string $resource = MenuItemResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}