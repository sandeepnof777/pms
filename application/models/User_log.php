<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_log")
 */

class User_log
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $userLogId;
    /**
     * @ORM\OneToOne(targetEntity="Accounts", cascade={"persist"})
     * @ORM\JoinColumn(name="user", referencedColumnName="accountId")
     */
    private $user;

    function __construct() {

    }

}