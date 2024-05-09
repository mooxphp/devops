<?php

namespace Moox\ForgeServer\Models;

use Illuminate\Database\Eloquent\Model;

class ForgeServer extends Model
{
    protected $table = 'forge_servers';

    protected $fillable = [
        'name',
        'forge_id',
        'ip_address',
        'type',
        'provider',
        'region',
        'ubuntu_version',
        'db_status',
        'redis_status',
        'php_version',
        'is_ready',
    ];

    protected $casts = [
        'is_ready' => 'bool',
    ];

    public function projects()
    {
        return $this->hasMany(ForgeProject::class, 'server_id', 'forge_id');
    }
}
