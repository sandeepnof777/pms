<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="user_roles")
 */
class UserRole
{
    // const OFFICE = 134;
    // const SHOPPING_CENTER = 48;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $role_name;
    
    // /**
    //  * @ORM\Column(type="integer", nullable=true)
    //  */
    // private $deleted=0;
    // /**
    //  * @ORM\Column(type="integer")
    //  */
    // private $ord = 999;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRoleName()
    {
        return $this->role_name;
    }

    /**
     * @param mixed $role_name
     */
    public function setRoleName($role_name)
    {
        $this->role_name = $role_name;
    }

 

   
    

}