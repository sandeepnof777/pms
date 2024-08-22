<?php
namespace Pms\Cron;

use Carbon\Carbon;
use models\ProposalAutomaticResend;
use Pms\CronInterface;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use Pms\Traits\RepositoryTrait;

class ProposalResend extends RepositoryAbstract implements CronInterface
{
    use RepositoryTrait;
    use DBTrait;
    private $start;
    private $times;
    private $time_limit = 60; //max run time to be 1 minute
    private $templates = [];

    function __construct()
    {
        parent::__construct();
        set_time_limit(120);
        $this->start = time();
        $nowEST = date('G');
        $this->times = [
            'EST' => $nowEST,
            'CST' => ($nowEST - 1),
            'MST' => ($nowEST - 2),
            'PST' => ($nowEST - 3),
        ];
    }

    /**
     * Runs the Cron
     */
    public function run()
    {
        echo 'The time is: ' . date('H:i:s') . ' <br>';
        foreach ($this->times as $timezone => $hour) {
            $this->resend($hour, $timezone);
            if ($this->timeLimitExceeded()) {
                break;
            }
        }
        echo 'Done!';
    }

    /**
     * Checks if the time limit is exceeded to stop execution
     * @return bool
     */
    public function timeLimitExceeded()
    {
        return (abs(time() - $this->start) > $this->time_limit);
    }

    /**
     * Returns array with all proposals that need to be sent for that hour and timezone
     * @param $hour
     * @param $timezone
     * @return array
     */
    public function getProposalsToResend($hour, $timezone)
    {
        $now = time();
        return $this->getAllResults("SELECT p.proposalId, p.resend_enabled, p.resend_frequency, p.resend_template, p.emailSendTime, p.proposalStatus, p.projectName, a.timeZone
            FROM proposals p LEFT JOIN clients cl ON p.client = cl.clientId LEFT JOIN proposal_resend_settings prs ON prs.company = cl.company LEFT JOIN accounts a ON cl.account = a.accountId
            WHERE 
              prs.enabled = 1 AND p.resend_enabled = 1 AND p.resend_excluded = 0 AND p.emailSendTime IS NOT NULL 
              AND ( ({$now} - p.emailSendTime) >= p.resend_frequency ) 
              AND p.proposalStatus IN (prs.statuses) and a.timeZone = '{$timezone}' AND prs.resend_time = {$hour} limit 50");
    }

    /**
     * Resends proposals for specific hour and timezone
     * @param $hour
     * @param $timezone
     */
    public function resend($hour, $timezone)
    {
        echo "Hour: {$hour} | Timezone: {$timezone} <br>";
        $proposalsToResend = $this->getProposalsToResend($hour, $timezone);

        foreach ($proposalsToResend as $proposalData) {
            /** @var \models\Proposals $proposal */
            $proposal = $this->em->find('\models\Proposals', $proposalData->proposalId);
            $templateId = ($proposalData->resend_template) ?: $proposalData->template;
            $template = $this->getTemplateData($templateId);
            if($template && !empty($template->templateBody)){
                echo 'Sending Proposal "' . $proposal->getProjectName() . '"<br>';
                $emailData = [
                    'fromName' => $proposal->getOwner()->getFullName() . ' via ' . SITE_NAME,
                    'fromEmail' => 'proposals@' . SITE_EMAIL_DOMAIN,
                    'subject' => 'Proposal for ' . $proposal->getProjectName(),
                    'body' => $template->templateBody,
                    'replyTo' => $proposal->getClient()->getAccount()->getEmail(),
                    'emailCC' => false,
                ];
                $account = $proposal->getClient()->getAccount();
                //Log Automatic resend
                $par = new ProposalAutomaticResend();
                $par->setProposalId($proposalData->proposalId);
                $par->setEmailContent($template->templateBody);
                $par->setSentAt(Carbon::now());
                $this->em->persist($par);
                $this->em->flush();

                $this->getProposalRepository()->send($proposalData->proposalId, $emailData, $account,null,null,$par->getId(),'automatic');
            }
            if ($this->timeLimitExceeded()) {
                break;
            }
        }
    }

    /**
     * Gets the template data by Template id from db
     * @param $templateId
     * @return mixed
     */
    public function getTemplate($templateId)
    {
        return $this->getSingleResult("select * from client_email_templates where templateId={$templateId}");
    }

    /**
     * Gets template data from cached array
     * @param $templateId
     * @return mixed
     */
    public function getTemplateData($templateId)
    {
        if (!isset($this->templates[$templateId])) {
            $this->templates[$templateId] = $this->getTemplate($templateId);
        }
        return $this->templates[$templateId];
    }

}