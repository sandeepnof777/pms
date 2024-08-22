<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;


class SendgridRepository extends RepositoryAbstract
{
    use DBTrait;

    protected $sendgrid = null;
    var $apiKey;

    public function __construct()
    {
        parent::__construct();
        $this->apiKey = $_ENV['SENDGRID_API_KEY'];
    }

    public function getBlacklistedDomains()
    {
        return [
            'gmail.com',
            'yahoo.com',
            'hotmail.com',
            'aol.com',
            'ymail.com',
            'comcast.net',
            'outlook.com',
            'verizon.com',
            'verizon.net',
            'me.com',
            'watchtv.net',
            'att.net',
            'gulftel.com',
            'hvc.rr.com',
            'bellsouth.net',
            'live.com',
            'icloud.com',
        ];
    }

    /**
     * @return \SendGrid
     */
    public function getSendgridInstance()
    {
        if ($this->sendgrid === null) {
            $this->sendgrid = new \SendGrid($this->apiKey);
        }
        return $this->sendgrid;
    }


    function updateAddressWhitelist()
    {

        // Start off the whitelis with pavementlayers.com
        $whitelistDomains = [
            'pavementlayers.com',
            'landscapelayers.com'
        ];

        $companies = $this->getCompanyRepository()->getEmailWhitelistCompanies();

        foreach ($companies as $company) {
            /* @var $company \models\Companies */
            $admin = $company->getAdministrator();

            if ($admin) {
                $email = $admin->getEmail();
                $domain = strtolower(getDomainFromEmail($email));

                if (!in_array($domain, $this->getBlacklistedDomains())) {
                    $whitelistDomains[] = strtolower($domain);
                }
            }
        }

        $data = [
            'enabled' => true,
            'list' => $whitelistDomains
        ];

        $this->getSendgridInstance()->client->mail_settings()->address_whitelist()->patch($data);
    }

}