<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_cost_item_files")
 */
class JobCostItemFile extends \MY_Model
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
    private $job_cost_item_id;

    /**
     * @ORM\Column(type="string")
     */
    private $file_name;
     
    /**
     * @ORM\Column(type="string")
     */
    private $created_at;

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
     * @return mixed
     */
    public function getJobCostItemId()
    {
        return $this->job_cost_item_id;
    }

    /**
     * @param mixed $job_cost_item_id
     */
    public function setJobCostItemId($job_cost_item_id)
    {
        $this->job_cost_item_id = $job_cost_item_id;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * @param mixed $file_name
     */
    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    
    
}