<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Publicity extends Model
{
    /**
     * The apartments that belong to the Publicty
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apartments(): BelongsToMany
    {
        return $this->belongsToMany(Apartment::class)->withPivot('apartment_id', 'publicity_id', 'publicity_start_date', 'publicity_expiration_date');
    }
}