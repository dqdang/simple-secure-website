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

   ob_start();
   session_start();

   $sql = "SELECT nonce, username, password FROM members WHERE username = '" . $_POST["username"] . "'";

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
   $secretFile = fopen("serverSecret", "r") or die("Unable to open file!: serverSecret.");
   $ss = fread($secretFile, 8192);
   $ss = trim($ss);
   $now = time();
   $decrypted = "";
   $open = fopen("publicKey" . $username, "r") or die("Unable to open file!:  publicKey" . $username);
   $publicKey = fread($open, 8192);
   fclose($open);
   fclose($secretFile);
   $decoded = base64_decode($_POST["password"]);
   openssl_public_decrypt($decoded, $decrypted, $publicKey);
   if(trim($decrypted) == trim($hash))
   {
      $msg = "Access granted.";
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + (30 * 60); // 30 min
      if(!isset($_COOKIE["username"]) && !isset($_COOKIE["password"]))
      {
         $cookie = hash("sha1", $ss . $_SESSION['expire'] . $username);
         setcookie("username", $username, time()+86313600, "/", "");
         setcookie("password", $cookie, time()+86313600, "/", "");
      }
      echo "nonce: " . $row["nonce"]. "; username: " . $row["username"]. "; password: " . $row["password"]. "<br>";
      // header("Location: /private.php");
   }
   else
   {
      $row = $result->fetch_assoc(); 
      echo "nonce: " . $row["nonce"]. "; username: " . $row["username"]. "; password: " . $row["password"]. "<br>"; 
      // header("Location: /LoginToZBoxlive.html");
   }
?>
<html>
   <head>
      <title>ZBoxlive.com</title>
   </head>
   <body>
      <p><?php echo $msg; ?></p>
      <p><a href = "LoginToZBoxlive.html">Back</a></p>
   </body>
</html>
