<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SymptomResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Modules\KnowledgeBase\Models\Symptom;

class SymptomResource extends Resource
{
    protected static ?string $model = Symptom::class;
    protected static ?string $navigationGroup = 'База знаний';
    protected static ?string $navigationLabel = 'Симптомы';
    protected static ?string $pluralModelLabel = 'Симптомы';
    protected static ?string $modelLabel = 'Симптом';
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('problem_id')
                ->label('Проблема')
                ->relationship('problem', 'title')
                ->searchable()
                ->required(),

            Textarea::make('description')
                ->label('Описание симптома')
                ->required()
                ->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('problem.title')->label('Проблема')->sortable()->searchable(),
                TextColumn::make('description')->label('Описание')->limit(50)->wrap(),
                TextColumn::make('created_at')->label('Создано')->dateTime(),
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
        return []; // Можно добавить релейшены, если в будущем появятся
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSymptoms::route('/'),
            'create' => Pages\CreateSymptom::route('/create'),
            'edit' => Pages\EditSymptom::route('/{record}/edit'),
        ];
    }
}
