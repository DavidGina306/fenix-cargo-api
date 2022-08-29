<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jamesh\Uuid\HasUuid;

class Profile extends Model
{
    use HasUuid;
    protected $guarded = [];

    /**
     * Get all of the users for the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
