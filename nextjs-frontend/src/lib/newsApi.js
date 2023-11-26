// lib/newsApi.js

// Tüm haberleri getiren fonksiyon
export async function getAllNews(useTempStorage = false) {
  try {
    // API'ye istek atılıyor ve haber listesi alınıyor
    const response = await fetch(`http://localhost:8000/api/news?useTempStorage=${useTempStorage}`);
    const { newsList } = await response.json();
    return newsList;
  } catch (error) {
    // Hata durumunda hata mesajı yazdırılıyor ve boş bir dizi döndürülüyor
    console.error('An error occurred while fetching the news:', error);
    return [];
  }
}

// Haber ID'sine göre haber getiren fonksiyon
export async function getNewsById(id) {
  try {
    // API'ye istek at ve belirtilen haber ID'sine ait detay al
    const response = await fetch(`your-backend-api/news/${id}`);
    const newsItem = await response.json();
    return newsItem;
  } catch (error) {
    // Hata durumunda hata mesajı yazdır ve null döndür
    console.error('An error occurred while fetching the news detail:', error);
    return null;
  }
}