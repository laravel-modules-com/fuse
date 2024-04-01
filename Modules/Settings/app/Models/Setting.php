<?php

declare(strict_types=1);

namespace Modules\Settings\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasUuid;

    protected $fillable = [
        'key',
        'value',
    ];
}
