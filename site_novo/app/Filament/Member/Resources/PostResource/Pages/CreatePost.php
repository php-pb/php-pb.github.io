<?php

namespace App\Filament\Member\Resources\PostResource\Pages;

use App\Filament\Concerns\HasPostPreview;
use App\Filament\Member\Resources\PostResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    use HasPostPreview;

    protected static string $resource = PostResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['author_id'] = Filament::auth()->id();

        return $data;
    }
}
