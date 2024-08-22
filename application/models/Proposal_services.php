<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_services")
 */
class Proposal_services extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $serviceId;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal;
    /**
     * @ORM\Column(type="integer")
     */
    private $initial_service;
    /**
     * @ORM\Column(type="string")
     */
    private $serviceName;
    /**
     * @ORM\Column(type="string")
     */
    private $price;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;
    /**
     * @ORM\Column(type="string")
     */
    private $amountQty;
    /**
     * @ORM\Column(type="string")
     */
    private $pricingType;
    /**
     * @ORM\Column(type="string")
     */
    private $material;
    /**
     * @ORM\Column(type="integer")
     */
    private $optional;
    /**
     * @ORM\Column(type="integer")
     */
    private $no_price;
    /**
     * @ORM\Column(type="integer")
     */
    private $tax;
    /**
     * @ORM\Column(type="integer")
     */
    private $exclude_from_total;
    /**
     * @ORM\Column(type="integer")
     */
    private $approved;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBID;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBSyncToken;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBSyncFlag;
    /**
     * @ORM\Column (type="string")
     */
    private $QBError;
    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $tax_price;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_estimate;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_hide_in_proposal = 0;
    /**
     * @ORM\Column (type="string")
     */
    private $map_area_data;
    
    function __construct()
    {
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }

    public function getProposal()
    {
        return $this->proposal;
    }

    public function setProposal($proposal)
    {
        $this->proposal = $proposal;
    }

    public function getInitialService()
    {
        return $this->initial_service;
    }

    public function setInitialService($service)
    {
        $this->initial_service = $service;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    public function getPrice($number = false)
    {
        $s = array('$', ',');
        $r = array('', '');
        $price = preg_replace("/[^0-9$,.-]/", "", $this->price);
        if (!strlen($price)) {
            $price = '$0';
        } else {
            // There could be a single character of '$', so add a zero if it is.
            if ($price == '$') {
                $price = '$0';
            }
        }

        if (!$number) {
            return $price;
        } else {
            return str_replace($s, $r, $price);
        }
    }

    public function getFormattedPrice()
    {
        $s = ['$', ',', '-'];
        $r = ['', '', ''];

        if ($this->getPrice(true) < 0) {
            return '($' . number_format(floatval(str_replace($s, $r, $this->getPrice())), 2) . ')';
        }

        return '$' . number_format(floatval(str_replace($s, $r, $this->getPrice())), 2);
    }

    public function setPrice($price)
    {
        $price = preg_replace("/[^0-9$,.-]/", "", $price);
        if (!strlen($price)) {
            $price = '$0';
        }
        $this->price = $price;
    }

    public function getOrd()
    {
        return $this->ord;
    }

    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    public function getAmountQty()
    {
        return $this->amountQty;
    }

    public function setAmountQty($amountQty)
    {
        $this->amountQty = $amountQty;
    }

    public function getPricingType()
    {
        return $this->pricingType;
    }

    public function setPricingType($pricingType)
    {
        $this->pricingType = $pricingType;
    }

    public function getMaterial()
    {
        return $this->material;
    }

    public function setMaterial($material)
    {
        $this->material = $material;
    }

    /**
     * @return mixed
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * @param mixed $optional
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;
    }

    /**
     * @return mixed
     */
    public function getNoPrice()
    {
        return $this->no_price;
    }

    /**
     * @param mixed $noPrice
     */
    public function setNoPrice($noPrice)
    {
        $this->no_price = $noPrice;
    }

    /**
     * Returns 1 if service is no price, 0 otherwise
     * @return mixed
     */
    public function isNoPrice()
    {
        return $this->getNoPrice();
    }

    /**
     * Returns 1 if service is optional, 0 otherwise
     * @return mixed
     */
    public function isOptional()
    {
        return $this->getOptional();
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return mixed
     */
    public function getExcludeFromTotal()
    {
        return $this->exclude_from_total;
    }

    /**
     * @param mixed $exclude_from_total
     */
    public function setExcludeFromTotal($exclude_from_total)
    {
        $this->exclude_from_total = $exclude_from_total;
    }

    /**
     * @return mixed
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @param mixed $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * @return mixed
     */
    public function isApproved()
    {
        return $this->getApproved();
    }

    /**
     * @return mixed
     */
    public function getQBID()
    {
        return $this->QBID;
    }

    /**
     * @param mixed $QBID
     */
    public function setQBID($QBID)
    {
        $this->QBID = $QBID;
    }

    /**
     * @return mixed
     */
    public function getQBSyncToken()
    {
        return $this->QBSyncToken;
    }

    /**
     * @param mixed $QBSyncToken
     */
    public function setQBSyncToken($QBSyncToken)
    {
        $this->QBSyncToken = $QBSyncToken;
    }

    /**
     * @return mixed
     */
    public function getQBSyncFlag()
    {
        return $this->QBSyncFlag;
    }

    /**
     * @param mixed $QBSyncFlag
     */
    public function setQBSyncFlag($QBSyncFlag)
    {
        $this->QBSyncFlag = $QBSyncFlag;
    }

    /**
     * @return mixed
     */
    public function getQBError()
    {
        return $this->QBError;
    }

    /**
     * @param mixed $QBError
     */
    public function setQBError($QBError)
    {
        $this->QBError = $QBError;
    }

    /**
     * @return mixed
     */
    public function getTaxPrice()
    {
        return $this->tax_price;
    }

    /**
     * @param mixed $tax_price
     */
    public function setTaxPrice($tax_price)
    {
        $this->tax_price = $tax_price;
    }

     /**
     * @return mixed
     */
    public function getIsEstimate()
    {
        return $this->is_estimate;
    }

    /**
     * @param mixed $is_estimate
     */
    public function setIsEstimate($is_estimate)
    {
        $this->is_estimate = $is_estimate;
    }

    /**
     * @return mixed
     */
    public function getIsHideInProposal()
    {
        return $this->is_hide_in_proposal;
    }

    /**
     * @param mixed $is_hide_in_proposal
     */
    public function setIsHideInProposal($is_hide_in_proposal)
    {
        $this->is_hide_in_proposal = $is_hide_in_proposal;
    }

    

    public function getServicesModel()
    {
        return $this->doctrine->em->findService($this->getInitialService());
    }

    
    /**
     * @return mixed
     */
    public function getMapAreaData()
    {
        return $this->map_area_data;
    }

    /**
     * @param mixed $map_area_data
     */
    public function setMapAreaData($map_area_data)
    {
        $this->map_area_data = $map_area_data;
    }

    public function getServicesImageCount()
    {
        $sql = "SELECT COUNT(pm)
                    FROM \models\Proposals_images pm
                    WHERE pm.proposal_service_id = :proposalServiceId";

        $query = $this->doctrine->em->createQuery($sql);
        $query->setParameter('proposalServiceId', $this->serviceId);
        return $query->getSingleScalarResult();
    }

    function hasMapImage()
    {
        $dql = "SELECT COUNT(pm.imageId)
                FROM \models\Proposals_images pm
                WHERE pm.map = 1 AND pm.proposal_service_id = :serviceId";

        $query = $this->doctrine->em->createQuery($dql);
        
        $query->setParameter('serviceId', $this->serviceId);

        $count = $query->getSingleScalarResult();

        if ($count > 0) {
            return true;
        }

        return false;
    }
}