<?php

namespace App\Filament\Resources\ProblemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SolutionsRelationManager extends RelationManager
{
    protected static string $relationship = 'solutions';
    protected static ?string $navigationLabel = 'Решения';
    protected static ?string $pluralModelLabel = 'Решения';
    protected static ?string $modelLabel = 'Решение';
    protected static ?string $title = 'Решения';


    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\RichEditor::make('description')
                ->label('Описание решения')
                ->required()
                ->columnSpanFull(),
            Forms\Components\Toggle::make('is_verified')
                ->label('Проверено'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')->limit(50)->label('Описание'),
                Tables\Columns\IconColumn::make('is_verified')->boolean()->label('Проверено'),
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
