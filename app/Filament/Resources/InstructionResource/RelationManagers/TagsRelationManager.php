<?php

namespace App\Filament\Resources\InstructionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

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
            Forms\Components\TextInput::make('name')->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
