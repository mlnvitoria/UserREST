<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


/**
 * @OA\Tag(
 *   name="user",
 *   description="Operations about user",
 * )
 *
 * @OA\Schema(
 *      @OA\Xml(name="User"),
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="firstname", type="string"),
 *      @OA\Property(property="lastname", type="string"),
 *      @OA\Property(property="email", type="string"),
 *      @OA\Property(property="api_token", type="string")
 * )
 * */
class User extends ModelAbstract implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
    ];

    protected $rules = [
        'store' => [
            'firstname' => ['required', 'min:2', 'max:100'],
            'lastname' => ['required', 'min:2', 'max:100'],
            'email' => ['required','email:rfc,dns'],
        ],
        'update' => [
            'firstname' => ['min:2', 'max:100'],
            'lastname' => ['min:2', 'max:100'],
            'email' => ['email:rfc,dns'],
        ], 
    ];
}
