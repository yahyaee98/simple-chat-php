<?php

declare(strict_types=1);

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string id
 * @property string nickname
 * @property \Carbon\Carbon created_at
 */
class User extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    public $visible = [
        'id',
        'nickname',
    ];

    protected $fillable = [
        'id',
        'nickname',
    ];
}
