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

        logger()->info('Forge Webhook', $data);

        // https://forge.laravel.com/docs/sites/deployments.html#webhooks

        if ($data['status'] == 'success') {
            $project = ForgeProject::where('site_id', $data['site']['id'])->first();

            logger()->info('Forge Webhook: Deployment Success', ['site_id' => $data['site']['id']]);

            if ($project) {
                $project->update([
                    'commit' => $data['commit_hash'],
                    'commit_message' => $data['commit_message'],
                    'commit_author' => $data['commit_author'],
                    'last_deployment' => now(),
                ]);
            } else {
                logger()->error('Failed to update project: Site ID not found', ['site_id' => $data['site']['id']]);

                return response()->json(['error' => 'Site ID not found'], 404);
            }
        }
    }
}
