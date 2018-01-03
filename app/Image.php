<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 21/11/2017
 * Time: 6:55 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_name'];

    public function type()
    {
        return $this->belongsTo('App\ImageType', 'image_type_id');
    }
}