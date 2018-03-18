<?php namespace Bantenprov\Layanan\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The LayananModel class.
 *
 * @package Bantenprov\Layanan
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class LayananModel extends Model
{
    /**
    * Table name.
    *
    * @var string
    */
    protected $table = 'layanan';

    /**
    * The attributes that are mass assignable.
    *
    * @var mixed
    */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
