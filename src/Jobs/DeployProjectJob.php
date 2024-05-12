<?php

namespace Moox\ForgeServer\Jobs;

use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Moox\ForgeServer\Models\ForgeProject;

class DeployProjectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;

    protected $user;

    public function __construct(ForgeProject $project, $user)
    {
        $this->project = $project;
        $this->user = $user;
    }

    public function handle()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('forge-servers.forge_api_key'),
            'Accept' => 'application/json',
        ])->post($this->project->deployment_url);

        Log::info("Server {$this->project->name} has been deployed.");

        Notification::make()
            ->title('Project '.$this->project->name.' has been deployed.')
            ->success()
            ->broadcast($this->user);

        // this is better done by the Forge webhook
        //$this->project->last_deployment = now();
        $this->project->save();
    }
}
