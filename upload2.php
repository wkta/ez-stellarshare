<!DOCTYPE html>
<html>
<body>

<?php
// reset session if necessary
session_start();

if (! isset($_SESSION['owners']) ) {
	session_destroy();
	throw new Exception('cannot find token owners info. Please restart script.');
}
else {
	$_SESSION['to_be_ignored'] = array();
	$fp = fopen($_FILES['fileToUpload']['tmp_name'], 'r');
	while ($line = fgets($fp)) {
		array_push($_SESSION['to_be_ignored'], trim($line)); 
	}
	fclose($fp);
	
	function keep_acc($acc_tested){
		global $_SESSION;
		if (in_array($acc_tested, $_SESSION['to_be_ignored'])){
			return False;
		}
		return True;
	}

	$_SESSION['kept'] = array_filter($_SESSION['owners'], "keep_acc");
	echo "[OK] some accounts were ignored<br>\n";
	var_dump($_SESSION['kept']);
	echo "<br>\n<h2>Please designate the Asset (e.g. HUG or GTshare) playing the role of a share</h2>";
	
}
// -------------- fin code PHP
?>


	<form action="custom_token_known.php" method="POST">
	
		Asset code (this asset will play the role of a "share"):<br>
		<input type="text" name="asset_code" value="GTshare" maxlength="12" size="12"><br>

		Public addr. of the ISSUER:<br>
		<input type="text" name="issuer_id" value="" maxlength="56" size="56">

		<h2>Please designate the private key of the temporary account holding Stellar lumens to be distributed.</h2>
		<p>
		Warning! The temporary account's funds will all be spent to pay dividends,
		the temporary account will then be automatically destroyed!
		Be sure this account contains the right amount of XLM.
		</p>
	  
		Private key of the temporary account containing XLM to be distributed:<br>
		<input type="text" name="priv_key" value="" maxlength="56" size="56"><br>

		<input type="submit" value="Submit">
	
	</form> 

</body>

</html>