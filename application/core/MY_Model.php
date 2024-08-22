<?php

## Extend CI_Controller to include Doctrine Entity Manager

class  MY_Model extends CI_Model
{
    use \Pms\Traits\RepositoryTrait;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;


    function __construct()
    {
        parent::__construct();

        /* Instantiate Doctrine's Entity manage so we don't have
           to everytime we want to use Doctrine */

        $this->em = $this->doctrine->em;
    }

}  