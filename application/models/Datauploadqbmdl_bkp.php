<?php

namespace models;

use Doctrine\Common\Collections\ArrayCollection;


class Datauploadqbmdl
{
    public $cms_db;

    function construct()
    {
        parent::__construct();
    }

    public function insertQbLoginMdl($c_id, $at_id, $rt_id, $error)
    {
        //echo $cID;die;
        $CI =& get_instance();
        $CI->load->database();
        //echo $c_id.'<br>'.$at_id.'<br>'.$rt_id;die;

        $count_company_id = $CI->db->query("SELECT count(company_id) as company_id FROM quickbook_settings where company_id='" . $c_id . "'");
        $count_company_id_result = $count_company_id->result_array();
        //echo $count_company_id_result[0]['company_id'];die;
        if ($count_company_id_result[0]['company_id'] > 0) {
            $updateQuery = $CI->db->query("UPDATE quickbook_settings SET access_token='" . $at_id . "',refresh_token='" . $rt_id . "',error_message='" . $error . "' WHERE company_id='" . $c_id . "'");
        } else {
            $insertQuery = $CI->db->query("INSERT INTO quickbook_settings (company_id,access_token,refresh_token,error_message) VALUES ('" . $c_id . "', '" . $at_id . "', '" . $rt_id . "', '" . $error . "')");
            $updateQuery = $CI->db->query("UPDATE companies SET qb_setting_id = 1 WHERE company_id = {$c_id}");
            //echo $c_id.'<br>'.$at_id.'<br>'.$rt_id;die;
        }
    }


    public function clientData($cID)
    {
        //echo $cID;die;
        $CI =& get_instance();
        $CI->load->database();
        $getqbSettingQuery = $CI->db->query("SELECT * FROM quickbook_settings where company_id='" . $cID . "'");
        $getqbSettingResultArr = $getqbSettingQuery->result_array();
        $getqbSettingResult = $getqbSettingResultArr[0];


        $clientQuery = $CI->db->query("SELECT * FROM clients where QBSyncFlag=1 and company='" . $cID . "' || QBSyncFlag=3 and company='" . $cID . "' order by clientId asc");
        $clientResultData = $clientQuery->result_array();

        $clientResult = array("getqbSetting" => $getqbSettingResult, "client" => $clientResultData);

        //echo"<pre>";print_r($itemResult);die;
        session_start();
        $_SESSION['clientResult'] = $clientResult;
        //include('../../OAuth_2/ItemCreation.php');
        redirect('/OAuth_2/CustomerCreate.php', 'refresh');

        //echo "<pre>";print_r($clientResult);die;
    }


    public function servicesData($cID)
    {
        //echo $cID;die;
        $CI =& get_instance();
        $CI->load->database();
        //$servicesQuery = $CI->db->query("SELECT * FROM services where QBSyncFlag=1 and company='".$cID."' || QBSyncFlag=3 and company='".$cID."' order by serviceId asc");
        $getqbSettingQuery = $CI->db->query("SELECT * FROM quickbook_settings where company_id='" . $cID . "'");
        $getqbSettingResultArr = $getqbSettingQuery->result_array();
        $getqbSettingResult = $getqbSettingResultArr[0];

        $servicesQuery = $CI->db->query("SELECT * FROM company_qb_services where QBSyncFlag=1 && company_id='" . $cID . "' || QBSyncFlag=3 && company_id='" . $cID . "'");

        $servicesResult = $servicesQuery->result_array();

        $itemResult = array("getqbSetting" => $getqbSettingResult, "items" => $servicesResult);

        //echo"<pre>";print_r($itemResult);die;
        session_start();
        $_SESSION['itemResult'] = $itemResult;
        //include('../../OAuth_2/ItemCreation.php');
        redirect('/OAuth_2/ItemCreation.php', 'refresh');
        
    }


    public function proposalData($cID)
    {
        //echo $cID;die;

        //$this->servicesData($cID);
        $CI =& get_instance();
        $CI->load->database();
        $getqbSettingQuery = $CI->db->query("SELECT * FROM quickbook_settings where company_id='" . $cID . "'");
        $getqbSettingResultArr = $getqbSettingQuery->result_array();
        $getqbSettingResult = $getqbSettingResultArr[0];
        //status order by proposalId desc limit 1
        $proposalQuery = $CI->db->query("SELECT * FROM proposals where QBSyncFlag IN (1,3)");
        if ($proposalQuery->result_array()) {
            $proposalResultArr = $proposalQuery->result_array();
            //echo "<pre>";print_r($proposalResultArr);die;
            $proposaldetails = array();

            foreach ($proposalResultArr as $proposalResult) {
                //proposal client
                $clientId = $proposalResult['client'];
                $clientQuery = $CI->db->query("SELECT * FROM clients where clientId ='" . $clientId . "'");
                if ($clientQuery->result_array()) {
                    $clientResultData = $clientQuery->result_array();

                    $clientDetails = $clientResultData[0];
                } else {
                    $clientDetails = array();;
                }
                $proposalResult['clientDetails'] = $clientDetails;

                //proposal services
                $proposalId = $proposalResult['proposalId'];
                $proposalservicesQuery = $CI->db->query("SELECT * FROM proposal_services where proposal='" . $proposalId . "' order by serviceId asc");

                //$proposalservicesQuery = $CI->db->query("SELECT * FROM pms_dev.proposal_services as ps inner join company_qb_services as qbs on ps.initial_service=qbs.service_id where qbs.QBSyncFlag IN (1,3) && qbs.company_id='".$cID."' && proposal='".$proposalId."'");

                //SELECT * FROM pms_dev.proposal_services as ps inner join company_qb_services as qbs on ps.initial_service=qbs.service_id where qbs.QBSyncFlag IN (1,3) && qbs.company_id='".$clientId."' && ps.proposal='".$proposalId."' order by ps.serviceId asc

                if ($proposalservicesQuery->result_array()) {
                    $proposalServices = $proposalservicesQuery->result_array();
                } else {
                    $proposalServices = array();;
                }
                $proposalResult['proposalServices'] = $proposalServices;
                $proposaldetails[] = array($proposalResult);
            }

        } else {
            $proposaldetails = array();
        }

        $proposalData = array("getqbSetting" => $getqbSettingResult, "proposaldetails" => $proposaldetails);
        //echo "<pre>";print_r($proposalData);die;
        session_start();
        $_SESSION['proposalData'] = $proposalData;
        //include('../../OAuth_2/ItemCreation.php');
        redirect('/OAuth_2/InvoiceCreate.php', 'refresh');

    }

   /* public function proposalservicesPlQbData($cID)
    {
        //echo $cID;die;
        $CI =& get_instance();
        $CI->load->database();
        $proposalservicesQuery = $CI->db->query("SELECT * FROM proposal_services where QBSyncFlag=1 || QBSyncFlag=3 order by serviceId asc");
        $proposalservicesResult = $proposalservicesQuery->result_array();

        echo "<pre>";
        print_r($proposalservicesResult);
        die;
    }*/

    public function logoutQbLoginMdl($companyId)
    {
        //echo $companyId;die;
        $CI =& get_instance();
        $CI->load->database();
        $updateQuery = $CI->db->query("UPDATE quickbook_settings SET access_token='',refresh_token='',error_message='' WHERE company_id='" . $companyId . "'");
        //redirect('http://dev.pavementlayers.com/OAuth_2/RefreshToken.php?deleteSession=true', 'refresh');
    }
}