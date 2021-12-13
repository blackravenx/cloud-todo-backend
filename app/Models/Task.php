<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $visible = ['id', 'title', 'description', 'complete_till', 'creator_id', 'creator', 'status', 'created_at'];
    protected $fillable = ['title', 'description', 'complete_till', 'creator_id', 'status'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id')->without('tasks');
    }
}
