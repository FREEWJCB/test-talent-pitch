<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;

class Program extends Model
{
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        ];

    /**
     * user function
     * relationship belong to user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * users function
     * relationship morph to many users
     * @return MorphToMany
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'entity', 'program_participants');
    }

    /**
     * challenges function
     * relationship morph to many challenges
     * @return MorphToMany
     */
    public function challenges(): MorphToMany
    {
        return $this->morphedByMany(Challenge::class, 'entity', 'program_participants');
    }

    /**
     * companies function
     * relationship morph to many companies
     * @return MorphToMany
     */
    public function companies(): MorphToMany
    {
        return $this->morphedByMany(Company::class, 'entity', 'program_participants');
    }
}