<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * Haberin sahibi olan kullanıcıyı temsil eden ilişki.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bu haber ile ilişkili bildirimleri temsil eden ilişki.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifies()
    {
        return $this->hasMany(Notify::class, 'news_id', 'id');
    }
}
