<?php

use Illuminate\Routing\Route;
use Moox\ForgeServer\Webhooks\ForgeWebhook;
use Moox\ForgeServer\Webhooks\GithubWebhook;

Route::post('/webhooks/forge', [ForgeWebhook::class, 'handleForge']);
Route::post('/webhooks/github', [GithubWebhook::class, 'handleGitHub']);
