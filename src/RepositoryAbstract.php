<?php
namespace Pms;

use Pms\Repositories\Account;
use Pms\Repositories\Email;
use Pms\Repositories\Lead;
use Pms\Traits\CITrait;
use Pms\Traits\RepositoryTrait;
use \Carbon\Carbon;

abstract class RepositoryAbstract
{
    use CITrait, RepositoryTrait;

    /**
     * RepositoryAbstract constructor.
     */
    public function __construct()
    {
        $this->initCiVariables();
    }
}