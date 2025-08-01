<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModificationResource\Pages;
use App\Filament\Resources\ModificationResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Auto\Models\Modification;

class ModificationResource extends Resource
{
    protected static ?string $model = Modification::class;
    protected static ?string $navigationGroup = 'Авто';
    protected static ?string $navigationLabel = 'Модификация';
    protected static ?string $pluralModelLabel = 'Модификация';
    protected static ?string $modelLabel = 'Модификация';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('model_id')
                    ->relationship('model', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('year_start'),
                Forms\Components\TextInput::make('year_end'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model.brand.name')->searchable(),
                Tables\Columns\TextColumn::make('model.name'),
                Tables\Columns\TextColumn::make('name'),
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
            'index' => Pages\ListModifications::route('/'),
            'create' => Pages\CreateModification::route('/create'),
            'edit' => Pages\EditModification::route('/{record}/edit'),
        ];
    }
}
