<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="prospect_types")
 */
class ProspectType
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
    private $type_name;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company_id;

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
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompany($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * Check if a status is unique for the specified account (defaults to NULL - the default texts)
     *
     * @param $text
     * @param Accounts $account
     * @return bool
     */
    public static function isUnique($text, Accounts $account = null)
    {

        $CI = &get_instance();

        $dql = "SELECT COUNT(pt.id) FROM models\ProspectType pt
                    WHERE pt.type_name = :typeName";

        if ($account) {
            $dql .= " AND (pt.company_id = " . $account->getCompany()->getCompanyId() . " OR pt.company_id IS NULL)";
        } else {
            $dql .= " AND pt.company IS NULL";
        }

        $query = $CI->em->createQuery($dql);
        $query->setParameter('typeName', $text);

        $count = $query->getSingleScalarResult();

        if ($count) {
            return false;
        }
        return true;
    }

}