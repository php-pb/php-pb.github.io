<?php

namespace App\Filament\Member\Pages;

use App\Filament\Member\Widgets\MyPostsOverview;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            MyPostsOverview::class,
        ];
    }
}
