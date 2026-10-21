<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminOverview;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            AdminOverview::class,
        ];
    }
}
