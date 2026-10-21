<?php

namespace App\Filament\Resources\JobListingResource\Pages;

use App\Filament\Resources\JobListingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJobListing extends EditRecord
{
    protected static string $resource = JobListingResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
