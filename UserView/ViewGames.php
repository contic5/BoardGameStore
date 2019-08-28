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
<h1>View Games</h1><br>
<?php
if(isset($_GET["Name"]))
{
  $name=sanitize($_GET["Name"]);
  $name=str_replace("+"," ",$name);
  $query=sprintf("SELECT * FROM BoardGame WHERE GameName LIKE '%s'",$name);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $rowon=0;
  print("<table><tbody>");
  while($row=mysqli_fetch_assoc($result))
  {
    if($rowon%4==0)
    {
      print("<tr>");
    }
    print("<td align='center'><form method='get' action='ViewSpecificGame.php'>");
    print("<p>".$row["GameName"].": ".$row["Cost"]."</p>");
    print("<p><img class='displayitem' src='".$row["ImageLocation"]."'</img></p>");
    print("<input type='hidden' name='Name' value='".$row["GameName"]."'>");
    print("<button type='submit'>View</button>");
    print("</form></td>");
    if($rowon%4==3)
    {
      print("</tr>");
    }
    $rowon=$rowon+1;
  }
  print("</tbody></table>");
}
else if(isset($_GET["Length"]))
{
  $length=sanitize($_GET["Length"]);
  $length=str_replace("+"," ",$length);
  $query=sprintf("SELECT * FROM BoardGame WHERE GameName Length= '%s'",$length);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $rowon=0;
  print("<table><tbody>");
  while($row=mysqli_fetch_assoc($result))
  {
    if($rowon%4==0)
    {
      print("<tr>");
    }
    print("<td align='center'><form method='get' action='ViewSpecificGame.php'>");
    print("<p>".$row["GameName"]."</p>");
    print("<p><img class='displayitem' src='".$row["ImageLocation"]."'</img></p>");
    print("<input type='hidden' name='Name' value='".$row["GameName"]."'>");
    print("<button type='submit'>View</button>");
    print("</form></td>");
    if($rowon%4==3)
    {
      print("</tr>");
    }
    $rowon=$rowon+1;
  }
  print("</tbody></table>");
}
else if(isset($_GET["Category"]))
{
  $category=sanitize($_GET["Category"]);
  $category=str_replace("_"," ",$category);
  $query=sprintf("SELECT * FROM CategoryTable WHERE CategoryName='%s' ORDER BY GameName ASC",$category);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $rowon=0;
  print("<table><tbody>");
  while($row=mysqli_fetch_assoc($result))
  {
    if($rowon%4==0)
    {
      print("<tr>");
    }
    print("<td align='center'><form method='get' action='ViewSpecificGame.php'>");
    print("<p>".$row["GameName"]."</p>");
    print("<p><img class='displayitem' src='".$row["ImageLocation"]."'</img></p>");
    print("<input type='hidden' name='Name' value='".$row["GameName"]."'>");
    print("<button type='submit'>View</button>");
    print("</form></td>");
    if($rowon%4==3)
    {
      print("</tr>");
    }
    $rowon=$rowon+1;
  }
  print("</tbody></table>");
}
else if(isset($_GET["searchtype"]))
{
    $query="";
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
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $rowon=0;
    print("<table><tbody>");
    while($row=mysqli_fetch_assoc($result))
    {
      if($rowon%4==0)
      {
        print("<tr>");
      }
      print("<td align='center'><form method='get' action='ViewSpecificGame.php'>");
      print("<p>".$row["GameName"]."</p>");
      print("<p><img class='displayitem' src='".$row["ImageLocation"]."'</img></p>");
      print("<input type='hidden' name='Name' value='".$row["GameName"]."'>");
      print("<button type='submit'>View</button>");
      print("</form></td>");
      if($rowon%4==3)
      {
        print("</tr>");
      }
      $rowon=$rowon+1;
    }
    print("</tbody></table>");
}
else
{
  $query="SELECT * FROM BoardGame ORDER BY GameName ASC";
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $rowon=0;
  print("<table><tbody>");
  while($row=mysqli_fetch_assoc($result))
  {
    if($rowon%4==0)
    {
      print("<tr>");
    }
    print("<td align='center'><form method='get' action='ViewSpecificGame.php'>");
    print("<p>".$row["GameName"]."</p>");
    print("<p><img class='displayitem' src='".$row["ImageLocation"]."'</img></p>");
    print("<input type='hidden' name='Name' value='".$row["GameName"]."'>");
    print("<button type='submit'>View</button>");
    print("</form></td>");
    if($rowon%4==3)
    {
      print("</tr>");
    }
    $rowon=$rowon+1;
  }
  print("</tbody></table>");
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
