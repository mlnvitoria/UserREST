<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Tag(
 *   name="Customer",
 *   description="Operations about customer",
 * )
 *
 * @OA\Schema(
 *      @OA\Xml(name="Customer"),
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="birthdate", type="string", format="date"),
 *      @OA\Property(property="enabled", type="boolean"),
 *      @OA\Property(property="name", type="string")
 * )
 * */
class Customer extends ModelAbstract
{
    use SoftDeletes;
    

    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'birthdate',
        'enabled',
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
            'name' => ['required', 'min:2', 'max:100'],
            'birthdate' => ['required', 'date', 'before:today'],
            'enabled' => 'boolean',
        ],
        'update' => [
            'name' => ['min:2', 'max:100'],
            'birthdate' => ['date', 'before:today'],
            'enabled' => 'boolean',
        ],
    ];
}