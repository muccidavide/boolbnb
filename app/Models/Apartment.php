<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Apartment extends Model
{
    protected $fillable = ['title', 'slug', 'thumb', 'description', 'rooms', 'beds', 'baths', 'sqm', 'address', 'lon', 'lat', 'visibility', 'user_id'];

    // metodo statico da richiamare nel controller per generare lo slug
    public static function generateSlug($title)
    {
        return Str::slug($title, '-');
    }

    /**
     * Get the user that owns the Apartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The services that belong to the Apartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * Get all of the views for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views(): HasMany
    {
        return $this->hasMany(View::class);
    }

    public function images() :HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * The publicities that belong to the Apartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function publicities(): BelongsToMany
    {
        return $this->belongsToMany(Publicity::class)->withPivot('apartment_id', 'publicity_id', 'publicity_start_date', 'publicity_expiration_date');
    }

    /**
     * Get all of the views for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}