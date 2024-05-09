<?php

namespace Moox\ForgeServer;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Moox\ForgeServer\Resources\ForgeServerResource;

class ForgeServerPlugin implements Plugin
{
    use EvaluatesClosures;

    public function getId(): string
    {
        return 'forge-servers';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            ForgeServerResource::class,
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
