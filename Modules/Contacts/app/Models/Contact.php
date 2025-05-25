<?php

declare(strict_types=1);

namespace Modules\Contacts\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Contacts\Database\Factories\ContactFactory;

class Contact extends Model
{
    /** @use HasFactory<ContactFactory> */
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

    protected static function newFactory(): ContactFactory
    {
        return ContactFactory::new();
    }
}
