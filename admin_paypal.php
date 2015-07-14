<?php
    define('AREA', 'admin');
	require("./lib/init.php");
	//Ist eine ID gesetzt?
	if(isset($_POST['id'])){
        $id=intval($_POST['id']);
	}
	elseif(isset($_GET['id'])){
        $id=intval($_GET['id']);
	}
    
    //MAIN PART
    
    //Page: Subscriptions Ueberblick
    if($page == "subscriptions" && $action == NULL){	  
        eval("echo \"".getTemplate("modules/paypal/subscription-top")."\";");
        $aboinfo= array();
        $aboinfo['pk_abo_id'] = "";  
        $abo_stmt = Database::prepare("SELECT * FROM PP_ABO_TYPE");
        Database::pexecute($abo_stmt, array("PK_ABO_ID" => $aboinfo['pk_abo_id'],));
        $row = array();
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            $pk_abo_id = $row["PK_ABO_ID"];
            $abo_kurz = $row["ABO_KURZ"];
            $abo_desc = $row["ABO_DESC"];
            $abo_costs_mth = $row["ABO_COSTS_MTH"];
            $abo_costs_year = $row["ABO_COSTS_YEAR"];
            $abo_paypal_code = $row["ABO_PAYPAL_CODE"];
            //$id = $idna_convert->decode($row['aboid']);
            eval("echo \"".getTemplate("modules/paypal/subscription-element")."\";");
        }
		eval("echo \"".getTemplate("modules/paypal/subscription-bottom")."\";");
	}
    
    //Page: Subscriptions -> delete::Are you sure?
    elseif($page == "subscriptions" && $action == "delete" && !isset($_POST['send'])){
        //Abfrage ob man wirklich loeschen will??
        $warnung = "M&ouml;chten Sie das Abo wirklich l&ouml;schen?<br><br>";
        $LINK = $linker->getLink(array('section' => 'paypal', 'page' => $page, 'action' => 'delete', 'id' => $id));
        ask_yesno($warnung, $LINK, array('id'=>$id, 'send'=>'send'));  
    }
    
    //Page: Subscriptions -> delte::commited
    elseif($page == "subscriptions" && $action == "delete" && isset($_POST['send']) && $_POST['send'] == 'send'){
        //!to be fixed: If a subscription exist for a user, you should not delete it.
        $abo_stmt = Database::prepare("DELETE FROM PP_ABO_TYPE WHERE PK_ABO_ID = '".$id."' ");
        Database::pexecute($abo_stmt, array('id' => $id));
        $umleitung = $linker->getLink(array('section' => 'paypal', 'page' => $page));
        header('Location: '.$umleitung.'');
    }
    
    //Page: Subscriptions -> add::Form
    elseif($page == "subscriptions" && $action == "add" && !isset($_POST['send'])){
        //anzeige Formular zum machen oder so.
        $customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/modules/formfield.abo_add.php';
        $customer_add_form = htmlform::genHTMLForm($customer_add_data);
        eval("echo \"".getTemplate("modules/paypal/subscription_add")."\";");
		eval("echo \"".getTemplate("modules/paypal/subscription-bottom")."\";");
    }
    
    //Page: Subscriptions -> add:save
    elseif($page == "subscriptions" && $action == "add" && isset($_POST['send']) && $_POST['send'] = 'send'){
        $abo_kurz = $_POST['code'];
        $abo_desc = $_POST['description'];
        $abo_costs_mth = $_POST['costs'];
        $abo_paypal_code = $_POST['paypal'];
        if(isset($_POST['costy'])){
            $abo_costs_year = $_POST['costy'];
        }
        $abo_stmt = Database::prepare("INSERT INTO PP_ABO_TYPE (ABO_KURZ, ABO_DESC, ABO_COSTS_MTH, ABO_PAYPAL_CODE) VALUES ('".$abo_kurz."', '".$abo_desc."', '".$abo_costs_mth."', '".$abo_paypal_code."')");
        Database::pexecute($abo_stmt, array('id' => $id));
        $umleitung = $linker->getLink(array('section' => 'paypal', 'page' => $page));
        header('Location: '.$umleitung.'');
    }
    
    //Page: Subscriptions -> edit::Form
    elseif($page == "subscriptions" && $action == "edit" && $_GET['state'] == 'edit'){
        $aboinfo= array();
        $aboinfo['pk_abo_id'] = "";  
        $abo_stmt = Database::prepare('SELECT * FROM PP_ABO_TYPE WHERE PK_ABO_ID ="'.$id.'"');
        Database::pexecute($abo_stmt, array("PK_ABO_ID" => $aboinfo['pk_abo_id'],));
        $row = array();
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            $pk_abo_id = $row["PK_ABO_ID"];
            $abo_kurz = $row["ABO_KURZ"];
            $abo_desc = $row["ABO_DESC"];
            $abo_costs_mth = $row["ABO_COSTS_MTH"];
            $abo_costs_year = $row["ABO_COSTS_YEAR"];
            $abo_paypal_code = $row["ABO_PAYPAL_CODE"];
        }
        $customer_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/modules/formfield.abo_edit.php';
        $customer_add_form = htmlform::genHTMLForm($customer_add_data);
        eval("echo \"".getTemplate("modules/paypal/subscription_edit")."\";");
		eval("echo \"".getTemplate("modules/paypal/subscription-bottom")."\";");
    }
    
    //Page: Subscriptions -> edit::save
    elseif($page == "subscriptions" && $action == "edit" && $_GET['state'] == 'save' && $_POST['send'] == 'send'){
        if(isset($_GET['id'])){$id = $_GET['id'];}
        if(isset($_POST['id'])){$id = $_POST['id'];}
        $abo_kurz = $_POST['code'];
        $abo_desc = $_POST['description'];
        $abo_costs_mth = $_POST['costs'];
        $abo_paypal_code = $_POST['paypal'];
        if(isset($_POST['costy'])){
            $abo_costs_year = $_POST['costy'];
        }
        if(isset($id)){
            $abo_stmt = Database::prepare("UPDATE PP_ABO_TYPE SET ABO_KURZ = '".$abo_kurz."', ABO_DESC = '".$abo_desc."' , ABO_COSTS_MTH = '".$abo_costs_mth."' , PayPal_Code = '".$abo_paypal_code."' WHERE PK_ABO_ID=\"".$id."\"");
            Database::pexecute($abo_stmt, array('id' => $id));
        }
        $umleitung = $linker->getLink(array('section' => 'paypal', 'page' => $page));
        header('Location: '.$umleitung.'');
    }
    
    

    //Page: Overview Clients
    if($page == "overview" && $action == NULL){  
        eval("echo \"".getTemplate("modules/paypal/overview-top")."\";");
        $aboinfo= array();
        $aboinfo['customerid'] = "";  
        $abo_stmt = Database::prepare("SELECT c.customerid, c.loginname, c.name, c.firstname, c.company, a.ABO_DESC, c.PP_ABO_EXPIRE, c.PP_SUB_COMPLETED FROM panel_customers AS c LEFT JOIN PP_ABO_TYPE AS a ON c.PP_ABO_TYPE = a.PK_ABO_ID");
        Database::pexecute($abo_stmt, array("customerid" => $aboinfo['customerid'],));
        $row = array();
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            $customerid = $row["customerid"];
            $loginname = $row["loginname"];
            $name = $row["name"];
            $firstname = $row["firstname"];
            $company = $row["company"];
            $abo_desc = $row["ABO_DESC"];
            $pp_abo_expire = $row["PP_ABO_EXPIRE"];
            if($row["PP_SUB_COMPLETED"] == '0'){
                $pp_sub_completed = "nicht aktiv";
            }
            else{
                $pp_sub_completed = "aktiv";
            }
            //$id = $idna_convert->decode($row['aboid']);
            eval("echo \"".getTemplate("modules/paypal/overview-element")."\";");
        }
		eval("echo \"".getTemplate("modules/paypal/overview-bottom")."\";");
	}

    //Page: Overview -> delete::sure?
    elseif($page == "overview" && $action == "delete" && !isset($_POST['send'])){
        //NUR ABO entfernen ++ Abfrage ob man das wirklich will??
        //Abfrage ob man wirklich loeschen will??
        $warnung = "M&ouml;chten Sie das Abo wirklich vom Kunden entfernen?<br><br>";
        $LINK = $linker->getLink(array('section' => 'paypal', 'page' => $page, 'action' => 'delete', 'id' => $id));
        ask_yesno($warnung, $LINK, array('id'=>$id, 'send'=>'send'));  
    }
    
    //Page: Overview -> delte::comitted
    elseif($page == "overview" && $action == "delete" && isset($_POST['send']) && $_POST['send'] == 'send'){
        $aboinfo['id'] = "";
        $abo_stmt = Database::prepare("UPDATE panel_customers SET PP_ABO_EXPIRE = NULL, PP_SUB_COMPLETED = '0', PP_ABO_TYPE = NULL  WHERE customerid = ".$id." ");
        Database::pexecute($abo_stmt, array('id' => $id));
        $umleitung = $linker->getLink(array('section' => 'paypal', 'page' => $page));
        header('Location: '.$umleitung.'');
    }
    
    //Page: Overview -> edit_customer_subscription::Form
    elseif($page == "overview" && $action == "edit" && !isset($_POST['send'])){
        $subs= array();
        $subs['customerid'] = "";  
        $abo_stmt = Database::prepare("SELECT customerid, loginname, name, firstname, company, PP_ABO_TYPE FROM panel_customers WHERE customerid = '".$id."'");
        Database::pexecute($abo_stmt, array("customerid" => $subs['customerid'],));
        $row = array();
        while($row = $abo_stmt->fetch(PDO::FETCH_ASSOC)){
            $name = $row['name'];
            $firstname = $row['firstname'];
            $company = $row['company'];
            $username = $row['loginname'];
            $abo = $row['PP_ABO_TYPE'];
        }     
        $subs= array();
        $subs['customerid'] = "";  
        $abo_stmt = Database::prepare("SELECT PK_ABO_ID, ABO_DESC FROM PP_ABO_TYPE");
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
        eval("echo \"".getTemplate("modules/paypal/overview_edit")."\";");
		eval("echo \"".getTemplate("modules/paypal/overview-bottom")."\";");
    }
    
    //Page: Overview -> edit_customer_subscription::save
    elseif($page == "overview" && $action == "edit" && isset($_POST['send']) && $_POST['send'] = 'send'){
        //formular aenderungen speichern...
        $abowish = $_POST['abo-wish'];
        $paypal = $_POST['paypal'];
        $abo_stmt = Database::prepare("UPDATE panel_customers SET PP_ABO_TYPE = '".$abowish."' WHERE customerid = '".$id."'");
        Database::pexecute($abo_stmt, array('id' => $id));
        $umleitung = $linker->getLink(array('section' => 'paypal', 'page' => $page));
        header('Location: '.$umleitung.'');
    }

    //If I forgot something: just redirect :)
    else{
        $umleitung = $linker->getLink(array('section' => 'paypal', 'page' => $page));
        //header('Location: '.$umleitung.'');
    }
    
?>
