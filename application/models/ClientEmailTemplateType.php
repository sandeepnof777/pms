<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_email_template_types")
 */
class ClientEmailTemplateType extends \MY_Model {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;
    /**
     * @ORM\Column(type="text",  nullable=true)
     */
    private $description;
    /**
     * @ORM\OneToMany(targetEntity="ClientEmailTemplateTypeField", mappedBy="template_type", cascade={"persist"})
     */
    private $fields;
    /**
     * @ORM\Column(type="integer",  nullable=true)
     */
    private $visible;


    const PROPOSAL = 1;
    const LEAD = 2;
    const PROSPECT = 3;
    const GLOB = 4;
    const CLIENT = 5;

    public function getTypeId() {
        return $this->id;
    }

    public function setTypeId($id) {
        $this->id = $id;
    }

    public function getTypeName() {
        return $this->name;
    }

    public function setTypeName($name) {
        $this->name = $name;
    }

    public function getTypeDescription() {
        return $this->description;
    }

    public function setTypeDescription($description) {
        $this->description = $description;
    }

    public function getFields() {
        return $this->fields;
    }

    /**
     * @description Return an array of all Email Template Types
     * @return array
     */
    public static function getAllTypes($hidden = false) {

        $CI =& get_instance();
        $dql = "SELECT cett
                FROM \models\ClientEmailTemplateType cett";
        if (!$hidden) {
            $dql .= ' where cett.visible = 1';
        }
        $dql .= " ORDER by cett.visible DESC, cett.id ASC";

        $query = $CI->em->createQuery($dql);

        return $query->getResult();
    }


    public function getAdminCount() {

        $dql = "SELECT COUNT(cet.templateId)
                FROM \models\ClientEmailTemplate cet
                WHERE cet.company IS NULL
                AND cet.template_type = :typeId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('typeId', $this->getTypeId());

        return $query->getSingleScalarResult();
    }

    /**
     * @return bool true if visible is set to false
     */
    function isHidden() {
        return !$this->visible;
    }
}