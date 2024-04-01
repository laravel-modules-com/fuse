<?php

declare(strict_types=1);

namespace Modules\Admin\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Admin\Database\Factories\NotificationFactory;
use Modules\Admin\Models\Traits\HasUuid;

class Notification extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'title',
        'assigned_to_user_id',
        'assigned_from_user_id',
        'link',
        'viewed',
        'viewed_at',
    ];

    protected static function newFactory(): NotificationFactory
    {
        return NotificationFactory::new();
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function assignedFrom(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_from_user_id');
    }
}
