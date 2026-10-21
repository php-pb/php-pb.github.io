<?php

namespace App\Filament\Member\Resources\PostResource\Pages;

use App\Filament\Concerns\HasPostPreview;
use App\Filament\Member\Resources\PostResource;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    use HasPostPreview;

    protected static string $resource = PostResource::class;
}
