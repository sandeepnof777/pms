<?php
namespace Pms\Cron;

use Pms\CronInterface;
use Pms\Traits\RepositoryTrait;

class QuickBooks implements CronInterface
{
    use RepositoryTrait;

    public function run()
    {


        $qbCompanies = $this->getCompanyRepository()->quickbookSyncCompanies();

        foreach ($qbCompanies as $company) {
            /* @var \models\Companies $company */

            if ($company->getQuickbooksSettings()) {
                echo '<h2>Syncing ' . $company->getCompanyName() . '</h2>';

                if ($company->getQuickbooksSettings()->getIncomeAccountId() && $company->getQuickbooksSettings()->getExpenseAccountId()) {
                    if($this->getQuickbooksRepository()->checkQbConnection($company)){
                        try {
                            $this->getQuickbooksRepository()->migrateQbServices($company);
                            $this->getQuickbooksRepository()->syncServices($company);
                            $this->getQuickbooksRepository()->syncContacts($company);
                            $this->getQuickbooksRepository()->syncProposals($company);
                            //$this->getQuickbooksRepository()->syncPaymentStatus($company);
                        } catch (\Exception $e) {
                           // echo '<p>Error syncing for this company. Check the logs.'.$e;
                            echo '<p>Error syncing for company ' . $company->getCompanyName() . '. Check the logs. Details: ' . $e->getMessage() . '</p>';

                        }
                    } else {
                        continue;
                    }
                } else {
                    echo '<p>Company does not have income and expense accounts set</p>';
                }
            }
        }
    }

}