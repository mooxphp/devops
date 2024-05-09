<?php

namespace Moox\ForgeServer\Resources\ForgeProjectResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;
use Moox\ForgeServer\Models\ForgeServer;

class ForgeProjectWidgets extends BaseWidget
{
    protected function getCards(): array
    {
        $aggregationColumns = [
            DB::raw('COUNT(*) as count'),
            DB::raw('COUNT(*) as count'),
            DB::raw('COUNT(*) as count'),
        ];

        $aggregatedInfo = ForgeServer::query()
            ->select($aggregationColumns)
            ->first();

        return [
            Stat::make(__('forge-servers::translations.totalone'), $aggregatedInfo->count ?? 0),
            Stat::make(__('forge-servers::translations.totaltwo'), $aggregatedInfo->count ?? 0),
            Stat::make(__('forge-servers::translations.totalthree'), $aggregatedInfo->count ?? 0),
        ];
    }
}
