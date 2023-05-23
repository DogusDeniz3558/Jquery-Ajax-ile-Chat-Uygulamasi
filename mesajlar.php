<?php
require_once("settings/baglan.php");
if (!isset($_SESSION['Kullanici_adi'])) {
    header("Location:index.php");
    exit();
}
$SuankiKullaniciSor = $db->prepare("SELECT Kullanici_ID FROM kullanicilar WHERE Kullanici_id = ?");
$SuankiKullaniciSor->execute([
    $_SESSION['Kullanici_ID']
]);
$SuankiKullanici = $SuankiKullaniciSor->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">


    <title>Mesajlaşma Uygulamasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--  Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abel&family=PT+Serif&display=swap" rel="stylesheet">
    <!--  Google Fonts-->

    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="css/style.css">

    <!-- toastrjs -->
    <link rel="stylesheet" href="css/toastr.min.css">
    <script src="js/toastr.min.js"></script>
    <!-- toastrjs -->

</head>
<body>
<main class="content">
    <div class="container p-0">
        <h1 class="h3 mb-3">Mesajlar</h1>
        <div class="card">
            <div class="row g-0">
                <div class="col-12 col-lg-5 col-xl-3 border-right">
                    <div class="px-4 d-none d-md-block">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <input id="ara" type="text" class="form-control my-3" placeholder="Ara...">
                            </div>
                        </div>
                    </div>
                    <div id="kullanicilar">

                    </div>

                    <hr class="d-block d-lg-none mt-1 mb-0">
                </div>
                <div class="col-12 col-lg-7 col-xl-9">
                    <div class="py-2 px-4 border-bottom d-none d-lg-block">
                        <div class="d-flex align-items-center py-1">
                            <div class="position-relative">
                                <img id="avatar" src="avatarlar/avatar3.png"
                                     class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                            </div>
                            <div class="flex-grow-1 pl-3">
                                <strong id="isimsoyisim" id="">İsim Soyisim</strong>
                                <input type="hidden" id="gonderilenidbilgisi" value="">
                                <input type="hidden" id="gonderenIDBilgisi"
                                       value="<?= $SuankiKullanici['Kullanici_ID'] ?>">
                                <div class="text-muted small"><em>Yazıyor...</em></div>
                            </div>
                            <div>
                                <a href="settings/cikis.php" class="btn btn-dark border btn-lg px-3">
                                    <i class="fa-solid fa-door-open"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div  class="position-relative">
                        <div id="mesajlar" class="chat-messages p-4 ">


                        </div>
                    </div>
                    <div class="flex-grow-0 py-3 px-4 border-top">
                        <div class="input-group">
                            <input id="Mesaj" type="text" class="form-control" placeholder="Mesajınız...">
                            <button id="Gonder" class="btn btn-primary btn-sm ml-1">Gönder</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<script src="js/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        //sol alan arama kutusu
        $('#ara').on('input', function () {
            var arananDeger = $(this).val().toLowerCase();//inputtan gelen değerleri aldık ve hepsini küçük harf yaptık

            $('.ara').each(function () {
                var currentRowText = $(this).text().toLowerCase(); //Dönen satırın içeriğini alır
                var showRow = currentRowText.indexOf(arananDeger) > -1; //metin içinde aranan kelimenin indeksini döndürür. Eğer kelime metin içinde varsa, indeks değeri 0'dan büyük olur, yoksa -1 döner.
                $(this).toggle(showRow);

            });
        });

        var sonGelenKullanicilar = "";

        function kullanicicek() {
            $.ajax({
                method: "POST",
                url: "api/solalankullanicilar.php",
                success: function (res) {
                    if (res !== sonGelenKullanicilar) {
                        // Sadece yeni eklenen kullanıcıları ekle
                        var yeniKullanicilar = res.replace(sonGelenKullanicilar, "");
                        $('#kullanicilar').append(yeniKullanicilar);
                        sonGelenKullanicilar = res;
                    }
                }
            });
        }

        setInterval(kullanicicek, 1000);

    });
    //Kullanıcı isim bulmak için post ettik

    var intervalID; // setInterval fonksiyonunun ID'sini saklamak için değişken

    $(document).on('click', '.ara', function () {

        clearInterval(intervalID); // Önceki setInterval fonksiyonunu durdur
        var id = $(this).data('id');
        var GonderenIDBilgisi = $('#gonderenIDBilgisi').val();
        $.ajax({
            method: "POST",
            url: "api/main.php",
            data: {
                "id": id,
                "GonderenIDBilgisi" : GonderenIDBilgisi,
                "Data": "Kullanici_Isim"
            },
            success: function (res) {
                var data = $.parseJSON(res);
                $('#isimsoyisim').html(data.IsimSoyisim);
                $('#avatar').attr("src", data.Avatar);
                $('#gonderilenidbilgisi').val(id);
                $('#mesajlar').html(data.Mesajlar);

                // 1 saniyede bir mesajları yenile
                intervalID = setInterval(function() {
                    $.ajax({
                        method: "POST",
                        url: "api/main.php",
                        data: {
                            "id": id,
                            "GonderenIDBilgisi" : GonderenIDBilgisi,
                            "Data": "Kullanici_Isim"
                        },
                        success: function (res) {
                            var data = $.parseJSON(res);
                            $('#mesajlar').html(data.Mesajlar);
                        }
                    });
                }, 800); // 1 saniyeden az bir zamnda yenileme yapılacak
            }
        });
    });

    //Mesaj Gönderme Alanı
    $(document).ready(function () {

        $('#Gonder').on('click', function (e) {
            e.preventDefault();
            var gonderilenidbilgisi = $('#gonderilenidbilgisi').val();
            var gonderenidbilgisi = $('#gonderenIDBilgisi').val();
            $.ajax({
                method: "POST",
                url: "api/main.php",
                data: {
                    "Data": "MesajEkle",
                    "Mesaj": $('#Mesaj').val(),
                    "gonderilenidbilgisi": gonderilenidbilgisi,
                    "gonderenidbilgisi": gonderenidbilgisi
                },
                success: function (response) {
                    if (response == "Boş") {
                        toastr["warning"]("Lütfen mesaj alanını boş bırakmayınız!", "Uyarı!");
                    } else if (response == "Gonderilen Bilgisi Yok") {
                        toastr["error"]("Mesaj Gönderecek Bir Kişi Seçiniz!!", "Hata!!");
                    } else if (response == "Eklendi") {
                        $('#Mesaj').val("");
                    }

                }
            });
        });

    });


    //Toastr js yapılandırma
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }


</script>
</body>
</html>