<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class User extends Model {

    protected $fillable = [
        'email',
        'password',
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'password'
    ];

    /**
     * Setter for password
     *
     * @param $password
     */
    public function setPasswordAttribute($password) {
        if ($password)
            $this->attributes['password'] = Hash::make($password);
    }

    /**
     * User to Token relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function token() {
        return $this->hasOne(Token::class, 'user_id');
    }

    /**
     * Generate a Token
     *
     * @param bool $renew
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function generateRefreshToken($renew = false) {
        if ($token = $this->token()->active()->first()) {
            if ($renew) {
                $token->token = str_random(45);
                $token->expiration = Carbon::now()->addMonth(1);
                $token->save();
            }

            return $token;
        }

        return $this->token()->create([
                    "token" => str_random(45),
                    "expiration" => Carbon::now()->addMonth(1)
        ]);
    }

}
