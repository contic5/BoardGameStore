<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<table><tbody><tr>
<td><a href="InsertBoardGame.php">Insert Board Game</a></td>
<td>
View Board Games By:
</td>
<td>
<form action="ViewBoardGame.php" method="get">
<select name="searchtype">
<option value="A-Z">A-Z</option>
<option value="Z-A">Z-A</option>
<option value="1-X">Oldest First</option>
<option value="X-1">Newest First</option>
</select>
<button type="submit">Go</button>
</form>
<td>
<form action="EditBoardGame.php" method="get">
<?php
include("db.php");
$query="SELECT ID FROM BoardGame";
$maxID=0;
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
while($row=mysqli_fetch_assoc($result))
{
  $maxID=$row["ID"];
}
print("<input type='hidden' name='ID' value='".$maxID."'>");
?>
<button type="submit">Edit Most Recent Game</button>
</form>
</td>
</tr></tbody></table>
<?php
print("<p>Hello ".$_SESSION["adminusername"]."</p>");
?>
</body>
</html>
