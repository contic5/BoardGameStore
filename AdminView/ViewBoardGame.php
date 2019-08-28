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
?>
<?php
$query="SELECT * FROM BoardGame";
if(isset($_GET["searchtype"]))
{
  $searchtype=$_GET["searchtype"];
  if($searchtype=="A-Z")
  {
    $query="SELECT * FROM BoardGame ORDER BY GameName ASC";
  }
  if($searchtype=="Z-A")
  {
    $query="SELECT * FROM BoardGame ORDER BY GameName DESC";
  }
  if($searchtype=="1-X")
  {
    $query="SELECT * FROM BoardGame ORDER BY ID ASC";
  }
  if($searchtype=="X-1")
  {
    $query="SELECT * FROM BoardGame ORDER BY ID DESC";
  }
}
$result=mysqli_query($conn,$query);
print("<h2>View Games</h2>");
print("<table><tbody>");
print("<tr><td colspan='5'><a href='InsertBoardGame.php'>Insert Board Game</a></td></tr>");
while($row=mysqli_fetch_assoc($result))
{
  $rowon=$row["ID"];
  $GameName=$row["GameName"];
  print("<tr>");
  print("<form method='get' action='EditBoardGame.php'>");
  print("<input type='hidden' name='ID' value='$rowon'>");
  print("<td>".$row["ID"]."</td>");
  print("<td>".$row["GameName"]."</td>");
  print("<td><button type='submit'>Edit</button></td>");
  print("</form>");
  print("<form method='post' action='DeleteBoardGame.php'>");
  print("<input type='hidden' name='GameName' value='$GameName'>");
  print("<td style='width:50px'></td>");
  print("<td><button type='submit'>Delete</button></td>");
  print("</form>");
  print("</tr>");
}
print("</tbody></table>");
?>
</body>
</html>
