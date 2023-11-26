<?php

namespace App\Services;

use App\Models\News;
use App\Notifications\NewNewsNotification;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class NewsService
{
    /**
     * Haberleri önbellekten alır veya önbelleğe ekler ve döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNews()
    {
        return cache()->remember('news', now()->addMinutes(10), function () {
            return News::all();
        });
    }

    /**
     * Yeni bir haber öğesini önbelleğe ekler.
     *
     * @param \App\Models\News $newNewsItem
     * @return void
     */
    public function cacheNews($newNewsItem)
    {
        $news = $this->getCachedNews();
        $news[] = $newNewsItem;

        cache()->put('news', $news, now()->addMinutes(10));
    }

    /**
     * Önbellekteki haberleri döndürür.
     *
     * @return array
     */
    public function getCachedNews()
    {
        return cache()->get('news', []);
    }

    /**
     * Günlük özet e-postasını hazırlar ve ilgili kullanıcılara bildirim gönderir.
     *
     * @return void
     */
    public function sendDailySummary()
    {
        $todayNews = News::whereDate('created_at', today())->get();

        if ($todayNews->isEmpty()) {
            return;
        }

        $users = $this->getNotificationUsers();
        foreach ($users as $user) {
            $user->notify(new NewNewsNotification($todayNews));
        }
    }

    /**
     * Bildirim alacak kullanıcıları döndürür.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getNotificationUsers()
    {
        return User::all();
    }
}
