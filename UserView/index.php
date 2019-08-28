<?php
require("sessionstart.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>User Login</title>
</head>
<body>
<?php
require("sessionstart.php");
require("db.php");
if(isset($_POST["username"])&&isset($_POST["password"]))
{
  $username=$_POST["username"];
  $password=$_POST["password"];
  $username=sanitize($username);
  $password=sanitize($password);
  $password=md5($password);
  print("<p>".$username."</p>");
  print("<p>".$password."</p>");


  //$stmt = $db->prepare('SELECT Username,Password FROM UserTable');

  $query=sprintf("SELECT * FROM UserTable WHERE Username='%s' AND Password='%s'",$username,$password);
  $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
  $rows = mysqli_num_rows($result);
  print("<p>".$rows."</p>");
  if($rows==1)
  {
    $_SESSION["username"]=$username;
    $_SESSION["password"]=$password;
    $URL="Home.php";
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
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
<h2>User Login</h2>
<p>For security reasons all users must log in. If you have not received an account, you will not be able to log in. If you
believe this is an error, contact the designer of this website to receive an account.</p>
<form method="post">
<p>Username:<input name="username" type="text"></p>
<p>Password:<input name="password" type="password"></p>
<p><button onclick="submit">Log In</button></p>
</form>
</body>
</html>
