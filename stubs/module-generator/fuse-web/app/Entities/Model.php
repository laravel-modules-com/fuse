<?php

declare(strict_types=1);

namespace Modules\{Module}\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\{Module}\Database\Factories\{Model}Factory;

class {Model} extends Model
{
    /** @use HasFactory<{Model}Factory> */
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var List<string>
     */
    protected $fillable = [
        'name',
        'email',
    ];

    protected static function newFactory(): {Model}Factory
    {
        return {Model}Factory::new();
    }
}
