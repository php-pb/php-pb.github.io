<?php

namespace App\Filament\Member\Resources;

use App\Enums\PostStatus;
use App\Filament\Fields\PostContent;
use App\Filament\Member\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Pboivin\FilamentPeek\Forms\Actions\InlinePreviewAction;
use Pboivin\FilamentPeek\Tables\Actions\ListPreviewAction;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Meus Artigos';

    protected static ?string $modelLabel = 'Artigo';

    protected static ?string $pluralModelLabel = 'Meus Artigos';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('author_id', Filament::auth()->id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Grid::make()->columns(2)->schema([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->live(debounce: 500)
                    ->afterStateUpdated(function ($set, $get, $state) {
                        if ($get('slug')) {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('status')
                    ->label('Status')
                    ->options(function (?Post $record) {
                        if ($record && in_array($record->status, [PostStatus::Published, PostStatus::Rejected], true)) {
                            return [$record->status->value => $record->status->getLabel()];
                        }

                        return [
                            PostStatus::Draft->value => PostStatus::Draft->getLabel(),
                            PostStatus::Pending->value => PostStatus::Pending->getLabel(),
                        ];
                    })
                    ->default(PostStatus::Draft)
                    ->helperText('Escolha "Em revisão" quando estiver pronto para um admin aprovar.')
                    ->disabled(fn (?Post $record) => $record && in_array($record->status, [PostStatus::Published, PostStatus::Rejected], true))
                    ->dehydrated()
                    ->required(),
            ]),

            Section::make('Imagem principal')->schema([
                FileUpload::make('main_image_upload')
                    ->label('Upload de imagem')
                    ->image()
                    ->disk('public')
                    ->directory('posts')
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ])->collapsible(),

            Section::make('Conteúdo')->schema([
                Actions::make([
                    InlinePreviewAction::make()
                        ->label('Preview do Conteúdo')
                        ->builderPreview('content_blocks'),
                ])->columnSpanFull()->alignRight(),
                PostContent::make('content_blocks'),
            ])->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image_upload')
                    ->label('')
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('Título')
                    ->sortable()
                    ->searchable()
                    ->limit(50),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Publicado')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options(PostStatus::class),
            ])
            ->recordActions([
                ListPreviewAction::make(),
                EditAction::make(),
                DeleteAction::make()->visible(fn (Post $record) => $record->status !== PostStatus::Published),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
