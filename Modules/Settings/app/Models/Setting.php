<?php

declare(strict_types=1);

namespace Modules\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Traits\HasUuid;

class Setting extends Model
{
    use HasUuid;

    protected $fillable = [
        'key',
        'value',
    ];
}
