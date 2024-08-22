<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="service_texts")
 */
class ServiceText extends \MY_Model{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $textId;
    /**
     * @ORM\Column(type="string")
     */
    private $textValue;
    /**
     * @ORM\Column(type="integer")
     */
    private $service;
    /**
     * @ORM\Column(type="integer")
     */
    private $company;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;

    function __construct() {
    }

    public function getTextId() {
        return $this->textId;
    }

    public function getText() {
        $s = array('<p>', '</p>');
        $r = array('', '<br>');
        return strip_tags(str_replace($s, $r, $this->textValue), '<b><i><u><ul><ol><li><strong><em><a><p><br><span>');
    }

    public function setText($textValue) {
        $s = array('<p>', '</p>');
        $r = array('', '<br>');
        $this->textValue = strip_tags(str_replace($s, $r, $textValue), '<b><i><u><ul><ol><li><strong><em><a><p><br><span>');
    }

    public function getService() {
        return $this->service;
    }

    public function setService($service) {
        $this->service = $service;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getOrd() {
        return $this->ord;
    }

    public function setOrd($ord) {
        $this->ord = $ord;
    }

    public function deleteAuth(Accounts $account) {
        // Admins can do everything
        if ($account->isGlobalAdministrator()) {
            return true;
        }

        // Don't let non admins do this
        if (!$account->isAdministrator()) {
            return false;
        }

        // Allow if company is set and and user belongs to company
        if ($this->getCompany()) {
            if ($this->getCompany() == $account->getCompany()->getCompanyId()){
                return true;
            }
        }
        else {
            return true;
        }
    }


    public function migrateOrder($newServiceId, $newTextId, $companyId) {

        $dql = "UPDATE \models\ServiceTextOrder sto
                SET sto.service = :serviceId, sto.textId = :newTextId
                WHERE sto.company = :companyId
                AND sto.textId = :textId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('textId', $this->getTextId());
        $query->setParameter('newTextId', $newTextId);
        $query->setParameter('serviceId', $newServiceId);

        $rows = $query->execute();

        return $rows;
    }


    public function migrateDeleted($newTextId, $companyId) {

        $dql = "UPDATE \models\Service_deleted_texts sdt
                SET sdt.textId = :newTextId
                WHERE sdt.company = :companyId
                AND sdt.textId = :textId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('textId', $this->getTextId());
        $query->setParameter('newTextId', $newTextId);

        $rows = $query->getResult();

        return $rows;
    }
}