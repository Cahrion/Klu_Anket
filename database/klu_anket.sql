-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3307
-- Üretim Zamanı: 08 Nis 2022, 14:31:36
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
  `anketGorus` text NOT NULL,
  `bransTur` varchar(255) NOT NULL,
  `fakulteID` int(11) NOT NULL,
  `birimID` int(11) NOT NULL,
  `kullaniciIP` varchar(255) NOT NULL,
  `gonderimTarihi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `anketGorus` tinyint(3) UNSIGNED NOT NULL,
  `serialize` text NOT NULL,
  `onay` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `anketler`
--

INSERT INTO `anketler` (`id`, `yoneticiID`, `baslik`, `metin`, `aciklama`, `anketKitle`, `anketGiris`, `anketGorus`, `serialize`, `onay`) VALUES
(64, 3, 'Anket 1', 'Anket üst bilgisi 1', 'Anket Açıklama 1', 'idari', 1, 1, 'a:2:{i:0;a:3:{i:0;a:3:{i:0;s:18:\"rgb(126, 189, 255)\";i:1;s:33:\"Analiz için farklı isimlendirme\";i:2;s:7:\"Detay 1\";}i:1;a:5:{i:0;s:1:\"A\";i:1;s:1:\"B\";i:2;s:1:\"C\";i:3;s:1:\"D\";i:4;s:0:\"\";}i:2;a:2:{i:0;a:2:{i:0;s:6:\"Soru 1\";i:1;s:5:\"false\";}i:1;a:2:{i:0;s:6:\"Soru 2\";i:1;s:5:\"false\";}}}i:1;a:3:{i:0;a:3:{i:0;s:18:\"rgb(234, 228, 135)\";i:1;s:6:\"Grup 2\";i:2;s:7:\"Detay 2\";}i:1;a:5:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";}i:2;a:12:{i:0;a:2:{i:0;s:6:\"Soru 1\";i:1;s:5:\"false\";}i:1;a:2:{i:0;s:6:\"Soru 2\";i:1;s:5:\"false\";}i:2;a:2:{i:0;s:6:\"Soru 3\";i:1;s:5:\"false\";}i:3;a:2:{i:0;s:6:\"Soru 4\";i:1;s:5:\"false\";}i:4;a:2:{i:0;s:6:\"Soru 5\";i:1;s:5:\"false\";}i:5;a:2:{i:0;s:6:\"Soru 6\";i:1;s:5:\"false\";}i:6;a:2:{i:0;s:0:\"\";i:1;s:5:\"false\";}i:7;a:2:{i:0;s:0:\"\";i:1;s:5:\"false\";}i:8;a:2:{i:0;s:0:\"\";i:1;s:5:\"false\";}i:9;a:2:{i:0;s:0:\"\";i:1;s:5:\"false\";}i:10;a:2:{i:0;s:0:\"\";i:1;s:5:\"false\";}i:11;a:2:{i:0;s:0:\"\";i:1;s:5:\"false\";}}}}', 1),
(65, 3, 'awdawdaw', 'wdawd', 'da', 'idari', 0, 0, 'a:1:{i:0;a:3:{i:0;a:3:{i:0;s:18:\"rgb(168, 234, 135)\";i:1;s:6:\"dawdaw\";i:2;s:6:\"dawdaw\";}i:1;a:1:{i:0;s:0:\"\";}i:2;a:1:{i:0;a:2:{i:0;s:0:\"\";i:1;s:5:\"false\";}}}}', 1),
(66, 3, 'dawdaw', 'dawdaw', 'dawdaw', 'idari', 1, 0, 'a:1:{i:0;a:3:{i:0;a:3:{i:0;s:18:\"rgb(168, 234, 135)\";i:1;s:6:\"dwadaw\";i:2;s:4:\"dawd\";}i:1;a:1:{i:0;s:6:\"dawdaw\";}i:2;a:1:{i:0;a:2:{i:0;s:6:\"dwadaw\";i:1;s:4:\"true\";}}}}', 1),
(67, 3, 'dawdaw', 'dwadaw', 'dwadwa', 'akademik', 1, 0, 'a:1:{i:0;a:3:{i:0;a:3:{i:0;s:18:\"rgb(168, 234, 135)\";i:1;s:6:\"dawdaw\";i:2;s:6:\"dwadwa\";}i:1;a:1:{i:0;s:6:\"dawdaw\";}i:2;a:1:{i:0;a:2:{i:0;s:6:\"awdawd\";i:1;s:4:\"true\";}}}}', 1),
(68, 3, 'dawdaw', 'dwadwa', 'wdadaw', 'akademik', 0, 0, 'a:1:{i:0;a:3:{i:0;a:3:{i:0;s:18:\"rgb(168, 234, 135)\";i:1;s:4:\"dawd\";i:2;s:9:\"awdawdawd\";}i:1;a:1:{i:0;s:6:\"dawdaw\";}i:2;a:1:{i:0;a:2:{i:0;s:6:\"dwadaw\";i:1;s:4:\"true\";}}}}', 1),
(69, 3, 'awdawdaw', 'wdad', 'awdawd', 'akademik', 1, 1, 'a:1:{i:0;a:3:{i:0;a:3:{i:0;s:18:\"rgb(168, 234, 135)\";i:1;s:4:\"dawd\";i:2;s:8:\"awdawdaw\";}i:1;a:1:{i:0;s:0:\"\";}i:2;a:1:{i:0;a:2:{i:0;s:6:\"dawdaw\";i:1;s:4:\"true\";}}}}', 1),
(70, 3, 'dawdaw', 'awdaw', 'dwad', 'akademik', 1, 0, 'a:1:{i:0;a:3:{i:0;a:3:{i:0;s:17:\"rgb(124, 100, 73)\";i:1;s:6:\"dawdaw\";i:2;s:5:\"awdaw\";}i:1;a:1:{i:0;s:0:\"\";}i:2;a:1:{i:0;a:2:{i:0;s:7:\"dwadwad\";i:1;s:4:\"true\";}}}}', 1);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Tablo için AUTO_INCREMENT değeri `anketler`
--
ALTER TABLE `anketler`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
