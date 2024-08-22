<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="failed_jobs")
 */
class FailedJob extends \MY_Model
{


    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $job_name;
    /**
     * @ORM\Column(type="string")
     */
    private $job_values;
    /**
     * @ORM\Column(type="string")
     */
    private $failed_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $resend = 0;
    /**
     * @ORM\Column(type="string")
     */
    private $job_data;
    /**
    * @ORM\Column(type="string")
    */
    private $error_message;
    /**
    * @ORM\Column(type="string")
    */
    private $job_type;
    /**
     * @ORM\Column(type="integer")
     */
    private $entity_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $campaign_id;
    /**
     * @ORM\Column(type="string")
     */
    private $last_retry_at;
    
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
    public function getJobName()
    {
        return $this->job_name;
    }

    /**
     * @param mixed $job_name
     */
    public function setJobName($job_name)
    {
        $this->job_name = $job_name;
    }

    /**
     * @return mixed
     */
    public function getJobValues()
    {
        return $this->job_values;
    }

    /**
     * @param mixed $job_values
     */
    public function setJobValues($job_values)
    {
        $this->job_values = $job_values;
    }

    /**
     * @return mixed
     */
    public function getFailedAt()
    {
        return $this->failed_at;
    }

    /**
     * @param mixed $failed_at
     */
    public function setFailedAt($failed_at)
    {
        $this->failed_at = $failed_at;
    }
    /**
     * @return mixed
     */
    public function getResend()
    {
        return $this->resend;
    }

    /**
     * @param mixed $resend
     */
    public function setResend($resend)
    {
        $this->resend = $resend;
    }
   
    /**
     * @return mixed
     */
    public function getJobData()
    {
        return $this->job_data;
    }

    /**
     * @param mixed $job_data
     */
    public function setJobData($job_data)
    {
        $this->job_data = $job_data;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param mixed $error_message
     */
    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    /**
     * @return mixed
     */
    public function getJobType()
    {
        return $this->job_type;
    }

    /**
     * @param mixed $job_type
     */
    public function setJobType($job_type)
    {
        $this->job_type = $job_type;
    }

    /**
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }

    /**
     * @param mixed $entity_id
     */
    public function setEntityId($entity_id)
    {
        $this->entity_id = $entity_id;
    }

    /**
     * @return mixed
     */
    public function getCampaignId()
    {
        return $this->campaign_id;
    }

    /**
     * @param mixed $campaign_id
     */
    public function setCampaignId($campaign_id)
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return mixed
     */
    public function getLastRetryAt()
    {
        return $this->last_retry_at;
    }

    /**
     * @param mixed $last_retry_at
     */
    public function setLastRetryAt($last_retry_at)
    {
        $this->last_retry_at = $last_retry_at;
    }
    
    
}