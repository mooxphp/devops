<?php

namespace Moox\ForgeServer\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Moox\ForgeServer\Models\ForgeProject;

class ForgeWebhook extends Controller
{
    public function handleForge(Request $request)
    {
        $data = $request->all();

        $project = ForgeProject::where('site_id', $data['site']['id'])->first();

        if ($project) {
            $user = User::where('id', $project->deployed_by_user_id)->first();

            if ($data['status'] == 'success') {
                Notification::make()
                    ->title('Project '.$project->name.' has been deployed.')
                    ->success()
                    ->persistent()
                    ->broadcast($user);

                logger()->info('Project '.$project->name.' has been deployed.');
            } else {
                Notification::make()
                    ->title('Project '.$project->name.' has NOT been deployed.')
                    ->body(json_encode($data))
                    ->danger()
                    ->persistent()
                    ->broadcast($user);

                logger()->error('Project '.$project->name.' has NOT been deployed.');
            }

            $project->update([
                'last_commit_hash' => $data['commit_hash'],
                'last_commit_url' => $data['commit_url'],
                'last_commit_message' => $data['commit_message'],
                'last_commit_author' => $data['commit_author'],
                'deployment_status' => $data['status'],
                'lock_deployments' => false,
                'last_deployment' => now(),
            ]);

        } else {
            logger()->error('Failed to update project: Site ID not found', ['site_id' => $data['site']['id']]);

            return response()->json(['error' => 'Site ID not found'], 404);
        }
    }
}
