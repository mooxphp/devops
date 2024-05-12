<?php

namespace Moox\ForgeServer\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Moox\ForgeServer\Models\ForgeProject;

class GithubWebhook extends Controller
{
    public function handleGitHub(Request $request)
    {
        $data = $request->all();

        logger()->info('GitHub Webhook', $data);

        /*
        $repository = $data['repository']['name'];
        $commits = $data['commits'];
        $head_commit = $data['head_commit'];



        // Process the latest commit details
        // Find the relevant project and update it
        $project = ForgeProject::where('repo_name', $repository)->first();
        if ($project) {
            $project->update([
                'last_deployment' => now(),
                'commit' => $head_commit['id'],
                'commit_message' => $head_commit['message'],
                'commit_author' => $head_commit['author']['name'],
            ]);
        }

        */
    }
}
