import React, { useEffect, useState } from 'react';
import { getNewsById } from '../lib/newsApi';

// NewsDetail bileşeni
const NewsDetail = ({ newsItem }) => {
  // Haber detayını saklamak için state kullanılıyor
  const [loadedNews, setLoadedNews] = useState(newsItem);

  // Sayfa yüklendiğinde haber detayını alacak useEffect kullanılıyor
  useEffect(() => {
    // Eğer haber detayı zaten varsa tekrar API çağrısı yapma
    if (loadedNews) {
      return;
    }

    // getNewsById fonksiyonunu kullanarak haber detayını al
    const fetchNewsDetail = async () => {
      try {
        const response = await getNewsById(newsItem.id);
        // Alınan haber detayını state'e setle
        setLoadedNews(response);
      } catch (error) {
        console.error('Haber detayını getirirken bir hata oluştu:', error);
      }
    };

    // fetchNewsDetail fonksiyonunu çağır
    fetchNewsDetail();
  }, [loadedNews, newsItem.id]); // useEffect, loadedNews veya newsItem.id değiştiğinde çalışsın

  // Alınan haber detayını JSX ile render et
  return (
    <div>
      {/* loadedNews varsa bilgileri görüntüle, yoksa yükleniyor mesajını göster */}
      {loadedNews ? (
        <>
          <h2>{loadedNews.title}</h2>
          <p>{loadedNews.content}</p>
        </>
      ) : (
        <p>Loading news...</p>
      )}
    </div>
  );
};

// NewsDetail bileşenini dışa aktar
export default NewsDetail;