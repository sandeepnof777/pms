<?php
namespace Pms\Cron;

use Pms\CronInterface;
use Pms\Traits\RepositoryTrait;

class AuditReminder implements CronInterface
{
    use RepositoryTrait;

    private $minutes = 15;

    public function run()
    {
        $proposals = $this->getProposalRepository()->getAuditReminderProposals($this->minutes);

        if (count($proposals)) {
            foreach ($proposals as $proposal) {
                /* @var \models\Proposals $proposal */

                // Load the template
                $template = $this->getEmailRepository()->em->find('models\Email_templates', 24);
                /* @var $template \models\Email_templates */
                $parser = new \EmailTemplateParser();
                $parser->setProposal($proposal);

                $emailData = [
                    'to' => $proposal->getClient()->getEmail(),
                    'fromEmail' => $proposal->getOwner()->getEmail(),
                    'fromName' => $proposal->getOwner()->getFullName(),
                    'replyTo' => $proposal->getOwner()->getEmail(),
                    'subject' => $parser->parse($template->getTemplateSubject()),
                    'body' => $parser->parse($template->getTemplateBody()),
                    'categories' => ['Audit Reminder']
                ];

                $this->getEmailRepository()->send($emailData);

                $this->getLogRepository()->add([
                    'action' => 'Audit Reminder Email',
                    'details' => 'Audit Reminder Email sent to ' . $proposal->getClient()->getEmail(),
                    'client' => $proposal->getClient()->getClientId(),
                    'proposal' => $proposal->getProposalId(),
                    'company' => $proposal->getClient()->getCompany()->getCompanyId(),
                ]);
                $proposal->setAuditReminderSent(time());
                $this->getProposalRepository()->em->flush($proposal);
            }
        }
    }


}