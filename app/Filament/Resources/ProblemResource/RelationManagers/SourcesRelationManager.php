<?php

namespace App\Filament\Resources\ProblemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SourcesRelationManager extends RelationManager
{
    protected static string $relationship = 'sources';
    protected static ?string $navigationLabel = 'Источники';
    protected static ?string $pluralModelLabel = 'Источники';
    protected static ?string $modelLabel = 'Источник';
    protected static ?string $title = 'Источники';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Название')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('type')
                ->label('Тип')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('url')
                ->label('Ссылка')
                ->url()
                ->nullable()
                ->maxLength(255),

            Forms\Components\Textarea::make('note')
                ->label('Примечание')
                ->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Источник'),
                Tables\Columns\TextColumn::make('url')->label('Ссылка')->wrap()->limit(40),
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
