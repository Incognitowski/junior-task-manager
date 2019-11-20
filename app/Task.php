<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Task extends Model
{
    protected $table = 'tasks';

    protected $primaryKey = 'id';

    protected $fillable = [
        'description',
        'user_id',
        'deadline'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:d/m/Y',
        'deadline' => 'datetime:d/m/Y',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
