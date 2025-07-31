<?php

namespace App\Filament\Resources\ProblemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SymptomsRelationManager extends RelationManager
{
    protected static string $relationship = 'symptoms';
    protected static ?string $navigationLabel = 'Симптомы';
    protected static ?string $pluralModelLabel = 'Симптомы';
    protected static ?string $modelLabel = 'Симптом';
    protected static ?string $title = 'Симптомы';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('description')
                ->label('Описание симптома')
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')->label('Описание'),
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
