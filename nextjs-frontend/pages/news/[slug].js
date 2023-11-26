import { useRouter } from 'next/router';
import { useEffect, useState } from 'react';
import axios from 'axios';

const NewsDetailPage = () => {
  const router = useRouter();
  const { slug } = router.query;
  const [news, setNews] = useState(null);
  const [useTempStorage, setUseTempStorage] = useState(false);

  useEffect(() => {
    // `[slug]` parametresine sahip haberin detayını almak için API isteği yapılıyor.
    const fetchNewsDetail = async () => {
      try {
        const response = await axios.get(`/api/news/${slug}`);
        setNews(response.data);
      } catch (error) {
        console.error('Haber detayını getirirken bir hata oluştu:', error);
      }
    };

    // Eğer slug değeri varsa ve useTempStorage false ise haber detayını getir.
    if (slug && !useTempStorage) {
      fetchNewsDetail();
    }
  }, [slug, useTempStorage]);

  if (!news && !useTempStorage) {
    // Eğer haber detayları yükleniyor ve temp storage kullanılmıyorsa loading mesajı göster.
    return <p>Haber yükleniyor...</p>;
  }

  return (
    <div>
      {news && (
        <>
          <h1>{news.title}</h1>
          <p>{news.content}</p>
        </>
      )}

      {/* Haber detayı yüklenmediyse ve temp storage kullanılıyorsa bir mesaj göster. */}
      {!news && useTempStorage && <p>Temp storage'dan haber detayı alınıyor...</p>}
    </div>
  );
};

export default NewsDetailPage;
