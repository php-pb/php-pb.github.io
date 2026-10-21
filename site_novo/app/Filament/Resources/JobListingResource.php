<?php

namespace App\Filament\Resources;

use App\Enums\EmploymentType;
use App\Enums\SeniorityLevel;
use App\Enums\WorkMode;
use App\Filament\Resources\JobListingResource\Pages;
use App\Models\JobListing;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static string|\UnitEnum|null $navigationGroup = 'Vagas';

    protected static ?string $navigationLabel = 'Vagas';

    protected static ?string $modelLabel = 'Vaga';

    protected static ?string $pluralModelLabel = 'Vagas';

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

                TextInput::make('company')
                    ->label('Empresa')
                    ->required(),

                TextInput::make('location')
                    ->label('Local')
                    ->placeholder('Ex: João Pessoa, PB'),

                Select::make('work_mode')
                    ->label('Modalidade')
                    ->options(WorkMode::class)
                    ->default(WorkMode::Presencial)
                    ->required(),

                Select::make('employment_type')
                    ->label('Contrato')
                    ->options(EmploymentType::class)
                    ->default(EmploymentType::Clt)
                    ->required(),

                Select::make('seniority')
                    ->label('Senioridade')
                    ->options(SeniorityLevel::class)
                    ->default(SeniorityLevel::Pleno)
                    ->required(),

                TextInput::make('salary_range')
                    ->label('Faixa salarial')
                    ->placeholder('Ex: R$ 5.000 - R$ 8.000'),

                TextInput::make('external_url')
                    ->label('Link de candidatura')
                    ->url()
                    ->required(),

                DateTimePicker::make('published_at')
                    ->label('Publicado em')
                    ->nullable(),

                DateTimePicker::make('expires_at')
                    ->label('Expira em')
                    ->nullable(),
            ]),

            Textarea::make('description')
                ->label('Descrição')
                ->rows(4)
                ->columnSpanFull(),

            FileUpload::make('company_logo')
                ->label('Logo da empresa')
                ->image()
                ->disk('public')
                ->directory('jobs')
                ->maxSize(5120),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('company_logo')
                    ->label('')
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('Título')
                    ->sortable()
                    ->searchable()
                    ->limit(50),

                TextColumn::make('company')
                    ->label('Empresa')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('work_mode')
                    ->label('Modalidade')
                    ->badge()
                    ->sortable(),

                TextColumn::make('seniority')
                    ->label('Senioridade')
                    ->badge()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Publicado')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—')
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->label('Expira')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('work_mode')->label('Modalidade')->options(WorkMode::class),
                SelectFilter::make('seniority')->label('Senioridade')->options(SeniorityLevel::class),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }
}
