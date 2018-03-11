<?php 
include __DIR__.'/stellar-api/vendor/autoload.php';

use phpseclib\Math\BigInteger;
use ZuluCrypto\StellarSdk\Keypair;
use ZuluCrypto\StellarSdk\Server;
use ZuluCrypto\StellarSdk\XdrModel\Operation\PaymentOp;

// extract useful info. from session
session_start();
$bh_acc_pk = $_SESSION['bh_pub_key'];
$provider_acc_privk = $_SESSION['priv_key'];
$giveouts = $_SESSION['giveouts'];

// lumens come from here…
$server = Server::publicNet();
$sourceKeypair = Keypair::newFromSeed($provider_acc_privk);
$provider_acc_pk = $sourceKeypair->getPublicKey();

// proceed for all payments to dest accounts
foreach($giveouts as $destinationAccountId => $custom_amount){
	
	// this line is useful since it checks if the destination account exists
	$destinationAccount = $server->getAccount($destinationAccountId);
	
	// let's build the payment transaction
	// we still have to convert float to BigInteger representing stroops
	
	$numeric_str = number_format ($custom_amount*10**7, 0, "", "");  // no separators, no decimals int $decimals = 0 , string $dec_point = "." , 
	$stroops = new BigInteger($numeric_str);
	echo 'executing payment: &nbsp; &nbsp;';
	echo "$destinationAccountId ... $stroops stroops<br>\n";
	
	$trans = $server->buildTransaction($provider_acc_pk)
		->addOperation(
			PaymentOp::newNativePayment($destinationAccountId, $stroops)
		);
	// Sign and submit the transaction
	$response = $trans->submit($sourceKeypair->getSecret());
}

// merge what funds remain in the provider account, into the bh_acc
$fromKeypair = $sourceKeypair;
$destinationKeypair = Keypair::newFromPublicKey($bh_acc_pk);

echo 'Merging...<br>';
$tmptmp = $sourceKeypair->getAccountId();
echo "temporary account $tmptmp removed.<br><br>";

// Transfer balance from $fromKeypair to $destinationKeypair
$server->buildTransaction($fromKeypair)
	->addMergeOperation($destinationKeypair)
	->submit($fromKeypair);

// display OK msg
echo "$cpt done OK. Temporary account was merged!<br>Lumen dividend process terminated.<br>" . PHP_EOL;
?>