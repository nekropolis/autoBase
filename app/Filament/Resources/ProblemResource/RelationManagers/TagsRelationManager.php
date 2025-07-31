<?php

namespace App\Filament\Resources\ProblemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';
    protected static ?string $navigationLabel = 'Теги';
    protected static ?string $pluralModelLabel = 'Теги';
    protected static ?string $modelLabel = 'Тег';
    protected static ?string $title = 'Теги';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TagsInput::make('name')->label('Тег'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Тег'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
