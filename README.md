# LaraNews

Bu proje, Next.js ve Laravel uygulamalarını içermektedir ve kullanıcılara güncel haberleri görüntüleme ve keşfetme imkanı sunar. Temel amacı, kullanıcılara güncel haberleri sağlamak ve haber detaylarını göstermektir.

## Özellikler

### Backend (Laravel)

1. **E-Posta Bildirimleri:**
   - Yeni bir haber,makale eklendiğinde kullanıcılara e-posta bildirimleri gönderir.
   - Günlük rutin, o gün eklenen tüm haberlerin özetini derleyip belirtilen e-posta adresine gönderir.

2. **Önbellek Mekanizması:**
   - Veritabanından alınan haberleri geçici olarak saklayarak sonraki isteklerde hızlı erişim için kullanır.

3. **Haber İşlemleri:**
   - Haber ekleme, güncelleme ve silme gibi işlemleri yönetir.
   - Bu işlemlere karşılık gelen bildirimleri gönderir.

### Frontend (Next.js)

1. **Kullanıcı Arayüzü:**
   - Haber listesini ana sayfada görüntüler.
   - Her bir haberin detaylarını görmek için haberlere tıklayabilirsiniz.
   - Haberlerin geçici depodan mı yoksa backend'den mi alındığını gösteren bir gösterge içerir.

## Nasıl Kullanılır

1. **Haber Listesi:**
   - En son haberlere ana sayfadan göz atın.
   - Her bir haberin detaylarına ulaşmak için üzerine tıklayın.

2. **Haber Ekle:**
   - Yeni bir makale eklemek için "Haber Ekle" sayfasını ziyaret edin.
   - Başlık ve içerik bilgilerini girin ve haber eklemek için "Kaydet"e tıklayın.

3. **Haber Güncelleme ve Silme:**
   - Haber detay sayfasındaki "Güncelle" veya "Sil" düğmelerini kullanarak haberleri yönetin.

---
