-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 24 May 2023, 22:43:50
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
(32, 6, 7, 'Merhaba', '2023-05-24 23:42:46');

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
(6, 'dogusdeniz', 'Doğuş Deniz', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'deneme@gmail.com', 'Erkek', '01.01.1998', 'avatarlar/avatar4.png'),
(7, 'denemehesabi', 'Doğuş Deneme', 'a346bc80408d9b2a5063fd1bddb20e2d5586ec30', 'dode@gmail.com', 'Erkek', '01.01.1998', 'avatarlar/avatar3.png');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `Kullanici_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
