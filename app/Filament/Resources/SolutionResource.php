<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolutionResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\KnowledgeBase\Models\Solution;

class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;
    protected static ?string $navigationGroup = 'База знаний';
    protected static ?string $navigationLabel = 'Решения';
    protected static ?string $pluralModelLabel = 'Решения';
    protected static ?string $modelLabel = 'Решение';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('problem_id')
                ->relationship('problem', 'title')
                ->required()
                ->searchable()
                ->preload(),

            Forms\Components\Select::make('source_id')
                ->relationship('source', 'title')
                ->searchable()
                ->preload()
                ->label('Источник')
                ->nullable(),

            Forms\Components\RichEditor::make('description')
                ->label('Описание решения')
                ->required()
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_verified')
                ->label('Проверено'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('problem.title')->label('Проблема'),
            Tables\Columns\TextColumn::make('source.title')->label('Источник')->sortable(),
            Tables\Columns\IconColumn::make('is_verified')->boolean()->label('Проверено'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Создано'),
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
        // Пока нет подчинённых сущностей у solutions, можно оставить пустым
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolutions::route('/'),
            'create' => Pages\CreateSolution::route('/create'),
            'edit' => Pages\EditSolution::route('/{record}/edit'),
        ];
    }
}
