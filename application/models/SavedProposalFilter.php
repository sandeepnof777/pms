<?php 
namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="saved_proposal_filter")
 */
class SavedProposalFilter {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column (type="integer")
     */
    private $company_id;

    /**
     * @ORM\Column (type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column (type="string")
     */
    private $filter_name;

    /**
     * @ORM\Column (type="string")
     */
    private $filter_data;

    /**
     * @ORM\Column (type="string")
     */
    private $filter_page;

    /**
     * @ORM\Column (type="string")
     */
    private $created_at;

    /**
     * @ORM\Column (type="string")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;



    function __construct() {
        $this->updated_at = time();
    }

    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $filter_name
     */
    public function setFilterName($filter_name)
    {
        $this->filter_name = $filter_name;
    }

    /**
     * @return mixed
     */
    public function getFilterName()
    {
        return $this->filter_name;
    }

    /**
     * @param mixed $filter_data
     */
    public function setFilterData($filter_data)
    {
        $this->filter_data = $filter_data;
    }

    /**
     * @return mixed
     */
    public function getFilterData()
    {
        return $this->filter_data;
    }

    /**
     * @param mixed $filter_page
     */
    public function setFilterPage($filter_page)
    {
        $this->filter_page = $filter_page;
    }

    /**
     * @return mixed
     */
    public function getFilterPage()
    {
        return $this->filter_page;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    /**
     * @return mixed
     */
    public function getord()
    {
        return $this->ord;
    }

}
?>