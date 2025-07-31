<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModelResource\Pages;
use App\Filament\Resources\ModelResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Auto\Models\ModelAuto;

class ModelResource extends Resource
{
    protected static ?string $model = ModelAuto::class;
    protected static ?string $navigationGroup = 'Авто';
    protected static ?string $navigationLabel = 'Модель';
    protected static ?string $pluralModelLabel = 'Модель';
    protected static ?string $modelLabel = 'Модель';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('slug'),
                Forms\Components\TextInput::make('year_start'),
                Forms\Components\TextInput::make('year_end'),
                Forms\Components\TextInput::make('description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('year_start'),
                Tables\Columns\TextColumn::make('year_end'),
                Tables\Columns\TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModels::route('/'),
            'create' => Pages\CreateModel::route('/create'),
            'edit' => Pages\EditModel::route('/{record}/edit'),
        ];
    }
}
