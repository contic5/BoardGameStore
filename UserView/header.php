<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<table><tbody><tr>
<td><a href="Home.php">Home</a></td>
<td><a href="ViewGames.php">View All Games</a></td>
<td><a href="ViewCart.php">View Cart
<?php
include("db.php");
$username=trim($_SESSION["username"]);
$username=stripslashes($username);
$username=htmlspecialchars($username);
$myquery=sprintf("SELECT * FROM CartTable WHERE Username='%s'",$username);
$myresult=mysqli_query($conn,$myquery) or die(mysqli_error($conn));
print("(".mysqli_num_rows($myresult).")");
?>
</a></td>
<td><a href="ViewPurchases.php">View Purchases</a></td>
<td><a href="userlogout.php">Log Out</a></td>
<td>
<form action="ViewGames.php" method="get">
<input type="text" name="Name"></input>
<button type="submit">Search</button>
</form>
</td>
<td>
View Games By:
</td>
<td>
<form action="ViewGames.php" method="get">
<select name="searchtype">
<option value="A-Z">A-Z</option>
<option value="Z-A">Z-A</option>
<option value="1-X">Oldest First</option>
<option value="X-1">Newest First</option>
</select>
<button type="submit">Go</button>
</form>
</td>
</tr></tbody></table>
<?php
print("<p>Hello ".$_SESSION["username"]."</p>");
?>
</body>
</html>
