<?php
namespace Pms\Repositories;


use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class Log extends RepositoryAbstract
{
    use DBTrait;

    /**
     * Adds information provided to the LOG
     * @param array $data
     */
    public function add(array $data)
    {
        //allow ip and timeadded to be overridden
        if (!isset($data['timeAdded'])) {
            $data['timeAdded'] = time();
        }
        if (!isset($data['ip'])) {
            $data['ip'] = $_SERVER['REMOTE_ADDR'];
        }
        $this->insert('log', $data);
    }

}