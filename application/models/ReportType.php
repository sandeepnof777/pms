<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="report_types")
 */
class ReportType {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @var
     */
    private $name;

    const PROSPECTS = 1;
    const LEADS = 2;
    const CLIENTS = 3;
    const PROPOSALS = 4;
    const HISTORY = 5;
    const SERVICES = 6;
    const ACCOUNTS = 7;

    function __construct(){

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    public static function getAll(){
        $CI =& get_instance();
        $dql = "SELECT rt
                FROM \models\ReportType rt";

        return $CI->em->createQuery($dql)->getResult();
    }
}