<?php

namespace Pms\Cron;

use Pms\CronInterface;
use Pms\Traits\RepositoryTrait;

class ProposalViewEmails implements CronInterface
{
    use RepositoryTrait;

    public function run()
    {
        // The function requires library loading, so I've moved it into a repo
        $this->getProposalRepository()->sendProposalViewedEmails();
    }
}