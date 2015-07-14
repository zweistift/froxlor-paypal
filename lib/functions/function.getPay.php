<?php
function getPay($userinfo){
	if($userinfo == 'admin'){$userinfo = "web1";}
	//$test = phpinfo(INFO_MODULES);
	//return $test;
	$db = new mysqli('localhost','root','20simonX15','froxlor');
	if($db->connect_errno > 0){
    	return('Unable to connect to database [' . $db->connect_error . ']');
	}
$sql = <<<SQL
    SELECT *
    FROM `panel_customers`
    where loginname = '$userinfo'
SQL;

if(!$result = $db->query($sql)){
    return('There was an error running the query [' . $db->error . ']');
}
while($row = $result->fetch_assoc()){
    $datum = date_create($row['hdl_abo_expire']);
    $date = date_format($datum,"d M Y");
    return $date;
}
}
?>