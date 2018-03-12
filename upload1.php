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

echo '<h2>[OK] token owners are now identified.</h2>';

echo '<p style="font-family: Courier, monospace;">';
print_r($_SESSION['owners']);
echo '</p>';

echo'<br>';

echo 'Please upload a .txt file listing accounts to ignore, separated by line breaks<br>';
?>

	<form action="upload2.php" method="POST" enctype="multipart/form-data">
		Select the .txt file to upload:
		<input type="file" name="fileToUpload" id="fileToUpload"><br><br>
		
		<input type="submit" value="Upload File" name="submit">
	</form>
</body>

</html>
