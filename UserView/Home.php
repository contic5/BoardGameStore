<?php
require("userauth.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include("db.php"); include("header.php"); ?>
<h1>Welcome to the Board Game Store</h1>
<?php
$query="SELECT * FROM BoardGame";
$result=mysqli_query($conn,$query) or die(mysqli_error($query));
$gamecount=mysqli_num_rows($result);
print("<h3>We have ".$gamecount." games in 10 different categories</h3>");
?>
<h3>Select Category</h3>
<form method="get" action="ViewGames.php">
<p><select name="Category">
<option value="Competitive">Competitive</option>
<option value="Cooperative">Cooperative</option>
<option value="Puzzle">Puzzle</option>
<option value="Mind+Game">Mind Game</option>
<option value="Strategy">Strategy</option>
<option value="Trivia">Trivia</option>
<option value="Kid+Friendly">Kid Firendly</option>
<option value="Luck+Based">Luck Based</option>
<option value="Casual">Casual</option>
<option value="Race">Race</option>
</select></p>
<button type="submit">View Category</button>
</form>
<h3>View All Games</h3>
<a href="ViewGames.php">View all Games</a>
<p>
<form action="ViewGames.php">
<input name="searchtype" type="hidden" value="A-Z">
<button type="submit">Board Games A-Z</button>
</form>
</p>
<p>
<form action="ViewGames.php">
<input name="searchtype" type="hidden" value="Z-A">
<button type="submit">Board Games Z-A</button>
</form>
</p>
<p>
<form action="ViewGames.php">
<input name="searchtype" type="hidden" value="1-X">
<button type="submit">Oldest Board Games</button>
</form>
</p>
<p>
<form action="ViewGames.php">
<input name="searchtype" type="hidden" value="X-1">
<button type="submit">Newest Board Games</button>
</form>
</p>
</body>
</html>
