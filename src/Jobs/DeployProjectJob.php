<?php

namespace Moox\ForgeServer\Jobs;

use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
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
        $this->project->update([
            'deployment_status' => 'running',
            'deployed_by_user_id' => $this->user->id,
            'lock_deployments' => true,
        ]);

        Notification::make()
            ->title('Project '.$this->project->name.' will be deployed.')
            ->info()
            ->persistent()
            ->broadcast($this->user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('forge-servers.forge_api_key'),
            'Accept' => 'application/json',
        ])->post($this->project->deployment_url);
    }
}
