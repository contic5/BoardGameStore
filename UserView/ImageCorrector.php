<html>
<head>

</head>
<body>
<?php
$conn=mysqli_connect("localhost", "cjcuser", "computing", "BoardGameDatabase");
$query="SELECT * FROM BoardGame";
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
$games=array();
$imagelocations=array();
while($row = mysqli_fetch_assoc($result))
{
  print($row["GameName"]);
  array_push($games,$row["GameName"]);
  array_push($imagelocations,$row["ImageLocation"]);
}
$query="SELECT * FROM CategoryTable";
$result=mysqli_query($conn,$query) or die(mysqli_error($conn));
print(count($games));
while($row = mysqli_fetch_assoc($result))
{
  for($i=0;$i<count($games);$i++)
  {
    if($games[$i]==$row["GameName"])
    {
      $curgame=$games[$i];
      $curimagelocation=$imagelocations[$i];
      $query2="UPDATE CategoryTable SET ImageLocation='$curimagelocation' WHERE GameName='$curgame'";
      $result2 = mysqli_query($conn,$query2) or die(mysqli_error($conn));
      print("<p>Update made</p>");
    }
  }
}
?>
</body>
</html>
