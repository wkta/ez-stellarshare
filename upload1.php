<!DOCTYPE html>
<html>
<body>

<?php
// reset session if necessary
session_start();
if ( isset($_SESSION['owners'])  ) {
	session_destroy();
}

session_start();
// saving info. into current session
$_SESSION['owners'] = array();
 
$fp = fopen($_FILES['fileToUpload']['tmp_name'], 'r');
while ($line = fgets($fp)) {
	// echo "$line<br>";
	array_push($_SESSION['owners'], trim($line)); 
}
fclose($fp);

echo '[OK] token owners are now identified.';
var_dump($_SESSION['owners']);
echo'<br>';
echo 'Please upload a .txt file listing accounts to ignore, separated by line breaks<br>';
?>

	<form action="upload2.php" method="POST" enctype="multipart/form-data">
		Select image to upload:
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload File" name="submit">
	</form>
</body>

</html>
