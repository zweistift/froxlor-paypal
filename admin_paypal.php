<?php
    define('AREA', 'admin');
	/**
	 * Include our init.php, which manages Sessions, Language etc.
	 */
	require("./lib/init.php");
	
	//Ist eine ID gesetzt?
	if(isset($_POST['id']))
	{	$id=intval($_POST['id']);
	}
	elseif(isset($_GET['id']))
	{	$id=intval($_GET['id']);
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
    if($page == "overview" && $action == NULL)
	{	//todo!
        //$result= $db->query('SELECT * FROM PP_ABO_TYPE');
        //$result= $db->query('SELECT * FROM panel_payment_abo');    
        eval("echo \"".getTemplate("modules/paypal/customer-top")."\";");
        $aboinfo= array();
        $aboinfo['customerid'] = "";  
        $abo_stmt = Database::prepare("SELECT c.customerid, c.loginname, c.name, c.firstname, c.company, a.ABO_DESC, c.hdl_abo_expire, c.hdl_abo_payed FROM panel_customers AS c LEFT JOIN panel_payment_abo AS a ON c.hdl_abo_type = a.PK_ABO_ID");
        Database::pexecute($abo_stmt, array("customerid" => $aboinfo['customerid'],));
        $row = array();
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            $customerid = $row["customerid"];
            $loginname = $row["loginname"];
            $name = $row["name"];
            $firstname = $row["firstname"];
            $company = $row["company"];
            $hdl_abo_type = $row["ABO_DESC"];
            $hdl_abo_expire = $row["hdl_abo_expire"];
            if($row["hdl_abo_payed"] == '0'){
                $hdl_abo_payed = "nicht aktiv";
            }
            else{
                $hdl_abo_payed = "aktiv";
            }
            //$id = $idna_convert->decode($row['aboid']);
            eval("echo \"".getTemplate("modules/paypal/customer-list")."\";");
        }
		eval("echo \"".getTemplate("modules/paypal/customer-bottom")."\";");
	}
    elseif($page == "overview" && $action == "delete" && !isset($_POST['send'])){
        //NUR ABO entfernen ++ Abfrage ob man das wirklich will??
        //Abfrage ob man wirklich loeschen will??
        $warnung = "M&ouml;chten Sie das Abo wirklich vom Kunden entfernen?<br><br>";
        $LINK = $linker->getLink(array('section' => 'billing_overview', 'page' => $page, 'action' => 'delete', 'id' => $id));
        ask_yesno($warnung, $LINK, array('id'=>$id, 'send'=>'send'));  
    }
    elseif($page == "overview" && $action == "delete" && isset($_POST['send']) && $_POST['send'] == 'send'){
        //loeschen genehmigt.
        //SQL Code zum loeschen hier platzieren.
        $aboinfo['id'] = "";
				
        //!to be fixed: If a subscription exist for a user, you can't delte an abo...
        //Database::pexecute($domains_stmt, array('cid' => $row['customerid'], 'stdd' => $row['standardsubdomain']));
        //$domains = $domains_stmt->fetch(PDO::FETCH_ASSOC);
        //$row['domains'] = intval($domains['domains']);
        
        
        $abo_stmt = Database::prepare("UPDATE panel_customers SET hdl_abo_expire = NULL, hdl_abo_payed = '0', hdl_abo_type = NULL  WHERE customerid = ".$id." ");
        Database::pexecute($abo_stmt, array('id' => $id));
        $umleitung = $linker->getLink(array('section' => 'billing_overview', 'page' => $page));
        header('Location: '.$umleitung.'');
    }



    elseif($page == "overview" && $action == "add" && !isset($_POST['send'])){
        //anzeige Formular zum machen oder so.
        $customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/modules/formfield.abo_add.php';
        $customer_add_form = htmlform::genHTMLForm($customer_add_data);
        
        eval("echo \"".getTemplate("modules/paypal/abos_add")."\";");
        
		eval("echo \"".getTemplate("modules/paypal/abos-bottom")."\";");
    }
    elseif($page == "overview" && $action == "add" && isset($_POST['send']) && $_POST['send'] = 'send'){
        
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

    elseif($page == "overview" && $action == "edit" && !isset($_POST['send'])){
        //aenderungenformular anzeigen
        //anzeige Formular zum machen oder so.
        $subs= array();
        $subs['customerid'] = "";  
        $abo_stmt = Database::prepare("SELECT customerid, loginname, name, firstname, company, hdl_abo_type FROM panel_customers WHERE customerid = '".$id."'");
        Database::pexecute($abo_stmt, array("customerid" => $subs['customerid'],));
        $row = array();
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            $name = $row['name'];
            $firstname = $row['firstname'];
            $company = $row['company'];
            $username = $row['loginname'];
            $abo = $row['hdl_abo_type'];
        }
        
        
        $subs= array();
        $subs['customerid'] = "";  
        $abo_stmt = Database::prepare("SELECT PK_ABO_ID, ABO_DESC FROM panel_payment_abo");
        Database::pexecute($abo_stmt, array("PK_ABO_ID" => $subs['customerid'],));
        $row = array();
        $abo_options = "";
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            if($row['PK_ABO_ID'] == $abo){
            $abo_options .= makeoption($row['ABO_DESC'], $row['PK_ABO_ID'],true, null, true, true);
            }
            else{
            $abo_options .= makeoption($row['ABO_DESC'], $row['PK_ABO_ID'], null, true, true);
            }
        }
        
        
        
        
        
        
        $customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/modules/formfield.customer_aboedit.php';
        $customer_add_form = htmlform::genHTMLForm($customer_add_data);
        
        eval("echo \"".getTemplate("modules/paypal/customerabo_edit")."\";");
        
		eval("echo \"".getTemplate("modules/paypal/customer-bottom")."\";");
    }
    elseif($page == "overview" && $action == "edit" && isset($_POST['send']) && $_POST['send'] = 'send'){
        //formular aenderungen speichern...
        $abowish = $_POST['abo-wish'];
        $paypal = $_POST['paypal'];
        
        
        $abo_stmt = Database::prepare("UPDATE panel_customers SET hdl_abo_type = '".$abowish."' WHERE customerid = '".$id."'");
        Database::pexecute($abo_stmt, array('id' => $id));
        
        
        $umleitung = $linker->getLink(array('section' => 'billing_overview', 'page' => $page));
        header('Location: '.$umleitung.'');
        
        
    }





    else{
        $umleitung = $linker->getLink(array('section' => 'billing', 'page' => $page));
        header('Location: '.$umleitung.'');
    }
?>
