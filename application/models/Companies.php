<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="companies")
 */
class Companies extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $companyId;
    /**
     * @ORM\OneToOne(targetEntity="Accounts", cascade={"persist"})
     * @ORM\JoinColumn(name="administrator", referencedColumnName="accountId")
     */
    private $administrator;
    /**
     * @ORM\OneToMany(targetEntity="Accounts", mappedBy="company", cascade={"persist"})
     * @ORM\OrderBy({"firstName" = "ASC"})
     */
    private $accounts;
    /**
     * @ORM\OneToMany(targetEntity="Clients", mappedBy="company", cascade={"persist"})
     */
    private $clients;
    /**
     * @ORM\OneToMany(targetEntity="Attatchments", mappedBy="company", cascade={"persist"})
     */
    private $attatchments;
    /**
     * @ORM\OneToMany(targetEntity="ClientEmailTemplate", mappedBy="company", cascade={"persist"})
     */
    private $clientEmails;
    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $companyName;
    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $companyAddress;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $companyLogo;
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $companyPhone;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $companyCity;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $companyZip;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $companyCountry;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $companyState;
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $alternatePhone;
    /**
     * @ORM\Column(type="string", length=32)
     */
    private $hearAboutUs;
    /**
     * @ORM\Column(type="string")
     */
    private $companyWebsite;
    /**
     * @ORM\Column(type="string")
     */
    private $aboutCompany;
    /**
     * @ORM\Column(type="string")
     */
    private $contractCopy;
    /**
     * @ORM\Column(type="integer")
     */
    private $created;
    /**
     * @ORM\Column(type="string",nullable=true,length=2048)
     */
    private $custom_texts_order;
    /**
     * @ORM\Column(type="string",nullable=true,length=16)
     */
    private $companyStatus;
    /**
     * @ORM\Column(type="string",nullable=true,length=9000)
     */
    private $standardLayoutIntro;
    /**
     * @ORM\Column(type="string",nullable=true,length=10000)
     */
    private $paymentTermText;
    /**
     * @ORM\Column(type="string",nullable=true,length=16)
     */
    private $paymentTerm;
    /**
     * @ORM\Column(type="string",nullable=true,length=255)
     */
    private $pdfHeader;
    /**
     * @ORM\Column(type="integer")
     */
    private $defaultBidApproval;
    /**
     * @ORM\Column(type="integer")
     */
    private $use_auto_num;
    /**
     * @ORM\Column(type="string")
     */
    private $auto_num_prefix;
    /**
     * @ORM\Column(type="integer")
     */
    private $auto_num;
    /**
     * @ORM\Column(type="string")
     */
    private $layout;
    /**
     * @ORM\Column(type="string")
     */
    private $standard_header_font = 'Helvetica';
    /**
     * @ORM\Column(type="string")
     */
    private $standard_text_font = 'Helvetica';
    /**
     * @ORM\Column(type="string")
     */
    private $cool_header_font = 'Helvetica';
    /**
     * @ORM\Column(type="string")
     */
    private $cool_text_font = 'Helvetica';
    /**
     * @ORM\Column(type="string")
     */
    private $header_font = 'Helvetica';
    /**
     * @ORM\Column(type="string")
     */
    private $text_font = 'Helvetica';
    /**
     * @ORM\Column(type="string")
     */
    private $gradient_opacity = '0.4';
    /**
     * @ORM\Column(type="string")
     */
    private $header_bg_color = '000000';
    /**
     * @ORM\Column(type="string")
     */
    private $header_bg_opacity = '1';
    /**
     * @ORM\Column(type="string")
     */
    private $header_font_color = 'ffffff';
    /**
     * @ORM\Column(type="integer")
     */
    private $new_layouts = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $psa = 0;
    /**
     * @ORM\Column(type="string")
     */
    private $zs_customer_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $qb_setting_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $estimating = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $userCheck = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_background = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_show_proposal_logo = 0;
   /**
     * @ORM\Column(type="string")
     */
    private $company_intro;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_master = 0;
      /**
      * @ORM\Column(type="integer")
     */
    private $sales_manager = 0;

    /**
      * @ORM\Column(type="integer")
     */
    private $modify_price = 0;

    /**
      * @ORM\Column(type="integer")
     */
    private $is_proposal = 0;

    /**
      * @ORM\Column(type="integer")
     */
    private $proposalCampaigns = 0;
    
      /**
      * @ORM\Column(type="integer")
     */
    private $proposal_checklist = 0;

      /**
     * @ORM\Column(type="integer")
     */
    private $work_order_setting;

    function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->created = time();
        $this->companyStatus = 'Active';
        $this->paymentTerm = 0;
        //init contract copy
        $this->contractCopy = '<p>
         You are hereby authorized to proceed with the work as identified in this contract. By signing and returning this contract, you are authorized to proceed with the work as stated.<br />
         <br />
         We understand that if any additional work is required different than stated in the this proposal/contract it must be in a new contract or added to this contract.<br />
         <br />
         Please see all attachments for special conditions that may pertain to aspects of this project.</p>';
        $this->pdfHeader = 'Service Provider Information';

        $this->load->library('doctrine');
    }
 
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return \models\Accounts
     */
    function getAdministrator()
    {
        return $this->administrator;
    }

    function setAdministrator($administrator)
    {
        $this->administrator = $administrator;
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    function getAccounts($deleted = 0)
    {
        if (!$deleted) {
            $accounts = new \Doctrine\Common\Collections\ArrayCollection();
            foreach ($this->accounts as $account) {
                if (!$account->isDeleted()) {
                    $accounts->add($account);
                }
            }
            return $accounts;
        } else {
            return $this->accounts;
        }
    }

    public function getAllAccounts()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('a')
            ->from('\models\Accounts', 'a')
            ->where('a.company = :companyId')
            ->setParameter('companyId', $this->getCompanyId());

        // Create the query and get the result
        $query = $qb->getQuery();
        $accounts = $query->getResult();

        return $accounts;
    }

    function getClients($deleted = 0)
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

    function getPsaSearchClients($query) {

        $this->load->database();

        $sql = "SELECT c.clientId, 
                CONCAT(a.firstName, ' ', a.lastName) AS ownerFullName,
                CONCAT(c.firstName, ' ', c.lastName) AS fullName,
                cc.name as clientCompanyName        
            FROM clients c
              LEFT JOIN client_companies cc ON c.client_account = cc.id
              LEFT JOIN accounts a ON c.account = a.accountId
            WHERE c.company = " . $this->getCompanyId();

        $sql .= (" AND ((cc.name LIKE \"%" . $query . "%\")
                    OR (c.lastName LIKE \"%" . $query . "%\")
                    OR (c.firstName LIKE \"%" . $query . "%\")
                    OR (c.firstName LIKE \"%" . $query . "%\")
                    OR (CONCAT_WS(' ', cc.name, c.firstName, c.lastName) LIKE \"%" . $query . "%\")
                    OR (CONCAT_WS(' ', c.firstName, c.lastName) LIKE \"%" . $query . "%\"))");

        $sql .= ' LIMIT 8';

        $clientData = $this->db->query($sql)->result();

        return $clientData;
    }

    public function getPsaSearchProposals($clientId)
    {
        $this->load->database();

        // Base query
        $sql = 'SELECT proposals.proposalId, proposals.projectName
        FROM proposals
        WHERE  client = ' . $clientId . '
        ORDER BY projectName ASC';

        $proposalsData = $this->db->query($sql)->result();

        return $proposalsData;
    }

    public function getCompanyAddress()
    {
        return $this->companyAddress;
    }

    public function setCompanyAddress($companyAddress)
    {
        $this->companyAddress = $companyAddress;
    }

    public function getCompanyPhone()
    {
        return $this->companyPhone;
    }

    public function setCompanyPhone($companyPhone)
    {
        $this->companyPhone = $companyPhone;
    }

    public function getHearAboutUs()
    {
        return $this->hearAboutUs;
    }

    public function setHearAboutUs($hearAboutUs)
    {
        $this->hearAboutUs = $hearAboutUs;
    }

    public function getCompanyLogo()
    {
        if ((file_exists(UPLOADPATH . '/clients/logos/' . $this->companyLogo)) && (is_file(UPLOADPATH . '/clients/logos/' . $this->companyLogo))) {
            return $this->companyLogo;
        } else {
            return 'none.jpg';
        }
    }

    public function getCompanyEmailLogo()
    {
        if ((file_exists(UPLOADPATH . '/clients/logos/' . $this->companyLogo)) && (is_file(UPLOADPATH . '/clients/logos/' . $this->companyLogo))) {
            return $this->companyLogo;
        } else {
            return 'blank-email-template.png';
        }
    }

    public function setCompanyLogo($companyLogo)
    {
        $this->companyLogo = $companyLogo;
    }

    public function getClientAccounts($alpha = false)
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('cc')
            ->from('\models\ClientCompany', 'cc')
            ->from('\models\Accounts', 'a')
            ->where('cc.owner_user = a.accountId')
            ->andWhere('a.company = :companyId')
            ->setParameter('companyId', $this->getCompanyId());

        if ($alpha) {
            $qb->orderBy('cc.name');
        }

        // Create the query and get the result
        $query = $qb->getQuery();
        $accounts = $query->getResult();

        return $accounts;
    }

    public function getBranches()
    {

        $CI = &get_instance();

        $dql = "SELECT b
                FROM \models\Branches b
                WHERE b.company = :companyId
                ORDER BY b.branchName ASC";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        return $query->getResult();
    }

    public function getProposals()
    {
        $proposals = new ArrayCollection();
        $accounts = $this->getAccounts();
        foreach ($accounts as $account) {
            $props = $account->getProposals();
            foreach ($props as $prop) {
                $proposals->add($prop);
            }
        }
        return $proposals;
    }

    public function getCompanyCountry()
    {
        return $this->companyCountry;
    }

    public function setCompanyCountry($companyCountry)
    {
        $this->companyCountry = $companyCountry;
    }

    public function getCompanyState()
    {
        return $this->companyState;
    }

    public function setCompanyState($companyState)
    {
        $this->companyState = $companyState;
    }

    public function getCompanyZip()
    {
        return $this->companyZip;
    }

    public function setCompanyZip($companyZip)
    {
        $this->companyZip = $companyZip;
    }

    public function getCompanyCity()
    {
        return $this->companyCity;
    }

    public function setCompanyCity($companyCity)
    {
        $this->companyCity = $companyCity;
    }

    //this is actually fax
    public function getAlternatePhone()
    {
        return $this->alternatePhone;
    }

    public function setAlternatePhone($alternatePhone)
    {
        $this->alternatePhone = $alternatePhone;
    }

    public function getFax()
    {
        return $this->alternatePhone;
    }

    public function setFax($alternatePhone)
    {
        $this->alternatePhone = $alternatePhone;
    }

    public function getCompanyWebsite()
    {
        return addHttp($this->companyWebsite);
    }

    public function setCompanyWebsite($companyWebsite)
    {
        $this->companyWebsite = $companyWebsite;
    }

    public function addAttatchment($attatchment)
    {
        $this->attatchments[] = $attatchment;
    }

    public function getAttatchments()
    {
        return $this->attatchments;
    }

    public function getAboutCompany()
    {
        return $this->aboutCompany;
    }

    public function setAboutCompany($aboutCompany)
    {
        $this->aboutCompany = $aboutCompany;
    }

    public function getContractCopy()
    {
        return $this->contractCopy;
    }

    public function setContractCopy($contractCopy)
    {
        $this->contractCopy = $contractCopy;
    }

    public function getCreated($timestamp = true)
    {
        if ($timestamp) {
            return $this->created;
        } else {
            return date('m/d/Y', $this->created);
        }
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCustomTextsOrder()
    {
        return $this->custom_texts_order;
    }

    public function setCustomTextsOrder($customTextsOrder)
    {
        $this->custom_texts_order = $customTextsOrder;
    }

    public function getCompanyStatus()
    {
        return $this->companyStatus;
    }

    public function setCompanyStatus($companyStatus)
    {
        $this->companyStatus = $companyStatus;
    }

    public function getStandardLayoutIntro()
    {
        return $this->standardLayoutIntro;
    }

    public function setStandardLayoutIntro($layoutIntro)
    {
        $this->standardLayoutIntro = $layoutIntro;
    }

    public function getPaymentTermText()
    {
        return $this->paymentTermText;
    }

    public function setPaymentTermText($paymentTermText)
    {
        $this->paymentTermText = $paymentTermText;
    }

    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }

    public function setPaymentTerm($paymentTerm)
    {
        $this->paymentTerm = $paymentTerm;
    }

    public function getPdfHeader()
    {
        return $this->pdfHeader;
    }

    public function setPdfHeader($pdfHeader)
    {
        $this->pdfHeader = $pdfHeader;
    }

    /**
     * @return mixed
     */
    public function getDefaultBidApproval()
    {
        return $this->defaultBidApproval;
    }

    /**
     * @param mixed $defaultBidApproval
     */
    public function setDefaultBidApproval($defaultBidApproval)
    {
        $this->defaultBidApproval = $defaultBidApproval;
    }

    /**
     * @return mixed
     */
    public function getAutoNum()
    {
        return $this->auto_num;
    }

    /**
     * @param mixed $auto_num
     */
    public function setAutoNum($auto_num)
    {
        $this->auto_num = $auto_num;
    }

    /**
     * @return mixed
     */
    public function getAutoNumPrefix()
    {
        return $this->auto_num_prefix;
    }

    /**
     * @param mixed $auto_num_prefix
     */
    public function setAutoNumPrefix($auto_num_prefix)
    {
        $this->auto_num_prefix = $auto_num_prefix;
    }

    /**
     * @return mixed
     */
    public function getUseAutoNum()
    {
        return $this->use_auto_num;
    }

    /**
     * @param mixed $use_auto_num
     */
    public function setUseAutoNum($use_auto_num)
    {
        $this->use_auto_num = $use_auto_num;
    }

    /**
     * @return mixed
     */
    public function getHeaderBgColor()
    {
        return $this->header_bg_color;
    }

    /**
     * @param mixed $header_bg_color
     */
    public function setHeaderBgColor($header_bg_color)
    {
        $this->header_bg_color = $header_bg_color;
    }

    /**
     * @return mixed
     */
    public function getHeaderBgOpacity()
    {
        return $this->header_bg_opacity;
    }

    /**
     * @param mixed $header_bg_opacity
     */
    public function setHeaderBgOpacity($header_bg_opacity)
    {
        $this->header_bg_opacity = $header_bg_opacity;
    }

    /**
     * @return mixed
     */
    public function getHeaderFontColor()
    {
        return $this->header_font_color;
    }

    /**
     * @param mixed $header_font_color
     */
    public function setHeaderFontColor($header_font_color)
    {
        $this->header_font_color = $header_font_color;
    }

    /**
     * @return mixed
     */
    public function getNewLayouts()
    {
        return $this->new_layouts;
    }

    /**
     * @param mixed $new_layouts
     */
    public function setNewLayouts($new_layouts)
    {
        $this->new_layouts = $new_layouts;
    }

    public function hasPSA()
    {
        return $this->getPsa();
    }

    /**
     * @return mixed
     */
    public function getPsa()
    {
        return $this->psa;
    }

    /**
     * @param mixed $psa
     */
    public function setPsa($psa)
    {
        $this->psa = $psa;
    }

    /**
     * @return mixed
     */
    public function getZsCustomerId()
    {
        return $this->zs_customer_id;
    }

    /**
     * @param mixed $zs_customer_id
     */
    public function setZsCustomerId($zs_customer_id)
    {
        $this->zs_customer_id = $zs_customer_id;
    }


    /**
     * @return mixed
     */
    public function getQbSettingId()
    {
        return $this->qb_setting_id;
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

    /**
     * @return mixed
     */
    public function getProposalBackground()
    {
        return $this->proposal_background;
    }

    /**
     * @param mixed $proposal_background
     */
    public function setProposalBackground($proposal_background)
    {
        $this->proposal_background = $proposal_background;
    }

    /**
     * @return mixed
     */
    public function getIsShowProposalLogo()
    {
        return $this->is_show_proposal_logo;
    }

    /**
     * @param mixed $is_show_proposal_logo
     */
    public function setIsShowProposalLogo($is_show_proposal_logo)
    {
        $this->is_show_proposal_logo = $is_show_proposal_logo;
    }

    /**
     * @return bool
     */
    public function hasQb()
    {
        return ($this->getQbSettingId() ? true : false);
    }

    public function getQbType()
    {
        $settings = $this->getQuickbooksSettings();

        if (!$settings) {
            return false;
        }

        else {
            return $settings->getQbConnectionType();
        }
    }

    /**
     * @param mixed $qb_setting_id
     */
    public function setQbSettingId($qb_setting_id)
    {
        $this->qb_setting_id = $qb_setting_id;
    }




    public static function getAllCompanies()
    {

        $CI = &get_instance();

        $query = $CI->em->createQuery('SELECT c FROM models\Companies c');
        $companies = $query->getResult();

        return $companies;
    }

    public static function getAllChildCompanies()
    {

        $CI = &get_instance();

        $query = $CI->em->createQuery("SELECT c.companyId,c.companyName FROM models\Companies c
        -- LEFT JOIN models\CompanyParentChildRelation cpcr 
         where c.is_master = 0 AND (c.companyStatus = 'Active' OR c.companyStatus = 'Test' ) 
         AND c.companyId NOT IN( select cpr.child_company_id from models\CompanyParentChildRelation cpr)
         ");
        $companies = $query->getResult();

        return $companies;
    }

    public function getFirstProposalTime()
    {
        $CI = &get_instance();

        $dql = "SELECT MIN(p.created) AS createdTime
                FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.company = :companyId";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        $result = $query->getSingleResult();

        return $result['createdTime'];
    }

    /**
     * @return \models\Status
     */
    public function getOpenStatus()
    {
        return $this->doctrine->em->findStatus(\models\Status::OPEN);
    }

    /**
     * @param $default
     * @return \models\Status
     */
    public function getDefaultStatus($default)
    {
        $CI = &get_instance();

        return $CI->em->findStatus($default);
    }

    public function assignDefaultStatuses()
    {
        return;


        $CI = &get_instance();

        $defaultStatuses = Status::getDefaultStatuses();

        foreach ($defaultStatuses as $defaultStatus) {
            $status = new Status();
            $status->setCompany($this->getCompanyId());
            $status->setText($defaultStatus->getText());
            $status->setOrder($defaultStatus->getOrder());
            $status->setDefaultStatus($defaultStatus->getStatusId());
            $status->setVisible(1);
            $CI->em->persist($status);
        }
        $CI->em->flush();
    }

    public function assignEmailTemplates()
    {
        $CI = &get_instance();

        $defaultTemplate = $CI->em->find('\models\Email_templates', 16);
        /* @var $defaultTemplate \models\Email_templates */
        $templateType = $CI->em->find('\models\ClientEMailTemplateType', \models\ClientEmailTemplateType::PROPOSAL);

        $template = new \models\ClientEmailTemplate();
        $template->setTemplateName($defaultTemplate->getTemplateName());
        $template->setTemplateDescription($defaultTemplate->getTemplateDescription());
        $template->setTemplateSubject($defaultTemplate->getTemplateSubject());
        $template->setTemplateBody($defaultTemplate->getTemplateBody());
        $template->setCompany($this);
        $template->setTemplateType($templateType);
        $template->setDefaultTemplate(1);
        $CI->em->persist($template);
        $CI->em->flush();
    }

    /**
     * Retrieve the saved export entities
     */
    public function getSavedExports()
    {

        $CI =& get_instance();

        $dql = "SELECT sr
                FROM \models\SavedReport sr
                WHERE sr.company = :company_id";

        $query = $CI->em->createQuery($dql);
        $query->setParameter(':company_id', $this->getCompanyId());

        $savedReports = $query->getResult();

        return $savedReports;
    }

    /**
     *  Return a collection of proposals with a specific status
     */
    public function getProposalsByStatus($statusId)
    {
        $CI = &get_instance();

        $dql = "SELECT p FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.company = :companyId
                AND p.proposalStatus = :statusId";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('statusId', $statusId);

        $proposals = $query->getResult();

        return $proposals;
    }

    public function getRangeCreatedProposals(array $time, $count = false)
    {

        $dql = "SELECT p FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.company = :companyId
                AND p.created >= :startTime
                -- AND p.statusChangeDate >= :statusChangeStart
                AND p.created <= :finishTime
                -- AND p.statusChangeDate < :statusChangeFinish
                ";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('startTime', $time['start']);
        //$query->setParameter('statusChangeStart', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        //$query->setParameter('statusChangeFinish', $time['finish']);

        $proposals = $query->getResult();
        if ($count) {
            return count($proposals);
        }

        return $proposals;
    }

    public function getRangeCreatedProposalsPrice(array $time)
    {

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.company = :companyId
                AND p.created >= :startTime
                AND p.created <= :finishTime
                -- AND p.statusChangeDate < :finishTime
                ";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRangeMagicNumber(array $time, \models\Status $status)
    {
        $statusId = $status->getStatusId();

        $dql = "SELECT SUM(p.price)
                FROM \models\Proposals p, \models\Clients c
                WHERE  p.client = c.clientId
                AND c.company = :companyId
                AND p.proposalStatus = :statusId
                AND p.duplicateOf IS NULL
                AND p.statusChangeDate >= :startTime
                AND p.statusChangeDate <= :finishTime
                ";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('statusId', $statusId);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRolloverValue($startTime)
    {
        $openStatus = $this->getOpenStatus();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.company = :companyId
                AND p.created < :startTime
                AND p.proposalStatus = :statusId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('startTime', $startTime);
        $query->setParameter('statusId', $openStatus->getStatusId());

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRangeCreatedProposalsStatusPrice(array $time, $statusId)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.company = :companyId
                AND p.created >= :startTime
                AND p.proposalStatus = :statusId
                AND p.created <= :finishTime";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return $total;
    }

    public function isSingleUser()
    {

        if (count($this->accounts) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getActiveSortedAccounts()
    {
        $dql = "SELECT a
                FROM \models\Accounts a
                WHERE a.company = :companyId
                AND a.deleted = 0
                AND a.secretary = 0
                ORDER BY a.firstName ASC";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        return $query->getResult();
    }

    public function getActiveSortedUsersAndBranchAdminAccounts()
    {
        $dql = "SELECT a
                FROM \models\Accounts a
                WHERE a.company = :companyId
                AND a.deleted = 0
                AND a.secretary = 0
                
                ORDER BY a.firstName ASC";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        return $query->getResult();
    }

    

    /**
     * @param bool $array
     * @return array
     */
    public function getStatuses($array = false)
    {
        return $this->getCompanyRepository()->getStatuses($this->getCompanyId(), $array);
    }

    public function getServiceTitles()
    {
        $dql = "SELECT st
                FROM models\Service_titles st
                WHERE st.company = :company";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('company', $this->getCompanyId());

        $titles = $query->getResult();
        $serviceTitles = array();

        foreach ($titles as $st) {
            $serviceTitles[$st->getService()] = $st->getTitle();
        }

        return $serviceTitles;
    }

    /**
     * @return mixed
     *
     * This function returns all services for this company
     */
    public function getAllServices()
    {

        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\Services', 's');
        $rsm->addFieldResult('s', 'serviceId', 'serviceId');
        $rsm->addFieldResult('s', 'serviceName', 'serviceName');
        $rsm->addFieldResult('s', 'parent', 'parent');
        $rsm->addFieldResult('s', 'company', 'company');

        $dql = "SELECT s.*
                FROM services s
                LEFT JOIN company_service_order cso ON s.serviceId = cso.serviceId AND cso.companyId = :company
                LEFT JOIN services_disabled sd ON s.serviceId = sd.service AND sd.company = :company1
                WHERE (s.company IS NULL
                OR s.company = :company2)
                ORDER BY COALESCE(cso.ord, 99999), s.ord";

        $query = $this->doctrine->em->createNativeQuery($dql, $rsm);
        $query->setParameter('company', $this->getCompanyId());
        $query->setParameter('company1', $this->getCompanyId());
        $query->setParameter('company2', $this->getCompanyId());

        $services = $query->getResult();

        return $services;
    }

    /**
     * @return mixed
     *
     * This function returns all services for this company
     */
    public function getAllEnabledServices()
    {

        $allServices = $this->getAllServices();
        $disabledServices = $this->getDisabledServices();
        $out = array();

        foreach ($allServices as $service) {
            if (!in_array($service->getServiceId(), $disabledServices)) {
                $out[] = $service;
            }
        }

        return $out;
    }

    /**
     * @param bool $array
     * @return array
     *
     * Returns all child services
     */
    public function getServices($array = false)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\Services', 's');
        $rsm->addFieldResult('s', 'serviceId', 'serviceId');
        $rsm->addFieldResult('s', 'serviceName', 'serviceName');
        $rsm->addFieldResult('s', 'parent', 'parent');
        $rsm->addFieldResult('s', 'company', 'company');


        $dql = "SELECT s.*
                FROM services s
                LEFT JOIN company_service_order cso ON s.serviceId = cso.serviceId AND cso.companyId = :company
                LEFT JOIN services_disabled sd ON s.serviceId = sd.service AND sd.company = :company1
                WHERE s.parent != 0
                AND sd.deleted IS NULL
                AND (s.company IS NULL
                OR s.company = :company2)
                ORDER BY COALESCE(cso.ord, 99999), s.ord";

        $query = $this->doctrine->em->createNativeQuery($dql, $rsm);
        $query->setParameter('company', $this->getCompanyId());
        $query->setParameter('company1', $this->getCompanyId());
        $query->setParameter('company2', $this->getCompanyId());
        //Cache It
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_SERVICES_MAP . $this->getCompanyId());

        $services = $query->getResult();

        if ($array) {
            $servs = array();
            foreach ($services as $service) {
                $servs[$service->getParent()][] = $service;
            }
            return $servs;
        }

        return $services;
    }

    /**
     * @return array
     */
    public function getQbdServiceList()
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\Services', 's');
        $rsm->addFieldResult('s', 'serviceId', 'serviceId');
        $rsm->addFieldResult('s', 'serviceName', 'serviceName');
        $rsm->addFieldResult('s', 'parent', 'parent');
        $rsm->addFieldResult('s', 'company', 'company');

        $dql = "SELECT s.*
                FROM services s
                LEFT JOIN company_service_order cso ON s.serviceId = cso.serviceId AND cso.companyId = :company
                LEFT JOIN services_disabled sd ON s.serviceId = sd.service AND sd.company = :company1
                WHERE s.parent != 0
                AND sd.deleted IS NULL
                AND (s.company IS NULL
                OR s.company = :company2)
                AND NOT EXISTS (
                  SELECT quickbooks_queue_id 
                  FROM quickbooks_queue 
                  WHERE quickbooks_queue.ident = s.serviceId
                  AND qb_action = 'ItemServiceAdd'
                  AND qb_username = :qbUsername
                )
                ORDER BY COALESCE(cso.ord, 99999), s.ord";

        $query = $this->doctrine->em->createNativeQuery($dql, $rsm);
        $query->setParameter('company', $this->getCompanyId());
        $query->setParameter('company1', $this->getCompanyId());
        $query->setParameter('company2', $this->getCompanyId());
        $query->setParameter('qbUsername', md5($this->getCompanyId()));

        $services = $query->getResult();

        $out = [];
        foreach ($services as $service) {
            $out[] = $service->getServiceId();
        }

        return $out;
    }

    /**
     * @return array
     */
    public function getDisabledServices()
    {
        $dql = "SELECT cds
                FROM \models\CompanyDisabledService cds
                WHERE cds.company = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        $services = $query->getResult();

        $out = array();

        if (count($services)) {
            foreach ($services as $service) {
                $out[] = $service->getService();
            }
        }

        return $out;
    }

    public function getCategories()
    {
        $dql = 'SELECT c
                FROM models\Services c
                WHERE c.parent = 0
                AND (c.company IS NULL
                OR c.company = :company)
                ORDER BY c.ord';

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('company', $this->getCompanyId());
        //Cache It
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_SERVICES . $this->getCompanyId());
        return $query->getResult();
    }

    /**
     * @description Returns array of enabled categories
     * @return array
     */
    public function getActiveCategories()
    {
        $allServices = $this->getCategories();
        $disabledServices = $this->getDisabledServices();

        $out = [];

        foreach ($allServices as $category) {
            if(!in_array($category->getServiceId(), $disabledServices)){
                $out[] = $category;
            }
        }

        return $out;
    }

    /**
     *  Clear previously set service order
     * @return void
     */
    function clearServiceOrder($categoryId)
    {

        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\CompanyServiceOrder', 'cso');
        $rsm->addFieldResult('cso', 'id', 'id');

        $dql = "SELECT cso.id
                FROM company_service_order cso
                LEFT JOIN services s ON cso.serviceId = s.serviceId
                WHERE s.parent = :category_id
                AND cso.companyId = :companyId";

        $query = $this->doctrine->em->createNativeQuery($dql, $rsm);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('category_id', $categoryId);

        $csos = $query->getResult();

        foreach ($csos as $csorsm) {
            $cso = $this->doctrine->em->find('\models\CompanyServiceOrder', $csorsm->getId());
            $this->doctrine->em->remove($cso);
        }

        $this->doctrine->em->flush();

    }

    /**
     * @param $serviceId
     * @return void
     * Clear previously set service text order
     */
    function clearServiceTextOrder($serviceId)
    {
        $dql = "DELETE \models\ServiceTextOrder sto
                WHERE sto.company = :companyId
                AND sto.service = :serviceId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('serviceId', $serviceId);

        $query->execute();
    }

    /**
     * @param $serviceId
     * @return void
     * Clear previously set service field order
     */
    function clearServiceFieldOrder($serviceId)
    {
        $dql = "DELETE \models\ServiceFieldOrder sfo
                WHERE sfo.company = :companyId
                AND sfo.serviceId = :serviceId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('serviceId', $serviceId);

        $query->execute();
    }

    function getServiceFields($serviceId)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\ServiceField', 'sf');
        $rsm->addFieldResult('sf', 'fieldId', 'fieldId');
        $rsm->addFieldResult('sf', 'service', 'service');
        $rsm->addFieldResult('sf', 'fieldCode', 'fieldCode');
        $rsm->addFieldResult('sf', 'fieldName', 'fieldName');
        $rsm->addFieldResult('sf', 'fieldType', 'fieldType');
        $rsm->addFieldResult('sf', 'fieldValue', 'fieldValue');
        $rsm->addFieldResult('sf', 'ord', 'ord');
        $rsm->addFieldResult('sf', 'company', 'company');
        $rsm->addFieldResult('sf', 'measurement', 'measurement');
        //$rsm->addFieldResult('sf', 'unit', 'unit');
        //$rsm->addFieldResult('sf', 'depth', 'depth');
        //$rsm->addFieldResult('sf', 'qty', 'qty');
        //$rsm->addFieldResult('sf', 'area', 'area');
        //$rsm->addFieldResult('sf', 'length', 'length');
        //$rsm->addFieldResult('sf', 'gravel_depth', 'gravel_depth');

        $dql = "SELECT sf.*
                FROM service_fields sf
                LEFT JOIN service_field_order sfo ON sf.fieldId = sfo.fieldId AND sfo.company = :companyId1
                WHERE sf.service = :serviceId
                AND (sf.company = :companyId2
                    OR sf.company IS NULL)
                AND sf.fieldId NOT IN (
	                SELECT sfd.fieldId
                    FROM service_fields_disabled sfd
                    WHERE sfd.companyId = :companyId3
                )
                ORDER BY COALESCE(sfo.ord, 99999), sf.ord";

        $query = $this->doctrine->em->createNativeQuery($dql, $rsm);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('companyId1', $this->getCompanyId());
        $query->setParameter('companyId2', $this->getCompanyId());
        $query->setParameter('companyId3', $this->getCompanyId());
        $query->setParameter('serviceId', $serviceId);

        $serviceFields = $query->getResult();

        return $serviceFields;
    }


    function getDeletedTexts($array = false)
    {
        $dql = "SELECT sdt
                FROM \models\Service_deleted_texts sdt
                WHERE sdt.company = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        $deletedTexts = $query->getResult();

        if ($array) {
            $out = [];

            if (count($deletedTexts)) {
                foreach ($deletedTexts as $deletedText) {
                    /* @var $deletedText \models\Service_deleted_texts */
                    $out[] = $deletedText->gettextId();
                }
            }

            return $out;
        }

        return $deletedTexts;
    }

    function getServiceTexts($serviceId)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\ServiceText', 'st');
        $rsm->addFieldResult('st', 'textId', 'textId');
        $rsm->addFieldResult('st', 'textValue', 'textValue');
        $rsm->addFieldResult('st', 'service', 'service');
        $rsm->addFieldResult('st', 'company', 'company');
        $rsm->addFieldResult('st', 'ord', 'ord');

        $dql = "SELECT st.*
                FROM service_texts st
                LEFT JOIN service_texts_order sto ON (st.textId = sto.textId AND sto.company = :companyId1)
                WHERE st.service = :serviceId
                AND (st.company = :companyId
                    OR st.company = 0)
                ORDER BY COALESCE(sto.ord, 99999), st.ord";

        $query = $this->doctrine->em->createNativeQuery($dql, $rsm);
        $query->setParameter('companyId1', $this->getCompanyId());
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('serviceId', $serviceId);

        $serviceTexts = $query->getResult();

        return $serviceTexts;
    }

    function getOrderedServiceTexts($serviceId)
    {

        $allTexts = $this->getServiceTexts($serviceId);
        $deletedTexts = $this->getDeletedTexts(true);

        $out = [];

        foreach ($allTexts as $text) {
            /* @var $text \models\ServiceText */
            if (!in_array($text->getTextId(), $deletedTexts)) {
                $out[] = $text;
            }
        }

        return $out;
    }


    function getCustomInitialServices()
    {
        return array(
            125, 57, 59, 68, 81, 92, 94, 95, 96, 97, 78, 77, 69, 70, 76, 62, 63, 71, 67, 98, 99, 100, 120, 122, 123, 124, 119, 121, 126, 104, 103, 101, 111, 24, 25, 26, 53, 118
        );
    }

    function migrateServices()
    {

        echo '<h1>' . $this->getCompanyName() . '</h1>';

        $customServices = $this->getCustomisedServices();

        if (!count($customServices)) {
            echo '<p>No customized services found</p>';
            return;
        }

        // 1. Loop through each service
        foreach ($customServices as $customService) {
            /* @var $customService \models\Services */

            $serviceName = ($customService->hasCustomTitle($this->getCompanyId())) ? $customService->getCustomTitle($this->getCompanyId())->getTitle() : $customService->getServiceName();

            // Output the name
            echo '<p>Migrating Custom Service: ';
            echo $serviceName;
            echo '</p>';

            // Create the new service
            $newService = new \models\Services();
            $newService->setServiceName($serviceName);
            $newService->setParent($customService->getParent());
            $newService->setOrd($customService->getOrd());
            $newService->setCompany($this->getCompanyId());
            $this->doctrine->em->persist($newService);
            $this->doctrine->em->flush();

            // Obtain the texts for this service/company
            $serviceTexts = $customService->getTexts($this->getCompanyId());

            echo '<p>' . count($serviceTexts) . ' service texts found</p>';

            // Loop through each service text
            foreach ($serviceTexts as $text) {
                /* @var $text \models\ServiceText */

                echo '<p>Text Id: ' . $text->getTextId() . '</p>';

                // Save as a new text
                $newText = new \models\ServiceText();
                $newText->setText($text->getText());
                $newText->setService($newService->getServiceId()); // Apply to the new service
                $newText->setCompany($text->getCompany());
                $newText->setOrd($text->getOrd());
                $this->doctrine->em->persist($newText);
                $this->doctrine->em->flush();

                $textOrders = $text->migrateOrder($newService->getServiceId(), $newText->getTextId(), $this->getCompanyId());
                echo '<p>Service Text Order updated in ' . $textOrders . ' rows';

                // Now we need to update the disabled texts
                $deletedTexts = $text->migrateDeleted($newText->getTextId(), $this->getCompanyId());
                echo '<p>Deleted Texts updated in  ' . $deletedTexts . ' rows</p>';
            }

            // Get the fields for each service
            $serviceFields = $this->getServiceFields($customService->getServiceId());

            echo '<p>' . count($serviceFields) . ' service texts found</p>';

            // Loop through each service field
            foreach ($serviceFields as $field) {
                /* @var $field \models\ServiceField */

                // Save as a new field
                $newField = new \models\ServiceField();
                $newField->setService($newService->getServiceId());     // Apply to new service
                $newField->setFieldName($field->getFieldName());
                $newField->setFieldCode($field->getFieldCode());
                $newField->setFieldType($field->getFieldType());
                $newField->setFieldValue($field->getFieldValue());
                $newField->setOrd($field->getOrd());
                $newField->setCompany($this->getCompanyId());           // Save to this company
                $this->doctrine->em->persist($newField);
                $this->doctrine->em->flush();
            }

            // Now we need to update the proposal services
            $proposalServices = $customService->migrateProposalServices($newService->getServiceId(), $this->getCompanyId());
            echo '<p>New service updated in ' . $proposalServices . ' proposal services</p>';

            // Now we need to update the services order
            $serviceOrders = $customService->migrateOrder($newService->getServiceId(), $this->getCompanyId());
            echo '<p>Service Order  updated in  ' . $serviceOrders . ' rows</p>';

            // Now we need to update the disabled services
            $disabledServices = $customService->migrateDisabled($newService->getServiceId(), $this->getCompanyId());
            echo '<p>Disabled Services will be updated in  ' . $disabledServices . ' rows</p>';

        }
    }


    public static function getCompaniesBatch($minId, $maxId)
    {
        $CI =& get_instance();

        $dql = "SELECT c
                FROM \models\Companies c
                WHERE c.companyId >= :minId
                AND c.companyId <= :maxId
                ORDER By c.companyId ASC";

        $query = $CI->doctrine->em->createQuery($dql);
        $query->setParameter('minId', $minId);
        $query->setParameter('maxId', $maxId);

        return $query->getResult();
    }

    public function getCustomServicesUsed()
    {
        $dql = "SELECT DISTINCT(ps.initial_service)
                FROM \models\Proposal_services ps, \models\Proposals p, \models\Clients c
                WHERE ps.proposal = p.proposalId
                AND p.client = c.clientId
                AND c.company = :companyId
                AND ps.initial_service IN (" . implode(',', Companies::getCustomInitialServices()) . ')';

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        $initialServices = $query->getResult();

        $out = [];

        foreach ($initialServices as $initialService) {
            $service = $this->doctrine->em->find('\models\Services', $initialService['initial_service']);
            $out[] = $service->getServiceId();
        }

        return $out;
    }

    public function getCustomisedServices()
    {

        $customServicesUsed = $this->getCustomServicesUsed();
        $customisedServiceTitles = $this->getCustomisedServicesFromTitles();

        $usedServices = [];

        foreach ($customServicesUsed as $serviceId) {
            if (!in_array($serviceId, $usedServices)) {
                $service = $this->doctrine->em->find('\models\Services', $serviceId);
                $usedServices[] = $service->getServiceId();
            }
        }

        foreach ($customisedServiceTitles as $serviceId) {
            if (!in_array($serviceId, $usedServices)) {
                $service = $this->doctrine->em->find('\models\Services', $serviceId);
                $usedServices[] = $service->getServiceId();
            }
        }

        $out = [];
        foreach ($usedServices as $usedServiceId) {
            $service = $this->doctrine->em->find('\models\Services', $usedServiceId);
            $out[] = $service;
        }

        return $out;
    }


    public function getCustomisedServicesFromTitles()
    {
        $dql = "SELECT st
                FROM models\Service_titles st
                WHERE st.company = :company
                AND st.service IN (" . implode(',', Companies::getCustomInitialServices()) . ')';

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('company', $this->getCompanyId());

        $titles = $query->getResult();
        $services = array();

        foreach ($titles as $st) {
            $service = $this->doctrine->em->find('\models\Services', $st->getService());
            $services[] = $service->getServiceId();
        }

        return $services;
    }


    public function numDeleteRequests()
    {
        $CI = &get_instance();

        $sql = "SELECT COUNT(p.proposalId) AS deleteRequests 
                FROM proposals p
                LEFT JOIN accounts a ON p.owner = a.accountId
                WHERE a.company = :companyId
                AND p.proposalStatus = :statusId";

        // Raw PDO
        $query = $CI->em->getConnection()->prepare($sql);
        $query->bindValue('companyId', $this->getCompanyId());
        $query->bindValue('statusId', \models\Status::DELETE_REQUEST);
        $query->execute();

        $results = $query->execute();
        $result = $results->fetchAssociative();

        return $result['deleteRequests'] ?: 0;
    }


    public function getTopTenProposals($start = false, $end = false, array $users, $service = 0)
    {
        $openStatus = $this->getOpenStatus();

        $dql = "SELECT p FROM models\Proposals p
            INNER JOIN p.client c
            INNER JOIN c.company cmp
            WHERE (cmp.companyId = c.company) AND (cmp.companyId = :companyId)
            AND p.owner IN (:users)
            AND p.proposalStatus = :openStatusId";


        if ($start) {
            $dql .= " AND p.created >= :startTime";
        }

        if ($end) {
            $dql .= " AND p.created <= :endTime";
        }

        $dql .= " ORDER BY p.price DESC";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setMaxResults(10);
        $query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('users', $users);
        $query->setParameter('openStatusId', $openStatus->getStatusId());
        if ($start) {
            $query->setParameter('startTime', $start);
        }
        if ($end) {
            $query->setParameter('endTime', $end);
        }

        return $query->getResult();
    }

    function getUserClients(array $users, $deleted = 0)
    {
        if (!$deleted) {
            $clients = new ArrayCollection();
            foreach ($this->clients as $client) {
                if (!$client->isDeleted() && in_array($client->getAccount()->getAccountId(), $users)) {
                    $clients->add($client);
                }
            }
            return $clients;
        } else {
            return $this->clients;
        }
    }

    public function getProposalAutoNum()
    {
        // Reoload to make sure
        $company = $this->doctrine->em->findCompany($this->getCompanyId());
        /* @var $company \models\Companies */
        $prefix = $company->getAutoNumPrefix();
        $autoVal = $company->getAutoNum();
        $company->setAutoNum($autoVal + 1);
        $this->doctrine->em->persist($company);
        $this->doctrine->em->flush();

        return $prefix . $autoVal;
    }

    /**
     * Getter for Layout
     * @return mixed
     */
    public function getLayout()
    {
        return ($this->layout) ? $this->layout : 'cool';
    }

    /**
     * Setter for Layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return mixed
     */
    public function getHeaderFont()
    {
        return $this->header_font;
    }

    /**
     * @param mixed $header_font
     */
    public function setHeaderFont($header_font)
    {
        $this->header_font = $header_font;
    }

    /**
     * @return mixed
     */
    public function getTextFont()
    {
        return $this->text_font;
    }

    /**
     * @param mixed $text_font
     */
    public function setTextFont($text_font)
    {
        $this->text_font = $text_font;
    }

    /**
     * @return mixed
     */
    public function getStandardHeaderFont()
    {
        return $this->standard_header_font;
    }

    /**
     * @param mixed $standard_header_font
     */
    public function setStandardHeaderFont($standard_header_font)
    {
        $this->standard_header_font = $standard_header_font;
    }

    /**
     * @return mixed
     */
    public function getStandardTextFont()
    {
        return $this->standard_text_font;
    }

    /**
     * @param mixed $standard_text_font
     */
    public function setStandardTextFont($standard_text_font)
    {
        $this->standard_text_font = $standard_text_font;
    }

    /**
     * @return mixed
     */
    public function getCoolHeaderFont()
    {
        return $this->cool_header_font;
    }

    /**
     * @param mixed $cool_header_font
     */
    public function setCoolHeaderFont($cool_header_font)
    {
        $this->cool_header_font = $cool_header_font;
    }

    /**
     * @return mixed
     */
    public function getCoolTextFont()
    {
        return $this->cool_text_font;
    }

    /**
     * @param mixed $cool_text_font
     */
    public function setCoolTextFont($cool_text_font)
    {
        $this->cool_text_font = $cool_text_font;
    }


    /**
     * @return mixed
     */
    public function getGradientOpacity()
    {
        return $this->gradient_opacity;
    }

    /**
     * @param mixed $gradient_opacity
     */
    public function setGradientOpacity($gradient_opacity)
    {
        $this->gradient_opacity = $gradient_opacity;
    }

    public function findResidentialAccount()
    {
        $dql = "SELECT cc
                FROM \models\ClientCompany cc
                WHERE cc.name = 'Residential'
                AND cc.owner_company = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter(':companyId', $this->getCompanyId());
        $query->setMaxResults(1);

        try {
            $result = $query->getOneOrNullResult();
        } catch (\Exception $e) {
            $result = null;
        }

        return $result;
    }

    /**
     * @param $companyName
     * @param Accounts $ownerAccount
     * @return mixed|ClientCompany
     */
    public function findClientAccountByName($companyName, Accounts $ownerAccount)
    {
        $dql = "SELECT cc FROM \models\ClientCompany cc
                        WHERE cc.name = :companyName
                        AND cc.owner_company = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter(':companyName', $companyName);
        $query->setParameter(':companyId', $this->getCompanyId());
        $clientAccount = $query->setMaxResults(1)->getOneOrNullResult();

        // If we didn't load one, create a new one
        if (!$clientAccount) {
            $clientAccount = new ClientCompany();
            /* @var \models\ClientCompany $newAccount */
            $clientAccount->setName($companyName);
            $clientAccount->setOwnerUser($ownerAccount);
            $clientAccount->setOwnerCompany($this);
            $clientAccount->setCreated(time());
            $this->doctrine->em->persist($clientAccount);
            $this->doctrine->em->flush();
        }

        return $clientAccount;
    }

    /**
     * @param $name
     * @param Accounts $ownerUser
     * @return mixed|ClientCompany
     */
    public function getAccountFromName($name, Accounts $ownerUser)
    {
        $dql = "SELECT cc FROM \models\ClientCompany cc
                            WHERE cc.name = :companyName
                            AND cc.owner_company = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter(':companyName', $name);
        $query->setParameter(':companyId', $this->getCompanyId());
        $query->setMaxResults(1);

        $clientAccount = $query->getOneOrNullResult();
        /* @var \models\ClientCompany $clientAccount */

        if (!$clientAccount) {
            $clientAccount = new \models\ClientCompany();
            $clientAccount->setName($name);
            $clientAccount->setOwnerUser($ownerUser);
            $clientAccount->setOwnerCompany($this);
            $clientAccount->setCreated(time());
            $this->doctrine->em->persist($clientAccount);
            $this->doctrine->em->flush();
        }

        return $clientAccount;
    }

    /**
     * @description Returns an array of the lead source names - defaults plus any belonging to the company
     * @return mixed
     */
    public function getLeadSources($collection = false)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\LeadSource', 'ls');
        $rsm->addFieldResult('ls', 'id', 'id');
        $rsm->addFieldResult('ls', 'name', 'name');
        $rsm->addFieldResult('ls', 'company_id', 'company_id');

        $dql = "SELECT ls.*
                FROM lead_sources ls
                LEFT JOIN lead_source_deleted lsd ON ls.id = lsd.lead_source_id AND lsd.company_id = :lsdCompany
                LEFT JOIN lead_source_order lso ON ls.id = lso.lead_source_id AND lso.company_id = :lsoCompany                
                WHERE (ls.company_id IS NULL
                OR ls.company_id = :companyId)
                AND lsd.id IS NULL
                ORDER BY COALESCE(lso.ord, 99999), ls.ord";

        $query = $this->doctrine->em->createNativeQuery($dql, $rsm);
        $query->setParameter(':lsdCompany', $this->getCompanyId());
        $query->setParameter(':lsoCompany', $this->getCompanyId());
        $query->setParameter(':companyId', $this->getCompanyId());

        $leadSources = $query->getResult();

        if ($collection) {
            return $leadSources;
        }

        $out = [];
        foreach ($leadSources as $leadSource) {
            $out[$leadSource->getName()] = $leadSource->getName();
        }

        return $out;
    }

    /**
     * @return void
     * Clear previously set service lead source
     */
    function clearLeadSourceOrder()
    {
        $dql = "DELETE \models\LeadSourceOrder lso
                WHERE lso.company_id = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        $query->execute();
    }



    function getLayouts()
    {
        $standardLayouts = [
            'Cool' => 'cool',
            'Standard' => 'standard',
        ];

        $allLayouts = [
            'Cool' => 'cool',
            'Standard' => 'standard',
            'Custom' => 'gradient',
        ];

        if ($this->getNewLayouts()) {
            return $allLayouts;
        }
        return $standardLayouts;
    }

    function getWebLayouts()
    {
        
        $allLayouts = [
            'Web Cool' => 'web-cool',
            'Web Standard' => 'web-standard',
             //'Web Custom' => 'web-custom',
        ];


        return $allLayouts;
        
    }

    public function getHighestBid() {

        $dql = "SELECT MAX(p.price) AS maxPrice
                FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.company = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter(':companyId', $this->getCompanyId());

        $result = $query->getSingleResult();
        // Cache it
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_PROPOSAL_MAX_PRICE . $this->getCompanyId());
        return $result['maxPrice'];
    }

    /**
     * Quick function to check if a company is active or not
     * @return bool
     */
    public function isActive()
    {
        return $this->getCompanyStatus() == 'Active';
    }

    /**
     * Quick function to check if a company is trial of not
     * @return bool
     */
    public function isTrial()
    {
        return $this->getCompanyStatus() == 'Trial';
    }

    public function shouldUpdateZS()
    {
        return !in_array($this->getCompanyId(), [3, 8]);
    }

    /**
     * @return null|\models\QuickbooksSettings
     */
    function getQuickbooksSettings()
    {
        try {
            $settings = $this->doctrine->em->getRepository('models\QuickbooksSettings')->findOneBy(['company_id' => $this->getCompanyId()]);
            return $settings;
        }
        catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return \models\CompanySettings
     */
    function getCompanySettings()
    {
        // Check for existing settings
       $companySetting =  $this->doctrine->em->find('models\CompanySettings',$this->getCompanyId());

       // If we don't have one, create a default
       if(!$companySetting) {
            $companySetting = new CompanySettings();
            $companySetting->setCompanyId($this->getCompanyId());
            $this->doctrine->em->persist($companySetting);
            $this->doctrine->em->flush();
       }
        
       return $companySetting;       
    }

    function getCompanyVideoCoverImagePath(){

        return UPLOADPATH . '/companies/' . $this->getCompanyId() . '/company_video_cover/';
    }

    public function getSitePathCompanyVideoCoverImage()
    {
       
        return site_url('uploads/companies/').'/' . $this->getCompanyId() . '/company_video_cover/' ;
    }

    public function getCompanyIntro()
    {
        return $this->company_intro;
    }

    public function setCompanyIntro($company_intro)
    {
        $this->company_intro = $company_intro;
    }

    public function getIsMaster()
    {
        return $this->is_master;
    }

    public function setIsMaster($is_master)
    {
        $this->is_master = $is_master;
    }

    public function getChildCompanyIds($return_array = false){
        $sql = "SELECT c.companyId FROM companies c 
                LEFT JOIN companies_parent_child_ralations cpc ON c.companyId = cpc.child_company_id
                WHERE cpc.parent_company_id =  " . $this->getCompanyId();
        if($return_array){
            $childs = $this->db->query($sql)->result_array();
            $data = [];
            foreach($childs as $child){
                $data[] = $child['companyId'];
            }

            return  $data;
        }else{
            return $this->db->query($sql)->result_array();
        }
        
    }

    public function getMasterRangeCreatedProposals(array $time, $count = false,$childIds)
    {

        //print_r($this->getChildCompanyIds());die;
        $dql = "SELECT p FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.company IN( :companyIds)
                AND p.created >= :startTime
                -- AND p.statusChangeDate >= :statusChangeStart
                AND p.created <= :finishTime
                -- AND p.statusChangeDate < :statusChangeFinish
                ";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyIds', $childIds);
        $query->setParameter('startTime', $time['start']);
        //$query->setParameter('statusChangeStart', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        //$query->setParameter('statusChangeFinish', $time['finish']);
  //echo   $dql;die;
  $proposals = $query->getResult();
          if ($count) {
            return count($proposals);
        }

        return $proposals;
    }

    public function getMasterRangeCreatedProposalsPrice(array $time,$childIds)
    {

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.company IN( :companyIds)
                AND p.created >= :startTime
                AND p.created <= :finishTime
                -- AND p.statusChangeDate < :finishTime
                ";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyIds', $childIds);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getMasterRangeMagicNumber(array $time, \models\Status $status,$childIds)
    {
        $statusId = $status->getStatusId();

        $dql = "SELECT SUM(p.price)
                FROM \models\Proposals p, \models\Clients c
                WHERE  p.client = c.clientId
                AND c.company IN( :companyIds)
                AND p.proposalStatus = :statusId
                AND p.duplicateOf IS NULL
                AND p.statusChangeDate >= :startTime
                AND p.statusChangeDate <= :finishTime
                ";

                

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyIds', $childIds);
        $query->setParameter('statusId', $statusId);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getMasterRolloverValue($startTime,$childIds)
    {
        $openStatus = $this->getOpenStatus();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.company IN( :companyIds)
                AND p.created < :startTime
                AND p.proposalStatus = :statusId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyIds', $childIds);
        $query->setParameter('startTime', $startTime);
        $query->setParameter('statusId', $openStatus->getStatusId());

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }


    public function getMasterRangeCreatedProposalsStatusPrice(array $time, $statusId,$childIds)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.company IN( :companyIds)
                AND p.created >= :startTime
                AND p.proposalStatus = :statusId
                AND p.created <= :finishTime";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('companyIds', $childIds);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return $total;
    }

    public function getMultipleCompanyBranches($companyIds)
    {

        $CI = &get_instance();

        $dql = "SELECT b
                FROM \models\Branches b
                WHERE b.company IN( :companyIds)
                ORDER BY b.branchName ASC";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyIds', $companyIds);

        return $query->getResult();
    }


    public function getRangeCreatedMasterProposalsPrice(array $time)
    {
        $sql = "SELECT SUM(p.price) as totalVal
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.company_id = :companyId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND s.prospect = 0
                AND s.on_hold = 0";

        $query = $this->doctrine->em->getConnection()->prepare($sql);
        $query->bindValue('companyId', $this->getCompanyId());
        $query->bindValue('startTime', $time['start']);
        $query->bindValue('finishTime', $time['finish']);
        $results =$query->execute();

        $result = $results->fetchAssociative();

        return (float)$result['totalVal'] ?: 0;
    }

    public function getRangeCreatedWonProposalsPrice(array $time)
    {
        $sql = "SELECT SUM(p.price) as totalVal
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.company_id = :companyId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND s.sales = 1";

        $query = $this->doctrine->em->getConnection()->prepare($sql);
        $query->bindValue('companyId', $this->getCompanyId());
        $query->bindValue('startTime', $time['start']);
        $query->bindValue('finishTime', $time['finish']);
        $results =$query->execute();

        $result = $results->fetchAssociative();

        return (float)$result['totalVal'] ?: 0;
    }

    

    public function checkChildCompany()
    {

        $CI = &get_instance();

        $dql = "SELECT cpcr
                FROM \models\CompanyParentChildRelation cpcr
                WHERE cpcr.child_company_id IN( :companyId) ";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyId', $this->getCompanyId());

        $results =  $query->getResult();
        if(count($results)>0){
            return true;
        }else{
            return false;
        }
    }

    public function getSiblingChildCompanyIds($return_array = false){
        $sql = "SELECT cpc.child_company_id FROM companies_parent_child_ralations cpcr 
                LEFT JOIN companies_parent_child_ralations cpc ON cpcr.parent_company_id = cpc.parent_company_id
                WHERE cpcr.child_company_id =  " . $this->getCompanyId()." AND cpc.child_company_id !=  " . $this->getCompanyId();

        if($return_array){
            $childs = $this->db->query($sql)->result_array();
            $data = [];
            foreach($childs as $child){
                $data[] = $child['child_company_id'];
            }

            return  $data;
        }else{
            return $this->db->query($sql)->result_array();
        }
        
    }

    public function getSalesManager()
    {
        return $this->sales_manager;
    }

    public function setSalesManager($sales_manager)
    {
        $this->sales_manager = $sales_manager;
    }

    public function getModifyPrice()
    {
        return $this->modify_price;
    }

    public function setModifyPrice($modify_price)
    {
        $this->modify_price = $modify_price;
    }

    /**
     * @param mixed $proposalCampaigns
     */
    public function getProposalCampaigns()
    {
        return $this->proposalCampaigns;
    }

    /**
     * @return mixed
     */
    public function setProposalCampaigns($proposalCampaigns)
    {
        //echo $proposalCampaigns;die;
        $this->proposalCampaigns = $proposalCampaigns;
    }
    /**
     * @param mixed $userCheck
     */
    public function setUserCheck($userCheck)
    {
        $this->userCheck = $userCheck;
    }

    /**
     * @return mixed
     */
    public function getUserCheck()
    {
        return $this->userCheck;
    }

     /**
     * @param mixed $proposal_checklist
     */

    public function getProposalChecklist()
    {
        return $this->proposal_checklist;
    }
    
    /**
     * @return mixed
     */
    public function setProposalChecklist($proposal_checklist)
    {
        $this->proposal_checklist = $proposal_checklist;
    }

     /**
     * Getter for Work order Layout
     * @return mixed
     */
    public function getWorkOrderSetting()
    {
        return ($this->work_order_setting!==""|| $this->work_order_setting!==NULL) ? $this->work_order_setting : 1;
    }

    /**
     * Setter for Work Order Layout
     */
    public function setWorkOrderSetting($work_order_setting)
    {
        $this->work_order_setting = $work_order_setting;
    }

    function getAllWorkOrderSetting()
    { 
        $getAllWorkOrder = [
            'Portrait' => 1,
            'Landscape' => 0
        ];
        return $getAllWorkOrder;
    }
    
}
