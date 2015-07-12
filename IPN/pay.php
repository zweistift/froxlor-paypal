<?php
// NOTE: THIS FILE IS PROPERTY OF PAYPAL. I INSERTED SOME SPECIFIC THINGS.
// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.
define("DEBUG", 0);
// Set to 0 once you're ready to go live
define("USE_SANDBOX", 0);
define("LOG_FILE", "./ipn.log");
// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}
// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data
if(USE_SANDBOX == true) {
	$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
	$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}
$ch = curl_init($paypal_url);
if ($ch == FALSE) {
	return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
if(DEBUG == true) {
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}
// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.
//$cert = __DIR__ . "./cacert.pem";
//curl_setopt($ch, CURLOPT_CAINFO, $cert);
$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
	{
	if(DEBUG == true) {	
		error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
	}
	curl_close($ch);
	exit;
} else {
		// Log the entire HTTP response if debug is switched on.
		if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
			error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
		}
		curl_close($ch);
}
// Inspect IPN validation result and act accordingly
// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp ($res, "VERIFIED") == 0) {
	// check whether the payment_status is Completed
	// check that txn_id has not been previously processed
	// check that receiver_email is your PayPal email
	// check that payment_amount/payment_currency are correct
	// process payment and mark item as paid.
	// assign posted variables to local variables
	
//Define the vars, bq database will be filled. and no erros. haha.	
    $item_name = "";
    $item_number = "";
    $payment_amount = "";
    $paypal_currency = "";
    $client = "";
    $txn_type = "";
    $payer_id= "";
    $next_payment_date = "";
    $recurring_payment_id = "";
    $subscr_id = "";
    if (!empty($_POST["item_name"])) {$item_name = $_POST['item_name'];}
    if (!empty($_POST["item_number"])) {$item_number = $_POST['item_number'];}
    if (!empty($_POST["mc_gross"])) {$payment_amount = $_POST['mc_gross'];}
    if (!empty($_POST["mc_currency"])) {$payment_currency = $_POST['mc_currency'];}
    if (!empty($_POST["custom"])) {$client = $_POST['custom'];}
    if (!empty($_POST["txn_type"])) {$txn_type = $_POST['txn_type'];}
    if (!empty($_POST["payer_id"])) {$payer_id = $_POST['payer_id'];} 
    if (!empty($_POST["next_payment_date"])) {$next_payment_date = $_POST['next_payment_date'];} 
    if (!empty($_POST["time_created"])) {$time_created = $_POST['time_created'];} 
    if (!empty($_POST["recurring_payment_id"])) {$recurring_payment_id = $_POST['recurring_payment_id'];} 
    if (!empty($_POST["subscr_id"])) {$subscr_id = $_POST['subscr_id'];} 
    $payment_status = $_POST['payment_status'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    
    //I wrote a Function to connect.
function database($db, $query){
  $location = "localhost";
  $username = "";
  $password = "";
  if (isset($db) && isset($query)){
    $connection = new mysqli($location, $username, $password, $db);
    if($connection->connect_errno > 0){
      return("DB Connection Error");
    }
    $sql = $query;
    if(!$result = $connection->query($sql)){
      return("SQL Querr Error");
    }
  }
  else{
    return("Idiot. You forgot to insert a Query or a DB-Name);
  }
}
    
   if($payment_status == 'Completed'){
   	$insert = "INSERT INTO paypal_transactions (txn_id, payer_id, payment_status, receiver_mail, custom, txn_type, next_payment_date, time_created, reccuring_payment_id, amount, subscr_id) VALUES (\"".$txn_id."\", \"".$payer_id."\", \"".$payment_status."\", \"".$receiver_email."\", \"".$client."\", \"".$txn_type."\", \"".$next_payment_date."\", \"".$time_created."\", \"".$reccuring_payment_id."\", \"".$payment_amount."\", \"".$subscr_id."\");";
        database("froxlor", $insert);
  }
  else{
        $insert = "INSERT INTO paypal_notifications (txn_id, payer_id, payment_status, receiver_mail, custom, txn_type, next_payment_date, time_created, reccuring_payment_id, amount) VALUES (\"".$txn_id."\", \"".$payer_id."\", \"".$payment_status."\", \"".$receiver_email."\", \"".$client."\", \"".$txn_type."\", \"".$next_payment_date."\", \"".$time_created."\", \"".$reccuring_payment_id."\", \"".$payment_amount."\", \"".$subscr_id."\");";
        database("froxlor", $insert);
  }
  if(DEBUG == true) {
	error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
	}
} else if (strcmp ($res, "INVALID") == 0) {
	// log for manual investigation
	// Add business logic here which deals with invalid IPN messages
	if(DEBUG == true) {
		error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
	}
}
?>
