<?php

namespace App\Filament\Member\Pages;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getNameFormComponent(),
            $this->getEmailFormComponent(),

            FileUpload::make('avatar')
                ->label('Avatar')
                ->image()
                ->disk('public')
                ->directory('avatars')
                ->maxSize(5120),

            TextInput::make('cargo')
                ->label('Cargo')
                ->placeholder('Ex: Desenvolvedor Back-End'),

            Textarea::make('bio')
                ->label('Bio')
                ->rows(3),

            TextInput::make('github_url')
                ->label('GitHub')
                ->url()
                ->placeholder('https://github.com/seu-usuario'),

            TextInput::make('linkedin_url')
                ->label('LinkedIn')
                ->url()
                ->placeholder('https://linkedin.com/in/seu-usuario'),

            TagsInput::make('stack')
                ->label('Stack')
                ->placeholder('Adicione uma tecnologia e aperte Enter'),
        ]);
    }
}
