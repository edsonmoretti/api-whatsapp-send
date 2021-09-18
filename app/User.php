<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'cpf', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function configurations()
    {
        return $this->hasMany(Configuration::class);
    }

    public function configuration($waTelephone)
    {
        return $this->configurations()->where('whatsapptelephone', '=', $waTelephone)->first();
    }

    public static function findByToken($token)
    {
        $db = DB::table('users')
            ->join('configurations', 'users.id', '=', 'configurations.user_id')
            ->where('configurations.api_token', '=', $token)
            ->select(['users.id', 'users.name', 'users.cpf'])
            ->first();
        if ($db) {
            $user = new User();
            $user->id = $db->id;
            $user->name = $db->name;
            $user->cpf = $db->cpf;
            return $user;
        }
        return null;
    }

    public function messages(): ?HasMany
    {
        return $this->hasMany(Message::class);
    }
    public function datacenterInfos(): ?HasMany
    {
        return $this->hasMany(DatacenterInfo::class);
    }
}
