<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    protected $fillable = ['content'];

    /*
     *  声明这个动态所属的用户
     * @return array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
