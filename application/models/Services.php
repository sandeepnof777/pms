<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="services")
 */
class Services extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $serviceId;
    /**
     * @ORM\Column(type="string")
     */
    private $serviceName;
    /**
     * @ORM\Column(type="integer")
     */
    private $parent;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;
    /**
     * @ORM\Column(type="integer")
     */
    private $company;
    /**
     * @ORM\Column(type="integer")
     */
    private $tax;

    function __construct()
    {
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getOrd()
    {
        return $this->ord;
    }

    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    /**
     * @return mixed
     * This property is generated via ResultSetMapping
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
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

    public function editAuth(Accounts $account)
    {
        // Only let admins
        if ($account->isAdministrator()) {
            return true;
        }

        // Default to false
        return false;
    }

    /**
     * @param $companyId
     * @return mixed
     */
    public function getTitle($companyId)
    {
        $ct = $this->getCustomTitle($companyId);

        if ($ct) {
            return $ct->getTitle();
        }
        return $this->getServiceName();
    }

    /**
     * Return the list of parent services (categories)
     * @return mixed
     */
    public static function getCategories()
    {
        $CI =& get_instance();

        $dql = "SELECT s
                FROM \models\Services s
                WHERE s.parent = 0
                ORDER BY s.ord";

        $query = $CI->doctrine->em->createQuery($dql);

        $services = $query->getResult();

        return $services;
    }


    public function getAdminSortedChildren()
    {
        $dql = "SELECT s
                FROM \models\Services s
                WHERE s.parent = :parentId
                AND s.company IS NULL
                ORDER BY s.ord";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('parentId', $this->getServiceId());

        $childServices = $query->getResult();

        return $childServices;
    }

    public static function getPopulatedCategories()
    {
        $categories = Services::getCategories();

        $out = [];

        foreach ($categories as $category) {
            /* @var $category \models\Services */

            $categoryServices = $category->getSortedChildren();

            if (count($categoryServices)) {
                $out[$category->getServiceId()] = [];

                foreach ($categoryServices as $categoryService) {
                    $out[$category->getServiceId()][] = $categoryService;
                }
            }
        }
        return $out;
    }

    public static function getAdminPopulatedCategories()
    {
        $categories = Services::getCategories();

        $out = [];

        foreach ($categories as $category) {
            /* @var $category \models\Services */

            $categoryServices = $category->getAdminSortedChildren();

            if (count($categoryServices)) {
                $out[$category->getServiceId()] = [];

                foreach ($categoryServices as $categoryService) {
                    $out[$category->getServiceId()][] = $categoryService;
                }
            }
        }
        return $out;
    }

    /**
     * @param $companyId
     * @return bool
     */
    public function isEnabled($companyId)
    {
        $dql = "SELECT COUNT(cds.disableId)
                FROM \models\CompanyDisabledService cds
                WHERE cds.service = :serviceId
                AND cds.company = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('serviceId', $this->getServiceId());
        $query->setParameter('companyId', $companyId);

        $count = $query->getSingleScalarResult();

        if ($count > 0) {
            return false;
        }

        return true;
    }

    function getTexts($companyId)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\ServiceText', 'st');
        $rsm->addFieldResult('st', 'textId', 'textId');
        $rsm->addFieldResult('st', 'textValue', 'textValue');
        $rsm->addFieldResult('st', 'service', 'service');
        $rsm->addFieldResult('st', 'company', 'company');
        $rsm->addFieldResult('st', 'ord', 'ord');

        $dql = "SELECT st.*
                FROM service_texts st
                LEFT JOIN service_texts_order sto ON sto.service = st.service
                WHERE st.service = :serviceId
                AND (
                    st.company = :companyId
                    OR st.company = 0
                    )
                ORDER BY COALESCE(sto.ord, 99999), st.ord";

        $query = $this->doctrine->em->createNativeQuery($dql, $rsm);
        $query->setParameter('serviceId', $this->getServiceId());
        $query->setParameter('companyId', $companyId);

        return $query->getResult();
    }

    public function getDefaultTexts()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Select clients from this company that aren't deleted
        $qb->select('st')
            ->from('\models\ServiceText', 'st')
            ->where('st.service = :serviceId')
            ->andWhere('st.company = 0')
            ->orderBy('st.ord', 'ASC')
            ->setParameter('serviceId', $this->getServiceId());

        return $qb->getQuery()->getResult();
    }

    public function getDefaultFields()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Select clients from this company that aren't deleted
        $qb->select('sf')
            ->from('\models\ServiceField', 'sf')
            ->where('sf.service = :serviceId')
            ->andWhere('sf.company IS NULL')
            ->orderBy('sf.ord', 'ASC')
            ->setParameter('serviceId', $this->getServiceId());

        return $qb->getQuery()->getResult();
    }

    public function getFieldCodes($companyId)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\ServiceField', 'sf');
        $rsm->addFieldResult('sf', 'fieldId', 'fieldId');
        $rsm->addFieldResult('sf', 'service', 'service');
        $rsm->addFieldResult('sf', 'fieldCode', 'fieldCode');
        $rsm->addFieldResult('sf', 'fieldName', 'fieldName');
        $rsm->addFieldResult('sf', 'fieldType', 'fieldType');
        $rsm->addFieldResult('sf', 'fieldValue', 'fieldValue');
        $rsm->addFieldResult('sf', 'ord', 'ord');
        $rsm->addFieldResult('sf', 'company', 'company');

        $sql = "SELECT sf.*
                FROM service_fields sf
                LEFT JOIN service_field_order sfo ON sf.fieldId = sfo.fieldId
                WHERE sf.service = :serviceId
                AND (sf.company = :companyId
                    OR sf.company IS NULL)
                AND sf.fieldId NOT IN (
	                SELECT sfd.fieldId
                    FROM service_fields_disabled sfd
                    WHERE sfd.companyId = :companyId
                )
                ORDER BY COALESCE(sfo.ord, 99999), sf.ord";

        $query = $this->doctrine->em->createNativeQuery($sql, $rsm);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('serviceId', $this->getServiceId());

        $serviceFields = $query->getResult();

        return $serviceFields;
    }

    /**
     * @return \models\Service_titles
     */
    function getCustomTitle($companyId)
    {
        $dql = "SELECT st
                FROM \models\Service_titles st
                WHERE st.service = :serviceId
                AND st.company = :companyId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('serviceId', $this->getServiceId());
        $query->setMaxResults(1);

        $serviceTitle = $query->getOneOrNullResult();

        return $serviceTitle;
    }

    function hasCustomTitle($companyId)
    {
        $dql = "SELECT COUNT(st.titleId)
                FROM \models\Service_titles st
                WHERE st.company = :companyId
                AND st.service = :serviceId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('serviceId', $this->getServiceId());

        $count = $query->getSingleScalarResult();

        if ($count > 0) {
            return true;
        }

        return false;
    }


    function migrateProposalServices($newServiceId, $companyId)
    {
        $dql = "SELECT ps
                FROM \models\Proposal_services ps, \models\Proposals p, \models\Clients c
                WHERE ps.proposal = p.proposalId
                AND p.client = c.clientId
                AND c.company = :companyId
                AND ps.initial_service = :serviceId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('serviceId', $this->getServiceId());
        $query->setParameter('companyId', $companyId);

        $ps = $query->getResult();

        $i = 0;
        foreach ($ps as $proposalService) {
            /* @var $proposalService \models\Proposal_services */
            $proposalService->setInitialService($newServiceId);
            $this->doctrine->em->persist($proposalService);
            $i++;
        }
        $this->doctrine->em->flush();

        return $i;
    }


    public function migrateOrder($newServiceId, $companyId)
    {

        $dql = "UPDATE \models\CompanyServiceOrder cso
                SET cso.serviceId = :newServiceId
                WHERE cso.companyId = :companyId
                AND cso.serviceId = :serviceId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('serviceId', $this->getServiceId());
        $query->setParameter('newServiceId', $newServiceId);

        $rows = $query->execute();

        return $rows;
    }

    public function migrateDisabled($newServiceId, $companyId)
    {
        $dql = "UPDATE \models\CompanyDisabledService cds
                SET cds.service = :newServiceId
                WHERE cds.company = :companyId
                AND cds.service = :serviceId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('serviceId', $this->getServiceId());
        $query->setParameter('newServiceId', $newServiceId);

        $rows = $query->getResult();

        return $rows;
    }

    /**
     * Check to see if this service has been used in a proposal
     * @return bool
     */
    public function hasUsages()
    {
        $qb = $this->doctrine->em->createQueryBuilder();

        // Select clients from this company that aren't deleted
        $qb->select('COUNT(ps.serviceId)')
            ->from('\models\Proposal_services', 'ps')
            ->where('ps.initial_service = :serviceId')
            ->setParameter('serviceId', $this->getServiceId());

        $usages = $qb->getQuery()->getSingleScalarResult();

        if ($usages > 0) {
            return true;
        }
        return false;
    }

}