<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property int    $user_status
 * @property int    $created_at
 * @property int    $updated_at
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $contact_number
 * @property string $profile_pic_path
 * @property string $userType
 * @property string $introduction
 */
class TblUsers extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'email', 'user_status', 'contact_number', 'profile_pic_path', 'introduction', 'userType', 'created_at', 'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int', 'username' => 'string', 'password' => 'string', 'email' => 'string', 'user_status' => 'int', 'contact_number' => 'string', 'profile_pic_path' => 'string', 'introduction' => 'string', 'userType' => 'string', 'created_at' => 'timestamp', 'updated_at' => 'timestamp'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...

    // Relations ...
}
