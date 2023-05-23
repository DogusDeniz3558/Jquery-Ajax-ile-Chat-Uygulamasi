<?php
session_start();
if (isset($_SESSION['Kullanici_adi']) == "Evet"){
    header("location:mesajlar.php");
}

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="js/jquery-3.7.0.min.js"></script>

    <!-- Include Fontawsome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <!------ Include Jquery UI ---------->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="js/jquery-ui.min.js"></script>

    <!------ Include toastr ---------->
    <link rel="stylesheet" href="css/toastr.min.css">
    <script src="js/toastr.min.js"></script>

    <script src="http://mymaplist.com/js/vendor/TweenLite.min.js"></script>
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
                    <h3 class="panel-title">Giriş Yap</h3>
                </div>
                <div class="panel-body">
                    <form accept-charset="UTF-8" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Kullanıcı Adı" id="Kullanici_adi"
                                       type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Şifre" id="Kullanici_Sifre" type="password"
                                       value="">
                            </div>
                            <div class="checkbox">
                                <span class="fa-solid fa-id-card"></span> <a href="kayitol.php" class="kayitol"
                                                                             style="color:black; text-decoration: none;">Kayıt
                                    Ol</a>

                            </div>
                            <input id="girisyap" class="btn btn-lg btn-success btn-block" type="submit" value="Giriş">
                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {


        $('#girisyap').on('click', function (e) {

            e.preventDefault();
            var $Kullanici_adi = $('#Kullanici_adi').val();
            var Kullanici_Sifre = $('#Kullanici_Sifre').val();
            if ($Kullanici_adi == "") {
                toastr["warning"]("Kullanıcı Adınız Boş Olamaz!", "Uyarı");
            } else if (Kullanici_Sifre == "") {
                toastr["warning"]("Parolanız Boş Olamaz!", "Uyarı");
            } else {
                $.ajax({
                    method: "POST",
                    url: "api/main.php",
                    data: {
                        "Kullanici_adi": $Kullanici_adi,
                        "Kullanici_Sifre": Kullanici_Sifre,
                        "Data": "Kullanici_Giris"
                    },
                    success: function (response) {
                        if (response == "Kullanıcı Yok"){
                            toastr["error"]("Kullanıcı Bilgilerinizi Kontrol Ediniz!", "Uyarı");
                        }else{
                            window.location.href = response;
                        }
                    }
                });
            }


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
    });

</script>
</body>
</html>