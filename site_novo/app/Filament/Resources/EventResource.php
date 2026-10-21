<?php

namespace App\Filament\Resources;

use App\Enums\EventType;
use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|\UnitEnum|null $navigationGroup = 'Eventos';

    protected static ?string $navigationLabel = 'Eventos';

    protected static ?string $modelLabel = 'Evento';

    protected static ?string $pluralModelLabel = 'Eventos';

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

                DateTimePicker::make('starts_at')
                    ->label('Data e hora')
                    ->required(),

                Select::make('type')
                    ->label('Tipo')
                    ->options(EventType::class)
                    ->default(EventType::Presencial)
                    ->required(),

                TextInput::make('location')
                    ->label('Local')
                    ->placeholder('Ex: Hub PB, João Pessoa ou Online via Google Meet')
                    ->required(),

                TextInput::make('external_url')
                    ->label('Link de inscrição')
                    ->url()
                    ->placeholder('https://meetup.com/...'),

                TextInput::make('attendees_count')
                    ->label('Confirmados')
                    ->numeric()
                    ->minValue(0),

                DateTimePicker::make('published_at')
                    ->label('Publicado em')
                    ->nullable(),

                Toggle::make('is_featured')
                    ->label('Destaque')
                    ->columnSpanFull()
                    ->default(false),
            ]),

            Textarea::make('description')
                ->label('Descrição')
                ->rows(4)
                ->columnSpanFull(),

            Select::make('speakers')
                ->label('Palestrantes')
                ->relationship('speakers', 'name')
                ->multiple()
                ->searchable()
                ->preload()
                ->getOptionLabelFromRecordUsing(fn (User $user) => $user->cargo ? "{$user->name} ({$user->cargo})" : $user->name)
                ->columnSpanFull(),

            FileUpload::make('banner')
                ->label('Banner')
                ->image()
                ->disk('public')
                ->directory('events')
                ->maxSize(5120)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('banner')
                    ->label('')
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('Título')
                    ->sortable()
                    ->searchable()
                    ->limit(50),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),

                TextColumn::make('published_at')
                    ->label('Publicado')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipo')->options(EventType::class),
                TernaryFilter::make('is_featured')->label('Destaque'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('starts_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
