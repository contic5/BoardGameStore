<?php
require("userauth.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
include("header.php");
include("db.php");
if(isset($_POST["GameName"]))
{
  $gamename=sanitize($_POST["GameName"]);
  $cost=sanitize($_POST["Cost"]);
  $imagelocation=sanitize($_POST["ImageLocation"]);
  $username=sanitize($_SESSION["username"]);
  $stock=0;
  $query=sprintf("SELECT * FROM BoardGame WHERE GameName='%s'",$gamename);
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  while($row = mysqli_fetch_assoc($result))
  {
    $stock=$row["Stock"];
    if($stock>0)
    {
      $query2=sprintf("INSERT INTO CartTable(GameName,Cost,Username,ImageLocation)"
      ."VALUES('%s','%s','%s','%s')",$gamename,$cost,$username,$imagelocation);
      $result2=mysqli_query($conn,$query2) or die(mysqli_error($conn));
      print("<p>".$gamename." has been added to your cart</p>");
    }
    else
    {
      print("<p>".$gamename." is out of stock and NOT added to your cart.</p>");
    }
  }
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
