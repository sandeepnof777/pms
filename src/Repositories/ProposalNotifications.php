<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class ProposalNotifications extends RepositoryAbstract
{
    use DBTrait;

    var $notificationSettings = [];


    /**
     * Returns the mysql settings table for the lead notification settings
     * @param $companyId
     * @return mixed
     */
    public function getProposalResendSettings($companyId)
    {
        if (!isset($this->notificationSettings[$companyId])) {
            $settings = $this->getSettingsFromDb($companyId);
            if (!$settings) {
                $this->saveProposalResendSettings([
                    'enabled' => 0,
                    'statuses' => '',
                    'template' => '',
                    'company' => $companyId,
                    'frequency' => '86400',
                    'resend_time' => 9
                ]);
                $settings = $this->getSettingsFromDb($companyId);
            }
            $this->notificationSettings[$companyId] = $settings;
        }
        return ($this->notificationSettings[$companyId]);
    }

    public function getSettingsFromDb($companyId)
    {
        return $this->getSingleResult('select * from proposal_resend_settings where company=' . $companyId);
    }

    public function saveProposalResendSettings($notificationData)
    {
        unset($this->notificationSettings[$notificationData['company']]);
        $this->db->delete('proposal_resend_settings', array('company' => $notificationData['company']));
        $this->db->insert('proposal_resend_settings', $notificationData);
    }


}