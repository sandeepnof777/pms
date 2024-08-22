<?php

namespace models;

use Doctrine\ORM\Mapping as ORM;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="accounts")
 */
class Accounts extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $accountId;
    /**
     * @ORM\ManyToOne (targetEntity="Companies", inversedBy="accounts", cascade={"persist"})
     * @ORM\JoinColumn (name="company", referencedColumnName="companyId")
     */
    private $company;
    /**
     * @ORM\OneToMany(targetEntity="Clients", mappedBy="account", cascade={"persist"})
     */
    private $clients;
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $fullName;
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $lastName;
    /**
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\Column(type="string", length=5)
     */
    private $fullAccess;
    /**
     * @ORM\Column(type="integer")
     */
    private $deleted;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $city;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;
    /**
     * @ORM\Column(type="string", length=16)
     */
    private $zip;
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $country;
    /**
     * @ORM\Column(type="string", length=16)
     */
    private $cellPhone;
    /**
     * @ORM\Column(type="string", length=16)
     */
    private $timeZone;
    /**
     * @ORM\Column(type="integer")
     */
    private $created;
    /**
     * @ORM\Column(type="integer")
     */
    private $globalAdministrator;
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $token;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $expires;
    /**
     * @ORM\Column(type="string",nullable=true, length=32)
     */
    private $officePhone;
    /**
     * @ORM\Column(type="string",nullable=true, length=10)
     */
    private $officePhoneExt;
    /**
     * @ORM\Column(type="string",nullable=true, length=32)
     */
    private $fax;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $adminPrivileges;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $disabled;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $work_order_address;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $disable_proposal_notifications;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $branch;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $userClass;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $requiresApproval;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $secretary;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $approvalAmount;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $defaultApproval;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $recovery_code;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $psa_email;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $psa_password;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $layout;
    /**
     * @ORM\OneToMany(targetEntity="ClientCompany", mappedBy="owner_user", cascade={"persist"})
     */
    private $clientCompanies;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sales;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wio;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $estimating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $edit_price;
    /**
     * @ORM\Column(type="integer")
     */
    private $sales_report_emails;
    /**
     * @ORM\Column(type="integer")
     */
    private $email_frequency;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $last_login;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_email_cc;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_super_user =0;
    /**
     * @ORM\Column(type="integer")
     */
    private $parent_user_id =0;
        /**
     * @ORM\Column(type="integer")
     */
    private $parent_company_id =0;

     /**
     * @ORM\Column(type="integer")
     */
    private $work_order_setting=0;
    
     /**
     * @ORM\Column(type="integer")
     */
    private $auth_login;
     /**
     * @ORM\Column(type="integer")
     */
    private $email_otp=0;
    /**
     * @ORM\Column(type="integer")
     */
    private $otp_time;

    

    function __construct()
    {
        //defaults
        $this->deleted = 0;
        $this->expires = time();
        $this->fullAccess = 'no';
        $this->clients = new ArrayCollection();
        $this->adminPrivileges = 0;
        $this->secretary = 0;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getInitials($tooltip = false)
    {
        // Not sure what's going on here but I'll keep it for now
        $names = '';
        $names2 = explode(' ', trim($this->getFirstName() . ' ' . $this->getLastName()));
        foreach ($names2 as $name) {
            $names .= substr($name, 0, 1) . '.';
        }

        if ($tooltip) {
            return '<span class="tiptip" title="' . $this->getFirstName() . ' ' . $this->getLastName() . '">' . $names . '</span>';
        }

        return $names;
    }

    public function getFirstName()
    {
        return trim(ucwords(($this->firstName)));
    }

    public function setFirstName($firstName)
    {
        $this->firstName = ucwords(($firstName));
    }

    public function getLastName()
    {
        return trim(ucwords(($this->lastName)));
    }

    public function setLastName($lastName)
    {
        $this->lastName = ucwords(($lastName));
    }

    public function safeDelete()
    {
        $this->deleted = 1;
        $this->email = 'deleted:' . $this->email . ' - ' . time();
    }

    public function setHidden()
    {
        $this->deleted = 1;
    }

    public function unDelete()
    {
        $this->deleted = 0;
        $this->email = str_replace('deleted:', '', $this->email);
    }

    public function isDeleted()
    {
        return $this->deleted;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;
    }

    public function getCreated($date = true)
    {
        if ($date) {
            return date('m/d/Y', $this->created + TIMEZONE_OFFSET);
        } else {
            return $this->created;
        }
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getClients($deleted = 0)
    {
        if (!$deleted) {
            $clients = new ArrayCollection();
            foreach ($this->clients as $client) {
                if (!$client->isDeleted()) {
                    $clients->add($client);
                }
            }
            return $clients;
        } else {
            return $this->clients;
        }
    }

    public function getActiveClients()
    {

        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Select clients from this company that aren't deleted
        $qb->select('c')
            ->from('\models\Clients', 'c')
            ->where('c.company = :companyId')
            ->setParameter('companyId', $this->getCompany()->getCompanyId())
            ->andWhere('c.deleted = 0');

        // Further conditions for non admins/full access
        if (!$this->isAdministrator() && !$this->hasFullAccess()) {

            // Show clients for branch for branch admins
            if ($this->isBranchAdmin()) {
                $qb->from('\models\Accounts', 'a')
                    ->andWhere('c.account = a.accountId')
                    ->andWhere('a.branch = :branchId')
                    ->setParameter('branchId', $this->getBranch());
            } else {
                // Only display for this account
                $qb->andWhere('c.account = :accountId')
                    ->setParameter('accountId', $this->getAccountId());
            }
        }

        // Create the query and get the result
        $query = $qb->getQuery();
        $clients = $query->getResult();

        return $clients;
    }

    /**
     * @return \models\Companies
     */
    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function isAdministrator($realValue = false)
    {
        $admin = $this->getCompany()->getAdministrator();
        if (!$admin) {
            return false;
        }

        if ($realValue) {
            return (($this->getAccountId() == $this->getCompany()->getAdministrator()->getAccountId()));
        } else {
            $value = ($this->getUserClass() >= 3);
            return $value;
        }
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    public function getUserClass($name = false,$branch = false)
    {
        if ($this->getSecretary() && $name) {
            //            return 'Limited User';
        }
        $names = array(
            '0' => 'User',
            '1' => 'Branch Manager',
            '2' => 'Full Access',
            '3' => 'Administrator',
        );

        $admin = $this->getCompany()->getAdministrator();
        if (!$admin) {
            $adminId = null;
        } else {
            $adminId = $admin->getAccountId();
        }

        if (!$name) {
            if ($adminId && ($this->getAccountId() == $adminId)) {
                return 4;
            } else {
                return ($this->userClass) ? $this->userClass : 0;
            }
        } else {
            if ($adminId && ($this->getAccountId() == $adminId)) {
                return 'Administrator';
            }else if($this->getUserClass() == 1 && $branch){
                
               
                    $branchData = $this->doctrine->em->find('models\Branches', $this->getBranch());
                    if($branchData){
                        return 'Branch Manager - '. $branchData->getBranchName();
                    }else{
                        return 'Branch Manager - Main';
                    }
                    
                
                
            } else {
                return ($this->getSecretary()) ? 'Limited User - ' . $names[$this->getUserClass()] : $names[$this->getUserClass()];
            }
        }
    }

    public function setUserClass($userClass)
    {
        $this->userClass = $userClass;
        // if ($userClass > 0) {
        //     $this->requiresApproval = 0;
        // }
    }

    public function getSecretary()
    {
        if ($this->isAdministrator(true)) {
            return 0;
        }
        return $this->secretary;
    }

    public function setSecretary($secretary)
    {
        if ($this->isAdministrator(true)) { //don't set company admins to secretary lol
            $this->secretary = 0;
        } else {
            $this->secretary = $secretary;
        }
    }

    /**
     * Similar to above, but returns a boolean
     * @return bool
     */
    public function hasFullAccess()
    {
        return ($this->getUserClass() >= 2) ? true : false;
    }

    public function isBranchAdmin()
    {
        return ($this->getUserClass() == 1);
    }

    public function getBranch()
    {
        return ($this->branch) ? $this->branch : 0;
    }

    public function setBranch($branch)
    {
        $this->branch = $branch;
    }

    public function getProposals()
    {

        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Select proposals owned by this client
        $qb->select('p')
            ->from('\models\Proposals', 'p')
            ->where('p.owner = :accountId')
            ->setParameter('accountId', $this->getAccountId());

        // Create the query and get the result
        $query = $qb->getQuery();
        $proposals = $query->getResult();

        return $proposals;
    }

    public function getAllClients()
    {

        $CI = &get_instance();

        if (!$this->isAdministrator()) {
            return false;
        }

        $q = 'SELECT c FROM models\Clients c where c.company is not NULL and c.company=' . $this->getCompany()->getCompanyId();
        if ($this->isAdministrator() || ($this->getFullAccess() == 'yes')) {
        } else {
            $q .= ' and c.account=' . $this->getAccountId();
        }

        $query = $CI->em->createQuery($q);
        $totalClients = $query->getResult();

        return $totalClients;
    }

    public function getFullAccess()
    {
        return ($this->getUserClass() >= 2) ? 'yes' : 'no';
    }

    public function setFullAccess($fullAccess)
    {
        //        $this->fullAccess = $fullAccess;
    }

    public function isFullAccess()
    {
        return ($this->getUserClass() >= 2 || $this->isAdministrator(true));
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function isGlobalAdministrator()
    {
        return $this->globalAdministrator;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getExpires($date = false)
    {
        if ($date) {
            return date('m/d/Y', $this->expires);
        } else {
            return $this->expires;
        }
    }

    public function setExpires($expires)
    {
        $this->expires = $expires;
    }

    public function isExpired()
    {
        return ($this->expires < time());
    }

    public function getOfficePhone()
    {
        return $this->officePhone;
    }

    public function setOfficePhone($officePhone)
    {
        $this->officePhone = $officePhone;
    }

    public function getOfficePhoneExt()
    {
        return $this->officePhoneExt;
    }

    public function setOfficePhoneExt($officePhoneExt)
    {
        $this->officePhoneExt = $officePhoneExt;
    }

    public function getAdminPrivileges()
    {
        return ($this->getUserClass() >= 3);
    }

    public function setAdminPrivileges($adminPrivileges)
    {
        //        $this->adminPrivileges = $adminPrivileges;
    }

    public function getFax()
    {
        return $this->fax;
    }

    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    public function isDisabled()
    {
        return $this->getDisabled();
    }

    public function getDisabled()
    {
        return $this->disabled;
    }

    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }

    public function getWorkOrderAddress()
    {
        return $this->work_order_address;
    }

    public function setWorkOrderAddress($work_order_address)
    {
        $this->work_order_address = $work_order_address;
    }

    public function getDisableProposalNotifications()
    {
        return $this->disable_proposal_notifications;
    }

    public function setDisableProposalNotifications($proposal_notifications)
    {
        $this->disable_proposal_notifications = $proposal_notifications;
    }

    public function requiresApproval()
    {
        //  if ($this->userClass > 0) { //fail safe
        //      return 0;
        //  }

         if ($this->getAccountId() == $this->getCompany()->getAdministrator()->getAccountId()) {
            
            return 0;
         }
        return $this->requiresApproval;
    }

    public function setRequiresApproval($requiresApproval)
    {
        // if ($this->userClass > 0) {
        //     $this->requiresApproval = 0;
        // } else {
            $this->requiresApproval = $requiresApproval;
        //}
    }

    /**
     * @return mixed
     */
    public function getRecoveryCode()
    {
        return $this->recovery_code;
    }

    public function setRecoveryCode()
    {
        $this->recovery_code = createUniqueId();
    }

    /**
     * @return mixed
     */
    public function getRecoveryCodeLink($new = false)
    {
        $path = 'home/password_reset/' . $this->recovery_code;

        if ($new) {
            $path .= '/new';
        }

        return site_url($path);
    }

    public function hasPsaCreds()
    {
        if ($this->getCompany()->hasPSA()) {
            if ($this->getPsaEmail() && $this->getPsaPassword()) {
                return true;
            }
        }

        return false;
    }

    public function getPsaEmail()
    {
        return $this->psa_email;
    }

    public function setPsaEmail($email)
    {
        $this->psa_email = $email;
    }

    public function getPsaPassword()
    {
        return $this->psa_password;
    }

    public function setPsaPassword($password)
    {
        $this->psa_password = $password;
    }

    /**
     * @return mixed
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param mixed $sales
     */
    public function setSales($sales)
    {
        $this->sales = $sales;
    }

    public function isSales()
    {
        return $this->sales;
    }

    /**
     * @return mixed
     */
    public function getWio()
    {
        return $this->wio;
    }

    /**
     * @param mixed $wio
     */
    public function setWio($wio)
    {
        $this->wio = $wio;
    }

    /**
     * @return mixed
     */
    public function getEditPrice()
    {
        if ($this->isAdministrator()) {
            return 1;
        }
        return $this->edit_price;
    }

    /**
     * @param mixed $edit_price
     */
    public function setEditPrice($edit_price)
    {
        $this->edit_price = $edit_price;
    }

    /**
     * @return mixed
     */
    public function getSalesReportEmails()
    {

        return $this->sales_report_emails;
    }

    /**
     * @param mixed $sales_report_emails
     */
    public function setSalesReportEmails($sales_report_emails)
    {
        $this->sales_report_emails = $sales_report_emails;
    }

    /**
     * @return mixed
     */
    public function getEmailFrequency()
    {

        return $this->email_frequency;
    }

    /**
     * @param mixed $email_frequency
     */
    public function setEmailFrequency($email_frequency)
    {
        $this->email_frequency = $email_frequency;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        if ($this->last_login) {
            return Carbon::createFromTimestamp($this->last_login->getTimestamp());
        }
        return $this->last_login;
    }

    /**
     * @param mixed $last_login
     */
    public function setLastLogin($last_login)
    {
        $this->last_login = $last_login;
    }

    /**
     * @return mixed
     */
    public function getProposalEmailCC()
    {

        return $this->proposal_email_cc;
    }

    /**
     * @param mixed $proposal_email_cc
     */
    public function setProposalEmailCC($proposal_email_cc)
    {
        $this->proposal_email_cc = $proposal_email_cc;
    }

    
   
  
    
    /**
    * @return mixed
    */
   public function getIsSuperUser()
   {

       return $this->is_super_user;
   }

   /**
    * @param mixed $is_super_user
    */
   public function setIsSuperUser($is_super_user)
   {
       $this->is_super_user = $is_super_user;
   }
    
   

    /**
    * @return mixed
    */
    public function getParentUserId()
    {
 
        return $this->parent_user_id;
    }
 
    /**
     * @param mixed $parent_user_id
     */
    public function setParentUserId($parent_user_id)
    {
        $this->parent_user_id = $parent_user_id;
    }
    

     /**
    * @return mixed
    */
    public function getParentCompanyId()
    {
 
        return $this->parent_company_id;
    }
 
    /**
     * @param mixed $parent_company_id
     */
    public function setParentCompanyId($parent_company_id)
    {
        $this->parent_company_id = $parent_company_id;
    }

    public function getParentCompany(){
        if($this->getParentCompanyId()){
            
            return  $this->doctrine->em->findCompany($this->getParentCompanyId());
        }else{
            
            return $this->getCompany();
        }
    }
    public function getClientAccounts($alpha = false, $applyFilters = false)
    {

        if ($this->getUserClass() == 0) {
            return $this->clientCompanies;
        }

        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('cc')
            ->from('\models\ClientCompany', 'cc')
            ->where('cc.owner_company = :companyId')
            ->setParameter('companyId', $this->getCompany()->getCompanyId());

        if ($applyFilters) {
            if ($this->session->userdata('accFilter')) {
                $qb->andWhere('cc.owner_user = :userId');
                $qb->setParameter('userId', $this->session->userdata('accFilterUser'));
            }
        }

        if ($alpha) {
            $qb->orderBy('cc.name');
        }

        // Create the query and get the result
        $query = $qb->getQuery();
        $accounts = $query->getResult();

        return $accounts;
    }

    public function getLeads($count = false, $action = '', $type = '', $resend_id = '')
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Define what we're selecting
        //$select = 'l,1 as opened_at,GROUP_CONCAT(bt.type_name) as types';
        $select = 'l,1 as opened_at';
        if ($count) {
            $select = 'COUNT(l)';
        } else if ($action == 'resend') {
            //$select = 'l,lgre.opened_at,GROUP_CONCAT(bt.type_name) as types';
            $select = 'l,lgre.opened_at';
        }

        // Begin Query - Ensure restriction to this company only
        $qb->select($select)
            ->from('\models\Leads', 'l')
            // ->from('\models\BusinessTypeAssignment', 'bta')
            // ->from('\models\BusinessType', 'bt')
            //->from('\models\Notes', 'nt')
            ->where('l.company = :companyId')
            //->andWhere('l.account = nt.relationId')
            //->andWhere('nt.type = :type')
            // ->andWhere('l.account = bta.account_id')
            // ->andWhere('bt.id = bta.business_type_id')
            ->setParameter(':companyId', $this->getCompany()->getCompanyId());
        // ->setParameter(':type', 'client');

        // For peons, add further restriction to their own account
        if ($this->getUserClass() < 1) {
            $qb->andWhere('l.account = :accountId');
            $qb->setParameter(':accountId', $this->getAccountId());
        }

        // For branch managers, join with accounts and branch id
        if ($this->isBranchAdmin()) {
            $qb->from('\models\Accounts', 'a');
            $qb->andWhere('l.account = a.accountId');
            $qb->andWhere('a.branch = :branchId');
            $qb->setParameter(':branchId', $this->getBranch());
        }
        if ($action == 'resend') {

            // FIrst we have to check for a filter so we can add the join

            $qb->from('\models\LeadGroupResendEmail', 'lgre');
            $qb->andWhere('l.leadId = lgre.lead_id ');
            $qb->andWhere('lgre.resend_id = :resendId');
            $qb->setParameter(':resendId', $this->session->userdata('pLeadResendFilterId'));
            if ($type == 'failed') {
                $lead_ids = $this->getResendFailedLeadsIds($this->session->userdata('pLeadResendFilterId'));
                if ($lead_ids) {

                    $qb->andWhere('l.leadId IN (:leadIds)');
                    $qb->setParameter(':leadIds', $lead_ids);
                } else {
                    return [];
                }
            } else {
                // Now we have to check it's in the resend
                $lead_ids = $this->getResendLeadsIds($this->session->userdata('pLeadResendFilterId'));
                //$lead_ids = explode(",",$lead_ids);
                if ($lead_ids) {

                    $qb->andWhere('l.leadId IN (:leadIds)');
                    $qb->setParameter(':leadIds', $lead_ids);
                } else {
                    return [];
                }
            }


            // Now add the WHERE condition
            switch ($type) {

                case 'delivered':
                    // Join on the PGRE where delivered

                    $qb->andWhere('lgre.delivered_at IS NOT NULL ');
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered

                    $qb->andWhere('lgre.bounced_at IS NOT NULL ');
                    break;

                case 'opened':
                    // Join on the PGRE where delivered

                    $qb->andWhere('lgre.opened_at IS NOT NULL ');
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered

                    $qb->andWhere('lgre.opened_at IS NULL');
                    break;
                case 'clicked':
                    // Join on the PGRE where delivered

                    $qb->andWhere('lgre.clicked_at IS NOT NULL');
                    break;
            }
        }

        // Filters
        if ($action != 'resend') {
            if ($this->session->userdata('lFilter')) {

                // User
                if (($this->session->userdata('lFilterUser') && $this->session->userdata('lFilterUser') != 'All') || $this->session->userdata('lFilterUser') === 'u') {

                    $qb->andWhere('l.account IN(:userIds)');
                    $qb->setParameter(':userIds', $this->session->userdata('lFilterUser'));
                }

                // Source
                if ($this->session->userdata('lFilterSource')) {
                    $qb->andWhere('l.source IN (:source)');
                    $qb->setParameter(':source', $this->session->userdata('lFilterSource'));
                }

                // Status
                if ($this->session->userdata('lFilterStatus')) {

                    $filterStatuses = [];

                    foreach ($this->session->userdata('lFilterStatus') as $k => $v) {
                        if ($v == 'Active') {
                            $filterStatuses[] = 'Working';
                        } else {
                            $filterStatuses[] = $v;
                        }
                    }

                    $qb->andWhere('l.status IN(:statuses)');
                    $qb->setParameter(':statuses', $filterStatuses);
                }

                // Business Type 
                if ($this->session->userdata('lFilterBusinessType')) {



                    $qb->andWhere('l.status IN(:statuses)');
                    $qb->setParameter(':statuses', $filterStatuses);
                }

                // business Type
                if ($this->session->userdata('lFilterBusinessType') && $this->session->userdata('lFilterBusinessType') != 'All') {
                    $qb->from('\models\BusinessTypeAssignment', 'bta');
                    $qb->andWhere('l.leadId = bta.lead_id ');
                    $qb->andWhere('bta.business_type_id IN(:types)');
                    $qb->groupBy('bta.lead_id');
                    $qb->setParameter(':types', $this->session->userdata('lFilterBusinessType'));
                }



                // Created Start Date
                $rangeStart = $this->session->userdata('lFilterDateStart');
                $rangeEnd = $this->session->userdata('lFilterDateEnd');

                if ($rangeStart) {
                    $qb->andWhere('l.created > :createdStart');
                    $qb->setParameter(':createdStart', $rangeStart);
                }

                // Created End Date
                if ($rangeEnd) {
                    $qb->andWhere('l.created < :createdEnd');
                    $qb->setParameter(':createdEnd', $rangeEnd);
                }

                // Age (filter page)
                switch ($this->session->userdata('lFilterAge')) {

                    case 'old':
                        $ageEnd = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        $qb->andWhere('l.created < :ageEnd');
                        $qb->setParameter(':ageEnd', $ageEnd);
                        break;

                    case 'current':
                        $ageStart = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        $ageEnd = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        $qb->andWhere('l.created > :ageStart');
                        $qb->andWhere('l.created < :ageEnd');
                        $qb->setParameter(':ageStart', $ageStart);
                        $qb->setParameter(':ageEnd', $ageEnd);
                        break;

                    case 'new':
                        $ageStart = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        $qb->andWhere('l.created > :ageStart');
                        $qb->setParameter(':ageStart', $ageStart);
                        break;
                }
            }
        } else {
            if ($this->session->userdata('lrFilter_' . $resend_id)) {

                // User
                if (($this->session->userdata('lrFilterUser_' . $resend_id) && $this->session->userdata('lrFilterUser_' . $resend_id) != 'All') || $this->session->userdata('lrFilterUser_' . $resend_id) === 'u') {

                    $qb->andWhere('l.account IN(:userIds)');
                    $qb->setParameter(':userIds', $this->session->userdata('lrFilterUser_' . $resend_id));
                }

                // Source
                if ($this->session->userdata('lrFilterSource_' . $resend_id)) {
                    $qb->andWhere('l.source IN (:source)');
                    $qb->setParameter(':source', $this->session->userdata('lrFilterSource_' . $resend_id));
                }

                // Status
                if ($this->session->userdata('lrFilterStatus_' . $resend_id)) {

                    $filterStatuses = [];

                    foreach ($this->session->userdata('lrFilterStatus_' . $resend_id) as $k => $v) {
                        if ($v == 'Active') {
                            $filterStatuses[] = 'Working';
                        } else {
                            $filterStatuses[] = $v;
                        }
                    }

                    $qb->andWhere('l.status IN(:statuses)');
                    $qb->setParameter(':statuses', $filterStatuses);
                }



                // Created Start Date
                $rangeStart = $this->session->userdata('lrFilterDateStart_' . $resend_id);
                $rangeEnd = $this->session->userdata('lrFilterDateEnd_' . $resend_id);

                if ($rangeStart) {
                    $qb->andWhere('l.created > :createdStart');
                    $qb->setParameter(':createdStart', $rangeStart);
                }

                // Created End Date
                if ($rangeEnd) {
                    $qb->andWhere('l.created < :createdEnd');
                    $qb->setParameter(':createdEnd', $rangeEnd);
                }

                // Age (filter page)
                switch ($this->session->userdata('lFilterAge')) {

                    case 'old':
                        $ageEnd = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        $qb->andWhere('l.created < :ageEnd');
                        $qb->setParameter(':ageEnd', $ageEnd);
                        break;

                    case 'current':
                        $ageStart = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        $ageEnd = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        $qb->andWhere('l.created > :ageStart');
                        $qb->andWhere('l.created < :ageEnd');
                        $qb->setParameter(':ageStart', $ageStart);
                        $qb->setParameter(':ageEnd', $ageEnd);
                        break;

                    case 'new':
                        $ageStart = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        $qb->andWhere('l.created > :ageStart');
                        $qb->setParameter(':ageStart', $ageStart);
                        break;
                }
            }
        }


        // Sorting
        $sortDir = 'asc';

        $order = $this->input->get('order');
        
        if ($order) {
            $sortDir = $order[0]['dir'];
        

        switch ($order[0]['column']) {
            case 2:
                $sortCol = 'l.created';
                break;
            case 4:
                $sortCol = 'l.source';
                break;
            case 5:
                $sortCol = 'l.status';
                break;
            case 6:
                $sortCol = 'l.rating';
                break;
            case 7:
                $sortCol = 'l.dueDate';
                break;
            case 8:
                $sortCol = 'l.company';
                break;
            case 9:
                $sortCol = 'l.zip';
                break;
            case 10:
                $sortCol = 'l.projectName';
                break;
            case 11:
                $sortCol = 'l.firstName';
                break;
            case 13:
                $sortCol = 'l.last_activity';
                break;
            case 15:
                $sortCol = 'lgre.opened_at';
                break;
            default:
                $sortCol = 'l.last_activity';
        }
    }else{
        $sortCol = 'l.last_activity';
    }
        // Search
        if ($this->input->get('search')) {
            $search = $this->input->get('search');

            $qb->andWhere("((l.firstName LIKE :searchVal)
                        OR (l.lastName LIKE :searchVal)
                        OR (l.status LIKE :searchVal)
                        OR (l.companyName LIKE :searchVal)
                        OR (l.title LIKE :searchVal)
                        OR (l.address LIKE :searchVal)
                        OR (l.email LIKE :searchVal)
                        OR (l.city LIKE :searchVal)
                        OR (l.state LIKE :searchVal)
                        OR (l.zip LIKE :searchVal)
                        OR (l.projectName LIKE :searchVal)
                        OR (l.projectAddress LIKE :searchVal)
                        OR (l.projectCity LIKE :searchVal)
                        OR (l.projectState LIKE :searchVal)
                        OR (l.projectZip LIKE :searchVal)
                        OR (l.businessPhone LIKE :searchVal)
                        OR (l.cellPhone LIKE :searchVal)
                        OR (l.source LIKE :searchVal))");

            $qb->setParameter(':searchVal', '%' . $search['value'] . '%');
        }

        // Return the count if requested
        if ($count) {
            $query = $qb->getQuery();
            if ($this->session->userdata('lFilterBusinessType') && $this->session->userdata('lFilterBusinessType') != 'All') {
                return count($query->getResult());
            }
            return $query->getSingleScalarResult();
        }

        // Paging
        $qb->orderBy($sortCol, $sortDir);

        if ($this->input->get('length')) {
            $qb->setMaxResults($this->input->get('length'));
        }

        if ($this->input->get('start')) {
            $qb->setFirstResult($this->input->get('start'));
        }

        // Create the query and get the result
        $query = $qb->getQuery();
        //print_r($query->getSql());
        // print_r($query->getParameters());die;
        $leads = $query->getResult();

        return $leads;
    }

    public function getResendLeadsIds($resendId)
    {
        $out = [];
        $sql = "SELECT DISTINCT(lgre.lead_id)
        FROM `lead_group_resend_email` lgre";
        $CI = &get_instance();
        $account = $CI->em->findAccount($this->getAccountId());
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch

            $sql .= " WHERE lgre.resend_id ={$resendId} AND lgre.is_failed =0";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            leads l1 ON lgre.lead_id = l1.leadId
            LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE lgre.resend_id ={$resendId} AND lgre.is_failed =0 AND a2.branch = " . $account->getBranch();
        } else {

            $sql .= " LEFT JOIN
            leads ON lgre.lead_id = leads.leadId WHERE lgre.resend_id ={$resendId} AND lgre.is_failed =0
                    AND 
                    leads.account = " . $account->getAccountId();
        }
        //WHERE resend_id ={$resendId}";
        $this->load->database();
        $results = $this->db->query($sql)->result();
        $this->db->close();
        foreach ($results as $result) {
            $out[] = $result->lead_id;
        }
        return $out;
    }

    public function getResendFailedLeadsIds($resendId)
    {

        $out = [];
        $sql = "SELECT DISTINCT(lgre.lead_id)
        FROM `lead_group_resend_email` lgre";
        $CI = &get_instance();
        $account = $CI->em->findAccount($this->getAccountId());
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 1";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            leads l1 ON lgre.lead_id = l1.leadId
            LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 1 AND a2.branch = " . $account->getBranch();
        } else {

            $sql .= " LEFT JOIN
            leads ON lgre.lead_id = leads.leadId WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 1
                    AND 
                    leads.account = " . $account->getAccountId();
        }

        // WHERE resend_id ={$resendId}";
        $this->load->database();

        $results = $this->db->query($sql)->result();
        $this->db->close();
        foreach ($results as $result) {
            $out[] = $result->lead_id;
        }
        return $out;
    }

    /**
     * @param bool $count
     * @return array|mixed
     */
    public function getMapProspects()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Define what we're selecting
        $select = 'p';

        // Begin Query - Ensure restriction to this company only
        $qb->select($select)
            ->from('\models\Prospects', 'p')
            ->where('p.company = :companyId')
            ->setParameter(':companyId', $this->getCompany()->getCompanyId());

        if (!$this->hasFullAccess()) {

            // For peons, add further restriction to their own account
            if ($this->isUser()) {
                $qb->andWhere('p.account = :accountId');
                $qb->setParameter(':accountId', $this->getAccountId());
            }

            // For branch managers, join with accounts and branch id
            if ($this->isBranchAdmin()) {
                $qb->from('\models\Accounts', 'a');
                $qb->andWhere('p.account = a.accountId');
                $qb->andWhere('a.branch = :branchId');
                $qb->setParameter(':branchId', $this->getBranch());
            }
        }

        // Create the query and get the result
        $query = $qb->getQuery();
        $prospects = $query->getResult();

        return $prospects;
    }

    public function isUser()
    {
        return ($this->userClass == 0);
    }

    /**
     * @param bool $count
     * @return array|mixed
     */
    public function getProspects($count = false, $action = '', $type = '', $resend_id = '')
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Define what we're selecting
        $select = 'p';
        if ($count) {
            $select = 'COUNT(p)';
        }
        // Begin Query - Ensure restriction to this company only
        $qb->select($select)
            ->from('\models\Prospects', 'p')
            ->where('p.company = :companyId')
            ->setParameter(':companyId', $this->getCompany()->getCompanyId());

        if (!$this->hasFullAccess()) {

            // For peons, add further restriction to their own account
            if ($this->isUser()) {
                $qb->andWhere('p.account = :accountId');
                $qb->setParameter(':accountId', $this->getAccountId());
            }

            // For branch managers, join with accounts and branch id
            if ($this->isBranchAdmin()) {
                $qb->from('\models\Accounts', 'a');
                $qb->andWhere('p.account = a.accountId');
                $qb->andWhere('a.branch = :branchId');
                $qb->setParameter(':branchId', $this->getBranch());
            }
        }

        if ($action == 'resend') {

            // FIrst we have to check for a filter so we can add the join

            $qb->from('\models\ProspectGroupResendEmail', 'pgre');
            $qb->andWhere('p.prospectId = pgre.prospect_id ');
            $qb->andWhere('pgre.resend_id = :resendId');
            $qb->setParameter(':resendId', $this->session->userdata('pProspectResendFilterId'));
            if ($type == 'failed') {
                //$lead_ids = $this->getResendFailedLeadsIds($this->session->userdata('pLeadResendFilterId'));
                $prospect_ids = $this->getResendFailedProspectsIds($this->session->userdata('pProspectResendFilterId'));
                //$lead_ids = explode(",",$lead_ids);
                if ($prospect_ids) {

                    $qb->andWhere('p.prospectId IN (:prospectIds)');
                    $qb->setParameter(':prospectIds', $prospect_ids);
                } else {
                    return [];
                }
            } else {
                // Now we have to check it's in the resend
                $prospect_ids = $this->getResendProspectsIds($this->session->userdata('pProspectResendFilterId'));
                //$lead_ids = explode(",",$lead_ids);
                if ($prospect_ids) {

                    $qb->andWhere('p.prospectId IN (:prospectIds)');
                    $qb->setParameter(':prospectIds', $prospect_ids);
                } else {
                    return [];
                }
            }

            // Now add the WHERE condition
            switch ($type) {

                case 'delivered':
                    // Join on the PGRE where delivered

                    $qb->andWhere('pgre.delivered_at IS NOT NULL ');
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered

                    $qb->andWhere('pgre.bounced_at IS NOT NULL ');
                    break;

                case 'opened':
                    // Join on the PGRE where delivered

                    $qb->andWhere('pgre.opened_at IS NOT NULL ');
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered

                    $qb->andWhere('pgre.opened_at IS NULL');
                    break;
                case 'clicked':
                    // Join on the PGRE where delivered

                    $qb->andWhere('pgre.clicked_at IS NOT NULL');
                    break;
            }
        }

        if ($action != 'resend') {
            // Filters
            if ($this->session->userdata('ptFilter')) {

                // Branch
                if ($this->session->userdata('ptFilterBranch') && $this->session->userdata('ptFilterBranch') != 'All') {
                    $qb->from('\models\Accounts', 'a');
                    $qb->andWhere('p.account = a.accountId');
                    $qb->andWhere('a.branch IN(:branchIds)');
                    $qb->setParameter(':branchIds', $this->session->userdata('ptFilterBranch'));
                }

                // User
                //print_r($this->session->userdata('ptFilterUser'));die;
                if ($this->session->userdata('ptFilterUser') && $this->session->userdata('ptFilterUser') != 'All') {
                    $qb->andWhere('p.account IN(:userIds)');
                    $qb->setParameter(':userIds', $this->session->userdata('ptFilterUser'));
                }

                // Status
                if ($this->session->userdata('ptFilterStatus')) {
                    // $qb->andWhere('p.status = :status');
                    // $qb->setParameter(':status', $this->session->userdata('ptFilterStatus'));
                }

                // Rating
                if ($this->session->userdata('ptFilterRating') && $this->session->userdata('ptFilterRating') != 'All') {
                    // $qb->andWhere('p.rating = :rating');
                    // $qb->setParameter(':rating', $this->session->userdata('ptFilterRating'));

                    $qb->andWhere('p.rating IN(:ratings)');
                    $qb->setParameter(':ratings', $this->session->userdata('ptFilterRating'));
                }

                // Rating
                if ($this->session->userdata('ptFilterSource') && $this->session->userdata('ptFilterRating') != 'All') {
                    // $qb->andWhere('p.prospect_source_id = :source');
                    // $qb->setParameter(':source', $this->session->userdata('ptFilterSource'));

                    $qb->andWhere('p.prospect_source_id IN(:sources)');
                    $qb->setParameter(':sources', $this->session->userdata('ptFilterSource'));
                }
                //print_r($this->session->userdata('ptFilterBusinessType'));die;
                // business Type
                if ($this->session->userdata('ptFilterBusinessType') && $this->session->userdata('ptFilterBusinessType') != 'All') {
                    $qb->from('\models\BusinessTypeAssignment', 'bta');
                    $qb->andWhere('p.prospectId = bta.prospect_id');
                    $qb->andWhere('bta.business_type_id IN(:types)');
                    $qb->groupBy('bta.prospect_id');
                    $qb->setParameter(':types', $this->session->userdata('ptFilterBusinessType'));
                }
            }
        } else {

            // Filters
            if ($this->session->userdata('ptrFilter_' . $resend_id)) {

                // Branch
                if ($this->session->userdata('ptrFilterBranch_' . $resend_id) && $this->session->userdata('ptrFilterBranch_' . $resend_id) != 'All') {
                    $qb->from('\models\Accounts', 'a');
                    $qb->andWhere('p.account = a.accountId');
                    $qb->andWhere('a.branch IN(:branchIds)');
                    $qb->setParameter(':branchIds', $this->session->userdata('ptrFilterBranch_' . $resend_id));
                }

                // User
                //print_r($this->session->userdata('ptFilterUser'));die;
                if ($this->session->userdata('ptrFilterUser_' . $resend_id) && $this->session->userdata('ptrFilterUser_' . $resend_id) != 'All') {
                    $qb->andWhere('p.account IN(:userIds)');
                    $qb->setParameter(':userIds', $this->session->userdata('ptrFilterUser_' . $resend_id));
                }

                // Status
                if ($this->session->userdata('ptrFilterStatus_' . $resend_id)) {
                    // $qb->andWhere('p.status = :status');
                    // $qb->setParameter(':status', $this->session->userdata('ptFilterStatus'));
                }

                // Rating
                if ($this->session->userdata('ptrFilterRating_' . $resend_id) && $this->session->userdata('ptrFilterRating_' . $resend_id) != 'All') {
                    // $qb->andWhere('p.rating = :rating');
                    // $qb->setParameter(':rating', $this->session->userdata('ptFilterRating'));

                    $qb->andWhere('p.rating IN(:ratings)');
                    $qb->setParameter(':ratings', $this->session->userdata('ptrFilterRating_' . $resend_id));
                }

                // Rating
                if ($this->session->userdata('ptrFilterSource_' . $resend_id) && $this->session->userdata('ptrFilterRating_' . $resend_id) != 'All') {
                    // $qb->andWhere('p.prospect_source_id = :source');
                    // $qb->setParameter(':source', $this->session->userdata('ptFilterSource'));

                    $qb->andWhere('p.prospect_source_id IN(:sources)');
                    $qb->setParameter(':sources', $this->session->userdata('ptrFilterSource_' . $resend_id));
                }

                // business Type
                if ($this->session->userdata('ptFilterBusinessType') && $this->session->userdata('ptFilterBusinessType') != 'All') {
                    $qb->from('\models\BusinessTypeAssignment', 'bta');
                    $qb->andWhere('p.prospectId = bta.prospect_id');
                    $qb->andWhere('bta.business_type_id IN(:types)');
                    $qb->groupBy('bta.prospect_id');
                    $qb->setParameter(':types', $this->session->userdata('ptFilterBusinessType'));
                }
            }
        }

        // Return the count if requested
        if ($count) {
            $query = $qb->getQuery();
            if ($this->session->userdata('ptFilterBusinessType') && $this->session->userdata('ptFilterBusinessType') != 'All') {
                return count($query->getResult());
            }
            return $query->getSingleScalarResult();
        }

        // Search
        $search = $this->input->get('search');
        $searchVal = $search['value'];

        if ($searchVal) {
            $qb->andWhere("p.firstName LIKE :fnSearchVal 
                                    OR p.lastName LIKE :lnSearchVal
                                    OR p.companyName LIKE :cSearchVal
                                    OR p.business LIKE :bSearchVal");
            $qb->setParameter('fnSearchVal', "%" . $searchVal . "%");
            $qb->setParameter('lnSearchVal', "%" . $searchVal . "%");
            $qb->setParameter('cSearchVal', "%" . $searchVal . "%");
            $qb->setParameter('bSearchVal', "%" . $searchVal . "%");
        }

        // Limits
        $order = $this->input->get('order');
        $orderCol = $order[0]['column'];
        $orderDir = $order[0]['dir'];

        switch ($orderCol) {
            case 2:
                $qb->orderBy('p.created', $orderDir);
                break;

            case 4:
                $qb->orderBy('p.status', $orderDir);

                break;

            case 5:

                $qb->orderBy('p.rating', $orderDir);

                break;

            case 7:
                $qb->orderBy('p.business', $orderDir);
                break;

            case 8:
                $qb->orderBy('p.companyName', $orderDir);
                break;

            case 9:
                $qb->orderBy('p.firstName', $orderDir);
                break;

            case 12:
                $qb->orderBy('p.account', $orderDir);
                break;
        }

        // Create the query and get the result
        //print_r($qb->getQuery()->getSql());die;
        $query = $qb->getQuery();

        $query->setMaxResults($this->input->get('length'));
        $query->setFirstResult($this->input->get('start'));
        return $query->getResult();
    }

    /**
     * @param bool $array
     * @return array
     */
    public function getStatuses($array = false)
    {
        return $this->getCompany()->getStatuses($array);
    }

    /**
     * @return mixed
     */
    public function getCustomStatuses()
    {
        $CI = &get_instance();

        $dql = "SELECT s
                FROM models\Status s
                WHERE s.company = :company
                AND s.visible = 1
                ORDER BY s.displayOrder ASC";

        $query = $CI->em->createQuery($dql);

        return $query->getResult();
    }

    /**
     *  Return a collection of proposals with a specific status
     * @param $statusId int
     */
    public function getProposalsByStatus($statusId)
    {
        $CI = &get_instance();

        $dql = "SELECT p FROM \models\Proposals p
                WHERE p.owner = :accountId
                AND p.proposalStatus = :statusId";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('accountId', $this->getAccountId());
        $query->setParameter('statusId', $statusId);

        $proposals = $query->getResult();

        return $proposals;
    }

    /**
     * Returns a collection of the default statuses
     */
    public function getDefaultStatuses()
    {
        $CI = &get_instance();

        $q = 'SELECT s FROM models\Status s
                WHERE s.company IS NULL
                AND s.visible = 1
                ORDER BY s.displayOrder ASC';

        $query = $CI->em->createQuery($q);

        return $query->getResult();
    }

    public function getRangeCreatedProposals(array $time, $count = false)
    {
        $CI = &get_instance();

        $sql = "SELECT p.proposalId
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND s.prospect = 0
                AND s.on_hold = 0";

        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue(':accountId', $this->getAccountId());
        $query->bindValue(':startTime', $time['start']);
        $query->bindValue(':finishTime', $time['finish']);
        $query->execute();

        $results = $query->execute();
        $proposalIds = $results->fetchAllAssociative();

        if ($count) {
            return $results->rowCount();
        }

        $proposals = [];
        foreach ($proposalIds as $proposalId) {
            $proposals[] = $this->em->findProposal($proposalId['proposalId']);
        }

        return $proposals;
    }

    public function getRangeWonProposals(array $time, $count = false)
    {

        $CI = &get_instance();

        $sql = "SELECT p.proposalId
                FROM proposals p
                WHERE p.owner = :accountId
                
                AND p.win_date >= :startTime
                AND p.win_date <= :finishTime";

        $query = $CI->em->getConnection()->prepare($sql);

        $query->bindValue(':accountId', $this->getAccountId());
        $query->bindValue(':startTime', $time['start']);
        $query->bindValue(':finishTime', $time['finish']);
        $results = $query->execute();

        $proposalIds = $results->fetchAssociative();

        if ($count) {
            return $results->rowCount();
        }

        $proposals = [];
        foreach ($proposalIds as $proposalId) {
            $proposals[] = $this->em->findProposal($proposalId['proposalId']);
        }

        return $proposals;
    }

    public function getRangeCreatedProposalsPrice(array $time)
    {
        $sql = "SELECT SUM(p.price) as totalVal
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND s.prospect = 0
                AND s.on_hold = 0";

        $query = $this->doctrine->em->getConnection()->prepare($sql);
        $query->bindValue('accountId', $this->getAccountId());
        $query->bindValue('startTime', $time['start']);
        $query->bindValue('finishTime', $time['finish']);
        $results =$query->execute();

        $result = $results->fetchAssociative();

        return (float)$result['totalVal'] ?: 0;
    }

    public function getNumRangeCreatedProposalsStatus(array $time, \models\Status $status)
    {
        $CI = &get_instance();

        $sql = "SELECT p.proposalId
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                LEFT JOIN clients ON p.client = clients.clientId
                LEFT JOIN companies ON clients.company = companies.companyId
                WHERE companies.companyId = :companyId
                AND p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.proposalStatus = :statusId
                AND s.prospect = 0
                AND s.on_hold = 0";

        if(!empty($time)){
            $sql .=" AND p.created >= :startTime
            AND p.created <= :finishTime ";
        }

        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue(':accountId', $this->getAccountId());
        if(!empty($time)){
            
            $query->bindValue(':startTime', $time['start']);
            $query->bindValue(':finishTime', $time['finish']);
        }
        $query->bindValue(':companyId', $this->getCompanyId());
        $query->bindValue(':statusId', $status->getStatusId());

        return $query->execute()->rowCount();
    }

    public function getNumRangeCreatedProposalsEmailOff(array $time)
    {
        $CI = &get_instance();

        $sql = "SELECT p.proposalId
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                LEFT JOIN clients ON p.client = clients.clientId
                LEFT JOIN companies ON clients.company = companies.companyId
                WHERE companies.companyId = :companyId
                AND p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.resend_excluded = 1
                AND s.prospect = 0
                AND s.on_hold = 0";

            if($time['start'] != "" && $time['finish'] != ""){
                $sql .=" AND p.created >= :startTime
                AND p.created <= :finishTime ";
            }

        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue(':accountId', $this->getAccountId());
        if($time['start'] != "" && $time['finish'] != ""){
            
            $query->bindValue(':startTime', $time['start']);
            $query->bindValue(':finishTime', $time['finish']);
        }

        $query->bindValue(':companyId', $this->getCompanyId());
        
        return $query->execute()->rowCount();
    }

    public function getRangeMagicNumber(array $time, \models\Status $status)
    {
        $statusId = $status->getStatusId();

        $dql = "SELECT SUM(p.price)
                FROM \models\Proposals p
                WHERE p.owner = :accountId
                AND p.proposalStatus = :statusId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                -- AND p.statusChangeDate >= :startTime
                -- AND p.statusChangeDate <= :finishTime
                ";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('accountId', $this->getAccountId());
        $query->setParameter('statusId', $statusId);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRolloverValue($startTime)
    {
        $openStatus = $this->getCompany()->getOpenStatus();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.created < :startTime
                AND p.proposalStatus = :statusId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('accountId', $this->getAccountId());
        $query->setParameter('startTime', $startTime);
        $query->setParameter('statusId', $openStatus->getStatusId());

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRangeCreatedProposalsStatusPrice(array $time, $statusId)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND p.proposalStatus = :statusId";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('accountId', $this->getAccountId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return ($total) ?: 0;
    }

    public function getRangeCreatedProposalsUserStatusPrice(array $time, $statusId)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                
                AND p.proposalStatus = :statusId";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('accountId', $this->getAccountId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return ($total) ?: 0;
    }

    public function getSalesValue(array $time)
    {
        //var_dump($time);
        $CI = &get_instance();

        $sql = "SELECT SUM(p.price) AS totalVal 
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.deleted = 0
                AND p.win_date >= :startTimeChange
                AND p.win_date <= :finishTimeChange
                AND s.sales = 1";

        // Raw PDO
        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue('accountId', $this->getAccountId());
        $query->bindValue('startTimeChange', $time['start']);
        $query->bindValue('finishTimeChange', $time['finish']);
        $results = $query->execute();

        $result = $results->fetchAssociative();

        return (float)$result['totalVal'] ?: 0;
    }

    public function getSalesValueCreated(array $time)
    {
        $CI = &get_instance();

        $sql = "SELECT SUM(p.price) AS totalVal 
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTimeChange
                AND p.created <= :finishTimeChange
                AND s.sales = 1";

        // Raw PDO
        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue('accountId', $this->getAccountId());
        $query->bindValue('startTimeChange', $time['start']);
        $query->bindValue('finishTimeChange', $time['finish']);
        $results = $query->execute();

        $result = $results->fetchAssociative();

        return (float)$result['totalVal'] ?: 0;
    }

    public function getSalesValueRollover($time)
    {
        $CI = &get_instance();

        $sql = "SELECT SUM(p.price) AS totalVal 
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.created < :startTime
                AND p.win_date >= :startTimeChange
                AND p.win_date <= :finishTimeChange
                AND s.sales = 1";

        // Raw PDO
        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue('accountId', $this->getAccountId());
        $query->bindValue('startTime', $time['start']);
        $query->bindValue('startTimeChange', $time['start']);
        $query->bindValue('finishTimeChange', $time['finish']);
        $results = $query->execute();

        $result = $results->fetchAssociative();

        return (float)$result['totalVal'] ?: 0;
    }

    /**
     * @return bool
     */
    public function hasDeleteProposalPermission()
    {
        // Currently only available to admins
        return $this->isAdministrator();
    }

    /**
     * @return bool
     */
    public function hasNotifications()
    {
        // Check if there are delete requests
        if ($this->getCompany()->numDeleteRequests()) {
            return true;
        }
        return false;
    }

    public function getApprovalLimit()
    {
        // First check if we are using company default
        if ($this->getDefaultApproval()) {
            // If we are, return the value or default to zero
            return $this->getCompany()->getDefaultBidApproval() ?: 0;
        } else {
            return $this->getApprovalAmount() ?: 0;
        }
    }

    /**
     * @return mixed
     */
    public function getDefaultApproval()
    {
        return $this->defaultApproval;
    }

    /**
     * @param mixed $defaultApproval
     */
    public function setDefaultApproval($defaultApproval)
    {
        $this->defaultApproval = $defaultApproval;
    }

    /**
     * @return mixed
     */
    public function getApprovalAmount()
    {
        return $this->approvalAmount;
    }

    /**
     * @param mixed $approvalAmount
     */
    public function setApprovalAmount($approvalAmount)
    {
        $this->approvalAmount = $approvalAmount;
    }

    /**
     * Getter for Layout
     * @return mixed
     */
    public function getLayout()
    {
        
        return $this->layout ?: $this->getCompany()->getLayout();
    }

    /**
     * Setter for Layout
     * @var $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function getProposalsData($action = '', $client = '', $limit = true, $map = false, $company = false, $page = false, $numRecords = false, $coords = null, $campaignEmailFilter = null, $resend_id = null)
    {
        //"SELECT COUNT(notes.noteId) as ncount FROM notes WHERE notes.type = 'proposal' AND relationId="
        $this->load->database();
        $firstProposal = $this->getCompany()->getFirstProposalTime();
        if ($limit) {
            $select = 'proposals.proposalId, proposals.projectName, proposals.projectAddress, proposals.projectCity, proposals.projectState, proposals.projectZip, proposals.price, proposals.jobNumber, proposals.created, proposals.status, proposals.duplicateOf, proposals.approvalQueue, proposals.declined, proposals.proposalStatus, proposals.last_activity, proposals.email_status, proposals.deliveryTime, proposals.lastOpenTime, proposals.emailSendTime, proposals.audit_key, proposals.audit_view_time, proposals.audit_reminder_sent, proposals.win_date, proposals.QBID, proposals.unapproved_services, proposals.lat, proposals.lng, proposals.access_key,proposals.estimate_status_id,proposals.job_cost_status,proposals.profit_margin_value,proposals.profit_margin_percent, proposals.image_count,proposals.is_hidden_to_view,proposals.business_type_id,proposals.approved,proposals.layout as proposal_layout,proposals.resend_excluded,proposals.note_count as ncount,proposals.signature_id,proposals.company_signature_id,proposals.proposal_view_count,proposals.owner,proposals.company_id,proposals.resend_enabled,
            accounts.firstName as accountFN, accounts.lastName as accountLN, accounts.branch, accounts.accountId as account,accounts.layout as owner_layout,
            client_companies.name as clientAccountName,
            clients.clientId, clients.title as clientTitle, clients.firstName as clientFN, clients.lastName as clientLN, clients.businessPhone as clientBP, clients.cellPhone as clientCP, clients.companyName as clientCompany, clients.quickbooksId as clientQuickbooksId, clients.email as clientEmail,
            statuses.text as statusText,statuses.sales as is_sales,statuses.color as statusColor';
        }else if($map){
            $select = 'proposals.proposalId ';
        } else {
            $select = 'COUNT(DISTINCT(proposals.proposalId)) AS numProposals';
        }
        // Base query
        $sql = 'SELECT ' . $select . ' FROM proposals';

        if ($limit) {
            //$sql .= " IGNORE INDEX(idx_company_id)";
        }

        $sql.= ' LEFT JOIN clients on proposals.client = clients.clientId
        LEFT JOIN client_companies on clients.client_account = client_companies.id
        LEFT JOIN companies on clients.company = companies.companyId
        LEFT JOIN accounts on proposals.owner = accounts.accountId
        LEFT JOIN statuses on proposals.proposalStatus = statuses.id
        ';


        // Join required for services so add here //
        $serviceJoin = false;
        // Check for status filters first as these are temporary
        if ($action == 'status') {
            if ($this->session->userdata('pStatusFilter') && $this->session->userdata('pStatusFilterService')) {
                $serviceJoin = true;
            }
        }   // Standard proposals join
        else {
            if ($this->session->userdata('pFilter') && $this->session->userdata('pFilterService') && $action != 'search') {
                $serviceJoin = true;
            }
        }

        if ($serviceJoin) {
            $sql .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
        }

        $order = $this->input->get('order');

        // If no order, default to created
        if (!$order) {
            $order = [
                0 => [
                    'column' => 2,
                    'dir' => 'ASC'
                ]
            ];
        }

        // Run permissions check if we're not doing the whole company

        if ($action == 'Resend') {

            // FIrst we have to check for a filter so we can add the join
            if ($campaignEmailFilter) {
                // Join on the PGRE where delivered
                $pResendFilterId = $this->session->userdata('pResendFilterId');
                if ($campaignEmailFilter != 'failed') {
                    $sql .= "  LEFT JOIN proposal_group_resend_email pgre ON proposals.proposalId = pgre.proposal_id  ";
                }
                if ($this->session->userdata('prFilterNotesAdded_' . $resend_id)) {
                    $sql .=  "LEFT JOIN
                    proposal_group_resends pgr ON pgre.resend_id = pgr.id
                        LEFT JOIN
                    notes ON pgre.proposal_id = notes.relationId AND notes.type = 'proposal'";
                }

                // if($campaignEmailFilter=='failed'){
                //     $sql .=  "JOIN
                //     failed_jobs fj ON pgre.resend_id = fj.campaign_id AND fj.job_type = 'proposal_campaign'";
                // }
                //echo  $sql;die;
            }
            if ($campaignEmailFilter == 'failed') {
                $proposal_ids = $this->getResendFailedProposalsIds($this->session->userdata('pResendFilterId'));


                if ($proposal_ids) {

                    $proposal_ids = implode(',', $proposal_ids);
                    $sql .= ' WHERE (proposals.proposalId IN(' . $proposal_ids . ')';
                } else {
                    return [];
                }
                //echo $sql;die;
            } else {
                // Now we have to check it's in the resend
                $proposal_ids = $this->getResendProposalsIds($this->session->userdata('pResendFilterId'));


                if ($proposal_ids) {

                    $proposal_ids = implode(',', $proposal_ids);
                    $sql .= ' WHERE (proposals.proposalId IN(' . $proposal_ids . ')';
                } else {
                    return [];
                }
            }
            if ($campaignEmailFilter) {
                $pResendFilterId = $this->session->userdata('pResendFilterId');
                if ($campaignEmailFilter != 'failed') {
                    if ($this->session->userdata('prFromFilterStatus_' . $resend_id)) {
                        $fromstatusId = $this->session->userdata('prFromFilterStatus_' . $resend_id);
                        $sql .= " AND pgre.resend_id = '$pResendFilterId'  AND pgre.proposal_status_id = '$fromstatusId'";
                    }
                    else if($this->session->userdata('pResendToStatusId') && $this->session->userdata('pResendFromStatusId')){
                        $fromstatusId = $this->session->userdata('pResendFromStatusId');
                        $toStatusId = $this->session->userdata('pResendToStatusId');
                        $sql .= " AND pgre.resend_id = '$pResendFilterId'  AND proposals.proposalStatus  = '$toStatusId' AND pgre.proposal_status_id = '$fromstatusId'";
                    } 
                    else {
                        $sql .= " AND pgre.resend_id = '$pResendFilterId'";
                    }
                }
                if ($this->session->userdata('prFilterNotesAdded_' . $resend_id)) {
                    $sql .= " AND notes.added > UNIX_TIMESTAMP(pgr.created)";
                }
            }
            // Now add the WHERE condition
            switch ($campaignEmailFilter) {

                case 'delivered':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.delivered_at IS NOT NULL";
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.bounced_at IS NOT NULL";
                    break;

                case 'opened':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.opened_at IS NOT NULL";
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.opened_at IS NULL";
                    break;
                case 'clicked':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.clicked_at IS NOT NULL";
                    break;
            }
            if ($this->session->userdata('prFromFilterStatus_' . $resend_id)) {
                $fromstatusId = $this->session->userdata('prFromFilterStatus_' . $resend_id);
                //$sql .= " AND pgre.proposal_status_id = '$fromstatusId'" ;
                //echo $sql;die;
            }
        } else if (!$company) {
            // Filter by user permissions
            if ($this->getUserClass() >= 2) {
                //company admin or full access, access to all proposals
                if($order[0]['column']==3 || $order[0]['column']==2){
                    $sql .= ' WHERE (proposals.company_id =' . $this->getCompany()->getCompanyId();
                }else{
                    $sql .= ' WHERE (clients.company =' . $this->getCompany()->getCompanyId();
                }
                
            } else {
                if ($this->isBranchAdmin()) {
                    //branch admin, can access only his branch
                    $sql .= ' WHERE (accounts.branch = ' . $this->getBranch();
                    if($order[0]['column']==3 || $order[0]['column']==2){
                        $sql .= ' AND proposals.company_id =' . $this->getCompany()->getCompanyId();
                    }else{
                        $sql .= ' AND clients.company =' . $this->getCompany()->getCompanyId();
                    }
                } else {
                    //regular user, can access only his proposals
                    $sql .= ' WHERE (proposals.owner=' . $this->getAccountId();
                }
            }
        } else {
            if($order[0]['column']==3 || $order[0]['column']==2 ){
                $sql .= ' AND proposals.company_id =' . $this->getCompany()->getCompanyId();
            }else{
                $sql .= ' AND clients.company =' . $this->getCompany()->getCompanyId();
            }
            
        }

        //if (!$this->isAdministrator() && ($this->getFullAccess() == 'no')) {
            $proposal_ids = $this->getUserPermissionProposalIds();
            if($proposal_ids){

                $sql .= ' OR (proposals.proposalId IN('.$proposal_ids.')) ';
    
                 }
       // }
        $sql .= ')';
        // Search
        if ($this->input->get('search')) {

            $search = $this->input->get('search');
            $searchValue = $this->db->escape_like_str($search['value']);

            if (strpos($search['value'], '$') === 0) {
                // Strip out dollar sign and commas and turn into an int
                $priceSearchString = str_replace(['$', ','], ['', ''], $searchValue);
                $priceSearch = intval($priceSearchString);

                if (strlen($priceSearchString) > 0) {
                    // Set upper and lower boundaries
                    $minPriceSearch = $priceSearch - 0.5;
                    $maxPriceSearch = $priceSearch + 0.5;

                    // Add to query
                    $sql .= " AND (proposals.price >= " . $minPriceSearch . " AND proposals.price < " . $maxPriceSearch . ')';
                }
            } else {
                if ($searchValue  != '') {
                    $sql .= " AND ( (proposals.projectName like \"%" . $searchValue . "%\")
                        OR (clients.email like \"%" . $searchValue . "%\")
                        OR (client_companies.name like \"%" . $searchValue . "%\")
                        OR (clients.lastName like \"%" . $searchValue . "%\")
                        OR (clients.firstName like \"%" . $searchValue . "%\")
                        OR (CONCAT(clients.firstName, ' ', clients.lastName) like \"%" . $searchValue . "%\")
                        OR (proposals.projectAddress like \"%" . $searchValue . "%\")
                        OR (proposals.projectCity like \"%" . $searchValue . "%\")
                        OR (proposals.projectState like \"%" . $searchValue . "%\")
                        OR (proposals.projectZip like \"%" . $searchValue . "%\")
                        OR (clients.businessPhone like \"%" . $searchValue . "%\")
                        OR (clients.cellPhone like \"%" . $searchValue . "%\")
                        OR (proposals.jobNumber like \"%" . $searchValue . "%\")
                        )";
                }
            }
        }

        // Client
        if ($client) {
            $sql .= " AND clients.clientId = " . $client;
        }

        // Mappable proposals
        if ($map) {
            $sql .= " AND (proposals.lat IS NOT NULL AND proposals.lng IS NOT NULL)";
        }

        if ($action != 'Resend') {
            // Filters
            if (($action == 'status') && $this->session->userdata('pStatusFilter')) {
                if ($this->session->userdata('pStatusFilterStatus') && $this->session->userdata('pStatusFilterStatus') != 'All') {
                    $sql .= " and (proposals.proposalStatus = '" . $this->session->userdata('pStatusFilterStatus') . "')";
                }

                if (($this->session->userdata('pStatusFilterBranch') && $this->session->userdata('pStatusFilterBranch') != 'All') || ($this->session->userdata('pStatusFilterBranch') === '0')) {

                    $sql .= " and (accounts.branch = '" . $this->session->userdata('pStatusFilterBranch') . "')";
                }

                if ($this->session->userdata('pStatusFilterUser') && $this->session->userdata('pStatusFilterUser') != 'All') {
                    $sql .= " and (clients.account = '" . $this->session->userdata('pStatusFilterUser') . "')";
                }

                if ($this->session->userdata('rollover')) {

                    $start = $firstProposal;
                    $end = mktime(0, 0, 0, 1, 1, date('Y'));

                    $sql .= " and (proposals.created >= {$start})";

                    $sql .= " and (proposals.created <= {$end})";
                } else {
                    if ($this->session->userdata('pStatusFilterFrom')) {
                        $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
                        $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                        $sql .= " and (proposals.created >= {$start})";
                    }

                    if ($this->session->userdata('pStatusFilterTo')) {
                        $to = explode('/', $this->session->userdata('pStatusFilterTo'));
                        $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                        $sql .= " and (proposals.created <= {$end})";
                    }
                }

                if ($this->session->userdata('pStatusFilterService')) {
                    $sql .= ' and proposal_services.initial_service = ' . $this->session->userdata('pStatusFilterService');
                }

                // Status date change from
                if ($this->session->userdata('pStatusFilterChangeFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterChangeFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.statusChangeDate >= {$start})";
                }
                // Status date change to
                if ($this->session->userdata('pStatusFilterChangeTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterChangeTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.statusChangeDate <= {$end})";
                }

                if ($this->session->userdata('pStatusFilterService')) {
                    $sql .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('pStatusFilterService')
                    ) . "))";
                }

                if ($this->session->userdata('pStatusFilterQueue')) {

                    if ($this->session->userdata('pStatusFilterQueue') == 'duplicate') {
                        $sql .= ' and proposals.duplicateOf IS NOT NULL';
                    } else {
                        if ($this->session->userdata('pStatusFilterQueue') == 1) {
                            $sql .= ' and proposals.approvalQueue = 1';
                        } else {
                            $sql .= ' and proposals.declined = 1';
                        }
                    }
                }

                if ($this->session->userdata('pFilterBusinessType')) {
                    $types = implode(',', $this->session->userdata('pFilterBusinessType'));
                    $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                }
            } else {
                if ($this->session->userdata('pFilter') && $action != 'search') {

                    // Proposal Status
                    if ($this->session->userdata('pFilterStatus')) {
                        //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                        $sql .= " and (proposals.proposalStatus IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterStatus')
                        ) . "))";
                    } else {
                        $sql .= " AND statuses.prospect = 0";
                    }

                    // Estimate Status
                    if ($this->session->userdata('pFilterEstimateStatus')) {
                        $sql .= " and (proposals.estimate_status_id IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterEstimateStatus')
                        ) . "))";
                    }

                    // job Cost Status
                    if ($this->session->userdata('pFilterJobCostStatus')) {
                        $sql .= " and (proposals.job_cost_status IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterJobCostStatus')
                        ) . "))";
                    }
                    // User
                    if ($this->session->userdata('pFilterUser')) {
                        $sql .= " and (proposals.owner IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterUser')
                        ) . "))";
                    } /*else {
                        if ($this->session->userdata('pFilterBranch')) {
                            $sql .= " and (accounts.branch IN (" . implode(
                                ', ',
                                $this->session->userdata('pFilterBranch')
                            ) . "))";
                        }
                    }*/
                    // Account
                    if ($this->session->userdata('pFilterClientAccount')) {
                        $sql .= " AND (clients.client_account IN (" . implode(
                            ',',
                            $this->session->userdata('pFilterClientAccount')
                        ) . "))";
                    }
                    // Created Date from
                    if ($this->session->userdata('pCreatedFrom')) {
                        $start = $this->session->userdata('pCreatedFrom');
                        $sql .= " AND (proposals.created >= {$start})";
                    }
                    // Created Date To
                    if ($this->session->userdata('pCreatedTo')) {
                        $end = $this->session->userdata('pCreatedTo');
                        $sql .= " AND (proposals.created <= {$end})";
                    }

                    // Created Date from
                    if ($this->session->userdata('pNewerThen')) {
                        $start = $this->session->userdata('pNewerThen');
                        $sql .= " AND (proposals.created >= {$start})";
                    }
                    // Created Date To
                    if ($this->session->userdata('pOlderThen')) {
                        $end = $this->session->userdata('pOlderThen');
                        $sql .= " AND (proposals.created <= {$end})";
                    }

                    // Activity Date from
                    if ($this->session->userdata('pActivityFrom')) {
                        $laStart = $this->session->userdata('pActivityFrom');
                        $sql .= " AND (proposals.last_activity >= {$laStart})";
                    }
                    // Activity Date To
                    if ($this->session->userdata('pActivityTo')) {
                        $laEnd = $this->session->userdata('pActivityTo');
                        $sql .= " AND (proposals.last_activity <= {$laEnd})";
                    }

                    // Won Date from
                    if ($this->session->userdata('pWonFrom')) {
                        $wonStart = $this->session->userdata('pWonFrom');
                        $sql .= " AND (proposals.win_date >= {$wonStart})";
                    }
                    // Won Date To
                    if ($this->session->userdata('pWonTo')) {
                        $wonEnd = $this->session->userdata('pWonTo');
                        $sql .= " AND (proposals.win_date <= {$wonEnd})";
                    }

                    if ($this->session->userdata('pFilterService')) {
                        $sql .= " and (proposal_services.initial_service IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterService')
                        ) . "))";
                    }
                    
                    if ($this->session->userdata('pFilterQueue')) {

                        $addOr = false;
                        $sql .= ' AND (';

                        if (in_array('duplicate', $this->session->userdata('pFilterQueue'))) {
                            $addOr = true;
                            $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                        }

                        if (in_array(1, $this->session->userdata('pFilterQueue'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.approvalQueue = 1)';
                            $addOr = true;
                        }

                        if (in_array(2, $this->session->userdata('pFilterQueue'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.declined = 1)';
                            $addOr = true;
                        }

                        if (in_array('unapproved', $this->session->userdata('pFilterQueue'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.unapproved_services = 1)';
                        }

                        $sql .= ')';
                    }
                    if ($this->session->userdata('pFilterEmailStatus')) {

                        $addOr = false;
                        $sql .= ' AND (';

                        if (in_array('o', $this->session->userdata('pFilterEmailStatus'))) {
                            $addOr = true;
                            $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                        }

                        if (in_array('d', $this->session->userdata('pFilterEmailStatus'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                            $addOr = true;
                        }

                        if (in_array('u', $this->session->userdata('pFilterEmailStatus'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                                AND proposals.deliveryTime IS NULL)';
                            $addOr = true;
                        }

                        if (in_array('uo', $this->session->userdata('pFilterEmailStatus'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                                AND proposals.deliveryTime IS NOT NULL)';
                        }
                        if (in_array('us', $this->session->userdata('pFilterEmailStatus'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                        }

                        $sql .= ')';
                    }


                    if ($this->session->userdata('pFilterMinBid')) {
                        if ($this->session->userdata('pFilterMinBid') != 0) {
                            $sql .= ' AND (proposals.price >= ' . $this->session->userdata('pFilterMinBid') . ')';
                        }
                    }

                    if ($this->session->userdata('pFilterMaxBid')) {
                        if ($this->session->userdata('pFilterMaxBid') != $this->getCompany()->getHighestBid()) {
                            $sql .= ' AND (proposals.price <= ' . $this->session->userdata('pFilterMaxBid') . ')';
                        }
                    }

                    if ($this->session->userdata('pFilterBusinessType')) {
                        $types = implode(',', $this->session->userdata('pFilterBusinessType'));
                        $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                    }

                    if ($this->session->userdata('pFilterBusinessType')) {
                        $types = implode(',', $this->session->userdata('pFilterBusinessType'));
                        $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                    }
                    if ($this->session->userdata('pResendExclude') == '1' && $this->session->userdata('pResendInclude') == '1' || $this->session->userdata('pResendExclude') == '0' && $this->session->userdata('pResendInclude') == '0') {
                    } else {
                        if ($this->session->userdata('pResendExclude')) {

                            $sql .= ' AND proposals.resend_excluded =1';
                        }
                        if ($this->session->userdata('pResendInclude')) {

                            $sql .= ' AND proposals.resend_excluded =0';
                        }
                    }

                    if ($this->session->userdata('pUnsigned') == '1' && $this->session->userdata('pSigned') == '1' || $this->session->userdata('pUnsigned') == '0' && $this->session->userdata('pSigned') == '0') {
                    } else {
                        if ($this->session->userdata('pSigned')) {

                            $sql .= ' AND proposals.signature_id IS NOT NULL';
                        }
                        if ($this->session->userdata('pUnsigned')) {

                            $sql .= ' AND proposals.signature_id IS NULL';
                        }
                    }


                    if ($this->session->userdata('pCompanyUnsigned') == '1' && $this->session->userdata('pCompanySigned') == '1' || $this->session->userdata('pCompanyUnsigned') == '0' && $this->session->userdata('pCompanySigned') == '0') {
                    } else {
                        if ($this->session->userdata('pCompanySigned')) {

                            $sql .= ' AND proposals.company_signature_id IS NOT NULL';
                        }
                        if ($this->session->userdata('pCompanyUnsigned')) {

                            $sql .= ' AND proposals.company_signature_id IS NULL';
                        }
                    }
                }
            }
        } else if ($this->session->userdata('prFilter_' . $resend_id)) {
            
            // Proposal Status
            if ($this->session->userdata('prFilterStatus_' . $resend_id)) {
                //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                $sql .= " and (proposals.proposalStatus IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterStatus_' . $resend_id)
                ) . "))";
            } else {
                $sql .= " AND statuses.prospect = 0";
            }

            // Estimate Status
            if ($this->session->userdata('prFilterEstimateStatus_' . $resend_id)) {
                $sql .= " and (proposals.estimate_status_id IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterEstimateStatus_' . $resend_id)
                ) . "))";
            }

            // job Cost Status
            if ($this->session->userdata('prFilterJobCostStatus_' . $resend_id)) {
                $sql .= " and (proposals.job_cost_status IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterJobCostStatus_' . $resend_id)
                ) . "))";
            }
            // User
            if ($this->session->userdata('prFilterUser_' . $resend_id)) {
                $sql .= " and (proposals.owner IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterUser_' . $resend_id)
                ) . "))";
            } else {
                if ($this->session->userdata('prFilterBranch_' . $resend_id)) {
                    $sql .= " and (accounts.branch IN (" . implode(
                        ', ',
                        $this->session->userdata('prFilterBranch_' . $resend_id)
                    ) . "))";
                }
            }
            // Account
            if ($this->session->userdata('prFilterClientAccount_' . $resend_id)) {
                $sql .= " AND (clients.client_account IN (" . implode(
                    ',',
                    $this->session->userdata('prFilterClientAccount_' . $resend_id)
                ) . "))";
            }
            // Created Date from
            if ($this->session->userdata('prCreatedFrom_' . $resend_id)) {
                $start = $this->session->userdata('prCreatedFrom_' . $resend_id);
                $sql .= " AND (proposals.created >= {$start})";
            }
            // Created Date To
            if ($this->session->userdata('prCreatedTo_' . $resend_id)) {
                $end = $this->session->userdata('prCreatedTo_' . $resend_id);
                $sql .= " AND (proposals.created <= {$end})";
            }
            // Activity Date from
            if ($this->session->userdata('prActivityFrom_' . $resend_id)) {
                $laStart = $this->session->userdata('prActivityFrom_' . $resend_id);
                $sql .= " AND (proposals.last_activity >= {$laStart})";
            }
            // Activity Date To
            if ($this->session->userdata('prActivityTo_' . $resend_id)) {
                $laEnd = $this->session->userdata('prActivityTo_' . $resend_id);
                $sql .= " AND (proposals.last_activity <= {$laEnd})";
            }

            // Won Date from
            if ($this->session->userdata('prWonFrom_' . $resend_id)) {
                $wonStart = $this->session->userdata('prWonFrom_' . $resend_id);
                $sql .= " AND (proposals.win_date >= {$wonStart})";
            }
            // Won Date To
            if ($this->session->userdata('prWonTo_' . $resend_id)) {
                $wonEnd = $this->session->userdata('prWonTo_' . $resend_id);
                $sql .= " AND (proposals.win_date <= {$wonEnd})";
            }

            if ($this->session->userdata('prFilterService_' . $resend_id)) {
                $sql .= " and (proposal_services.initial_service IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterService_' . $resend_id)
                ) . "))";
            }
            if ($this->session->userdata('prFilterQueue_' . $resend_id)) {

                $addOr = false;
                $sql .= ' AND (';

                if (in_array('duplicate', $this->session->userdata('prFilterQueue_' . $resend_id))) {
                    $addOr = true;
                    $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                }

                if (in_array(1, $this->session->userdata('prFilterQueue_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.approvalQueue = 1)';
                    $addOr = true;
                }

                if (in_array(2, $this->session->userdata('prFilterQueue_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.declined = 1)';
                    $addOr = true;
                }

                if (in_array('unapproved', $this->session->userdata('prFilterQueue_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.unapproved_services = 1)';
                }

                $sql .= ')';
            }
            if ($this->session->userdata('prFilterEmailStatus_' . $resend_id)) {

                $addOr = false;
                $sql .= ' AND (';

                if (in_array('o', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    $addOr = true;
                    $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                }

                if (in_array('d', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                    $addOr = true;
                }

                if (in_array('u', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                        AND proposals.deliveryTime IS NULL)';
                    $addOr = true;
                }

                if (in_array('uo', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                        AND proposals.deliveryTime IS NOT NULL)';
                }
                if (in_array('us', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                }

                $sql .= ')';
            }


            if ($this->session->userdata('prFilterMinBid_' . $resend_id)) {
                if ($this->session->userdata('prFilterMinBid_' . $resend_id) != 0) {
                    $sql .= ' AND (proposals.price >= ' . $this->session->userdata('prFilterMinBid_' . $resend_id);
                    if (!$this->session->userdata('prFilterMaxBid_' . $resend_id)) {
                        $sql .= ' OR proposals.price IS NULL)';
                    } else {
                        $sql .= ')';
                    }
                }
            }

            if ($this->session->userdata('prFilterMaxBid_' . $resend_id)) {
                if ($this->session->userdata('prFilterMaxBid_' . $resend_id) != $this->getCompany()->getHighestBid()) {
                    $sql .= ' AND (proposals.price <= ' . $this->session->userdata('prFilterMaxBid_' . $resend_id);
                    if (!$this->session->userdata('prFilterMinBid_' . $resend_id)) {
                        $sql .= ' OR proposals.price IS NULL)';
                    } else {
                        $sql .= ')';
                    }
                }
            }

            if ($this->session->userdata('prFilterBusinessType_' . $resend_id)) {
                $types = implode(',', $this->session->userdata('prFilterBusinessType_' . $resend_id));
                $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
            }

            

            if ($this->session->userdata('prResendExclude_'.$resend_id) == '1' && $this->session->userdata('prResendInclude_'.$resend_id) == '1' || $this->session->userdata('prResendExclude_'.$resend_id) == '0' && $this->session->userdata('prResendInclude_'.$resend_id) == '0') {
            } else {
                if ($this->session->userdata('prResendExclude_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.resend_excluded =1';
                    
                }
                if ($this->session->userdata('prResendInclude_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.resend_excluded =0';
                    
                }
            }

            if ($this->session->userdata('prUnsigned_'.$resend_id) == '1' && $this->session->userdata('prSigned_'.$resend_id) == '1' || $this->session->userdata('prUnsigned_'.$resend_id) == '0' && $this->session->userdata('prSigned_'.$resend_id) == '0') {
            } else {
                if ($this->session->userdata('prSigned_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.signature_id IS NOT NULL';
                    
                }
                if ($this->session->userdata('prUnsigned_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.signature_id IS NULL';
                    
                }
            }

            if ($this->session->userdata('prCompanyUnsigned_'.$resend_id) == '1' && $this->session->userdata('prCompanySigned_'.$resend_id) == '1' || $this->session->userdata('prCompanyUnsigned_'.$resend_id) == '0' && $this->session->userdata('prCompanySigned_'.$resend_id) == '0') {
            } else {
                if ($this->session->userdata('prCompanySigned_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.company_signature_id IS NOT NULL';
                    
                }
                if ($this->session->userdata('prCompanyUnsigned_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.company_signature_id IS NULL';
                    
                }
            }
            
        }


        // Map coordinates
        if ($coords) {
            $sql .= " AND proposals.lat < " . $coords['x1'] . "
                      AND proposals.lng < " . $coords['x2'] . "
                      AND proposals.lat > " . $coords['y1'] . "
                      AND proposals.lng > " . $coords['y2'];
        }
        //$sql .= " AND pgre.proposal_status_id =1";
        // Searching on services can give duplicate results - this stops that
        if ($this->session->userdata('pFilterService')) {
            if($limit){
                 $sql .= ' GROUP BY proposals.proposalId';
            }
        }
        if ($this->session->userdata('prFilterNotesAdded_' . $resend_id)) {
            if($limit){
                 $sql .= ' GROUP BY proposals.proposalId';
            }
        }

        if ($this->input->get('order') && $limit) {

            ///SORTING
            $order = $this->input->get('order');

            switch ($order[0]['column']) {
                case 2: // date
                    $sql .= ' ORDER BY proposals.created ' . $order[0]['dir'];
                    break;
                case 3: // status
                    $sql .= ' ORDER BY statusText ' . $order[0]['dir'];
                    break;
                case 4: // Win date
                    $sql .= ' ORDER BY proposals.win_date ' . $order[0]['dir'];
                    break;
                case 5: // job Number
                    $sql .= ' ORDER BY lpad(proposals.jobNumber, 10, 0) ' . $order[0]['dir'];
                    break;
                case 6: // Client Account Name
                    $sql .= ' ORDER BY client_companies.name ' . $order[0]['dir'];
                    break;
                case 7: // Project Name
                    $sql .= ' ORDER BY proposals.projectName ' . $order[0]['dir'];
                    break;
                case 8: // Image Count
                    $sql .= ' ORDER BY proposals.image_count ' . $order[0]['dir'];
                    break;
                case 9: // Price
                    $sql .= ' ORDER BY proposals.price ' . $order[0]['dir'];
                    break;
                case 10: // Contact
                    $sql .= ' ORDER BY clients.firstName ' . $order[0]['dir'];
                    break;
                case 11: // Owner
                    $sql .= ' ORDER BY accounts.firstName ' . $order[0]['dir'];
                    break;
                case 12: // Last Activity
                    $sql .= ' ORDER BY proposals.last_activity ' . $order[0]['dir'] . ' , proposals.created DESC';
                    break;
                case 13: // Email Status
                    $sql .= ' ORDER BY proposals.email_status ' . $order[0]['dir'];
                    break;
                case 14: // Delivery Status
                    $sql .= ' ORDER BY proposals.deliveryTime ' . $order[0]['dir'];
                    break;
                case 15: // Open Status
                    $sql .= ' ORDER BY proposals.lastOpenTime ' . $order[0]['dir'];
                    break;
                case 16: // Audit View Time
                    $sql .= ' ORDER BY proposals.audit_view_time ' . $order[0]['dir'] . ', proposals.audit_key ' . $this->input->get('sSortDir_0');
                    break;
                case 17: // Estimate type View
                    $sql .= ' ORDER BY proposals.estimate_status_id ' . $order[0]['dir'];
                    break;
            }
        }

        if($map){
            
            $data = $this->db->query($sql)->result();
            $this->db->close();

            // Return the data
            return $data;
             
        }

        // Limit for paging if we're not counting
        if ($limit) {
            if ($limit !== 10000) {
                $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
            }
        }

        if (!is_int($page) && $numRecords) {
            $start = ($numRecords * $page);
            $sql .= ' LIMIT ' . $start . ', ' . $numRecords;
        }

         if(!$limit){
           // echo "sql2". $sql;die;
            return $this->db->query($sql)->result()[0]->numProposals;
         }else{
            $data = $this->db->query($sql)->result();
           // echo $this->db->last_query();die;

            $this->db->close();

            // Return the data
            // echo "sql1". $sql;die;

            return $data;
         }


    }

    public function getResendProposalsIds($resendId)
    {
        $out = [];
        $sql = "SELECT DISTINCT(pgre.proposal_id)
        FROM `proposal_group_resend_email` pgre ";
        $CI = &get_instance();
        $account = $CI->em->findAccount($this->getAccountId());
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE resend_id ={$resendId}";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE pgre.resend_id ={$resendId} AND a2.branch = " . $account->getBranch();
            //$sql .= " WHERE resend_id ={$resendId}";
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    proposals ON pgre.proposal_id = proposals.proposalId WHERE pgre.resend_id ={$resendId}
                    AND 
                    proposals.owner = " . $account->getAccountId();
        }
        $sql .= " AND pgre.is_failed = 0";
        $this->load->database();
        $results = $this->db->query($sql)->result();
        $this->db->close();
        // $total = $total[0];
        foreach ($results as $result) {
            $out[] = $result->proposal_id;
        }
        return $out;
    }

    public function getResendFailedProposalsIds($resendId)
    {
        $out = [];
        $sql = "SELECT DISTINCT(fj.entity_id)
        FROM `failed_jobs` fj ";
        $CI = &get_instance();
        $account = $CI->em->findAccount($this->getAccountId());
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE fj.campaign_id ={$resendId} AND job_type ='proposal_campaign'";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            proposals p1 ON fj.entity_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE fj.campaign_id ={$resendId} AND job_type ='proposal_campaign' AND a2.branch = " . $account->getBranch();
            //$sql .= " WHERE resend_id ={$resendId}";
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    proposals ON fj.entity_id = proposals.proposalId WHERE fj.campaign_id ={$resendId} AND job_type ='proposal_campaign'
                    AND 
                    proposals.owner = " . $account->getAccountId();
        }

        $this->load->database();
        $results = $this->db->query($sql)->result();
        $this->db->close();
        // $total = $total[0];
        foreach ($results as $result) {
            $out[] = $result->entity_id;
        }
        return $out;
    }


    public function getProposalsStatusData($action = '', $count = false)
    {
        $this->load->database();
        $firstProposal = $this->getCompany()->getFirstProposalTime();


        // Base query
        $sql = 'SELECT DISTINCT proposals.proposalId, proposals.projectName, proposals.projectAddress, proposals.projectCity, proposals.projectState, proposals.projectZip, proposals.price, proposals.jobNumber, proposals.created, proposals.status, proposals.duplicateOf, proposals.approvalQueue, proposals.declined, proposals.proposalStatus, proposals.last_activity, proposals.email_status, proposals.deliveryTime, proposals.lastOpenTime, proposals.emailSendTime, proposals.audit_key, proposals.audit_view_time, proposals.audit_reminder_sent, proposals.win_date, proposals.QBID, proposals.unapproved_services, proposals.lat, proposals.lng, proposals.access_key,proposals.estimate_status_id,proposals.job_cost_status,proposals.profit_margin_value,proposals.profit_margin_percent, proposals.image_count,proposals.is_hidden_to_view,proposals.business_type_id,proposals.approved,proposals.layout as proposal_layout,proposals.resend_excluded,proposals.note_count as ncount,proposals.signature_id,proposals.company_signature_id,proposals.proposal_view_count,proposals.owner,proposals.company_id,proposals.resend_enabled,
        accounts.firstName as accountFN, accounts.lastName as accountLN, accounts.branch, accounts.accountId as account,accounts.layout as owner_layout,
        client_companies.name as clientAccountName,
        clients.clientId, clients.title as clientTitle, clients.firstName as clientFN, clients.lastName as clientLN, clients.businessPhone as clientBP, clients.cellPhone as clientCP, clients.companyName as clientCompany, clients.quickbooksId as clientQuickbooksId, clients.email as clientEmail,
        statuses.text as statusText,statuses.sales as is_sales,statuses.color as statusColor';

        $sqlCounter = 'SELECT COUNT(DISTINCT proposals.proposalId) AS total';

        $joins = ' FROM proposals
            LEFT JOIN clients on proposals.client = clients.clientId
            LEFT JOIN client_companies on clients.client_account = client_companies.id
            LEFT JOIN companies on clients.company = companies.companyId
            LEFT JOIN accounts on proposals.owner = accounts.accountId
            LEFT JOIN statuses on proposals.proposalStatus = statuses.id';

        $sql .= $joins;
        $sqlCounter .= $joins;

        // Join required for services so add here //
        $serviceJoin = false;
        // Check for status filters first as these are temporary
        if ($action == 'status') {
            if ($this->session->userdata('pStatusFilter') && $this->session->userdata('pStatusFilterService')) {
                $serviceJoin = true;
            }
        }   // Standard proposals join
        else {
            if ($this->session->userdata('pFilter') && $this->session->userdata('pstsFilterService') && $action != 'search') {
                $serviceJoin = true;
            }
        }

        if ($serviceJoin) {
            $sql .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
            $sqlCounter .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
        }

        // Filter by user permissions
        if ($this->getUserClass() >= 2) {
            //company admin or full access, access to all proposals
            $sql .= ' WHERE proposals.company_id=' . $this->getCompany()->getCompanyId();
            $sqlCounter .= ' WHERE proposals.company_id=' . $this->getCompany()->getCompanyId();
        } else {
            if ($this->isBranchAdmin()) {
                //branch admin, can access only his branch
                $sql .= ' WHERE accounts.branch = ' . $this->getBranch() . '
                        AND proposals.company_id=' . $this->getCompany()->getCompanyId();
                $sqlCounter .= ' WHERE accounts.branch = ' . $this->getBranch() . '
                        AND proposals.company_id=' . $this->getCompany()->getCompanyId();
            } else {
                //regular user, can access only his proposals
                $sql .= ' WHERE proposals.owner=' . $this->getAccountId();
                $sqlCounter .= ' WHERE proposals.owner=' . $this->getAccountId();
            }
        }

        
        // Search
        if ($this->input->get('search')) {

            $search = $this->input->get('search');
            if ($search['value']) {
                $searchValue = $this->db->escape_like_str($search['value']);
                if ($searchValue  != '') {

                    $searchQuery = " AND ( (proposals.projectName like \"%" . $searchValue . "%\")
                    OR (clients.email like \"%" . $searchValue . "%\")
                    OR (client_companies.name like \"%" . $searchValue . "%\")
                    OR (clients.lastName like \"%" . $searchValue . "%\")
                    OR (clients.firstName like \"%" . $searchValue . "%\")
                    OR (proposals.projectAddress like \"%" . $searchValue . "%\")
                    OR (proposals.projectCity like \"%" . $searchValue . "%\")
                    OR (proposals.projectState like \"%" . $searchValue . "%\")
                    OR (proposals.projectZip like \"%" . $searchValue . "%\")
                    OR (proposals.jobNumber like \"%" . $searchValue . "%\"))";


                    $sql .= $searchQuery;
                    $sqlCounter .= $searchQuery;
                }
            }
        }

        ///FILTER
        if ($this->session->userdata('pStatusFilter')) {

            // Sold
            if ($this->session->userdata('pSold')) {

                // Status date change from
                if ($this->session->userdata('pStatusFilterChangeFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterChangeFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.win_date >= {$start})";
                    $sqlCounter .= " and (proposals.win_date >= {$start})";
                }
                // Status date change to
                if ($this->session->userdata('pStatusFilterChangeTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterChangeTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.win_date <= {$end})";
                    $sqlCounter .= " and (proposals.win_date <= {$end})";
                }

                $sql .= " and (proposals.win_date IS NOT NULL)";
                $sqlCounter .= " and (proposals.win_date IS NOT NULL)";
            }

            if ($this->session->userdata('pOpen')) {
                $sql .= " and proposals.proposalStatus = 1 ";
                $sqlCounter .= " and proposals.proposalStatus = 1 ";
                if ($this->session->userdata('pStatusFilterChangeFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterChangeFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.statusChangeDate >= {$start})";
                    $sqlCounter .= " and (proposals.statusChangeDate >= {$start})";
                }
                // Status date change to
                if ($this->session->userdata('pStatusFilterChangeTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterChangeTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.statusChangeDate <= {$end})";
                    $sqlCounter .= " and (proposals.statusChangeDate <= {$end})";
                }

                

                if ($this->session->userdata('pStatusFilterTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.created <= {$end})";
                    $sqlCounter .= " and (proposals.created <= {$end})";
                }
            }

            if ($this->session->userdata('pWon')) {
                $sql .= " AND statuses.sales = 1 ";
                $sqlCounter .= " AND statuses.sales = 1 ";


                if ($this->session->userdata('pStatusFilterFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.win_date >= {$start})";
                    $sqlCounter .= " and (proposals.win_date >= {$start})";
                }

                if ($this->session->userdata('pStatusFilterTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.win_date <= {$end})";
                    $sqlCounter .= " and (proposals.win_date <= {$end})";
                }
            }

            if ($this->session->userdata('pEmailOff')) {
                $sql .= " AND proposals.resend_excluded = 1 ";
                $sqlCounter .= " AND proposals.resend_excluded = 1 ";


                if ($this->session->userdata('pStatusFilterFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.created >= {$start})";
                    $sqlCounter .= " and (proposals.created >= {$start})";
                }

                if ($this->session->userdata('pStatusFilterTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.created <= {$end})";
                    $sqlCounter .= " and (proposals.created <= {$end})";
                }
            }

            if ($this->session->userdata('pOther')) {
                $sql .= " AND statuses.sales != 1 AND statuses.id != 1";
                $sqlCounter .= " AND statuses.sales != 1 AND statuses.id != 1";
                if ($this->session->userdata('pStatusFilterChangeFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterChangeFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.statusChangeDate >= {$start})";
                    $sqlCounter .= " and (proposals.statusChangeDate >= {$start})";
                }
                // Status date change to
                if ($this->session->userdata('pStatusFilterChangeTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterChangeTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.statusChangeDate <= {$end})";
                    $sqlCounter .= " and (proposals.statusChangeDate <= {$end})";
                }

               

                if ($this->session->userdata('pStatusFilterTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.created <= {$end})";
                    $sqlCounter .= " and (proposals.created <= {$end})";
                }
            }

            //else{


            if ($this->session->userdata('pStatusFilterStatus') && $this->session->userdata('pStatusFilterStatus') != 'All') {
                $sql .= " and (proposals.proposalStatus = '" . $this->session->userdata('pStatusFilterStatus') . "')";
                $sqlCounter .= " and (proposals.proposalStatus = '" . $this->session->userdata('pStatusFilterStatus') . "')";
            } else {
                $sql .= " AND statuses.prospect = 0";
                $sqlCounter .= " AND statuses.prospect = 0";
            }
            //}



            if ($this->session->userdata('pStatusFilterUser') && $this->session->userdata('pStatusFilterUser') != 'All') {
                $sql .= " and (proposals.owner = '" . $this->session->userdata('pStatusFilterUser') . "')";
                $sqlCounter .= " and (proposals.owner = '" . $this->session->userdata('pStatusFilterUser') . "')";
            }

            // Account
            // if ($this->session->userdata('pFilterClientAccount') && $this->session->userdata('pFilterClientAccount') != 'All') {
            //     $sql .= " AND (clients.client_account IN (" . implode(',', $this->session->userdata('pFilterClientAccount')) . "))";
            // }

            //if ($this->session->userdata('pStatusFilterCreate')) {
                if ($this->session->userdata('pStatusFilterFrom') && !$this->session->userdata('pWon')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.created >= {$start})";
                    $sqlCounter .= " and (proposals.created >= {$start})";
                }

                if ($this->session->userdata('pStatusFilterTo') && !$this->session->userdata('pWon')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.created <= {$end})";
                    $sqlCounter .= " and (proposals.created <= {$end})";
                }
           // }

            if ($this->session->userdata('pStatusFilterService')) {
                $sql .= ' and proposal_services.initial_service = ' . $this->session->userdata('pStatusFilterService');
                $sqlCounter .= ' and proposal_services.initial_service = ' . $this->session->userdata('pStatusFilterService');
            }

            /*
            if (!$this->session->userdata('pSold')) {
                // Status date change from
                if ($this->session->userdata('pStatusFilterChangeFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterChangeFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.statusChangeDate >= {$start})";
                    $sqlCounter .= " and (proposals.statusChangeDate >= {$start})";
                }
                // Status date change to
                if ($this->session->userdata('pStatusFilterChangeTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterChangeTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.statusChangeDate <= {$end})";
                    $sqlCounter .= " and (proposals.statusChangeDate <= {$end})";
                }
            }
            */


            if ($this->session->userdata('pStatusFilterService')) {
                $sql .= ' and proposal_services.initial_service = ' . $this->session->userdata('pStatusFilterService');
                $sqlCounter .= ' and proposal_services.initial_service = ' . $this->session->userdata('pStatusFilterService');
            }

            if ($this->session->userdata('pStatusFilterQueue')) {

                if ($this->session->userdata('pStatusFilterQueue') == 'duplicate') {
                    $sql .= ' and proposals.duplicateOf IS NOT NULL';
                    $sqlCounter .= ' and proposals.duplicateOf IS NOT NULL';
                } else {
                    if ($this->session->userdata('pStatusFilterQueue') == 1) {
                        $sql .= ' and proposals.approvalQueue = 1';
                        $sqlCounter .= ' and proposals.approvalQueue = 1';
                    } else {
                        $sql .= ' and proposals.declined = 1';
                        $sqlCounter .= ' and proposals.declined = 1';
                    }
                }
            }

            ///adding for new filter by sunil


            // Filters

            if ($this->session->userdata('pFilter') && $action != 'search') {

                // Proposal Status
                if ($this->session->userdata('psttFilterStatus')) {
                    //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                    $sql .= " and (proposals.proposalStatus IN (" . implode(
                        ', ',
                        $this->session->userdata('psttFilterStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.proposalStatus IN (" . implode(
                        ', ',
                        $this->session->userdata('psttFilterStatus')
                    ) . "))";
                } else {
                    $sql .= " AND statuses.prospect = 0";
                    $sqlCounter .= " AND statuses.prospect = 0";
                }

                // Estimate Status
                if ($this->session->userdata('pFilterEstimateStatus')) {
                    $sql .= " and (proposals.estimate_status_id IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterEstimateStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.estimate_status_id IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterEstimateStatus')
                    ) . "))";
                }

                // job Cost Status
                if ($this->session->userdata('pFilterJobCostStatus')) {
                    $sql .= " and (proposals.job_cost_status IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterJobCostStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.job_cost_status IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterJobCostStatus')
                    ) . "))";
                }
                // User
                if ($this->session->userdata('pstsFilterUser')) {
                    $sql .= " and (proposals.owner IN (" . implode(
                        ', ',
                        $this->session->userdata('pstsFilterUser')
                    ) . "))";
                    $sqlCounter .= " and (proposals.owner IN (" . implode(
                        ', ',
                        $this->session->userdata('pstsFilterUser')
                    ) . "))";
                } else {
                    if ($this->session->userdata('pstsFilterBranch')) {
                        $sql .= " and (accounts.branch IN (" . implode(
                            ', ',
                            $this->session->userdata('pstsFilterBranch')
                        ) . "))";
                        $sqlCounter .= " and (accounts.branch IN (" . implode(
                            ', ',
                            $this->session->userdata('pstsFilterBranch')
                        ) . "))";
                    }
                }
                // Account
                if ($this->session->userdata('pstsFilterClientAccount')) {
                    $sql .= " AND (clients.client_account IN (" . implode(
                        ',',
                        $this->session->userdata('pstsFilterClientAccount')
                    ) . "))";
                    $sqlCounter .= " AND (clients.client_account IN (" . implode(
                        ',',
                        $this->session->userdata('pstsFilterClientAccount')
                    ) . "))";
                }
                // Created Date from
                if ($this->session->userdata('pstsCreatedFrom')) {
                    $start = $this->session->userdata('pstsCreatedFrom');
                    $sql .= " AND (proposals.created >= {$start})";
                    $sqlCounter .= " AND (proposals.created >= {$start})";
                }
                // Created Date To
                if ($this->session->userdata('pstsCreatedTo')) {
                    $end = $this->session->userdata('pstsCreatedTo');
                    $sql .= " AND (proposals.created <= {$end})";
                    $sqlCounter .= " AND (proposals.created <= {$end})";
                }
                // Activity Date from
                if ($this->session->userdata('pstsActivityFrom')) {
                    $laStart = $this->session->userdata('pstsActivityFrom');
                    $sql .= " AND (proposals.last_activity >= {$laStart})";
                    $sqlCounter .= " AND (proposals.last_activity >= {$laStart})";
                }
                // Activity Date To
                if ($this->session->userdata('pstsActivityTo')) {
                    $laEnd = $this->session->userdata('pstsActivityTo');
                    $sql .= " AND (proposals.last_activity <= {$laEnd})";
                    $sqlCounter .= " AND (proposals.last_activity <= {$laEnd})";
                }

                // Won Date from
                if ($this->session->userdata('pstsWonFrom')) {
                    $wonStart = $this->session->userdata('pstsWonFrom');
                    $sql .= " AND (proposals.win_date >= {$wonStart})";
                    $sqlCounter .= " AND (proposals.win_date >= {$wonStart})";
                }
                // Won Date To
                if ($this->session->userdata('pstsWonTo')) {
                    $wonEnd = $this->session->userdata('pstsWonTo');
                    $sql .= " AND (proposals.win_date <= {$wonEnd})";
                    $sqlCounter .= " AND (proposals.win_date <= {$wonEnd})";
                }

                if ($this->session->userdata('pstsFilterService')) {
                    $sql .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('pstsFilterService')
                    ) . "))";
                    $sqlCounter .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('pstsFilterService')
                    ) . "))";
                }
                if ($this->session->userdata('pstsFilterQueue')) {

                    $addOr = false;
                    $sql .= ' AND (';
                    $sqlCounter .= ' AND (';

                    if (in_array('duplicate', $this->session->userdata('pstsFilterQueue'))) {
                        $addOr = true;
                        $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                        $sqlCounter .= ' (proposals.duplicateOf IS NOT NULL)';
                    }

                    if (in_array(1, $this->session->userdata('pstsFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.approvalQueue = 1)';
                        $sqlCounter .= ' (proposals.approvalQueue = 1)';
                        $addOr = true;
                    }

                    if (in_array(2, $this->session->userdata('pstsFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.declined = 1)';
                        $sqlCounter .= ' (proposals.declined = 1)';
                        $addOr = true;
                    }

                    if (in_array('unapproved', $this->session->userdata('pstsFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.unapproved_services = 1)';
                        $sqlCounter .= ' (proposals.unapproved_services = 1)';
                    }

                    $sql .= ')';
                    $sqlCounter .= ')';
                }
                if ($this->session->userdata('pstsFilterEmailStatus')) {

                    $addOr = false;
                    $sql .= ' AND (';
                    $sqlCounter .= ' AND (';

                    if (in_array('o', $this->session->userdata('pstsFilterEmailStatus'))) {
                        $addOr = true;
                        $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.lastOpenTime IS NOT NULL)';
                    }

                    if (in_array('d', $this->session->userdata('pstsFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.deliveryTime IS NOT NULL)';
                        $addOr = true;
                    }

                    if (in_array('u', $this->session->userdata('pstsFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                            AND proposals.deliveryTime IS NULL)';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                            AND proposals.deliveryTime IS NULL)';
                        $addOr = true;
                    }

                    if (in_array('uo', $this->session->userdata('pstsFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                            AND proposals.deliveryTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                            AND proposals.deliveryTime IS NOT NULL)';
                    }
                    if (in_array('us', $this->session->userdata('pstsFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                    }

                    $sql .= ')';
                    $sqlCounter .= ')';
                }


                if ($this->session->userdata('pstsFilterMinBid')) {
                    if ($this->session->userdata('pstsFilterMinBid') != 0) {
                        $sql .= ' AND (proposals.price >= ' . $this->session->userdata('pstsFilterMinBid');
                        $sqlCounter .= ' AND (proposals.price >= ' . $this->session->userdata('pstsFilterMinBid');
                        if (!$this->session->userdata('pstsFilterMaxBid')) {
                            $sql .= ' OR proposals.price IS NULL)';
                            $sqlCounter .= ' OR proposals.price IS NULL)';
                        } else {
                            $sql .= ')';
                            $sqlCounter .= ')';
                        }
                    }
                }

                if ($this->session->userdata('pstsFilterMaxBid')) {
                    if ($this->session->userdata('pstsFilterMaxBid') != $this->getCompany()->getHighestBid()) {
                        $sql .= ' AND (proposals.price <= ' . $this->session->userdata('pstsFilterMaxBid');
                        $sqlCounter .= ' AND (proposals.price <= ' . $this->session->userdata('pstsFilterMaxBid');
                        if (!$this->session->userdata('pstsFilterMinBid')) {
                            $sql .= ' OR proposals.price IS NULL)';
                            $sqlCounter .= ' OR proposals.price IS NULL)';
                        } else {
                            $sql .= ')';
                            $sqlCounter .= ')';
                        }
                    }
                }

                if ($this->session->userdata('pstsFilterBusinessType')) {
                    $types = implode(',', $this->session->userdata('pstsFilterBusinessType'));
                    $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                    $sqlCounter .= ' AND proposals.business_type_id IN (' . $types . ')';
                }

                if ($this->session->userdata('pstsResendExclude') == '1' && $this->session->userdata('pstsResendInclude') == '1' || $this->session->userdata('pstsResendExclude') == '0' && $this->session->userdata('pstsResendInclude') == '0') {
                } else {
                    if ($this->session->userdata('pstsResendExclude')=='1') {

                        $sql .= ' AND proposals.resend_excluded =1';
                        $sqlCounter .= ' AND proposals.resend_excluded =1';
                    }
                    if ($this->session->userdata('pstsResendInclude')=='1') {

                        $sql .= ' AND proposals.resend_excluded =0';
                        $sqlCounter .= ' AND proposals.resend_excluded =0';
                    }
                }

                if ($this->session->userdata('pstsUnsigned') == '1' && $this->session->userdata('pstsSigned') == '1' || $this->session->userdata('pstsUnsigned') == '0' && $this->session->userdata('pstsSigned') == '0') {
                } else {
                    if ($this->session->userdata('pstsSigned')=='1') {

                        $sql .= ' AND proposals.signature_id IS NOT NULL';
                        $sqlCounter .= ' AND proposals.signature_id IS NOT NULL';
                    }
                    if ($this->session->userdata('pstsUnsigned')=='1') {

                        $sql .= ' AND proposals.signature_id IS NULL';
                        $sqlCounter .= ' AND proposals.signature_id IS NULL';
                    }
                }

                if ($this->session->userdata('pstsCompanyUnsigned') == '1' && $this->session->userdata('pstsCompanySigned') == '1' || $this->session->userdata('pstsCompanyUnsigned') == '0' && $this->session->userdata('pstsCompanySigned') == '0') {
                } else {
                    if ($this->session->userdata('pstsCompanySigned')=='1') {

                        $sql .= ' AND proposals.company_signature_id IS NOT NULL';
                        $sqlCounter .= ' AND proposals.company_signature_id IS NOT NULL';
                    }
                    if ($this->session->userdata('pstsCompanyUnsigned')=='1') {

                        $sql .= ' AND proposals.company_signature_id IS NULL';
                        $sqlCounter .= ' AND proposals.company_signature_id IS NULL';
                    }
                }
            }


            if (($this->session->userdata('pStatusFilterBranch') && $this->session->userdata('pStatusFilterBranch') != 'All') || ($this->session->userdata('pStatusFilterBranch') === '0')) {

                $sql .= " and (accounts.branch = '" . $this->session->userdata('pStatusFilterBranch') . "')";
            }
            //// end filter added by sunil

        } else {
            if ($this->session->userdata('pFilter') && $action != 'search') {

                // Proposal Status
                if ($this->session->userdata('pstsFilterStatus') && $this->session->userdata('pstsFilterStatus') != 'All') {
                    $sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pstsFilterStatus') . "')";
                }
                // Branch
                if (($this->session->userdata('pstsFilterBranch') && $this->session->userdata('pstsFilterBranch') != 'All')
                    || ($this->session->userdata('pstsFilterBranch') == '0')
                ) {
                    $sql .= " AND (accounts.branch = '" . $this->session->userdata('pstsFilterBranch') . "')";
                }
                // User
                if ($this->session->userdata('pFilterUser') && $this->session->userdata('pFilterUser') != 'All') {
                    $sql .= " AND (clients.account = '" . $this->session->userdata('pFilterUser') . "')";
                }
                // Created Date from
                if ($this->session->userdata('pFilterFrom')) {
                    $from = explode('/', $this->session->userdata('pFilterFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " AND (proposals.created >= {$start})";
                }
                // Created Date To
                if ($this->session->userdata('pFilterTo')) {
                    $to = explode('/', $this->session->userdata('pFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " AND (proposals.created <= {$end})";
                }
                if ($this->session->userdata('pstsFilterService')) {
                    $sql .= ' AND proposal_services.initial_service = ' . $this->session->userdata('pstsFilterService');
                }
                if ($this->session->userdata('pstsFilterQueue')) {
                    if ($this->session->userdata('pstsFilterQueue') == 'duplicate') {
                        $sql .= ' AND proposals.duplicateOf IS NOT NULL';
                    } else {
                        if ($this->session->userdata('pstsFilterQueue') == 1) {
                            $sql .= ' AND proposals.approvalQueue = 1';
                        } else {
                            $sql .= ' AND proposals.declined = 1';
                        }
                    }
                }
                if ($this->session->userdata('pstsFilterEmailStatus')) {

                    switch ($this->session->userdata('pstsFilterEmailStatus')) {

                        case \models\Proposals::EMAIL_SENT:
                        case \models\Proposals::EMAIL_UNSENT:
                        case \models\Proposals::EMAIL_EDITED:
                            $sql .= ' AND proposals.email_status = ' . $this->session->userdata('pstsFilterEmailStatus');
                            break;

                        case 'o':
                            $sql .= ' AND proposals.lastOpenTime IS NOT NULL';
                            break;
                        case 'd':
                            $sql .= ' AND proposals.deliveryTime IS NOT NULL';
                            break;
                        case 'u':
                            $sql .= ' AND (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                                AND proposals.deliveryTime IS NULL)';
                            break;
                        case 'uo':
                            $sql .= ' AND (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                                AND proposals.deliveryTime IS NOT NULL
                                AND proposals.lastOpenTime IS NULL)';
                            break;
                    }
                }
            }
        }

        $sql .= ' AND proposals.deleted = 0 ';
        ///SORTING
        $order = $this->input->get('order');

        switch ($order[0]['column']) {
            case 2: // date
                $sql .= ' ORDER BY proposals.created ' . $order[0]['dir'];
                break;
            case 3: // status
                $sql .= ' ORDER BY statusText ' . $order[0]['dir'];
                break;
            case 4: // Win date
                $sql .= ' ORDER BY proposals.win_date ' . $order[0]['dir'];
                break;
            case 5: // job Number
                $sql .= ' ORDER BY lpad(proposals.jobNumber, 10, 0) ' . $order[0]['dir'];
                break;
            case 6: // Client Account Name
                $sql .= ' ORDER BY client_companies.name ' . $order[0]['dir'];
                break;
            case 7: // Project Name
                $sql .= ' ORDER BY proposals.projectName ' . $order[0]['dir'];
                break;
            case 8: // Image Count
                $sql .= ' ORDER BY proposals.image_count ' . $order[0]['dir'];
                break;
            case 9: // Price
                $sql .= ' ORDER BY proposals.price ' . $order[0]['dir'];
                break;
            case 10: // Contact
                $sql .= ' ORDER BY clients.firstName ' . $order[0]['dir'];
                break;
            case 11: // Owner
                $sql .= ' ORDER BY accounts.firstName ' . $order[0]['dir'];
                break;
            case 12: // Last Activity
                $sql .= ' ORDER BY proposals.last_activity ' . $order[0]['dir'] . ' , proposals.created DESC';
                break;
            case 13: // Email Status
                $sql .= ' ORDER BY proposals.email_status ' . $order[0]['dir'];
                break;
            case 14: // Delivery Status
                $sql .= ' ORDER BY proposals.deliveryTime ' . $order[0]['dir'];
                break;
            case 15: // Open Status
                $sql .= ' ORDER BY proposals.lastOpenTime ' . $order[0]['dir'];
                break;
            case 16: // Audit View Time
                $sql .= ' ORDER BY proposals.audit_view_time ' . $order[0]['dir'] . ', proposals.audit_key ' . $this->input->get('sSortDir_0');
                break;
            case 16: // Estimate type View
                $sql .= ' ORDER BY proposals.estimate_status_id ' . $order[0]['dir'];
                break;
        }

        // Limit for paging
        $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');

        if ($count) {
            //echo $sqlCounter;die;
            return $this->db->query($sqlCounter)->result();
        }
       
       // echo $sql;die;
        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    /**
     * @return integer
     */
    public function getProposalsDataTotal()
    {

        $this->load->database();
        updateOrphanBranches($this->getCompany()->getCompanyId());

        // Start the query, based on permissions
        if ($this->isAdministrator() || ($this->getFullAccess() == 'yes')) {
            //company admin or full access, access to all proposals
            $query = "SELECT COUNT(proposals.proposalId) AS total
                        FROM proposals
                        LEFT JOIN clients ON proposals.client = clients.clientId
                        WHERE clients.company = " . $this->getCompany()->getCompanyId();
        } elseif ($this->isBranchAdmin()) {
            // Branch Admin, can access only his branch
            $query = "SELECT COUNT(proposals.proposalId) AS total
                        FROM proposals
                        LEFT JOIN clients ON proposals.client = clients.clientId
                        LEFT JOIN accounts ON clients.account = accounts.accountId
                        WHERE accounts.branch = " . $this->getBranch() . "
                        AND clients.company = " . $this->getCompany()->getCompanyId();
        } else {
            //regular user, can access only his proposals
            $query = "SELECT COUNT(proposals.proposalId) AS total
                        FROM proposals
                        LEFT JOIN clients ON proposals.client = clients.clientId
                        WHERE clients.account = " . $this->getAccountId();
        }

        $total = $this->db->query($query)->result();
        $total = $total[0];

        return $total->total;
    }

    public function getEstimatesDataTotal()
    {

        $this->load->database();
        updateOrphanBranches($this->getCompany()->getCompanyId());

        // Start the query, based on permissions
        if ($this->isAdministrator() || ($this->getFullAccess() == 'yes')) {
            //company admin or full access, access to all proposals
            $query = "SELECT COUNT(proposals.proposalId) AS total
                        FROM proposal_estimates
                        LEFT JOIN proposals ON proposal_estimates.proposal_id = proposals.proposalId
                        LEFT JOIN clients ON proposals.client = clients.clientId
                        WHERE clients.company = " . $this->getCompany()->getCompanyId();
        } elseif ($this->isBranchAdmin()) {
            // Branch Admin, can access only his branch
            $query = "SELECT COUNT(proposals.proposalId) AS total
                        FROM proposal_estimates
                        LEFT JOIN proposals ON proposal_estimates.proposal_id = proposals.proposalId
                        LEFT JOIN clients ON proposals.client = clients.clientId
                        LEFT JOIN accounts ON clients.account = accounts.accountId
                        WHERE accounts.branch = " . $this->getBranch() . "
                        AND clients.company = " . $this->getCompany()->getCompanyId();
        } else {
            //regular user, can access only his proposals
            $query = "SELECT COUNT(proposals.proposalId) AS total
                        FROM proposal_estimates
                        LEFT JOIN proposals ON proposal_estimates.proposal_id = proposals.proposalId
                        LEFT JOIN clients ON proposals.client = clients.clientId
                        WHERE clients.account = " . $this->getAccountId();
        }

        $total = $this->db->query($query)->result();
        $total = $total[0];

        return $total->total;
    }

    public function getAllProposalsData()
    {
        $this->load->database();

        // Base query
        $sql = 'SELECT proposals.proposalId, proposals.projectName, proposals.projectZip, proposals.lat, proposals.lng 
        FROM proposals
        LEFT JOIN clients on proposals.client = clients.clientId
        WHERE clients.company = ' . $this->getCompany()->getCompanyId();
        //echo $sql;

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    public function getClientsTableData($action = '', $type = '', $resend_id = '')
    {
        updateOrphanBranches($this->getCompany()->getCompanyId());

        $this->load->database();

        if ($action == 'resend') {

            // FIrst we have to check for a filter so we can add the join
            //if ($type) {
                        $sql = "SELECT c.clientId, c.firstName, c.lastName, c.businessPhone, c.businessPhoneExt, c.cellPhone, c.fax, c.account,c.resend_excluded,
                                c.address, c.city, c.state, c.last_activity, CONCAT(c.firstName, ' ', c.lastName) as fullName, c.email,c.company as company_id,
                                CONCAT(a.firstName, ' ', a.lastName) AS ownerFullName,c.proposals_count,c.bid_total,
                                cc.name as clientCompanyName,cgre.opened_at,GROUP_CONCAT(bt.type_name) as types,
                                COUNT(notes.noteId) as ncount
                            FROM clients c
                              LEFT JOIN client_companies cc ON c.client_account = cc.id
                              LEFT JOIN accounts a ON c.account = a.accountId
                              LEFT JOIN notes  ON c.clientId = notes.relationId AND   type = 'client' 
                              LEFT JOIN client_group_resend_email cgre ON c.clientId = cgre.client_id 
                             AND cgre.resend_id = " . $this->session->userdata('pClientResendFilterId');
                        
            // }
            $sql .= " LEFT JOIN business_type_assignments bta ON c.clientId = bta.client_id
            LEFT JOIN business_types bt ON bt.id = bta.business_type_id";

            if ($type == 'failed') {
                $client_ids = $this->getResendFailedClientsIds($this->session->userdata('pClientResendFilterId'));
                if ($client_ids) {
                    $client_ids = implode(',', $client_ids);
                    $sql .= " WHERE c.clientId IN(" . $client_ids . ")";
                } else {
                    return [];
                }
            } else {
                // Now we have to check it's in the resend
                $client_ids = $this->getResendClientsIds($this->session->userdata('pClientResendFilterId'));

                if ($client_ids) {
                    $client_ids = implode(',', $client_ids);
                    $sql .= " WHERE c.clientId IN(" . $client_ids . ")";
                } else {
                    return [];
                }
            }

            // Now add the WHERE condition
            switch ($type) {

                case 'delivered':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.delivered_at IS NOT NULL";
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.bounced_at IS NOT NULL";
                    break;

                case 'opened':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.opened_at IS NOT NULL";
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.opened_at IS NULL";
                    break;
                case 'clicked':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.clicked_at IS NOT NULL";
                    break;
            }

            $order_by_last_column = 'cgre.opened_at';
        } else {
            $sql = "SELECT c.clientId, c.firstName, c.lastName, c.businessPhone, c.businessPhoneExt, c.cellPhone, c.fax, c.account,c.resend_excluded,
                    c.address, c.city, c.state, c.last_activity, CONCAT(c.firstName, ' ', c.lastName) as fullName, c.email,c.company as company_id,
                    CONCAT(a.firstName, ' ', a.lastName) AS ownerFullName,c.proposals_count,c.bid_total,
                    cc.name as clientCompanyName, GROUP_CONCAT(bt.type_name) as types,
                    COUNT(notes.noteId) as ncount
                FROM clients c
                  LEFT JOIN client_companies cc ON c.client_account = cc.id
                  LEFT JOIN notes  ON c.clientId = notes.relationId AND   type = 'client' 
                  LEFT JOIN accounts a ON c.account = a.accountId";


            // Business type filter
            // if ($this->session->userdata('cFilterBusinessType')) {
            //     $sql .= " LEFT JOIN business_type_assignments bta ON c.clientId = bta.client_id";
            // }
            $sql .= " LEFT JOIN business_type_assignments bta ON c.clientId = bta.client_id
                      LEFT JOIN business_types bt ON bt.id = bta.business_type_id";

            $sql .= " WHERE c.company = " . $this->getCompany()->getCompanyId();
            $order_by_last_column = 'c.last_activity';

            if($this->session->userdata('ClientSearchFilter')){
                $sql .= " AND c.clientId = ".$this->session->userdata('ClientSearchFilter');
            }
        }


        // Search
        $search = $this->input->get('search');
        if ($search['value']) {
            $searchValue = $this->db->escape_like_str($search['value']);
            $sql .= (" AND ((c.email LIKE \"%" . $searchValue . "%\")
                            OR (cc.name LIKE \"%" . $searchValue . "%\")
                            OR (c.businessPhone LIKE \"%" . $searchValue . "%\")
                            OR (c.cellPhone LIKE \"%" . $searchValue . "%\")
                            OR (c.lastName LIKE \"%" . $searchValue . "%\")
                            OR (c.firstName LIKE \"%" . $searchValue . "%\")
                            OR (CONCAT(c.firstName, ' ', c.lastName) LIKE \"%" . $searchValue . "%\"))");
        }


        // Filters
        if ($action != 'resend') {
            if ($this->session->userdata('cFilter')) {

                // User filter
                if ($this->session->userdata('cFilterUser')) {
                    $sql .= " AND (c.account IN (" .
                        implode(',', $this->session->userdata('cFilterUser')) . "))";
                }

                // Account filter
                if ($this->session->userdata('cFilterClientAccount')) {
                    $sql .= " AND (cc.id IN (" .
                        implode(',', $this->session->userdata('cFilterClientAccount')) . "))";
                }

                // Business type filter
                if ($this->session->userdata('cFilterBusinessType')) {
                    $sql .= " AND (bta.business_type_id IN (" .
                        implode(',', $this->session->userdata('cFilterBusinessType')) . "))";
                }
                //Campaign filter
                if ($this->session->userdata('cResendExclude') == '1' && $this->session->userdata('cResendInclude') == '1' || $this->session->userdata('cResendExclude') == '0' && $this->session->userdata('cResendInclude') == '0') {
                } else {
                    if ($this->session->userdata('cResendExclude')) {

                        $sql .= ' AND c.resend_excluded =1';
                    }
                    if ($this->session->userdata('cResendInclude')) {

                        $sql .= ' AND c.resend_excluded =0';
                    }
                }
            }
        } else {
            if ($this->session->userdata('crFilter_' . $resend_id)) {

                // User filter
                if ($this->session->userdata('crFilterUser_' . $resend_id)) {
                    $sql .= " AND (c.account IN (" .
                        implode(',', $this->session->userdata('crFilterUser_' . $resend_id)) . "))";
                }

                // Account filter
                if ($this->session->userdata('crFilterClientAccount_' . $resend_id)) {
                    $sql .= " AND (cc.id IN (" .
                        implode(',', $this->session->userdata('crFilterClientAccount_' . $resend_id)) . "))";
                }

                 // Business type filter
                 if ($this->session->userdata('crFilterBusinessType_' . $resend_id)) {
                    $sql .= " AND (bta.business_type_id IN (" .
                        implode(',', $this->session->userdata('crFilterBusinessType_' . $resend_id)) . "))";
                }
                //Campaign filter
                if ($this->session->userdata('crResendExclude_' . $resend_id) == '1' && $this->session->userdata('crResendInclude_' . $resend_id) == '1' || $this->session->userdata('crResendExclude_' . $resend_id) == '0' && $this->session->userdata('crResendInclude_' . $resend_id) == '0') {
                } else {
                    if ($this->session->userdata('crResendExclude_' . $resend_id)) {

                        $sql .= ' AND c.resend_excluded =1';
                    }
                    if ($this->session->userdata('crResendInclude_' . $resend_id)) {

                        $sql .= ' AND c.resend_excluded =0';
                    }
                }
            }
        }


        // Sorting
        $order = $this->input->get('order');
        if ($order) {
            $sortDir = $order[0]['dir'];

            switch ($order[0]['column']) {
                case 2:
                    $sortCol = 'cc.name';
                    break;
                case 3:
                    $sortCol = 'c.firstName';
                    break;
                case 4:
                    $sortCol = 'c.lastName';
                    break;
                case 5:
                    $sortCol = 'c.email';
                    break;
                case 6:
                    $sortCol = 'c.cellPhone';
                    break;
                case 7:
                    $sortCol = 'c.proposals_count';
                    break;
                case 8:
                    $sortCol = 'c.bid_total';
                    break;
                case 9:
                    $sortCol = 'c.account';
                    break;
                case 10:
                    $sortCol = $order_by_last_column;
                    break;
                
            }
        } else {
            $sortDir = 'asc';
            $sortCol = 'cc.name';
        }
        $sql .= ' GROUP BY bta.client_id,c.clientId ';
        $sql .= " ORDER BY " . $sortCol . ' ' . $sortDir;

        $sql .= ' LIMIT ' . $this->input->get('length');
        $sql .= ' OFFSET ' . $this->input->get('start');

        $clientData = $this->db->query($sql)->result();
        //echo $sql;die;
        $this->db->close();
        $out = [];

        foreach ($clientData as $data) {
            $out[] = $data;
        }
        return $out;
    }

    public function getResendCompaniesIds($resendId)
    {

        $out = [];
        $sql = "SELECT DISTINCT(cgre.user_id)
        FROM `admin_group_resend_email` cgre
        WHERE resend_id ={$resendId}";
        $this->load->database();
        $results = $this->db->query($sql)->result();
        $this->db->close();
        foreach ($results as $result) {
            $out[] = $result->user_id;
        }
        return $out;
    }

    public function getResendFailedClientsIds($resendId)
    {

        $out = [];
        $sql = "SELECT DISTINCT(cgre.client_id)
        FROM `client_group_resend_email` cgre";
        $CI = &get_instance();
        $account = $CI->em->findAccount($this->getAccountId());
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE resend_id ={$resendId} AND cgre.is_failed = 1";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            clients c1 ON cgre.client_id = c1.clientId
            LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE cgre.resend_id ={$resendId} AND cgre.is_failed = 1 AND a2.branch = " . $account->getBranch();
            //$sql .= " WHERE resend_id ={$resendId}";
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                clients ON cgre.client_id = clients.clientId 
                LEFT JOIN
                client_group_resends AS cgr ON cgre.resend_id = cgr.id WHERE cgre.resend_id ={$resendId} AND (cgr.account_id =" . $account->getAccountId() . " OR
                clients.account = " . $account->getAccountId() . " ) AND cgre.is_failed = 1";
        }

        // WHERE resend_id ={$resendId}";
        $this->load->database();
        $results = $this->db->query($sql)->result();
        $this->db->close();
        foreach ($results as $result) {
            $out[] = $result->client_id;
        }
        return $out;
    }

    public function getResendClientsIds($resendId)
    {

        $out = [];
        $sql = "SELECT DISTINCT(cgre.client_id)
        FROM `client_group_resend_email` cgre";
        $CI = &get_instance();
        $account = $CI->em->findAccount($this->getAccountId());
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE resend_id ={$resendId} AND cgre.is_failed = 0";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            clients c1 ON cgre.client_id = c1.clientId
            LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE cgre.resend_id ={$resendId} AND cgre.is_failed = 0 AND a2.branch = " . $account->getBranch();
            //$sql .= " WHERE resend_id ={$resendId}";
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            // $sql .= " LEFT JOIN
            //     clients ON cgre.client_id = clients.clientId WHERE cgre.resend_id ={$resendId}
            //     AND cgre.is_failed = 0 AND 
            //         clients.account = " . $account->getAccountId();

            $sql .= " LEFT JOIN
            clients ON cgre.client_id = clients.clientId 
            LEFT JOIN
            client_group_resends AS cgr ON cgre.resend_id = cgr.id WHERE cgre.resend_id ={$resendId} AND (cgr.account_id =" . $account->getAccountId() . " OR
                clients.account = " . $account->getAccountId() . " ) AND cgre.is_failed = 0";
        }

        // WHERE resend_id ={$resendId}";
        $this->load->database();
        $results = $this->db->query($sql)->result();
        $this->db->close();
        foreach ($results as $result) {
            $out[] = $result->client_id;
        }
        return $out;
    }


    function getClientsTableDataTotal($all = false, $action = '', $type = '', $resend_id = '')
    {
        $this->load->database();

        $sql = "SELECT c.clientId
            FROM clients c LEFT JOIN client_companies cc ON c.client_account = cc.id";
        $groupByBT = '';
        if ($this->session->userdata('cFilterBusinessType') || $this->session->userdata('crFilterBusinessType_' . $resend_id)) {
            $sql .= " LEFT JOIN business_type_assignments bta ON c.clientId = bta.client_id
            LEFT JOIN business_types bt ON bt.id = bta.business_type_id";
        }
        if ($action == 'resend' && $all == false) {

            // FIrst we have to check for a filter so we can add the join
            if ($type) {

                // Join on the PGRE where delivered
                $sql .= " LEFT JOIN client_group_resend_email cgre ON c.clientId = cgre.client_id 
                          AND cgre.resend_id = " . $this->session->userdata('pClientResendFilterId');
            }

            if ($type == 'failed') {
                $client_ids = $this->getResendFailedClientsIds($this->session->userdata('pClientResendFilterId'));
                if ($client_ids) {
                    $client_ids = implode(',', $client_ids);
                    $sql .= " WHERE c.clientId IN(" . $client_ids . ")";
                } else {
                    return [];
                }
            } else {
                // Now we have to check it's in the resend
                $client_ids = $this->getResendClientsIds($this->session->userdata('pClientResendFilterId'));

                if ($client_ids) {
                    $client_ids = implode(',', $client_ids);
                    $sql .= " WHERE c.clientId IN(" . $client_ids . ")";
                } else {
                    return [];
                }
            }
            //echo $sql;die;
            // Now add the WHERE condition
            switch ($type) {

                case 'delivered':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.delivered_at IS NOT NULL";
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.bounced_at IS NOT NULL";
                    break;

                case 'opened':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.opened_at IS NOT NULL";
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered
                    $sql .= " AND cgre.opened_at IS NULL";
                    break;
            }
        } else {
            $sql .= ", accounts a  WHERE c.client_account = cc.id
            AND c.account = a.accountId
            AND c.company = " . $this->getCompany()->getCompanyId();

            if($this->session->userdata('ClientSearchFilter')){
                $sql .= " AND c.clientId = ".$this->session->userdata('ClientSearchFilter');
            }
        }

        //echo $sql;die;

        if (!$all) {
            // Search
            $search = $this->input->get('search');
            if ($search['value']) {

                $searchValue = $this->db->escape_like_str($search['value']);
                $sql .= (" AND ((c.email LIKE \"%" . $searchValue . "%\")
                            OR (cc.name LIKE \"%" . $searchValue . "%\")
                            OR (cc.name LIKE \"%" . $searchValue . "%\")
                            OR (c.businessPhone LIKE \"%" . $searchValue . "%\")
                            OR (c.cellPhone LIKE \"%" . $searchValue . "%\")
                            OR (c.lastName LIKE \"%" . $searchValue . "%\")
                            OR (c.firstName LIKE \"%" . $searchValue . "%\")
                            OR (CONCAT(c.firstName, ' ', c.lastName) LIKE \"%" . $searchValue . "%\"))");
            }

            // Filters
            if ($action != 'resend') {
                if ($this->session->userdata('cFilter')) {

                    // User filter
                    if ($this->session->userdata('cFilterUser')) {
                        $sql .= " AND (c.account IN (" .
                            implode(',', $this->session->userdata('cFilterUser')) . "))";
                    }

                    // Account filter
                    if ($this->session->userdata('cFilterClientAccount')) {
                        $sql .= " AND (cc.id IN (" .
                            implode(',', $this->session->userdata('cFilterClientAccount')) . "))";
                    }

                    // Business type filter
                    if ($this->session->userdata('cFilterBusinessType')) {

                        $groupByBT = ' bta.client_id,';
                        $sql .= " AND (bta.business_type_id IN (" .
                            implode(',', $this->session->userdata('cFilterBusinessType')) . "))";
                    }

                    //Campaign filter
                    if ($this->session->userdata('cResendExclude') == '1' && $this->session->userdata('cResendInclude') == '1' || $this->session->userdata('cResendExclude') == '0' && $this->session->userdata('cResendInclude') == '0') {
                    } else {
                        if ($this->session->userdata('cResendExclude')) {

                            $sql .= ' AND c.resend_excluded =1';
                        }
                        if ($this->session->userdata('cResendInclude')) {

                            $sql .= ' AND c.resend_excluded =0';
                        }
                    }
                }
            } else {
                if ($this->session->userdata('crFilter_' . $resend_id)) {

                    // User filter
                    if ($this->session->userdata('crFilterUser_' . $resend_id)) {
                        $sql .= " AND (c.account IN (" .
                            implode(',', $this->session->userdata('crFilterUser_' . $resend_id)) . "))";
                    }

                    // Account filter
                    if ($this->session->userdata('crFilterClientAccount_' . $resend_id)) {
                        $sql .= " AND (cc.id IN (" .
                            implode(',', $this->session->userdata('crFilterClientAccount_' . $resend_id)) . "))";
                    }
                    // Business type filter
                    if ($this->session->userdata('crFilterBusinessType_' . $resend_id)) {

                        $groupByBT = ' bta.client_id,';
                        $sql .= " AND (bta.business_type_id IN (" .
                            implode(',', $this->session->userdata('crFilterBusinessType_' . $resend_id)) . "))";
                    }
                    
                    // Business type filter
                 if ($this->session->userdata('crFilterBusinessType_' . $resend_id)) {
                    $sql .= " AND (bta.business_type_id IN (" .
                        implode(',', $this->session->userdata('crFilterBusinessType_' . $resend_id)) . "))";
                }
                //Campaign filter
                if ($this->session->userdata('crResendExclude_' . $resend_id) == '1' && $this->session->userdata('crResendInclude_' . $resend_id) == '1' || $this->session->userdata('crResendExclude_' . $resend_id) == '0' && $this->session->userdata('crResendInclude_' . $resend_id) == '0') {
                } else {
                    if ($this->session->userdata('crResendExclude_' . $resend_id)) {

                        $sql .= ' AND c.resend_excluded =1';
                    }
                    if ($this->session->userdata('crResendInclude_' . $resend_id)) {

                        $sql .= ' AND c.resend_excluded =0';
                    }
                }
                }
            }
        }

        if (!$all) {
            $sql .= ' GROUP BY ' . $groupByBT . ' c.clientId ';
            //echo $sql;die;
        } else {
            $sql .= ' GROUP BY c.clientId ';
        }
        //echo $sql;die;
        $clientIds = $this->db->query($sql)->result();
        $this->db->close();
        return count($clientIds);
    }

    public function getLeadsTableData()
    {

        $this->load->database();

        // Base query - leads and join with owner account and restrict to own company
        $sql = 'SELECT l.leadId
        FROM leads l
        LEFT JOIN accounts a on l.account = a.accountId
        WHERE l.company = ' . $this->getCompanyId();

        // User permissions
        if (!$this->hasFullAccess()) {
            if ($this->isBranchAdmin()) {
                //branch admin, can access only his branch
                $sql .= ' WHERE a.branch = ' . $this->getBranch();
            } else {
                //regular user, can access only his proposals
                $sql .= ' WHERE l.account = ' . $this->getAccountId();
            }
        }

        // Filters

        // Sorting
        $sortDir = $this->input->get('sSortDir_0');

        switch ($this->input->get('iSortCol_0')) {
            case 1:
                $sortCol = 'l.created';
                break;
            case 2:
                $sortCol = 'l.source';
                break;
            case 3:
                $sortCol = 'l.status';
                break;
            case 4:
                $sortCol = 'l.rating';
                break;
            case 5:
                $sortCol = 'l.dueDate';
                break;
            case 6:
                $sortCol = 'l.company';
                break;
            case 7:
                $sortCol = 'l.zip';
                break;
            case 8:
                $sortCol = 'l.projectName';
                break;
            case 9:
                $sortCol = 'l.firstName';
                break;
            case 10:
                $sortCol = 'a.firstName';
                break;
            case 11:
                $sortCol = 'l.last_activity';
                break;
        }

        $sql .= " ORDER BY " . $sortCol . ' ' . $sortDir;
        $sql .= ' LIMIT ' . $this->input->get('iDisplayLength');
        $sql .= ' OFFSET ' . $this->input->get('iDisplayStart');

        $leadIds = $this->db->query($sql)->result();
        $this->db->close();

        $out = [];

        foreach ($leadIds as $data) {
            $lead = $this->doctrine->em->findLead($data->leadId);
            if ($lead) {
                $out[] = $lead;
            }
        }
        return $out;

        /*

        // Search
        if ($this->input->get('sSearch')) {
            $sql .= " AND ( (proposals.projectName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.email like \"%" . $this->input->get('sSearch') . "%\")
                    OR (client_companies.name like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.lastName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.firstName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (CONCAT(clients.firstName, ' ', clients.lastName) like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.projectAddress like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.projectCity like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.projectState like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.projectZip like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.businessPhone like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.cellPhone like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.jobNumber like \"%" . $this->input->get('sSearch') . "%\"))";
        }

        // Client
        if ($client) {
            $sql .= " AND clients.clientId = " . $client;
        }

        // Filters
        if (($action == 'status') && $this->session->userdata('pStatusFilter')) {
            if ($this->session->userdata('pStatusFilterStatus') && $this->session->userdata('pStatusFilterStatus') != 'All') {
                $sql .= " and (proposals.proposalStatus = '" . $this->session->userdata('pStatusFilterStatus') . "')";
            }

            if (($this->session->userdata('pStatusFilterBranch') && $this->session->userdata('pStatusFilterBranch') != 'All') || ($this->session->userdata('pStatusFilterBranch') === '0')) {

                $sql .= " and (accounts.branch = '" . $this->session->userdata('pStatusFilterBranch') . "')";
            }

            if ($this->session->userdata('pStatusFilterUser') && $this->session->userdata('pStatusFilterUser') != 'All') {
                $sql .= " and (clients.account = '" . $this->session->userdata('pStatusFilterUser') . "')";
            }

            if ($this->session->userdata('rollover')) {

                $start = $firstProposal;
                $end = mktime(0, 0, 0, 1, 1, date('Y'));

                $sql .= " and (proposals.created >= {$start})";

                $sql .= " and (proposals.created <= {$end})";
            } else {
                if ($this->session->userdata('pStatusFilterFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.created >= {$start})";
                }

                if ($this->session->userdata('pStatusFilterTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.created <= {$end})";
                }
            }

            if ($this->session->userdata('pStatusFilterService')) {
                $sql .= ' and proposal_services.initial_service = ' . $this->session->userdata('pStatusFilterService');
            }

            // Status date change from
            if ($this->session->userdata('pStatusFilterChangeFrom')) {
                $from = explode('/', $this->session->userdata('pStatusFilterChangeFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $sql .= " and (proposals.statusChangeDate >= {$start})";
            }
            // Status date change to
            if ($this->session->userdata('pStatusFilterChangeTo')) {
                $to = explode('/', $this->session->userdata('pStatusFilterChangeTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                $sql .= " and (proposals.statusChangeDate <= {$end})";
            }

            if ($this->session->userdata('pStatusFilterService')) {
                $sql .= " and (proposal_services.initial_service IN (" . implode(', ', $this->session->userdata('pStatusFilterService')) . "))";
            }

            if ($this->session->userdata('pStatusFilterQueue')) {

                if ($this->session->userdata('pStatusFilterQueue') == 'duplicate') {
                    $sql .= ' and proposals.duplicateOf IS NOT NULL';
                } else {
                    if ($this->session->userdata('pStatusFilterQueue') == 1) {
                        $sql .= ' and proposals.approvalQueue = 1';
                    } else {
                        $sql .= ' and proposals.declined = 1';
                    }
                }
            }
        } else if ($this->session->userdata('pFilter') && $action != 'search') {

            // Proposal Status
            if ($this->session->userdata('pFilterStatus')) {
                //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                $sql .= " and (proposals.proposalStatus IN (" . implode(', ', $this->session->userdata('pFilterStatus')) . "))";
            }
            // User
            if ($this->session->userdata('pFilterUser')) {
                $sql .= " and (proposals.owner IN (" . implode(', ', $this->session->userdata('pFilterUser')) . "))";
            }
            else if($this->session->userdata('pFilterBranch')){
                $sql .= " and (accounts.branch IN (" . implode(', ', $this->session->userdata('pFilterBranch')) . "))";
            }
            // Account
            if ($this->session->userdata('pFilterClientAccount')) {
                $sql .= " AND (clients.client_account IN (" . implode(',', $this->session->userdata('pFilterClientAccount')) . "))";
            }
            // Created Date from
            if ($this->session->userdata('pCreatedFrom')) {
                $start = $this->session->userdata('pCreatedFrom');
                $sql .= " AND (proposals.created >= {$start})";
            }
            // Created Date To
            if ($this->session->userdata('pCreatedTo')) {
                $end = $this->session->userdata('pCreatedTo');
                $sql .= " AND (proposals.created <= {$end})";
            }
            // Activity Date from
            if ($this->session->userdata('pActivityFrom')) {
                $laStart = $this->session->userdata('pActivityFrom');
                $sql .= " AND (proposals.last_activity >= {$laStart})";
            }
            // Activity Date To
            if ($this->session->userdata('pActivityTo')) {
                $laEnd = $this->session->userdata('pActivityTo');
                $sql .= " AND (proposals.last_activity <= {$laEnd})";
            }
            if ($this->session->userdata('pFilterService')) {
                $sql .= " and (proposal_services.initial_service IN (" . implode(', ', $this->session->userdata('pFilterService')) . "))";
            }
            if ($this->session->userdata('pFilterQueue')) {

                $addOr = false;
                $sql .= ' AND (';

                if (in_array('duplicate', $this->session->userdata('pFilterQueue'))) {
                    $addOr = true;
                    $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                }

                if (in_array(1, $this->session->userdata('pFilterQueue'))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.approvalQueue = 1)';
                    $addOr = true;
                }

                if (in_array(2, $this->session->userdata('pFilterQueue'))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.declined = 1)';
                }

                $sql .= ')';
            }
            if ($this->session->userdata('pFilterEmailStatus')) {

                $addOr = false;
                $sql .= ' AND (';

                if (in_array('o', $this->session->userdata('pFilterEmailStatus'))) {
                    $addOr = true;
                    $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                }

                if (in_array('d', $this->session->userdata('pFilterEmailStatus'))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                    $addOr = true;
                }

                if (in_array('u', $this->session->userdata('pFilterEmailStatus'))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                                AND proposals.deliveryTime IS NULL)';
                    $addOr = true;
                }

                if (in_array('uo', $this->session->userdata('pFilterEmailStatus'))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                                AND proposals.deliveryTime IS NOT NULL)';
                }
                if (in_array('us', $this->session->userdata('pFilterEmailStatus'))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                }

                $sql .= ')';
            }
            if ($this->session->userdata('pFilterMinBid')) {
                $sql .= ' AND (proposals.price >= ' . $this->session->userdata('pFilterMinBid');
                if (!$this->session->userdata('pFilterMaxBid')) {
                    $sql .= ' OR proposals.price IS NULL)';
                }
                else {
                    $sql .= ')';
                }
            }
            else {
                $sql .= ' AND (proposals.price <= ' . $this->session->userdata('pFilterMaxBid');
                if (!$this->session->userdata('pFilterMinBid')) {
                    $sql .= ' OR proposals.price IS NULL)';
                }
                else {
                    $sql .= ')';
                }
            }
        }

        // Searching on services can give duplicate results - this stops that
        $sql.= ' GROUP BY proposals.proposalId';

        ///SORTING
        switch ($this->input->get('iSortCol_0')) {
            case 2: // date
                $sql .= ' ORDER BY proposals.created ' . $this->input->get('sSortDir_0');
                break;
            case 3: // branch
                $sql .= ' ORDER BY accounts.branch ' . $this->input->get('sSortDir_0');
                break;
            case 4: // status
                $sql .= ' ORDER BY statusText ' . $this->input->get('sSortDir_0');
                break;
            case 6: // job Number
                $sql .= ' ORDER BY proposals.jobNumber ' . $this->input->get('sSortDir_0');
                break;
            case 7: // Company
                $sql .= ' ORDER BY clients.companyName ' . $this->input->get('sSortDir_0');
                break;
            case 8: // Project Name
                $sql .= ' ORDER BY proposals.projectName ' . $this->input->get('sSortDir_0');
                break;
            case 10: // Price
                $sql .= ' ORDER BY proposals.price ' . $this->input->get('sSortDir_0');
                break;
            case 11: // Contact
                $sql .= ' ORDER BY clients.firstName ' . $this->input->get('sSortDir_0');
                break;
            case 12: // Owner
                $sql .= ' ORDER BY accounts.firstName ' . $this->input->get('sSortDir_0');
                break;
            case 13: // Last Activity
                $sql .= ' ORDER BY proposals.last_activity ' . $this->input->get('sSortDir_0') . ' , proposals.created DESC';
                break;
            case 17: // Email Status
                $sql .= ' ORDER BY proposals.email_status ' . $this->input->get('sSortDir_0');
                break;
            case 19:// Delivery Status
                $sql .= ' ORDER BY proposals.deliveryTime ' . $this->input->get('sSortDir_0');
                break;
            case 21: // Open Status
                $sql .= ' ORDER BY proposals.lastOpenTime ' . $this->input->get('sSortDir_0');
                break;
            case 23: // Audit View Time
                $sql .= ' ORDER BY proposals.audit_view_time ' . $this->input->get('sSortDir_0') . ', proposals.audit_key ' . $this->input->get('sSortDir_0');
                break;
        }

        // Limit for paging if we're not counting
        if ($limit) {
            $sql .= ' LIMIT ' . $this->input->get('iDisplayStart') . ', ' . $this->input->get('iDisplayLength');
        }

        //echo $sql;
        */
    }

    public function getCompanyId()
    {
        return $this->getCompany()->getCompanyId();
    }

    public function getAccountsTableData($count = false)
    {
        $this->load->database();
        $excludeZero = false;

        // Build proposal count subquery
        $bidCountSubQuery = "(SELECT COUNT(*) FROM proposals p, clients c  
        WHERE p.client = c.clientId AND c.client_account = cc.id ";

        // Date filter applies to bid subquery
        if ($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
                $from = explode('/', $this->session->userdata('accFilterFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $to = explode('/', $this->session->userdata('accFilterTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

                $bidCountSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
            }

            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $bidCountSubQuery .= ' AND p.owner IN (' . $aUsers . ')';
            }

        }
        $bidCountSubQuery .= " ) AS numProposals";


        // Build bid amount subquery
        $bidAmtSubQuery = " (SELECT SUM(p.price) FROM proposals p, clients c  
            WHERE p.client = c.clientId AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery
        if ($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
                $from = explode('/', $this->session->userdata('accFilterFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $to = explode('/', $this->session->userdata('accFilterTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

                $bidAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
            }

            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $bidAmtSubQuery .= ' AND p.owner IN (' . $aUsers . ')';
                $excludeZero = true;
            }
        }

        $bidAmtSubQuery .= " AND c.client_account = cc.id) AS totalBid";
        $bidClientSubQuery = "(SELECT COUNT(clientId) FROM clients LEFT JOIN accounts a3 ON clients.account = a3.accountId  WHERE client_account = cc.id ";
        $bidClientSubQuery .= ") AS numContacts";


        // subquery for Sold amount

        $bidSoldAmtSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, clients c, statuses st  
           
            WHERE p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery
        if ($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
                $from = explode('/', $this->session->userdata('accFilterFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $to = explode('/', $this->session->userdata('accFilterTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

                $bidSoldAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
            }

            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $bidSoldAmtSubQuery .= ' AND p.owner IN (' . $aUsers . ')';
            }
        }
        $bidSoldAmtSubQuery .= " AND c.client_account = cc.id) AS totalSold";

        // subquery for Sold amount

        $bidWinSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) * 100 / SUM(p.price)  AS percent_total FROM proposals p, clients c, statuses st  
           
            WHERE p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery
        if ($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
                $from = explode('/', $this->session->userdata('accFilterFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $to = explode('/', $this->session->userdata('accFilterTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

                $bidWinSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
            }

            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $bidWinSubQuery .= ' AND p.owner IN (' . $aUsers . ')';
            }
        }

        $bidWinSubQuery .= " AND c.client_account = cc.id) AS percent_total";

        //echo $bidClientSubQuery;die;


        // Base query
        $sql = 'SELECT cc.id, cc.name, GROUP_CONCAT(bt.type_name) as types,
            a.firstName, a.lastName,' .
            $bidWinSubQuery . ', ' .
            $bidSoldAmtSubQuery . ', ' .
            $bidClientSubQuery . ', ' .
            $bidCountSubQuery . ', ' .
            $bidAmtSubQuery . '
            FROM client_companies cc
            LEFT JOIN accounts a ON cc.owner_user = a.accountId';
        // Business type filter
        //if ($this->session->userdata('accFilterBusinessType')) {
        $sql .= " LEFT JOIN business_type_assignments bta ON cc.id = bta.account_id
                          LEFT JOIN business_types bt ON bt.id = bta.business_type_id";
        //}


        $sql .= ' WHERE cc.owner_company = ' . $this->getCompany()->getCompanyId();

        // Permissions
        if (!$this->hasFullAccess()) {

            if ($this->isBranchAdmin()) {
                $sql .= ' AND a.branch = ' . $this->getBranch();
            } else {
                $sql .= ' AND cc.owner_user = ' . $this->getAccountId();
            }
        }

        // Filters
        if ($this->session->userdata('accFilter')) {

            // Owner Filter
            if ($this->session->userdata('accFilterUser')) {
                $users = implode(',', $this->session->userdata('accFilterUser'));
                $sql .= ' AND cc.owner_user IN (' . $users . ')';
            }

            // Owner Filter
            if ($this->session->userdata('accFilterBusinessType')) {
                $types = implode(',', $this->session->userdata('accFilterBusinessType'));
                $sql .= ' AND bta.business_type_id IN (' . $types . ')';
            }
        }

        $searchVal = $this->input->get('search')['value'];

        // Search
        if ($searchVal) {
            $searchVal = $this->db->escape_like_str($searchVal);
            $sql .= " AND ((cc.name LIKE \"%" . $searchVal . "%\")
                    OR (a.firstName LIKE \"%" . $searchVal . "%\")
                    OR (a.lastName LIKE \"%" . $searchVal . "%\"))";
        }
        //echo $sql;die;


        // Changed by AL 9/15/21
        // $sql .= ' GROUP BY bta.account_id,cc.id ';
        $sql .= ' GROUP BY cc.id ';

        if ($excludeZero) {
            $sql .= " HAVING numProposals > 0";
        }
        // Sorting
        if ($this->input->get('order')) {

            ///SORTING
            $order = $this->input->get('order');

            switch ($order[0]['column']) {
                case 2: // Account Name
                    $sql .= ' ORDER BY cc.name ' . $order[0]['dir'];
                    break;
                case 4: // contacts
                    $sql .= ' ORDER BY numContacts ' . $order[0]['dir'];
                    break;
                case 5: // numProposals
                    $sql .= ' ORDER BY numProposals ' . $order[0]['dir'];
                    break;
                case 6: // totalBid
                    $sql .= ' ORDER BY totalBid ' . $order[0]['dir'];
                    break;
                case 9: // Company
                    $sql .= ' ORDER BY a.firstName ' . $order[0]['dir'];
                    break;
                case 7: // Sold
                    $sql .= ' ORDER BY totalSold ' . $order[0]['dir'];
                    break;
                case 8: // Win
                    $sql .= ' ORDER BY percent_total ' . $order[0]['dir'];
                    break;
            }
        }

        if (!$count) {
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        } else {
            return $this->db->query($sql)->num_rows();
        }

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    public function getUserAccountsTableData($user_id, $count = false)
    {
        if($count) {
            return $this->getUserAccountsTableDataCount($user_id);
        }

        $this->load->database();

        // Build proposal count subquery
        $bidCountSubQuery = "(SELECT COUNT(*) FROM proposals p, clients c  
        WHERE p.client = c.clientId AND c.client_account = cc.id ";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidCountSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidCountSubQuery .= ' AND p.owner =' . $user_id;
        $bidCountSubQuery .= " ) AS numProposals";


        // Build bid amount subquery
        $bidAmtSubQuery = " (SELECT SUM(p.price) FROM proposals p, clients c 
            WHERE p.client = c.clientId AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidAmtSubQuery .= ' AND p.owner =' . $user_id;

        $bidAmtSubQuery .= " AND c.client_account = cc.id) AS totalBid";

        $bidClientSubQuery = "(SELECT COUNT(clientId)  FROM clients LEFT JOIN accounts a3 ON clients.account = a3.accountId  WHERE client_account = cc.id ";

        $bidClientSubQuery .= ' AND clients.account =' . $user_id;

        $bidClientSubQuery .= " ) AS numContacts";


        // subquery for Sold amount

        $bidSoldAmtSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, clients c, statuses st  
           
            WHERE p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidSoldAmtSubQuery .= " AND (p.win_date >= " . $start . " AND p.win_date <= " . $end . ")";
        }

        // Show all accounts
        $bidSoldAmtSubQuery .= ' AND p.owner =' . $user_id;


        $bidSoldAmtSubQuery .= " AND c.client_account = cc.id) AS totalSold";

        // subquery for Sold amount

        $bidWinSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) * 100 / SUM(p.price)  AS percent_total FROM proposals p, clients c, statuses st  
           
            WHERE p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";


        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidWinSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidWinSubQuery .= ' AND p.owner =' . $user_id;

        $bidWinSubQuery .= " AND c.client_account = cc.id) AS percent_total";


        // subquery for Open amount

        $bidOpenAmtSubQuery = " (SELECT SUM(CASE WHEN (st.id = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, clients c, statuses st  
           
            WHERE p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOpenAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOpenAmtSubQuery .= ' AND p.owner =' . $user_id;


        $bidOpenAmtSubQuery .= " AND c.client_account = cc.id) AS totalOpen";

        // subquery for Other total amount

        $bidOtherAmtSubQuery = " (SELECT SUM(CASE WHEN st.id != '1' AND st.sales != '1' THEN p.price ELSE 0 END) as total_other_amount FROM proposals p, clients c, statuses st  
           
            WHERE p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOtherAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOtherAmtSubQuery .= ' AND p.owner =' . $user_id;


        $bidOtherAmtSubQuery .= " AND c.client_account = cc.id) AS totalOther";

        //echo $bidClientSubQuery;die;
        // Base query
        $sql = 'SELECT cc.id, cc.name,
            a.firstName, a.lastName,' .
            $bidWinSubQuery . ', ' .
            $bidSoldAmtSubQuery . ', ' .
            $bidClientSubQuery . ', ' .
            $bidCountSubQuery . ', ' .
            $bidOpenAmtSubQuery . ', ' .
            $bidOtherAmtSubQuery . ', ' .
            $bidAmtSubQuery . '
            FROM client_companies cc
            LEFT JOIN accounts a ON cc.owner_user = a.accountId
            WHERE cc.owner_company = ' . $this->getCompany()->getCompanyId();

        /*
        // Permissions
        if (!$this->hasFullAccess()) {

            if ($this->isBranchAdmin()) {
                $sql .= ' AND a.branch = ' . $this->getBranch();
            } else {
                $sql .= ' AND cc.owner_user = ' . $this->getAccountId();
            }
        }


                $sql .= ' AND cc.owner_user =' . $user_id;
        */

        $searchVal = $this->input->get('search')['value'];
        // Search
        if ($searchVal) {
            $sql .= " AND ((cc.name LIKE \"%" . $searchVal . "%\")
                    OR (a.firstName LIKE \"%" . $searchVal . "%\")
                    OR (a.lastName LIKE \"%" . $searchVal . "%\"))";
        }

        $sql .= ' HAVING numProposals > 0 ';
        // Sorting

        if ($this->input->get('order')) {

            ///SORTING
            $order = $this->input->get('order');

            switch ($order[0]['column']) {
                case 1: // Account Name
                    $sql .= ' ORDER BY cc.name ' . $order[0]['dir'];
                    break;
                case 3: // status
                    $sql .= ' ORDER BY numProposals ' . $order[0]['dir'];
                    break;
                case 4: // job Number
                    $sql .= ' ORDER BY totalBid ' . $order[0]['dir'];
                    break;
                case 5: // Company
                    $sql .= ' ORDER BY totalOpen ' . $order[0]['dir'];
                    break;
                case 6: // Sold
                    $sql .= ' ORDER BY totalOther ' . $order[0]['dir'];
                    break;
                case 7: // Sold
                    $sql .= ' ORDER BY totalSold ' . $order[0]['dir'];
                    break;
                case 8: // Win
                    $sql .= ' ORDER BY percent_total ' . $order[0]['dir'];
                    break;
                case 9: //company
                    $sql .= ' ORDER BY a.firstName ' . $order[0]['dir'];
            }
        }

        if (!$count) {
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        } else {
            return $this->db->query($sql)->num_rows();
        }

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getUserAccountsTableDataCount($user_id)
    {
        $this->load->database();

        // Build proposal count subquery
        $bidCountSubQuery = "(SELECT COUNT(*) FROM proposals p, clients c  
        WHERE p.client = c.clientId AND c.client_account = cc.id ";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidCountSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidCountSubQuery .= ' AND p.owner =' . $user_id;
        $bidCountSubQuery .= " ) AS numProposals";


        //echo $bidClientSubQuery;die;
        // Base query
        $sql = 'SELECT ' .
            $bidCountSubQuery . ' 
            FROM client_companies cc
            LEFT JOIN accounts a ON cc.owner_user = a.accountId
            WHERE cc.owner_company = ' . $this->getCompany()->getCompanyId();

        $searchVal = $this->input->get('search')['value'];
        // Search
        if ($searchVal) {
            $sql .= " AND ((cc.name LIKE \"%" . $searchVal . "%\")
                    OR (a.firstName LIKE \"%" . $searchVal . "%\")
                    OR (a.lastName LIKE \"%" . $searchVal . "%\"))";
        }

        $sql .= ' HAVING numProposals > 0 ';
        
        return $this->db->query($sql)->num_rows();
    }

    /**
     * Function to send the email to the user with the link for them to reset their password
     */
    public function sendPasswordReset()
    {
        $this->setRecoveryCode();
        $this->doctrine->em->persist($this);
        $this->doctrine->em->flush();

        $emailTemplate = $this->doctrine->em->findAdminTemplate(8);
        $etp = new \EmailTemplateParser();
        $etp->setAccount($this);

        $subject = $etp->parse($emailTemplate->getTemplateSubject());
        $content = $etp->parse($emailTemplate->getTemplateBody(), true);

        $emailData = [
            'to' => $this->getEmail(),
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'subject' => $subject,
            'body' => $content,
            'categories' => ['Forgot Password Reset'],
        ];

        $this->getEmailRepository()->send($emailData);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function confirmPasswordChanged()
    {

        $emailTemplate = $this->doctrine->em->findAdminTemplate(3);
        $etp = new \EmailTemplateParser();
        $etp->setAccount($this);

        $subject = $etp->parse($emailTemplate->getTemplateSubject());
        $content = $etp->parse($emailTemplate->getTemplateBody(), true);

        $emailData = [
            'to' => $this->getEmail(),
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'subject' => $subject,
            'body' => $content,
            'categories' => ['Forgot Password Confirm'],
        ];

        $this->getEmailRepository()->send($emailData);
    }

    public function sendNewCompanyEmail()
    {
        $emailTemplate = $this->doctrine->em->findAdminTemplate(7);
        $etp = new \EmailTemplateParser();
        $etp->setAccount($this);

        $subject = $etp->parse($emailTemplate->getTemplateSubject());
        $content = $etp->parse($emailTemplate->getTemplateBody(), true);

        $emailData = [
            'to' => $this->getEmail(),
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'subject' => $subject,
            'body' => $content,
            'categories' => ['New Company Email'],
        ];

        $this->getEmailRepository()->send($emailData);
    }

    public function sendNewUserEmail()
    {

        $emailTemplate = $this->doctrine->em->findAdminTemplate(6);
 
        $etp = new \EmailTemplateParser();
        $etp->setAccount($this);
        $etp->createPassword = true;

        $subject = $etp->parse($emailTemplate->getTemplateSubject());
        $content = $etp->parse($emailTemplate->getTemplateBody(), true);

        $emailData = [
            'to' => $this->getEmail(),
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'subject' => $subject,
            'body' => $content,
            'categories' => ['New User Email'],
        ];

        $this->getEmailRepository()->send($emailData);
    }

    public function sendTrialSignupEmail()
    {
        $emailTemplate = $this->doctrine->em->findAdminTemplate(9);
        $etp = new \EmailTemplateParser();
        $etp->setAccount($this);
        $etp->createPassword = true;

        $subject = $etp->parse($emailTemplate->getTemplateSubject());
        $content = $etp->parse($emailTemplate->getTemplateBody(), true);

        $emailData = [
            'to' => $this->getEmail(),
            'fromName' => SITE_NAME,
            'fromEmail' => 'support@' . SITE_EMAIL_DOMAIN,
            'subject' => $subject,
            'body' => $content,
            'categories' => ['Trial Signup Email'],
        ];

        $this->getEmailRepository()->send($emailData);
    }

    public function resetCompanyProposals()
    {
        $props = $this->doctrine->em->createQuery('SELECT p, c, cmp FROM models\Proposals p inner join p.client c inner join c.company cmp where (p.rebuildFlag = 0) and (cmp.companyId = c.company) and (cmp.companyId = ' . $this->getCompany()->getCompanyId() . ')')->getResult();
        foreach ($props as $proposal) {
            $proposal->setRebuildFlag(1, false, false);
            $this->doctrine->em->persist($proposal);
        }
        $this->doctrine->em->flush();
        $this->doctrine->em->clear();
    }

    public function getHistoryData($limit = true)
    {

        $companyId = $this->getCompany()->getCompanyId();

        $select = "SELECT l.timeAdded, 
        l.userName, 
        l.ip, l.client, 
        l.account, 
        l.proposal, 
        l.details, 
        a.firstName as accountFirstName, 
        a.lastName as accountLastName, 
        c.firstName as clientFirstName, 
        c.lastName as clientsLastName, 
        cc.name as clientCompanyName, 
        p.projectName ";

        if(!$limit){
            $select = "SELECT count(logId) as numLogs";

        }
        $sql = $select." FROM `log` l
        left join accounts a on l.account = a.accountId AND a.company = {$companyId}
        left join clients c on l.client = c.clientId AND c.company = {$companyId}
        left join client_companies cc on c.client_account = cc.id
        left join proposals p on l.proposal = p.proposalId 
        left join clients as cl on p.client = cl.clientId AND cl.company = {$companyId}
        left join activity_action as aa on l.action = aa.id 
        where l.company = {$companyId}";

//if($this->session->userdata('hActionParent') > 0  && $this->session->userdata('hActionChild') < 1){
//    $sql .= " left join activity_action as aa on l.action = aa.id ";
//}

        //$sql .= " where l.company = {$companyId}";

        if (!$this->hasFullAccess() || $this->uri->segment(3)) {
            $account = ($this->uri->segment(3)) ? $this->uri->segment(3) : $this->getAccountId();
            $sql .= " AND l.account = {$account}";
        }

        // Search
        $searchVal = $this->input->get('search')['value'];


        if ($searchVal) {
            $searchVal = $this->db->escape_like_str($searchVal);
            $sql .= " AND ( (a.firstName like \"%" . $searchVal . "%\")
                    OR (a.lastName like \"%" . $searchVal . "%\")
                    OR (cc.name like \"%" . $searchVal . "%\")
                    OR (c.lastName like \"%" . $searchVal . "%\")
                    OR (c.firstName like \"%" . $searchVal . "%\")
                    OR (l.details like \"%" . $searchVal . "%\")
                    OR (CONCAT(c.firstName, ' ', c.lastName) like \"%" . $searchVal . "%\")
                    OR (p.projectName like \"%" . $searchVal . "%\")
                    OR (aa.activity_action_name like \"%" . $searchVal . "%\"))";
        }

        if ($this->session->userdata('hisFilter')) {
            if ($this->session->userdata('hFilterFrom') && $this->session->userdata('hFilterTo')) {
                $from = explode('/', $this->session->userdata('hFilterFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $to = explode('/', $this->session->userdata('hFilterTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

                $sql .= " AND (l.timeAdded >= " . $start . " AND l.timeAdded <= " . $end . ")";
            }
            if($this->session->userdata('hActionChild') > 0){
                $action = $this->session->userdata('hActionChild');
                $sql .= " AND l.action = " . $action ;
               
            }else  if($this->session->userdata('hActionParent') > 0  && $this->session->userdata('hActionChild') < 1){
                $action  = $this->session->userdata('hActionParent');
                $sql .= " AND aa.parent_id = ".$action;
            }
        }

        ///SORTING
        $sortDir = 'asc';

        $order = $this->input->get('order');
        if ($order) {
            $sortDir = $order[0]['dir'];
        }

        switch ($order[0]['column']) {
            case 1: // date
                $sql .= ' ORDER BY l.timeAdded ' . $sortDir;
                break;
            case 2: // user name
                $sql .= ' ORDER BY a.firstName ' . $sortDir;
                break;
            case 3: // Company Name
                $sql .= ' ORDER BY cc.name ' . $sortDir;
                break;
            case 5: // Project Name
                $sql .= ' ORDER BY p.projectName ' . $sortDir;
                break;
            case 6: // Company
                $sql .= ' ORDER BY l.details ' . $sortDir;
                break;
        }

        $this->load->database();
        // Limit for paging if we're not counting
        if ($limit) {
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }else{
            
            return $this->db->query($sql)->result()[0]->numLogs;
        }
        //echo $sql;die;
       
        $logs = $this->db->query($sql)->result();
        $this->db->close();

        return $logs;
    }

    public function getHistoryDataTotal($filter = false)
    {

        $companyId = $this->getCompany()->getCompanyId();

        $sql = "SELECT COUNT(*) AS total
        FROM `log` l ";
        if($this->session->userdata('hActionParent') > 0  && $this->session->userdata('hActionChild') < 1){
            $sql .= " left join activity_action as aa on l.action = aa.id ";
        }
        $sql .= " where l.company = {$companyId}";

        if (!$this->hasFullAccess() || $this->uri->segment(3)) {
            $account = ($this->uri->segment(3)) ? $this->uri->segment(3) : $this->getAccountId();
            $sql .= " AND l.account = {$account}";
        }

 /*
        if ($filter) {
            $searchVal = $this->input->get('search')['value'];

            if ($searchVal) {
                $searchValue = $this->db->escape_like_str($searchVal);
                $sql .= " AND ((a.firstName like \"%" . $searchValue . "%\")
                    OR (a.lastName like \"%" . $searchValue . "%\")
                    OR (cc.name like \"%" . $searchValue . "%\")
                    OR (c.lastName like \"%" . $searchValue . "%\")
                    OR (c.firstName like \"%" . $searchValue . "%\")
                    OR (l.details like \"%" . $searchValue . "%\")
                    OR (CONCAT(c.firstName, ' ', c.lastName) like \"%" . $searchValue . "%\")
                    OR (p.projectName like \"%" . $searchValue . "%\"))";
            }
        }
*/

        if ($this->session->userdata('hisFilter')) {
            if ($this->session->userdata('hFilterFrom') && $this->session->userdata('hFilterTo')) {
                $from = explode('/', $this->session->userdata('hFilterFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $to = explode('/', $this->session->userdata('hFilterTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

                $sql .= " AND (l.timeAdded >= " . $start . " AND l.timeAdded <= " . $end . ")";
            }

            if($this->session->userdata('hActionChild') > 0){
                $action = $this->session->userdata('hActionChild');
                $sql .= " AND l.action = " . $action ;
               
            }else  if($this->session->userdata('hActionParent') > 0  && $this->session->userdata('hActionChild') < 1){
                $action  = $this->session->userdata('hActionParent');
                $sql .= " AND aa.parent_id = ".$action;
            }
        }

        $this->load->database();
        $total = $this->db->query($sql)->result();
        $this->db->close();
        $total = $total[0];

        return $total->total;
    }


    public function getAdminHistoryData($limit = true)
    {

        if($this->uri->segment(3)){
            $companyId = $this->uri->segment(3);
            $select = "SELECT l.timeAdded, 
            l.userName, 
            l.ip, l.client, 
            l.account, 
            l.proposal, 
            l.details, 
            a.firstName as accountFirstName, 
            a.lastName as accountLastName, 
            c.firstName as clientFirstName, 
            c.lastName as clientsLastName, 
            cc.name as clientCompanyName,
            cmp.companyName as projectCompanyName,
            cmp1.companyName as accountCompanyName,
            p.projectName ";

            if(!$limit){
                $select = "SELECT count(l.logId) as numLogs ";
            }
            $sql = $select ." FROM `log` l
                left join accounts a on l.account = a.accountId AND a.company = {$companyId} 
                left join clients c on l.client = c.clientId AND c.company = {$companyId}
                left join client_companies cc on c.client_account = cc.id
                left join proposals p on l.proposal = p.proposalId 
                left join clients as cl on p.client = cl.clientId AND cl.company = {$companyId} 
                left join companies as cmp on p.company_id = cmp.companyId AND cmp.companyId = {$companyId}
                left join companies as cmp1 on a.company = cmp1.companyId AND cmp1.companyId = {$companyId}
                left join activity_action as aa on l.action = aa.id 
                where l.company = {$companyId}";

        }else{

        
            $select = "SELECT l.timeAdded, 
            l.userName, 
            l.ip, l.client, 
            l.account, 
            l.proposal, 
            l.details, 
            a.firstName as accountFirstName, 
            a.lastName as accountLastName, 
            c.firstName as clientFirstName, 
            c.lastName as clientsLastName, 
            cc.name as clientCompanyName,
            cmp.companyName as projectCompanyName,
            cmp1.companyName as accountCompanyName,
            p.projectName ";

            if(!$limit){
                $select = "SELECT count(l.logId) as numLogs ";
            }
            $sql = $select ." FROM `log` l
            left join accounts a on l.account = a.accountId 
            left join clients c on l.client = c.clientId 
            left join client_companies cc on c.client_account = cc.id
            left join proposals p on l.proposal = p.proposalId 
            left join clients as cl on p.client = cl.clientId 
            left join companies as cmp on p.company_id = cmp.companyId
            left join companies as cmp1 on a.company = cmp1.companyId 
            left join activity_action as aa on l.action = aa.id ";

            
        }

        // if (!$this->hasFullAccess() || $this->uri->segment(3)) {
        //     $account = ($this->uri->segment(3)) ? $this->uri->segment(3) : $this->getAccountId();
        //     $sql .= " AND l.account = {$account}";
        // }

        
        // Search
        $searchVal = $this->input->get('search')['value'];

        
        if ($searchVal) {
            
            if(!$this->uri->segment(3)){
                $sql .= " WHERE ";
            }
            $searchVal = $this->db->escape_like_str($searchVal);
            $sql .= " ( (a.firstName like \"%" . $searchVal . "%\")
                    OR (a.lastName like \"%" . $searchVal . "%\")
                    OR (cc.name like \"%" . $searchVal . "%\")
                    OR (c.lastName like \"%" . $searchVal . "%\")
                    OR (c.firstName like \"%" . $searchVal . "%\")
                    OR (l.details like \"%" . $searchVal . "%\")
                    OR (cmp.companyName like \"%" . $searchVal . "%\")
                    OR (CONCAT(c.firstName, ' ', c.lastName) like \"%" . $searchVal . "%\")
                    OR (p.projectName like \"%" . $searchVal . "%\")
                    OR (aa.activity_action_name like \"%" . $searchVal . "%\"))";
        }

        if ($this->session->userdata('hisAdminFilter')) {
            if(!$this->uri->segment(3) && !$searchVal){
                $sql .= " WHERE logId > 0";
            }
            if ($this->session->userdata('hAdminFilterFrom') && $this->session->userdata('hAdminFilterTo')) {
                $from = explode('/', $this->session->userdata('hAdminFilterFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $to = explode('/', $this->session->userdata('hAdminFilterTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

                $sql .= " AND (l.timeAdded >= " . $start . " AND l.timeAdded <= " . $end . ")";
            }

            if($this->session->userdata('hAdminActionChild') > 0){
                $action = $this->session->userdata('hAdminActionChild');
                $sql .= " AND l.action = " . $action ;
               
            }else  if($this->session->userdata('hAdminActionParent') > 0  && $this->session->userdata('hAdminActionChild') < 1){
                $action  = $this->session->userdata('hAdminActionParent');
                $sql .= " AND aa.parent_id = ".$action;
            }
        }

        ///SORTING
        $sortDir = 'asc';

        $order = $this->input->get('order');
        if ($order) {
            $sortDir = $order[0]['dir'];
        }

        switch ($order[0]['column']) {
            case 1: // date
                $sql .= ' ORDER BY l.timeAdded ' . $sortDir;
                break;
            case 1: // Company
                $sql .= ' ORDER BY l.timeAdded ' . $sortDir;
                break;
            case 3: // user name
                $sql .= ' ORDER BY a.firstName ' . $sortDir;
                break;
            case 4: // Company Name
                $sql .= ' ORDER BY cc.name ' . $sortDir;
                break;
            case 5: // Project Name
                $sql .= ' ORDER BY p.projectName ' . $sortDir;
                break;
            case 6: // details
                $sql .= ' ORDER BY l.details ' . $sortDir;
                break;
        }

        $this->load->database();
        // Limit for paging if we're not counting
        if ($limit) {
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }else{
            
            return $this->db->query($sql)->result()[0]->numLogs;
        }
       
       
        $logs = $this->db->query($sql)->result();
        $this->db->close();

        return $logs;
    }

    public function getAdminHistoryDataTotal($filter = false)
    {
        if($this->uri->segment(3)){
            $companyId = $this->uri->segment(3);

        $sql = "SELECT COUNT(logId) AS total
        FROM `log` l  where l.company = {$companyId}";
        }else{
            $sql = "SELECT COUNT(logId) AS total
            FROM `log`";
        }

        

        // if ($this->session->userdata('hisFilter')) {
        //     if ($this->session->userdata('hFilterFrom') && $this->session->userdata('hFilterTo')) {
        //         $from = explode('/', $this->session->userdata('hFilterFrom'));
        //         $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
        //         $to = explode('/', $this->session->userdata('hFilterTo'));
        //         $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

        //         $sql .= " AND (l.timeAdded >= " . $start . " AND l.timeAdded <= " . $end . ")";
        //     }
        // }

        $this->load->database();
        $total = $this->db->query($sql)->result();
        $this->db->close();
        $total = $total[0];

        return $total->total;
    }


    /**
     * @return int
     */
    public function getTimeZoneOffset()
    {
        switch ($this->getTimeZone()) {
            case 'EST':
                return 0;
                break;
            case 'CST':
                return -3600;
                break;
            case 'MST':
                return -7200;
                break;
            case 'PST':
                return -10800;
                break;
            default:
                return 0;
        }
    }

    public function gettimeZone()
    {
        return $this->timeZone;
    }

    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
    }

    public function getLastLogin_old()
    {

        $dql = "SELECT MAX(l.timeAdded)
        FROM \models\Log l
        WHERE l.account = :accountId
        AND l.action = 'user_login'";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter(':accountId', $this->getAccountId());
        $lastLogin = $query->getSingleScalarResult();

        return $lastLogin;
    }

    function getAdminCompaniesTableData($count = false)
    {
        // Base query
        $sql = "SELECT c.companyId, c.companyName, c.companyStatus, c.new_layouts, c.psa, c.administrator,c.estimating,
                CONCAT(a.firstName, ' ', a.lastName) AS adminFullName,c.sales_manager,c.modify_price,c.proposalCampaigns,c.proposal_checklist,
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.parent_user_id =0) AS numUsers,            
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.parent_user_id =0 AND a.secretary <> 1 AND a.expires > " . time() . ") AS numPaidUsers,                
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.parent_user_id =0 AND a.secretary <> 1 AND a.expires < " . time() . ") AS numInactiveUsers,           
                (SELECT MIN(expires) FROM accounts a WHERE a.company = c.companyId AND a.parent_user_id =0 AND a.secretary <> 1 AND a.expires > " . time() . ") AS nextExpiry,
                (SELECT COUNT(notes.noteId) FROM notes WHERE notes.type = 'company'  AND a.parent_user_id =0 AND relationId=c.companyId) as ncount    
            FROM companies c
            LEFT JOIN accounts a ON c.administrator = a.accountId";

        $sortCol = $this->input->get('order')[0]['column'];
        $sortDir = $this->input->get('order')[0]['dir'];

        // We need a where to kick things off
        $sql .= " WHERE c.companyId > 0";

       // echo $sql;die;

        // Search
        $searchVal = $this->input->get('search')['value'];
        $searchVal = $this->db->escape_like_str($searchVal);

        if ($searchVal) {
            $sql .= " AND ((CONCAT(a.firstName, ' ', a.lastName) LIKE '%" . $searchVal . "%')
                    OR (c.companyName like '%" . $searchVal . "%'))";
        }


        // Filters
        if ($this->session->userdata('adminStatusFilter')) {
            $sql .= " AND c.companyStatus = '" . $this->session->userdata('adminStatusFilter') . "'";
        }

        if ($this->session->userdata('adminStatusExpiredFilter')) {

            switch ($this->session->userdata('adminStatusExpiredFilter')) {

                case 'Active':
                    $sql .= ' HAVING numInactiveUsers < numUsers';
                    break;

                case 'Expired':
                    $sql .= ' HAVING numInactiveUsers = numUsers';
                    break;
            }
        }
        // Sorting
        switch ($sortCol) {

            case 1: // Company ID
                $sql .= ' ORDER BY c.companyId ' . $sortDir;
                break;

            case 2: // Company id
              $sql .= ' ORDER BY c.companyId ' . $sortDir;
                break;

            case 3: // Company Name
                $sql .= ' ORDER BY c.companyName ' . $sortDir;
                break;

            case 4: // company Status
               $sql .= ' ORDER BY c.companyStatus ' . $sortDir;
               break;

            case 5: // num Users
               $sql .= ' ORDER BY numUsers ' . $sortDir;
                break;

            case 6: // num Paid Users
                $sql .= ' ORDER BY numPaidUsers ' . $sortDir;
                break;

            case 7: // num Inactive Users
               $sql .= ' ORDER BY numInactiveUsers ' . $sortDir;
               break;

            case 8: // next Expiry
              $sql .= ' ORDER BY nextExpiry ' . $sortDir;
                break;

            case 9: // admin Full Name
               $sql .= ' ORDER BY adminFullName ' . $sortDir;
                break;

            case 10: // new layouts
                $sql .= ' ORDER BY new_layouts ' . $sortDir;
                break;
            case 11: // PSA
                $sql .= ' ORDER BY psa ' . $sortDir;
                break;
            case 12: // estimating
                  $sql .= ' ORDER BY estimating ' . $sortDir;
                break;
            case 13: // sales_manager
                      $sql .= ' ORDER BY sales_manager ' . $sortDir;
                break;
            case 14: // Proposal modify_price
                            $sql .= ' ORDER BY modify_price ' . $sortDir;
                break;
            case 15: // Proposal proposalCampaigns
                            $sql.= '  ORDER BY proposalCampaigns ' . $sortDir;
        }
        if ($count) {
            return count($this->db->query($sql)->result());
            
        }
        if ($this->input->get('length') != -1) {
            // Paging
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }


        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }


    function getAdminCompaniesResendTableData($count = false, $action = '', $type = '')
    {
        // Base query
        $sql = "SELECT 
                    c.companyId,
                    c.companyName,
                    a.accountId,
                    a.email,
                    agre.delivered_at,
                    agre.opened_at,
                    agre.bounced_at,
                    agre.clicked_at,
                    CONCAT(a.firstName, ' ', a.lastName) AS adminFullName
            FROM accounts a
            LEFT JOIN companies c ON a.company = c.companyId
            LEFT JOIN 
                admin_group_resend_email agre ON a.accountId = agre.user_id 
                AND agre.resend_id = " . $this->session->userdata('pAdminResendFilterId');

        $user_ids = $this->getResendCompaniesIds($this->session->userdata('pAdminResendFilterId'));

        if ($user_ids) {
            $user_ids = implode(',', $user_ids);
            $sql .= " WHERE a.accountId IN(" . $user_ids . ")";
        } else {
            return [];
        }

        if ($type == 'failed') {

            $sql .= " AND agre.is_failed=1 ";
        } else {
            // Now add the WHERE condition
            switch ($type) {

                case 'delivered':
                    // Join on the PGRE where delivered
                    $sql .= " AND agre.delivered_at IS NOT NULL";
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered
                    $sql .= " AND agre.bounced_at IS NOT NULL";
                    break;

                case 'opened':
                    // Join on the PGRE where delivered
                    $sql .= " AND agre.opened_at IS NOT NULL";
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered
                    $sql .= " AND agre.opened_at IS NULL";
                    break;
                case 'clicked':
                    $sql .= " AND agre.clicked_at IS NOT NULL";
                    break;
            }

            $sql .= " AND agre.is_failed=0 ";
        }
        $sortCol = $this->input->get('order')[0]['column'];
        $sortDir = $this->input->get('order')[0]['dir'];

        // Search
        $searchVal = $this->input->get('search')['value'];

        if ($searchVal) {
            $sql .= " AND ((CONCAT(a.firstName, ' ', a.lastName) LIKE '%" . $searchVal . "%')
                    OR (c.companyName like '%" . $searchVal . "%')  OR (a.email like '%" . $searchVal . "%'))";
        }

        // Sorting
        switch ($sortCol) {

            case 0: // Company Name
                $sql .= ' ORDER BY c.companyName ' . $sortDir;
                break;

            case 1: // User Name
                $sql .= ' ORDER BY adminFullName ' . $sortDir;
                break;

            case 2: // Email
                $sql .= ' ORDER BY a.email ' . $sortDir;
                break;

            case 3: // Delivered At
                $sql .= ' ORDER BY agre.delivered_at ' . $sortDir;
                break;

            case 4: // Opened At
                $sql .= ' ORDER BY agre.opened_at ' . $sortDir;
                break;

            case 5: // Bounced At
                $sql .= ' ORDER BY agre.bounced_at ' . $sortDir;
                break;

            case 6: // Clicked At
                $sql .= ' ORDER BY agre.clicked_at ' . $sortDir;
                break;
        }

        if ($count) {
            return count($this->db->query($sql)->result());
        }

        if ($this->input->get('length') != -1) {
            // Paging
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }


    public function getEstimatesData($action = '', $client = '', $limit = true, $map = false, $company = false, $page = false, $numRecords = false, $coords = null)
    {
        $this->load->database();
        $firstProposal = $this->getCompany()->getFirstProposalTime();

        // Base query
        $sql = 'SELECT proposals.proposalId, proposals.projectName, proposals.projectAddress, proposals.projectCity, proposals.projectState, proposals.projectZip, proposals.price, proposals.jobNumber, proposals.created, proposals.status, proposals.duplicateOf, proposals.approvalQueue, proposals.declined, proposals.proposalStatus, proposal_estimates.last_updated as last_activity, proposals.email_status, proposals.deliveryTime, proposals.lastOpenTime, proposals.emailSendTime, proposals.audit_key, proposals.audit_view_time, proposals.audit_reminder_sent, proposals.win_date, proposals.QBID, proposals.unapproved_services, proposals.lat, proposals.lng, proposals.access_key,proposals.estimate_status_id,proposals.signature_id,proposals.company_signature_id,
        accounts.firstName as accountFN, accounts.lastName as accountLN, accounts.branch, accounts.accountId as account,
        client_companies.name as clientAccountName, branches.branchName,
        clients.clientId, clients.title as clientTitle, clients.firstName as clientFN, clients.lastName as clientLN, clients.businessPhone as clientBP, clients.cellPhone as clientCP, clients.companyName as clientCompany, clients.quickbooksId as clientQuickbooksId, clients.email as clientEmail,
        statuses.text as statusText, proposal_estimates.status_id as estimate_status_id,proposal_estimates.material,proposal_estimates.equipment,proposal_estimates.labor,proposal_estimates.created_at,proposal_estimates.completion_percent
        
        FROM  proposal_estimates 
        LEFT JOIN proposals on proposal_estimates.proposal_id = proposals.proposalId
        LEFT JOIN clients on proposals.client = clients.clientId
        LEFT JOIN client_companies on clients.client_account = client_companies.id
        LEFT JOIN companies on clients.company = companies.companyId
        LEFT JOIN accounts on proposals.owner = accounts.accountId
        LEFT JOIN statuses on proposals.proposalStatus = statuses.id
        LEFT JOIN branches ON accounts.branch = branches.branchId';

        // Join required for services so add here //
        $serviceJoin = false;
        // Check for status filters first as these are temporary
        if ($action == 'status') {
            if ($this->session->userdata('pesStatusFilter') && $this->session->userdata('pesStatusFilterService')) {
                $serviceJoin = true;
            }
        }   // Standard proposals join
        else {
            if ($this->session->userdata('pesFilter') && $this->session->userdata('pesFilterService') && $action != 'search') {
                $serviceJoin = true;
            }
        }

        if ($serviceJoin) {
            $sql .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
        }

        // Run permissions check if we're not doing the whole company
        if (!$company) {
            // Filter by user permissions
            if ($this->getUserClass() >= 2) {
                //company admin or full access, access to all proposals
                $sql .= ' WHERE companies.companyId=' . $this->getCompany()->getCompanyId();
            } else {
                if ($this->isBranchAdmin()) {
                    //branch admin, can access only his branch
                    $sql .= ' WHERE accounts.branch = ' . $this->getBranch() . '
                        AND companies.companyId=' . $this->getCompany()->getCompanyId();
                } else {
                    //regular user, can access only his proposals
                    $sql .= ' WHERE proposals.owner=' . $this->getAccountId();
                }
            }
        } else {
            $sql .= ' WHERE companies.companyId=' . $this->getCompany()->getCompanyId();
        }

        // Search
        if ($this->input->get('sSearch')  != '') {
            $sql .= " AND ( (proposals.projectName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.email like \"%" . $this->input->get('sSearch') . "%\")
                    OR (client_companies.name like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.lastName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.firstName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (CONCAT(clients.firstName, ' ', clients.lastName) like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.projectAddress like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.projectCity like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.projectState like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.projectZip like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.businessPhone like \"%" . $this->input->get('sSearch') . "%\")
                    OR (clients.cellPhone like \"%" . $this->input->get('sSearch') . "%\")
                    OR (proposals.jobNumber like \"%" . $this->input->get('sSearch') . "%\"))";
        }

        // Client
        if ($client) {
            $sql .= " AND clients.clientId = " . $client;
        }

        // Mappable proposals
        if ($map) {
            $sql .= " AND (proposals.lat IS NOT NULL AND proposals.lng IS NOT NULL)";
        }

        // Filters
        if (($action == 'status') && $this->session->userdata('pesStatusFilter')) {
            if ($this->session->userdata('pStatusFilterStatus') && $this->session->userdata('pesStatusFilterStatus') != 'All') {
                $sql .= " and (proposals.proposalStatus = '" . $this->session->userdata('pesStatusFilterStatus') . "')";
            }

            if (($this->session->userdata('pesStatusFilterBranch') && $this->session->userdata('pesStatusFilterBranch') != 'All') || ($this->session->userdata('pStatusFilterBranch') === '0')) {

                $sql .= " and (accounts.branch = '" . $this->session->userdata('pesStatusFilterBranch') . "')";
            }

            if ($this->session->userdata('pesStatusFilterUser') && $this->session->userdata('pesStatusFilterUser') != 'All') {
                $sql .= " and (clients.account = '" . $this->session->userdata('pesStatusFilterUser') . "')";
            }

            if ($this->session->userdata('rollover')) {

                $start = $firstProposal;
                $end = mktime(0, 0, 0, 1, 1, date('Y'));

                $sql .= " and (proposals.created >= {$start})";

                $sql .= " and (proposals.created <= {$end})";
            } else {
                if ($this->session->userdata('pesStatusFilterFrom')) {
                    $from = explode('/', $this->session->userdata('pesStatusFilterFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.created >= {$start})";
                }

                if ($this->session->userdata('pesStatusFilterTo')) {
                    $to = explode('/', $this->session->userdata('pesStatusFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.created <= {$end})";
                }
            }

            if ($this->session->userdata('pesStatusFilterService')) {
                $sql .= ' and proposal_services.initial_service = ' . $this->session->userdata('pesStatusFilterService');
            }

            // Status date change from
            if ($this->session->userdata('pesStatusFilterChangeFrom')) {
                $from = explode('/', $this->session->userdata('pesStatusFilterChangeFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $sql .= " and (proposals.statusChangeDate >= {$start})";
            }
            // Status date change to
            if ($this->session->userdata('pesStatusFilterChangeTo')) {
                $to = explode('/', $this->session->userdata('pesStatusFilterChangeTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                $sql .= " and (proposals.sestatusChangeDate <= {$end})";
            }

            if ($this->session->userdata('pesStatusFilterService')) {
                $sql .= " and (proposal_services.initial_service IN (" . implode(
                    ', ',
                    $this->session->userdata('pesStatusFilterService')
                ) . "))";
            }

            if ($this->session->userdata('pesStatusFilterQueue')) {

                if ($this->session->userdata('pesStatusFilterQueue') == 'duplicate') {
                    $sql .= ' and proposals.duplicateOf IS NOT NULL';
                } else {
                    if ($this->session->userdata('pesStatusFilterQueue') == 1) {
                        $sql .= ' and proposals.approvalQueue = 1';
                    } else {
                        $sql .= ' and proposals.declined = 1';
                    }
                }
            }
        } else {
            if ($this->session->userdata('pesFilter') && $action != 'search') {

                // Proposal Status
                if ($this->session->userdata('pesFilterStatus')) {
                    //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                    $sql .= " and (proposals.proposalStatus IN (" . implode(
                        ', ',
                        $this->session->userdata('pesFilterStatus')
                    ) . "))";
                }

                // Estimate Status

                if ($this->session->userdata('pesFilterEstimateStatus')) {
                    $sql .= " and (proposal_estimates.status_id IN (" . implode(
                        ', ',
                        $this->session->userdata('pesFilterEstimateStatus')
                    ) . "))";
                }
                // User
                if ($this->session->userdata('pesFilterUser')) {
                    $sql .= " and (proposals.owner IN (" . implode(
                        ', ',
                        $this->session->userdata('pesFilterUser')
                    ) . "))";
                } else {
                    if ($this->session->userdata('pesFilterBranch')) {
                        $sql .= " and (accounts.branch IN (" . implode(
                            ', ',
                            $this->session->userdata('pesFilterBranch')
                        ) . "))";
                    }
                }
                // Account
                if ($this->session->userdata('pesFilterClientAccount')) {
                    $sql .= " AND (clients.client_account IN (" . implode(
                        ',',
                        $this->session->userdata('pesFilterClientAccount')
                    ) . "))";
                }
                // Created Date from
                if ($this->session->userdata('pesCreatedFrom')) {
                    $start = $this->session->userdata('pesCreatedFrom');
                    $sql .= " AND (proposal_estimates.created_at >= '$start')";
                }
                // Created Date To
                if ($this->session->userdata('pesCreatedTo')) {
                    $end = $this->session->userdata('pesCreatedTo');
                    $sql .= " AND (proposal_estimates.created_at <= '$end')";
                }
                // Activity Date from
                if ($this->session->userdata('pesActivityFrom')) {
                    $laStart = $this->session->userdata('pesActivityFrom');
                    $sql .= " AND (proposal_estimates.last_updated >= '$laStart')";
                }
                // Activity Date To
                if ($this->session->userdata('pesActivityTo')) {
                    $laEnd = $this->session->userdata('pesActivityTo');
                    $sql .= " AND (proposal_estimates.last_updated <= '$laEnd')";
                }
                if ($this->session->userdata('pesFilterService')) {
                    $sql .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('pesFilterService')
                    ) . "))";
                }
                if ($this->session->userdata('pesFilterQueue')) {

                    $addOr = false;
                    $sql .= ' AND (';

                    if (in_array('duplicate', $this->session->userdata('pesFilterQueue'))) {
                        $addOr = true;
                        $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                    }

                    if (in_array(1, $this->session->userdata('pesFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                        }
                        $sql .= ' (proposals.approvalQueue = 1)';
                        $addOr = true;
                    }

                    if (in_array(2, $this->session->userdata('pesFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                        }
                        $sql .= ' (proposals.declined = 1)';
                        $addOr = true;
                    }

                    if (in_array('unapproved', $this->session->userdata('pesFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                        }
                        $sql .= ' (proposals.unapproved_services = 1)';
                    }

                    $sql .= ')';
                }
                if ($this->session->userdata('pesFilterEmailStatus')) {

                    $addOr = false;
                    $sql .= ' AND (';

                    if (in_array('o', $this->session->userdata('pesFilterEmailStatus'))) {
                        $addOr = true;
                        $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                    }

                    if (in_array('d', $this->session->userdata('pesFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                        }
                        $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                        $addOr = true;
                    }

                    if (in_array('u', $this->session->userdata('pesFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                                AND proposals.deliveryTime IS NULL)';
                        $addOr = true;
                    }

                    if (in_array('uo', $this->session->userdata('pesFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                                AND proposals.deliveryTime IS NOT NULL)';
                    }
                    if (in_array('us', $this->session->userdata('pesFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                    }

                    $sql .= ')';
                }
                if ($this->session->userdata('pesFilterMinBid')) {
                    $sql .= ' AND (proposals.price >= ' . $this->session->userdata('pesFilterMinBid');
                    if (!$this->session->userdata('pesFilterMaxBid')) {
                        $sql .= ' OR proposals.price IS NULL)';
                    } else {
                        $sql .= ')';
                    }
                }
                if ($this->session->userdata('pesFilterMaxBid')) {
                    $sql .= ' AND (proposals.price <= ' . $this->session->userdata('pesFilterMaxBid');
                    if (!$this->session->userdata('pesFilterMinBid')) {
                        $sql .= ' OR proposals.price IS NULL)';
                    } else {
                        $sql .= ')';
                    }
                }
            }
        }

        // Map coordinates
        if ($coords) {
            $sql .= " AND proposals.lat < " . $coords['x1'] . "
                      AND proposals.lng < " . $coords['x2'] . "
                      AND proposals.lat > " . $coords['y1'] . "
                      AND proposals.lng > " . $coords['y2'];
        }

        // Searching on services can give duplicate results - this stops that
        $sql .= ' GROUP BY proposals.proposalId';

        if ($this->input->get('iSortCol_0')) {

            ///SORTING
            switch ($this->input->get('iSortCol_0')) {
                case 2: // date
                    $sql .= ' ORDER BY proposals.created ' . $this->input->get('sSortDir_0');
                    break;
                case 3: // branch
                    $sql .= ' ORDER BY accounts.branch ' . $this->input->get('sSortDir_0');
                    break;
                case 4: // status
                    $sql .= ' ORDER BY statusText ' . $this->input->get('sSortDir_0');
                    break;
                case 6: // job Number
                    //$sql .= ' ORDER BY proposals.jobNumber ' . $this->input->get('sSortDir_0');
                    $sql .= ' ORDER BY lpad(proposals.jobNumber, 10, 0) ' . $this->input->get('sSortDir_0');
                    break;
                case 7: // Company
                    $sql .= ' ORDER BY clients.companyName ' . $this->input->get('sSortDir_0');
                    break;
                case 8: // Project Name
                    $sql .= ' ORDER BY proposals.projectName ' . $this->input->get('sSortDir_0');
                    break;
                case 10: // Price
                    $sql .= ' ORDER BY proposals.price ' . $this->input->get('sSortDir_0');
                    break;
                case 11: // Contact
                    $sql .= ' ORDER BY clients.firstName ' . $this->input->get('sSortDir_0');
                    break;
                case 12: // Owner
                    $sql .= ' ORDER BY accounts.firstName ' . $this->input->get('sSortDir_0');
                    break;
                case 13: // Last Activity
                    $sql .= ' ORDER BY proposal_estimates.last_updated ' . $this->input->get('sSortDir_0') . ' , proposals.created DESC';
                    break;
                case 17: // Email Status
                    $sql .= ' ORDER BY proposals.email_status ' . $this->input->get('sSortDir_0');
                    break;
                case 19: // Delivery Status
                    $sql .= ' ORDER BY proposals.deliveryTime ' . $this->input->get('sSortDir_0');
                    break;
                case 21: // Open Status
                    $sql .= ' ORDER BY proposals.lastOpenTime ' . $this->input->get('sSortDir_0');
                    break;
                case 23: // Audit View Time
                    $sql .= ' ORDER BY proposal_estimates.completion_percent ' . $this->input->get('sSortDir_0');
                    break;
                case 24: // Estimate type View
                    $sql .= ' ORDER BY proposals.estimate_status_id ' . $this->input->get('sSortDir_0');
                    break;
            }
        }

        // Limit for paging if we're not counting
        if ($limit) {
            $sql .= ' LIMIT ' . $this->input->get('iDisplayStart') . ', ' . $this->input->get('iDisplayLength');
        }


        if (!is_int($page) && $numRecords) {
            $start = ($numRecords * $page);
            $sql .= ' LIMIT ' . $start . ', ' . $numRecords;
        }

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }


    public function hasEstimatingPermission()
    {
        // Deny if company doesn't have estimating
        if (!$this->getCompany()->getEstimating()) {
            return false;
        }

        // Allow admins
        if ($this->isAdministrator()) {
            return true;
        }

        // Allow beanch managers
        if ($this->isBranchAdmin()) {
            return true;
        }

        // Deny secretaries
        if ($this->isSecretary()) {
            return false;
        }

        // Allows users and full access if they are enabled
        if ($this->getUserClass() == 0 || $this->getUserClass() == 2) {

            if ($this->getEstimating()) {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    public function isSecretary()
    {
        return $this->getSecretary();
    }

    /**
     * @return mixed
     */
    public function getEstimating()
    {
        return $this->estimating;
    }

    /**
     * @param mixed $estimating
     */
    public function setEstimating($estimating)
    {
        $this->estimating = $estimating;
    }

    public function getJobCostHistoryData($company, $proposalId, $limit = true)
    {

        $companyId = $company->getCompanyId();

        $sql = "SELECT l.timeAdded, l.userName, l.ip, l.client, l.account, l.proposal, l.details, a.firstName as accountFirstName, a.lastName as accountLastName, c.firstName as clientFirstName, c.lastName as clientsLastName, cc.name as clientCompanyName, p.projectName 
        FROM `log` l
        left join accounts a on l.account = a.accountId AND a.company = {$companyId}
        left join clients c on l.client = c.clientId AND c.company = {$companyId}
        left join client_companies cc on c.client_account = cc.id
        left join proposals p on l.proposal = p.proposalId 
        left join clients as cl on p.client = cl.clientId AND cl.company = {$companyId}
    where l.company = {$companyId} AND l.proposal = {$proposalId} AND l.action ='mobile_job_costing' ";


        // if (!$this->hasFullAccess() || $this->uri->segment(3)) {
        //     $account = ($this->uri->segment(3)) ? $this->uri->segment(3) : $this->getAccountId();
        //     $sql .= " AND (
        //     (l.account = {$account}) or (((p.client in (select clients.clientId from clients where clients.account = {$account})) or (p.owner = {$account})) and l.account is null)
        //     )";
        // }

        // Search
        if ($this->input->get('sSearch')) {
            $sql .= " AND ( (a.firstName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (a.lastName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (cc.name like \"%" . $this->input->get('sSearch') . "%\")
                    OR (c.lastName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (c.firstName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (l.details like \"%" . $this->input->get('sSearch') . "%\")
                    OR (CONCAT(c.firstName, ' ', c.lastName) like \"%" . $this->input->get('sSearch') . "%\")
                    OR (p.projectName like \"%" . $this->input->get('sSearch') . "%\"))";
        }

        ///SORTING
        switch ($this->input->get('iSortCol_0')) {
            case 1: // date
                $sql .= ' ORDER BY l.timeAdded ' . $this->input->get('sSortDir_0');
                break;
            case 2: // user name
                $sql .= ' ORDER BY a.firstName ' . $this->input->get('sSortDir_0');
                break;
            case 3: // Company Name
                $sql .= ' ORDER BY cc.name ' . $this->input->get('sSortDir_0');
                break;
            case 5: // Project Name
                $sql .= ' ORDER BY p.projectName ' . $this->input->get('sSortDir_0');
                break;
            case 6: // Company
                $sql .= ' ORDER BY l.details ' . $this->input->get('sSortDir_0');
                break;
        }

        // Limit for paging if we're not counting
        if ($limit) {
            $sql .= ' LIMIT ' . $this->input->get('iDisplayStart') . ', ' . $this->input->get('iDisplayLength');
        }

        $this->load->database();
        $logs = $this->db->query($sql)->result();

        $this->db->close();

        return $logs;
    }

    public function getJobCostHistoryDataTotal($filter = false, $company, $proposalId)
    {

        $companyId = $company->getCompanyId();

        $sql = "SELECT COUNT(*) AS total
        FROM `log` l
        left join accounts a on l.account = a.accountId AND a.company = {$companyId}
        left join clients c on l.client = c.clientId AND c.company = {$companyId}
        left join client_companies cc on c.client_account = cc.id
        left join proposals p on l.proposal = p.proposalId 
        left join clients as cl on p.client = cl.clientId AND cl.company = {$companyId}
        where l.company = {$companyId} AND l.proposal = {$proposalId} AND l.action ='mobile_job_costing'";


        // if (!$this->hasFullAccess() || $this->uri->segment(3)) {
        //     $account = ($this->uri->segment(3)) ? $this->uri->segment(3) : $this->getAccountId();
        //     $sql .= " AND (
        //     (l.account = {$account}) or (((p.client in (select clients.clientId from clients where clients.account = {$account})) or (p.owner = {$account})) and l.account is null)
        //     )";
        // }

        if ($filter) {
            // Search
            if ($this->input->get('sSearch')) {
                $sql .= " AND ( (a.firstName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (a.lastName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (cc.name like \"%" . $this->input->get('sSearch') . "%\")
                    OR (c.lastName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (c.firstName like \"%" . $this->input->get('sSearch') . "%\")
                    OR (l.details like \"%" . $this->input->get('sSearch') . "%\")
                    OR (CONCAT(c.firstName, ' ', c.lastName) like \"%" . $this->input->get('sSearch') . "%\")
                    OR (p.projectName like \"%" . $this->input->get('sSearch') . "%\"))";
            }
        }

        $this->load->database();
        $total = $this->db->query($sql)->result();
        $this->db->close();
        $total = $total[0];

        return $total->total;
    }

    public function getResendProspectsIds($resendId)
    {
        $out = [];
        $sql = "SELECT DISTINCT(pgre.prospect_id)
        FROM `prospect_group_resend_email` pgre";
        $CI = &get_instance();
        $account = $CI->em->findAccount($this->getAccountId());
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch

            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed =0";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            prospects p1 ON pgre.prospect_id = p1.prospectId 
            LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed =0 AND a2.branch = " . $account->getBranch();
        } else {

            $sql .= " LEFT JOIN
            prospects ON pgre.prospect_id = prospects.prospectId WHERE pgre.resend_id ={$resendId}
            AND pgre.is_failed =0 AND 
                    prospects.account = " . $account->getAccountId();
        }
        //WHERE resend_id ={$resendId}";
        $this->load->database();
        $results = $this->db->query($sql)->result();
        $this->db->close();
        foreach ($results as $result) {
            $out[] = $result->prospect_id;
        }
        return $out;
    }

    public function getResendFailedProspectsIds($resendId)
    {

        $out = [];
        $sql = "SELECT DISTINCT(pgre.prospect_id)
        FROM `prospect_group_resend_email` pgre";
        $CI = &get_instance();
        $account = $CI->em->findAccount($this->getAccountId());
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 1";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            prospects p1 ON pgre.prospect_id = p1.prospectId
            LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 1 AND a2.branch = " . $account->getBranch();
        } else {

            $sql .= " LEFT JOIN
            prospects ON pgre.prospect_id = prospects.prospectId WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 1
                    AND 
                    prospects.account = " . $account->getAccountId();
        }

        // WHERE resend_id ={$resendId}";
        $this->load->database();

        $results = $this->db->query($sql)->result();
        $this->db->close();
        foreach ($results as $result) {
            $out[] = $result->prospect_id;
        }
        return $out;
    }

    public function getStatsProposalsData($action = '', $count = false)
    {
        $this->load->database();


        // Base query
        $sql = 'SELECT DISTINCT proposals.proposalId,proposals.owner, proposals.projectName, proposals.projectAddress, proposals.projectCity, proposals.projectState, proposals.projectZip, proposals.price, proposals.jobNumber, proposals.created, proposals.status, proposals.duplicateOf, proposals.approvalQueue, proposals.declined, proposals.proposalStatus, proposals.last_activity, proposals.email_status, proposals.deliveryTime, proposals.lastOpenTime, proposals.emailSendTime, proposals.audit_key, proposals.audit_view_time, proposals.audit_reminder_sent, proposals.win_date, proposals.QBID, proposals.unapproved_services, proposals.lat, proposals.lng, proposals.access_key,proposals.estimate_status_id,proposals.job_cost_status,proposals.profit_margin_value,proposals.profit_margin_percent, proposals.image_count,proposals.is_hidden_to_view,proposals.business_type_id,proposals.approved,proposals.layout as proposal_layout,proposals.resend_excluded,proposals.note_count as ncount,proposals.signature_id,proposals.company_signature_id,proposals.proposal_view_count,proposals.owner,proposals.company_id,proposals.resend_enabled,
        accounts.firstName as accountFN, accounts.lastName as accountLN, accounts.branch, accounts.accountId as account,accounts.layout as owner_layout,
        client_companies.name as clientAccountName,
        clients.clientId, clients.title as clientTitle, clients.firstName as clientFN, clients.lastName as clientLN, clients.businessPhone as clientBP, clients.cellPhone as clientCP, clients.companyName as clientCompany, clients.quickbooksId as clientQuickbooksId, clients.email as clientEmail,
        statuses.text as statusText,statuses.sales as is_sales,statuses.color as statusColor';

        $sqlCounter = 'SELECT COUNT(DISTINCT proposals.proposalId) AS total';

        $joins = ' FROM proposals
            LEFT JOIN clients on proposals.client = clients.clientId
            LEFT JOIN client_companies on clients.client_account = client_companies.id
            LEFT JOIN companies on clients.company = companies.companyId
            LEFT JOIN accounts on proposals.owner = accounts.accountId
            LEFT JOIN statuses on proposals.proposalStatus = statuses.id';

        $sql .= $joins;
        $sqlCounter .= $joins;

        // Join required for services so add here //
        $serviceJoin = false;
        // Check for status filters first as these are temporary
        if ($action == 'status') {
            if ($this->session->userdata('pStatusFilter') && $this->session->userdata('pStatusFilterService')) {
                $serviceJoin = true;
            }
        }   // Standard proposals join
        else {
            if ($this->session->userdata('pFilter') && $this->session->userdata('psttFilterService') && $action != 'search') {
                $serviceJoin = true;
            }
        }

        if ($serviceJoin) {
            $sql .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
            $sqlCounter .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
        }

        if ($this->session->userdata('pStatsFilterAccountsType')) {
            $sql .= " WHERE client_companies.owner_company='" . $this->getCompany()->getCompanyId() . "'";

            $sqlCounter .= " WHERE  client_companies.owner_company='" . $this->getCompany()->getCompanyId() . "'";
            if ($this->session->userdata('pStatsFilterAccountsType') == 'branch') {

                $sql .= " AND (accounts.branch = " . $this->session->userdata('pStatsFilterBranchId') . ")";
                $sqlCounter .= " AND (accounts.branch = " . $this->session->userdata('pStatsFilterBranchId') . ")";
            }
        } else {
            if($this->session->userdata('pStatsFilterUser')){
                $sql .= " WHERE  proposals.owner = '" . $this->session->userdata('pStatsFilterUser') . "'
                AND client_companies.owner_company='" . $this->getCompany()->getCompanyId() . "'";
    
                $sqlCounter .= " WHERE  proposals.owner = '" . $this->session->userdata('pStatsFilterUser') . "'
                AND client_companies.owner_company='" . $this->getCompany()->getCompanyId() . "'";
            }else{
                $sql .= " WHERE client_companies.owner_company='" . $this->getCompany()->getCompanyId() . "'";

            $sqlCounter .= " WHERE client_companies.owner_company='" . $this->getCompany()->getCompanyId() . "'";
            }
            
        }
        
        if ($this->session->userdata('pStatsFilterClientAccount')) {
            
            $sql .= " AND clients.client_account = " . $this->session->userdata('pStatsFilterClientAccount');
            $sqlCounter .= " AND clients.client_account = " . $this->session->userdata('pStatsFilterClientAccount');
        }
        
        if ($this->session->userdata('pStatsFilterBusinessType')) {
            $sql .= " AND  proposals.business_type_id  = " . $this->session->userdata('pStatsFilterBusinessType');
            $sqlCounter .= " AND  proposals.business_type_id  = " . $this->session->userdata('pStatsFilterBusinessType');
        }
        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
            if ($this->session->userdata('pWon')) {
                $sql .= " AND (proposals.win_date >= " . $start . " AND proposals.win_date <= " . $end . ")";
                $sqlCounter .= " AND (proposals.win_date >= " . $start . " AND proposals.win_date <= " . $end . ")";
            } else {
                $sql .= " AND (proposals.created >= " . $start . " AND proposals.created <= " . $end . ")";
                $sqlCounter .= " AND (proposals.created >= " . $start . " AND proposals.created <= " . $end . ")";
            }
        }

        if ($this->session->userdata('pStatsFilterStatusId')) {
            $sql .= " and (proposals.proposalStatus = '" . $this->session->userdata('pStatsFilterStatusId') . "')";
            $sqlCounter .= " and (proposals.proposalStatus = '" . $this->session->userdata('pStatsFilterStatusId') . "')";
        }
        if ($this->session->userdata('pStatsFilterStatusName')) {
            if ($this->session->userdata('pStatsFilterStatusName') == 'open') {
                $sql .= " and proposals.proposalStatus = 1";
                $sqlCounter .= " and proposals.proposalStatus = 1";
            } else if ($this->session->userdata('pStatsFilterStatusName') == 'won_rate') {
                $sql .= " and statuses.sales = 1";
                $sqlCounter .= " and statuses.sales = 1";
            } else if ($this->session->userdata('pStatsFilterStatusName') == 'won') {
                $sql .= " and statuses.sales = 1";
                $sqlCounter .= " and statuses.sales = 1";
            } else if ($this->session->userdata('pStatsFilterStatusName') == 'other') {
                $sql .= " and statuses.sales != 1 and statuses.id != 1";
                $sqlCounter .= " and statuses.sales != 1 and statuses.id != 1";
            }
        }
        
        // }

        // Search
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
            if ($search['value']  != '') {
                $searchQuery = " AND ( (proposals.projectName like \"%" . $search['value'] . "%\")
                    OR (clients.email like \"%" . $search['value'] . "%\")
                    OR (client_companies.name like \"%" . $search['value'] . "%\")
                    OR (clients.lastName like \"%" . $search['value'] . "%\")
                    OR (clients.firstName like \"%" . $search['value'] . "%\")
                    OR (proposals.projectAddress like \"%" . $search['value'] . "%\")
                    OR (proposals.projectCity like \"%" . $search['value'] . "%\")
                    OR (proposals.projectState like \"%" . $search['value'] . "%\")
                    OR (proposals.projectZip like \"%" . $search['value'] . "%\")
                    OR (proposals.jobNumber like \"%" . $search['value'] . "%\"))";

                $sql .= $searchQuery;
                $sqlCounter .= $searchQuery;
            }
        }

        ///FILTER
        if ($this->session->userdata('pStatsFilter')) {

            ///adding for new filter by sunil


            // Filters

            if ($this->session->userdata('pFilter') && $action != 'search') {

                // Proposal Status
                if ($this->session->userdata('psttFilterStatus')) {
                    //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                    $sql .= " and (proposals.proposalStatus IN (" . implode(
                        ', ',
                        $this->session->userdata('psttFilterStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.proposalStatus IN (" . implode(
                        ', ',
                        $this->session->userdata('psttFilterStatus')
                    ) . "))";
                } else {
                    $sql .= " AND statuses.prospect = 0";
                    $sqlCounter .= " AND statuses.prospect = 0";
                }

                // Estimate Status
                if ($this->session->userdata('pFilterEstimateStatus')) {
                    $sql .= " and (proposals.estimate_status_id IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterEstimateStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.estimate_status_id IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterEstimateStatus')
                    ) . "))";
                }

                // job Cost Status
                if ($this->session->userdata('pFilterJobCostStatus')) {
                    $sql .= " and (proposals.job_cost_status IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterJobCostStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.job_cost_status IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterJobCostStatus')
                    ) . "))";
                }
                // User
                if ($this->session->userdata('psttFilterUser')) {
                    $sql .= " and (proposals.owner IN (" . implode(
                        ', ',
                        $this->session->userdata('psttFilterUser')
                    ) . "))";
                    $sqlCounter .= " and (proposals.owner IN (" . implode(
                        ', ',
                        $this->session->userdata('psttFilterUser')
                    ) . "))";
                } else {
                    if ($this->session->userdata('psttFilterBranch')) {
                        $sql .= " and (accounts.branch IN (" . implode(
                            ', ',
                            $this->session->userdata('psttFilterBranch')
                        ) . "))";
                        $sqlCounter .= " and (accounts.branch IN (" . implode(
                            ', ',
                            $this->session->userdata('psttFilterBranch')
                        ) . "))";
                    }
                }
                // Account
                if ($this->session->userdata('psttFilterClientAccount')) {
                    $sql .= " AND (clients.client_account IN (" . implode(
                        ',',
                        $this->session->userdata('psttFilterClientAccount')
                    ) . "))";
                    $sqlCounter .= " AND (clients.client_account IN (" . implode(
                        ',',
                        $this->session->userdata('psttFilterClientAccount')
                    ) . "))";
                }
                // Created Date from
                if ($this->session->userdata('psttCreatedFrom')) {
                    $start = $this->session->userdata('psttCreatedFrom');
                    $sql .= " AND (proposals.created >= {$start})";
                    $sqlCounter .= " AND (proposals.created >= {$start})";
                }
                // Created Date To
                if ($this->session->userdata('psttCreatedTo')) {
                    $end = $this->session->userdata('psttCreatedTo');
                    $sql .= " AND (proposals.created <= {$end})";
                    $sqlCounter .= " AND (proposals.created <= {$end})";
                }
                // Activity Date from
                if ($this->session->userdata('psttActivityFrom')) {
                    $laStart = $this->session->userdata('psttActivityFrom');
                    $sql .= " AND (proposals.last_activity >= {$laStart})";
                    $sqlCounter .= " AND (proposals.last_activity >= {$laStart})";
                }
                // Activity Date To
                if ($this->session->userdata('psttActivityTo')) {
                    $laEnd = $this->session->userdata('psttActivityTo');
                    $sql .= " AND (proposals.last_activity <= {$laEnd})";
                    $sqlCounter .= " AND (proposals.last_activity <= {$laEnd})";
                }

                // Won Date from
                if ($this->session->userdata('psttWonFrom')) {
                    $wonStart = $this->session->userdata('psttWonFrom');
                    $sql .= " AND (proposals.win_date >= {$wonStart})";
                    $sqlCounter .= " AND (proposals.win_date >= {$wonStart})";
                }
                // Won Date To
                if ($this->session->userdata('psttWonTo')) {
                    $wonEnd = $this->session->userdata('psttWonTo');
                    $sql .= " AND (proposals.win_date <= {$wonEnd})";
                    $sqlCounter .= " AND (proposals.win_date <= {$wonEnd})";
                }

                if ($this->session->userdata('psttFilterService')) {
                    $sql .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('psttFilterService')
                    ) . "))";
                    $sqlCounter .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('psttFilterService')
                    ) . "))";
                }
                if ($this->session->userdata('psttFilterQueue')) {

                    $addOr = false;
                    $sql .= ' AND (';
                    $sqlCounter .= ' AND (';

                    if (in_array('duplicate', $this->session->userdata('psttFilterQueue'))) {
                        $addOr = true;
                        $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                        $sqlCounter .= ' (proposals.duplicateOf IS NOT NULL)';
                    }

                    if (in_array(1, $this->session->userdata('psttFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.approvalQueue = 1)';
                        $sqlCounter .= ' (proposals.approvalQueue = 1)';
                        $addOr = true;
                    }

                    if (in_array(2, $this->session->userdata('psttFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.declined = 1)';
                        $sqlCounter .= ' (proposals.declined = 1)';
                        $addOr = true;
                    }

                    if (in_array('unapproved', $this->session->userdata('psttFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.unapproved_services = 1)';
                        $sqlCounter .= ' (proposals.unapproved_services = 1)';
                    }

                    $sql .= ')';
                    $sqlCounter .= ')';
                }
                if ($this->session->userdata('psttFilterEmailStatus')) {

                    $addOr = false;
                    $sql .= ' AND (';
                    $sqlCounter .= ' AND (';

                    if (in_array('o', $this->session->userdata('psttFilterEmailStatus'))) {
                        $addOr = true;
                        $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.lastOpenTime IS NOT NULL)';
                    }

                    if (in_array('d', $this->session->userdata('psttFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.deliveryTime IS NOT NULL)';
                        $addOr = true;
                    }

                    if (in_array('u', $this->session->userdata('psttFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                            AND proposals.deliveryTime IS NULL)';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                            AND proposals.deliveryTime IS NULL)';
                        $addOr = true;
                    }

                    if (in_array('uo', $this->session->userdata('psttFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                            AND proposals.deliveryTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                            AND proposals.deliveryTime IS NOT NULL)';
                    }
                    if (in_array('us', $this->session->userdata('psttFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                    }

                    $sql .= ')';
                    $sqlCounter .= ')';
                }


                if ($this->session->userdata('psttFilterMinBid')) {
                    if ($this->session->userdata('psttFilterMinBid') != 0) {
                        $sql .= ' AND (proposals.price >= ' . $this->session->userdata('psttFilterMinBid');
                        $sqlCounter .= ' AND (proposals.price >= ' . $this->session->userdata('psttFilterMinBid');
                        if (!$this->session->userdata('psttFilterMaxBid')) {
                            $sql .= ' OR proposals.price IS NULL)';
                            $sqlCounter .= ' OR proposals.price IS NULL)';
                        } else {
                            $sql .= ')';
                            $sqlCounter .= ')';
                        }
                    }
                }

                if ($this->session->userdata('psttFilterMaxBid')) {
                    if ($this->session->userdata('psttFilterMaxBid') != $this->getCompany()->getHighestBid()) {
                        $sql .= ' AND (proposals.price <= ' . $this->session->userdata('psttFilterMaxBid');
                        $sqlCounter .= ' AND (proposals.price <= ' . $this->session->userdata('psttFilterMaxBid');
                        if (!$this->session->userdata('psttFilterMinBid')) {
                            $sql .= ' OR proposals.price IS NULL)';
                            $sqlCounter .= ' OR proposals.price IS NULL)';
                        } else {
                            $sql .= ')';
                            $sqlCounter .= ')';
                        }
                    }
                }

                if ($this->session->userdata('psttFilterBusinessType')) {
                    //echo 'test';die;
                    $types = implode(',', $this->session->userdata('psttFilterBusinessType'));
                    $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                    $sqlCounter .= ' AND proposals.business_type_id IN (' . $types . ')';
                    //echo $sql ;die;
                }

                
                
                
                if ($this->session->userdata('psttResendExclude') == '1' && $this->session->userdata('psttResendInclude') == '1' || $this->session->userdata('psttResendExclude') == '0' && $this->session->userdata('psttResendInclude') == '0') {
                } else {
                    if ($this->session->userdata('psttResendExclude')=='1') {

                        $sql .= ' AND proposals.resend_excluded =1';
                        $sqlCounter .= ' AND proposals.resend_excluded =1';
                    }
                    if ($this->session->userdata('psttResendInclude')=='1') {

                        $sql .= ' AND proposals.resend_excluded =0';
                        $sqlCounter .= ' AND proposals.resend_excluded =0';
                    }
                }

                if ($this->session->userdata('psttUnsigned') == '1' && $this->session->userdata('psttSigned') == '1' || $this->session->userdata('psttUnsigned') == '0' && $this->session->userdata('psttSigned') == '0') {
                } else {
                    if ($this->session->userdata('psttSigned')=='1') {

                        $sql .= ' AND proposals.signature_id IS NOT NULL';
                        $sqlCounter .= ' AND proposals.signature_id IS NOT NULL';
                    }
                    if ($this->session->userdata('psttUnsigned')=='1') {

                        $sql .= ' AND proposals.signature_id IS NULL';
                        $sqlCounter .= ' AND proposals.signature_id IS NULL';
                    }
                }

                if ($this->session->userdata('psttCompanyUnsigned') == '1' && $this->session->userdata('psttCompanySigned') == '1' || $this->session->userdata('psttCompanyUnsigned') == '0' && $this->session->userdata('psttCompanySigned') == '0') {
                } else {
                    if ($this->session->userdata('psttCompanySigned')=='1') {

                        $sql .= ' AND proposals.company_signature_id IS NOT NULL';
                        $sqlCounter .= ' AND proposals.company_signature_id IS NOT NULL';
                    }
                    if ($this->session->userdata('psttCompanyUnsigned')=='1') {

                        $sql .= ' AND proposals.company_signature_id IS NULL';
                        $sqlCounter .= ' AND proposals.company_signature_id IS NULL';
                    }
                }

            }


            //// end filter added by sunil


        }
        
        ///SORTING
        $order = $this->input->get('order');

        switch ($order[0]['column']) {
            case 2: // date
                $sql .= ' ORDER BY proposals.created ' . $order[0]['dir'];
                break;
            case 3: // status
                $sql .= ' ORDER BY statusText ' . $order[0]['dir'];
                break;
            case 4: // Win date
                $sql .= ' ORDER BY proposals.win_date ' . $order[0]['dir'];
                break;
            case 5: // job Number
                $sql .= ' ORDER BY lpad(proposals.jobNumber, 10, 0) ' . $order[0]['dir'];
                break;
            case 6: // Client Account Name
                $sql .= ' ORDER BY client_companies.name ' . $order[0]['dir'];
                break;
            case 7: // Project Name
                $sql .= ' ORDER BY proposals.projectName ' . $order[0]['dir'];
                break;
            case 8: // Image Count
                $sql .= ' ORDER BY proposals.image_count ' . $order[0]['dir'];
                break;
            case 9: // Price
                $sql .= ' ORDER BY proposals.price ' . $order[0]['dir'];
                break;
            case 10: // Contact
                $sql .= ' ORDER BY clients.firstName ' . $order[0]['dir'];
                break;
            case 11: // Owner
                $sql .= ' ORDER BY accounts.firstName ' . $order[0]['dir'];
                break;
            case 12: // Last Activity
                $sql .= ' ORDER BY proposals.last_activity ' . $order[0]['dir'] . ' , proposals.created DESC';
                break;
            case 13: // Email Status
                $sql .= ' ORDER BY proposals.email_status ' . $order[0]['dir'];
                break;
            case 14: // Delivery Status
                $sql .= ' ORDER BY proposals.deliveryTime ' . $order[0]['dir'];
                break;
            case 15: // Open Status
                $sql .= ' ORDER BY proposals.lastOpenTime ' . $order[0]['dir'];
                break;
            case 16: // Audit View Time
                $sql .= ' ORDER BY proposals.audit_view_time ' . $order[0]['dir'] . ', proposals.audit_key ' . $this->input->get('sSortDir_0');
                break;
            case 17: // Estimate type View
                $sql .= ' ORDER BY proposals.estimate_status_id ' . $order[0]['dir'];
                break;
        }

        // Limit for paging
        $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');

        if ($count) {
            return $this->db->query($sqlCounter)->result();
        }
        
        
        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;

    }


    public function getAccStatsProposalsData($action = '', $count = false)
    {
        $this->load->database();


        // Base query
        $sql = 'SELECT DISTINCT proposals.proposalId,proposals.owner, proposals.projectName, proposals.projectAddress, proposals.projectCity, proposals.projectState, proposals.projectZip, proposals.price, proposals.jobNumber, proposals.created, proposals.status, proposals.duplicateOf, proposals.approvalQueue, proposals.declined, proposals.proposalStatus, proposals.last_activity, proposals.email_status, proposals.deliveryTime, proposals.lastOpenTime, proposals.emailSendTime, proposals.audit_key, proposals.audit_view_time, proposals.audit_reminder_sent, proposals.win_date, proposals.QBID, proposals.unapproved_services, proposals.lat, proposals.lng, proposals.access_key,proposals.estimate_status_id,proposals.job_cost_status,proposals.profit_margin_value,proposals.profit_margin_percent, proposals.image_count,proposals.is_hidden_to_view,proposals.business_type_id,proposals.approved,proposals.layout as proposal_layout,proposals.resend_excluded,proposals.note_count as ncount,proposals.signature_id,proposals.company_signature_id,proposals.proposal_view_count,proposals.owner,proposals.company_id,proposals.resend_enabled,
        accounts.firstName as accountFN, accounts.lastName as accountLN, accounts.branch, accounts.accountId as account,accounts.layout as owner_layout,
        client_companies.name as clientAccountName,
        clients.clientId, clients.title as clientTitle, clients.firstName as clientFN, clients.lastName as clientLN, clients.businessPhone as clientBP, clients.cellPhone as clientCP, clients.companyName as clientCompany, clients.quickbooksId as clientQuickbooksId, clients.email as clientEmail,
        statuses.text as statusText,statuses.sales as is_sales,statuses.color as statusColor';

        $sqlCounter = 'SELECT COUNT(DISTINCT proposals.proposalId) AS total';

        $joins = ' FROM proposals
            LEFT JOIN clients on proposals.client = clients.clientId
            LEFT JOIN client_companies on clients.client_account = client_companies.id
            LEFT JOIN companies on clients.company = companies.companyId
            LEFT JOIN accounts on proposals.owner = accounts.accountId
            LEFT JOIN statuses on proposals.proposalStatus = statuses.id';

        $sql .= $joins;
        $sqlCounter .= $joins;

        // Join required for services so add here //
        $serviceJoin = false;
        // Check for status filters first as these are temporary
        if ($action == 'status') {
            if ($this->session->userdata('pStatusFilter') && $this->session->userdata('pStatusFilterService')) {
                $serviceJoin = true;
            }
        }   // Standard proposals join
        else {
            if ($this->session->userdata('pFilter') && $this->session->userdata('pastFilterService') && $action != 'search') {
                $serviceJoin = true;
            }
        }

        if ($serviceJoin) {
            $sql .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
            $sqlCounter .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
        }

        //if ($this->session->userdata('pStatsFilterClientAccount')) {
        $sql .= " WHERE clients.client_account = '" . $this->session->userdata('pStatsFilterClientAccount') . "'
            
            AND client_companies.owner_company='" . $this->getCompany()->getCompanyId() . "'";

        $sqlCounter .= " WHERE clients.client_account = '" . $this->session->userdata('pStatsFilterClientAccount') . "'
            
            AND client_companies.owner_company='" . $this->getCompany()->getCompanyId() . "'";


        if ($this->session->userdata('pAccFilterBusinessType')) {
            $sql .= " AND  proposals.business_type_id  = " . $this->session->userdata('pAccFilterBusinessType');
            $sqlCounter .= " AND  proposals.business_type_id  = " . $this->session->userdata('pAccFilterBusinessType');
        }
        if ($this->session->userdata('pAccStatsFilterStatusId')) {
            $sql .= " and (proposals.proposalStatus = '" . $this->session->userdata('pAccStatsFilterStatusId') . "')";
            $sqlCounter .= " and (proposals.proposalStatus = '" . $this->session->userdata('pAccStatsFilterStatusId') . "')";
        }

        if ($this->session->userdata('pAccStatsFilterStatusName')) {
            if ($this->session->userdata('pAccStatsFilterStatusName') == 'open') {
                $sql .= " and proposals.proposalStatus = 1";
                $sqlCounter .= " and proposals.proposalStatus = 1";
            } else if ($this->session->userdata('pAccStatsFilterStatusName') == 'won') {
                $sql .= " and statuses.sales = 1";
                $sqlCounter .= " and statuses.sales = 1";
                if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
                    $from = explode('/', $this->session->userdata('accFilterFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $to = explode('/', $this->session->userdata('accFilterTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    if ($this->session->userdata('pWon')) {
                        $sql .= " AND (proposals.win_date >= " . $start . " AND proposals.win_date <= " . $end . ")";
                        $sqlCounter .= " AND (proposals.win_date >= " . $start . " AND proposals.win_date <= " . $end . ")";
                    } else {
                        $sql .= " AND (proposals.created >= " . $start . " AND proposals.created <= " . $end . ")";
                        $sqlCounter .= " AND (proposals.created >= " . $start . " AND proposals.created <= " . $end . ")";
                    }
                }
            } else if ($this->session->userdata('pAccStatsFilterStatusName') == 'other') {
                $sql .= " and statuses.sales != 1 and statuses.id != 1";
                $sqlCounter .= " and statuses.sales != 1 and statuses.id != 1";
            }
        }

        if ($this->session->userdata('pAccStatsFilterStatusName') != 'won') {
            if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
                $from = explode('/', $this->session->userdata('accFilterFrom'));
                $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                $to = explode('/', $this->session->userdata('accFilterTo'));
                $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

                $sql .= " AND (proposals.created >= " . $start . " AND proposals.created <= " . $end . ")";
                $sqlCounter .= " AND (proposals.created >= " . $start . " AND proposals.created <= " . $end . ")";
            }
        }
        // if ($this->session->userdata('pStatsFilterStatusName')) {
        //     if($this->session->userdata('pStatsFilterStatusName')=='open'){
        //         $sql .= " and proposals.proposalStatus = 1";
        //         $sqlCounter .= " and proposals.proposalStatus = 1";
        //     }else if($this->session->userdata('pStatsFilterStatusName')=='won'){
        //         $sql .= " and statuses.sales = 1";
        //         $sqlCounter .= " and statuses.sales = 1";
        //     }else if($this->session->userdata('pStatsFilterStatusName')=='other'){
        //         $sql .= " and statuses.sales != 1 and statuses.id != 1";
        //         $sqlCounter .= " and statuses.sales != 1 and statuses.id != 1";
        //     }

        // }

        // }
        if ($this->session->userdata('pAccStatsFilterUser')) {

            $user_ids = implode(',', $this->session->userdata('pAccStatsFilterUser'));

            $sql .= " and proposals.owner IN (" . $user_ids . ")";
            $sqlCounter .= " and proposals.owner IN (" . $user_ids . ")";
        }


        // Search
        if ($this->input->get('search')) {
            $search = $this->input->get('search');
            if ($search['value'] != '') {
                $searchQuery = " AND ( (proposals.projectName like \"%" . $search['value'] . "%\")
                        OR (clients.email like \"%" . $search['value'] . "%\")
                        OR (client_companies.name like \"%" . $search['value'] . "%\")
                        OR (clients.lastName like \"%" . $search['value'] . "%\")
                        OR (clients.firstName like \"%" . $search['value'] . "%\")
                        OR (proposals.projectAddress like \"%" . $search['value'] . "%\")
                        OR (proposals.projectCity like \"%" . $search['value'] . "%\")
                        OR (proposals.projectState like \"%" . $search['value'] . "%\")
                        OR (proposals.projectZip like \"%" . $search['value'] . "%\")
                        OR (proposals.jobNumber like \"%" . $search['value'] . "%\"))";

                $sql .= $searchQuery;
                $sqlCounter .= $searchQuery;
            }
        }

        ///FILTER
        if ($this->session->userdata('pAccStatsFilter')) {

            ///adding for new filter by sunil


            // Filters

            if ($this->session->userdata('pFilter') && $action != 'search') {

                // Proposal Status
                if ($this->session->userdata('pastFilterStatus')) {
                    //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                    $sql .= " and (proposals.proposalStatus IN (" . implode(
                        ', ',
                        $this->session->userdata('pastFilterStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.proposalStatus IN (" . implode(
                        ', ',
                        $this->session->userdata('pastFilterStatus')
                    ) . "))";
                } else {
                    $sql .= " AND statuses.prospect = 0";
                    $sqlCounter .= " AND statuses.prospect = 0";
                }

                // Estimate Status
                if ($this->session->userdata('pFilterEstimateStatus')) {
                    $sql .= " and (proposals.estimate_status_id IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterEstimateStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.estimate_status_id IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterEstimateStatus')
                    ) . "))";
                }

                // job Cost Status
                if ($this->session->userdata('pFilterJobCostStatus')) {
                    $sql .= " and (proposals.job_cost_status IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterJobCostStatus')
                    ) . "))";
                    $sqlCounter .= " and (proposals.job_cost_status IN (" . implode(
                        ', ',
                        $this->session->userdata('pFilterJobCostStatus')
                    ) . "))";
                }
                // User
                if ($this->session->userdata('pastFilterUser')) {
                    $sql .= " and (proposals.owner IN (" . implode(
                        ', ',
                        $this->session->userdata('pastFilterUser')
                    ) . "))";
                    $sqlCounter .= " and (proposals.owner IN (" . implode(
                        ', ',
                        $this->session->userdata('pastFilterUser')
                    ) . "))";
                } else {
                    if ($this->session->userdata('pastFilterBranch')) {
                        $sql .= " and (accounts.branch IN (" . implode(
                            ', ',
                            $this->session->userdata('pastFilterBranch')
                        ) . "))";
                        $sqlCounter .= " and (accounts.branch IN (" . implode(
                            ', ',
                            $this->session->userdata('pastFilterBranch')
                        ) . "))";
                    }
                }
                // Account
                if ($this->session->userdata('pastFilterClientAccount')) {
                    $sql .= " AND (clients.client_account IN (" . implode(
                        ',',
                        $this->session->userdata('pastFilterClientAccount')
                    ) . "))";
                    $sqlCounter .= " AND (clients.client_account IN (" . implode(
                        ',',
                        $this->session->userdata('pastFilterClientAccount')
                    ) . "))";
                }
                // Created Date from
                if ($this->session->userdata('pastCreatedFrom')) {
                    $start = $this->session->userdata('pastCreatedFrom');
                    $sql .= " AND (proposals.created >= {$start})";
                    $sqlCounter .= " AND (proposals.created >= {$start})";
                }
                // Created Date To
                if ($this->session->userdata('pastCreatedTo')) {
                    $end = $this->session->userdata('pastCreatedTo');
                    $sql .= " AND (proposals.created <= {$end})";
                    $sqlCounter .= " AND (proposals.created <= {$end})";
                }
                // Activity Date from
                if ($this->session->userdata('pastActivityFrom')) {
                    $laStart = $this->session->userdata('pastActivityFrom');
                    $sql .= " AND (proposals.last_activity >= {$laStart})";
                    $sqlCounter .= " AND (proposals.last_activity >= {$laStart})";
                }
                // Activity Date To
                if ($this->session->userdata('pastActivityTo')) {
                    $laEnd = $this->session->userdata('pastActivityTo');
                    $sql .= " AND (proposals.last_activity <= {$laEnd})";
                    $sqlCounter .= " AND (proposals.last_activity <= {$laEnd})";
                }

                // Won Date from
                if ($this->session->userdata('pastWonFrom')) {
                    $wonStart = $this->session->userdata('pastWonFrom');
                    $sql .= " AND (proposals.win_date >= {$wonStart})";
                    $sqlCounter .= " AND (proposals.win_date >= {$wonStart})";
                }
                // Won Date To
                if ($this->session->userdata('pastWonTo')) {
                    $wonEnd = $this->session->userdata('pastWonTo');
                    $sql .= " AND (proposals.win_date <= {$wonEnd})";
                    $sqlCounter .= " AND (proposals.win_date <= {$wonEnd})";
                }

                if ($this->session->userdata('pastFilterService')) {
                    $sql .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('pastFilterService')
                    ) . "))";
                    $sqlCounter .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('pastFilterService')
                    ) . "))";
                }
                if ($this->session->userdata('pastFilterQueue')) {

                    $addOr = false;
                    $sql .= ' AND (';
                    $sqlCounter .= ' AND (';

                    if (in_array('duplicate', $this->session->userdata('pastFilterQueue'))) {
                        $addOr = true;
                        $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                        $sqlCounter .= ' (proposals.duplicateOf IS NOT NULL)';
                    }

                    if (in_array(1, $this->session->userdata('pastFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.approvalQueue = 1)';
                        $sqlCounter .= ' (proposals.approvalQueue = 1)';
                        $addOr = true;
                    }

                    if (in_array(2, $this->session->userdata('pastFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.declined = 1)';
                        $sqlCounter .= ' (proposals.declined = 1)';
                        $addOr = true;
                    }

                    if (in_array('unapproved', $this->session->userdata('pastFilterQueue'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.unapproved_services = 1)';
                        $sqlCounter .= ' (proposals.unapproved_services = 1)';
                    }

                    $sql .= ')';
                    $sqlCounter .= ')';
                }
                if ($this->session->userdata('pastFilterEmailStatus')) {

                    $addOr = false;
                    $sql .= ' AND (';
                    $sqlCounter .= ' AND (';

                    if (in_array('o', $this->session->userdata('pastFilterEmailStatus'))) {
                        $addOr = true;
                        $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.lastOpenTime IS NOT NULL)';
                    }

                    if (in_array('d', $this->session->userdata('pastFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.deliveryTime IS NOT NULL)';
                        $addOr = true;
                    }

                    if (in_array('u', $this->session->userdata('pastFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                            AND proposals.deliveryTime IS NULL)';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                            AND proposals.deliveryTime IS NULL)';
                        $addOr = true;
                    }

                    if (in_array('uo', $this->session->userdata('pastFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                            AND proposals.deliveryTime IS NOT NULL)';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                            AND proposals.deliveryTime IS NOT NULL)';
                    }
                    if (in_array('us', $this->session->userdata('pastFilterEmailStatus'))) {
                        if ($addOr) {
                            $sql .= ' OR';
                            $sqlCounter .= ' OR';
                        }
                        $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                        $sqlCounter .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                    }

                    $sql .= ')';
                    $sqlCounter .= ')';
                }


                if ($this->session->userdata('pastFilterMinBid')) {
                    if ($this->session->userdata('pastFilterMinBid') != 0) {
                        $sql .= ' AND (proposals.price >= ' . $this->session->userdata('pastFilterMinBid');
                        $sqlCounter .= ' AND (proposals.price >= ' . $this->session->userdata('pastFilterMinBid');
                        if (!$this->session->userdata('pastFilterMaxBid')) {
                            $sql .= ' OR proposals.price IS NULL)';
                            $sqlCounter .= ' OR proposals.price IS NULL)';
                        } else {
                            $sql .= ')';
                            $sqlCounter .= ')';
                        }
                    }
                }

                if ($this->session->userdata('pastFilterMaxBid')) {
                    if ($this->session->userdata('pastFilterMaxBid') != $this->getCompany()->getHighestBid()) {
                        $sql .= ' AND (proposals.price <= ' . $this->session->userdata('pastFilterMaxBid');
                        $sqlCounter .= ' AND (proposals.price <= ' . $this->session->userdata('pastFilterMaxBid');
                        if (!$this->session->userdata('pastFilterMinBid')) {
                            $sql .= ' OR proposals.price IS NULL)';
                            $sqlCounter .= ' OR proposals.price IS NULL)';
                        } else {
                            $sql .= ')';
                            $sqlCounter .= ')';
                        }
                    }
                }

                if ($this->session->userdata('pastFilterBusinessType')) {
                    $types = implode(',', $this->session->userdata('pastFilterBusinessType'));
                    $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                    $sqlCounter .= ' AND proposals.business_type_id IN (' . $types . ')';
                }

                if ($this->session->userdata('pastResendExclude') == '1' && $this->session->userdata('pastResendInclude') == '1' || $this->session->userdata('pastResendExclude') == '0' && $this->session->userdata('pastResendInclude') == '0') {
                } else {
                    if ($this->session->userdata('pastResendExclude')=='1') {

                        $sql .= ' AND proposals.resend_excluded =1';
                        $sqlCounter .= ' AND proposals.resend_excluded =1';
                    }
                    if ($this->session->userdata('pastResendInclude')=='1') {

                        $sql .= ' AND proposals.resend_excluded =0';
                        $sqlCounter .= ' AND proposals.resend_excluded =0';
                    }
                }

                if ($this->session->userdata('pastUnsigned') == '1' && $this->session->userdata('pastSigned') == '1' || $this->session->userdata('pastUnsigned') == '0' && $this->session->userdata('pastSigned') == '0') {
                } else {
                    if ($this->session->userdata('pastSigned')=='1') {

                        $sql .= ' AND proposals.signature_id IS NOT NULL';
                        $sqlCounter .= ' AND proposals.signature_id IS NOT NULL';
                    }
                    if ($this->session->userdata('pastUnsigned')=='1') {

                        $sql .= ' AND proposals.signature_id IS NULL';
                        $sqlCounter .= ' AND proposals.signature_id IS NULL';
                    }
                }

                if ($this->session->userdata('pastCompanyUnsigned') == '1' && $this->session->userdata('pastCompanySigned') == '1' || $this->session->userdata('pastCompanyUnsigned') == '0' && $this->session->userdata('pastCompanySigned') == '0') {
                } else {
                    if ($this->session->userdata('pastCompanySigned')=='1') {

                        $sql .= ' AND proposals.company_signature_id IS NOT NULL';
                        $sqlCounter .= ' AND proposals.company_signature_id IS NOT NULL';
                    }
                    if ($this->session->userdata('pastCompanyUnsigned')=='1') {

                        $sql .= ' AND proposals.company_signature_id IS NULL';
                        $sqlCounter .= ' AND proposals.company_signature_id IS NULL';
                    }
                }
            }


            //// end filter added by sunil
        }
        if ($serviceJoin) {
            // $sql .= ' GROUP BY proposals.proposalId';
            //$sqlCounter .= ' GROUP BY proposals.proposalId';
        }
        ///SORTING
        $order = $this->input->get('order');

        switch ($order[0]['column']) {
            case 2: // date
                $sql .= ' ORDER BY proposals.created ' . $order[0]['dir'];
                break;
            case 3: // status
                $sql .= ' ORDER BY statusText ' . $order[0]['dir'];
                break;
            case 4: // Win date
                $sql .= ' ORDER BY proposals.win_date ' . $order[0]['dir'];
                break;
            case 5: // job Number
                $sql .= ' ORDER BY lpad(proposals.jobNumber, 10, 0) ' . $order[0]['dir'];
                break;
            case 6: // Client Account Name
                $sql .= ' ORDER BY client_companies.name ' . $order[0]['dir'];
                break;
            case 7: // Project Name
                $sql .= ' ORDER BY proposals.projectName ' . $order[0]['dir'];
                break;
            case 8: // Image Count
                $sql .= ' ORDER BY proposals.image_count ' . $order[0]['dir'];
                break;
            case 9: // Price
                $sql .= ' ORDER BY proposals.price ' . $order[0]['dir'];
                break;
            case 10: // Contact
                $sql .= ' ORDER BY clients.firstName ' . $order[0]['dir'];
                break;
            case 11: // Owner
                $sql .= ' ORDER BY accounts.firstName ' . $order[0]['dir'];
                break;
            case 12: // Last Activity
                $sql .= ' ORDER BY proposals.last_activity ' . $order[0]['dir'] . ' , proposals.created DESC';
                break;
            case 13: // Email Status
                $sql .= ' ORDER BY proposals.email_status ' . $order[0]['dir'];
                break;
            case 14: // Delivery Status
                $sql .= ' ORDER BY proposals.deliveryTime ' . $order[0]['dir'];
                break;
            case 15: // Open Status
                $sql .= ' ORDER BY proposals.lastOpenTime ' . $order[0]['dir'];
                break;
            case 16: // Audit View Time
                $sql .= ' ORDER BY proposals.audit_view_time ' . $order[0]['dir'] . ', proposals.audit_key ' . $this->input->get('sSortDir_0');
                break;
            case 17: // Estimate type View
                $sql .= ' ORDER BY proposals.estimate_status_id ' . $order[0]['dir'];
                break;
        }


        // Limit for paging
        $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');

        if ($count) {

            return $this->db->query($sqlCounter)->result();
        }
        
        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }




    public function getOtherSalesValue(array $time)
    {
        $CI = &get_instance();

        $sql = "SELECT SUM(p.price) AS totalVal 
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                -- AND p.statusChangeDate >= :startTime
                -- AND p.statusChangeDate <= :finishTime
                AND s.sales != 1 AND s.id != 1";

        // Raw PDO
        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue('accountId', $this->getAccountId());
        $query->bindValue('startTime', $time['start']);
        $query->bindValue('finishTime', $time['finish']);
        $results = $query->execute();

        $result = $results->fetchAssociative();

        return (float)$result['totalVal'] ?: 0;
    }


    public function getRangePricedCreatedProposals(array $time, $count = false)
    {
        $CI = &get_instance();

        $sql = "SELECT p.proposalId
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.owner = :accountId
                AND p.duplicateOf IS NULL
                -- AND p.price > 0
                AND s.prospect = 0
                AND s.on_hold = 0";

            if($time['start'] != "" && $time['finish'] != ""){
                $sql .=" AND p.created >= :startTime
                AND p.created <= :finishTime ";
            }



        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue(':accountId', $this->getAccountId());
        if($time['start'] != "" && $time['finish'] != ""){

            $query->bindValue(':startTime', $time['start']);
            $query->bindValue(':finishTime', $time['finish']);
        }
        $results = $query->execute();

        $proposalIds = $results->fetchAllAssociative();

        if ($count) {
            return $results->rowCount();
        }

        $proposals = [];
        foreach ($proposalIds as $proposalId) {
            $proposals[] = $this->em->findProposal($proposalId['proposalId']);
        }

        return $proposals;
    }


    public function getUserBusinessTypesTableData($user_id, $count = false)
    {
        $this->load->database();


        $bidCountSubQuery = "(SELECT COUNT(*) FROM proposals p  
        WHERE p.business_type_id = bt.id ";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidCountSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidCountSubQuery .= ' AND p.owner =' . $user_id;

        $bidCountSubQuery .= " ) AS numProposals";



        // Build bid amount subquery
        $bidAmtSubQuery = " (SELECT SUM(p.price) FROM proposals p 
        WHERE p.business_type_id = bt.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidAmtSubQuery .= ' AND p.owner =' . $user_id;

        $bidAmtSubQuery .= " ) AS totalBid";




        // subquery for Sold amount

        $bidSoldAmtSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, statuses st
        WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidSoldAmtSubQuery .= " AND (p.win_date >= " . $start . " AND p.win_date <= " . $end . ")";
        }

        // Show all accounts
        $bidSoldAmtSubQuery .= ' AND p.owner =' . $user_id;


        $bidSoldAmtSubQuery .= " ) AS totalSold";

        // subquery for Sold amount

        $bidWinSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) * 100 / SUM(p.price)  AS percent_total FROM proposals p, statuses st
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";


        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidWinSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidWinSubQuery .= ' AND p.owner =' . $user_id;

        $bidWinSubQuery .= " ) AS percent_total";


        // subquery for Open amount

        $bidOpenAmtSubQuery = " (SELECT SUM(CASE WHEN (st.id = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, statuses st
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOpenAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOpenAmtSubQuery .= ' AND p.owner =' . $user_id;


        $bidOpenAmtSubQuery .= " ) AS totalOpen";

        // subquery for Other total amount

        $bidOtherAmtSubQuery = " (SELECT SUM(CASE WHEN st.id != '1' AND st.sales != '1' THEN p.price ELSE 0 END) as total_other_amount FROM proposals p, statuses st 
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatsFilterFrom') && $this->session->userdata('pStatsFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatsFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatsFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOtherAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOtherAmtSubQuery .= ' AND p.owner =' . $user_id;


        $bidOtherAmtSubQuery .= " ) AS totalOther";

        //echo $bidClientSubQuery;die;
        // Base query
        $sql = 'SELECT bt.id, bt.type_name,
           ' . $bidWinSubQuery . ', ' .
            $bidSoldAmtSubQuery . ', ' .
            $bidCountSubQuery . ', ' .
            $bidOpenAmtSubQuery . ', ' .
            $bidOtherAmtSubQuery . ', ' .
            $bidAmtSubQuery . '
            FROM business_types bt
            
            WHERE bt.company_id IS NULL OR bt.company_id = ' . $this->getCompany()->getCompanyId();


        $searchVal = $this->input->get('search')['value'];
        // Search
        if ($searchVal) {
            $sql .= " AND ((bt.type_name LIKE \"%" . $searchVal . "%\")
                   )";
        }

        $sql .= ' HAVING numProposals > 0 ';
        // Sorting

        if ($this->input->get('order')) {

            ///SORTING
            $order = $this->input->get('order');

            switch ($order[0]['column']) {
                case 0: // Account Name
                    $sql .= ' ORDER BY bt.type_name ' . $order[0]['dir'];
                    break;
                case 1: // status
                    $sql .= ' ORDER BY numProposals ' . $order[0]['dir'];
                    break;
                case 2: // job Number
                    $sql .= ' ORDER BY totalBid ' . $order[0]['dir'];
                    break;
                case 3: // Company
                    $sql .= ' ORDER BY totalOpen ' . $order[0]['dir'];
                    break;
                case 4: // Sold
                    $sql .= ' ORDER BY totalOther ' . $order[0]['dir'];
                    break;
                case 5: // Sold
                    $sql .= ' ORDER BY totalSold ' . $order[0]['dir'];
                    break;
                case 6: // Win
                    $sql .= ' ORDER BY percent_total ' . $order[0]['dir'];
                    break;
            }
        }

        if (!$count) {
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    public function getDashboardBusinessTypesTableData($users, $count = false)
    {
        $this->load->database();


        $bidCountSubQuery = "(SELECT COUNT(*) FROM proposals p  
        WHERE p.business_type_id = bt.id ";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidCountSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidCountSubQuery .= ' AND p.owner IN(' . $users . ')';

        $bidCountSubQuery .= " ) AS numProposals";



        // Build bid amount subquery
        $bidAmtSubQuery = " (SELECT SUM(p.price) FROM proposals p 
        WHERE p.business_type_id = bt.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidAmtSubQuery .= ' AND p.owner IN(' . $users . ')';

        $bidAmtSubQuery .= " ) AS totalBid";




        // subquery for Sold amount

        $bidSoldAmtSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, statuses st
        WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidSoldAmtSubQuery .= " AND (p.win_date >= " . $start . " AND p.win_date <= " . $end . ")";
        }

        // Show all accounts
        $bidSoldAmtSubQuery .= ' AND p.owner IN(' . $users . ')';


        $bidSoldAmtSubQuery .= " ) AS totalSold";

        // subquery for Sold amount

        $bidWinSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) * 100 / SUM(p.price)  AS percent_total FROM proposals p, statuses st
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";


        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidWinSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidWinSubQuery .= ' AND p.owner IN(' . $users . ')';

        $bidWinSubQuery .= " ) AS percent_total";


        // subquery for Open amount

        $bidOpenAmtSubQuery = " (SELECT SUM(CASE WHEN (st.id = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, statuses st
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOpenAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOpenAmtSubQuery .= ' AND p.owner IN(' . $users . ')';


        $bidOpenAmtSubQuery .= " ) AS totalOpen";

        // subquery for Other total amount

        $bidOtherAmtSubQuery = " (SELECT SUM(CASE WHEN st.id != '1' AND st.sales != '1' THEN p.price ELSE 0 END) as total_other_amount FROM proposals p, statuses st 
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOtherAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOtherAmtSubQuery .= ' AND p.owner IN(' . $users . ')';


        $bidOtherAmtSubQuery .= " ) AS totalOther";

        //echo $bidClientSubQuery;die;
        // Base query
        $sql = 'SELECT bt.id, bt.type_name,
           ' . $bidWinSubQuery . ', ' .
            $bidSoldAmtSubQuery . ', ' .
            $bidCountSubQuery . ', ' .
            $bidOpenAmtSubQuery . ', ' .
            $bidOtherAmtSubQuery . ', ' .
            $bidAmtSubQuery . '
            FROM business_types bt
            
            WHERE bt.company_id IS NULL OR bt.company_id = ' . $this->getCompany()->getCompanyId();


        $searchVal = $this->input->get('search')['value'];
        // Search
        if ($searchVal) {
            $sql .= " AND ((bt.type_name LIKE \"%" . $searchVal . "%\")
                   )";
        }

        $sql .= ' HAVING numProposals > 0 ';
        // Sorting

        if ($this->input->get('order')) {

            ///SORTING
            $order = $this->input->get('order');

            switch ($order[0]['column']) {
                case 0: // Account Name
                    $sql .= ' ORDER BY bt.type_name ' . $order[0]['dir'];
                    break;
                case 1: // status
                    $sql .= ' ORDER BY numProposals ' . $order[0]['dir'];
                    break;
                case 2: // job Number
                    $sql .= ' ORDER BY totalBid ' . $order[0]['dir'];
                    break;
                case 3: // Company
                    $sql .= ' ORDER BY totalOpen ' . $order[0]['dir'];
                    break;
                case 4: // Sold
                    $sql .= ' ORDER BY totalOther ' . $order[0]['dir'];
                    break;
                case 5: // Sold
                    $sql .= ' ORDER BY totalSold ' . $order[0]['dir'];
                    break;
                case 6: // Win
                    $sql .= ' ORDER BY percent_total ' . $order[0]['dir'];
                    break;
            }
        }

        if (!$count) {
            //$sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    public function getAccountBusinessTypesTableData($account_id, $count = false)
    {
        $this->load->database();


        $bidCountSubQuery = "(SELECT COUNT(*) FROM proposals p, clients c
        WHERE p.business_type_id = bt.id AND p.client = c.clientId";

        // Date filter applies to bid subquery

        if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
            $from = explode('/', $this->session->userdata('accFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('accFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidCountSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidCountSubQuery .= ' AND c.client_account =' . $account_id;

        $bidCountSubQuery .= " ) AS numProposals";



        // Build bid amount subquery
        $bidAmtSubQuery = " (SELECT SUM(p.price) FROM proposals p,clients c 
        WHERE p.business_type_id = bt.id AND p.client = c.clientId AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
            $from = explode('/', $this->session->userdata('accFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('accFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidAmtSubQuery .= ' AND c.client_account =' . $account_id;

        $bidAmtSubQuery .= " ) AS totalBid";




        // subquery for Sold amount

        $bidSoldAmtSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p,clients c, statuses st
        WHERE p.business_type_id = bt.id AND p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
            $from = explode('/', $this->session->userdata('accFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('accFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidSoldAmtSubQuery .= " AND (p.win_date >= " . $start . " AND p.win_date <= " . $end . ")";
        }

        // Show all accounts
        $bidSoldAmtSubQuery .= ' AND c.client_account =' . $account_id;


        $bidSoldAmtSubQuery .= " ) AS totalSold";

        // subquery for Sold amount

        $bidWinSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) * 100 / SUM(p.price)  AS percent_total FROM proposals p,clients c, statuses st
           
            WHERE p.business_type_id = bt.id AND p.client = c.clientId  AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";


        // Date filter applies to bid subquery

        if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
            $from = explode('/', $this->session->userdata('accFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('accFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidWinSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidWinSubQuery .= ' AND c.client_account =' . $account_id;

        $bidWinSubQuery .= " ) AS percent_total";


        // subquery for Open amount

        $bidOpenAmtSubQuery = " (SELECT SUM(CASE WHEN (st.id = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p,clients c, statuses st
           
            WHERE p.business_type_id = bt.id AND p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
            $from = explode('/', $this->session->userdata('accFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('accFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOpenAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOpenAmtSubQuery .= ' AND c.client_account =' . $account_id;


        $bidOpenAmtSubQuery .= " ) AS totalOpen";

        // subquery for Other total amount

        $bidOtherAmtSubQuery = " (SELECT SUM(CASE WHEN st.id != '1' AND st.sales != '1' THEN p.price ELSE 0 END) as total_other_amount FROM proposals p,clients c, statuses st 
           
            WHERE p.business_type_id = bt.id AND p.client = c.clientId AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('accFilterFrom') && $this->session->userdata('accFilterTo')) {
            $from = explode('/', $this->session->userdata('accFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('accFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOtherAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOtherAmtSubQuery .= ' AND c.client_account =' . $account_id;


        $bidOtherAmtSubQuery .= " ) AS totalOther";

        //echo $bidClientSubQuery;die;
        // Base query
        $sql = 'SELECT bt.id, bt.type_name,
           ' . $bidWinSubQuery . ', ' .
            $bidSoldAmtSubQuery . ', ' .
            $bidCountSubQuery . ', ' .
            $bidOpenAmtSubQuery . ', ' .
            $bidOtherAmtSubQuery . ', ' .
            $bidAmtSubQuery . '
            FROM business_types bt
            
            WHERE bt.company_id IS NULL OR bt.company_id = ' . $this->getCompany()->getCompanyId();


        $searchVal = $this->input->get('search')['value'];
        // Search
        if ($searchVal) {
            $sql .= " AND ((bt.type_name LIKE \"%" . $searchVal . "%\")
                   )";
        }

        $sql .= ' HAVING numProposals > 0 ';
        // Sorting

        if ($this->input->get('order')) {

            ///SORTING
            $order = $this->input->get('order');

            switch ($order[0]['column']) {
                case 0: // Account Name
                    $sql .= ' ORDER BY bt.type_name ' . $order[0]['dir'];
                    break;
                case 1: // status
                    $sql .= ' ORDER BY numProposals ' . $order[0]['dir'];
                    break;
                case 2: // job Number
                    $sql .= ' ORDER BY totalBid ' . $order[0]['dir'];
                    break;
                case 3: // Company
                    $sql .= ' ORDER BY totalOpen ' . $order[0]['dir'];
                    break;
                case 4: // Sold
                    $sql .= ' ORDER BY totalOther ' . $order[0]['dir'];
                    break;
                case 5: // Sold
                    $sql .= ' ORDER BY totalSold ' . $order[0]['dir'];
                    break;
                case 6: // Win
                    $sql .= ' ORDER BY percent_total ' . $order[0]['dir'];
                    break;
            }
        }

        if (!$count) {
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }
        
        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }


    public function getExistingContact($account_id = '', $accountName = '', $firstname = '', $lastname = '', $email = '', $count = false)
    {
        $this->load->database();


        $sql = "SELECT c.clientId, CONCAT(c.firstName, ' ', c.lastName) as fullName, c.email,
                    cc.name as clientCompanyName
                FROM clients c
                  LEFT JOIN client_companies cc ON c.client_account = cc.id
                  LEFT JOIN accounts a ON c.account = a.accountId";

        $sql .= " WHERE c.company = " . $this->getCompany()->getCompanyId();


        if ($account_id) {
            // $sql .= " AND cc.id = " .$account_id;
        }
        if ($accountName != '' || $firstname != '' || $lastname != '') {
            $sql .= " AND ( (";
            if ($accountName) {
                $searchValue = $this->db->escape_like_str($accountName);
                $sql .= "  cc.name LIKE \"%" . $searchValue . "%\" ";
            }

            if ($firstname) {
                if ($accountName != '') {
                    $sql .= " AND ";
                }
                $searchValue = $this->db->escape_like_str($firstname);
                $sql .= "  c.firstName LIKE \"%" . $searchValue . "%\" ";
            }
            if ($lastname) {
                if ($accountName != '' || $firstname != '') {
                    $sql .= " AND ";
                }
                $searchValue = $this->db->escape_like_str($lastname);
                $sql .= "  c.lastName LIKE \"%" . $searchValue . "%\" ";
            }
            $sql .= ")";

            if ($email) {
                $searchValue = $this->db->escape_like_str($email);
                $sql .= " OR c.email LIKE \"%" . $searchValue . "%\")";
            } else {
                $sql .= ")";
            }
        } else {
            if ($email) {
                $searchValue = $this->db->escape_like_str($email);
                $sql .= " AND (c.email LIKE \"%" . $searchValue . "%\")";
            }
        }





        // Sorting
        $order = $this->input->get('order');
        if ($order) {
            $sortDir = $order[0]['dir'];

            switch ($order[0]['column']) {
                case 0:
                    $sortCol = 'clientCompanyName';
                    break;
                case 1:
                    $sortCol = 'c.firstName';
                    break;

                case 2:
                    $sortCol = 'c.email';
                    break;
            }
        } else {
            $sortDir = 'asc';
            $sortCol = 'clientCompanyName';
        }

        $sql .= " ORDER BY " . $sortCol . ' ' . $sortDir;
        if (!$count) {
            $sql .= ' LIMIT ' . $this->input->get('length');
            $sql .= ' OFFSET ' . $this->input->get('start');
        }


        //echo $sql;die;
        $clientData = $this->db->query($sql)->result();
        $this->db->close();
        $out = [];
        //print_r($clientData);die;
        foreach ($clientData as $data) {
            $out[] = $data;
        }
        return $out;
    }



    /**
     * @param bool $count
     * @return array|mixed
     */
    public function getProspectsNew($count = false, $action = '', $type = '', $resend_id = '')
    {


        // Define what we're selecting
        $this->load->database();
        $select = 'p.*,GROUP_CONCAT(DISTINCT bt.type_name) as types,COUNT(notes.noteId) as ncount';

        if ($count) {
            $select = 'p.prospectId as total_prospect';
        }

        $groupBy = ' GROUP BY p.prospectId';
        $groupBy2 = ' GROUP BY p.prospectId';
        $sql = "SELECT " . $select . "
        FROM prospects as p
        LEFT JOIN accounts as a on p.account = a.accountId ";
        if (!$count) {
            $sql .= " LEFT JOIN business_type_assignments bta ON p.prospectId = bta.prospect_id
            LEFT JOIN business_types bt ON bt.id = bta.business_type_id
            LEFT JOIN notes  ON p.prospectId = notes.relationId AND   type = 'prospect' ";
        }

        $sqlWhere = ' Where p.company=' . $this->getCompany()->getCompanyId();
        if (!$this->hasFullAccess()) {

           
            $sqlWhere .= ' AND a.branch = ' . $this->getBranch();
           
            // For peons, add further restriction to their own account
            if ($this->isUser()) {
               
                $sqlWhere .= ' AND p.account = ' . $this->getAccountId();
            }
        }

        if ($action == 'resend') {

            // FIrst we have to check for a filter so we can add the join

           

            $sql .= "  LEFT JOIN prospect_group_resend_email pgre ON p.prospectId = pgre.prospect_id AND pgre.resend_id = " . $this->session->userdata('pProspectResendFilterId');
            if ($type == 'failed') {
               
                $prospect_ids = $this->getResendFailedProspectsIds($this->session->userdata('pProspectResendFilterId'));
                
                if ($prospect_ids) {

                    
                    $sqlWhere .= ' AND p.prospectId IN(' . $prospect_ids . ')';
                } else {
                    return [];
                }
            } else {
                // Now we have to check it's in the resend
                $prospect_ids = $this->getResendProspectsIds($this->session->userdata('pProspectResendFilterId'));
                
                if ($prospect_ids) {

                    
                    $prospect_ids = implode(",", $prospect_ids);
                    $sqlWhere .= ' AND p.prospectId IN(' . $prospect_ids . ')';
                } else {
                    return [];
                }
            }

            // Now add the WHERE condition
            switch ($type) {

                case 'delivered':
                    // Join on the PGRE where delivered

                   
                    $sqlWhere .= ' AND pgre.delivered_at IS NOT NULL ';
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered

                    
                    $sqlWhere .= ' AND pgre.bounced_at IS NOT NULL ';
                    break;

                case 'opened':
                    // Join on the PGRE where delivered

                    
                    $sqlWhere .= ' AND pgre.opened_at IS NOT NULL ';

                    break;

                case 'unopened':
                    // Join on the PGRE where delivered

                    
                    $sqlWhere .= ' AND pgre.opened_at IS  NULL ';
                    break;
                case 'clicked':
                    // Join on the PGRE where delivered

                    
                    $sqlWhere .= ' AND pgre.clicked_at IS NOT NULL ';
                    break;
            }
        }

        if ($action != 'resend') {
            // Filters
            if ($this->session->userdata('ptFilter')) {

                // Branch
                if ($this->session->userdata('ptFilterBranch') && $this->session->userdata('ptFilterBranch') != 'All') {
                    
                    $branchIds = implode(",", $this->session->userdata('ptFilterBranch'));
                    $sqlWhere .= ' AND a.branch IN(' . $branchIds . ')';
                }

                // User
               
                if ($this->session->userdata('ptFilterUser') && $this->session->userdata('ptFilterUser') != 'All') {
                    

                    $userIds = "'" . implode("','", $this->session->userdata('ptFilterUser')) . "'";
                    $sqlWhere .= ' AND p.account IN(' . $userIds . ')';
                }

                // Status
                if ($this->session->userdata('ptFilterStatus')) {
                    // $qb->andWhere('p.status = :status');
                    // $qb->setParameter(':status', $this->session->userdata('ptFilterStatus'));
                }

                // Rating
                if ($this->session->userdata('ptFilterRating') && $this->session->userdata('ptFilterRating') != 'All') {
                    
                    $ratings = "'" . implode("','", $this->session->userdata('ptFilterRating')) . "'";
                    $sqlWhere .= " AND p.rating IN(" . $ratings . ")";
                }

                // Rating
                if ($this->session->userdata('ptFilterSource') && $this->session->userdata('ptFilterRating') != 'All') {
                    
                    $sources = implode(",", $this->session->userdata('ptFilterSource'));
                    $sqlWhere .= " AND p.prospect_source_id IN(" . $sources . ")";
                }
         
                // business Type
                if ($this->session->userdata('ptFilterBusinessType') && $this->session->userdata('ptFilterBusinessType') != 'All') {
                    
                    if ($count) {
                        $sql .= " LEFT JOIN business_type_assignments bta ON p.prospectId = bta.prospect_id
                    LEFT JOIN business_types bt ON bt.id = bta.business_type_id
                    ";
                        $groupBy2 .= ' ,bta.prospect_id ';
                    }

                    $types = "'" . implode("','", $this->session->userdata('ptFilterBusinessType')) . "'";
                    $sqlWhere .= " AND bta.business_type_id IN(" . $types . ")";
                    //$groupBy .= '  GROUP BY bta.prospect_id ';
                }
            }
        } else {

            // Filters
            if ($this->session->userdata('ptrFilter_' . $resend_id)) {

                // Branch
                if ($this->session->userdata('ptrFilterBranch_' . $resend_id) && $this->session->userdata('ptrFilterBranch_' . $resend_id) != 'All') {
                    
                    $sqlWhere .= ' AND a.branch = ' . $this->session->userdata('ptrFilterBranch_' . $resend_id);
                }

                // User
                //print_r($this->session->userdata('ptFilterUser'));die;
                if ($this->session->userdata('ptrFilterUser_' . $resend_id) && $this->session->userdata('ptrFilterUser_' . $resend_id) != 'All') {
                    
                    $sqlWhere .= ' AND p.account IN(' . $this->session->userdata('ptrFilterUser_' . $resend_id) . ')';
                }

                // Status
                if ($this->session->userdata('ptrFilterStatus_' . $resend_id)) {
                    // $qb->andWhere('p.status = :status');
                    // $qb->setParameter(':status', $this->session->userdata('ptFilterStatus'));
                }

                // Rating
                if ($this->session->userdata('ptrFilterRating_' . $resend_id) && $this->session->userdata('ptrFilterRating_' . $resend_id) != 'All') {
                    
                    $sqlWhere .= ' AND p.rating IN(' . $this->session->userdata('ptrFilterRating_' . $resend_id) . ')';
                }

                // Rating
                if ($this->session->userdata('ptrFilterSource_' . $resend_id) && $this->session->userdata('ptrFilterRating_' . $resend_id) != 'All') {
                    
                    $sqlWhere .= ' AND p.prospect_source_id IN(' . $this->session->userdata('ptrFilterSource_' . $resend_id) . ')';
                }

                // business Type
                if ($this->session->userdata('ptFilterBusinessType') && $this->session->userdata('ptFilterBusinessType') != 'All') {
                    
                    if ($count) {
                        $sql .= " LEFT JOIN business_type_assignments bta ON p.prospectId = bta.prospect_id
                                LEFT JOIN business_types bt ON bt.id = bta.business_type_id
                                ";
                        $groupBy2 .= ' ,bta.prospect_id ';
                    }
                    $sqlWhere .= ' AND bta.business_type_id IN(' . $this->session->userdata('ptFilterBusinessType') . ')';
                }
            }
        }

        
        // Search
        $search = $this->input->get('search');
        $searchVal = $search['value'];

        if ($searchVal) {
            $sqlWhere .= " AND ( (p.firstName like \"%" . $searchVal . "%\")
            OR (p.lastName like \"%" . $searchVal . "%\")
            OR (p.companyName like \"%" . $searchVal . "%\")
            OR (p.business like \"%" . $searchVal . "%\")
            OR (p.title like \"%" . $searchVal . "%\")
            )";
        }
        if ($count) {
            $sql .=  $sqlWhere . $groupBy2;
        } else {
            $sql .=  $sqlWhere . $groupBy;
        }

        // Limits
        $order = $this->input->get('order');
        $orderCol = $order[0]['column'];
        $orderDir = $order[0]['dir'];

        switch ($orderCol) {
            case 2:
                
                $sql .= ' ORDER BY p.created ' . $orderDir;
                break;
            
            
        
            case 4:
                
                $sql .= ' ORDER BY p.status ' . $orderDir;
                break;

            case 5:

                
                $sql .= ' ORDER BY p.rating ' . $orderDir;

                break;

            case 7:
                
                $sql .= ' ORDER BY p.business ' . $orderDir;
                break;

            case 8:
                
                $sql .= ' ORDER BY p.companyName ' . $orderDir;

                break;

            case 9:
                
                $sql .= ' ORDER BY p.firstName ' . $orderDir;
                break;

            case 11:
                $sql .= ' ORDER BY p.title ' . $orderDir;
                break;
            case 13:
                
                $sql .= ' ORDER BY p.account ' . $orderDir;
                break;
        }

        
        if ($count) {
            
            $data = $this->db->query($sql)->result();
            $this->db->close();
            return count($data);
        } else {
            
        }
        $sql .= ' LIMIT ' . $this->input->get('length');
        $sql .= ' OFFSET ' . $this->input->get('start');
        // if($debug){
        //  echo $sql;
        //  die;
        // }


        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
        //return $query->getResult();
    }

    public function getLeadsNew($count = false, $action = '', $type = '', $resend_id = '')
    {

        // Define what we're selecting
        $this->load->database();
        $select = ' l.*,1 as opened_at,GROUP_CONCAT(DISTINCT bt.type_name) as types,COUNT(notes.noteId) as ncount ';
        if ($count) {
            $select = 'l.leadId';
        } else if ($action == 'resend') {
            $select = 'l.*,lgre.opened_at,GROUP_CONCAT(DISTINCT bt.type_name) as types,COUNT(notes.noteId) as ncount';
        }

        // Begin Query - Ensure restriction to this company only
        // $qb->select($select)
        //     ->from('\models\Leads', 'l')
        //     ->where('l.company = :companyId')
        //     ->setParameter(':companyId', $this->getCompany()->getCompanyId());
        $sql = "SELECT " . $select . " FROM leads as l
        LEFT JOIN accounts on l.account = accounts.accountId ";
        if (!$count) {
            $sql .= " LEFT JOIN business_type_assignments bta ON l.leadId = bta.lead_id
            LEFT JOIN business_types bt ON bt.id = bta.business_type_id
            LEFT JOIN notes  ON l.leadId = notes.relationId AND type = 'lead'  ";
        }

        $sqlWhere = ' Where l.company=' . $this->getCompany()->getCompanyId();
        $groupBy = ' GROUP BY l.leadId';

        $groupBy2 = ' GROUP BY l.leadId';
        // For peons, add further restriction to their own account
        if ($this->getUserClass() < 1) {
            // $qb->andWhere('l.account = :accountId');
            // $qb->setParameter(':accountId', $this->getAccountId());
            $sqlWhere .= ' AND l.account = ' . $this->getAccountId();
        }


        // For branch managers, join with accounts and branch id
        if ($this->isBranchAdmin()) {
            $sqlWhere .= ' AND accounts.branch = ' . $this->getBranch();
        }
        if ($action == 'resend') {

            $sql .= " LEFT JOIN lead_group_resend_email lgre ON l.leadId = lgre.lead_id 
            AND lgre.resend_id = " . $this->session->userdata('pLeadResendFilterId');

            // FIrst we have to check for a filter so we can add the join
            // $qb->from('\models\LeadGroupResendEmail', 'lgre');
            // $qb->andWhere('l.leadId = lgre.lead_id ');
            // $qb->andWhere('lgre.resend_id = :resendId');
            // $qb->setParameter(':resendId', $this->session->userdata('pLeadResendFilterId'));
            // Now we have to check it's in the resend
            $lead_ids = $this->getResendLeadsIds($this->session->userdata('pLeadResendFilterId'));
            //$lead_ids = explode(",",$lead_ids);
            if ($lead_ids) {

                // $qb->andWhere('l.leadId IN (:leadIds)');
                // $qb->setParameter(':leadIds', $lead_ids);
                $lead_ids = implode(",", $lead_ids);
                $sqlWhere .= " AND l.leadId IN (" . $lead_ids . ")";
            } else {
                return [];
            }

            // Now add the WHERE condition
            switch ($type) {

                case 'delivered':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.delivered_at IS NOT NULL ');
                    $sqlWhere .= ' AND lgre.delivered_at IS NOT NULL';
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.bounced_at IS NOT NULL ');
                    $sqlWhere .= ' AND lgre.bounced_at IS NOT NULL ';
                    break;

                case 'opened':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.opened_at IS NOT NULL ');
                    $sqlWhere .= ' AND lgre.opened_at IS NOT NULL ';
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.opened_at IS NULL');
                    $sqlWhere .= ' AND lgre.opened_at IS NULL';
                    break;
                case 'clicked':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.clicked_at IS NOT NULL');
                    $sqlWhere .= ' AND lgre.clicked_at IS NOT NULL';
                    break;
            }
        }



        // Filters
        if ($action != 'resend') {
            if ($this->session->userdata('lFilter')) {

                // User
                if (($this->session->userdata('lFilterUser') && $this->session->userdata('lFilterUser') != 'All') || $this->session->userdata('lFilterUser') === 'u') {

                    // $qb->andWhere('l.account IN(:userIds)');
                    // $qb->setParameter(':userIds', $this->session->userdata('lFilterUser'));
                    $userIds  = "'" . implode("','", $this->session->userdata('lFilterUser')) . "'";

                    $sqlWhere .= " AND l.account IN(" . $userIds . ")";
                }

                // Source
                if ($this->session->userdata('lFilterSource')) {
                    // $qb->andWhere('l.source IN (:source)');
                    // $qb->setParameter(':source', $this->session->userdata('lFilterSource'));

                    $source  = "'" . implode("','", $this->session->userdata('lFilterSource')) . "'";
                    $sqlWhere .= " AND l.source IN (" . $source . ")";
                }

                // Status
                if ($this->session->userdata('lFilterStatus')) {

                    $filterStatuses = [];

                    foreach ($this->session->userdata('lFilterStatus') as $k => $v) {
                        if ($v == 'Active') {
                            $filterStatuses[] = 'Working';
                        } else {
                            $filterStatuses[] = $v;
                        }
                    }

                    // $qb->andWhere('l.status IN (:statuses)');
                    // $qb->setParameter(':statuses', $filterStatuses);
                    $statuses = "'" . implode("','", $filterStatuses) . "'";
                    $sqlWhere .= " AND l.status IN(" . $statuses . ")";
                }

                // Business Type 
                if ($this->session->userdata('lFilterBusinessType')) {



                    // $qb->andWhere('l.status IN (:statuses)');
                    // $qb->setParameter(':statuses', $filterStatuses);
                    $statuses = "'" . implode("','", $filterStatuses) . "'";
                    $sqlWhere .= " AND l.status IN (" . $statuses . ")";
                }

                // business Type
                if ($this->session->userdata('lFilterBusinessType') && $this->session->userdata('lFilterBusinessType') != 'All') {
                    if ($count) {
                        $sql .= " LEFT JOIN business_type_assignments bta ON l.leadId = bta.lead_id
                                LEFT JOIN business_types bt ON bt.id = bta.business_type_id ";
                        $groupBy2 .= ' ,bta.lead_id ';
                    }
                    $types = "'" . implode("','", $this->session->userdata('lFilterBusinessType')) . "'";
                    $sqlWhere .= " AND bta.business_type_id IN(" . $types . ")";
                }



                // Created Start Date
                $rangeStart = $this->session->userdata('lFilterDateStart');
                $rangeEnd = $this->session->userdata('lFilterDateEnd');

                if ($rangeStart) {
                    // $qb->andWhere('l.created > :createdStart');
                    // $qb->setParameter(':createdStart', $rangeStart);
                    $sqlWhere .= " AND l.created > " . $rangeStart;
                }

                // Created End Date
                if ($rangeEnd) {
                    // $qb->andWhere('l.created < :createdEnd');
                    // $qb->setParameter(':createdEnd', $rangeEnd);
                    $sqlWhere .= " AND l.created < " . $rangeEnd;
                }

                // Age (filter page)
                switch ($this->session->userdata('lFilterAge')) {

                    case 'old':
                        $ageEnd = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created < :ageEnd');
                        // $qb->setParameter(':ageEnd', $ageEnd);
                        $sqlWhere .= " AND l.created < " . $ageEnd;
                        break;

                    case 'current':
                        $ageStart = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        $ageEnd = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created > :ageStart');
                        // $qb->andWhere('l.created < :ageEnd');
                        // $qb->setParameter(':ageStart', $ageStart);
                        $sqlWhere .= " AND l.created > " . $ageStart;
                        // $qb->setParameter(':ageEnd', $ageEnd);
                        $sqlWhere .= " AND l.created < " . $ageEnd;
                        break;

                    case 'new':
                        $ageStart = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created > :ageStart');
                        // $qb->setParameter(':ageStart', $ageStart);
                        $sqlWhere .= " AND l.created > " . $ageStart;
                        break;
                }
            }
        } else {
            if ($this->session->userdata('lrFilter_' . $resend_id)) {

                // User
                if (($this->session->userdata('lrFilterUser_' . $resend_id) && $this->session->userdata('lrFilterUser_' . $resend_id) != 'All') || $this->session->userdata('lrFilterUser_' . $resend_id) === 'u') {

                    // $qb->andWhere('l.account IN(:userIds)');
                    // $qb->setParameter(':userIds', $this->session->userdata('lrFilterUser_'.$resend_id));
                    $users = "'" . implode("','", $this->session->userdata('lrFilterUser_' . $resend_id)) . "'";
                    $sqlWhere .= " AND l.account IN (" . $users . ")";
                }

                // Source
                if ($this->session->userdata('lrFilterSource_' . $resend_id)) {
                    // $qb->andWhere('l.source IN (:source)');
                    // $qb->setParameter(':source', $this->session->userdata('lrFilterSource_'.$resend_id));
                    $source = "'" . implode("','", $this->session->userdata('lrFilterSource_' . $resend_id)) . "'";
                    $sqlWhere .= " AND l.source IN (" . $source . ")";
                }

                // Status
                if ($this->session->userdata('lrFilterStatus_' . $resend_id)) {

                    $filterStatuses = [];

                    foreach ($this->session->userdata('lrFilterStatus_' . $resend_id) as $k => $v) {
                        if ($v == 'Active') {
                            $filterStatuses[] = 'Working';
                        } else {
                            $filterStatuses[] = $v;
                        }
                    }

                    // $qb->andWhere('l.status IN (:statuses)');
                    // $qb->setParameter(':statuses', $filterStatuses);
                    $filterStatuses = "'" . implode("','", $filterStatuses) . "'";
                    $sqlWhere .= " AND l.status IN (" . $filterStatuses . ")";
                }

                // business Type
                if ($this->session->userdata('lrFilterBusinessType_' . $resend_id) && $this->session->userdata('lrFilterBusinessType_' . $resend_id) != 'All') {
                    if ($count) {
                        $sql .= " LEFT JOIN business_type_assignments bta ON l.leadId = bta.lead_id
                    LEFT JOIN business_types bt ON bt.id = bta.business_type_id ";
                        $groupBy2 .= ' ,bta.lead_id ';
                    }

                    $types = "'" . implode("','", $this->session->userdata('lrFilterBusinessType_' . $resend_id)) . "'";
                    $sqlWhere .= " AND bta.business_type_id IN(" . $types . ")";
                }


                // Created Start Date
                $rangeStart = $this->session->userdata('lrFilterDateStart_' . $resend_id);
                $rangeEnd = $this->session->userdata('lrFilterDateEnd_' . $resend_id);

                if ($rangeStart) {
                    // $qb->andWhere('l.created > :createdStart');
                    // $qb->setParameter(':createdStart', $rangeStart);
                    $sqlWhere .= " AND l.created > " . $rangeStart;
                }

                // Created End Date
                if ($rangeEnd) {
                    // $qb->andWhere('l.created < :createdEnd');
                    // $qb->setParameter(':createdEnd', $rangeEnd);
                    $sqlWhere .= " AND l.created < " . $rangeEnd;
                }

                // Age (filter page)
                switch ($this->session->userdata('lFilterAge')) {

                    case 'old':
                        $ageEnd = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created < :ageEnd');
                        // $qb->setParameter(':ageEnd', $ageEnd);
                        $sqlWhere .= " AND l.created < " . $ageEnd;
                        break;

                    case 'current':
                        $ageStart = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        $ageEnd = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created > :ageStart');
                        // $qb->andWhere('l.created < :ageEnd');
                        // $qb->setParameter(':ageStart', $ageStart);
                        $sqlWhere .= " AND l.created > " . $ageStart;
                        // $qb->setParameter(':ageEnd', $ageEnd);
                        $sqlWhere .= " AND l.created < " . $ageEnd;
                        break;

                    case 'new':
                        $ageStart = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created > :ageStart');
                        // $qb->setParameter(':ageStart', $ageStart);
                        $sqlWhere .= " AND l.created > " . $ageStart;
                        break;
                }
            }
        }


        // Sorting
        $sortDir = 'asc';

        $order = $this->input->get('order');
        if ($order) {
            $sortDir = $order[0]['dir'];
        }

        switch ($order[0]['column']) {
            case 2:
                $sortCol = 'l.created';
                break;
            case 4:
                $sortCol = 'l.source';
                break;
            case 5:
                $sortCol = 'l.status';
                break;
            case 6:
                $sortCol = 'l.rating';
                break;
            case 7:
                $sortCol = 'l.dueDate';
                break;
            case 8:
                $sortCol = 'l.company';
                break;
            case 9:
                $sortCol = 'l.zip';
                break;
            case 10:
                $sortCol = 'l.projectName';
                break;
            case 11:
                $sortCol = 'l.firstName';
                break;
            case 13:
                $sortCol = 'l.last_activity';
                break;
            case 15:
                $sortCol = 'lgre.opened_at';
                break;
            default:
                $sortCol = 'l.last_activity';
        }


        // Search
        $search = $this->input->get('search');
        $searchVal = $search['value'];
        if ($searchVal) {
            // $search = $this->input->get('search');

            // $qb->andWhere("((l.firstName LIKE :searchVal)
            //             OR (l.lastName LIKE :searchVal)
            //             OR (l.status LIKE :searchVal)
            //             OR (l.companyName LIKE :searchVal)
            //             OR (l.title LIKE :searchVal)
            //             OR (l.address LIKE :searchVal)
            //             OR (l.email LIKE :searchVal)
            //             OR (l.city LIKE :searchVal)
            //             OR (l.state LIKE :searchVal)
            //             OR (l.zip LIKE :searchVal)
            //             OR (l.projectName LIKE :searchVal)
            //             OR (l.projectAddress LIKE :searchVal)
            //             OR (l.projectCity LIKE :searchVal)
            //             OR (l.projectState LIKE :searchVal)
            //             OR (l.projectZip LIKE :searchVal)
            //             OR (l.businessPhone LIKE :searchVal)
            //             OR (l.cellPhone LIKE :searchVal)
            //             OR (l.source LIKE :searchVal))");

            // $qb->setParameter(':searchVal', '%' . $search['value'] . '%');

            $sqlWhere .= " AND (
                (l.firstName like \"%" . $searchVal . "%\")
                OR (l.lastName like \"%" . $searchVal . "%\")
                OR (l.status like \"%" . $searchVal . "%\")
                OR (l.companyName like \"%" . $searchVal . "%\")
                OR (l.title like \"%" . $searchVal . "%\")
                OR (l.address like \"%" . $searchVal . "%\")
                OR (l.email like \"%" . $searchVal . "%\")
                OR (l.city like \"%" . $searchVal . "%\")
                OR (l.state like \"%" . $searchVal . "%\")
                OR (l.zip like \"%" . $searchVal . "%\")
                OR (l.projectName like \"%" . $searchVal . "%\")
                OR (l.projectAddress like \"%" . $searchVal . "%\")
                OR (l.projectCity like \"%" . $searchVal . "%\")
                OR (l.projectState like \"%" . $searchVal . "%\")
                OR (l.projectZip like \"%" . $searchVal . "%\")
                OR (l.businessPhone like \"%" . $searchVal . "%\")
                OR (l.cellPhone like \"%" . $searchVal . "%\")
                OR (l.source like \"%" . $searchVal . "%\")
            )";
        }

        // $sql .= $sqlWhere ;
        // if ($this->input->get('start')) {
        //     $qb->setFirstResult($this->input->get('start'));
        // }
        // $sql .= $groupBy ;
        if ($count) {
            $sql .=  $sqlWhere . $groupBy2;
        } else {
            $sql .=  $sqlWhere . $groupBy;
        }

        // Return the count if requested
        // if ($count) {
        //     $query = $qb->getQuery();
        //     if ($this->session->userdata('lFilterBusinessType') && $this->session->userdata('lFilterBusinessType') != 'All') {
        //         return count($query->getResult());
        //     }
        //     return $query->getSingleScalarResult();
        // }

        // Paging
        // $qb->orderBy($sortCol, $sortDir);
        $sql .= ' ORDER BY ' . $sortCol . ' ' . $sortDir;

        // if ($this->input->get('length')) {
        //     $qb->setMaxResults($this->input->get('length'));
        // }


        //     if ($count) {
        //         $data = $this->db->query($sql)->result();
        //         return $data[0]->total_lead ;
        //    //echo  $sql;die;
        //     }

        if ($count) {
            //echo  $sql;die;
            $data = $this->db->query($sql)->result();
            $this->db->close();
            return count($data);
        } else {
            $sql .= ' LIMIT ' . $this->input->get('length');
            $sql .= ' OFFSET ' . $this->input->get('start');
        }
        //  echo $sql;
        //  die;


        // Create the query and get the result
        // $query = $qb->getQuery();
        //print_r($query->getSql());
        // print_r($query->getParameters());die;
        // $leads = $query->getResult();
        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    public function getLeadsNew2($count = false, $action = '', $type = '', $resend_id = '')
    {
        //$qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Define what we're selecting
        $this->load->database();
        $select = ' l.*,1 as opened_at ';
        if ($count) {
            $select = 'COUNT(l.leadId) as total_lead';
        } else if ($action == 'resend') {
            $select = 'l.*,lgre.opened_at';
        }

        // Begin Query - Ensure restriction to this company only
        // $qb->select($select)
        //     ->from('\models\Leads', 'l')
        //     ->where('l.company = :companyId')
        //     ->setParameter(':companyId', $this->getCompany()->getCompanyId());
        $sql = 'SELECT' . $select . ' FROM leads as l
        LEFT JOIN accounts on l.account = accounts.accountId ';

        $sqlWhere = ' Where l.company=' . $this->getCompany()->getCompanyId();
        $groupBy = ' ';
        // For peons, add further restriction to their own account
        if ($this->getUserClass() < 1) {
            // $qb->andWhere('l.account = :accountId');
            // $qb->setParameter(':accountId', $this->getAccountId());
            $sqlWhere .= ' AND l.account = ' . $this->getAccountId();
        }


        // For branch managers, join with accounts and branch id
        if ($this->isBranchAdmin()) {
            $sqlWhere .= ' AND a.branch = ' . $this->getBranch();
            //     $qb->from('\models\Accounts', 'a');
            //     $qb->andWhere('l.account = a.accountId');
            //     $qb->andWhere('a.branch = :branchId');
            //     $qb->setParameter(':branchId', $this->getBranch());
        }
        if ($action == 'resend') {

            $sql .= " LEFT JOIN lead_group_resend_email lgre ON l.leadId = lgre.lead_id 
            AND lgre.resend_id = " . $this->session->userdata('pLeadResendFilterId');

            // FIrst we have to check for a filter so we can add the join
            // $qb->from('\models\LeadGroupResendEmail', 'lgre');
            // $qb->andWhere('l.leadId = lgre.lead_id ');
            // $qb->andWhere('lgre.resend_id = :resendId');
            // $qb->setParameter(':resendId', $this->session->userdata('pLeadResendFilterId'));
            // Now we have to check it's in the resend
            $lead_ids = $this->getResendLeadsIds($this->session->userdata('pLeadResendFilterId'));
            //$lead_ids = explode(",",$lead_ids);
            if ($lead_ids) {

                // $qb->andWhere('l.leadId IN (:leadIds)');
                // $qb->setParameter(':leadIds', $lead_ids);
                $lead_ids = implode(",", $lead_ids);
                $sqlWhere .= " AND l.leadId IN (" . $lead_ids . ")";
            } else {
                return [];
            }

            // Now add the WHERE condition
            switch ($type) {

                case 'delivered':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.delivered_at IS NOT NULL ');
                    $sqlWhere .= ' AND lgre.delivered_at IS NOT NULL';
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.bounced_at IS NOT NULL ');
                    $sqlWhere .= ' AND lgre.bounced_at IS NOT NULL ';
                    break;

                case 'opened':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.opened_at IS NOT NULL ');
                    $sqlWhere .= ' AND lgre.opened_at IS NOT NULL ';
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.opened_at IS NULL');
                    $sqlWhere .= ' AND lgre.opened_at IS NULL';
                    break;
                case 'clicked':
                    // Join on the PGRE where delivered

                    // $qb->andWhere('lgre.clicked_at IS NOT NULL');
                    $sqlWhere .= ' AND lgre.clicked_at IS NOT NULL';
                    break;
            }
        }



        // Filters
        if ($action != 'resend') {
            if ($this->session->userdata('lFilter')) {

                // User
                if (($this->session->userdata('lFilterUser') && $this->session->userdata('lFilterUser') != 'All') || $this->session->userdata('lFilterUser') === 'u') {

                    // $qb->andWhere('l.account IN(:userIds)');
                    // $qb->setParameter(':userIds', $this->session->userdata('lFilterUser'));
                    $userIds  = implode(",", $this->session->userdata('lFilterUser'));
                    $sqlWhere .= ' AND l.account IN(' . $userIds . ')';
                }

                // Source
                if ($this->session->userdata('lFilterSource')) {
                    // $qb->andWhere('l.source IN (:source)');
                    // $qb->setParameter(':source', $this->session->userdata('lFilterSource'));
                    $source = implode(',', $this->session->userdata('lFilterSource'));
                    $sqlWhere .= ' AND l.source IN (' . $source . ')';
                }

                // Status
                if ($this->session->userdata('lFilterStatus')) {

                    $filterStatuses = [];

                    foreach ($this->session->userdata('lFilterStatus') as $k => $v) {
                        if ($v == 'Active') {
                            $filterStatuses[] = 'Working';
                        } else {
                            $filterStatuses[] = $v;
                        }
                    }

                    // $qb->andWhere('l.status IN (:statuses)');
                    // $qb->setParameter(':statuses', $filterStatuses);
                    $statuses = implode(',', $filterStatuses);
                    $sqlWhere .= " AND l.status IN('" . $statuses . "')";
                }

                // Business Type 
                if ($this->session->userdata('lFilterBusinessType')) {



                    // $qb->andWhere('l.status IN (:statuses)');
                    // $qb->setParameter(':statuses', $filterStatuses);
                    $statuses = implode(',', $filterStatuses);
                    $sqlWhere .= ' AND l.status IN (' . $statuses . ')';
                }

                // business Type
                if ($this->session->userdata('lFilterBusinessType') && $this->session->userdata('lFilterBusinessType') != 'All') {
                    // $qb->from('\models\BusinessTypeAssignment', 'bta');
                    // $qb->andWhere('l.leadId = bta.lead_id ');
                    // $qb->andWhere('bta.business_type_id IN(:types)');
                    // $qb->groupBy('bta.lead_id');
                    // $qb->setParameter(':types', $this->session->userdata('lFilterBusinessType'));
                    $sql .= ' LEFT JOIN business_type_assignment bta ON l.leadId = bta.lead_id ';
                    $types = implode(",", $this->session->userdata('lFilterBusinessType'));
                    $sqlWhere .= ' AND bta.business_type_id IN(' . $types . ')';
                    $groupBy = ' GROUP BY bta.lead_id';
                }



                // Created Start Date
                $rangeStart = $this->session->userdata('lFilterDateStart');
                $rangeEnd = $this->session->userdata('lFilterDateEnd');

                if ($rangeStart) {
                    // $qb->andWhere('l.created > :createdStart');
                    // $qb->setParameter(':createdStart', $rangeStart);
                    $sqlWhere .= ' AND l.created > ' . $rangeStart;
                }

                // Created End Date
                if ($rangeEnd) {
                    // $qb->andWhere('l.created < :createdEnd');
                    // $qb->setParameter(':createdEnd', $rangeEnd);
                    $sqlWhere .= ' AND l.created < ' . $rangeEnd;
                }

                // Age (filter page)
                switch ($this->session->userdata('lFilterAge')) {

                    case 'old':
                        $ageEnd = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created < :ageEnd');
                        // $qb->setParameter(':ageEnd', $ageEnd);
                        $sqlWhere .= ' AND l.created < ' . $ageEnd;
                        break;

                    case 'current':
                        $ageStart = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        $ageEnd = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created > :ageStart');
                        // $qb->andWhere('l.created < :ageEnd');
                        // $qb->setParameter(':ageStart', $ageStart);
                        $sqlWhere .= ' AND l.created > ' . $ageStart;
                        // $qb->setParameter(':ageEnd', $ageEnd);
                        $sqlWhere .= ' AND l.created < ' . $ageEnd;
                        break;

                    case 'new':
                        $ageStart = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created > :ageStart');
                        // $qb->setParameter(':ageStart', $ageStart);
                        $sqlWhere .= ' AND l.created > ' . $ageStart;
                        break;
                }
            }
        } else {
            if ($this->session->userdata('lrFilter_' . $resend_id)) {

                // User
                if (($this->session->userdata('lrFilterUser_' . $resend_id) && $this->session->userdata('lrFilterUser_' . $resend_id) != 'All') || $this->session->userdata('lrFilterUser_' . $resend_id) === 'u') {

                    // $qb->andWhere('l.account IN(:userIds)');
                    // $qb->setParameter(':userIds', $this->session->userdata('lrFilterUser_'.$resend_id));
                    $sqlWhere .= " AND l.account IN (" . $this->session->userdata('lrFilterUser_' . $resend_id) . ")";
                }

                // Source
                if ($this->session->userdata('lrFilterSource_' . $resend_id)) {
                    // $qb->andWhere('l.source IN (:source)');
                    // $qb->setParameter(':source', $this->session->userdata('lrFilterSource_'.$resend_id));
                    $sqlWhere .= " AND l.source IN (" . $this->session->userdata('lrFilterSource_' . $resend_id) . ")";
                }

                // Status
                if ($this->session->userdata('lrFilterStatus_' . $resend_id)) {

                    $filterStatuses = [];

                    foreach ($this->session->userdata('lrFilterStatus_' . $resend_id) as $k => $v) {
                        if ($v == 'Active') {
                            $filterStatuses[] = 'Working';
                        } else {
                            $filterStatuses[] = $v;
                        }
                    }

                    // $qb->andWhere('l.status IN (:statuses)');
                    // $qb->setParameter(':statuses', $filterStatuses);
                    $sqlWhere .= " AND l.status IN ('" . $filterStatuses . "')";
                }



                // Created Start Date
                $rangeStart = $this->session->userdata('lrFilterDateStart_' . $resend_id);
                $rangeEnd = $this->session->userdata('lrFilterDateEnd_' . $resend_id);

                if ($rangeStart) {
                    // $qb->andWhere('l.created > :createdStart');
                    // $qb->setParameter(':createdStart', $rangeStart);
                    $sqlWhere .= " AND l.created > " . $rangeStart;
                }

                // Created End Date
                if ($rangeEnd) {
                    // $qb->andWhere('l.created < :createdEnd');
                    // $qb->setParameter(':createdEnd', $rangeEnd);
                    $sqlWhere .= " AND l.created < " . $rangeEnd;
                }

                // Age (filter page)
                switch ($this->session->userdata('lFilterAge')) {

                    case 'old':
                        $ageEnd = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created < :ageEnd');
                        // $qb->setParameter(':ageEnd', $ageEnd);
                        $sqlWhere .= " AND l.created < " . $ageEnd;
                        break;

                    case 'current':
                        $ageStart = Carbon::now()->subDays(7)->startOfDay()->timestamp;
                        $ageEnd = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created > :ageStart');
                        // $qb->andWhere('l.created < :ageEnd');
                        // $qb->setParameter(':ageStart', $ageStart);
                        $sqlWhere .= " AND l.created > " . $ageStart;
                        // $qb->setParameter(':ageEnd', $ageEnd);
                        $sqlWhere .= " AND l.created < " . $ageEnd;
                        break;

                    case 'new':
                        $ageStart = Carbon::now()->subDays(2)->startOfDay()->timestamp;
                        // $qb->andWhere('l.created > :ageStart');
                        // $qb->setParameter(':ageStart', $ageStart);
                        $sqlWhere .= " AND l.created > " . $ageStart;
                        break;
                }
            }
        }


        // Sorting
        $sortDir = 'asc';

        $order = $this->input->get('order');
        if ($order) {
            $sortDir = $order[0]['dir'];
        }

        switch ($order[0]['column']) {
            case 2:
                $sortCol = 'l.created';
                break;
            case 4:
                $sortCol = 'l.source';
                break;
            case 5:
                $sortCol = 'l.status';
                break;
            case 6:
                $sortCol = 'l.rating';
                break;
            case 7:
                $sortCol = 'l.dueDate';
                break;
            case 8:
                $sortCol = 'l.company';
                break;
            case 9:
                $sortCol = 'l.zip';
                break;
            case 10:
                $sortCol = 'l.projectName';
                break;
            case 11:
                $sortCol = 'l.firstName';
                break;
            case 13:
                $sortCol = 'l.last_activity';
                break;
            case 15:
                $sortCol = 'lgre.opened_at';
                break;
            default:
                $sortCol = 'l.last_activity';
        }


        // Search
        $search = $this->input->get('search');
        $searchVal = $search['value'];
        if ($searchVal) {
            // $search = $this->input->get('search');

            // $qb->andWhere("((l.firstName LIKE :searchVal)
            //             OR (l.lastName LIKE :searchVal)
            //             OR (l.status LIKE :searchVal)
            //             OR (l.companyName LIKE :searchVal)
            //             OR (l.title LIKE :searchVal)
            //             OR (l.address LIKE :searchVal)
            //             OR (l.email LIKE :searchVal)
            //             OR (l.city LIKE :searchVal)
            //             OR (l.state LIKE :searchVal)
            //             OR (l.zip LIKE :searchVal)
            //             OR (l.projectName LIKE :searchVal)
            //             OR (l.projectAddress LIKE :searchVal)
            //             OR (l.projectCity LIKE :searchVal)
            //             OR (l.projectState LIKE :searchVal)
            //             OR (l.projectZip LIKE :searchVal)
            //             OR (l.businessPhone LIKE :searchVal)
            //             OR (l.cellPhone LIKE :searchVal)
            //             OR (l.source LIKE :searchVal))");

            // $qb->setParameter(':searchVal', '%' . $search['value'] . '%');

            $sqlWhere .= " AND (
                (l.firstName like \"%" . $searchVal . "%\")
                OR (l.lastName like \"%" . $searchVal . "%\")
                OR (l.status like \"%" . $searchVal . "%\")
                OR (l.companyName like \"%" . $searchVal . "%\")
                OR (l.title like \"%" . $searchVal . "%\")
                OR (l.address like \"%" . $searchVal . "%\")
                OR (l.email like \"%" . $searchVal . "%\")
                OR (l.city like \"%" . $searchVal . "%\")
                OR (l.state like \"%" . $searchVal . "%\")
                OR (l.zip like \"%" . $searchVal . "%\")
                OR (l.projectName like \"%" . $searchVal . "%\")
                OR (l.projectAddress like \"%" . $searchVal . "%\")
                OR (l.projectCity like \"%" . $searchVal . "%\")
                OR (l.projectState like \"%" . $searchVal . "%\")
                OR (l.projectZip like \"%" . $searchVal . "%\")
                OR (l.businessPhone like \"%" . $searchVal . "%\")
                OR (l.cellPhone like \"%" . $searchVal . "%\")
                OR (l.source like \"%" . $searchVal . "%\")
            )";
        }

        $sql .= $sqlWhere;
        // if ($this->input->get('start')) {
        //     $qb->setFirstResult($this->input->get('start'));
        // }
        $sql .= $groupBy;

        // Return the count if requested
        // if ($count) {
        //     $query = $qb->getQuery();
        //     if ($this->session->userdata('lFilterBusinessType') && $this->session->userdata('lFilterBusinessType') != 'All') {
        //         return count($query->getResult());
        //     }
        //     return $query->getSingleScalarResult();
        // }

        // Paging
        // $qb->orderBy($sortCol, $sortDir);
        $sql .= ' ORDER BY ' . $sortCol . ' ' . $sortDir;

        // if ($this->input->get('length')) {
        //     $qb->setMaxResults($this->input->get('length'));
        // }

        $sql .= ' LIMIT ' . $this->input->get('length');
        $sql .= ' OFFSET ' . $this->input->get('start');
        if ($count) {
            $data = $this->db->query($sql)->result();
            $this->db->close();
            return $data[0]->total_lead;
            //echo  $sql;die;
        }
        //  echo $sql;
        //  die;


        // Create the query and get the result
        // $query = $qb->getQuery();
        //print_r($query->getSql());
        // print_r($query->getParameters());die;
        // $leads = $query->getResult();
        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }


    public function getProposalsDataByIDs($proposalIds)
    {
       $this->load->database();
        $company_id = $this->getCompany()->getCompanyId();
        // Base query
        $sql = 'SELECT proposals.proposalId, proposals.projectName, proposals.projectAddress, proposals.projectCity, proposals.projectState, proposals.projectZip, proposals.price, proposals.jobNumber, proposals.created, proposals.status, proposals.duplicateOf, proposals.approvalQueue, proposals.declined, proposals.proposalStatus, proposals.last_activity, proposals.email_status, proposals.deliveryTime, proposals.lastOpenTime, proposals.emailSendTime, proposals.audit_key, proposals.audit_view_time, proposals.audit_reminder_sent, proposals.win_date, proposals.QBID, proposals.unapproved_services, proposals.lat, proposals.lng, proposals.access_key,proposals.estimate_status_id,proposals.job_cost_status,proposals.profit_margin_value,proposals.profit_margin_percent, proposals.image_count,proposals.is_hidden_to_view,proposals.business_type_id,proposals.approved,proposals.layout as proposal_layout,proposals.resend_excluded,proposals.note_count as ncount,
        accounts.firstName as accountFN, accounts.lastName as accountLN, accounts.branch, accounts.accountId as account,accounts.layout as owner_layout,
        client_companies.name as clientAccountName,
        clients.clientId, clients.title as clientTitle, clients.firstName as clientFN, clients.lastName as clientLN, clients.businessPhone as clientBP, clients.cellPhone as clientCP, clients.companyName as clientCompany, clients.quickbooksId as clientQuickbooksId, clients.email as clientEmail,
        statuses.text as statusText,statuses.sales as is_sales,statuses.color as statusColor FROM proposals';

        $sql.= ' LEFT JOIN clients on proposals.client = clients.clientId
        LEFT JOIN client_companies on clients.client_account = client_companies.id
        LEFT JOIN companies on clients.company = companies.companyId
        LEFT JOIN accounts on proposals.owner = accounts.accountId
        LEFT JOIN statuses on proposals.proposalStatus = statuses.id
        ';
        if ($this->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= ' AND accounts.branch = ' . $this->getBranch();
           
         }
        if ($this->getUserClass() < 1) { 
            //regular user, can access only his proposals
            $sql .= ' AND proposals.owner = ' . $this->getAccountId();
        }

        $sql .= ' WHERE proposals.company_id ='.$company_id.' AND proposals.proposalId IN(' . $proposalIds . ')';

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;

    }

    public function getLeadsByIds($leadIds)
    {
        // Define what we're selecting
        $this->load->database();
        $select = ' l.*,1 as opened_at,GROUP_CONCAT(DISTINCT bt.type_name) as types,COUNT(notes.noteId) as ncount, accounts.firstName as FN, accounts.lastName as LN ';

        $sql = "SELECT " . $select . " FROM leads as l
            LEFT JOIN accounts on l.account = accounts.accountId ";
            $sql .= " LEFT JOIN business_type_assignments bta ON l.leadId = bta.lead_id
            LEFT JOIN business_types bt ON bt.id = bta.business_type_id
            LEFT JOIN notes  ON l.leadId = notes.relationId AND type = 'lead'  ";

        $sqlWhere = ' Where l.company=' . $this->getCompany()->getCompanyId();
        

        if ($this->getUserClass() < 1) {
            $sqlWhere .= ' AND l.account = ' . $this->getAccountId();
        }

        // For branch managers, join with accounts and branch id
        if ($this->isBranchAdmin()) {
            $sqlWhere .= ' AND accounts.branch = ' . $this->getBranch();
        }
        $sqlWhere .= ' and l.leadId IN(' . $leadIds . ')';
        $groupBy = ' GROUP BY l.leadId';

        $sql .=  $sqlWhere . $groupBy;

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    public function getProspectsByIds($prospectIds)
    {


        // Define what we're selecting
        $this->load->database();
        $select = 'p.*,GROUP_CONCAT(DISTINCT bt.type_name) as types, a.firstName as FN, a.lastName as LN ';

        $groupBy = ' GROUP BY p.prospectId';
        $sql = "SELECT " . $select . "
        FROM prospects as p
        LEFT JOIN accounts as a on p.account = a.accountId 
        LEFT JOIN business_type_assignments bta ON p.prospectId = bta.prospect_id
        LEFT JOIN business_types bt ON bt.id = bta.business_type_id";

        $sqlWhere = ' Where p.company=' . $this->getCompany()->getCompanyId();
        if (!$this->hasFullAccess()) {
            $sqlWhere .= ' AND a.branch = ' . $this->getBranch();
           
            // For peons, add further restriction to their own account
            if ($this->isUser()) {
               
                $sqlWhere .= ' AND p.account = ' . $this->getAccountId();
            }
        }
        $sqlWhere .= ' and p.prospectId IN(' . $prospectIds . ')';

        $sql .=  $sqlWhere . $groupBy;
        
        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    public function getSignatureFilePath()
    {
        return UPLOADPATH . '/clients/signatures/signature-' . $this->getAccountId() . '.jpg';
    }

    public function hasSignatureFile()
    {
        return file_exists($this->getSignatureFilePath());
    }

    public function getSignatureWebPath()
    {
        return site_url('uploads/clients/signatures/signature-' . $this->getAccountId() . '.jpg');
    }

    public function hasSendPermission($proposal){
        //check if Golbal Admin
        if (!$this->isGlobalAdministrator()) {

            //Check For Same Company
            if ($this->getCompany() != $proposal->getClient()->getCompany()) {
                return false;
            }
            if (!$this->isAdministrator() && ($this->getFullAccess() == 'no')) { //check if user is not an admin
              
                //if user is branch manager and the proposal is in a differnet branch
                
                if (($this->getAccountId() != $proposal->getClient()->getAccount()->getAccountId()) && ($this->getAccountId() != $proposal->getOwner()->getAccountId())  && ($this->getBranch() != $proposal->getClient()->getAccount()->getBranch())) {
                    
                    //check if allow manual permission
                    return $this->getProposalRepository()->getUserProposalPermission($proposal->getProposalId(),$this->getAccountId());

                    
                }
            }
        }
        return true;
    }

    public function getUserPermissionProposalIds(){
         $user_sql = "select  GROUP_CONCAT(proposal_id SEPARATOR ',') as proposal_ids from proposal_user_permissions where user_id =" . $this->getAccountId();
        
        $proposal_ids_data = $this->db->query($user_sql)->result();
        if($proposal_ids_data[0]->proposal_ids){
            return $proposal_ids_data[0]->proposal_ids;
        }else{
            return false;
        }
    }



    public function getProposalsAutomaticResendData($action = '', $client = '', $limit = true, $map = false, $company = false, $page = false, $numRecords = false, $coords = null, $campaignEmailFilter = null, $resend_id = null)
    {
        //"SELECT COUNT(notes.noteId) as ncount FROM notes WHERE notes.type = 'proposal' AND relationId="
        $this->load->database();
        $firstProposal = $this->getCompany()->getFirstProposalTime();
        if ($limit) {
            $select = 'proposals.proposalId, proposals.projectName, proposals.projectAddress, proposals.projectCity, proposals.projectState, proposals.projectZip, proposals.price, proposals.jobNumber, proposals.created, proposals.status, proposals.duplicateOf, proposals.approvalQueue, proposals.declined, proposals.proposalStatus, proposals.last_activity, proposals.email_status, proposals.deliveryTime, proposals.lastOpenTime, proposals.emailSendTime, proposals.audit_key, proposals.audit_view_time, proposals.audit_reminder_sent, proposals.win_date, proposals.QBID, proposals.unapproved_services, proposals.lat, proposals.lng, proposals.access_key,proposals.estimate_status_id,proposals.job_cost_status,proposals.profit_margin_value,proposals.profit_margin_percent, proposals.image_count,proposals.is_hidden_to_view,proposals.business_type_id,proposals.approved,proposals.layout as proposal_layout,proposals.resend_excluded,proposals.note_count as ncount,proposals.signature_id,proposals.company_signature_id,proposals.proposal_view_count,proposals.owner,proposals.company_id,proposals.resend_enabled,
            accounts.firstName as accountFN, accounts.lastName as accountLN, accounts.branch, accounts.accountId as account,accounts.layout as owner_layout,
            client_companies.name as clientAccountName,
            clients.clientId, clients.title as clientTitle, clients.firstName as clientFN, clients.lastName as clientLN, clients.businessPhone as clientBP, clients.cellPhone as clientCP, clients.companyName as clientCompany, clients.quickbooksId as clientQuickbooksId, clients.email as clientEmail,
            statuses.text as statusText,statuses.sales as is_sales,statuses.color as statusColor,proposal_automatic_resends.sent_at as resend_date';
        } else {
            $select = 'COUNT(proposals.proposalId) AS numProposals';
        }
        // Base query
        $sql = 'SELECT ' . $select . ' FROM proposals';

        if ($limit) {
            //$sql .= " IGNORE INDEX(idx_company_id)";
        }

        $sql.= ' LEFT JOIN clients on proposals.client = clients.clientId
        LEFT JOIN client_companies on clients.client_account = client_companies.id
        LEFT JOIN companies on clients.company = companies.companyId
        LEFT JOIN accounts on proposals.owner = accounts.accountId
        LEFT JOIN statuses on proposals.proposalStatus = statuses.id
        LEFT JOIN proposal_automatic_resends on proposals.proposalId = proposal_automatic_resends.proposal_id
        ';


        // Join required for services so add here //
        $serviceJoin = false;
        // Check for status filters first as these are temporary
        if ($action == 'status') {
            if ($this->session->userdata('pStatusFilter') && $this->session->userdata('pStatusFilterService')) {
                $serviceJoin = true;
            }
        }   // Standard proposals join
        else {
            if ($this->session->userdata('pFilter') && $this->session->userdata('pFilterService') && $action != 'search') {
                $serviceJoin = true;
            }
        }

        if ($serviceJoin) {
            $sql .= ' INNER JOIN proposal_services ON proposal_services.proposal = proposals.proposalId';
        }

        $order = $this->input->get('order');

        // If no order, default to created
        if (!$order) {
            $order = [
                0 => [
                    'column' => 2,
                    'dir' => 'ASC'
                ]
            ];
        }

        // Run permissions check if we're not doing the whole company

        if ($action == 'Resend') {

            // FIrst we have to check for a filter so we can add the join
            if ($campaignEmailFilter) {
                // Join on the PGRE where delivered
                $pResendFilterId = $this->session->userdata('pResendFilterId');
                if ($campaignEmailFilter != 'failed') {
                    $sql .= "  LEFT JOIN proposal_group_resend_email pgre ON proposals.proposalId = pgre.proposal_id  ";
                }
                if ($this->session->userdata('prFilterNotesAdded_' . $resend_id)) {
                    $sql .=  "LEFT JOIN
                    proposal_group_resends pgr ON pgre.resend_id = pgr.id
                        LEFT JOIN
                    notes ON pgre.proposal_id = notes.relationId AND notes.type = 'proposal'";
                }

                // if($campaignEmailFilter=='failed'){
                //     $sql .=  "JOIN
                //     failed_jobs fj ON pgre.resend_id = fj.campaign_id AND fj.job_type = 'proposal_campaign'";
                // }
                //echo  $sql;die;
            }
            if ($campaignEmailFilter == 'failed') {
                $proposal_ids = $this->getResendFailedProposalsIds($this->session->userdata('pResendFilterId'));


                if ($proposal_ids) {

                    $proposal_ids = implode(',', $proposal_ids);
                    $sql .= ' WHERE (proposals.proposalId IN(' . $proposal_ids . ')';
                } else {
                    return [];
                }
                //echo $sql;die;
            } else {
                // Now we have to check it's in the resend
                $proposal_ids = $this->getResendProposalsIds($this->session->userdata('pResendFilterId'));


                if ($proposal_ids) {

                    $proposal_ids = implode(',', $proposal_ids);
                    $sql .= ' WHERE (proposals.proposalId IN(' . $proposal_ids . ')';
                } else {
                    return [];
                }
            }
            if ($campaignEmailFilter) {
                $pResendFilterId = $this->session->userdata('pResendFilterId');
                if ($campaignEmailFilter != 'failed') {
                    if ($this->session->userdata('prFromFilterStatus_' . $resend_id)) {
                        $fromstatusId = $this->session->userdata('prFromFilterStatus_' . $resend_id);
                        $sql .= " AND pgre.resend_id = '$pResendFilterId'  AND pgre.proposal_status_id = '$fromstatusId'";
                    } else {
                        $sql .= " AND pgre.resend_id = '$pResendFilterId'";
                    }
                }
                if ($this->session->userdata('prFilterNotesAdded_' . $resend_id)) {
                    $sql .= " AND notes.added > UNIX_TIMESTAMP(pgr.created)";
                }
            }
            // Now add the WHERE condition
            switch ($campaignEmailFilter) {

                case 'delivered':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.delivered_at IS NOT NULL";
                    break;

                case 'bounced':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.bounced_at IS NOT NULL";
                    break;

                case 'opened':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.opened_at IS NOT NULL";
                    break;

                case 'unopened':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.opened_at IS NULL";
                    break;
                case 'clicked':
                    // Join on the PGRE where delivered
                    $sql .= " AND pgre.clicked_at IS NOT NULL";
                    break;
            }
            if ($this->session->userdata('prFromFilterStatus_' . $resend_id)) {
                $fromstatusId = $this->session->userdata('prFromFilterStatus_' . $resend_id);
                //$sql .= " AND pgre.proposal_status_id = '$fromstatusId'" ;
                //echo $sql;die;
            }
        } else if (!$company) {
            // Filter by user permissions
            if ($this->getUserClass() >= 2) {
                //company admin or full access, access to all proposals
                if($order[0]['column']==3 || $order[0]['column']==2){
                    $sql .= ' WHERE (proposals.company_id =' . $this->getCompany()->getCompanyId();
                }else{
                    $sql .= ' WHERE (clients.company =' . $this->getCompany()->getCompanyId();
                }
                
            } else {
                if ($this->isBranchAdmin()) {
                    //branch admin, can access only his branch
                    $sql .= ' WHERE (accounts.branch = ' . $this->getBranch();
                    if($order[0]['column']==3 || $order[0]['column']==2){
                        $sql .= ' AND proposals.company_id =' . $this->getCompany()->getCompanyId();
                    }else{
                        $sql .= ' AND clients.company =' . $this->getCompany()->getCompanyId();
                    }
                } else {
                    //regular user, can access only his proposals
                    $sql .= ' WHERE (proposals.owner=' . $this->getAccountId();
                }
            }
        } else {
            if($order[0]['column']==3 || $order[0]['column']==2 ){
                $sql .= ' AND proposals.company_id =' . $this->getCompany()->getCompanyId();
            }else{
                $sql .= ' AND clients.company =' . $this->getCompany()->getCompanyId();
            }
            
        }

        if (!$this->isAdministrator() && ($this->getFullAccess() == 'no')) {
            $proposal_ids = $this->getUserPermissionProposalIds();
            if($proposal_ids){

                $sql .= ' OR (proposals.proposalId IN('.$proposal_ids.')) ';
    
                 }
        }
        $sql .= ')';
        // Search
        if ($this->input->get('search')) {

            $search = $this->input->get('search');
            $searchValue = $this->db->escape_like_str($search['value']);

            if (strpos($search['value'], '$') === 0) {
                // Strip out dollar sign and commas and turn into an int
                $priceSearchString = str_replace(['$', ','], ['', ''], $searchValue);
                $priceSearch = intval($priceSearchString);

                if (strlen($priceSearchString) > 0) {
                    // Set upper and lower boundaries
                    $minPriceSearch = $priceSearch - 0.5;
                    $maxPriceSearch = $priceSearch + 0.5;

                    // Add to query
                    $sql .= " AND (proposals.price >= " . $minPriceSearch . " AND proposals.price < " . $maxPriceSearch . ')';
                }
            } else {
                if ($searchValue  != '') {
                    $sql .= " AND ( (proposals.projectName like \"%" . $searchValue . "%\")
                        OR (clients.email like \"%" . $searchValue . "%\")
                        OR (client_companies.name like \"%" . $searchValue . "%\")
                        OR (clients.lastName like \"%" . $searchValue . "%\")
                        OR (clients.firstName like \"%" . $searchValue . "%\")
                        OR (CONCAT(clients.firstName, ' ', clients.lastName) like \"%" . $searchValue . "%\")
                        OR (proposals.projectAddress like \"%" . $searchValue . "%\")
                        OR (proposals.projectCity like \"%" . $searchValue . "%\")
                        OR (proposals.projectState like \"%" . $searchValue . "%\")
                        OR (proposals.projectZip like \"%" . $searchValue . "%\")
                        OR (clients.businessPhone like \"%" . $searchValue . "%\")
                        OR (clients.cellPhone like \"%" . $searchValue . "%\")
                        OR (proposals.jobNumber like \"%" . $searchValue . "%\")
                        )";
                }
            }
        }

        // Client
        if ($client) {
            $sql .= " AND clients.clientId = " . $client;
        }

        // Mappable proposals
        if ($map) {
            $sql .= " AND (proposals.lat IS NOT NULL AND proposals.lng IS NOT NULL)";
        }

        if ($action != 'Resend') {
            // Filters
            if (($action == 'status') && $this->session->userdata('pStatusFilter')) {
                if ($this->session->userdata('pStatusFilterStatus') && $this->session->userdata('pStatusFilterStatus') != 'All') {
                    $sql .= " and (proposals.proposalStatus = '" . $this->session->userdata('pStatusFilterStatus') . "')";
                }

                if (($this->session->userdata('pStatusFilterBranch') && $this->session->userdata('pStatusFilterBranch') != 'All') || ($this->session->userdata('pStatusFilterBranch') === '0')) {

                    $sql .= " and (accounts.branch = '" . $this->session->userdata('pStatusFilterBranch') . "')";
                }

                if ($this->session->userdata('pStatusFilterUser') && $this->session->userdata('pStatusFilterUser') != 'All') {
                    $sql .= " and (clients.account = '" . $this->session->userdata('pStatusFilterUser') . "')";
                }

                if ($this->session->userdata('rollover')) {

                    $start = $firstProposal;
                    $end = mktime(0, 0, 0, 1, 1, date('Y'));

                    $sql .= " and (proposals.created >= {$start})";

                    $sql .= " and (proposals.created <= {$end})";
                } else {
                    if ($this->session->userdata('pStatusFilterFrom')) {
                        $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
                        $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                        $sql .= " and (proposals.created >= {$start})";
                    }

                    if ($this->session->userdata('pStatusFilterTo')) {
                        $to = explode('/', $this->session->userdata('pStatusFilterTo'));
                        $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                        $sql .= " and (proposals.created <= {$end})";
                    }
                }

                if ($this->session->userdata('pStatusFilterService')) {
                    $sql .= ' and proposal_services.initial_service = ' . $this->session->userdata('pStatusFilterService');
                }

                // Status date change from
                if ($this->session->userdata('pStatusFilterChangeFrom')) {
                    $from = explode('/', $this->session->userdata('pStatusFilterChangeFrom'));
                    $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
                    $sql .= " and (proposals.statusChangeDate >= {$start})";
                }
                // Status date change to
                if ($this->session->userdata('pStatusFilterChangeTo')) {
                    $to = explode('/', $this->session->userdata('pStatusFilterChangeTo'));
                    $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);
                    $sql .= " and (proposals.statusChangeDate <= {$end})";
                }

                if ($this->session->userdata('pStatusFilterService')) {
                    $sql .= " and (proposal_services.initial_service IN (" . implode(
                        ', ',
                        $this->session->userdata('pStatusFilterService')
                    ) . "))";
                }

                if ($this->session->userdata('pStatusFilterQueue')) {

                    if ($this->session->userdata('pStatusFilterQueue') == 'duplicate') {
                        $sql .= ' and proposals.duplicateOf IS NOT NULL';
                    } else {
                        if ($this->session->userdata('pStatusFilterQueue') == 1) {
                            $sql .= ' and proposals.approvalQueue = 1';
                        } else {
                            $sql .= ' and proposals.declined = 1';
                        }
                    }
                }

                if ($this->session->userdata('pFilterBusinessType')) {
                    $types = implode(',', $this->session->userdata('pFilterBusinessType'));
                    $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                }
            } else {
                if ($this->session->userdata('pFilter') && $action != 'search') {

                    // Proposal Status
                    if ($this->session->userdata('pFilterStatus')) {
                        //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                        $sql .= " and (proposals.proposalStatus IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterStatus')
                        ) . "))";
                    } else {
                        $sql .= " AND statuses.prospect = 0";
                    }

                    // Estimate Status
                    if ($this->session->userdata('pFilterEstimateStatus')) {
                        $sql .= " and (proposals.estimate_status_id IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterEstimateStatus')
                        ) . "))";
                    }

                    // job Cost Status
                    if ($this->session->userdata('pFilterJobCostStatus')) {
                        $sql .= " and (proposals.job_cost_status IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterJobCostStatus')
                        ) . "))";
                    }
                    // User
                    if ($this->session->userdata('pFilterUser')) {
                        $sql .= " and (proposals.owner IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterUser')
                        ) . "))";
                    } /*else {
                        if ($this->session->userdata('pFilterBranch')) {
                            $sql .= " and (accounts.branch IN (" . implode(
                                ', ',
                                $this->session->userdata('pFilterBranch')
                            ) . "))";
                        }
                    }*/
                    // Account
                    if ($this->session->userdata('pFilterClientAccount')) {
                        $sql .= " AND (clients.client_account IN (" . implode(
                            ',',
                            $this->session->userdata('pFilterClientAccount')
                        ) . "))";
                    }
                    // Created Date from
                    if ($this->session->userdata('pCreatedFrom')) {
                        $start = $this->session->userdata('pCreatedFrom');
                        $sql .= " AND (proposals.created >= {$start})";
                    }
                    // Created Date To
                    if ($this->session->userdata('pCreatedTo')) {
                        $end = $this->session->userdata('pCreatedTo');
                        $sql .= " AND (proposals.created <= {$end})";
                    }

                    // Created Date from
                    if ($this->session->userdata('pNewerThen')) {
                        $start = $this->session->userdata('pNewerThen');
                        $sql .= " AND (proposals.created >= {$start})";
                    }
                    // Created Date To
                    if ($this->session->userdata('pOlderThen')) {
                        $end = $this->session->userdata('pOlderThen');
                        $sql .= " AND (proposals.created <= {$end})";
                    }

                    // Activity Date from
                    if ($this->session->userdata('pActivityFrom')) {
                        $laStart = $this->session->userdata('pActivityFrom');
                        $sql .= " AND (proposals.last_activity >= {$laStart})";
                    }
                    // Activity Date To
                    if ($this->session->userdata('pActivityTo')) {
                        $laEnd = $this->session->userdata('pActivityTo');
                        $sql .= " AND (proposals.last_activity <= {$laEnd})";
                    }

                    // Won Date from
                    if ($this->session->userdata('pWonFrom')) {
                        $wonStart = $this->session->userdata('pWonFrom');
                        $sql .= " AND (proposals.win_date >= {$wonStart})";
                    }
                    // Won Date To
                    if ($this->session->userdata('pWonTo')) {
                        $wonEnd = $this->session->userdata('pWonTo');
                        $sql .= " AND (proposals.win_date <= {$wonEnd})";
                    }

                    if ($this->session->userdata('pFilterService')) {
                        $sql .= " and (proposal_services.initial_service IN (" . implode(
                            ', ',
                            $this->session->userdata('pFilterService')
                        ) . "))";
                    }
                    
                    if ($this->session->userdata('pFilterQueue')) {

                        $addOr = false;
                        $sql .= ' AND (';

                        if (in_array('duplicate', $this->session->userdata('pFilterQueue'))) {
                            $addOr = true;
                            $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                        }

                        if (in_array(1, $this->session->userdata('pFilterQueue'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.approvalQueue = 1)';
                            $addOr = true;
                        }

                        if (in_array(2, $this->session->userdata('pFilterQueue'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.declined = 1)';
                            $addOr = true;
                        }

                        if (in_array('unapproved', $this->session->userdata('pFilterQueue'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.unapproved_services = 1)';
                        }

                        $sql .= ')';
                    }
                    if ($this->session->userdata('pFilterEmailStatus')) {

                        $addOr = false;
                        $sql .= ' AND (';

                        if (in_array('o', $this->session->userdata('pFilterEmailStatus'))) {
                            $addOr = true;
                            $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                        }

                        if (in_array('d', $this->session->userdata('pFilterEmailStatus'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                            $addOr = true;
                        }

                        if (in_array('u', $this->session->userdata('pFilterEmailStatus'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                                AND proposals.deliveryTime IS NULL)';
                            $addOr = true;
                        }

                        if (in_array('uo', $this->session->userdata('pFilterEmailStatus'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                                AND proposals.deliveryTime IS NOT NULL)';
                        }
                        if (in_array('us', $this->session->userdata('pFilterEmailStatus'))) {
                            if ($addOr) {
                                $sql .= ' OR';
                            }
                            $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                        }

                        $sql .= ')';
                    }


                    if ($this->session->userdata('pFilterMinBid')) {
                        if ($this->session->userdata('pFilterMinBid') != 0) {
                            $sql .= ' AND (proposals.price >= ' . $this->session->userdata('pFilterMinBid') . ')';
                        }
                    }

                    if ($this->session->userdata('pFilterMaxBid')) {
                        if ($this->session->userdata('pFilterMaxBid') != $this->getCompany()->getHighestBid()) {
                            $sql .= ' AND (proposals.price <= ' . $this->session->userdata('pFilterMaxBid') . ')';
                        }
                    }

                    if ($this->session->userdata('pFilterBusinessType')) {
                        $types = implode(',', $this->session->userdata('pFilterBusinessType'));
                        $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                    }

                    if ($this->session->userdata('pFilterBusinessType')) {
                        $types = implode(',', $this->session->userdata('pFilterBusinessType'));
                        $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
                    }
                    if ($this->session->userdata('pResendExclude') == '1' && $this->session->userdata('pResendInclude') == '1' || $this->session->userdata('pResendExclude') == '0' && $this->session->userdata('pResendInclude') == '0') {
                    } else {
                        if ($this->session->userdata('pResendExclude')) {

                            $sql .= ' AND proposals.resend_excluded =1';
                        }
                        if ($this->session->userdata('pResendInclude')) {

                            $sql .= ' AND proposals.resend_excluded =0';
                        }
                    }

                    if ($this->session->userdata('pUnsigned') == '1' && $this->session->userdata('pSigned') == '1' || $this->session->userdata('pUnsigned') == '0' && $this->session->userdata('pSigned') == '0') {
                    } else {
                        if ($this->session->userdata('pSigned')) {

                            $sql .= ' AND proposals.signature_id IS NOT NULL';
                        }
                        if ($this->session->userdata('pUnsigned')) {

                            $sql .= ' AND proposals.signature_id IS NULL';
                        }
                    }


                    if ($this->session->userdata('pCompanyUnsigned') == '1' && $this->session->userdata('pCompanySigned') == '1' || $this->session->userdata('pCompanyUnsigned') == '0' && $this->session->userdata('pCompanySigned') == '0') {
                    } else {
                        if ($this->session->userdata('pCompanySigned')) {

                            $sql .= ' AND proposals.company_signature_id IS NOT NULL';
                        }
                        if ($this->session->userdata('pCompanyUnsigned')) {

                            $sql .= ' AND proposals.company_signature_id IS NULL';
                        }
                    }
                }
            }
        } else if ($this->session->userdata('prFilter_' . $resend_id)) {
            
            // Proposal Status
            if ($this->session->userdata('prFilterStatus_' . $resend_id)) {
                //$sql .= " AND (proposals.proposalStatus = '" . $this->session->userdata('pFilterStatus') . "')";
                $sql .= " and (proposals.proposalStatus IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterStatus_' . $resend_id)
                ) . "))";
            } else {
                $sql .= " AND statuses.prospect = 0";
            }

            // Estimate Status
            if ($this->session->userdata('prFilterEstimateStatus_' . $resend_id)) {
                $sql .= " and (proposals.estimate_status_id IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterEstimateStatus_' . $resend_id)
                ) . "))";
            }

            // job Cost Status
            if ($this->session->userdata('prFilterJobCostStatus_' . $resend_id)) {
                $sql .= " and (proposals.job_cost_status IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterJobCostStatus_' . $resend_id)
                ) . "))";
            }
            // User
            if ($this->session->userdata('prFilterUser_' . $resend_id)) {
                $sql .= " and (proposals.owner IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterUser_' . $resend_id)
                ) . "))";
            } else {
                if ($this->session->userdata('prFilterBranch_' . $resend_id)) {
                    $sql .= " and (accounts.branch IN (" . implode(
                        ', ',
                        $this->session->userdata('prFilterBranch_' . $resend_id)
                    ) . "))";
                }
            }
            // Account
            if ($this->session->userdata('prFilterClientAccount_' . $resend_id)) {
                $sql .= " AND (clients.client_account IN (" . implode(
                    ',',
                    $this->session->userdata('prFilterClientAccount_' . $resend_id)
                ) . "))";
            }
            // Created Date from
            if ($this->session->userdata('prCreatedFrom_' . $resend_id)) {
                $start = $this->session->userdata('prCreatedFrom_' . $resend_id);
                $sql .= " AND (proposals.created >= {$start})";
            }
            // Created Date To
            if ($this->session->userdata('prCreatedTo_' . $resend_id)) {
                $end = $this->session->userdata('prCreatedTo_' . $resend_id);
                $sql .= " AND (proposals.created <= {$end})";
            }
            // Activity Date from
            if ($this->session->userdata('prActivityFrom_' . $resend_id)) {
                $laStart = $this->session->userdata('prActivityFrom_' . $resend_id);
                $sql .= " AND (proposals.last_activity >= {$laStart})";
            }
            // Activity Date To
            if ($this->session->userdata('prActivityTo_' . $resend_id)) {
                $laEnd = $this->session->userdata('prActivityTo_' . $resend_id);
                $sql .= " AND (proposals.last_activity <= {$laEnd})";
            }

            // Won Date from
            if ($this->session->userdata('prWonFrom_' . $resend_id)) {
                $wonStart = $this->session->userdata('prWonFrom_' . $resend_id);
                $sql .= " AND (proposals.win_date >= {$wonStart})";
            }
            // Won Date To
            if ($this->session->userdata('prWonTo_' . $resend_id)) {
                $wonEnd = $this->session->userdata('prWonTo_' . $resend_id);
                $sql .= " AND (proposals.win_date <= {$wonEnd})";
            }

            if ($this->session->userdata('prFilterService_' . $resend_id)) {
                $sql .= " and (proposal_services.initial_service IN (" . implode(
                    ', ',
                    $this->session->userdata('prFilterService_' . $resend_id)
                ) . "))";
            }
            if ($this->session->userdata('prFilterQueue_' . $resend_id)) {

                $addOr = false;
                $sql .= ' AND (';

                if (in_array('duplicate', $this->session->userdata('prFilterQueue_' . $resend_id))) {
                    $addOr = true;
                    $sql .= ' (proposals.duplicateOf IS NOT NULL)';
                }

                if (in_array(1, $this->session->userdata('prFilterQueue_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.approvalQueue = 1)';
                    $addOr = true;
                }

                if (in_array(2, $this->session->userdata('prFilterQueue_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.declined = 1)';
                    $addOr = true;
                }

                if (in_array('unapproved', $this->session->userdata('prFilterQueue_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.unapproved_services = 1)';
                }

                $sql .= ')';
            }
            if ($this->session->userdata('prFilterEmailStatus_' . $resend_id)) {

                $addOr = false;
                $sql .= ' AND (';

                if (in_array('o', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    $addOr = true;
                    $sql .= ' (proposals.lastOpenTime IS NOT NULL)';
                }

                if (in_array('d', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.deliveryTime IS NOT NULL)';
                    $addOr = true;
                }

                if (in_array('u', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_SENT . '
                        AND proposals.deliveryTime IS NULL)';
                    $addOr = true;
                }

                if (in_array('uo', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . '
                        AND proposals.deliveryTime IS NOT NULL)';
                }
                if (in_array('us', $this->session->userdata('prFilterEmailStatus_' . $resend_id))) {
                    if ($addOr) {
                        $sql .= ' OR';
                    }
                    $sql .= ' (proposals.email_status = ' . \models\Proposals::EMAIL_UNSENT . ')';
                }

                $sql .= ')';
            }


            if ($this->session->userdata('prFilterMinBid_' . $resend_id)) {
                if ($this->session->userdata('prFilterMinBid_' . $resend_id) != 0) {
                    $sql .= ' AND (proposals.price >= ' . $this->session->userdata('prFilterMinBid_' . $resend_id);
                    if (!$this->session->userdata('prFilterMaxBid_' . $resend_id)) {
                        $sql .= ' OR proposals.price IS NULL)';
                    } else {
                        $sql .= ')';
                    }
                }
            }

            if ($this->session->userdata('prFilterMaxBid_' . $resend_id)) {
                if ($this->session->userdata('prFilterMaxBid_' . $resend_id) != $this->getCompany()->getHighestBid()) {
                    $sql .= ' AND (proposals.price <= ' . $this->session->userdata('prFilterMaxBid_' . $resend_id);
                    if (!$this->session->userdata('prFilterMinBid_' . $resend_id)) {
                        $sql .= ' OR proposals.price IS NULL)';
                    } else {
                        $sql .= ')';
                    }
                }
            }

            if ($this->session->userdata('prFilterBusinessType_' . $resend_id)) {
                $types = implode(',', $this->session->userdata('prFilterBusinessType_' . $resend_id));
                $sql .= ' AND proposals.business_type_id IN (' . $types . ')';
            }

            

            if ($this->session->userdata('prResendExclude_'.$resend_id) == '1' && $this->session->userdata('prResendInclude_'.$resend_id) == '1' || $this->session->userdata('prResendExclude_'.$resend_id) == '0' && $this->session->userdata('prResendInclude_'.$resend_id) == '0') {
            } else {
                if ($this->session->userdata('prResendExclude_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.resend_excluded =1';
                    
                }
                if ($this->session->userdata('prResendInclude_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.resend_excluded =0';
                    
                }
            }

            if ($this->session->userdata('prUnsigned_'.$resend_id) == '1' && $this->session->userdata('prSigned_'.$resend_id) == '1' || $this->session->userdata('prUnsigned_'.$resend_id) == '0' && $this->session->userdata('prSigned_'.$resend_id) == '0') {
            } else {
                if ($this->session->userdata('prSigned_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.signature_id IS NOT NULL';
                    
                }
                if ($this->session->userdata('prUnsigned_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.signature_id IS NULL';
                    
                }
            }

            if ($this->session->userdata('prCompanyUnsigned_'.$resend_id) == '1' && $this->session->userdata('prCompanySigned_'.$resend_id) == '1' || $this->session->userdata('prCompanyUnsigned_'.$resend_id) == '0' && $this->session->userdata('prCompanySigned_'.$resend_id) == '0') {
            } else {
                if ($this->session->userdata('prCompanySigned_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.company_signature_id IS NOT NULL';
                    
                }
                if ($this->session->userdata('prCompanyUnsigned_'.$resend_id)=='1') {

                    $sql .= ' AND proposals.company_signature_id IS NULL';
                    
                }
            }
            
        }


        // Map coordinates
        if ($coords) {
            $sql .= " AND proposals.lat < " . $coords['x1'] . "
                      AND proposals.lng < " . $coords['x2'] . "
                      AND proposals.lat > " . $coords['y1'] . "
                      AND proposals.lng > " . $coords['y2'];
        }

        $sql .= " AND proposal_automatic_resends.id IS NOT NULL ";
        //$sql .= " AND pgre.proposal_status_id =1";
        // Searching on services can give duplicate results - this stops that
        if ($this->session->userdata('pFilterService')) {
            if($limit){
                 $sql .= ' GROUP BY proposals.proposalId';
            }
        }
        if ($this->session->userdata('prFilterNotesAdded_' . $resend_id)) {
            if($limit){
                 $sql .= ' GROUP BY proposals.proposalId';
            }
        }

        if ($this->input->get('order') && $limit) {

            ///SORTING
            $order = $this->input->get('order');

            switch ($order[0]['column']) {
                case 2: // date
                    $sql .= ' ORDER BY proposal_automatic_resends.sent_at ' . $order[0]['dir'];
                    break;
                
                case 3: // date
                    $sql .= ' ORDER BY proposals.created ' . $order[0]['dir'];
                    break;
                case 4: // status
                    $sql .= ' ORDER BY statusText ' . $order[0]['dir'];
                    break;
                case 5: // job Number
                    $sql .= ' ORDER BY lpad(proposals.jobNumber, 10, 0) ' . $order[0]['dir'];
                    break;
                case 6: // Client Account Name
                    $sql .= ' ORDER BY client_companies.name ' . $order[0]['dir'];
                    break;
                case 7: // Project Name
                    $sql .= ' ORDER BY proposals.projectName ' . $order[0]['dir'];
                    break;
                case 8: // Image Count
                    $sql .= ' ORDER BY proposals.image_count ' . $order[0]['dir'];
                    break;
                case 9: // Price
                    $sql .= ' ORDER BY proposals.price ' . $order[0]['dir'];
                    break;
                case 10: // Contact
                    $sql .= ' ORDER BY clients.firstName ' . $order[0]['dir'];
                    break;
                case 11: // Owner
                    $sql .= ' ORDER BY accounts.firstName ' . $order[0]['dir'];
                    break;
                case 12: // Last Activity
                    $sql .= ' ORDER BY proposals.last_activity ' . $order[0]['dir'] . ' , proposals.created DESC';
                    break;
                case 13: // Email Status
                    $sql .= ' ORDER BY proposals.email_status ' . $order[0]['dir'];
                    break;
                case 14: // Delivery Status
                    $sql .= ' ORDER BY proposals.deliveryTime ' . $order[0]['dir'];
                    break;
                case 15: // Open Status
                    $sql .= ' ORDER BY proposals.lastOpenTime ' . $order[0]['dir'];
                    break;
                case 16: // Audit View Time
                    $sql .= ' ORDER BY proposals.audit_view_time ' . $order[0]['dir'] . ', proposals.audit_key ' . $this->input->get('sSortDir_0');
                    break;
                case 17: // Estimate type View
                    $sql .= ' ORDER BY proposals.estimate_status_id ' . $order[0]['dir'];
                    break;
            }
        }

        // Limit for paging if we're not counting
        if ($limit) {
            if ($limit !== 10000) {
                $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
            }
        }

        if (!is_int($page) && $numRecords) {
            $start = ($numRecords * $page);
            $sql .= ' LIMIT ' . $start . ', ' . $numRecords;
        }

         if(!$limit){
            //echo $sql;die;
            return $this->db->query($sql)->result()[0]->numProposals;
         }else{
            $data = $this->db->query($sql)->result();
            $this->db->close();

            // Return the data
            return $data;
         }


        // Return the data
        //return $this->db->query($sql)->result();
    }

    function getMasterCompaniesTableData($count = false)
    {
        // Base query
        $sql = "SELECT c.companyId, c.companyName, c.companyStatus, c.new_layouts, c.psa, c.administrator,c.estimating,
                CONCAT(a.firstName, ' ', a.lastName) AS adminFullName,
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId OR a.parent_company_id = c.companyId) AS numUsers,            
                (SELECT COUNT(accountId) FROM accounts a WHERE (a.company = c.companyId OR a.parent_company_id = c.companyId) AND a.secretary <> 1 AND a.expires > " . time() . ") AS numPaidUsers,                
                (SELECT COUNT(accountId) FROM accounts a WHERE (a.company = c.companyId OR a.parent_company_id = c.companyId) AND a.secretary <> 1 AND a.expires < " . time() . ") AS numInactiveUsers,           
                (SELECT MIN(expires) FROM accounts a WHERE (a.company = c.companyId OR a.parent_company_id = c.companyId) AND a.secretary <> 1 AND a.expires > " . time() . ") AS nextExpiry,
                (SELECT COUNT(notes.noteId) FROM notes WHERE notes.type = 'company' AND relationId=c.companyId) as ncount    
            FROM companies c
            LEFT JOIN accounts a ON c.administrator = a.accountId";

        $sortCol = $this->input->get('order')[0]['column'];
        $sortDir = $this->input->get('order')[0]['dir'];

        // We need a where to kick things off
        $sql .= " WHERE c.companyId > 0 AND is_master = 1";

        // Search
        $searchVal = $this->input->get('search')['value'];
        $searchVal = $this->db->escape_like_str($searchVal);

        if ($searchVal) {
            $sql .= " AND ((CONCAT(a.firstName, ' ', a.lastName) LIKE '%" . $searchVal . "%')
                    OR (c.companyName like '%" . $searchVal . "%'))";
        }


        // Filters
        if ($this->session->userdata('adminStatusFilter')) {
            $sql .= " AND c.companyStatus = '" . $this->session->userdata('adminStatusFilter') . "'";
        }

        if ($this->session->userdata('adminStatusExpiredFilter')) {

            switch ($this->session->userdata('adminStatusExpiredFilter')) {

                case 'Active':
                    $sql .= ' HAVING numInactiveUsers < numUsers';
                    break;

                case 'Expired':
                    $sql .= ' HAVING numInactiveUsers = numUsers';
                    break;
            }
        }


        // Sorting
        switch ($sortCol) {

            case 1: // Company ID
                $sql .= ' ORDER BY c.companyId ' . $sortDir;
                break;

            case 2: // Company Name
                $sql .= ' ORDER BY c.companyName ' . $sortDir;
                break;

            case 3: // Company Name
                $sql .= ' ORDER BY c.companyStatus ' . $sortDir;
                break;

            case 4: // Num Users
                $sql .= ' ORDER BY numUsers ' . $sortDir;
                break;

            case 5: // Num Paid Users
                $sql .= ' ORDER BY numPaidUsers ' . $sortDir;
                break;

            case 6: // Num Inactive Users
                $sql .= ' ORDER BY numInactiveUsers ' . $sortDir;
                break;

            case 7: // Num Inactive Users
                $sql .= ' ORDER BY nextExpiry ' . $sortDir;
                break;

            case 8: // Admin
                $sql .= ' ORDER BY adminFullName ' . $sortDir;
                break;

            case 9: // Layouts
                $sql .= ' ORDER BY new_layouts ' . $sortDir;
                break;

            case 10: // PSA
                $sql .= ' ORDER BY psa ' . $sortDir;
                break;
            case 11: // PSA
                $sql .= ' ORDER BY estimating ' . $sortDir;
                break;
        }

        if ($count) {
            return count($this->db->query($sql)->result());
            
        }
        if ($this->input->get('length') != -1) {
            // Paging
            $sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }


        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }


    public function getParentDashboardBusinessTypesTableData($users,$companyIds, $count = false)
    {
        $this->load->database();


        $bidCountSubQuery = "(SELECT COUNT(*) FROM proposals p  
        WHERE p.business_type_id = bt.id ";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidCountSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidCountSubQuery .= ' AND p.owner IN(' . $users . ')';

        $bidCountSubQuery .= " ) AS numProposals";



        // Build bid amount subquery
        $bidAmtSubQuery = " (SELECT SUM(p.price) FROM proposals p 
        WHERE p.business_type_id = bt.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidAmtSubQuery .= ' AND p.owner IN(' . $users . ')';

        $bidAmtSubQuery .= " ) AS totalBid";




        // subquery for Sold amount

        $bidSoldAmtSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, statuses st
        WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidSoldAmtSubQuery .= " AND (p.win_date >= " . $start . " AND p.win_date <= " . $end . ")";
        }

        // Show all accounts
        $bidSoldAmtSubQuery .= ' AND p.owner IN(' . $users . ')';


        $bidSoldAmtSubQuery .= " ) AS totalSold";

        // subquery for Sold amount

        $bidWinSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) * 100 / SUM(p.price)  AS percent_total FROM proposals p, statuses st
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";


        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidWinSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // SHow all accounts
        $bidWinSubQuery .= ' AND p.owner IN(' . $users . ')';

        $bidWinSubQuery .= " ) AS percent_total";


        // subquery for Open amount

        $bidOpenAmtSubQuery = " (SELECT SUM(CASE WHEN (st.id = '1') THEN p.price ELSE 0 END) as total_sold_amount FROM proposals p, statuses st
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOpenAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOpenAmtSubQuery .= ' AND p.owner IN(' . $users . ')';


        $bidOpenAmtSubQuery .= " ) AS totalOpen";

        // subquery for Other total amount

        $bidOtherAmtSubQuery = " (SELECT SUM(CASE WHEN st.id != '1' AND st.sales != '1' THEN p.price ELSE 0 END) as total_other_amount FROM proposals p, statuses st 
           
            WHERE p.business_type_id = bt.id AND p.proposalStatus = st.id AND  p.duplicateOf IS NULL";

        // Date filter applies to bid subquery

        if ($this->session->userdata('pStatusFilterFrom') && $this->session->userdata('pStatusFilterTo')) {
            $from = explode('/', $this->session->userdata('pStatusFilterFrom'));
            $start = mktime(0, 0, 0, $from[0], $from[1], $from[2]);
            $to = explode('/', $this->session->userdata('pStatusFilterTo'));
            $end = mktime(23, 59, 59, $to[0], $to[1], $to[2]);

            $bidOtherAmtSubQuery .= " AND (p.created >= " . $start . " AND p.created <= " . $end . ")";
        }

        // Show all accounts
        $bidOtherAmtSubQuery .= ' AND p.owner IN(' . $users . ')';


        $bidOtherAmtSubQuery .= " ) AS totalOther";

        //echo $bidClientSubQuery;die;
        // Base query
        $sql = 'SELECT bt.id, bt.type_name,
           ' . $bidWinSubQuery . ', ' .
            $bidSoldAmtSubQuery . ', ' .
            $bidCountSubQuery . ', ' .
            $bidOpenAmtSubQuery . ', ' .
            $bidOtherAmtSubQuery . ', ' .
            $bidAmtSubQuery . '
            FROM business_types bt
            
            WHERE bt.company_id IS NULL OR bt.company_id IN(' . implode(',',$companyIds).')';


        $searchVal = $this->input->get('search')['value'];
        // Search
        if ($searchVal) {
            $sql .= " AND ((bt.type_name LIKE \"%" . $searchVal . "%\")
                   )";
        }

        $sql .= ' HAVING numProposals > 0 ';
        // Sorting

        if ($this->input->get('order')) {

            ///SORTING
            $order = $this->input->get('order');

            switch ($order[0]['column']) {
                case 0: // Account Name
                    $sql .= ' ORDER BY bt.type_name ' . $order[0]['dir'];
                    break;
                case 1: // status
                    $sql .= ' ORDER BY numProposals ' . $order[0]['dir'];
                    break;
                case 2: // job Number
                    $sql .= ' ORDER BY totalBid ' . $order[0]['dir'];
                    break;
                case 3: // Company
                    $sql .= ' ORDER BY totalOpen ' . $order[0]['dir'];
                    break;
                case 4: // Sold
                    $sql .= ' ORDER BY totalOther ' . $order[0]['dir'];
                    break;
                case 5: // Sold
                    $sql .= ' ORDER BY totalSold ' . $order[0]['dir'];
                    break;
                case 6: // Win
                    $sql .= ' ORDER BY percent_total ' . $order[0]['dir'];
                    break;
            }
        }

        if (!$count) {
            //$sql .= ' LIMIT ' . $this->input->get('start') . ', ' . $this->input->get('length');
        }

        $data = $this->db->query($sql)->result();
        $this->db->close();

        // Return the data
        return $data;
    }

    public function sendAccountAddEmailToSupport()
    {
        $emailTemplate = $this->doctrine->em->findAdminTemplate(56);
        $etp = new \EmailTemplateParser();
        $etp->setAccount($this);
        $etp->createPassword = true;
        $subject = $etp->parse($emailTemplate->getTemplateSubject()); 
        $content = $etp->parse($emailTemplate->getTemplateBody(), true);
        $emailData = [
            'to' => 'support@'.SITE_EMAIL_DOMAIN,
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@'.SITE_EMAIL_DOMAIN,
            'subject' => $subject,
            'body' => $content,
            'categories' => ['New User Added'],
        ]; 

        // echo "<pre>";
        // print_r($emailData);die;
        $this->getEmailRepository()->send($emailData);
    }


    // Get expire company data
    // function getExpireAdminCompaniesTableData($count = false)
    // {
    //     // Base query
    //     $sql = "SELECT c.companyId, c.companyName, c.companyStatus,
    //             CONCAT(a.firstName, ' ', a.lastName) AS adminFullName,a.expires,a.created
    //             FROM companies c
    //             LEFT JOIN accounts a ON c.administrator = a.accountId
    //             WHERE a.company = c.companyId AND a.parent_user_id = 0 AND a.expires < " . time();
    
    //     // We need a where to kick things off
    //     if ($count) {
    //         return count($this->db->query($sql)->result());
    //     }
    
    //     $sql .= " AND c.companyId > 0";
    //     echo $sql;
    
    //     $data = $this->db->query($sql)->result();
    //     $this->db->close();
    
    //     // Return the data
    //     return $data;
    // }

  // Get expire company data
function getExpireAdminCompaniesTableData()
{
    // Base query
    $sql = "SELECT c.companyId, c.companyName, c.companyStatus,
            CONCAT(a.firstName, ' ', a.lastName) AS adminFullName, a.expires, a.created
            FROM companies c
            LEFT JOIN accounts a ON c.administrator = a.accountId
            WHERE a.company = c.companyId AND a.parent_user_id = 0 
                AND DATEDIFF(CURRENT_DATE(), FROM_UNIXTIME(a.created)) < 15 
                AND a.expires < " . time(); //if user expand the plan witing 14 days
            // We need a where to kick things off
            $sql .= " AND c.companyId > 0";
            $data = $this->db->query($sql)->result(); 
            $this->db->close();

    // Return the data
    return $data;
}
 
     /**
     * Getter for Work Order Setting
     * @return mixed
     */
    public function getWorkOrderSetting()
    {
         return ($this->work_order_setting !== "" && $this->work_order_setting !== NULL) ? $this->work_order_setting : $this->getOwner()->getWorkOrderSetting();
    } 

    /**
     * Setter for Work Order Setting
     * @var $work_order_setting
     */
    public function setWorkOrderSetting($work_order_setting)
    {
        $this->work_order_setting = $work_order_setting;
    }

    /**
     * Getter for  auth login
     * @return mixed
     */
    public function getAuthLogin()
    {
        return $this->auth_login;
    } 
   /**
     * Setter for auth login
     * @var $auth_login
     */
    public function setAuthLogin($auth_login)
    {
        $this->auth_login = $auth_login;
    }

    /**
     * Getter for  email otp
     * @return mixed
     */
    public function getEmailOtp()
    {
        return $this->email_otp;
    } 
   /**
     * Setter for email otp
     * @var $email_otp
     */
    public function setEmailOtp($email_otp)
    {
        $this->email_otp = $email_otp;
    }

    /**
     * Getter for  otp time
     * @return mixed
     */
    public function getOtpTime()
    {
        return $this->otp_time;
    } 
   /**
     * Setter for otp time
     * @var $otp_time
     */
    public function setOtpTime($otp_time)
    {
        $this->otp_time = $otp_time;
    }



}
