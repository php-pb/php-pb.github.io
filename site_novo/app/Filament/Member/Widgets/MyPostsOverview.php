<?php

namespace App\Filament\Member\Widgets;

use App\Enums\PostStatus;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MyPostsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $authorId = Auth::id();

        return [
            Stat::make('Publicados', Post::published()->where('author_id', $authorId)->count())
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Pendentes', Post::pending()->where('author_id', $authorId)->count())
                ->description('Aguardando revisão')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Rascunhos', Post::where('author_id', $authorId)->where('status', PostStatus::Draft)->count())
                ->icon('heroicon-o-pencil')
                ->color('gray'),
        ];
    }
}
