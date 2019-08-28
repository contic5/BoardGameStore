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
include("header.php");?>
<?php
if(isset($_POST['Name']))
{
  $name=sanitize($_POST["Name"]);
  $cost=sanitize($_POST["Cost"]);
  $stock=sanitize($_POST["Stock"]);
  $minplayers=sanitize($_POST["MinimumPlayers"]);
  $maxplayers=sanitize($_POST["MaximumPlayers"]);
  $gamelength=sanitize($_POST["GameLength"]);
  $imagelocation=trim($_POST["ImageLocation"]);
  $imagelocation=htmlspecialchars($imagelocation);
  $imagesource=trim($_POST["ImageSource"]);
  $imagesource=htmlspecialchars($imagesource);
  $query=sprintf("INSERT INTO BoardGame(GameName,Length,Minimum_Players,Maximum_Players,Cost,Stock,ImageLocation,ImageSource)"
  ."VALUES('%s','%s','%s','%s','%s','%s','%s','%s')",$name,$gamelength,$minplayers,$maxplayers,$cost,$stock,$imagelocation,$imagesource);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  print("<p>".$name." added</p>");
  $categories=array("Competitive","Cooperative","Puzzle","Mind+Game","Strategy","Trivia","Kid+Friendly","Luck+Based","Casual","Race","Party");
  for($i=0;$i<sizeof($categories);$i++)
  {
    $curcategory=$categories[$i];
    if(isset($_POST[$curcategory])&&$_POST[$curcategory])
    {
      $curcategorytext=str_replace("+"," ",$curcategory);
      $query=sprintf("INSERT INTO CategoryTable(GameName,CategoryName,ImageLocation)"
      ."VALUES('%s','%s','%s')",$name,$curcategorytext,$imagelocation);
      $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
      print("<p>".$name." set as ".$curcategorytext." game</p>");
    }
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
<h1>Insert Board Game</h1>
<form method="post">
<p>Name:
<input type="text" name="Name" size='64' required>
</p>
<p>ImageLocation:</p>
<p><textarea name="ImageLocation" cols='32' rows='8' required></textarea></p>
<p>ImageSource:</p>
<p><textarea name="ImageSource" cols='32' rows='8' required></textarea></p>
<select name="GameLength">
<option value="Short">Short(0-30 minutes)</option>
<option value="Medium">Medium (30-60 minutes)</option>
<option value="Long">Long (60+ minutes)</option>
<option value="Varying">Varying</option>
</select>
<p>Minimum Players:
<input type="number" name="MinimumPlayers" value="1" required>
</p>
<p>Maximum Players:
<input type="number" name="MaximumPlayers" value="4" required>
</p>
<p>Cost:
<input type="text" name="Cost" value="24.99" required>
</p>
<p>Stock:
<input type="text" name="Stock" value="10" required>
</p>
<p>Categories</p>
Competitive:<input type="checkbox" name="Competitive"><br>
Cooperative:<input type="checkbox" name="Cooperative"><br>
Puzzle:<input type="checkbox" name="Puzzle"><br>
Mind Game:<input type="checkbox" name="Mind+Game"><br>
Strategy:<input type="checkbox" name="Strategy"><br>
Trivia:<input type="checkbox" name="Trivia"><br>
Kid Friendly:<input type="checkbox" name="Kid+Friendly"><br>
Luck Based:<input type="checkbox" name="Luck+Based"><br>
Casual:<input type="checkbox" name="Casual"><br>
Race:<input type="checkbox" name="Race"><br>
Party:<input type="checkbox" name="Party"><br>
<button type="submit">Submit</button>
</form>
</body>
</html>
