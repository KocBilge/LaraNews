// pages/news/[id].js

import React from 'react';
import { useRouter } from 'next/router';
import NewsDetail from '../../components/NewsDetail';
import { getNewsById } from '../../lib/newsApi';

// Haber detay sayfası bileşeni
const NewsDetailPage = ({ newsItem }) => {
  const router = useRouter();
  const { id } = router.query;

  return (
    <div>
      <h1>Haber Detayı</h1>
      {/* NewsDetail bileşenine haber detayını ileterek render et */}
      <NewsDetail newsItem={newsItem} />
    </div>
  );
};

// Haber detay sayfasının statik yollarını belirleyen fonksiyon
export async function getStaticPaths() {
  // Örnek olarak bir haber ID'si belirt
  const paths = [{ params: { id: '1' } }];
  return {
    paths,
    fallback: false,
  };
}

// Haber detay sayfasının statik verilerini belirleyen fonksiyon
export async function getStaticProps({ params }) {
  // Belirtilen haber ID'sine göre haber detayını getir
  const newsItem = await getNewsById(params.id);
  return {
    props: {
      newsItem,
    },
  };
}

export default NewsDetailPage;