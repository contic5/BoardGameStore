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
$gamelength="";
$minimumplayers=0;
$maximumplayers=0;
$cost=0;
$stock=0;
$imagelocation="";
$categories=array("Competitive","Cooperative","Puzzle","Mind+Game","Strategy","Trivia","Kid+Friendly","Luck+Based","Casual","Race","Party");
$categoriesset=array_fill(0, count($categories), "");
$gamename="";
$ID=0;
if(isset($_GET['ID']))
{
  $ID=sanitize($_GET['ID']);
  $query=sprintf("SELECT GameName FROM BoardGame where ID='%d'",$ID);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  while($row = mysqli_fetch_assoc($result))
  {
    $gamename=$row["GameName"];
  }
  print("<form method='get'>");
  if($ID>1)
  {
    print("<input type='hidden' name='ID' value='".($ID-1)."'>");
    print("<p><button type='submit'>Edit Previous</button></p>");
    print("</form>");
  }
  else
  {
    print("<input type='hidden' name='ID' value='".($ID-1)."'>");
    print("<p><button disabled type='submit'>Edit Previous</button></p>");
    print("</form>");
  }
  if($ID<$maxID)
  {
    print("<form method='get'>");
    print("<input type='hidden' name='ID' value='".($ID+1)."'>");
    print("<p><button type='submit'>Edit Next</button></p>");
    print("</form>");
  }
  else
  {
    print("<form method='get'>");
    print("<input type='hidden' name='ID' value='".($ID+1)."'>");
    print("<p><button disabled type='submit'>Edit Next</button></p>");
    print("</form>");
  }
}
if(isset($_POST['Name']))
{
  $ID=sanitize($_POST["ID"]);
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
  $query=sprintf("UPDATE BoardGame SET GameName='%s',Length='%s',Minimum_Players='%s',Maximum_Players='%s',Cost='%s',Stock='%s',ImageLocation='%s',ImageSource='%s' "
  ."where ID='%d'",$name,$gamelength,$minplayers,$maxplayers,$cost,$stock,$imagelocation,$imagesource,$ID);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  print("<p>".$name." updated</p>");
  for($i=0;$i<sizeof($categories);$i++)
  {
    $curcategory=$categories[$i];
    if(isset($_POST[$curcategory])&&$_POST[$curcategory])
    {
      $curcategorytext=str_replace("+"," ",$curcategory);
      $query=sprintf("SELECT * FROM CategoryTable WHERE GameName='%s' AND CategoryName='%s' ",$name,$curcategorytext);
      $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
      $rowcount=mysqli_num_rows($result);
      if($rowcount==0)
      {
        $query=sprintf("INSERT INTO CategoryTable(GameName,CategoryName,ImageLocation)"
        ."VALUES('%s','%s','%s')",$name,$curcategorytext,$imagelocation);
        $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
        print("<p>".$name." is now set as a ".$curcategorytext." game</p>");
      }
      else
      {
        print("<p>".$name." is already set as a ".$curcategorytext." game</p>");
      }
    }
    else
    {
      $curcategorytext=str_replace("+"," ",$curcategory);
      $query=sprintf("DELETE FROM CategoryTable WHERE GameName='%s' AND CategoryName='%s'",$name,$curcategorytext);
      $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
      $rowcount=mysqli_affected_rows($conn);
      if($rowcount>0)
      {
        print("<p>".$name." is no longer set as a ".$curcategorytext." game</p>");
      }
    }
  }
}
if(isset($_GET['ID']))
{
  $query=sprintf("SELECT * FROM BoardGame WHERE GameName='%s'",$gamename);
  $result = mysqli_query($conn, $query) or die ( mysqli_error($conn));
  while($row = mysqli_fetch_assoc($result))
  {
    $gamelength=$row["Length"];
    $minimumplayers=$row["Minimum_Players"];
    $maximumplayers=$row["Maximum_Players"];
    $cost=$row["Cost"];
    $stock=$row["Stock"];
    $imagelocation=$row["ImageLocation"];
    $imagesource=$row["ImageSource"];
  }
  for($i=0;$i<sizeof($categories);$i++)
  {
    $curcategory=$categories[$i];
    $curcategorytext=str_replace("+"," ",$curcategory);
    $query=sprintf("SELECT * FROM CategoryTable WHERE GameName='%s' AND CategoryName='%s'",$gamename,$curcategorytext);
    $result = mysqli_query($conn, $query) or die ( mysqli_error($conn));
    $rowcount=mysqli_num_rows($result);
    if($rowcount>0)
    {
      $categoriesset[$i]="checked";
    }
    //print($categoriesset[i]);
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
<h1>Edit Board Game</h1>
<form method="post">
<input type="hidden" name="ID" value=<?php print($_GET["ID"])?>>
<p>Name:
<input type="text" name="Name" size='64' required
<?php
print("value='$gamename'"); ?>
>
</p>
<p>ImageLocation:</p>
<p><textarea name="ImageLocation" cols='32' rows='8' required>
<?php print($imagelocation); ?>
</textarea></p>
<p>ImageSource:</p>
<p><textarea name="ImageSource" cols='32' rows='8' required>
<?php print($imagesource); ?>
</textarea></p>
<select name="GameLength">
<option value="Short"
<?php if($gamelength=="Short")
print("selected");
?>>
Short(0-30 minutes)</option>
<option value="Medium"
<?php if($gamelength=="Medium")
print("selected");
?>>
Medium (30-60 minutes)</option>
<option value="Long"
<?php if($gamelength=="Long")
print("selected");
?>>
Long (60+ minutes)</option>
<option value="Varying"
<?php if($gamelength=="Varying")
print("selected");
?>>
Varying</option>
</select>
<p>Minimum Players:
<input type="number" name="MinimumPlayers" required
<?php
print("value= ".$minimumplayers);
?>
></p>
<p>Maximum Players:
<input type="number" name="MaximumPlayers" required
<?php
print("value= ".$maximumplayers);
?>
></p>
<p>Cost:
<input type="text" name="Cost" required
<?php
print("value= ".$cost);
?>
></p>
<p>Stock:
<input type="text" name="Stock" value="10" required
<?php
print("value= ".$stock);
?>
></p>
<p>Categories</p>
Competitive:<input type="checkbox" name="Competitive"
<?php
print($categoriesset[0]);
?>
><br>
Cooperative:<input type="checkbox" name="Cooperative"
<?php
print($categoriesset[1]);
?>
><br>
Puzzle:<input type="checkbox" name="Puzzle"
<?php
print($categoriesset[2]);
?>
><br>
Mind Game:<input type="checkbox" name="Mind+Game"
<?php
print($categoriesset[3]);
?>
><br>
Strategy:<input type="checkbox" name="Strategy"
<?php
print($categoriesset[4]);
?>><br>
Trivia:<input type="checkbox" name="Trivia"
<?php
print($categoriesset[5]);
?>
><br>
Kid Friendly:<input type="checkbox" name="Kid+Friendly"
<?php
print($categoriesset[6]);
?>
><br>
Luck Based:<input type="checkbox" name="Luck+Based"
<?php
print($categoriesset[7]);
?>
><br>
Casual:<input type="checkbox" name="Casual"
<?php
print($categoriesset[8]);
?>
><br>
Race:<input type="checkbox" name="Race"
<?php
print($categoriesset[9]);
?>
><br>
Party:<input type="checkbox" name="Party"
<?php
print($categoriesset[10]);
?>
><br>
<button type="submit">Submit</button>
</form>
</body>
</html>
