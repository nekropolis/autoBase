<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SourceResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\KnowledgeBase\Models\Source;

class SourceResource extends Resource
{
    protected static ?string $model = Source::class;
    protected static ?string $navigationGroup = 'База знаний';
    protected static ?string $navigationLabel = 'Источники';
    protected static ?string $pluralModelLabel = 'Источники';
    protected static ?string $modelLabel = 'Источник';
    protected static ?string $navigationIcon = 'heroicon-o-link';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Название')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('type')->label('Тип')->sortable(),
                Tables\Columns\TextColumn::make('url')->label('Ссылка')->wrap()->limit(40),
                Tables\Columns\TextColumn::make('created_at')->label('Создано')->dateTime(),
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
        // Можно позже добавить relation manager, если потребуется
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSources::route('/'),
            'create' => Pages\CreateSource::route('/create'),
            'edit' => Pages\EditSource::route('/{record}/edit'),
        ];
    }
}
