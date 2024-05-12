<?php

namespace Moox\ForgeServer\Models;

use Illuminate\Database\Eloquent\Model;

class ForgeRepository extends Model
{
    protected $table = 'forge_repositories';

    protected $fillable = [
        'name',
        'repository_url',
        'platform',
        'platform_uid',
        'last_commit',
        'deploys_to_project_id',
    ];

    protected $casts = [
        'last_commit' => 'datetime',
    ];

    public function server()
    {
        return $this->hasMany(ForgeCommit::class, 'repository_id', 'id');
    }
}
