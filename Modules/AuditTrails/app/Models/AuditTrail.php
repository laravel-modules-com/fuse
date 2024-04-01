<?php

declare(strict_types=1);

namespace Modules\AuditTrails\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Admin\Models\Traits\HasUuid;
use Modules\AuditTrails\Database\Factories\AuditTrailsFactory;

class AuditTrail extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'link',
        'reference_id',
        'section',
        'type',
    ];

    protected static function newFactory(): AuditTrailsFactory
    {
        return AuditTrailsFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
