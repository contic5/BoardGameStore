<?php
require("adminauth.php");
?>
<html>
<head>

</head>
<body>
<?php
include("db.php");
$query="SELECT GameName,ImageLocation,ImageSource FROM BoardGame ORDER BY GameName ASC";
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
print("<p>Images Cited</p>");
while($row=mysqli_fetch_assoc($result))
{
  print("<p>".$row["GameName"]."<br>");
  print("ImageLocation: ".$row["ImageLocation"]."<br>");
  print("ImageSource: ".$row["ImageSource"]."</p>");
}
?>
</body>
</html>
