<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;
    public const DEFAULT = 'http://127.0.0.1:8000/storage/users/default.png';
    public const FOLDER = 'public/users/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'age', 'email', 'file_name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        return env('APP_URL') . Storage::url(self::FOLDER . $this->attributes['file_name']);
    }

}
