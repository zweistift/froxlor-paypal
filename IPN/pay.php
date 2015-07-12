<?php
function getPayOverview($froxlor_client_details, $session){
	$froxlor_login_name = $froxlor_client_details['loginname'];
    
    if (isset($froxlor_client_details['customerid'])) {
        $froxlor_user_id = $froxlor_client_details['customerid'];
        
	$froxlor_already_payed = 1;
    
    
	if($froxlor_login_name == "admin"){
	// do nothing or set userid to web1
	$froxlor_login_name = "web1";
	}

	$db = new mysqli('localhost', 'root', '20simonX15','froxlor');
	if($db->connect_errno > 0){
		return("Verbindung zur Datenbank nicht moeglich. Fehler".$db->connect_error);
	}
    $sql = "SELECT * FROM vKundenabos WHERE Kundennummer = ".$froxlor_user_id.";";
		
	if(!$result = $db->query($sql)){
		return("Problem beim Query aufgetreten".$db->error);	
	}
	
	while($row = $result->fetch_assoc()){
		$datum = date_create($row['Ablauf']);
		$payment_expire_date = date_format($datum,"d M Y");
        $payment_abo_desc = $row['Abo Beschreibung'];
        $payment_abo_kurz = $row['AboZeichen'];
        $payment_abo_amount = $row['Kosten'];
        $payment_abo_amount_year = $payment_abo_amount * 12;
        $froxlor_already_payed = $row['Bezahlt'];
	}
	$button_hdl_small = "<form id=\"paypal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\"><input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\"><input type=\"hidden\" name=\"custom\" value=\"".$froxlor_user_id."\"><input type=\"hidden\" name=\"hosted_button_id\" value=\"RJBFU6EUQTFA4\"><input type=\"image\" src=\"https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_m.png\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\"><img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\"></form>";
        
        
        
        
	$button_hdl_medium = "<form id=\"paypal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\"><input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\"><input type=\"hidden\" name=\"custom\" value=\"".$froxlor_user_id."\"><input type=\"hidden\" name=\"hosted_button_id\" value=\"7N9WNQ2A6CZLG\"><input type=\"image\" src=\"https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_m.png\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\"><img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\"></form>";
        
    $button_hdl_large = "<form id=\"paypal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\"><input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\"><input type=\"hidden\" name=\"custom\" value=\"".$froxlor_user_id."\"><input type=\"hidden\" name=\"hosted_button_id\" value=\"7N9WNQ2A6CZLG\"><input type=\"image\" src=\"https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_m.png\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\"><img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\"></form>";
        
    $button_hdl_xtralarge = "<form id=\"paypal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\"><input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\"><input type=\"hidden\" name=\"custom\" value=\"".$froxlor_user_id."\"><input type=\"hidden\" name=\"hosted_button_id\" value=\"7N9WNQ2A6CZLG\"><input type=\"image\" src=\"https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_m.png\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\"><img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\"></form>";
        
    $button_unsubscribe = "<A HREF=\"https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=K87NQABLHP6GY\">Abo beenden</A>";

    $button_test = "<form id=\"paypal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\"><input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\"><input type=\"hidden\" name=\"custom\" value=\"".$froxlor_user_id."\"><input type=\"hidden\" name=\"hosted_button_id\" value=\"JBEE6F32NSU6Y\"><input type=\"image\" src=\"https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_m.png\" border=\"0\" name=\"submit\" alt=\"PayPal - The safer, easier way to pay online!\"><img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/en_US/i/scr/pixel.gif\" width=\"1\" height=\"1\"></form>";
        
    switch($payment_abo_kurz){
    case "S":
        $button = $button_hdl_small;
        break;
    case "M":
        $button = $button_hdl_medium;
        break;
    case "L":
        $button = $button_hdl_large;
        break;
    case "XL":
        $button = $button_hdl_xtralarge;
        break;
    case "XXX":
        $button = $button_test;
        break;
    default:
        $button = $button_hdl_small;
        break;
    }
    

    //$button_hdl_small = "<a href="">Mit Paypal bezahlen</a>";
	$ausgabe = "<table class=\"dboarditem\"><thead><tr><th colspan=\"2\">Abrechnung</th></tr></thead>";
    $ausgabe = $ausgabe."<tbody>";
	$ausgabe = $ausgabe."<tr><td>Kundennummer</td><td>00".$froxlor_user_id."</td></tr>";
    $ausgabe = $ausgabe."<tr><td>Abo-Typ</td><td>".$payment_abo_desc."</td></tr>";
    $ausgabe = $ausgabe."<tr><td>Session</td><td>".$session."</td></tr>";
    $ausgabe = $ausgabe."<tr><td>Abokosten</td><td>".$payment_abo_amount." CHF/Monat | ".$payment_abo_amount_year." CHF/Jahr</td></tr>";
    $ausgabe = $ausgabe."<tr><td>Abo l&auml;uft aus</td><td>".$payment_expire_date."</td></tr>";
    //$ausgabe = $ausgabe."<tr><td>Zahlungsart</td><td>PayPal <a href=\"#\">Verl&auml;ngern</a></td></tr>";
    $ausgabe = $ausgabe."<tr><td>Warnung</td><td>Bitte beachten sie dass die Daten zuerst mit unserem System abgeglichen werden!</td></tr>";
    if($froxlor_already_payed == 1){
        $ausgabe = $ausgabe."<tr><td>Status</td><td>Abo Aktiv</td></tr>";
        $ausgabe = $ausgabe."<tr><td>Beenden</td><td>".$button_unsubscribe."</td></tr>";
    }
    else{
        $ausgabe = $ausgabe."<tr><td>Status</td><td>Abo nicht aktiv</td></tr>";
        $ausgabe = $ausgabe."<tr><td>Aktivation</td><td>".$button."</td></tr>";
        
    }
    $ausgabe = $ausgabe."<tbody></table>";
	return $ausgabe;
    }
    else{
        $froxlor_user_id = 0;
        return "";
    }
	

}
?>



