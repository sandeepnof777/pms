<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="prospect_sources")
 */
class ProspectSource
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
    private $name;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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

        $dql = "SELECT COUNT(ps.id) FROM models\ProspectSource ps
                    WHERE ps.name = :sourceName";

        if ($account) {
            $dql .= " AND (ps.company_id = " . $account->getCompany()->getCompanyId() . " OR ps.company_id IS NULL)";
        } else {
            $dql .= " AND ps.company IS NULL";
        }

        $query = $CI->em->createQuery($dql);
        $query->setParameter('sourceName', $text);

        $count = $query->getSingleScalarResult();

        if ($count) {
            return false;
        }
        return true;
    }

}