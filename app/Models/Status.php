<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * @return array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
