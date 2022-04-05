-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3307
-- Üretim Zamanı: 05 Nis 2022, 01:57:50
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
  `bransTur` varchar(255) NOT NULL,
  `fakulteID` int(11) NOT NULL,
  `birimID` int(11) NOT NULL,
  `kullaniciIP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `anketcevaplar`
--

INSERT INTO `anketcevaplar` (`id`, `anketID`, `serialize`, `bransTur`, `fakulteID`, `birimID`, `kullaniciIP`) VALUES
(1, 21, 'a:1:{i:0;a:2:{i:0;s:3:\"1-A\";i:1;s:3:\"2-B\";}}', '', 0, 0, '::1'),
(2, 21, 'a:1:{i:1;a:5:{i:0;s:3:\"1-B\";i:1;s:3:\"2-A\";i:2;s:3:\"3-B\";i:3;s:3:\"4-B\";i:4;s:3:\"5-A\";}}', '', 0, 0, '::1'),
(3, 18, 'a:2:{i:0;a:3:{i:0;s:3:\"1-A\";i:1;s:3:\"2-B\";i:2;s:3:\"3-C\";}i:1;a:2:{i:0;s:6:\"1-Evet\";i:1;s:14:\"2-Kısmen evet\";}}', '', 0, 0, '::1'),
(4, 18, 'a:2:{i:0;a:3:{i:0;s:3:\"1-C\";i:1;s:3:\"2-C\";i:2;s:3:\"3-C\";}i:1;a:2:{i:0;s:16:\"1-Kısmen hayır\";i:1;s:16:\"2-Kısmen hayır\";}}', '', 0, 0, '::1'),
(5, 21, 'a:2:{i:0;a:8:{i:0;s:3:\"1-B\";i:1;s:3:\"2-B\";i:2;s:3:\"3-B\";i:3;s:3:\"4-B\";i:4;s:3:\"5-B\";i:5;s:3:\"6-B\";i:6;s:3:\"7-B\";i:7;s:3:\"8-B\";}i:1;a:5:{i:0;s:3:\"1-B\";i:1;s:3:\"2-B\";i:2;s:3:\"3-B\";i:3;s:3:\"4-B\";i:4;s:3:\"5-B\";}}', '', 0, 0, '::1'),
(6, 21, 'a:1:{i:1;a:1:{i:4;s:3:\"5-B\";}}', '', 0, 0, '::1'),
(7, 18, 'a:2:{i:0;a:3:{i:0;s:3:\"1-A\";i:1;s:3:\"2-B\";i:2;s:3:\"3-A\";}i:1;a:2:{i:0;s:14:\"1-Kısmen evet\";i:1;s:14:\"2-Kısmen evet\";}}', '', 0, 0, '::1'),
(8, 18, 'a:2:{i:0;a:3:{i:0;s:3:\"1-A\";i:1;s:3:\"2-B\";i:2;s:3:\"3-A\";}i:1;a:2:{i:0;s:14:\"1-Kısmen evet\";i:1;s:14:\"2-Kısmen evet\";}}', '', 0, 0, '::1'),
(9, 21, 'a:2:{i:0;a:8:{i:0;s:3:\"1-A\";i:1;s:3:\"2-B\";i:2;s:3:\"3-B\";i:3;s:3:\"4-B\";i:4;s:3:\"5-B\";i:5;s:3:\"6-B\";i:6;s:3:\"7-C\";i:7;s:3:\"8-C\";}i:1;a:5:{i:0;s:3:\"1-D\";i:1;s:3:\"2-D\";i:2;s:3:\"3-D\";i:3;s:3:\"4-D\";i:4;s:3:\"5-D\";}}', '', 0, 0, '::1'),
(10, 21, 'a:2:{i:0;a:7:{i:0;s:3:\"1-D\";i:1;s:3:\"2-D\";i:2;s:3:\"3-D\";i:3;s:3:\"4-D\";i:5;s:3:\"6-D\";i:6;s:3:\"7-D\";i:7;s:3:\"8-D\";}i:1;a:5:{i:0;s:3:\"1-D\";i:1;s:3:\"2-D\";i:2;s:3:\"3-D\";i:3;s:3:\"4-D\";i:4;s:3:\"5-D\";}}', '', 0, 0, '::1'),
(11, 21, 'a:1:{i:0;a:3:{i:3;s:3:\"4-D\";i:4;s:3:\"5-D\";i:5;s:3:\"6-D\";}}', '', 0, 0, '::1'),
(12, 18, 'a:2:{i:0;a:4:{i:0;s:3:\"1-A\";i:1;s:3:\"2-A\";i:2;s:3:\"3-A\";i:3;s:3:\"4-A\";}i:1;a:2:{i:0;s:6:\"1-Evet\";i:1;s:6:\"2-Evet\";}}', '', 0, 0, '::1'),
(13, 18, 'a:2:{i:0;a:4:{i:0;s:3:\"1-A\";i:1;s:3:\"2-A\";i:2;s:3:\"3-A\";i:3;s:3:\"4-A\";}i:1;a:2:{i:0;s:6:\"1-Evet\";i:1;s:6:\"2-Evet\";}}', 'ogrenci', 1, 1, '::1'),
(14, 18, 'a:2:{i:0;a:4:{i:0;s:3:\"1-A\";i:1;s:3:\"2-A\";i:2;s:3:\"3-A\";i:3;s:3:\"4-A\";}i:1;a:2:{i:0;s:6:\"1-Evet\";i:1;s:6:\"2-Evet\";}}', 'idari', 1, 0, '::1'),
(15, 52, 'a:1:{i:0;a:1:{i:0;s:7:\"1-awdaw\";}}', 'idari', 2, 0, '::1');

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
  `anketKitle` varchar(255) NOT NULL,
  `anketGiris` tinyint(1) NOT NULL,
  `serialize` text NOT NULL,
  `onay` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `anketler`
--

INSERT INTO `anketler` (`id`, `yoneticiID`, `baslik`, `metin`, `aciklama`, `anketKitle`, `anketGiris`, `serialize`, `onay`) VALUES
(31, 3, 'ANKET BAŞLIĞI', 'Anket üst bilgisini giriniz', 'Anket hakkında açıklama yapınız.', '', 0, 'a:3:{i:0;a:3:{i:0;a:3:{i:0;s:12:\"rgb(0, 0, 0)\";i:1;s:17:\"Group Başlığı\";i:2;s:23:\"Detay bilgisini giriniz\";}i:1;a:1:{i:0;s:0:\"\";}i:2;a:1:{i:0;a:2:{i:0;s:0:\"\";i:1;s:4:\"true\";}}}i:1;a:3:{i:0;a:3:{i:0;s:12:\"rgb(0, 0, 0)\";i:1;s:17:\"Group Başlığı\";i:2;s:23:\"Detay bilgisini giriniz\";}i:1;a:1:{i:0;s:0:\"\";}i:2;a:1:{i:0;a:2:{i:0;s:0:\"\";i:1;s:4:\"true\";}}}i:2;a:3:{i:0;a:3:{i:0;s:12:\"rgb(0, 0, 0)\";i:1;s:17:\"Group Başlığı\";i:2;s:23:\"Detay bilgisini giriniz\";}i:1;a:1:{i:0;s:0:\"\";}i:2;a:1:{i:0;a:2:{i:0;s:0:\"\";i:1;s:4:\"true\";}}}}', 1),
(52, 3, 'dwadaw', 'dawdaw', 'dawdaw', 'idari', 0, 'a:1:{i:0;a:3:{i:0;a:3:{i:0;s:12:\"rgb(0, 0, 0)\";i:1;s:7:\"dawdawd\";i:2;s:6:\"dwadaw\";}i:1;a:1:{i:0;s:5:\"awdaw\";}i:2;a:1:{i:0;a:2:{i:0;s:0:\"\";i:1;s:4:\"true\";}}}}', 1);

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
(8, 'icabitr@gmail.com', 1);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `anketler`
--
ALTER TABLE `anketler`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
