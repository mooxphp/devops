<?php

namespace Moox\ForgeServer\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GithubWebhook extends Controller
{
    public function handleGitHub(Request $request)
    {
        $data = $request->all();

        logger()->info('GitHub Webhook', $data);
    }
}
