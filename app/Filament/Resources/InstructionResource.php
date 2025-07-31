<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstructionResource\Pages;
use App\Filament\Resources\InstructionResource\RelationManagers;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Auto\Models\Brand;
use Modules\Auto\Models\ModelAuto;
use Modules\Auto\Models\Modification;
use Modules\KnowledgeBase\Models\Instruction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;


class InstructionResource extends Resource
{
    protected static ?string $model = Instruction::class;
    protected static ?string $navigationGroup = 'База знаний';
    protected static ?string $navigationLabel = 'Инструкции';
    protected static ?string $pluralModelLabel = 'Инструкции';
    protected static ?string $modelLabel = 'Инструкция';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Название')
                ->required()
                ->maxLength(255),

            Select::make('brand_id')
                ->label('Марка авто')
                ->options(Brand::pluck('name', 'id'))
                ->reactive()
                ->required()
                ->afterStateHydrated(function (Select $component, ?Instruction $record) {
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
                ->afterStateHydrated(function (Select $component, ?Instruction $record) {
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
                ->afterStateHydrated(function (Select $component, ?Instruction $record) {
                    $component->state($record?->modifications->pluck('id')->toArray() ?? []);
                }),

            Select::make('component_id')
                ->label('Компонент Авто')
                ->relationship('component', 'name')
                ->required()
                ->searchable(),

            RichEditor::make('content')
                ->label('Контент')
                ->required()
                ->columnSpanFull(),

            FileUpload::make('media')
                ->multiple()
                ->reorderable()
                ->disk('public')
                ->directory('instructions/media')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('component.name')->label('Компонент'),
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SourceRelationManager::class,
            RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstructions::route('/'),
            'create' => Pages\CreateInstruction::route('/create'),
            'edit' => Pages\EditInstruction::route('/{record}/edit'),
        ];
    }
}
