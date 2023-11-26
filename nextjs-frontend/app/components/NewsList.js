// components/NewsList.js

import React, { useState, useEffect } from 'react';
import Link from 'next/link';
import { getAllNews } from '../lib/newsApi';

// Haber listesi bileşeni
const NewsList = () => {
  // Haber listesini saklamak için state kullanılıyor
  const [news, setNews] = useState([]);
  // Temp depodan mı alındığı kontrolü için state kullanılıyor
  const [isFromTempStorage, setIsFromTempStorage] = useState(false);

  // Veri alımı için asenkron bir işlem gerçekleştiren useEffect kullanılıyor
  useEffect(() => {
    const fetchData = async () => {
      // Temp depodan haberleri al
      const newsFromTempStorage = await getAllNews(true);
      // Backend'den tüm haberleri al
      const newsFromBackend = await getAllNews(false);

      // Alınan haberleri state'e setle
      setNews(newsFromTempStorage);
      // Eğer temp depodan haber alındıysa flag'i true olarak setle
      setIsFromTempStorage(newsFromTempStorage.length > 0);

      // Eğer temp depodan haber alınmamışsa, tüm haberleri state'e setle
      if (newsFromTempStorage.length === 0) {
        setNews(newsFromBackend);
        setIsFromTempStorage(false);
      }
    };

    // fetchData fonksiyonunu çağır
    fetchData();
  }, []); // useEffect sadece bir kez çalışsın

  // JSX ile haber listesini render et
  return (
    <div>
      <h1>En Son Haberler</h1>
      {/* Temp depodan alındıysa bilgilendirme mesajını göster */}
      {isFromTempStorage && <p>Temp depodan alınan haberler</p>}
      <ul>
        {/* Haber listesini map fonksiyonu ile dönerek listele */}
        {news.map(item => (
          <li key={item.id}>
            {/* Her bir haberi Link bileşeni ile sayfaya yönlendirme bağlantısı yap */}
            <Link href={`/news/${item.id}`}>
              <a>{item.title}</a>
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
};

// Haber listesi bileşenini dışa aktar
export default NewsList;