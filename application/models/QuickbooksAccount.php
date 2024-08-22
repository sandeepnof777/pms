<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="quickbook_accounts")
 */
class QuickbooksAccount
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $c_id;
    /**
     * @ORM\Column(type="string")
     */
    private $acc_name;
    /**
     * @ORM\Column(type="string")
     */
    private $acc_type;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCId()
    {
        return $this->c_id;
    }

    /**
     * @param mixed $c_id
     */
    public function setCId($c_id)
    {
        $this->c_id = $c_id;
    }

    /**
     * @return mixed
     */
    public function getAccName()
    {
        return $this->acc_name;
    }

    /**
     * @param mixed $acc_name
     */
    public function setAccName($acc_name)
    {
        $this->acc_name = $acc_name;
    }

    /**
     * @return mixed
     */
    public function getAccType()
    {
        return $this->acc_type;
    }

    /**
     * @param mixed $acc_type
     */
    public function setAccType($acc_type)
    {
        $this->acc_type = $acc_type;
    }


}