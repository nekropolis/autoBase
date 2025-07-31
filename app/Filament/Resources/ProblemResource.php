<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProblemResource\Pages;
use App\Filament\Resources\ProblemResource\RelationManagers;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Auto\Models\Brand;
use Modules\Auto\Models\ModelAuto;
use Modules\Auto\Models\Modification;
use Modules\KnowledgeBase\Models\Problem;

class ProblemResource extends Resource
{
    protected static ?string $model = Problem::class;
    protected static ?string $navigationGroup = 'База знаний';
    protected static ?string $navigationLabel = 'Проблемы';
    protected static ?string $pluralModelLabel = 'Проблемы';
    protected static ?string $modelLabel = 'Проблема';
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Название проблемы')
                ->required()
                ->maxLength(255),

            Select::make('brand_id')
                ->label('Марка авто')
                ->options(Brand::pluck('name', 'id'))
                ->reactive()
                ->required()
                ->afterStateHydrated(function (Select $component, ?Problem $record) {
                    $component->state($record?->modifications->first()?->model->brand_id ?? null);
                })
                ->afterStateUpdated(fn (callable $set) => [
                    $set('model_id', null),
                    $set('modification_ids', []),
                ]),

            Select::make('model_id')
                ->label('Модель авто')
                ->options(fn (callable $get) =>
                $get('brand_id')
                    ? ModelAuto::where('brand_id', $get('brand_id'))->pluck('name', 'id')
                    : []
                )
                ->reactive()
                ->required()
                ->disabled(fn (callable $get) => !$get('brand_id'))
                ->afterStateHydrated(function (Select $component, ?Problem $record) {
                    $component->state($record?->modifications->first()?->model_id ?? null);
                })
                ->afterStateUpdated(fn (callable $set) => $set('modification_ids', [])),

            Select::make('modification_ids')
                ->label('Модификации авто')
                ->multiple()
                ->options(fn (callable $get) =>
                $get('model_id')
                    ? Modification::where('model_id', $get('model_id'))->pluck('name', 'id')
                    : []
                )
                ->searchable()
                ->preload()
                ->required()
                ->dehydrated(false)
                ->afterStateHydrated(function (Select $component, ?Problem $record) {
                    $component->state($record?->modifications->pluck('id')->toArray() ?? []);
                }),

            RichEditor::make('description')
                ->label('Описание')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Название'),
                Tables\Columns\TextColumn::make('modifications')
                    ->label('Модификации')
                    ->formatStateUsing(fn($record) =>
                        $record->modifications->pluck('name')->take(1)->implode(', ') .
                        ($record->modifications->count() > 1 ? ' …' : '')
                    )
                    ->tooltip(fn($record) =>
                    $record->modifications->pluck('name')->implode(', ')
                    )
                    ->wrap(),
                TextColumn::make('symptoms_count')->counts('symptoms')->label('Симптомов'),
                TextColumn::make('solutions_count')->counts('solutions')->label('Решений'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SolutionsRelationManager::class,
            RelationManagers\SourcesRelationManager::class,
            RelationManagers\SymptomsRelationManager::class,
            RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProblems::route('/'),
            'create' => Pages\CreateProblem::route('/create'),
            'edit' => Pages\EditProblem::route('/{record}/edit'),
        ];
    }
}
