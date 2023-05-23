<?php
require_once("../settings/baglan.php");
date_default_timezone_set('Europe/Istanbul');
$Data = Filtrele($_POST['Data']);
$sonuc;

switch ($Data) {
    // Kullanici Giriş İşlemleri
    case "Kullanici_Giris":

        $Kullanici_adi = Filtrele($_POST["Kullanici_adi"]);
        $Kullanici_Sifre = Filtrele(sha1(md5($_POST["Kullanici_Sifre"])));

        $KullaniciSor = $db->prepare("SELECT * FROM kullanicilar WHERE Kullanici_adi = ? AND Kullanici_Sifre = ?");
        $KullaniciSor->execute([
            $Kullanici_adi,
            $Kullanici_Sifre
        ]);

        $KullaniciCek = $KullaniciSor->fetch(PDO::FETCH_ASSOC);

        if ($KullaniciCek) {
            $_SESSION['Kullanici_adi'] = "Evet";
            $_SESSION['Kullanici_ID'] = $KullaniciCek['Kullanici_ID'];
            echo "mesajlar.php";
        } else {
            echo "Kullanıcı Yok";
        }


        break;
    // Kullanıcı Kayıt Ol İşlemleri
    case "Kayit_Ol":

        $Kullanici_Adi = Filtrele($_POST["Kullanici_Adi"]);
        $Kullanici_AdSoyad = Filtrele($_POST["Kullanici_AdSoyad"]);
        $Kullanici_Eposta = Filtrele($_POST["Kullanici_Eposta"]);
        $Kullanici_Sifre = Filtrele(sha1(md5($_POST["Kullanici_Sifre"])));
        $Kullanici_Cinsiyet = Filtrele($_POST["Kullanici_Cinsiyet"]);
        $Kullanici_Dtarihi = Filtrele($_POST["Kullanici_Dtarihi"]);

        $Tarih = date('d.m.Y', strtotime($Kullanici_Dtarihi));// 2023-05-14 şeklinde gelen tarihi 14.05.2023 e çevirir

        $rastgeleSayi = rand(1, 5); // avatar eklerken rastgele oluşturacak

        if ($Kullanici_Adi == "" || $Kullanici_AdSoyad == "" || $Kullanici_Eposta == "" || $Kullanici_Sifre == "" || $Kullanici_Cinsiyet == "" || $Kullanici_Dtarihi == "") {
            $sonuc = "Bos";
            echo $sonuc;
        } elseif (!preg_match('/@(gmail|hotmail|outlook)\.com$/', $Kullanici_Eposta)) {
            $sonuc = "Eposta Hatalı";
            echo $sonuc;
        } else {
            $KullaniciSor = $db->prepare("SELECT * FROM kullanicilar WHERE Kullanici_Eposta = ? or Kullanici_adi = ?");
            $KullaniciSor->execute([
                $Kullanici_Eposta,
                $Kullanici_Adi
            ]);
            $Kullanici = $KullaniciSor->fetch(PDO::FETCH_ASSOC);
            if (!$Kullanici) {
                $Ekle = $db->prepare("INSERT INTO kullanicilar SET Kullanici_adi = ?, Kullanici_AdSoyad = ?, Kullanici_Sifre = ?,Kullanici_Eposta = ?, Kullanici_Cinsiyet = ?, Kullanici_Dtarihi = ?, Kullanici_Avatar = ? ");
                $Ekle->execute([
                    $Kullanici_Adi,
                    $Kullanici_AdSoyad,
                    $Kullanici_Sifre,
                    $Kullanici_Eposta,
                    $Kullanici_Cinsiyet,
                    $Tarih,
                    "avatarlar/avatar" . $rastgeleSayi . ".png"
                ]);

                if ($Ekle) {
                    $sonuc = "Eklendi";
                    echo $sonuc;
                } else {
                    $sonuc = "Eklenmedi";
                    echo $sonuc;
                }
            } else {
                $sonuc = "Kullanici Var";
                echo $sonuc;
            }

        }

        break;
    // Mesajlar alanında üstte isim soyisim ve avatar resmi gelsin dediğimiz alan
    case "Kullanici_Isim":
        $sonuc = [];
        $GonderilenIDBilgisi = Filtrele($_POST['id']);
        $GonderenIDBilgisi = Filtrele($_POST['GonderenIDBilgisi']);

        $KullaniciSor = $db->prepare("SELECT * FROM kullanicilar WHERE Kullanici_ID = ?");
        $KullaniciSor->execute([
            $GonderilenIDBilgisi
        ]);
        $Kullanici = $KullaniciSor->fetch(PDO::FETCH_ASSOC);

        $IsimSoyisim = $Kullanici['Kullanici_AdSoyad'];
        $Avatar = $Kullanici['Kullanici_Avatar'];

        // Kullanıcıya göre mesaj listeleme

        $MesajSor = $db->prepare("SELECT * FROM chats WHERE (gonderici_id = :gonderen_id and alici_id = :alici_id) OR (gonderici_id = :alici_id and alici_id = :gonderen_id)");
        $MesajSor->execute([
            ':gonderen_id' => $GonderenIDBilgisi,
            ':alici_id' => $GonderilenIDBilgisi
        ]);
        $MesajCek = $MesajSor->fetchAll(PDO::FETCH_ASSOC);
        $mesajlarHTML = '';
        foreach ($MesajCek as $Mesaj) {
            $gondericiID = $Mesaj["gonderici_id"];
            $mesaj = $Mesaj["mesaj"];


            $KullaniciBilgiSor = $db->prepare("SELECT * FROM kullanicilar WHERE Kullanici_ID = :kullaniciID");
            $KullaniciBilgiSor->execute([
                "kullaniciID" => ($gondericiID == $GonderenIDBilgisi) ? $GonderenIDBilgisi : $GonderilenIDBilgisi
            ]);
            $KullaniciBilgi = $KullaniciBilgiSor->fetch(PDO::FETCH_ASSOC);

            // Gonderici tarafından gönderilen mesaj
            if ($gondericiID == $GonderenIDBilgisi) {
                $mesajlarHTML .= '<div class="chat-message-right pb-4 clearfix">';
                $mesajlarHTML .= '    <div>';
                $mesajlarHTML .= '        <img src="'.$KullaniciBilgi['Kullanici_Avatar'].'" class="rounded-circle mr-1" alt="" width="40" height="40">';
                $mesajlarHTML .= '    </div>';
                $mesajlarHTML .= '    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">';
                $mesajlarHTML .= '        <div class="font-weight-bold mb-1">Sen</div>';
                $mesajlarHTML .= $mesaj;
                $mesajlarHTML .= '    </div>';
                $mesajlarHTML .= '</div>';
            }
            // Alici tarafından alınan mesaj
            else {
                $mesajlarHTML .= '<div class="chat-message-left pb-4 clearfix">';
                $mesajlarHTML .= '    <div>';
                $mesajlarHTML .= '        <img src="'.$KullaniciBilgi['Kullanici_Avatar'].'" class="rounded-circle mr-1" alt="" width="40" height="40">';
                $mesajlarHTML .= '    </div>';
                $mesajlarHTML .= '    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">';
                $mesajlarHTML .= '        <div class="font-weight-bold mb-1">'.$KullaniciBilgi['Kullanici_AdSoyad'].'</div>';
                $mesajlarHTML .= $mesaj;
                $mesajlarHTML .= '    </div>';
                $mesajlarHTML .= '</div>';
            }
        }
        $data = [
            "IsimSoyisim" => $IsimSoyisim,
            "Avatar" => $Avatar,
            "Mesajlar" => $mesajlarHTML
        ];
        echo json_encode($data);
        break;


    // Mesaj Ekle Alanı
    case "MesajEkle":
        $Sonuc;
        $Mesaj = Filtrele($_POST['Mesaj']);
        $GonderilenIDBilgisi = Filtrele($_POST['gonderilenidbilgisi']);
        $GonderenIDBilgisi = Filtrele($_POST['gonderenidbilgisi']);
        $gonderimZamani = date('Y-m-d H:i:s');
        if ($Mesaj == "") {
            $Sonuc = "Boş";
            echo $Sonuc;
        } else if ($GonderilenIDBilgisi == "") {
            $Sonuc = "Gonderilen Bilgisi Yok";
            echo $Sonuc;
        } else {
            $Ekle = $db->prepare("INSERT INTO chats SET Chat_ID = ?, gonderici_id = ?, alici_id = ?, mesaj = ?, gonderilme_zamani = ?");
            $Ekle->execute([
                1,
                $GonderenIDBilgisi,
                $GonderilenIDBilgisi,
                $Mesaj,
                $gonderimZamani
            ]);
            if ($Ekle) {
                $Sonuc = "Eklendi";
                echo $Sonuc;
            }
        }


        break;


    default:
        echo "Your favorite color is neither red, blue, nor green!";
}
?>