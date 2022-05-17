<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $phone
 * @property string $description
 * @property User $user
 */
class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'title',
        'phone',
        'description',
    ];

    /**
     * User owner relationship
     *
     * @return BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
