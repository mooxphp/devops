<?php

namespace Moox\ForgeServer\Resources\ForgeProjectResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Moox\ForgeServer\Resources\ForgeProjectResource;
use Moox\ForgeServer\Resources\ForgeProjectResource\Widgets\ForgeProjectWidgets;

class ListPage extends ListRecords
{
    public static string $resource = ForgeProjectResource::class;

    public function getActions(): array
    {
        return [];
    }

    public function getHeaderWidgets(): array
    {
        return [
            //ForgeProjectWidgets::class,
        ];
    }

    public function getTitle(): string
    {
        return __('forge-servers::translations.forge_projects');
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
