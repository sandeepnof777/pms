<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lead_sources")
 */
class LeadSource {
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
    public static function isUnique($text, \models\Accounts $account = null)
    {
        $CI = &get_instance();
        $sql = "SELECT  COUNT(ls.id) AS count_id FROM lead_sources ls
        LEFT JOIN lead_source_deleted lsd ON ls.id = lsd.lead_source_id
        WHERE ls.name = '$text'";

        if($account){
                $sql.= " AND lsd.id IS NULL AND ls.company_id = " . $account->getCompany()->getCompanyId();
            }
            else {
                $sql.= " AND lsd.id IS NULL AND ls.company IS NULL";
            }

        $count = $CI->db->query($sql)->result();
        if($count){
            if($count[0]->count_id > 0) {
                return false;
            }
        }
        return true;
    }

}