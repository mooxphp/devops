<?php

namespace Moox\ForgeServer\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Moox\ForgeServer\Models\ForgeProject;

class ForgeWebhook extends Controller
{
    public function handleForge(Request $request)
    {
        $data = $request->all();

        // https://forge.laravel.com/docs/sites/deployments.html#webhooks
        // logger()->info('Forge Webhook', $data);

        if ($data['status'] == 'success') {
            $project = ForgeProject::where('site_id', $data['site']['id'])->first();

            if ($project) {
                $project->update([
                    'last_commit_hash' => $data['commit_hash'],
                    'last_commit_url' => $data['commit_url'],
                    'last_commit_message' => $data['commit_message'],
                    'last_commit_author' => $data['commit_author'],
                    'last_deployment' => now(),
                ]);
            } else {
                logger()->error('Failed to update project: Site ID not found', ['site_id' => $data['site']['id']]);

                return response()->json(['error' => 'Site ID not found'], 404);
            }
        }
    }
}
