<?php

namespace Moox\ForgeServer\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Moox\ForgeServer\Models\ForgeProject;
use Moox\ForgeServer\Models\ForgeServer;

class SyncForgeData extends Command
{
    protected $signature = 'moox:syncforge';

    protected $description = 'Synchronize data from Laravel Forge API and Git data';

    public function handle()
    {
        $client = new Client();
        $apiKey = config('forge-servers.forge_api_key');
        $baseUrl = config('forge-servers.forge_api_url');

        $serversResponse = $client->request('GET', $baseUrl.'/servers', [
            'headers' => ['Authorization' => "Bearer {$apiKey}"],
        ]);

        $servers = json_decode($serversResponse->getBody()->getContents(), true);

        foreach ($servers['servers'] as $serverData) {
            if (str_contains($serverData['name'], config('forge-servers.forge_server_filter'))) {
                $server = ForgeServer::updateOrCreate(
                    ['forge_id' => $serverData['id']],
                    [
                        'name' => $serverData['name'],
                        'ip_address' => $serverData['ip_address'],
                        'type' => $serverData['type'],
                        'provider' => $serverData['provider'],
                        'region' => $serverData['region'],
                        'ubuntu_version' => $serverData['ubuntu_version'],
                        'db_status' => $serverData['db_status'],
                        'redis_status' => $serverData['redis_status'],
                        'php_version' => $serverData['php_version'],
                        'is_ready' => $serverData['is_ready'],
                    ]
                );

                $projectsResponse = $client->request('GET', $baseUrl.'/servers/'.$serverData['id'].'/sites', [
                    'headers' => ['Authorization' => "Bearer {$apiKey}"],
                ]);

                $projects = json_decode($projectsResponse->getBody()->getContents(), true);

                foreach ($projects['sites'] as $projectData) {

                    $project = ForgeProject::updateOrCreate(
                        ['site_id' => $projectData['id']],
                        [
                            'name' => $projectData['name'],
                            'deployment_url' => $projectData['deployment_url'],
                            'server_id' => $projectData['server_id'],
                        ]
                    );
                }
            }
        }

        $this->info('Data synchronization complete.');
    }
}
