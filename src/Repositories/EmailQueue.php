<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class EmailQueue extends RepositoryAbstract
{
    use DBTrait;

    public function add($data = [])
    {
        $defaults = [
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'fromName' => SITE_NAME,
            'completed' => 0,
            'due' => time(), //set it to fire immediately if just adding
            'completedAt' => null
        ];
        if (!$data['subject'] || !$data['recipient'] || !$data['body']) {
            return false;
        }
        $this->insert('email_queue', array_merge($defaults, $data));
        return true;
    }
}