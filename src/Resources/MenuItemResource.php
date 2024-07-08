<?php

namespace Tarique\MenuBuilder\Resources;

use Tarique\MenuBuilder\Models\MenuItem;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Spatie\Permission\Models\Role;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-menu';

    public static function navigationLabel()
    {
        return 'Menu Builder'; // Label shown in the sidebar navigation
    }

    public static function getModel()
    {
        return MenuItem::class;
    }

    public static function getPages()
    {
        return [
            ListRecords::for(static::class)->canSee(function () {
                // Optionally define permissions to view this page
                return true; // Example: always visible
            }),
            CreateRecord::for(static::class)->canSee(function () {
                return true; // Example: always visible
            }),
            EditRecord::for(static::class)->canSee(function () {
                return true; // Example: always visible
            }),
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('target')
                    ->label('Target')
                    ->options([
                        '_self' => 'Same Tab',
                        '_blank' => 'New Tab',
                    ])
                    ->nullable(),
                Forms\Components\TextInput::make('rel')
                    ->label('Rel Attribute')
                    ->maxLength(255)
                    ->nullable(),
                Forms\Components\Select::make('parent_id')
                    ->label('Parent')
                    ->relationship('parent', 'title')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('url'),
                Tables\Columns\TextColumn::make('target')->label('Target'),
                Tables\Columns\TextColumn::make('rel')->label('Rel Attribute'),
                Tables\Columns\TextColumn::make('parent.title')->label('Parent'),
            ])
            ->defaultSort('order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    // public static function getPages(): array
    // {
    //     return [
    //         'index' => Pages\ListMenuItems::route('/'),
    //         'create' => Pages\CreateMenuItem::route('/create'),
    //         'edit' => Pages\EditMenuItem::route('/{record}/edit'),
    //     ];
    // }

    public function getAllRoles()
    {
        return Role::all();
    }
}
