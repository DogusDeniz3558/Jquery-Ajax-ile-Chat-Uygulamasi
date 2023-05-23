<?php
require_once ("../settings/baglan.php");

// Veritabanındaki tüm kullanıcıları listele
$KullaniciSor = $db->prepare("SELECT * FROM kullanicilar");
$KullaniciSor->execute();
$KullaniciCek = $KullaniciSor->fetchAll(PDO::FETCH_ASSOC);

// Son eklenen kullanıcının ID'sini al
$last_id = end($KullaniciCek)['Kullanici_ID'];

// Yeni bir kullanıcı eklenmiş mi kontrol et
$KullaniciSor = $db->prepare("SELECT COUNT(*) FROM kullanicilar WHERE Kullanici_ID > :last_id");
$KullaniciSor->bindParam(":last_id", $last_id, PDO::PARAM_INT);
$KullaniciSor->execute();
$yeni_kullanici_varmi = $KullaniciSor->fetchColumn();

// Yeni kullanıcı eklenmemişse tüm kullanıcıları listeleyip ekrana yazdır
if (!$yeni_kullanici_varmi) {
    foreach ($KullaniciCek as $Kullanici){ ?>
            <head>
                <style>
                    .ara{cursor: pointer}
                </style>
            </head>
        <div class="ara ara2 list-group-item list-group-item-action border-0" data-id="<?=$Kullanici['Kullanici_ID'] ?>">
            <div class="badge bg-success text-white float-right">0</div>
            <div class="d-flex align-items-start">
                <img src="<?= $Kullanici['Kullanici_Avatar'] ?>" class="rounded-circle mr-1"
                     alt="<?= $Kullanici['Kullanici_AdSoyad'] ?>" width="40" height="40">
                <div class="flex-grow-1 ml-3">
                    <?= $Kullanici['Kullanici_AdSoyad'] ?>
                    <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                </div>
            </div>
        </div>
    <?php }
} else {
    // Yeni kullanıcı eklenmişse sadece yeni eklenen kullanıcıları ekrana yazdır
    echo "Yeni Kullanıcı";
}
?>
