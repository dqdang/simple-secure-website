<?php
   ob_start();
   session_start();
?>

<html>
   
   <head>
      <title>Private</title>
      
   </head>
	
   <body>
      <?php
      $server = "localhost";
      $rootUser = "dqdang";
      $rootPass = "e38ad214943daad1d64c102faec29de4afe9da3d";
      $dbname = "cs683";

      $connection = new mysqli($server, $rootUser, $rootPass, $dbname);
      if($connection->connect_error)
      {
         die("Connection failed: " . $connection->connect_error);
      }

      $sql = "SELECT nonce, username, password FROM members WHERE username = '" . $_COOKIE["username"] . "'";

      $result = $connection->query($sql);
      if($result->num_rows == 1)
      {
         $row = $result->fetch_assoc();
         $username = $row["username"];
         $hash = $row["password"];
      }
      else
      {
         while($row = $result->fetch_assoc())
         {
             echo "nonce: " . $row["nonce"]. "; username: " . $row["username"]. "; password: " . $row["password"]. "<br>";
         }
      }

      $msg = "";
      $secret = fopen("serverSecret", "r") or die("Unable to open file!");
      $ss = fread($secret, 8192);
      $ss = trim($ss);
      $cookie = hash("sha1", $ss . $_SESSION['expire'] . $username);
      fclose($file);
      fclose($secret);
      $now = time();

      if(isset($_COOKIE["username"]) && isset($_COOKIE["password"]) && $_COOKIE["username"] == $username && $_COOKIE["password"] == $cookie && $now < $_SESSION['expire'])
      {
         echo $_COOKIE["username"] . "<br/>";
         echo $_COOKIE["password"];
      }
      ?>
      <p><a href = "/">Back</a><br />
      <a href = "clear.php">Logout</a></p>
   </body>
</html>
