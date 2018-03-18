<?php

namespace Bantenprov\Layanan\Models\Bantenprov\Layanan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'layanans';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'group_egovernment_id',
        'user_id',
        'label',
        'description'
    ];

    public function group_egovernment()
    {
        return $this->belongsTo('Bantenprov\GroupEgovernment\Models\Bantenprov\GroupEgovernment\GroupEgovernment','group_egovernment_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
