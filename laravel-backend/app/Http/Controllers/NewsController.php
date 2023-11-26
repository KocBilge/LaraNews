<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\NewsServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Services\Contracts\NewsServiceContract;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(\App\Services\NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Haber listesini getirir.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // useTempStorage parametresini sorgudan alır, varsayılan olarak false olarak ayarlanmıştır.
            $useTempStorage = $request->query('useTempStorage', false);
            
            // Tüm haberleri veritabanından seçer.
            $newsList = News::select('id', 'title', 'content')->get();
            
            if ($useTempStorage) {
                // Eğer useTempStorage parametresi true ise, geçici depodan haberleri getirir.
                return response()->json(['newsList' => $newsList], 200);
            }

            // Eğer useTempStorage parametresi false veya belirtilmemişse, tüm haberleri getirir.
            return response()->json(['newsList' => $newsList], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Kullanıcının bildirimlerini getirir.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications()
    {
        try {
            // Auth kütüphanesini kullanarak kullanıcının kimlik bilgilerini alır.
            $notifications = Notify::where('news_id', auth()->user()->id)->get();
            return response()->json($notifications);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Yeni bir haber öğesi oluşturur ve önbelleğe ekler.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Yeni bir haber öğesi oluşturur ve önbelleğe ekler.
            $newNewsItem = News::create($request->only(['title', 'content']));
            $this->newsService->cacheNews($newNewsItem);

            // Günlük özet e-postasını gönderir.
            $this->newsService->sendDailySummary();

            return response()->json($newNewsItem, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Belirli bir haber öğesini getirir.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            // Belirli bir haber öğesini veritabanından seçer.
            $newsItem = News::find($id);

            if (!$newsItem) {
                return response()->json(['error' => 'Not found news.'], 404);
            }

            return response()->json($newsItem, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Belirli bir haber öğesini günceller.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Belirli bir haber öğesini günceller.
            $existingNewsItem = News::find($id);

            if (!$existingNewsItem) {
                return response()->json(['error' => 'Not found news.'], 404);
            }

            $existingNewsItem->update($request->only(['title', 'content']));

            // Haber önbelleğini temizler ve günceller.
            $this->newsService->clearAndCacheNews();

            return response()->json($existingNewsItem);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Belirli bir haber öğesini siler.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $newsItem = News::find($id);

            if (!$newsItem) {
                return response()->json(['error' => 'Not found news.'], 404);
            }

            $newsItem->delete();

            // Haber önbelleğini temizler.
            $this->newsService->clearCachedNews();

            return response()->json(['message' => 'News successfully deleted.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
