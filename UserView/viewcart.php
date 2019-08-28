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
print("<h1>View Cart</h1>");
$username=sanitize($_SESSION["username"]);
$query=sprintf("SELECT * FROM CartTable where Username='%s'",$username);
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
$rowon=0;
if(mysqli_num_rows($result)>0)
{
  print("<table><tbody>");
}
while($row=mysqli_fetch_assoc($result))
{
  if($rowon%4==0)
  {
    print("<tr>");
  }
  print("<td><p>".$row["GameName"].": $".$row["Cost"]."</p>");
  print("<p><img class='displayitem' src='".$row["ImageLocation"]."'</img></p>");
  $query2=sprintf("SELECT * FROM BoardGame where GameName='%s'",$row["GameName"]);
  $result2=mysqli_query($conn,$query2) or die(mysqli_error($conn));
  $stock=0;
  while($row2=mysqli_fetch_assoc($result2))
  {
    $stock=$row2["Stock"];
  }
  if($stock==0)
  {
    print("<p>".$row["GameName"]." is out of stock. This item will not be added to your order.</p>");
  }
  print("<form action='removefromcart.php' method='post'>");
  print("<input type='hidden' name='GameName' value='".$row["GameName"]."'>");
  print("<p><button type='submit'>Delete</button></p>");
  print("</form>");
  print("</td>");
  if($rowon%4==3)
  {
    print("</tr>");
  }
  $rowon=$rowon+1;
}
if(mysqli_num_rows($result)>0)
{
  print("</tbody></table>");
}
if(mysqli_num_rows($result)>0)
{
  print("<form action='purchase.php' method='post'>");
  print("<button>Purchase</button>");
  print("</form>");
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
