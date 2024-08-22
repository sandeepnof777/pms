<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class ProposalServices extends RepositoryAbstract
{
    use DBTrait;

    public function getAll($company)
    {
        return $this->get(null, $company);
    }

    public function getParents($company)
    {
        return $this->get(0, $company);
    }

    public function getChildren($parentId, $company)
    {
        return $this->get($parentId, $company);
    }

    public function get($parent = null, $company)
    {
        $sql = "select * from services where (company is null or company ={$company})";
        if ($parent !== null) {
            $sql .= ' and parent = '.$parent;
        }
        return $this->getAllResults($sql);
    }
}