<?php


namespace Pms\Traits;


trait CITrait
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * @var \CI_DB_active_record
     */
    protected $db;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;

    public function initCiVariables()
    {
        $this->ci =& get_instance();

        if ($this->ci) {
            $this->db = $this->ci->db;
            $this->em = $this->ci->doctrine->em;
        }
    }
}