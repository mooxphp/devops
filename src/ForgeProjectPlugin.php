<?php

namespace Moox\ForgeServer;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Moox\ForgeServer\Resources\ForgeProjectResource;

class ForgeProjectPlugin implements Plugin
{
    use EvaluatesClosures;

    public function getId(): string
    {
        return 'forge-projects';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            ForgeProjectResource::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
