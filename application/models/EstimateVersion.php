<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimate_versions")
 */
class EstimateVersion extends \MY_Model
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
    private $user_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_id;
   

    /**
     * @ORM\Column(type="string")
     */
    private $created_at;
    /**
     * @ORM\Column(type="string")
     */
    private $updated_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $base_version;
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
    public function getProposalId()
    {
        return $this->proposal_id;
    }

    /**
     * @param mixed $proposal_id
     */
    public function setProposalId($proposal_id)
    {
        $this->proposal_id = $proposal_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at ;
    }

    /**
     * @param mixed created_at 
    */
    public function setCreatedAt($created_at)
    {
        $this->created_at  = $created_at ;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at ;
    }

    /**
     * @param mixed updated_at 
    */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at  = $updated_at ;
    }
    
    /**
     * @return mixed
     */
    public function getBaseVersion()
    {
        return $this->base_version ;
    }

    /**
     * @param mixed base_version 
    */
    public function setBaseVersion($base_version)
    {
        $this->base_version  = $base_version ;
    }
}