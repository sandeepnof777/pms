<?php

namespace models;


class Datauploadqbmdl extends \MY_Model
{
    public $cms_db;

    function construct()
    {
        parent::__construct();
    }
	
    public function insertQbLoginMdl($companyId, $accessToken, $refreshToken, $realmId, $error)
    {
        $this->getQuickbooksRepository()->saveCredentials($companyId, $accessToken, $refreshToken, $realmId, $error);
    }
	
    public function clientData($cID)
    {
        $CI =& get_instance();
        $CI->load->database();
		$getqbSettingQuery = $CI->db->query("SELECT * FROM quickbook_settings where company_id='" . $cID . "'");
        $getqbSettingResultArr = $getqbSettingQuery->result_array();
        $getqbSettingResult = $getqbSettingResultArr[0];

        $clientQuery = $CI->db->query("SELECT * FROM clients where QBSyncFlag=1 and company='" . $cID . "' || QBSyncFlag=3 and company='" . $cID . "' order by clientId desc limit 1");
        $clientResultData = $clientQuery->result_array();

        $clientResult = array("getqbSetting" => $getqbSettingResult, "client" => $clientResultData);
        session_start();
        $_SESSION['clientResult'] = $clientResult;
        redirect('/OAuth_2/CustomerCreate.php', 'refresh');
    }


    public function servicesData($cID)
    {
        $CI =& get_instance();
        $CI->load->database();
        
        $getqbSettingQuery = $CI->db->query("SELECT * FROM quickbook_settings where company_id='" . $cID . "'");
        $getqbSettingResultArr = $getqbSettingQuery->result_array();
        $getqbSettingResult = $getqbSettingResultArr[0];
        $servicesQuery = $CI->db->query("SELECT * FROM company_qb_services where QBSyncFlag IN (1,3) && company_id='" . $cID . "'");
        $servicesResult = $servicesQuery->result_array();
        $itemResult = array("getqbSetting" => $getqbSettingResult, "items" => $servicesResult);
        session_start();
        $_SESSION['itemResult'] = $itemResult;
        redirect('/OAuth_2/ItemCreation.php', 'refresh');
    }

    public function proposalData($cID)
    {
        $CI =& get_instance();
        $CI->load->database();
        $getqbSettingQuery = $CI->db->query("SELECT * FROM quickbook_settings where company_id='" . $cID . "'");
        $getqbSettingResultArr = $getqbSettingQuery->result_array();
        $getqbSettingResult = $getqbSettingResultArr[0];
        $proposalQuery = $CI->db->query("SELECT * FROM proposals where QBSyncFlag IN (1,3)");
        if ($proposalQuery->result_array()) {
            $proposalResultArr = $proposalQuery->result_array();
            $proposaldetails = array();
            foreach ($proposalResultArr as $proposalResult) {
                //proposal client
                $clientId = $proposalResult['client'];
                $clientQuery = $CI->db->query("SELECT * FROM clients where clientId ='" . $clientId . "'");
                if ($clientQuery->result_array()){
                    $clientResultData = $clientQuery->result_array();

                    $clientDetails = $clientResultData[0];
                } 
				else {
                    $clientDetails = array();;
                }
                $proposalResult['clientDetails'] = $clientDetails;
                //proposal services
                $proposalId = $proposalResult['proposalId'];
                $proposalservicesQuery = $CI->db->query("SELECT * FROM proposal_services where proposal='" . $proposalId . "' order by serviceId asc");
                if ($proposalservicesQuery->result_array()) {
                    $proposalServices = $proposalservicesQuery->result_array();
                } 
				else {
                    $proposalServices = array();;
                }
                $proposalResult['proposalServices'] = $proposalServices;
                $proposaldetails[] = array($proposalResult);
            }

        } 
		else {
            $proposaldetails = array();
        }

        $proposalData = array("getqbSetting" => $getqbSettingResult, "proposaldetails" => $proposaldetails);
        session_start();
        $_SESSION['proposalData'] = $proposalData;
        redirect('/OAuth_2/InvoiceCreate.php', 'refresh');
    }

    public function logoutQbLoginMdl($companyId)
    {
        $this->getQuickbooksRepository()->removeCredentials($companyId);
    }
}