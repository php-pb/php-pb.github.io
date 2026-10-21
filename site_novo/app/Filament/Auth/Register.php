<?php

namespace App\Filament\Auth;

use App\Enums\UserRole;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class Register extends BaseRegister
{
    protected static string $layout = 'filament.auth.split-layout';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getCargoFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getCargoFormComponent(): Component
    {
        return TextInput::make('cargo')
            ->label('Cargo')
            ->placeholder('Ex: Desenvolvedor Back-End')
            ->maxLength(255);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(6));
        $data['role'] = UserRole::Member;

        return $data;
    }
}
