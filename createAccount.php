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
   $username = "";
   $password = "";
   $hash = "";

   $config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 1024,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

   $username = $_POST["username"];
   $password = $_POST["password"];
   $publicKey = $_POST["publicKey"];
   $publicKey[26] = PHP_EOL;
   $publicKey[-25] = PHP_EOL;
   $key = fopen("publicKey" . $username, "w") or die("Unable to open file!:  publicKey" . $username);
   fwrite($key, $publicKey);
   fclose($key);
   $read = fopen("publicKey" . $username, "r") or die("Unable to open file number 2!:  publicKey" . $username);
   $publicKey = fread($read, 8192);
   fclose($read);
   $res = openssl_get_publickey($publicKey);
   $decoded = base64_decode($password);
   openssl_public_decrypt($decoded, $decrypted, $res);

   $sql = "SELECT nonce FROM members ORDER BY nonce DESC LIMIT 1";

   $result = $connection->query($sql);
   $row = $result->fetch_assoc();
   $nonce =  $row["nonce"] + 1;

   $sql = "INSERT INTO members (nonce, username, password) VALUES ($nonce, '". $_POST["username"] . "','" . $decrypted . "');";
   if(mysqli_query($connection, $sql))
   {
      echo "Records inserted successfully";
   }
   else
   {
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
   }
   // $file = fopen("hashes", "r+") or die("Unable to open file!");
   // while(fgets($file) != null)
   // {
   //    continue;
   // }

   // fwrite($file, $username . ";");
   // fwrite($file, $password . "\n");
   // fclose($file);
   // $res = openssl_pkey_new($config);
   // openssl_pkey_export($res, $privkey);
   // $key = fopen("privateKey" . $username, "w") or die("Unable to open file!");
   // fwrite($key, $privkey);
   // fclose($key);

   // $pubkey = openssl_pkey_get_details($res);
   // $pubkey = $pubkey["key"];
   // $key = fopen("publicKey" . $username, "w") or die("Unable to open file!");
   // fwrite($key, $pubkey);
   // fclose($key);
   echo "<p>Go to <a href = 'LoginToZBoxlive.html'>LoginToZBoxlive.html</a>.</p>";
   echo "<p>Go back to <a href = 'createAccount.html'>createAccount.html</a>.</p>";

?>
<html>
   <head>
      <title>Create Account</title>
   </head>
</html>