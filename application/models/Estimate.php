<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimates")
 */
class Estimate extends \MY_Model
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
    private $proposal_service_id;   
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $total_price;
    /**
     * @ORM\Column(type="string")
     */
    private $completed = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $custom_price = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $overhead_rate;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $profit_rate;
  
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
    public function getProposalServiceId()
    {
        return $this->proposal_service_id;
    }

    /**
     * @param mixed $proposal_service_id
     */
    public function setProposalServiceId($proposal_service_id)
    {
        $this->proposal_service_id = $proposal_service_id;
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
    public function getTotalPrice()
    {
        return $this->total_price;
    }

    /**
     * @param mixed $total_price
     */
    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;
    }

    /**
     * @return mixed
     */
    public function getCustomPrice()
    {
        return $this->custom_price;
    }

    /**
     * @param mixed $custom_price
     */
    public function setCustomPrice($custom_price)
    {
        $this->custom_price = $custom_price;
    }

    /**
     * @return mixed
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @param mixed $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

    /**
     * @return \models\Proposal_services
     */
    public function getProposalService()
    {
        return $this->doctrine->em->findProposalService($this->getProposalServiceId());
    }

    /**
     * @return mixed
     */
    public function getOverheadRate()
    {
        return $this->overhead_rate;
    }

    /**
     * @param mixed $overhead_rate
     */
    public function setOverheadRate($overhead_rate)
    {
        $this->overhead_rate = $overhead_rate;
    }

    /**
     * @return mixed
     */
    public function getProfitRate()
    {
        return $this->profit_rate;
    }

    /**
     * @param mixed $profit_rate
     */
    public function setProfitRate($profit_rate)
    {
        $this->profit_rate = $profit_rate;
    }
    
}