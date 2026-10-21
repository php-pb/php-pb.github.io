<?php

namespace App\Filament\Widgets;

use App\Enums\PostStatus;
use App\Models\Event;
use App\Models\JobListing;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Publicados', Post::published()->count())
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Pendentes', Post::pending()->count())
                ->description('Aguardando revisão')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Rascunhos', Post::where('status', PostStatus::Draft)->count())
                ->icon('heroicon-o-pencil')
                ->color('gray'),

            Stat::make('Eventos próximos', Event::published()->upcoming()->count())
                ->icon('heroicon-o-calendar-days')
                ->color('info'),

            Stat::make('Vagas ativas', JobListing::published()->active()->count())
                ->icon('heroicon-o-briefcase')
                ->color('info'),
        ];
    }
}
