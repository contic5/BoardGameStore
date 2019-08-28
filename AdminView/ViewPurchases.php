<?php
require("adminauth.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>Admin Login</title>
</head>
<body>
<h2>View Purchases</h2>
<?php
require("db.php");
$query="SELECT * FROM PurchaseTable ORDER BY Username ASC";
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
$curuser="";
$curID=-1;
$IDvalue=1;
$rowon=0;
print("<table><tbody>");
while($row=mysqli_fetch_assoc($result))
{
  if($curuser!=$row["Username"])
  {
    $curuser=$row["Username"];
    $IDvalue=0;
    print("<h3>".$curuser."</h3>");
  }
  if($curID!=$row["ID"])
  {
    if($curID!=-1)
    {
      print("</tbody></table>");
    }
    print("<p>Purchase ID: ".($IDvalue+1)."</p>");
    print("<p>Purchase Time: ".$row["PurchaseDateTime"]."</p>");
    print("<table><tbody>");
    $IDValue=$IDvalue+1;
    $rowon=0;
  }
  if($rowon%4==0)
  {
    print("<tr>");
  }
  print("<td><p>".$row["GameName"].": ".$row["Cost"]."</p></td>");
  if($rowon%4==3)
  {
    print("</tr>");
  }
  $rowon=$rowon+1;
}
print("</tbody></table>");
?>
</body>
</html>
