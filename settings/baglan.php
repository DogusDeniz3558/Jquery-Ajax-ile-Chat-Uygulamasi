<?php
session_start();
try {
    $db = new PDO("mysql:host=localhost;dbname=chat-uygulamasi", "root", "");
   // echo "bağlantı ok";
} catch ( PDOException $e ){
    print $e->getMessage();
}


function Filtrele($deger){
    $A = trim($deger);
    $B = strip_tags($A);
    $C = htmlspecialchars($B, ENT_QUOTES);
    $Sonuc = $C;
    return $Sonuc;
}

?>