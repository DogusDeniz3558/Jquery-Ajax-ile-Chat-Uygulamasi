-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 23 May 2023, 20:04:39
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `chat-uygulamasi`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `chats`
--

CREATE TABLE `chats` (
  `ID` int(11) NOT NULL,
  `gonderici_id` int(11) NOT NULL,
  `alici_id` int(11) NOT NULL,
  `mesaj` longtext NOT NULL,
  `gonderilme_zamani` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `chats`
--

INSERT INTO `chats` (`ID`, `gonderici_id`, `alici_id`, `mesaj`, `gonderilme_zamani`) VALUES
(8, 1, 3, 'Aşkım Naber', '15:45'),
(9, 3, 1, 'İyi oturuyorum canım senn ', '15:46'),
(10, 1, 3, 'İyi bende evdeyim kod yazıyorum', '15:45'),
(11, 3, 1, 'Kolay gelsin canım', '15:46'),
(18, 1, 2, 'Gardaşım Napıyon', '2023-05-22 23:52:58'),
(23, 1, 2, 'Nasıl Gidiyor', '2023-05-23 20:05:50'),
(24, 2, 1, 'İyi kanka senden naber', '2023-05-23 20:06:37'),
(25, 1, 2, 'iyi bende aynı nolsun', '2023-05-23 20:06:49'),
(26, 2, 1, 'MLBB ?', '2023-05-23 20:08:08'),
(27, 1, 2, 'Birazdan olabilir neden olmasın', '2023-05-23 20:08:23'),
(28, 2, 1, 'Tamam haberleşiriz', '2023-05-23 20:10:33'),
(29, 1, 2, 'Tamam', '2023-05-23 20:12:03');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `Kullanici_ID` int(11) NOT NULL,
  `Kullanici_adi` varchar(250) NOT NULL,
  `Kullanici_AdSoyad` varchar(250) NOT NULL,
  `Kullanici_Sifre` varchar(250) NOT NULL,
  `Kullanici_Eposta` varchar(250) NOT NULL,
  `Kullanici_Cinsiyet` varchar(6) NOT NULL,
  `Kullanici_Dtarihi` varchar(250) NOT NULL,
  `Kullanici_Avatar` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`Kullanici_ID`, `Kullanici_adi`, `Kullanici_AdSoyad`, `Kullanici_Sifre`, `Kullanici_Eposta`, `Kullanici_Cinsiyet`, `Kullanici_Dtarihi`, `Kullanici_Avatar`) VALUES
(1, 'dogusdeniz', 'Doğuş Deniz', '306dff4f057691ac6c66583fc106d7e0b59ab4d8', 'dogusdeniz.3558@gmail.com', 'Erkek', '01.01.1998', 'avatarlar/avatar5.png'),
(2, 'gokselbas', 'Göksel Baş', '321f93c3b6968522fc258d4e80a9ad3afdd50644', 'gokselbas1997@gmail.com', 'Erkek', '24.08.1997', 'avatarlar/avatar1.png'),
(3, 'sedadeniz', 'Seda Deniz', '306dff4f057691ac6c66583fc106d7e0b59ab4d8', 'sedadeniz@gmail.com', 'Kadın', '26.09.1995', 'avatarlar/avatar3.png'),
(4, 'zubeydebas', 'Zübeyde Baş', '321f93c3b6968522fc258d4e80a9ad3afdd50644', 'zubeydebas@gmail.com', 'Kadın', '28.06.1997', 'avatarlar/avatar2.png'),
(5, 'onurozbey', 'Onur Özbey', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'onurızbey@gmail.com', 'Erkek', '15.01.2000', 'avatarlar/avatar4.png');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`Kullanici_ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `chats`
--
ALTER TABLE `chats`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `Kullanici_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
