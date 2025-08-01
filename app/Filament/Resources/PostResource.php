<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Modules\Posts\Models\Post;
use Filament\Forms\Components\{TextInput, Textarea, RichEditor, Select};
use Filament\Tables\Columns\{SpatieMediaLibraryImageColumn, TextColumn};

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Посты';
    protected static ?string $modelLabel = 'Пост';
    protected static ?string $pluralModelLabel = 'Посты';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->label('Заголовок')
                ->required()
                ->maxLength(255)
                ->live()
                ->afterStateUpdated(fn ($state, callable $set) =>
                $set('slug', \Str::slug($state))
                ),

            TextInput::make('slug')
                ->label('Ссылка')
                ->required()
                ->maxLength(255),

            SpatieMediaLibraryFileUpload::make('image')
                ->label('Изображение')
                ->collection('post-image')
                ->imageEditor()
                ->disk('public'),

            Textarea::make('excerpt')
                ->label('Краткое описание')
                ->rows(3),

            RichEditor::make('body')
                ->label('Содержание')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            SpatieMediaLibraryImageColumn::make('image')
                ->collection('post-image'),
            TextColumn::make('title')->searchable()->sortable(),
            TextColumn::make('slug')->copyable(),
            TextColumn::make('created_at')->dateTime()->sortable(),
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
            RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
