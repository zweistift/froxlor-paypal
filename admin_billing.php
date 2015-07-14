<?php
    define('AREA', 'admin');
	/**
	 * Include our init.php, which manages Sessions, Language etc.
	 */
	require("./lib/init.php");
	
	
	if(isset($_POST['id']))
	{	$id=intval($_POST['id']);
	}
	elseif(isset($_GET['id']))
	{	$id=intval($_GET['id']);
	}
	
	if($page == "overview")
	{	//todo!	
		eval("echo \"".getTemplate("modules/paypal/overview")."\";");
	}
    if($page == "invoices")
	{	//todo!	
		eval("echo \"".getTemplate("modules/paypal/overview")."\";");
	}
    if($page == "notifications")
	{	//todo!	
		eval("echo \"".getTemplate("modules/paypal/overview")."\";");
	}
    if($page == "abos" && $action == NULL)
	{	//todo!
        //$result= $db->query('SELECT * FROM PP_ABO_TYPE');
        //$result= $db->query('SELECT * FROM panel_payment_abo');    
        eval("echo \"".getTemplate("modules/paypal/abos-top")."\";");
        $aboinfo= array();
        $aboinfo['pk_abo_id'] = "";  
        $abo_stmt = Database::prepare("SELECT * FROM panel_payment_abo");
        Database::pexecute($abo_stmt, array("PK_ABO_ID" => $aboinfo['pk_abo_id'],));
        $row = array();
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            $pk_abo_id = $row["PK_ABO_ID"];
            $abo_kurz = $row["ABO_KURZ"];
            $abo_desc = $row["ABO_DESC"];
            $abo_costs_mth = $row["ABO_COSTS_MTH"];
            $abo_costs_year = $row["ABO_COSTS_YEAR"];
            //$id = $idna_convert->decode($row['aboid']);
            eval("echo \"".getTemplate("modules/paypal/abos-list")."\";");
        }
		eval("echo \"".getTemplate("modules/paypal/abos-bottom")."\";");
	}
    elseif($page == "abos" && $action == "delete" && !isset($_POST['send'])){
        $pk_abo_id = $_GET['id'];
        //Abfrage ob man wirklich loeschen will??
        $warnung = "M&ouml;chten Sie das Abo wirklich l&ouml;schen?<br><br>";
        $LINK = $linker->getLink(array('section' => 'billing', 'page' => $page, 'action' => 'delete', 'id' => $pk_abo_id));
        ask_yesno($warnung, $LINK, array('id'=>$id, 'send'=>'send'));  
    }
    elseif($page == "abos" && $action == "delete" && isset($_POST['send']) && $_POST['send'] == 'send'){
        //loeschen genehmigt.
        $pk_abo_id = $_GET['id'];
        //SQL Code zum loeschen hier platzieren.
        $aboinfo['pk_abo_id'] = "";
        $domains_stmt = Database::prepare("
					SELECT COUNT(`id`) AS `domains`
					FROM `" . TABLE_PANEL_DOMAINS . "`
					WHERE `customerid` = :cid
					AND `parentdomainid` = '0'
					AND `id`<> :stdd"
				);
				
        //!to be fixed: If a subscription exist for a user, you can't delte an abo...
        //Database::pexecute($domains_stmt, array('cid' => $row['customerid'], 'stdd' => $row['standardsubdomain']));
        //$domains = $domains_stmt->fetch(PDO::FETCH_ASSOC);
        //$row['domains'] = intval($domains['domains']);
        
        
        $abo_stmt = Database::prepare("DELETE FROM panel_payment_abo WHERE PK_ABO_ID = '".$pk_abo_id."' ");
        Database::pexecute($abo_stmt, array('id' => $id));
        $umleitung = $linker->getLink(array('section' => 'billing', 'page' => $page));
        header('Location: '.$umleitung.'');
    }
    elseif($page == "abos" && $action == "add" && !isset($_POST['send'])){
        //anzeige Formular zum machen oder so.
        $customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/modules/formfield.abo_add.php';
        $customer_add_form = htmlform::genHTMLForm($customer_add_data);
        
        eval("echo \"".getTemplate("modules/paypal/abos_add")."\";");
        
		eval("echo \"".getTemplate("modules/paypal/abos-bottom")."\";");
    }
    elseif($page == "abos" && $action == "add" && isset($_POST['send']) && $_POST['send'] = 'send'){
        
        $code = $_POST['code'];
        $description = $_POST['description'];
        $costs = $_POST['costs'];
        if(isset($_POST['costy'])){
            $costy = $_POST['costy'];
            $yearset = true;
        }
        $paypal = $_POST['paypal'];
        
        $abo_stmt = Database::prepare("INSERT INTO panel_payment_abo (ABO_KURZ, ABO_DESC, ABO_COSTS_MTH, PayPal_Code) VALUES ('".$code."', '".$description."', '".$costs."', '".$paypal."')");
        Database::pexecute($abo_stmt, array('id' => $id));
        
        $umleitung = $linker->getLink(array('section' => 'billing', 'page' => $page));
        header('Location: '.$umleitung.'');
        
        
    }
    elseif($page == "abos" && $action == "edit" && $_GET['state'] == 'edit'){
        $id = $_GET['id'];
        $aboinfo= array();
        $aboinfo['pk_abo_id'] = "";  
        $abo_stmt = Database::prepare('SELECT * FROM panel_payment_abo WHERE PK_ABO_ID ="'.$id.'"');
        Database::pexecute($abo_stmt, array("PK_ABO_ID" => $aboinfo['pk_abo_id'],));
        $row = array();
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            $pk_abo_id = $row["PK_ABO_ID"];
            $abo_kurz = $row["ABO_KURZ"];
            $abo_desc = $row["ABO_DESC"];
            $abo_costs_mth = $row["ABO_COSTS_MTH"];
            $abo_costs_year = $row["ABO_COSTS_YEAR"];
            $paypal = $row["PayPal_Code"];
            //$id = $idna_convert->decode($row['aboid']);
        }
        $customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/modules/formfield.abo_edit.php';
        $customer_add_form = htmlform::genHTMLForm($customer_add_data);
        eval("echo \"".getTemplate("modules/paypal/abos_edit")."\";");
        
		eval("echo \"".getTemplate("modules/paypal/abos-bottom")."\";");
    }
    elseif($page == "abos" && $action == "edit" && $_GET['state'] == 'save' && $_POST['send'] == 'send'){
        if(isset($_GET['id'])){$id = $_GET['id'];}
        if(isset($_POST['id'])){$id = $_POST['id'];}
        $code = $_POST['code'];
        $description = $_POST['description'];
        $costs = $_POST['costs'];
        if(isset($_POST['costy'])){
            $costy = $_POST['costy'];
            $yearset = true;
        }
        $paypal = $_POST['paypal'];
        
        if(isset($id)){
        $abo_stmt = Database::prepare("UPDATE panel_payment_abo SET ABO_KURZ = '".$code."', ABO_DESC = '".$description."' , ABO_COSTS_MTH = '".$costs."' , PayPal_Code = '".$paypal."' WHERE PK_ABO_ID=\"".$id."\"");
        Database::pexecute($abo_stmt, array('id' => $id));
        }
        $umleitung = $linker->getLink(array('section' => 'billing', 'page' => $page));
        header('Location: '.$umleitung.'');
        
        
    }
    else{
        $umleitung = $linker->getLink(array('section' => 'billing', 'page' => $page));
        header('Location: '.$umleitung.'');
    }
?>
