<?php

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'Blog';

    protected static ?string $navigationLabel = 'Usuários';

    protected static ?string $modelLabel = 'Usuário';

    protected static ?string $pluralModelLabel = 'Usuários';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nome')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state ?? ''))),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('email')
                ->label('E-mail')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('password')
                ->label('Senha')
                ->password()
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context) => $context === 'create'),

            Select::make('role')
                ->label('Papel')
                ->options(UserRole::class)
                ->required(),

            TextInput::make('cargo')
                ->label('Cargo'),

            Textarea::make('bio')
                ->label('Bio')
                ->rows(3)
                ->columnSpanFull(),

            TextInput::make('github_url')
                ->label('GitHub')
                ->url(),

            TextInput::make('linkedin_url')
                ->label('LinkedIn')
                ->url(),

            FileUpload::make('avatar')
                ->label('Avatar')
                ->image()
                ->disk('public')
                ->directory('avatars')
                ->maxSize(5120)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')->label('')->disk('public')->circular(),
                TextColumn::make('name')->label('Nome')->sortable()->searchable(),
                TextColumn::make('email')->label('E-mail')->searchable(),
                TextColumn::make('role')->label('Papel')->badge(),
                TextColumn::make('posts_count')
                    ->label('Posts')
                    ->counts('posts')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')->label('Papel')->options(UserRole::class),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
