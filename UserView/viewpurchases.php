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
print("<h1>View Purchases</h1>");
$username=sanitize($_SESSION["username"]);
$query=sprintf("SELECT * FROM PurchaseTable where Username='%s' ORDER BY ID DESC",$username);
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
$rowon=0;
$newpurchaseid=true;
$curID=-1;
$IDon=0;
print("<table><tbody>");
while($row=mysqli_fetch_assoc($result))
{
  if($curID!=$row["PurchaseID"])
  {
    if($curID!=-1)
    {
      print("</tbody></table>");
      $IDon=$IDon+1;
    }
    print("<p>Purchase ID: ".($IDon+1)."</p>");
    print("<p>Purchase Time: ".$row["PurchaseDateTime"]."</p>");
    if($curID!=-1)
    {
      print("<table><tbody>");
    }
    $rowon=0;
    $curID=$row["PurchaseID"];
    $newpurchaseid=false;
  }
  if($rowon%4==0)
  {
    print("<tr>");
  }
  print("<td><p>".$row["GameName"].": $".$row["Cost"]."</p></td>");
  if($rowon%4==3)
  {
    print("</tr>");
  }
  $rowon=$rowon+1;
}
print("</tbody></table>");
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
