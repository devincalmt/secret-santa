<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'code',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userDetails()
    {
        return $this->hasMany(UserDetail::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Define the relationship for the SecretSanta where the user is the giver
    public function givenSecretSanta()
    {
        return $this->hasOne(SecretSanta::class, 'giver_id');
    }

    // Define the relationship for the SecretSanta where the user is the receiver
    public function receivedSecretSanta()
    {
        return $this->hasOne(SecretSanta::class, 'receiver_id');
    }

    protected static function boot()
    {
        parent::boot();

        // Generate UUID ketika membuat user baru
        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = (string) Str::uuid();
            }
        });
    }
}
