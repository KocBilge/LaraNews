// pages/index.js

import React from 'react';
import Link from 'next/link';
import NewsList from '../components/NewsList';
import { getAllNews } from '../lib/newsApi';

// Anasayfa bileşeni
const HomePage = ({ news }) => {
  return (
    <div>
      <h1>En Son Haberler</h1>
      {/* NewsList bileşenine haber listesini ileterek render et */}
      <NewsList news={news} />
    </div>
  );
};

// Anasayfa bileşeninin statik verilerini belirleyen fonksiyon
export async function getStaticProps() {
  // Tüm haberleri getir
  const news = await getAllNews();
  return {
    props: {
      news,
    },
  };
}

export default HomePage;