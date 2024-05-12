<?php

declare(strict_types=1);

namespace Moox\ForgeServer;

use Moox\ForgeServer\Commands\InstallCommand;
use Moox\ForgeServer\Commands\SyncForgeData;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ForgeServerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('forge-servers')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('api')
            ->hasTranslations()
            ->hasMigrations([
                'create_forge_servers_table',
                'create_forge_projects_table',
                'create_forge_commits_table',
                'create_forge_repositories_table', ])
            ->hasCommands(InstallCommand::class, SyncForgeData::class);
    }
}
