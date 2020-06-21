<?php

declare(strict_types=1);

namespace App\Services\Chat\Data\Models;

use App\Data\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string id
 * @property string text
 * @property string from
 * @property string to
 * @property User author
 * @property \Carbon\Carbon created_at
 */
class Message extends Model
{
    public $incrementing = false;
    public $timestamps = false;

    public $visible = [
        'id',
        'text',
        'author',
        'created_at',
    ];

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}
