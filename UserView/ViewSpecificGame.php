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
include("header.php");?>
<h1>View Specific Game</h1>
<?php
if(isset($_GET["Name"]))
{
  $name=sanitize($_GET["Name"]);
  $query=sprintf("SELECT * FROM BoardGame WHERE GameName='%s'",$name);
  $result=mysqli_query($conn,$query) or die(mysqli_error($conn));
  while($row = mysqli_fetch_assoc($result))
  {
    print("<div class='displayitem'>");
    $rowname=$row["GameName"];
    print("<h2>".$rowname."</h2>");
    print("<h3>$".$row["Cost"]."</h3>");
    print("<form action='addtocart.php' method='post'>");
    print("<input type='hidden' name='GameName' value='".$rowname."'>");
    print("<input type='hidden' name='Cost' value='".$row["Cost"]."'>");
    print("<input type='hidden' name='ImageLocation' value='".$row["ImageLocation"]."'>");
    print("<p><img class='displayitem' src='".$row["ImageLocation"]."'></img></p>");
    $query2=sprintf("SELECT * FROM BoardGame where GameName='%s'",$row["GameName"]);
    $result2=mysqli_query($conn,$query2) or die(mysqli_error($conn));
    $stock=0;
    while($row2=mysqli_fetch_assoc($result2))
    {
      $stock=$row2["Stock"];
    }
    if($stock>0)
    {
      print("<p><button type='submit'>Add To Cart</button></p>");
    }
    else
    {
      print("<p>".$rowname." is out of stock!</p>");
      print("<p><button type='submit' disabled>Add To Cart</button></p>");
    }
    print("</form>");
    print("</div>");
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
