<?php
require("sessionstart.php");
if(!isset($_SESSION["adminusername"])||!isset($_SESSION["adminpassword"]))
{
  $URL="index.php";
  echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
  echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
}
?>
