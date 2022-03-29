-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3307
-- Üretim Zamanı: 29 Mar 2022, 14:18:11
-- Sunucu sürümü: 10.4.19-MariaDB
-- PHP Sürümü: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `klu_anket`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anketcevaplar`
--

CREATE TABLE `anketcevaplar` (
  `id` int(11) UNSIGNED NOT NULL,
  `anketID` int(11) UNSIGNED NOT NULL,
  `serialize` text NOT NULL,
  `kullaniciIP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `anketcevaplar`
--

INSERT INTO `anketcevaplar` (`id`, `anketID`, `serialize`, `kullaniciIP`) VALUES
(1, 21, 'a:1:{i:0;a:2:{i:0;s:3:\"1-A\";i:1;s:3:\"2-B\";}}', '::1'),
(2, 21, 'a:1:{i:1;a:5:{i:0;s:3:\"1-B\";i:1;s:3:\"2-A\";i:2;s:3:\"3-B\";i:3;s:3:\"4-B\";i:4;s:3:\"5-A\";}}', '::1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anketler`
--

CREATE TABLE `anketler` (
  `id` int(11) UNSIGNED NOT NULL,
  `yoneticiID` int(11) UNSIGNED NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `metin` text NOT NULL,
  `aciklama` text NOT NULL,
  `serialize` text NOT NULL,
  `onay` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `anketler`
--

INSERT INTO `anketler` (`id`, `yoneticiID`, `baslik`, `metin`, `aciklama`, `serialize`, `onay`) VALUES
(18, 3, '2. Anket Deneme Töreni', 'Detaylar ana sayfada sizlerle olucaktır.', '', 'a:2:{i:0;a:3:{i:0;a:3:{i:0;s:12:\"rgb(0, 0, 0)\";i:1;s:17:\"Group Başlığı\";i:2;s:0:\"\";}i:1;a:4:{i:0;s:1:\"A\";i:1;s:1:\"B\";i:2;s:1:\"C\";i:3;s:1:\"D\";}i:2;a:3:{i:0;a:2:{i:0;s:20:\"Kim daha büyüktür\";i:1;s:4:\"true\";}i:1;a:2:{i:0;s:32:\"Hangisi Alfabede en başa gelir.\";i:1;s:4:\"true\";}i:2;a:2:{i:0;s:42:\"Dersi geçmek için en iyi not hangisidir.\";i:1;s:4:\"true\";}}}i:1;a:3:{i:0;a:3:{i:0;s:14:\"rgb(0, 0, 255)\";i:1;s:5:\"Zafer\";i:2;s:57:\"Bu kısımda zaferle alakalı bir kaç veri verilecektir.\";}i:1;a:4:{i:0;s:4:\"Evet\";i:1;s:12:\"Kısmen evet\";i:2;s:14:\"Kısmen hayır\";i:3;s:6:\"Hayır\";}i:2;a:2:{i:0;a:2:{i:0;s:40:\"Zafer kazanmakla aynı anlamda mıdır ?\";i:1;s:4:\"true\";}i:1;a:2:{i:0;s:36:\"Zafer için her şey mubah mıdır ?\";i:1;s:4:\"true\";}}}}', 1),
(21, 3, '3. Anket Girişimi', 'Değerli Akademik Personelimiz, \n\nAşağıda sunulan anket, Kırklareli üniversitesi \nbla bla bla bla bla bla bla\n', 'Anket 5 şıktan oluşmakta ve şıkları doğru işaretlerseniz seviniriz.', 'a:2:{i:0;a:3:{i:0;a:3:{i:0;s:14:\"rgb(0, 0, 255)\";i:1;s:12:\"Soru grubu 1\";i:2;s:0:\"\";}i:1;a:4:{i:0;s:1:\"A\";i:1;s:1:\"B\";i:2;s:1:\"C\";i:3;s:1:\"D\";}i:2;a:8:{i:0;a:2:{i:0;s:9:\"İlk Soru\";i:1;s:4:\"true\";}i:1;a:2:{i:0;s:12:\"İkinci Soru\";i:1;s:4:\"true\";}i:2;a:2:{i:0;s:11:\"Ucuncu Soru\";i:1;s:4:\"true\";}i:3;a:2:{i:0;s:9:\"Dort Soru\";i:1;s:4:\"true\";}i:4;a:2:{i:0;s:9:\"Beş Soru\";i:1;s:4:\"true\";}i:5;a:2:{i:0;s:10:\"Altı Soru\";i:1;s:4:\"true\";}i:6;a:2:{i:0;s:9:\"Yedi Soru\";i:1;s:4:\"true\";}i:7;a:2:{i:0;s:10:\"Sekiz Soru\";i:1;s:4:\"true\";}}}i:1;a:3:{i:0;a:3:{i:0;s:16:\"rgb(255, 0, 255)\";i:1;s:5:\"Zafer\";i:2;s:51:\"Bu kısımda zafer konulu şeyler konuşulacaktır.\";}i:1;a:4:{i:0;s:1:\"A\";i:1;s:1:\"B\";i:2;s:1:\"C\";i:3;s:1:\"D\";}i:2;a:5:{i:0;a:2:{i:0;s:6:\"Soru 1\";i:1;s:4:\"true\";}i:1;a:2:{i:0;s:6:\"Soru 2\";i:1;s:4:\"true\";}i:2;a:2:{i:0;s:6:\"Soru 3\";i:1;s:4:\"true\";}i:3;a:2:{i:0;s:6:\"Soru 4\";i:1;s:4:\"true\";}i:4;a:2:{i:0;s:6:\"Soru 5\";i:1;s:4:\"true\";}}}}', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `id` int(11) NOT NULL,
  `SiteLinki` varchar(255) NOT NULL,
  `siteAnketMetni` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `SiteLinki`, `siteAnketMetni`) VALUES
(1, 'https://localhost/Klu_Anket/', 'https://localhost/Klu_Anket/');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler`
--

CREATE TABLE `uyeler` (
  `id` int(11) NOT NULL,
  `emailAdresi` varchar(255) NOT NULL,
  `yonetimFaktoru` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `uyeler`
--

INSERT INTO `uyeler` (`id`, `emailAdresi`, `yonetimFaktoru`) VALUES
(3, 'icabikrz@gmail.com', 1),
(8, 'icabitr@gmail.com', 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anketcevaplar`
--
ALTER TABLE `anketcevaplar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `anketler`
--
ALTER TABLE `anketler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uyeler`
--
ALTER TABLE `uyeler`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anketcevaplar`
--
ALTER TABLE `anketcevaplar`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `anketler`
--
ALTER TABLE `anketler`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
