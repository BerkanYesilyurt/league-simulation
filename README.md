
# Şampiyonlar Ligi / Simülasyon

Bu proje, Laravel ve Vue.js kullanılarak geliştirilen Şampiyonlar Ligi simülasyon sistemidir. Takım listeleme, fikstür oluşturma, maç simülasyonu gibi temel işlevlerin yanı sıra, skor tablosu ve şampiyonluk tahminleri gibi analiz özelliklerini de içermektedir. 


## Özellikler

- Takım listesinin görüntülenmesi
- Dengeli ve rastgele fikstür oluşturma algoritması
- Oluşturulan fikstürün detaylı şekilde listelenmesi
- Güncel skor tablosunun takip edilmesi
- Haftalık maçların ve sonuçların görüntülenmesi
- Maç sonuçlarına göre şampiyonluk olasılıklarının tahmin edilmesi
- Haftalık maç simülasyonlarının çalıştırılması
- Tüm sezonu tek tıklamayla simüle etme seçeneği
- Maç sonuçlarını haftalara göre inceleme imkânı
- İnteraktif kullanıcı deneyimi ve anlık veri güncellemeleri
  
## Teknolojiler

- Laravel
- Vue.js (Vite, Axios ile birlikte)

  
## Başlarken

Projeyi klonlayın.

```bash
  git clone <url>
```

Proje dizinine gidin.

```bash
  cd league
```

Servislerin imajlarını oluşturun ve bu servisleri çalıştırarak uygulamayı başlatın.

```bash
  docker-compose up --build
```
## Manuel Kurulum Adımları (Docker kullanılmadığında)

- Proje kök dizininde bulunan .env.example dosyasını kopyalayarak .env dosyasını oluşturun.
- .env dosyasında yer alan aşağıdaki alanları, kendi yerel veritabanı bilgilerinizle güncelleyin.
- Composer ile PHP bağımlılıklarını yükleyin. (```composer install```)
- Proje dizininde aşağıdaki komutla JavaScript bağımlılıklarını yükleyin. (```npm install```)
- Laravel uygulaması için gerekli application keyi oluşturun. (```php artisan key:generate```)
- Migration ve seed işlemlerini çalıştırarak veritabanını başlatın. (```php artisan migrate --seed```)
- Composer ile PHP bağımlılıklarını yükleyin. (```composer install```)
- Geliştirme sunucusunu başlatın. (```php artisan serve - npm run dev```)