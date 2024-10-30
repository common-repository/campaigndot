<?php
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET["wes_qrurl"])){

  include "include/phpqrcode/qrlib.php";

  // On crée l'image PNG directement avec les entêtes content-type corrects
  QRcode::png($_GET["wes_qrurl"], false, 'M', 4, 2);
  die();
 }

