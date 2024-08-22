<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_email_types")
 */
class EventMailType extends \MY_Model
{
    const CLIENT = 1;
    const CC = 2;
    const BCC = 3;
    const WORKORDER = 4;
    const GROUPRESEND = 5;
    

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    
    private $type_name;
   /**
     * @ORM\Column(type="string")
     */
    
    private $type_code;
   /**
     * @ORM\Column(type="string")
     */
    
    private $color_code;
      
    
    function __construct()
    {
    }

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
    public function getTypeName()
    {
        return $this->type_name;
    }

    /**
     * @param mixed $type_name
     */
    public function setTypeName($type_name)
    {
        $this->type_name = $type_name;
    }

    /**
     * @return mixed
     */
    public function getTypeCode()
    {
        return $this->type_code;
    }

    /**
     * @param mixed $type_code
     */
    public function setTypeCode($type_code)
    {
        $this->type_code = $type_code;
    }

    /**
     * @return mixed
     */
    public function getColorCode()
    {
        return $this->color_code;
    }

    /**
     * @param mixed $color_code
     */
    public function setColorCode($color_code)
    {
        $this->color_code = $color_code;
    }

    
    

}