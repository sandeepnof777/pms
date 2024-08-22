<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="saved_reports")
 */
class SavedReport {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Companies", cascade={"persist"})
     * @ORM\JoinColumn (name="company", referencedColumnName="companyId")
     * @var
     */
    private $company;
    /**
     * @ORM\ManyToOne(targetEntity="Accounts", cascade={"persist"})
     * @ORM\JoinColumn (name="account", referencedColumnName="accountId")
     * @var
     */
    private $account;
    /**
     * @ORM\ManyToOne(targetEntity="ReportType", fetch="EAGER")
     * @ORM\JoinColumn (name="report_type", referencedColumnName="id")
     * @var
     */
    private $report_type;
    /**
     * @ORM\Column(type="string")
     */
    private $report_name;
    /**
     * @ORM\Column(type="string")
     */
    private $params;


    function __construct() {

        if($this->getReportType()){
            $this->setObjReportType();
        }
    }

    /**
     * @param \models\Companies $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return \models\Companies
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param \models\Accounts $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return \models\Accounts
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return json_decode($this->params, true);
    }

    /**
     * @param mixed $report_name
     */
    public function setReportName($report_name)
    {
        $this->report_name = $report_name;
    }

    /**
     * @return mixed
     */
    public function getReportName()
    {
        return $this->report_name;
    }

    /**
     * @param  \models\ReportType $report_type
     */
    public function setReportType($report_type)
    {
        $this->report_type = $report_type;
    }

    /**
     * @return \models\ReportType
     */
    public function getReportType()
    {
        return $this->report_type;
    }

    /** Create the output for the overlay that display the details of a saved Export */
    public function getDisplayCriteria(){

        switch($this->getReportType()->getId()){

            case ReportType::PROPOSALS:
                return $this->getProposalsCriteria();
                break;

            case ReportType::PROSPECTS:
            case ReportType::LEADS:
            case ReportType::CLIENTS:
                return $this->getFieldsCriteria();
                break;

            case ReportType::HISTORY:
                return $this->getHistoryCriteria();
                break;

            case ReportType::SERVICES:
                return $this->getServicesCriteria();
                break;

        }

    }

    /**
     * Construct the criteria output for proposal exports
     * @return string
     */
    private function getProposalsCriteria(){
        $CI =& get_instance();

        // Params
        $params = $this->getParams();
        $statusString = '';
        $statusChangeString = '';
        // Status
        if($params['status']){

            // Load the status
            $status = $CI->em->find('\models\Status', $params['status']);
            if ($status) {
                $statusString = $status->getText();
            }
        }
        else {
            $statusString = 'All';
        }

        // Status Change Date
        if(isset($params['statusApply']) && $params['statusApply']){

            $statusFrom = explode('/', $params['statusFrom']);
            $statusTo = explode('/', $params['statusTo']);

            if(is_array($statusFrom) && is_array($statusTo)){
              //  $statusChangeString = $statusFrom[0] . '/' . $statusFrom[1] . '/' . $statusFrom[2] . ' - ' . $statusTo[0] . '/' . $statusTo[1] . '/' . $statusTo[2];
              $statusChangeString = 
              (isset($statusFrom[0]) ? $statusFrom[0] : '') . '/' . 
              (isset($statusFrom[1]) ? $statusFrom[1] : '') . '/' . 
              (isset($statusFrom[2]) ? $statusFrom[2] : '') . ' - ' . 
              (isset($statusTo[0]) ? $statusTo[0] : '') . '/' . 
              (isset($statusTo[1]) ? $statusTo[1] : '') . '/' . 
              (isset($statusTo[2]) ? $statusTo[2] : '');
            }
        }
        else {
            $statusChangeString = ' - ';
        }

        // User
        if($params['user']){
            $user = $CI->em->find('\models\Accounts', $params['user']);

            if ($user) {
                $userString = $user->getFullName();
            } else {
                $userString = 'Deleted User';
            }

        }
        else {
            $userString = 'All';
        }


        // Service
        if($params['service']){
            $service = $CI->em->find('\models\Services', $params['service']);
            /* @var $service \models\Services */
            $serviceString = $service->getServiceName();
        }
        else {
            $serviceString = 'All';
        }


        // Proposal Creation Date
        if($params['from']){

            $createdFrom = explode('/', $params['from']);
            $createdTo = explode('/', $params['to']);

            $createdDateString = $createdFrom[0] . '/' . $createdFrom[1] . '/' . $createdFrom[2] . ' - ' . $createdTo[0] . '/' . $createdTo[1] . '/' . $createdTo[2];
        }
        else {
            $createdDateString = 'All';
        }


        $criteriaString = "
        <table>
            <tr>
                <td><strong>Status</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$statusString</td>
            </tr>
            <tr>
                <td><strong>Status Change Date</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$statusChangeString</td>
            </tr>
            <tr>
                <td><strong>User</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$userString</td>
            </tr>
            <tr>
                <td><strong>Service</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$serviceString</td>
            </tr>
            <tr>
                <td><strong>Created Date</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$createdDateString</td>
            </tr>
        </table>
        ";

        return $criteriaString;
    }

    /**
     * Construct the criteria output for exports that use only fields
     * @return string
     */
    private function getFieldsCriteria(){

        $params = $this->getParams();

        $criteriaString = '<h3>Selected Fields</h3>';

        $criteriaString .= '<ul>';

        if(is_array($params)){
            foreach($params['fields'] as $field){
                $criteriaString .= '<li>' . $field . '</li>';
            }
        }

        $criteriaString .= '</ul>';

        return $criteriaString;
    }

    /**
     * Construct the criteria output for history exports
     * @return string
     */
    private function getHistoryCriteria(){
        $CI =& get_instance();

        // Params
        $params = $this->getParams();

        // Year
        $yearString = $params['year'];


        // User
        if($params['user']){
            $user = $CI->em->find('\models\Accounts', $params['user']);
            $userString = $user->getFullName();
        }
        else {
            $userString = 'All';
        }

        $criteriaString = "
        <table>
            <tr>
                <td><strong>Year</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$yearString</td>
            </tr>
            <tr>
                <td><strong>User</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$userString</td>
            </tr>
        </table>
        ";

        return $criteriaString;
    }

    /**
     * Construct the criteria output for services exports
     * @return string
     */
    private function getServicesCriteria(){
        $CI =& get_instance();

        $params = $this->getParams();

        // Get the fields first
        $criteriaString = $this->getFieldsCriteria();
        $statusString = '';
        // Now the other stuff
        // Status
        if($params['status']){

            // Load the status
            $status = $CI->em->find('\models\Status', $params['status']);
            if ($status) {
                $statusString = $status->getText();
            }
        }
        else {
            $statusString = 'All';
        }

        // User
        if($params['user']){
            $user = $CI->em->find('\models\Accounts', $params['user']);
            $userString = $user->getFullName();
        }
        else {
            $userString = 'All';
        }

        // Proposal Creation Date
        if($params['from']){

            $createdFrom = explode('/', $params['from']);
            $createdTo = explode('/', $params['to']);

            $createdDateString = $createdFrom[0] . '/' . $createdFrom[1] . '/' . $createdFrom[2] . ' - ' . $createdTo[0] . '/' . $createdTo[1] . '/' . $createdTo[2];
        }
        else {
            $createdDateString = 'All';
        }

        $criteriaString .= "<br /><h3>Export Criteria</h3>
        <table>
            <tr>
                <td><strong>Status</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$statusString</td>
            </tr>
            <tr>
                <td><strong>User</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$userString</td>
            </tr>
            <tr>
                <td><strong>Created Date</strong></td>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td>$createdDateString</td>
            </tr>
        </table>
        ";

        return $criteriaString;
    }

}