<?php

namespace Moox\ForgeServer\Models;

use Illuminate\Database\Eloquent\Model;

class ForgeCommit extends Model
{
    protected $table = 'forge_commits';

    protected $fillable = [
        'commit_hash',
        'commit_message',
        'commit_author',
        'commit_url',
        'commit_timestamp',
        'repository_id',
        'deployed_to_project_id',
    ];

    protected $casts = [
        'commit_timestamp' => 'datetime',
    ];

    public function server()
    {
        return $this->belongsTo(ForgeRepository::class, 'repository_id', 'id');
    }
}
