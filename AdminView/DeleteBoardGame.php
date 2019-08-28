<?php
require("adminauth.php");
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
  $GameName=$_POST["GameName"];
  $query=sprintf("SELECT * FROM BoardGame WHERE GameName='%s'",$GameName);
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  $CURID=999999;
  while($row = mysqli_fetch_assoc($result))
  {
    $CURID=$row["ID"];
  }
  $query=sprintf("DELETE FROM BoardGame WHERE GameName='%s'",$GameName);
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  $query=sprintf("DELETE FROM CategoryTable WHERE GameName='%s'",$GameName);
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  print("<p>Deleted ".$GameName."</p>");
  $query=sprintf("UPDATE BoardGame SET ID=ID-1 WHERE ID>$CURID");
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  //header("Location: ViewBoardGame.php");
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
