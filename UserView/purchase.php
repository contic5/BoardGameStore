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
$date = date("m:d:y H:i:s"); //date, month,year,hour,minute,second
print("<p>".$date."</p>");
if($_SERVER['REQUEST_METHOD']=="POST")
{
  $username=sanitize($_SESSION["username"]);
  $query=sprintf("SELECT * FROM CartTable where Username='%s'",$username);
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  $gamenames=array();
  $costs=array();
  $rowcount=0;
  while($row = mysqli_fetch_assoc($result))
  {
      array_push($gamenames,$row["GameName"]);
      array_push($costs,$row["Cost"]);
      $rowcount=$rowcount+1;
  }
  $query="SELECT * FROM PurchaseTable ORDER BY PurchaseID ASC";
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  $maxPurchaseID=0;
  while($row = mysqli_fetch_assoc($result))
  {
    $maxPurchaseID=$row["PurchaseID"];
  }
  for($rowon=0;$rowon<$rowcount;$rowon++)
  {
    $query=sprintf("SELECT * FROM BoardGame where GameName='%s'",$gamenames[$rowon]);
    $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
    $stock=0;
    while($row=mysqli_fetch_assoc($result))
    {
      $stock=$row["Stock"];
    }

    if($stock>0)
    {
      $query=sprintf("INSERT INTO PurchaseTable(PurchaseID,Username,Gamename,Cost,PurchaseDateTime)"
      ."VALUES('%s','%s','%s','%s','%s')",$maxPurchaseID+1,$username,$gamenames[$rowon],$costs[$rowon],$date);
      $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
      print("<p>".$gamenames[$rowon]." purchased!</p>");
    }
    else
    {
      print("<p>".$gamenames[$rowon]." is out of stock and NOT purchased.</p>");
    }
  }
  $query=sprintf("DELETE FROM CartTable where Username='%s'",$username);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));

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
