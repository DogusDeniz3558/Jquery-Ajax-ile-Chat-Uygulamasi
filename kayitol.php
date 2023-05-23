<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="http://mymaplist.com/js/vendor/TweenLite.min.js"></script>
    <!------ Include Jquery UI ---------->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="js/jquery-ui.min.js"></script>

    <!-- Toastrjs -->
    <link rel="stylesheet" href="css/toastr.min.css">
    <script src="js/toastr.min.js"></script>

    <style>
        .vertical-offset-100 {
            padding-top: 210px;
        }

        .kayitol:hover {
            text-shadow: 1px 2px 3px 2px red;
        }
    </style>
</head>
<body>


<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Kayıt Ol</h3>
                </div>
                <div class="panel-body">
                    <form accept-charset="UTF-8" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Kullanıcı Adı" id="Kullanici_Adi" type="text"
                                       required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Adınız Soyadınız" id="Kullanici_AdSoyad"
                                       type="text" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" id="Kullanici_Eposta" type="text"
                                       required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Şifre" id="Kullanici_Sifre" type="password"
                                       required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="D.Tarihi" id="Kullanici_Dtarihi" type="date"
                                       required>
                            </div>
                            <div class="form-group">
                                <select id="Cinsiyet" class="form-control">
                                    <option value="">Seçiniz</option>
                                    <option value="Erkek">Erkek</option>
                                    <option value="Kadın">Kadın</option>
                                </select>
                            </div>
                            <div class="checkbox">
                                <span class="fa-solid fa-id-card"></span> <a href="index.php" class="kayitol"
                                                                             style="color:black; text-decoration: none;">
                                    Giriş Yap</a>
                            </div>
                            <input id="KayitOl" class="btn btn-lg btn-success btn-block" type="submit" value="Kayıt Ol">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#KayitOl').on('click', function (e) {
            e.preventDefault();
            var Kullanici_Adi = $('#Kullanici_Adi').val();
            var Kullanici_AdSoyad = $('#Kullanici_AdSoyad').val();
            var Kullanici_Eposta = $('#Kullanici_Eposta').val();
            var Kullanici_Sifre = $('#Kullanici_Sifre').val();
            var Kullanici_Dtarihi = $('#Kullanici_Dtarihi').val();
            var Kullanici_Cinsiyet = $('#Cinsiyet').val();

            $.ajax({
                method: "POST",
                url: "api/main.php",
                data: {
                    "Kullanici_Adi": Kullanici_Adi,
                    "Kullanici_AdSoyad": Kullanici_AdSoyad,
                    "Kullanici_Eposta": Kullanici_Eposta,
                    "Kullanici_Sifre": Kullanici_Sifre,
                    "Kullanici_Dtarihi": Kullanici_Dtarihi,
                    "Kullanici_Cinsiyet": Kullanici_Cinsiyet,
                    "Data": "Kayit_Ol"
                },
                success: function (response) {
                    if (response == "Bos"){
                        toastr["warning"]("Lütfen Boş Alan Bırakmayınız!!", "Uyarı!");
                    }else if (response == "Eklendi") {
                        toastr["success"]("Kullanıcı kayıt işleminiz başarıyla sonuçlandı.", "Aramıza Hoşgeldiniz");

                    } else if (response == "Eklenmedi") {
                        toastr["error"]("Kullanıcı Ekleme Sırasında Bir Hata Oluştu", "Hata!");
                    }else if (response == "Kullanici Var"){
                        toastr["error"]("Kullanıcı adınız ya da E-Posta adresiniz sistemimizde tanımlı.", "Dikkat!");

                    }else if(response == "Eposta Hatalı"){
                        toastr["warning"]("<b>Lütfen geçerli bir Gmail, Hotmail ya da Outlook e-posta adresi girin.</b>", "Uyarı!");
                    }
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Bağlantı Yok.\n İnternetinizi Kontrol Edin';
                    } else if (jqXHR.status == 404) {
                        msg = 'İstek atılan sayfa bulunamadı. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'İç Sunucu Hatası [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'İstenen JSON ayrıştırması başarısız oldu.';
                    } else if (exception === 'timeout') {
                        msg = 'Zaman Aşımı hatası.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax isteği iptal edildi.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    alert(msg);
                }
            });


        });
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
    });
</script>
</body>
</html>