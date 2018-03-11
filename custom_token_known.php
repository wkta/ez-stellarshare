<!doctype html>
<html>

<?php 
include __DIR__.'/stellar-api/vendor/autoload.php';

session_start();

$asset_code = $_POST['asset_code'];
$issuer_id = $_POST['issuer_id'];

use ZuluCrypto\StellarSdk\XdrModel\Asset;
$adhoc_asset = Asset::newCustomAsset($asset_code, $issuer_id);

$_SESSION['priv_key'] = $privkey = $_POST['priv_key'];


/*
	at this point we know which token owners should be rewarded,
	what is the asset we focus on,
	and where the lumens we shall distribute are coming from…
	
	Using Stellar-api, let's compute:
	- how much XLM total we distribute (stored in $total_sum variable)
	- how much each account shall receive, based on his current token investment (stored in the $giveouts array)
*/


use ZuluCrypto\StellarSdk\Keypair;
use ZuluCrypto\StellarSdk\Server;

$server = Server::publicNet();
//$server2 = Server::testNet();


$balances = array();
$the_sum = 0;
foreach ($_SESSION['kept'] as $adr_str){
	// let's loop over all accounts that shall receive somethin
	// and sum it all
	$account = $server->getAccount($adr_str);
	//print 'Balances for account ' . $adr_str . PHP_EOL;

	$value = $account->getCustomAssetBalanceValue($adhoc_asset);
	if ($value == null){
		var_dump($value);
		throw new Exception('unexpected value type, check if your issuer_id public addr is correct!');
	}
	$balances[$adr_str] = $value;  // let's associate each acc to its custom asset balance
	$the_sum += $value;
}

// for each acc, computes the ratio of custom tokens owned
$ratios = array();
foreach ($_SESSION['kept'] as $adr_str){
	$ratios[$adr_str] = $balances[$adr_str] / $the_sum;
}

// let's compute the amount of XLM to be distributed,
//  based on the current XLM balance of the temp account
$temp_keypair = Keypair::newFromSeed($privkey);
$temp_acc_publickey = $temp_keypair->getAccountId();
$temp_acc = $server->getAccount($temp_acc_publickey);
$xlm_quantity = $temp_acc->getNativeBalance();

$MINIMUM_BALANCE = 1.0;
$xlm_distrib_theory = $xlm_quantity - 0.005*$xlm_quantity - $MINIMUM_BALANCE;  // tiny fee

// what shall we give to each token owner?
$giveouts = array();
$distrib_practice = 0;
$NB_DIGITS = 3;  // smallest unit we're using is 0.001

foreach ($_SESSION['kept'] as $adr_str){
	$tmpvar = round($ratios[$adr_str] * $xlm_distrib_theory, $NB_DIGITS, PHP_ROUND_HALF_DOWN);
	$giveouts[$adr_str] = $tmpvar;
	$distrib_practice += $tmpvar;
}

echo "Temporary account $temp_acc_publickey used for distribution contains $xlm_quantity XLM.";
?>

<h2>Summary</h2>
<?php
$_SESSION['giveouts'] = $giveouts;  // save this info. in order to proceed for payment if the user clicks YES
$_SESSION['bh_pub_key'] = 'GDFEAHGRYKS73TU2YXXFT6GROD6FVEVD5SF6U7CPLEPADB6VR52V6QR7';  // temp account will be merge into this one

$fees = round($xlm_quantity - $distrib_practice, $NB_DIGITS);
$nb_owners = count($giveouts);
echo "$distrib_practice XLM will be distributed among $nb_owners token owners, considering $asset_code token units represent a share.<br>";
echo "<table style=\"border:1px solid black;\">";
echo "<tr><th>destination account</th><th>amount to be paid</th></tr>";
foreach ($giveouts as $tmpaddr => $single_giveout){
		echo "<tr><td>$tmpaddr</td><td>$single_giveout</td></tr>";
}
echo "</table>";
echo "Service fees (estimate) are: $fees XLM<br>";
echo "Warning! Temporary account $temp_acc_publickey used for distribution will be destroyed."
?>

<br><br>
<font style="color:red; font-size:1em;">Proceed for payment?</font>

<br><br>
<button name="yes_button" onclick="location.href='proceed.php'">YES</button>&nbsp; &nbsp; &nbsp;
<button name="no_button"  onclick="location.href='index.php'">NO</button>

<p>
Important notice: if you proceed, the next page may take several minutes to load.
This is due the iterated interaction with the Stellar Horizon Server.<br>
Please be patient, do not reload the webpage or close browser!
</p>

</html>