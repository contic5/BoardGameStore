<?php
require("userauth.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
include("db.php");
include("header.php");
if(isset($_POST["GameName"]))
{
  $username=sanitize($_SESSION["username"]);
  $GameName=$_POST["GameName"];
  $query=sprintf("DELETE FROM CartTable WHERE Username='%s' AND GameName='%s'",$username,$GameName);
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  header("Location: viewcart.php");
}
function sanitize($text)
{
  $text=trim($text);
  $text=stripslashes($text);
  $text=htmlspecialchars($text);
  return $text;
}
?>
</body>
</html>
