<?php

class EmailTemplateParser
{

    /* @var \models\Proposals */
    private $proposal;

    /* @var \models\ProposalPreviewLink */
    private $proposal_preview_link;

    /* @var \models\Clients */
    private $client;

    /* @var \models\Accounts */
    private $account;

    /* @var \models\Companies */
    private $company;

    /* @var \models\Leads */
    private $lead;

    /* @var \models\Prospects */
    private $prospect;

    /* @var string */
    private $navLink;

    /* @var string */
    private $passwordResetLink;

    /* @var bool */
    public $createPassword = false;

    /* @var bool */
    public $parseProposalLink = true;

    /* @var array */
    private $auditLeads;

    /* @var array */
    private $search;

    /* @var array */
    private $replace;

    private $wrapTop = '<html><head>
                        <title>Email</title>
                        <style type="text/css">
                            body {font-size: 12px; font-family: Helvetica, Arial, sans-serif;}
                        </style>
                        </head>
                        <body>';

    private $wrapBottom = '</body>';


    /**
     * @return \models\Accounts
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param \models\Accounts $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return \models\Clients
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param \models\Clients $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return \models\Companies
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param \models\Companies $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return \models\Leads
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param \models\Leads $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
    }

    /**
     * @return \models\Proposals
     */
    public function getProposal()
    {
        return $this->proposal;
    }

    /**
     * @param \models\Proposals $proposal
     */
    public function setProposal($proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * @return \models\ProposalPreviewLink
     */
    public function getProposalPreviewLink()
    {
        return $this->proposal_preview_link;
    }

    /**
     * @param \models\ProposalPreviewLink $proposal_preview_link
     */
    public function setProposalPreviewLink($proposal_preview_link)
    {
        $this->proposal_preview_link = $proposal_preview_link;
    }

    /**
     * @return \models\Prospects
     */
    public function getProspect()
    {
        return $this->prospect;
    }

    /**
     * @param \models\Prospects $prospect
     */
    public function setProspect($prospect)
    {
        $this->prospect = $prospect;
    }

    /**
     * @param string $navLink
     */
    public function setNavLink($navLink)
    {
        $this->navLink = $navLink;
    }

    /**
     * @return string
     */
    public function getNavlink()
    {
        return $this->navLink;
    }

    /**
     * @param bool $parseProposalLink
     */
    public function setParseProposalLink($parseProposalLink)
    {
        $this->parseProposalLink = $parseProposalLink;
    }

    /**
     * @return bool
     */
    public function getParseProposalLink()
    {
        return $this->parseProposalLink;
    }

    
    /**
     * @return array
     */
    public function getAuditLeads()
    {
        return $this->auditLeads;
    }

    /**
     * @param array $auditLeads
     */
    public function setAuditLeads($auditLeads)
    {
        $this->auditLeads = $auditLeads;
    }

    /**
     * @return array
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @return array
     */
    public function getReplace()
    {
        return $this->replace;
    }


    /**
     * @param $text
     * @param bool $wrap
     * @return mixed|string
     */
    public function parse($text, $wrap = false)
    {
           
        if ($this->getProposal()) {

            $this->setClient($this->getProposal()->getClient());
            $this->setCompany($this->getProposal()->getClient()->getCompany());
            $this->setAccount($this->getProposal()->getOwner());

            $layout = $this->proposal->getLayout() ?: 'cool';

            
            if($this->proposal_preview_link) {
                $this->search[] = '{proposal.link}';
                $this->replace[] = '<a href="' . site_url('proposal/'.$this->proposal_preview_link->getUuid()).'">' . $this->proposal->getProjectName() . '</a>';
            } else {
                if($this->parseProposalLink){
                    $this->search[] = '{proposal.link}';
                    $this->replace[] = '<a href="' . site_url('proposals/live/views/' . $layout . '/plproposal_' . $this->proposal->getAccessKey() . '.pdf">' . $this->proposal->getProjectName() . '</a>');
                }
                
            }

            
            if($this->proposal_preview_link) {
                $this->search[] = '{proposal.url}';
                $this->replace[] = site_url('proposal/'.$this->proposal_preview_link->getUuid());
            } else {
                if($this->parseProposalLink){
                    $this->search[] = '{proposal.url}';
                    $this->replace[] = site_url('proposals/live/views/' . $layout . '/plproposal_' . $this->proposal->getAccessKey() . '.pdf');
                }
            }

            $this->search[] = '{proposal.projectName}';
            $this->replace[] = $this->proposal->getProjectName();

            $this->search[] = '{proposal.auditReportViewLink}';
            $this->replace[] = $this->proposal->getAuditReportUrl(true);

            $this->search[] = '{proposal.auditReportViewButton}';
            $this->replace[] = '
                <p style="text-align: center;">
                    <a href="' . $this->proposal->getAuditReportUrl(true) . '" style="display: inline-block; float: none; margin: 10px 10px; text-align: center; padding: 15px 20px; border-radius: 5px; background-color: #008cba; color: #fff; font-size: 22px; text-decoration: none; width: 200px;">
                        View Audit Report
                    </a>
                </p>
            ';
        }

        if ($this->getClient()) {

            $this->search[] = '{client.firstName}';
            $this->replace[] = $this->getClient()->getFirstName();

            $this->search[] = '{client.lastName}';
            $this->replace[] = $this->getClient()->getLastName();

            $this->search[] = '{client.companyName}';
            $this->replace[] = $this->getClient()->getCompanyName();
        }

        if ($this->getAccount()) {

            // Set the company if it hasn't already been done
            if (!$this->getCompany()) {
                $this->setCompany($this->getAccount()->getCompany());
            }

            // Format the office phone number for use
            $formattedOfficePhone = $this->getAccount()->getOfficePhoneExt() ? $this->getAccount()->getOfficePhone() . ' Ext ' . $this->getAccount()->getOfficePhoneExt() : $this->getAccount()->getOfficePhone();

            $this->search[] = '{user.firstName}';
            $this->replace[] = $this->getAccount()->getFirstName();

            $this->search[] = '{user.lastName}';
            $this->replace[] = $this->getAccount()->getLastName();

            $this->search[] = '{user.jobTitle}';
            $this->replace[] = $this->getAccount()->getTitle();

            $this->search[] = '{user.email}';
            $this->replace[] = $this->getAccount()->getEmail();

            $this->search[] = '{email}';
            $this->replace[] = $this->getAccount()->getEmail();

            $this->search[] = '{user.cellPhone}';
            $this->replace[] = $this->getAccount()->getCellPhone();

            $this->search[] = '{user.officePhone}';
            $this->replace[] = $formattedOfficePhone;

            $this->search[] = '{user.accountExpiry}';
            $this->replace[] = $this->getAccount()->getExpires(true);

            $this->search[] = '{user.userClass}';
            $this->replace[] = $this->getAccount()->getUserClass(true);

            $this->search[] = '{user.passwordResetLink}';
            $this->replace[] = $this->getAccount()->getRecoveryCodeLink($this->createPassword);
        }

        if ($this->getCompany()) {

            $this->search[] = '{company.name}';
            $this->replace[] = $this->getCompany()->getCompanyName();

            $this->search[] = '{company.website}';
            $this->replace[] = $this->getCompany()->getCompanyWebsite();

        }

        if ($this->getLead()) {

            $this->search[] = '{lead.firstName}';
            $this->replace[] = $this->getLead()->getFirstName();

            $this->search[] = '{lead.lastName}';
            $this->replace[] = $this->getLead()->getLastName();

            $this->search[] = '{lead.companyName}';
            $this->replace[] = $this->getLead()->getCompanyName();

            $this->search[] = '{lead.projectName}';
            $this->replace[] = $this->getLead()->getProjectName();
        }

        if ($this->getProspect()) {

            $this->search[] = '{prospect.firstName}';
            $this->replace[] = $this->getProspect()->getFirstName();

            $this->search[] = '{prospect.lastName}';
            $this->replace[] = $this->getProspect()->getLastName();

            $this->search[] = '{prospect.companyName}';
            $this->replace[] = $this->getProspect()->getCompanyName();
        }

        if ($this->getNavlink()) {
            $this->search[] = '{navigationLink}';
            $this->replace[] = $this->getNavlink();
        }

        if ($this->getAuditLeads()) {
            $this->search[] = '{audit.links}';

            $auditLeadsReplace = '';

            foreach ($this->getAuditLeads() as $auditLead) {
                /* @var $auditLead models\Leads */

                $auditLeadsReplace .= '<p>
                 <strong>Lead Information:</strong></p>
                <p>
                 <strong>Company Name:</strong> ' . $auditLead->getCompanyName() . '<br />
                 <strong>Contact:</strong> ' . $auditLead->getFirstName() . ' ' . $auditLead->getLastName() . '<br />
                 <strong>Title:</strong> ' . $auditLead->getTitle() . '<br />
                 <strong>Phone:</strong> ' . $auditLead->getCellPhone() . '<br />
                 <strong>Email: </strong> ' . $auditLead->getEmail() . '<br />
                 <strong>Lead Address:</strong> ' . $auditLead->getAddress() . ' ' . $auditLead->getCity() . ' ' . $auditLead->getState() . ' ' . $auditLead->getZip() . '</p>
                <p>
                 <strong>Project Information:</strong></p>
                <p>
                 <strong><strong>Project Name:</strong> ' . $auditLead->getProjectName() . '<br />
                 Address:</strong> ' . $auditLead->getProjectAddress() . ' ' . $auditLead->getProjectCity() . ' ' . $auditLead->getProjectState() . ', ' . $auditLead->getProjectZip() . '<br />
                 <strong>Contact:</strong> ' . $auditLead->getProjectContact() . '<br />
                 <strong>Phone: </strong> ' . $auditLead->getProjectPhone() . '<br />
                 &nbsp;</p>
                <p>
                
                <p style="text-align: center;"><a href="' . $auditLead->getPsaAuditUrl() . '" style="display: inline-block; float: none; margin: 5px 10px; text-align: center; padding: 15px 20px; border-radius: 5px; background-color: #008cba; color: #fff; font-size: 22px; text-decoration: none; width: 200px;">Start Audit</a><a href="' . $auditLead->getPsaSmsUrl() . '" style="display: inline-block; float: none; margin: 5px 10px; text-align: center;padding: 15px 20px; border-radius: 5px; background-color: #E69A29; color: #000; font-size: 22px; text-decoration: none; width: 200px;">Send Audit Via Text</a></p>
                
                 <strong>Notes:</strong></p>
                <p>' . $auditLead->getNotes() . '</p>
                <p>
                 ---------------------------------------------<br />';
            }

            $this->replace[] = $auditLeadsReplace;
        }

        $this->search[] = '{site_title}';
        $this->replace[] = config_item('site_name');

        $this->search[] = '{site_name}';
        $this->replace[] = config_item('site_name');

        $this->search[] = '{login_url}';
        $this->replace[] = site_url('home/signin');

        $text = str_replace($this->getSearch(), $this->getReplace(), $text);

        if ($wrap) {
            $text = $this->wrapTop . $text . $this->wrapBottom;
        }

        return $text;
    }

}