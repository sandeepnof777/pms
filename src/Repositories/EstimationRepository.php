<?php
namespace Pms\Repositories;

use Carbon\Carbon;
use models\Accounts;
use models\Companies;
use models\CompanyEstimateServiceField;
use models\Estimate;
use models\EstimateLog;
use models\EstimateStatus;
use models\EstimationCategory;
use models\EstimationCompanyServiceType;
use models\EstimationItem;
use models\EstimationItemPriceChange;
use models\EstimationLineItem;
use models\EstimationPhase;
use models\EstimationPlant;
use models\EstimationSetting;
use models\EstimationTemplate;
use models\EstimationType;
use models\EstimationUnitType;
use models\Proposal_services;
use models\ProposalEstimate;
use models\ProposalPlant;
use models\Proposals;
use models\ServiceField;
use models\ServiceJobCost;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class EstimationRepository extends RepositoryAbstract
{
    use DBTrait;

    /**
     * @return array
     * Retrieves the admin list of sorted items
     */
    public function getSortedItems()
    {
        $out = [];

        // Get the sorted Types
        $sortedTypes = $this->getSortedTypes();

        // First level is categories - skip this
        foreach ($sortedTypes as $categoryId => $categoryTypes) {
            $out[$categoryId] = [];
            // Next level is the types
            foreach ($categoryTypes as $type) {
                $out[$categoryId][$type->getId()] = [];
                // Now we get the items
                $typeItems = $this->getAdminTypeItems($type);
                // Populate the array
                foreach ($typeItems as $item) {
                    $out[$categoryId][$type->getId()][] = $item;
                }
            }
        }

        return $out;
    }

    /**
     * @return array
     */
    public function getSortedTypes()
    {
        $out = [];
        $categories = $this->getAdminCategories();

        foreach ($categories as $category) {
            $out[$category->getId()] = [];
            $categoryTypes = $this->getAdminCategoryTypes($category);

            foreach ($categoryTypes as $categoryType) {
                $out[$category->getId()][] = $categoryType;
            }
        }

        return $out;
    }

    /**
     * @return array
     * @description Returns a collection of the admin categories
     */
    public function getAdminCategories()
    {
        $dql = "SELECT ec
        FROM \models\EstimationCategory ec
        WHERE ec.company_id IS NULL
        ORDER BY ec.ord ASC";

        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    /**
     * @param EstimationCategory $category
     * @return array
     * @description Returns a collection of types belonging to a category
     */
    public function getAdminCategoryTypes(EstimationCategory $category)
    {
        $dql = "SELECT et
        FROM \models\EstimationType et
        WHERE et.company_id IS NULL
        AND et.category_id = :catId
        AND et.deleted = 0
        ORDER BY et.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':catId', $category->getId());

        return $query->getResult();
    }

    /**
     * @param EstimationType $type
     * @return array
     * @description Returns a collection of items belonging to a type
     */
    public function getAdminTypeItems(EstimationType $type)
    {


        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\EstimationItem', 'ei');
        $rsm->addFieldResult('ei', 'id', 'id');
        $rsm->addFieldResult('ei', 'name', 'name');
        $rsm->addFieldResult('ei', 'company_id', 'company_id');

        $sql = "SELECT ei.id
        FROM estimation_items ei
        LEFT JOIN estimation_items_company_order eico
          ON ei.id = eico.item_id AND eico.company_id = " . 0 . "
        WHERE ei.company_id is null
        AND ei.type_id = " . $type->getId() . "
        AND ei.deleted = 0
        ORDER BY COALESCE (eico.ord, 99999)";

        $results = $this->getAllResults($sql);
        $out = [];

        foreach ($results as $result) {
            $item = $this->em->findEstimationItem($result->id);

            if ($item) {
                $out[] = $item;
            }
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @return array
     * Retrieves the company list of sorted items
     */
    public function getCompanyProposalSortedItems(Companies $company, $proposalId)
    {
        $out = [];

        // Get the sorted Types
        $sortedTypes = $this->getCompanySortedTypes($company);

        // First level is categories - skip this
        foreach ($sortedTypes as $categoryId => $categoryTypes) {
            $out[$categoryId] = [];
            // Next level is the types
            foreach ($categoryTypes as $type) {
                $out[$categoryId][$type->getId()] = [];
                // Now we get the items
                $typeItems = $this->getCompanyTypeProposalItems($company, $type, $proposalId);
                // Populate the array
                foreach ($typeItems as $item) {
                    $out[$categoryId][$type->getId()][] = $item;
                }
            }
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getCompanySortedTypes(Companies $company)
    {
        $out = [];
        $categories = $this->getCompanyCategories($company);

        foreach ($categories as $category) {
            $out[$category->getId()] = [];
            $categoryTypes = $this->getCompanyCategoryTypes($company, $category);

            foreach ($categoryTypes as $categoryType) {
                $out[$category->getId()][] = $categoryType;
            }
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @return array
     * @description Returns a collection of this company's categories
     */
    public function getCompanyCategories(Companies $company)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\EstimationCategory', 'ec');
        $rsm->addFieldResult('ec', 'id', 'id');
        $rsm->addFieldResult('ec', 'name', 'name');
        $rsm->addFieldResult('ec', 'company_id', 'company_id');

        $dql = "SELECT ec.*
        FROM estimation_categories ec
        LEFT JOIN estimation_categories_company_order ecco
          ON ec.id = ecco.category_id AND ecco.company_id = :companyId
        WHERE (ec.company_id = :companyId
          OR ec.company_id IS NULL)
        AND ec.deleted = 0
        ORDER BY COALESCE (ecco.ord, 99999), ec.ord ASC";

        $query = $this->em->createNativeQuery($dql, $rsm);
        $query->setParameter(':companyId', $company->getCompanyId());

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @param EstimationCategory $category
     * @return array
     * @description Returns a collection of types belonging to a category for a company
     */
    public function getCompanyCategoryTypes(Companies $company, EstimationCategory $category)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\EstimationType', 'et');
        $rsm->addFieldResult('et', 'id', 'id');
        $rsm->addFieldResult('et', 'name', 'name');
        $rsm->addFieldResult('et', 'company_id', 'company_id');

        $dql = "SELECT et.*
        FROM estimation_types et
        LEFT JOIN estimation_types_company_order etco
          ON et.id = etco.type_id AND etco.company_id = :companyId
        WHERE
          (et.company_id = :companyId OR
          et.company_id IS NULL)
        AND et.category_id = :catId
        AND et.deleted = 0
        ORDER BY COALESCE (etco.ord, 99999), et.ord ASC";

        $query = $this->em->createNativeQuery($dql, $rsm);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':catId', $category->getId());

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @param EstimationType $type
     * @return array
     * @description Returns a collection of items belonging to a type for a company
     */
    public function getCompanyTypeProposalItems(Companies $company, EstimationType $type, $proposalId)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\EstimationItem', 'ei');
        $rsm->addFieldResult('ei', 'id', 'id');
        $rsm->addFieldResult('ei', 'name', 'name');
        $rsm->addFieldResult('ei', 'company_id', 'company_id');

        $sql = "SELECT ei.id,ei.deleted
        FROM estimation_items ei
        LEFT JOIN estimation_items_company_order eico
          ON ei.id = eico.item_id AND eico.company_id = " . $company->getCompanyId() . "
        WHERE ei.company_id = " . $company->getCompanyId() . "
        AND ei.type_id = " . $type->getId() . "

        ORDER BY COALESCE (eico.ord, 99999)";

        $results = $this->getAllResults($sql);
        $out = [];

        foreach ($results as $result) {
            $item = $this->em->findEstimationItem($result->id);

            if ($result->deleted == 0) {
                if ($item) {

                    $out[] = $item;
                }
            } else {
                $item_id = $result->id;
                $item_count = $this->em->createQuery("SELECT count(eli.id) as item_count FROM \models\EstimationLineItem eli WHERE eli.item_id= $item_id AND eli.proposal_id =$proposalId")->getSingleScalarResult();
                if ($item_count > 0) {
                    if ($item) {

                        $out[] = $item;
                    }
                }
            }

        }

        return $out;
    }

    /**
     * @return array
     */
    public function getAdminTypes()
    {
        $dql = "SELECT et
        FROM \models\EstimationType et
        WHERE et.company_id IS NULL
        ORDER BY et.ord ASC";

        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getCompanyTypes(Companies $company)
    {
        $dql = "SELECT et
        FROM \models\EstimationType et
        WHERE (et.company_id IS NULL
          OR et.company_id = :companyId)
        ORDER BY et.name ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        return $query->getResult();
    }

    /**
     * @return array
     */
    public function getSortedUnits()
    {
        $out = [];
        $unitTypes = $this->getUnitTypes();

        foreach ($unitTypes as $unitType) {
            $out[$unitType->getId()] = [];
            $out[$unitType->getId()]['unitType'] = $unitType;
            $out[$unitType->getId()]['units'] = $this->getTypeUnits($unitType);
        }

        return $out;
    }

    /**
     * @return array
     */
    public function getUnitTypes()
    {
        $dql = "SELECT eut
        FROM \models\EstimationUnitType eut
        ORDER BY eut.ord ASC";

        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    /**
     * @param EstimationUnitType $type
     * @return array
     */
    public function getTypeUnits(EstimationUnitType $type)
    {
        $dql = "SELECT eu
        FROM \models\EstimationUnit eu
        WHERE eu.company_id IS NULL
        AND eu.unit_type = :typeId
        ORDER BY eu.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':typeId', $type->getId());

        return $query->getResult();
    }

    /**
     * @return array
     */
    public function defaultSearchItems()
    {
        $dql = "SELECT ei
        FROM \models\EstimationItem ei
        WHERE ei.company_id IS NULL
        AND ei.deleted = 0
        ORDER BY ei.ord ASC";

        $query = $this->em->createQuery($dql);

        $results = $query->getResult();

        $out = [];

        foreach ($results as $item) {
            $result = [
                'id' => $item->getId(),
                'value' => $item->getId(),
                'label' => $item->getName(),
                'type_id' => $item->getTypeId(),
                'category_id' => $item->getType()->getcategoryId()
            ];
            $out[] = $result;
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function companySearchItems(Companies $company)
    {
        $dql = "SELECT ei
        FROM \models\EstimationItem ei
        WHERE ei.company_id = :companyId
        AND ei.deleted = 0
        ORDER BY ei.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $results = $query->getResult();

        $out = [];

        foreach ($results as $item) {
            $result = [
                'id' => $item->getId(),
                'value' => $item->getId(),
                'label' => $item->getName(),
                'type_id' => $item->getTypeId(),
                'category_id' => $item->getType()->getcategoryId()
            ];
            $out[] = $result;
        }

        return $out;
    }

    /**
     * @param Companies $company
     * Clears company category order records
     */
    public function clearCompanyCategoryOrder(Companies $company)
    {
        $dql = "DELETE \models\EstimatingCategoryOrder eco
        WHERE eco.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->execute();
    }

    /**
     * @param Companies $company
     * @param array $typeIds
     * Clears company type order records
     */
    public function clearTypeOrders(Companies $company, array $typeIds)
    {

        $dql = "DELETE \models\EstimationTypeOrder eto
        WHERE eto.company_id = :companyId
        AND eto.type_id IN (:typeIds)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':typeIds', $typeIds);
        $query->execute();
    }

    /**
     * @param Companies $company
     * @param array $itemIds
     * Clears company item order records
     */
    public function clearItemOrders(Companies $company, array $itemIds)
    {

        $dql = "DELETE \models\EstimationItemOrder eio
        WHERE eio.company_id = :companyId
        AND eio.item_id IN (:typeIds)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':typeIds', $itemIds);
        $query->execute();
    }

    /**
     * @param array $itemIds
     * Clears Admin item order records
     */
    public function clearAdminItemOrders(array $itemIds)
    {

        $dql = "DELETE \models\EstimationItemOrder eio
        WHERE eio.company_id = :companyId
        AND eio.item_id IN (:typeIds)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', 0);
        $query->setParameter(':typeIds', $itemIds);
        $query->execute();
    }

    /**
     * @param $uuid
     * @return array
     */
    public function getLineItemsByUuid($uuid)
    {
        $sql = "SELECT eli.*, ec.name AS categoryName, et.name AS typeName, ei.name AS itemName
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        WHERE eli.uuid = '" . $uuid . "'";

        // Sorting
        $order = $this->ci->input->get('order');
        $sort = $order[0]['column'];
        $sortDir = $order[0]['dir'];
        $sortCol = '';

        switch ($sort) {
            case 0:
                $sortCol = ' ec.name';
                break;

            case 1:
                $sortCol = ' et.name';
                break;

            case 2:
                $sortCol = ' ei.name';
                break;

            case 3:
                $sortCol = ' eli.quantity';
                break;

            case 4:
                $sortCol = ' eli.unit_price';
                break;

            case 5:
                $sortCol = ' eli.total_price';
                break;
        }

        $sql .= " ORDER BY " . $sortCol . " " . $sortDir;

        return $this->getAllResults($sql);
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getLineItemsByPsId($proposalServiceId)
    {
        $sql = "SELECT eli.*, ec.name AS categoryName, et.name AS typeName, ei.name AS itemName
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        WHERE eli.proposal_service_id = '" . $proposalServiceId . "'";

        return $this->getAllResults($sql);
    }

    /**
     * @param $uuid
     * @param $proposalServiceId
     */
    public function uuidToProposalService($uuid, $proposalServiceId)
    {
        $dql = "UPDATE \models\EstimationLineItem eli
        SET eli.proposal_service_id = :proposalServiceId
        WHERE eli.uuid = :uuid";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        $query->setParameter(':uuid', $uuid);
        $query->execute();
    }

    /**
     * @param Companies $company
     * @param $typeId
     */
    public function clearCompanyServiceTypeAssignments(Companies $company, $typeId)
    {
        $dql = "DELETE \models\EstimationCompanyServiceType ecst
        WHERE ecst.company_id = :companyId
        AND ecst.estimate_type_id = :typeId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':typeId', $typeId);
        $query->execute();
    }

    /**
     * @param $typeId
     */
    public function clearAdminCompanyServiceTypeAssignments($typeId)
    {
        $dql = "DELETE \models\EstimationCompanyServiceType ecst
        WHERE ecst.company_id = :companyId
        AND ecst.estimate_type_id = :typeId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', 0);
        $query->setParameter(':typeId', $typeId);
        $query->execute();
    }

    /**
     * @param Companies $company
     * @param $typeId
     */
    public function clearCompanyTemplateItemAssignments($itemId)
    {
        $dql = "DELETE \models\EstimateTemplateItem eti
        WHERE eti.item_id = :itemId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':itemId', $itemId);
        $query->execute();
    }

    /**
     * @param Companies $company
     * @param $templateId
     */
    public function clearCompanyTemplateServiceAssignments($templateId)
    {
        $dql = "DELETE \models\EstimationServiceTemplate est
        WHERE est.template_id = :templateId";
        $query = $this->em->createQuery($dql);
        $query->setParameter(':templateId', $templateId);
        $query->execute();
    }

    /**
     * @param Companies $company
     * @param $templateId
     */
    public function clearCompanyPlantBranchAssignments($plantId)
    {
        $dql = "DELETE \models\EstimationBranchPlant est
        WHERE est.plant_id = :plantId";
        $query = $this->em->createQuery($dql);
        $query->setParameter(':plantId', $plantId);
        $query->execute();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getAllCompanyServiceTemplateAssignments(Companies $company)
    {
        $out = [];
        $services = $company->getCategories();

        foreach ($services as $service) {
            $out[$service->getServiceId()] = $this->getCompanyServiceTemplateAssignmentsByService($company, $service->getServiceId());
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @param $serviceId
     * @return array
     */
    public function getCompanyServiceTemplateAssignmentsByService(Companies $company, $serviceId)
    {
        $dql = "SELECT est
        FROM \models\EstimationServiceTemplate est
        WHERE est.company_id = :companyId
        AND est.service_id = :serviceId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':serviceId', $serviceId);

        $types = [];

        $results = $query->getResult();

        foreach ($results as $result) {
            $types[] = $result->getTemplateId();
        }

        return $types;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getAllCompanyServiceTypeAssignments(Companies $company)
    {
        $out = [];
        $services = $company->getCategories();

        foreach ($services as $service) {
            $out[$service->getServiceId()] = $this->getCompanyServiceTypeAssignmentsByService($company, $service->getServiceId());
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @param $serviceId
     * @return array
     */
    public function getCompanyServiceTypeAssignmentsByService(Companies $company, $serviceId)
    {

        $defaults_types = $this->getCompanySortedTypes($company);
        
        $types11 = [];
        $return_types = [];
       
        foreach($defaults_types as $x => $defaults_type){
           
            foreach($defaults_type as $type22){
                $types11[$x][] = $type22->getId();
            }
           
        }

        foreach($types11 as $catId => $type44){
            
            $c_id =$company->getCompanyId();
            $sql = "select ecst.id,ecst.company_id,ecst.service_id,ecst.estimate_type_id
            from estimate_company_service_types ecst 
            left join estimation_types et on ecst.estimate_type_id = et.id 
            WHERE ecst.company_id = '$c_id'
            AND ecst.service_id = '$serviceId' AND et.category_id = '$catId'";

            $results = $this->getAllResults($sql);

            if ($results) {
                foreach ($results as $result) {
                    //print_r($result->id);die;
                    
                    $return_types[] = (int) $result->estimate_type_id;
                }
            } else {

                $return_types =  array_merge($return_types,$type44);

            }
            
        }
        

        $return_types = array_unique($return_types, SORT_REGULAR);
        $return_types = array_values($return_types);
        return $return_types;
        
    }

    /**
     * @param Companies $company
     * @param $typeId
     * @return array
     */
    public function getCompanyServiceTypeAssignments(Companies $company, $typeId)
    {
        $dql = "SELECT ecst
        FROM \models\EstimationCompanyServiceType ecst
        WHERE ecst.company_id = :companyId
        AND ecst.estimate_type_id = :typeId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':typeId', $typeId);

        $services = [];

        $results = $query->getResult();
        if ($results) {
            foreach ($results as $result) {
                $services[] = $result->getServiceId();
            }
        } else {

            $dql = "SELECT ecst
            FROM \models\EstimationCompanyServiceType ecst
            WHERE ecst.company_id = :companyId
            AND ecst.estimate_type_id = :typeId";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':companyId', 0);
            $query->setParameter(':typeId', $typeId);

            $services = [];

            $results = $query->getResult();
            foreach ($results as $result) {
                $services[] = $result->getServiceId();
            }

        }


        return $services;
    }

    /**
     * @param $typeId
     * @return array
     */
    public function getAdminCompanyServiceTypeAssignments($typeId)
    {
        $dql = "SELECT ecst
        FROM \models\EstimationCompanyServiceType ecst
        WHERE ecst.company_id = :companyId
        AND ecst.estimate_type_id = :typeId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', 0);
        $query->setParameter(':typeId', $typeId);

        $services = [];

        $results = $query->getResult();

        foreach ($results as $result) {
            $services[] = $result->getServiceId();
        }

        return $services;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getPopulatedTemplates(Companies $company, $proposalId)
    {


        $out = [];
        $templates = $this->getCompanyEstimateTemplates($company, $proposalId);

        foreach ($templates as $template) {
            
            $out[$template->getId()] = [
                'template' => $template,
                'items' => $this->getTemplateItems($template, $proposalId)

            ];
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getCompanyEstimateTemplates(Companies $company, $proposalId)
    {
        $dql = "SELECT et
        FROM \models\EstimationTemplate et
        WHERE et.company_id = :companyId
        ORDER BY et.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        $templates = $query->getResult();
        $data = [];
        foreach ($templates as $template) {
            if ($template->getDeleted() == 0) {
                $data[] = $template;
            } else {
                $template_id = $template->getid();
                $item_count = $this->em->createQuery("SELECT count(eli.id) as item_count FROM \models\EstimationLineItem eli WHERE eli.template_id= $template_id AND eli.proposal_id =$proposalId")->getSingleScalarResult();
                if ($item_count > 0) {
                    $data[] = $template;
                }
            }
        }

        return $data;
    }

    /**
     * @param EstimationTemplate $template
     * @return array
     */
    public function getTemplateItems(EstimationTemplate $template, $proposalId)
    {
        $sql = "SELECT eti.item_id,eti.deleted,eti.id,eti.default_days,eti.default_qty,eti.default_hpd, ec.name,eu.single_name
        FROM estimate_template_items eti
        LEFT JOIN estimation_items ei ON eti.item_id = ei.id
        LEFT JOIN estimation_units eu ON ei.unit = eu.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        WHERE eti.template_id = " . $template->getId() . "
        ORDER BY eti.ord ASC";

        $results = $this->getAllResults($sql);

        $out = [];

       // if(count($results)>0){
        foreach ($results as $result) {
            if ($result->deleted == 0) {
                $item = $this->em->findEstimationItem($result->item_id);
            } else {
                $template_id = $template->getId();
                $item_count = $this->em->createQuery("SELECT count(eli.id) as item_count FROM \models\EstimationLineItem eli WHERE eli.template_id= $template_id AND eli.item_id =$result->item_id AND eli.proposal_id =$proposalId")->getSingleScalarResult();
                if ($item_count > 0) {
                    $item = $this->em->findEstimationItem($result->item_id);
                } else {
                    $item = NULL;
                }
            }

            $templateId = $template->getId();

            $defaults = array(
                'default_days' => ($result->default_days) ? $result->default_days : '-',
                'default_qty' => ($result->default_qty) ? $result->default_qty : '-',
                'default_hpd' => ($result->default_hpd) ? $result->default_hpd : '-',

            );

            if ($item) {

                $item->categoryName = $result->name;
                $item->$templateId = $defaults;
                $item->single_name = $result->single_name;
                $out[] = $item;

            }
        }
    // }else{
    //     $item = $this->em->findEstimationItem(0);
    //     $templateId = $template->getId();

    //         $defaults = array(
    //             'default_days' => '-',
    //             'default_qty' => '-',
    //             'default_hpd' => '-',

    //         );
    //         $item->categoryName = 'Custom';
    //             $item->$templateId = $defaults;
    //             $item->single_name ='';
    //             $out[] = $item;
    //     $out[] = $item;
    // }

        return $out;
    }
    public function getJobCostImageCount($proposal_id){
        $sql = "SELECT count(jcif.id) as total FROM job_cost_item as jci 
                LEFT JOIN job_cost_item_files as jcif 
                ON jci.id = jcif.job_cost_item_id where jci.proposal_id ='$proposal_id'";

        $result = $this->getSingleResult($sql);

        return $result->total;
        
    }
    
    public function getJobCostAttachments($proposal_id)
    {
        $dql = "SELECT jca
        FROM \models\JobCostAttachment jca
        WHERE jca.proposal_id = :proposal_id ";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposal_id);

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getCompanyTemplates(Companies $company)
    {
        $dql = "SELECT et
        FROM \models\EstimationTemplate et
        WHERE et.company_id = :companyId AND et.deleted=0
        ORDER BY et.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        return $query->getResult();
    }

    /**
     * Returns a count of line items belonging to a proposal service
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServiceLineItemsCount($proposalServiceId)
    {
        $sql = "SELECT COUNT(eli.id) AS numLineItems
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = '$proposalServiceId' AND eli.fixed_template !=1";

        $result = $this->getSingleResult($sql);

        return $result->numLineItems;
    }

    public function getProposalServiceJobCostingItemsCount($proposalServiceId)
    {
        $sql = "SELECT COUNT(jci.id) AS numLineItems
        FROM job_cost_item jci  JOIN estimate_line_items eli ON jci.estimate_line_item_id = eli.id
        WHERE jci.estimate_line_item_id != 0 AND jci.proposal_service_id = '$proposalServiceId'";

        $result = $this->getSingleResult($sql);

        return $result->numLineItems;
    }

    public function getProposalServiceJobCostingCustomItemsCount($proposalServiceId)
    {
        $sql = "SELECT COUNT(jci.id) AS numLineItems
        FROM job_cost_item jci
        WHERE estimate_line_item_id = 0 AND jci.proposal_service_id = '$proposalServiceId'";

        $result = $this->getSingleResult($sql);

        return $result->numLineItems;
    }
    /**
     * @param $phaseId
     * @return mixed
     */
    public function getProposalServiceLineItemsCountByPhaseId($phaseId)
    {
        $sql = "SELECT COUNT(eli.id) AS numLineItems
        FROM estimate_line_items eli
        WHERE eli.phase_id = '$phaseId'
        AND eli.parent_line_item_id IS NULL";

        $result = $this->getSingleResult($sql);

        return $result->numLineItems;
    }

    /**
     * Returns an array with details of all line item models belonging to a proposal service
     * @param $proposalServiceId
     * @param $custom
     * @return array
     */
    public function getProposalServiceLineItemArray($proposalServiceId, $custom = false)
    {
        $out = [];

        $lineItems = $this->getProposalServiceLineItems($proposalServiceId, $custom);

        if ($lineItems) {
            foreach ($lineItems as $lineItem) {
                /*  var \models\EstimationLineItem $lineItem */

                $out[] = [
                    'id' => $lineItem->getId(),
                    'item_id' => $lineItem->getItemId(),
                    'unit_price' => $lineItem->getUnitPrice(),
                    'quantity' => $lineItem->getQuantity(),
                    'total_price' => $lineItem->getTotalPrice(),
                    'custom_price' => $lineItem->getCustomUnitPrice(),
                    'base_price' => $lineItem->getBasePrice(),
                    'overhead_rate' => $lineItem->getOverheadRate(),
                    'overhead_price' => $lineItem->getOverheadPrice(),
                    'profit_rate' => $lineItem->getOverheadRate(),
                    'profit_price' => $lineItem->getOverheadPrice(),
                    'tax_rate' => $lineItem->getTaxRate(),
                    'tax_price' => $lineItem->getTaxPrice(),
                    'trucking_overhead_rate' => $lineItem->getTruckingOverheadRate(),
                    'trucking_overhead_price' => $lineItem->getTruckingOverheadPrice(),
                    'trucking_price' => $lineItem->getTruckingTotalPrice(),
                    'name' => $lineItem->getCustomName(),
                    'notes' => $lineItem->getNotes()
                ];
            }
        }

        return $out;
    }

    /**
     * Returns all line item models belonging to a proposal service
     * Excludes custom items
     * @param $proposalServiceId
     * @param $custom
     * @return array
     */
    public function getProposalServiceLineItems($proposalServiceId, $custom = false)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :psId";

        if (!$custom) {
            $dql .= " AND eli.item_id != 0";
        } else {
            $dql .= " AND eli.item_id = 0";
        }

        $query = $this->em->createQuery($dql);
        $query->setParameter(':psId', $proposalServiceId);

        return $query->getResult();
    }

    /**
     * Returns an array with details of all line item models belonging to a phase
     * @param $phaseId
     * @param $proposalServiceId
     * @param bool $custom
     * @param bool $fees
     * @param bool $permit
     * @return array
     */
    public function getPhaseLineItemArray($phaseId, $proposalServiceId, $custom = false, $fees = false, $permit = false)
    {
        $out = [];
        $lineItems = $this->getPhaseLineItemsByProposalServiceId($phaseId, $proposalServiceId, $custom, $fees, $permit);
        if ($lineItems) {
            foreach ($lineItems as $lineItem) {
                /*  var \models\EstimationLineItem $lineItem */
                $est_line_id = $lineItem->getId();

                $lineChildItems = $this->getChildLineItems($est_line_id);
                $is_custom_child = 0;
                $is_equipment_child = 0;
                $is_trucking_child = 0;
                $is_labor_child = 0;
                $is_fees_child = 0;
                $is_permit_child = 0;
                $is_child_has_updated_flag = 0;
                foreach ($lineChildItems as $linechildItem) {

                    if ($linechildItem->getItemId() == 0) {
                        if ($linechildItem->getFees() == 1) {
                            $is_fees_child = 1;
                        } else if ($linechildItem->getPermit() == 1) {
                            $is_permit_child = 1;
                        } else {
                            $is_custom_child = 1;
                        }
                    } else if ($linechildItem->getItem()->getType()->getCategoryId() == 2 || $linechildItem->getChildMaterial() == 1) {
                        $is_equipment_child = 1;
                    } else if ($linechildItem->getItem()->getTypeId() == 20) {
                        $is_trucking_child = 1;
                    } else {
                        $is_labor_child = 1;
                    }
                    if ($linechildItem->getParentUpdated() == 1) {
                        $is_child_has_updated_flag = 1;
                    }
                }
                if ($lineItem->getTemplateId()) {
                    $template = $this->get_template_name($lineItem->getTemplateId());
                    $template_name = $template[0]->getName();
                } else {
                    $template_name = 'null';
                }
                $savedValues = $this->getEstimateCalculatorValue($lineItem->getId());
                if ($savedValues) {
                    if ($savedValues[0]['calculator_name'] == 'time_type_form' && $savedValues[0]['saved_values'] != '') {
                        $saved_calculator_values = $savedValues[0]['saved_values'];
                    } else {
                        $saved_calculator_values = NULL;
                    }
                } else {
                    $saved_calculator_values = NULL;
                }

                $note_count = $this->em->createQuery("SELECT count(n) as note_count FROM models\Notes n WHERE n.type='estimate_line_item' AND n.relationId= $est_line_id ")->getSingleScalarResult();
                // var_dump($notes);die;
                $out[] = [
                    'id' => $lineItem->getId(),
                    'item_id' => $lineItem->getItemId(),
                    'unit_price' => $lineItem->getUnitPrice(),
                    'quantity' => $lineItem->getQuantity(),
                    'parent_total_price' => $lineItem->getTotalPrice(),
                    'total_price' => $this->getLineItemTotalPrice($lineItem->getId()),
                    'custom_price' => $lineItem->getCustomUnitPrice(),
                    'base_price' => $lineItem->getBasePrice(),
                    'overhead_rate' => $lineItem->getOverheadRate(),
                    'overhead_price' => $lineItem->getOverheadPrice(),
                    'profit_rate' => $lineItem->getOverheadRate(),
                    'profit_price' => $lineItem->getOverheadPrice(),
                    'template_id' => $lineItem->getTemplateId(),
                    'notes' => $lineItem->getNotes(),
                    'days' => $lineItem->getDay(),
                    'num_people' => $lineItem->getNumPeople(),
                    'hours_per_day' => $lineItem->getHoursPerDay(),

                    'template_name' => $template_name,
                    'tax_rate' => $lineItem->getTaxRate(),
                    'tax_price' => $lineItem->getTaxPrice(),
                    'trucking_overhead_rate' => $lineItem->getTruckingOverheadRate(),
                    'trucking_overhead_price' => $lineItem->getTruckingOverheadPrice(),
                    'trucking_price' => $lineItem->getTruckingTotalPrice(),
                    'name' => $lineItem->getCustomName(),
                    'notes_count' => $note_count,
                    'child_count' => count($lineChildItems),
                    'child_material' => $lineItem->getChildMaterial(),
                    'is_equipment_child' => $is_equipment_child,
                    'is_custom_child' => $is_custom_child,
                    'is_trucking_child' => $is_trucking_child,
                    'is_labor_child' => $is_labor_child,
                    'is_fees_child' => $is_fees_child,
                    'is_permit_child' => $is_permit_child,
                    'is_child_has_updated_flag' => $is_child_has_updated_flag,
                    'calculator_value' => $saved_calculator_values,
                    'custom_total_price' => $lineItem->getCustomTotalPrice(),
                    'custom_unit_price' => $lineItem->getCustomUnitPrice(),
                    'edited_base_price' => $lineItem->getEditedBasePrice(),
                    'edited_unit_price' => $lineItem->getEditedUnitPrice(),
                    'edited_total_price' => $lineItem->getEditedTotalPrice(),
                ];
            }
        }
        return $out;
    }

    /**
     * Returns all line item models belonging to a phase
     * Excludes custom items
     * @param $phaseId
     * @param $proposal_Id
     * @param $custom
     * @return array
     */
    public function getPhaseLineItemsByProposalServiceId($phaseId, $proposalServiceId, $custom = false, $fees = false, $permit = false)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.proposal_service_id = :proposalServiceId
        AND eli.parent_line_item_id IS NULL";
        if ($fees) {
            $dql .= " AND eli.item_id = 0 AND eli.sub_id =0 AND eli.fees = 1 ";
        } else if ($permit) {
            $dql .= " AND eli.item_id = 0 AND eli.sub_id =0  AND eli.permit = 1";
        } else if (!$custom) {
            $dql .= " AND eli.item_id != 0 ";
        } else {
            $dql .= " AND eli.item_id = 0 AND eli.sub_id =0 AND eli.is_custom_sub =0 AND eli.fees = 0 AND eli.permit = 0 AND  eli.fixed_template !=1";
        }
        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        return $query->getResult();
    }

    /**
     * @param $lineItemId
     * @return array
     * @description Returns the estimate line items with the specified id as a parent id
     */
    public function getChildLineItems($lineItemId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.parent_line_item_id = :parentId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parentId', $lineItemId);

        return $query->getResult();
    }

    public function get_template_name($template_id)
    {
        $dql = "SELECT et
        FROM \models\EstimationTemplate et
        WHERE et.id = :id
        ORDER BY et.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':id', $template_id);

        return $query->getResult();
    }

    public function getEstimateCalculatorValue($estimateLineId)
    {

        $dql = "SELECT eli.saved_values,eli.id,eli.calculator_name
        FROM \models\EstimationCalculatorValue eli
        WHERE eli.line_item_id = :estimateLineId ";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':estimateLineId', $estimateLineId);
        return $query->getResult();
    }

    /**
     * @param $lineItemId
     * @return mixed
     */
    public function getLineItemTotalPrice($lineItemId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.id = '$lineItemId'
        OR eli.parent_line_item_id = '$lineItemId'";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    public function getParentChildLineItems($lineItemId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.parent_line_item_id = :parentId OR eli.id = :parentId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parentId', $lineItemId);

        return $query->getResult();
    }

    /**
     * Returns an array with details of all line item models belonging to a phase
     * @param $phaseId
     * @param $custom
     * @return array
     */
    public function getPhaseSubContractorLineItemArray($phaseId, $proposalServiceId, $custom = false)
    {
        $out = [];
        $lineItems = $this->getPhaseSubContractorLineItemsByProposalServiceId($phaseId, $proposalServiceId, $custom);
        if ($lineItems) {
            foreach ($lineItems as $lineItem) {
                /*  var \models\EstimationLineItem $lineItem */
                $est_line_id = $lineItem->getId();


                $linechildItems = $this->getChildLineItems($est_line_id);
                $is_custom_child = 0;
                $is_equipment_child = 0;
                $is_trucking_child = 0;
                $is_labor_child = 0;
                foreach ($linechildItems as $linechildItem) {
                    if ($linechildItem->getItemId() == 0) {
                        $is_custom_child = 1;
                    } else if ($linechildItem->getItem()->getType()->getCategoryId() == 2 || $linechildItem->getChildMaterial() == 1) {
                        $is_equipment_child = 1;
                    } else if ($linechildItem->getItem()->getTypeId() == 20) {
                        $is_trucking_child = 1;
                    } else {
                        $is_labor_child = 1;
                    }
                }
                $note_count = $this->em->createQuery("SELECT count(n) as note_count FROM models\Notes n WHERE n.type='estimate_line_item' AND n.relationId= $est_line_id ")->getSingleScalarResult();
                // var_dump($notes);die;
                $out[] = [
                    'id' => $lineItem->getId(),
                    'item_id' => $lineItem->getItemId(),
                    'unit_price' => $lineItem->getUnitPrice(),
                    'quantity' => $lineItem->getQuantity(),
                    'total_price' => $this->getLineItemTotalPrice($lineItem->getId()),
                    'custom_price' => $lineItem->getCustomUnitPrice(),
                    'base_price' => $lineItem->getBasePrice(),
                    'overhead_rate' => $lineItem->getOverheadRate(),
                    'overhead_price' => $lineItem->getOverheadPrice(),
                    'profit_rate' => $lineItem->getOverheadRate(),
                    'profit_price' => $lineItem->getOverheadPrice(),
                    'tax_rate' => $lineItem->getTaxRate(),
                    'tax_price' => $lineItem->getTaxPrice(),
                    'trucking_overhead_rate' => $lineItem->getTruckingOverheadRate(),
                    'trucking_overhead_price' => $lineItem->getTruckingOverheadPrice(),
                    'trucking_price' => $lineItem->getTruckingTotalPrice(),
                    'name' => $lineItem->getCustomName(),
                    'sub_contractor_name' => ($lineItem->getSubContractor()) ? $lineItem->getSubContractor()->getCompanyName() : $lineItem->getCustomName(),
                    'sub_id' => $lineItem->getSubId(),
                    'notes_count' => $note_count,
                    'notes' => $lineItem->getNotes(),
                    'child_count' => 0,
                    'child_material' => $lineItem->getChildMaterial(),
                    'is_equipment_child' => $is_equipment_child,
                    'is_custom_child' => $is_custom_child,
                    'is_trucking_child' => $is_trucking_child,
                    'is_labor_child' => $is_labor_child,
                ];
            }
        }
        return $out;
    }

    /**
     * Returns all line item models belonging to a phase
     * Excludes custom items
     * @param $phaseId
     * @param $proposal_Id
     * @param $custom
     * @return array
     */
    public function getPhaseSubContractorLineItemsByProposalServiceId($phaseId, $proposalServiceId, $custom = false)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.proposal_service_id = :proposalServiceId
        AND eli.parent_line_item_id IS NULL";

        $dql .= " AND eli.item_id = 0 AND (eli.sub_id >0 OR eli.is_custom_sub >0)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @param $proposalId
     * @return array
     */
    public function getProposalSortedLineItems(Companies $company, $proposalId)
    {
        $allLineItems = $this->getAllProposalLineItems($proposalId);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {
                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => []
                ];
            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getAllProposalLineItems($proposalId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        ORDER BY eli.item_id ";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposalId);

        return $query->getResult();
    }

        /**
     * @param $phaseId
     * @return array
     */
    public function getAllProposalLineItemsWithoutFixedTemplate($proposalId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND eli.fixed_template=0
        ORDER BY eli.item_id ";
        

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposalId);
        return $query->getResult();
    }
    /**
     * @param Companies $company
     * @param $proposalId
     * @return array
     */
    public function getProposalSortedLineItemsTotal(Companies $company, $proposalId)
    {
        $allLineItems = $this->getAllProposalLineItemsWithoutFixedTemplate($proposalId);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }

            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                continue;
               
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }
            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {
                $aggBaseCost = $this->getProposalCategoryBaseCost($proposalId, $category);
                $aggOverheadCost = $this->getProposalCategoryOverheadCost($proposalId, $category);
                $aggProfitCost = $this->getProposalCategoryProfitCost($proposalId, $category);
                $aggTotalCost = $this->getProposalCategoryTotalCost($proposalId, $category);
                $aggOverheadRate = (($aggOverheadCost != 0) && ($aggBaseCost != 0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggProfitCost != 0) && ($aggBaseCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;
                $aggTaxCost = $this->getProposalServiceCategoryTaxCost($proposalId, $category);
                $aggTaxRate = (($aggTaxCost > 0) && ($aggBaseCost > 0)) ? number_format(($aggTaxCost / $aggBaseCost) * 100, 2) : 0;

                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'aggregateTaxPrice' => $aggTaxCost,
                    'aggregateTaxRate' => $aggTaxRate,
                    'aggregateTotalRate' => $aggTotalCost,
                ];

            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    function getPlantDumpAddressById($plantId)
    {

        $sql = "SELECT ep.address,ep.city,ep.name,ep.company_name
        FROM estimation_plants ep

        WHERE ep.id =" . $plantId;

        $result = $this->getSingleResult($sql);
        return '<br>' . $result->company_name . ' | ' . $result->name . '<br>' . $result->address . ' ' . $result->city;
    }

    /**
     * @param $proposalId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalCategoryBaseCost($proposalId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_base_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_id = " . (int)$proposalId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }
        else if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_base_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_id = " . (int)$proposalId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $proposalId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalCategoryOverheadCost($proposalId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_oh_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_id = " . (int)$proposalId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }
        else if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_oh_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_id = " . (int)$proposalId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $proposalId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalCategoryProfitCost($proposalId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_pm_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_id = " . (int)$proposalId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }
        else if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_pm_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_id = " . (int)$proposalId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $proposalId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalCategoryTotalCost($proposalId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_id = " . (int)$proposalId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_id = " . (int)$proposalId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }
    /**
     * @param $proposalServiceId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalServiceCategoryTotalCost($proposalServiceId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_service_id = " . (int)$proposalServiceId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_service_id = " . (int)$proposalServiceId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $proposalServiceId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalServiceCategoryTotalTaxCost($proposalServiceId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalServiceId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalServiceCategoryTaxCost($proposalId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND ei.type_id !=20
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param Companies $company
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServiceSortedLineItems(Companies $company, $proposalServiceId)
    {
        $allLineItems = $this->getAllProposalServiceLineItemsWithoutTemplates($proposalServiceId);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();


            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                continue;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getProposalServiceCategoryBaseCost($proposalServiceId, $category);
                $aggOverheadCost = $this->getProposalServiceCategoryOverheadCost($proposalServiceId, $category);
                $aggProfitCost = $this->getProposalServiceCategoryProfitCost($proposalServiceId, $category);
                $aggTotalCost = $this->getProposalServiceCategoryTotalCost($proposalServiceId, $category);

                $aggTaxCost = $this->getProposalServiceCategoryTotalTaxCost($proposalServiceId, $category);
                $aggTaxRate = (($aggTaxCost > 0) && ($aggBaseCost > 0)) ? number_format(($aggTaxCost / $aggBaseCost) * 100, 2) : 0;



                $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;

                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'aggregateTaxPrice' => $aggTaxCost,
                    'aggregateTaxRate' => $aggTaxRate,
                    'aggregateTotalRate' => $aggTotalCost,

                ];

            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getAllProposalServiceLineItems($proposalServiceId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :proposalServiceId
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
         AND eli.fixed_template !=1 ";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);

        return $query->getResult();
    }
    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getAllProposalServiceLineItemsWithoutTemplates($proposalServiceId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :proposalServiceId
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND (eli.template_id=0 OR eli.template_id IS NULL) ";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);

        return $query->getResult();
    }
    
    /**
     * @param $proposalServiceId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalServiceCategoryBaseCost($proposalServiceId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_base_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_service_id = " . (int)$proposalServiceId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_base_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_service_id = " . (int)$proposalServiceId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $proposalServiceId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalServiceCategoryOverheadCost($proposalServiceId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_oh_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_service_id = " . (int)$proposalServiceId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_oh_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_service_id = " . (int)$proposalServiceId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $proposalServiceId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalServiceCategoryProfitCost($proposalServiceId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;

        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_pm_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_service_id = " . (int)$proposalServiceId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_pm_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.proposal_service_id = " . (int)$proposalServiceId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $templateId
     * @return mixed
     */
    public function getEstimateTemplateItemsCount($templateId)
    {
        $sql = "SELECT COUNT(*) AS numItems
            FROM estimate_template_items eti
            WHERE eti.template_id = " . $templateId;

        $result = $this->getSingleResult($sql);
        return $result->numItems;
    }

    /**
     * @param $templateId
     * @return array
     */
    public function getEstimateTemplateItemsData($templateId)
    {
        $sql = "SELECT ei.*, ec.name AS categoryName,
          et.name AS typeName,
          eti.id AS etiId, eti.default_qty, eti.default_days, eti.default_hpd,
          eut.id as unitType
        FROM estimate_template_items eti
        LEFT JOIN estimation_items ei ON eti.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        LEFT JOIN estimation_units eu ON ei.unit = eu.id
        LEFT JOIN estimation_unit_types eut ON eu.unit_type = eut.id
        WHERE eti.deleted=0 AND eti.template_id = " . $templateId;

        // Search
        $search = $this->ci->input->get('search');
        $searchVal = $search['value'];

        if ($searchVal) {
            $sql .= " AND (
                ei.name LIKE '%" . $searchVal . "%'
                OR et.name LIKE '%" . $searchVal . "%'
                OR ec.name LIKE '%" . $searchVal . "%')";
        }


        // Sorting
        $order = $this->ci->input->get('order');
        $sort = $order[0]['column'];
        $sortDir = $order[0]['dir'];
        $sortCol = '';

        switch ($sort) {

            case 0:
                $sortCol = 'eti.ord';
                break;

            case 1:
                $sortCol = 'et.name';
                break;

            case 2:
                $sortCol = 'ei.name';
                break;
        }

        $sql .= ' ORDER BY ' . $sortCol . " " . $sortDir;
        $sql .= ' LIMIT ' . $this->ci->input->get('length');
        $sql .= ' OFFSET ' . $this->ci->input->get('start');

        return $this->getAllResults($sql);
    }

    /**
     * @param $templateId
     * @return array
     */
    public function getEstimateTemplateItems($templateId)
    {


        $dql = "SELECT esi
        FROM \models\EstimateTemplateItem esi
        WHERE esi.template_id = :templateId";

        $query = $this->em->createQuery($dql);

        $query->setParameter(':templateId', $templateId);


        $results = $query->getResult();


        return $results;
    }

    /**
     * @param Companies $company
     * @return mixed
     */
    public function getEstimateItemsCount(Companies $company)
    {
        $sql = "SELECT COUNT(*) AS numItems
            FROM estimation_items ei
            WHERE ei.company_id = " . $company->getCompanyId() . "
            AND ei.deleted = 0
            OR ei.company_id IS NULL";

        $result = $this->getSingleResult($sql);
        return $result->numItems;
    }

    public function getAdminEstimateItemsCount()
    {
        $sql = "SELECT COUNT(*) AS numItems
            FROM estimation_items ei
            WHERE ei.company_id IS NULL
            AND ei.deleted = 0";

        $result = $this->getSingleResult($sql);
        return $result->numItems;
    }

    /**
     * @param Companies $company
     * @param integer $templateId
     * @param boolean $count
     * @return array
     */
    public function getEstimateLineItemsTableData(Companies $company, $templateId, $count = false)
    {
        $sql = "SELECT ei.*, ec.name AS categoryName, et.name AS typeName, eti.id AS etiId
        FROM estimation_items ei
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        LEFT JOIN estimation_units eu ON ei.unit = eu.id
        LEFT JOIN estimate_template_items eti ON ei.id = eti.item_id AND eti.deleted = 0 AND eti.template_id = " . $templateId . "
        LEFT JOIN estimation_templates etp ON eti.template_id = etp.id
        WHERE ei.company_id = " . $company->getCompanyId() . "
          AND (etp.company_id = " . $company->getCompanyId() . " OR etp.company_id IS NULL)
          AND ei.deleted = 0  AND eu.unit_type = 6 AND et.id !=20";

        $categories = $this->ci->input->get('categories');

        if (is_array($categories) && count($categories)) {
            $sql .= " AND ec.id IN (" . implode(',', $categories) . ')';
        }

        // Search
        $search = $this->ci->input->get('search');
        $searchVal = $search['value'];

        if ($searchVal) {
            $sql .= " AND (
                ei.name LIKE '%" . $searchVal . "%'
                OR et.name LIKE '%" . $searchVal . "%'
                OR ec.name LIKE '%" . $searchVal . "%')";
        }

        if ($count) {
            return count($this->getAllResults($sql));
        }

        // Sorting
        $order = $this->ci->input->get('order');
        $sort = $order[0]['column'];
        $sortDir = $order[0]['dir'];
        $sortCol = '';

        switch ($sort) {

            case 0:
                $sortCol = 'eti.id';
                break;

            case 1:
                $sortCol = 'ec.name';
                break;

            case 2:
                $sortCol = 'et.name';
                break;

            case 3:
                $sortCol = 'ei.name';
                break;
        }

        $sql .= ' ORDER BY ' . $sortCol . " " . $sortDir;

        if ($this->ci->input->get('length') >= 0) {
            $sql .= ' LIMIT ' . $this->ci->input->get('length');
            $sql .= ' OFFSET ' . $this->ci->input->get('start');
        }

        return $this->getAllResults($sql);
    }

    public function getAdminEstimateLineItemsTableData($templateId, $count = false)
    {
        $sql = "SELECT ei.*, ec.name AS categoryName, et.name AS typeName, eti.id AS etiId
        FROM estimation_items ei
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        LEFT JOIN estimation_units eu ON ei.unit = eu.id
        LEFT JOIN estimate_template_items eti ON ei.id = eti.item_id AND eti.deleted = 0 AND eti.template_id = " . $templateId . "
        LEFT JOIN estimation_templates etp ON eti.template_id = etp.id
        WHERE ei.company_id IS NULL
          AND (etp.company_id =0 OR etp.company_id IS NULL)
          AND ei.deleted = 0 AND eu.unit_type =6";

        $categories = $this->ci->input->get('categories');

        if (is_array($categories) && count($categories)) {
            $sql .= " AND ec.id IN (" . implode(',', $categories) . ')';
        }

        // Search
        $search = $this->ci->input->get('search');
        $searchVal = $search['value'];

        if ($searchVal) {
            $sql .= " AND (
                ei.name LIKE '%" . $searchVal . "%'
                OR et.name LIKE '%" . $searchVal . "%'
                OR ec.name LIKE '%" . $searchVal . "%')";
        }

        if ($count) {
            return count($this->getAllResults($sql));
        }

        // Sorting
        $order = $this->ci->input->get('order');
        $sort = $order[0]['column'];
        $sortDir = $order[0]['dir'];
        $sortCol = '';

        switch ($sort) {

            case 0:
                $sortCol = 'eti.id';
                break;

            case 1:
                $sortCol = 'ec.name';
                break;

            case 2:
                $sortCol = 'et.name';
                break;

            case 3:
                $sortCol = 'ei.name';
                break;
        }

        $sql .= ' ORDER BY ' . $sortCol . " " . $sortDir;

        if ($this->ci->input->get('length') >= 0) {
            $sql .= ' LIMIT ' . $this->ci->input->get('length');
            $sql .= ' OFFSET ' . $this->ci->input->get('start');
        }

        return $this->getAllResults($sql);
    }

    /**
     * @param Companies $company
     * @param integer $templateId
     * @param boolean $count
     * @return array
     */
    public function getEstimateLineItemsTableDataCrew(Companies $company, $crewId, $count = false)
    {
        $sql = "SELECT ei.*, ec.name AS categoryName, et.name AS typeName, eti.id AS etiId
        FROM estimation_items ei
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        LEFT JOIN estimate_crew_items eti ON ei.id = eti.item_id AND eti.crew_id = " . $crewId . "
        LEFT JOIN estimation_crews etp ON eti.crew_id = etp.id
        WHERE (
          ei.company_id IS NULL
          OR ei.company_id = " . $company->getCompanyId() . ")
          AND etp.company_id = " . $company->getCompanyId() . "
          AND ei.deleted = 0";

        $categories = $this->ci->input->get('categories');

        if (is_array($categories) && count($categories)) {
            $sql .= " AND ec.id IN (" . implode(',', $categories) . ')';
        }

        // Search
        $search = $this->ci->input->get('search');
        $searchVal = $search['value'];

        if ($searchVal) {
            $sql .= " AND (
                ei.name LIKE '%" . $searchVal . "%'
                OR et.name LIKE '%" . $searchVal . "%'
                OR ec.name LIKE '%" . $searchVal . "%')";
        }

        if ($count) {
            return count($this->getAllResults($sql));
        }

        // Sorting
        $order = $this->ci->input->get('order');
        $sort = $order[0]['column'];
        $sortDir = $order[0]['dir'];
        $sortCol = '';

        switch ($sort) {

            case 0:
                $sortCol = 'eti.id';
                break;

            case 1:
                $sortCol = 'ec.name';
                break;

            case 2:
                $sortCol = 'et.name';
                break;

            case 3:
                $sortCol = 'ei.name';
                break;
        }

        $sql .= ' ORDER BY ' . $sortCol . " " . $sortDir;

        if ($this->ci->input->get('length') >= 0) {
            $sql .= ' LIMIT ' . $this->ci->input->get('length');
            $sql .= ' OFFSET ' . $this->ci->input->get('start');
        }

        return $this->getAllResults($sql);
    }

    /**
     * @param Estimate $estimate
     * @return mixed
     */
    public function calculateEstimateLineItemTotalPrice(Estimate $estimate)
    {
        return $this->getProposalServiceLineItemTotal($estimate->getProposalServiceId());
    }

    /**
     * Returns the total price of all estimated line items belonging to a proposal service id
     * @param $proposalServiceId
     * @return mixed
     */
    public function getProposalServiceLineItemTotal($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = '$proposalServiceId'";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * Returns the total tax price of all estimated line items belonging to a proposal service id
     * @param $proposalServiceId
     * @return mixed
     */
    public function getProposalServiceLineItemTaxTotal($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalTaxPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = '$proposalServiceId'";

        $result = $this->getSingleResult($sql);

        return $result->totalTaxPrice;
    }

    /**
     * @param Estimate $estimate
     * @return array
     */
    public function getEstimateData(Estimate $estimate)
    {
        return [
            'id' => $estimate->getId(),
            'proposal_service_id' => $estimate->getProposalServiceId(),
            'completed' => $estimate->getCompleted(),
            'total_price' => $estimate->getTotalPrice(),
            'custom_price' => $estimate->getCustomPrice(),
            'line_item_total' => $this->getProposalServiceLineItemTotal($estimate->getProposalServiceId()),
            'service_price' => number_format($estimate->getProposalService()->getPrice(true), 2, '.', ''),
            'child_has_updated_flag' => $this->getChildUpdatedFlagCount($estimate->getProposalServiceId()),
        ];
    }

    /**
     * @param $proposalServiceId
     * @return mixed
     */
    public function getChildUpdatedFlagCount($proposalServiceId)
    {

        $sql = "SELECT SUM(eli.parent_updated) AS updated_count
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = '$proposalServiceId'";

        $result = $this->getSingleResult($sql);
        if (!$result->updated_count) {
            $result->updated_count = 0;
        }
        return $result->updated_count;
    }

    /**
     * @param $proposalServiceId
     */
    public function clearEstimateLineItems($proposalServiceId)
    {
        $dql = "DELETE \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :proposalServiceId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        $query->execute();
    }

    /**
     * @param $phaseId
     */
    public function clearEstimateLineItemsByPhaseId($phaseId)
    {
        $dql = "DELETE \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $query->execute();
    }

    /**
     * @param $proposalServiceId
     */
    public function clearsealcoatdefualtchild($parent_line_item_id)
    {
        $dql = "DELETE \models\EstimationLineItem eli
        WHERE eli.parent_line_item_id = :parent_line_item_id
        AND eli.child_material = 1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parent_line_item_id', $parent_line_item_id);
        $query->execute();
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getAllPhaseItems($phaseId)
    {

        $dql = "SELECT eli.item_id,eli.id
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId ";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        return $query->getResult();
    }

    /**
     * @param $proposalServiceId
     */
    public function deleteEstimationCalculatorValues($proposalServiceId)
    {
        $dql = "DELETE \models\EstimationCalculatorValue ecv
        WHERE ecv.proposal_service_id = :proposalServiceId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        $query->execute();
    }

    /**
     * @param $proposalServiceId
     * @param $typeId
     * @return mixed
     */
    public function getProposalServiceTypeTotal($proposalServiceId, $typeId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.proposal_service_id = '$proposalServiceId'
        AND ei.type_id = '$typeId'";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalServiceId
     * @param $categoryId
     * @return mixed
     */
    public function getProposalServiceCategoryTotal($proposalServiceId, $categoryId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND et.category_id = " . (int)$categoryId;

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getCompanyPlants(Companies $company)
    {
        $dql = "SELECT ep
        FROM \models\EstimationPlant ep
        WHERE ep.company_id = :companyId
        AND ep.plants = 1
        AND ep.deleted = 0
        ORDER BY ep.ord ASC";
        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        return $query->getResult();
    }


    /**
     * @param Companies $company
     * @return array
     */

    public function getCompanyPlantsByUser(Accounts $account,$proposal)
    {
        $allPlants = array();
        if($account->hasFullAccess() ||  $account->isAdministrator()){
            $allPlants = $this->getCompanyPlants($account->getCompany());

         }else{
            $dql = "SELECT ebp
            FROM \models\EstimationBranchPlant ebp
            WHERE ebp.company_id = :companyId";
            $query = $this->em->createQuery($dql);
            $query->setParameter(':companyId', $account->getCompany()->getCompanyId());
            $assigns =  $query->getResult();

            if(count($assigns)>0){


                $dql = "SELECT ebp
                FROM \models\EstimationBranchPlant ebp
                WHERE ebp.company_id = :companyId
                AND ebp.branch_id = :branchId";
                $query = $this->em->createQuery($dql);
                $query->setParameter(':companyId', $account->getCompany()->getCompanyId());
                $query->setParameter(':branchId', $account->getBranch());
                $assignPlants =  $query->getResult();



                foreach($assignPlants as $assignPlant){

                    $dql = "SELECT ed
                    FROM \models\EstimationPlant ed
                    WHERE ed.id = :plantId
                    AND ed.plants = 1
                    AND ed.deleted = 0
                    ORDER BY ed.ord ASC";
                    $query = $this->em->createQuery($dql);
                    $query->setParameter(':plantId', $assignPlant->getPlantId());
                    $result =$query->getOneOrNullResult();
                    if($result){
                        $allPlants[] =$result;
                    }
                }

                //return $allPlants;
            }else{

                $allPlants = $this->getCompanyPlants($account->getCompany());
            }

         }

         foreach($allPlants as $allPlant) {

            $tempArray = $allPlant;
            if($allPlant->getLat() !='0.00000000'){
                $tempArray->distance =$this->distance($proposal->getLat(),$proposal->getLng(),$allPlant->getLat(),$allPlant->getLng(),'M');
            }else{
                $tempArray->distance =0;
            }

            $newAllPlants[] =  $tempArray;
        }


         usort($newAllPlants, function($a, $b) {

            if ($a->distance == $b->distance) return 0;
            if ($a->distance == 0) return 1;
            if ($b->distance == 0) return -1;
            return $a->distance > $b->distance ? 1 : -1;

         });
        return $newAllPlants;
    }



    /**
     * @param Accounts $account
     * @return array
     */

    public function getCompanyDumpsByUser(Accounts $account,$proposal)
    {
        $allDumps =array();
        if($account->hasFullAccess() ||  $account->isAdministrator()){
            $allDumps = $this->getCompanyDumps($account->getCompany());

         }else{

            $dql = "SELECT ebp
            FROM \models\EstimationBranchPlant ebp
            WHERE ebp.company_id = :companyId";
            $query = $this->em->createQuery($dql);
            $query->setParameter(':companyId', $account->getCompany()->getCompanyId());
            $assigns =  $query->getResult();

            if(count($assigns)>0){

                $dql = "SELECT ebp
                FROM \models\EstimationBranchPlant ebp
                WHERE ebp.company_id = :companyId
                AND ebp.branch_id = :branchId";
                $query = $this->em->createQuery($dql);
                $query->setParameter(':companyId', $account->getCompany()->getCompanyId());
                $query->setParameter(':branchId', $account->getBranch());
                $assignDumps =  $query->getResult();



                foreach($assignDumps as $assignDump){

                    $dql = "SELECT ed
                    FROM \models\EstimationPlant ed
                    WHERE ed.id = :dumpId
                    AND ed.dumps = 1
                    AND ed.deleted = 0
                    ORDER BY ed.ord ASC";
                    $query = $this->em->createQuery($dql);
                    $query->setParameter(':dumpId', $assignDump->getPlantId());
                    $result =$query->getOneOrNullResult();
                    if($result){
                        $allDumps[] =$result;
                    }
                }

                //return $allDumps;
            }else{

                $allDumps =$this->getCompanyDumps($account->getCompany());
            }



         }
        $newAllDumps = array();

//print_r($allDumps);
        foreach($allDumps as $allDump) {

            $tempArray = $allDump;
            if($allDump->getLat() !='0.00000000'){
                $tempArray->distance =$this->distance($proposal->getLat(),$proposal->getLng(),$allDump->getLat(),$allDump->getLng(),'M');
            }else{
                $tempArray->distance = 0;
            }

            $newAllDumps[] =  $tempArray;
        }

        usort($newAllDumps, function($a, $b) {

            if ($a->distance == $b->distance) return 0;
            if ($a->distance == 0) return 1;
            if ($b->distance == 0) return -1;
            return $a->distance > $b->distance ? 1 : -1;

         });

 return $newAllDumps;


    }
    /**
     * @param Companies $company
     * @return array
     */
    public function getCompanyDumps(Companies $company)
    {
        $dql = "SELECT ed
        FROM \models\EstimationPlant ed
        WHERE ed.company_id = :companyId
        AND ed.dumps = 1
        AND ed.deleted = 0
        ORDER BY ed.ord ASC";
        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        return $query->getResult();
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServiceCustomLineItems($proposalServiceId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :psId
        AND eli.item_id = 0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':psId', $proposalServiceId);

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getTruckingItemsArray(Companies $company)
    {

        $truckingTypeId = 20;
        $type = $this->em->findEstimationType($truckingTypeId);

        $items = $this->getCompanyTypeItems($company, $type);

        $out = [];

        foreach ($items as $item) {
            $out[$item->getId()] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'unit_price' => $item->getUnitPrice(),
                'base_price' => $item->getBasePrice(),
                'profit_rate' => $item->getProfitRate(),
                'overhead_rate' => $item->getOverheadRate(),
                'capacity' => $item->getCapacity(),
                'minimum_hours' => $item->getMinimumHours(),
            ];
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @param EstimationType $type
     * @return array
     * @description Returns a collection of items belonging to a type for a company
     */
    public function getCompanyTypeItems(Companies $company, EstimationType $type)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\EstimationItem', 'ei');
        $rsm->addFieldResult('ei', 'id', 'id');
        $rsm->addFieldResult('ei', 'name', 'name');
        $rsm->addFieldResult('ei', 'company_id', 'company_id');

        $sql = "SELECT ei.id
        FROM estimation_items ei
        LEFT JOIN estimation_items_company_order eico
          ON ei.id = eico.item_id AND eico.company_id = " . $company->getCompanyId() . "
        WHERE ei.company_id = " . $company->getCompanyId() . "
        AND ei.type_id = " . $type->getId() . "
        AND ei.deleted = 0
        ORDER BY COALESCE (eico.ord, 99999)";

        $results = $this->getAllResults($sql);
        $out = [];

        foreach ($results as $result) {
            $item = $this->em->findEstimationItem($result->id);

            if ($item) {
                $out[] = $item;
            }
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getSandSealerItemsArray(Companies $company)
    {

        $sandSealerTypeId = 12;
        $type = $this->em->findEstimationType($sandSealerTypeId);

        $items = $this->getCompanyTypeItems($company, $type);

        $out = [];

        foreach ($items as $item) {
            $out[$item->getId()] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'unit_price' => $item->getUnitPrice(),
                'unit_base_price' => $item->getBasePrice(),
                'profit_rate' => $item->getProfitRate(),
                'overhead_rate' => $item->getOverheadRate(),
                'capacity' => $item->getCapacity(),
            ];
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getAdditiveSealerItemsArray(Companies $company)
    {

        $additiveSealerTypeId = 11;
        $type = $this->em->findEstimationType($additiveSealerTypeId);

        $items = $this->getCompanyTypeItems($company, $type);

        $out = [];

        foreach ($items as $item) {
            $out[$item->getId()] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'unit_price' => $item->getUnitPrice(),
                'unit_base_price' => $item->getBasePrice(),
                'profit_rate' => $item->getProfitRate(),
                'overhead_rate' => $item->getOverheadRate(),
                'capacity' => $item->getCapacity(),
            ];
        }

        return $out;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getlaborItemsArray(Companies $company)
    {
        $company_id = 3;
        $category_id = \models\EstimationCategory::LABOR;
        $Category = $this->em->find('models\EstimationCategory', \models\EstimationCategory::LABOR);
        $laborTypeIds = $this->getCompanyCategoryTypes($company, $Category);

        $labor_array = array();
        $i = 0;

        foreach ($laborTypeIds as $laborTypeId) {

            $type = $this->em->findEstimationType($laborTypeId->getId());
            $items = $this->getCompanyTypeItems($company, $type);
            // $out = [];
            $labor_array[$i]['name'] = $type->getName();
            $j = 0;
            foreach ($items as $item) {
                $labor_array[$i]['items'][$j] = [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'unit_price' => $item->getUnitPrice(),
                    'unit_single_name' => $item->getUnitModel()->getSingleName(),
                    'base_price' => $item->getBasePrice(),
                    'profit_rate' => $item->getProfitRate(),
                    'overhead_rate' => $item->getOverheadRate(),
                    'capacity' => $item->getCapacity(),
                ];
                $j++;
            }
            //print_r($type->getName());
            $i++;
        }


        return $labor_array;
    }

    /**
     * @param $plantId
     * @param $proposalId
     * @param $lineItemId
     */
    public function addProposalPlant($plantId, $proposalId, $lineItemId)
    {
        // Remove any plants for this line item
        $this->clearEstimateLineItemPlant($lineItemId);

        $proposalPlant = new ProposalPlant();
        $proposalPlant->setPlantId($plantId);
        $proposalPlant->setProposalId($proposalId);
        $proposalPlant->setLineItemId($lineItemId);
        $this->em->persist($proposalPlant);
        $this->em->flush();
    }

    /**
     * @param $lineItemId
     */
    public function clearEstimateLineItemPlant($lineItemId)
    {
        $dql = "DELETE \models\ProposalPlant pp
        WHERE pp.line_item_id = :lineItemId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':lineItemId', $lineItemId);
        $query->execute();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getCategoryByName($name)
    {
        $dql = "SELECT ec
        FROM \models\EstimationCategory ec
        WHERE ec.name = :name";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':name', $name);

        return $query->getOneOrNullResult();
    }

    /**
     * @param Companies $company
     * @param $categoryId
     * @param $name
     * @return mixed|EstimationType
     */
    public function getCategoryTypeByName(Companies $company, $categoryId, $name)
    {
        $dql = "SELECT et
        FROM \models\EstimationType et
        WHERE et.name = :name
        AND et.category_id = :categoryId
        AND (et.company_id IS NULL OR et.company_id = :companyId)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':name', $name);
        $query->setParameter(':categoryId', $categoryId);
        $query->setParameter(':companyId', $company->getCompanyId());

        $type = $query->getOneOrNullResult();

        if ($type) {
            return $type;
        }

        // Didn't exist, we have to create a new one
        $type = new EstimationType();
        $type->setCompanyId($company->getCompanyId());
        $type->setCategoryId($categoryId);
        $type->setName($name);
        $this->em->persist($type);
        $this->em->flush();

        return $type;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getUnitByName($name)
    {
        $dql = "SELECT eu
        FROM \models\EstimationUnit eu
        WHERE eu.name = :name";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':name', $name);

        return $query->getOneOrNullResult();
    }

    /**
     * @param $proposalServiceId
     * @return mixed
     */
    public function getProposalServiceUncompletedPhasesCount($proposalServiceId)
    {

        $sql = "SELECT COUNT(ep.id) AS uncomplete
        FROM estimation_phases ep
        WHERE ep.proposal_service_id = '$proposalServiceId'
        AND ep.complete =0";

        $result = $this->getSingleResult($sql);
        return $result->uncomplete;
    }

    /**
     * @param Proposal_services $proposalService
     * @return array
     * @description Returns a formatted array of phases belonging to a proposal service
     */
    public function getProposalServicePhaseArray(Proposal_services $proposalService, $proposal_Id)
    {
        $out = [];
        $phases = $this->getProposalServicePhases($proposalService, $proposal_Id);

        foreach ($phases as $phase) {


            $out[] = [
                'id' => $phase->getId(),
                'name' => $phase->getName(),
                'complete' => $phase->getComplete(),
                'child_updated_count' => $this->getChildUpdatedFlagCountByPhaseId($phase->getId()),
            ];
        }

        return $out;
    }

    /**
     * @param Proposal_services $proposalService
     * @return array
     */
    public function getProposalServicePhases(Proposal_services $proposalService, $proposal_Id)
    {
        $dql = "SELECT ep
        FROM \models\EstimationPhase ep
        WHERE ep.proposal_service_id = :proposal_service_id
        ORDER BY ep.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_service_id', $proposalService->getServiceId());

        return $query->getResult();
    }

    /**
     * @param $proposalServiceId
     * @return mixed
     */
    public function getChildUpdatedFlagCountByPhaseId($phaseId)
    {

        $sql = "SELECT SUM(eli.parent_updated) AS updated_count
        FROM estimate_line_items eli
        WHERE eli.phase_id = '$phaseId'";

        $result = $this->getSingleResult($sql);
        return $result->updated_count;
    }

    /**
     * @param $proposal_Id
     * @return array
     * @description Returns a formatted array of phases belonging to a proposal service
     */
    public function getProposalPhaseArray($proposal_Id)
    {
        $out = [];
        $phases = $this->getProposalPhases($proposal_Id);

        foreach ($phases as $phase) {
            $out[] = [
                'id' => $phase->getId(),
                'name' => $phase->getName(),
                'complete' => $phase->getComplete()
            ];
        }

        return $out;
    }

    /**
     * @param Proposal_services $proposalService
     * @return array
     */
    public function getProposalPhases($proposal_Id)
    {
        $dql = "SELECT ep
        FROM \models\EstimationPhase ep
        WHERE ep.proposal_id = :proposalId
        ORDER BY ep.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposal_Id);

        return $query->getResult();
    }

    /**
     * @param EstimationLineItem $lineItem
     * @description Returns a breakdown of price splits and details including child items for an item
     */
    public function getItemPriceBreakdown(EstimationLineItem $lineItem)
    {
        $out = [
            'itemPrice' => $lineItem->getTotalPrice(),
            'breakdown' => [
                'truckingPrice' => $this->getChildTruckingTotalPrice($lineItem),
                'laborPrice' => $this->getChildLaborTotalPrice($lineItem)
            ]
        ];

        var_dump($out);
    }

    /**
     * @param EstimationLineItem $lineItem
     * @return mixed
     */
    public function getChildTruckingTotalPrice(EstimationLineItem $lineItem)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) as truckingPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei
          ON eli.item_id = ei.id
        WHERE ei.type_id = 22
        AND eli.parent_line_item_id = " . $lineItem->getId();

        return $this->getSingleResult($sql);
    }

    /**
     * @param EstimationLineItem $lineItem
     * @return mixed
     */
    public function getChildLaborTotalPrice(EstimationLineItem $lineItem)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) as truckingPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei
          ON eli.item_id = ei.id
        LEFT JOIN estimation_types et
          ON ei.type_id = et.id
        WHERE et.category_id = 22
        AND eli.parent_line_item_id = " . $lineItem->getId();

        return $this->getSingleResult($sql);
    }

    /**
     * @param Companies $company
     * @param $categoryId
     * @return array
     */
    public function getCategoryTypeByCategoryId(Companies $company, $categoryId)
    {
        // $dql = "SELECT et
        // FROM \models\EstimationType et
        // WHERE et.category_id = :categoryId
        // AND (et.company_id IS NULL OR et.company_id = :companyId)";

        // $query = $this->em->createQuery($dql);
        // $query->setParameter(':categoryId', $categoryId);
        // $query->setParameter(':companyId', $company->getCompanyId());

        // $types = $query->getResult();

        $Category = $this->em->find('models\EstimationCategory', $categoryId);
        $types = $this->getCompanyCategoryTypes($company, $Category);
        $equipmentArray = array();
        $i = 0;
        foreach ($types as $type) {

            $items = $this->getCompanyTypeItems($company, $type);
            //print_r($items);die;
            // $out = [];
            $equipmentArray[$i]['name'] = $type->getName();
            $equipmentArray[$i]['type_id'] = $type->getId();
            $equipmentArray[$i]['items'] = array();
            $j = 0;
            foreach ($items as $item) {
                $equipmentArray[$i]['items'][$j] = [
                    'id' => $item->getId(),
                    'name' => $item->getName(),
                    'unit_price' => $item->getUnitPrice(),
                    'unit_single_name' => $item->getUnitModel()->getSingleName(),
                    'base_price' => $item->getBasePrice(),
                    'profit_rate' => $item->getProfitRate(),
                    'overhead_rate' => $item->getOverheadRate(),
                    'capacity' => $item->getCapacity(),
                ];
                $j++;
            }
            $i++;
        }

        return $equipmentArray;
    }

    /**
     * @param EstimationPhase $phase
     * @return array
     * @description Returns the parent items belonging to a phase
     */
    public function getPhaseParentItems(EstimationPhase $phase)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.parent_line_item_id IS NULL";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phase->getId());

        return $query->getResult();
    }

    /**
     * @param EstimationLineItem $parentItem
     * @return array
     */
    public function getItemChildItems(EstimationLineItem $parentItem)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.parent_line_item_id = :parentId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parentId', $parentItem->getId());

        return $query->getResult();
    }

    /**
     * @param Proposals $proposal
     * @return bool
     */
    public function proposalHasEstimateItems(Proposals $proposal)
    {
        $sql = "SELECT COUNT(eli.id) AS numLineItems
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposal->getProposalId();

        $result = $this->getSingleResult($sql);

        if ($result->numLineItems > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param Proposals $proposal
     */
    public function createDefaultProposalEstimate(Proposals $proposal,Accounts $account)
    {
        $proposalId = $proposal->getProposalId();

        $sql = "SELECT COUNT(pe.id) AS numLineItems
            FROM proposal_estimates pe
            WHERE pe.proposal_id = " . (int)$proposalId;

        $result = $this->getSingleResult($sql);
        if ($result->numLineItems < 1) {
            $pe = new ProposalEstimate();
            $pe->setProposalId($proposalId);
            $pe->setStatusId(\models\EstimateStatus::NOT_STARTED);
            $pe->setCreatedAt(date("Y-m-d H:i:s"));
            $pe->setLastUpdated(date("Y-m-d H:i:s"));
            $this->em->persist($pe);
            $this->em->flush();

        //Event Log 
        $this->getProposalEventRepository()->startEstimation($proposal,$account);
        }
        


    }

    /**
     * @param Proposals $proposal
     */
    public function createDefaultProposalServiceJobCosting(Proposals $proposal,Accounts $account)
    {
        $proposalId = $proposal->getProposalId();

        $sql = "SELECT COUNT(pe.id) AS numLineItems
            FROM service_job_cost pe
            WHERE pe.proposal_id = " . (int)$proposalId;

        $result = $this->getSingleResult($sql);
        if ($result->numLineItems < 1) {
            $sjc = new ServiceJobCost();
            $sjc->setProposalId($proposalId);
            $sjc->setProposalServiceId(0);
            $sjc->setStatusId(\models\JobCostStatus::NOT_STARTED);
           
            $this->em->persist($sjc);
            $this->em->flush();
        
        //Event Log 
        $this->getProposalEventRepository()->jobCostingStart($proposal,$account);

        }

    }

    /**
     * @param EstimationPhase $phase
     */
    public function updatePhaseStatus(EstimationPhase $phase)
    {
        $phaseItems = $this->getPhaseLineItems($phase->getId());

        if (count($phaseItems)) {
            $phase->setComplete(1);
        } else {
            $phase->setComplete(0);
        }

        $this->em->persist($phase);
        $this->em->flush();
    }

    /**
     * Returns all line item models belonging to a phase
     * Excludes custom items
     * @param $phaseId
     * @param $custom
     * @return array
     */
    public function getPhaseLineItems($phaseId, $custom = false)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.parent_line_item_id IS NULL";
        if (!$custom) {
            $dql .= " AND eli.item_id != 0";
        } else {
            $dql .= " AND eli.item_id = 0";
        }
        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        return $query->getResult();
    }

    /**
     * @param Proposal_services $proposalService
     * @return bool
     */
    public function proposalServicePhasesComplete(Proposal_services $proposalService)
    {
        $sql = "SELECT COUNT(ep.id) AS numPhases
        FROM estimation_phases ep
        WHERE ep.complete = 0";

        $result = $this->getSingleResult($sql);

        if ($result->numPhases > 0) {
            return false;
        }

        return true;
    }

    /**
     * @param EstimationLineItem $oldItem
     * @param EstimationLineItem $newItem
     * @return string
     */
    public function getLineItemsDifferencesString(EstimationLineItem $oldItem, EstimationLineItem $newItem)
    {
        $changedValues = $this->getLineItemDifferences($oldItem, $newItem);
        $out = '';

        foreach ($changedValues as $changedValue) {
            $out .= '<strong>' . $changedValue['name'] . ':</strong> Updated from ' .
                $changedValue['from'] . ' to ' . $changedValue['to'] . '<br />';
        }

        return $out;
    }

    /**
     * @param EstimationLineItem $oldItem
     * @param EstimationLineItem $newItem
     * @return array
     */
    public function getLineItemDifferences(EstimationLineItem $oldItem, EstimationLineItem $newItem)
    {

        $changedValues = [];


        if ((int)$newItem->getDay() != (int)$oldItem->getDay()) {
            $changedValues[2] = [
                'name' => 'Days',
                'from' => number_format($oldItem->getDay()),
                'to' => number_format($newItem->getDay() ? $newItem->getDay() : 0)
            ];
        }

        // Check Number of People
        if ((int)$newItem->getNumPeople() != (int)$oldItem->getNumPeople()) {
            $changedValues[3] = [
                'name' => 'Number',
                'from' => number_format($oldItem->getNumPeople()),
                'to' => number_format($newItem->getNumPeople() ? $newItem->getNumPeople() : 0)
            ];

        }

        // Check Hours per day
        if ((int)$newItem->getHoursPerDay() != (int)$oldItem->getHoursPerDay()) {
            $changedValues[4] = [
                'name' => 'Hours per day',
                'from' => number_format($oldItem->getHoursPerDay()),
                'to' => number_format($newItem->getHoursPerDay() ? $newItem->getHoursPerDay() : 0)
            ];
        }
        // Check Quantity
        if (number_format($newItem->getQuantity(), 2) !== number_format($oldItem->getQuantity(), 2)) {
            $changedValues[0] = [
                'name' => 'Quantity',
                'from' => number_format($oldItem->getQuantity()),
                'to' => number_format($newItem->getQuantity())
            ];
        }
        // Check Total Price
        if (number_format($newItem->getTotalPrice(), 2) !== number_format($oldItem->getTotalPrice(), 2)) {
            $changedValues[6] = [
                'name' => 'Total Price',
                'from' => '$' . number_format($oldItem->getTotalPrice()),
                'to' => '$' . number_format($newItem->getTotalPrice())
            ];
        }


        // Check Unit Price
        if (number_format($newItem->getUnitPrice(), 2) !== number_format($oldItem->getUnitPrice(), 2)) {
            
            if($newItem->getEditedUnitPrice()==1){
               
                $changedValues[1] = [
                    'name' => 'Unit Price',
                    'from' => '$' . number_format($oldItem->getUnitPrice()),
                    'to' => '$' . number_format($newItem->getUnitPrice())
                ];
            }else if($newItem->getEditedBasePrice()==1){
                $changedValues[1] = [
                    'name' => 'Base Unit Price',
                    'from' => '$' . number_format($oldItem->getBasePrice()),
                    'to' => '$' . number_format($newItem->getBasePrice())
                ];
            }
            
        }

        // Check Overhead Rate
        if ($newItem->getOverheadRate() !== $oldItem->getOverheadRate()) {
            $changedValues[3] = [
                'name' => 'Overhead Rate',
                'from' => number_format($oldItem->getOverheadRate()) . '%',
                'to' => number_format($newItem->getOverheadRate() ? $newItem->getOverheadRate() : 0) . '%'
            ];
        }

        // Check Profit Rate
        if ($newItem->getProfitRate() !== $oldItem->getProfitRate()) {
            $changedValues[4] = [
                'name' => 'Profit Rate',
                'from' => number_format($oldItem->getProfitRate()) . '%',
                'to' => number_format($newItem->getProfitRate() ? $newItem->getProfitRate() : 0) . '%'
            ];
        }

        // Check Tax Rate
        if ($newItem->getTaxRate() != $oldItem->getTaxRate()) {
            $changedValues[5] = [
                'name' => 'Tax Rate',
                'from' => number_format($oldItem->getTaxRate()) . '%',
                'to' => number_format($newItem->getTaxRate() ? $newItem->getTaxRate() : 0) . '%'
            ];
        }


        return $changedValues;
    }

    /**
     * @param EstimationLineItem $oldItem
     * @param EstimationLineItem $newItem
     * @return string
     */
    public function getTemplateEditLineItemsDifferencesString(EstimationLineItem $oldItem, EstimationLineItem $newItem)
    {
        $changedValues = $this->getTemplateEditLineItemDifferences($oldItem, $newItem);
        $out = '';

        foreach ($changedValues as $changedValue) {
            $out .= '<strong>' . $changedValue['name'] . ':</strong> Changed from ' .
                $changedValue['from'] . ' to ' . $changedValue['to'] . '<br />';
        }

        return $out;
    }

    /**
     * @param EstimationLineItem $oldItem
     * @param EstimationLineItem $newItem
     * @return array
     */
    public function getTemplateEditLineItemDifferences(EstimationLineItem $oldItem, EstimationLineItem $newItem)
    {

        $changedValues = [];

        // Check Days
        if ($newItem->getDay() !== $oldItem->getDay()) {
            $changedValues[2] = [
                'name' => 'Days',
                'from' => number_format($oldItem->getDay()),
                'to' => number_format($newItem->getDay() ? $newItem->getDay() : 0)
            ];
        }

        // Check Number of People
        if ($newItem->getNumPeople() !== $oldItem->getNumPeople()) {
            $changedValues[3] = [
                'name' => 'Number',
                'from' => number_format($oldItem->getNumPeople()),
                'to' => number_format($newItem->getNumPeople() ? $newItem->getNumPeople() : 0)
            ];

        }

        // Check Hours per day
        if ($newItem->getHoursPerDay() != $oldItem->getHoursPerDay()) {
            $changedValues[4] = [
                'name' => 'Hours per day',
                'from' => number_format($oldItem->getHoursPerDay()),
                'to' => number_format($newItem->getHoursPerDay() ? $newItem->getHoursPerDay() : 0)
            ];
        }
        // Check Total Price
        if (number_format($newItem->getTotalPrice(), 2) !== number_format($oldItem->getTotalPrice(), 2)) {
            $changedValues[1] = [
                'name' => 'Total Price',
                'from' => '$' . number_format($oldItem->getTotalPrice()),
                'to' => '$' . number_format($newItem->getTotalPrice())
            ];
        }
        return $changedValues;

    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getEstimateNotes($proposalId)
    {
        $dql = "SELECT n FROM models\Notes n
                WHERE n.type = :noteType
                AND n.relationId = :proposalId
                ORDER BY n.added ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':noteType', 'estimate');
        $query->setParameter(':proposalId', $proposalId);

        return $query->getResult();
    }

    /**
     * @param $estimateLineItem
     * @return array
     */
    public function getEstimateLineItemNotes($estimateLineItem)
    {
        $dql = "SELECT n FROM models\Notes n
                WHERE n.type = :noteType
                AND n.relationId = :estimateLineItem
                ORDER BY n.added ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':noteType', 'estimate_line_item');
        $query->setParameter(':estimateLineItem', $estimateLineItem);

        return $query->getResult();
    }

    /**
     * @param Proposals $proposal
     * @return array
     */
    public function getProposalPlantIds(Proposals $proposal)
    {
        $sql = "SELECT DISTINCT(eli.plant_id)
                FROM estimate_line_items eli
                WHERE eli.proposal_id = " . $proposal->getProposalId() . "
                AND eli.plant_id IS NOT NULL";

        $results = $this->getAllResults($sql);
        $out = [];

        foreach ($results as $result) {
            $out[] = $result->plant_id;
        }

        return $out;
    }

    /**
     * @param Accounts $account
     * @param EstimationLineItem $lineItem
     */
    public function deleteChildItems(Accounts $account, EstimationLineItem $lineItem)
    {
        $childItems = $this->getChildLineItems($lineItem->getId());

        foreach ($childItems as $childItem) {

            // Log it
            $this->addLog(
                $account,
                $childItem->getProposalService()->getProposal(),
                'delete_item',
                $childItem->getItem()->getName() . " item deleted (Parent Item deleted)"
            );

            $this->em->remove($childItem);
        }

        $this->em->flush();
    }

    /**
     * @param Accounts $user
     * @param $proposalId
     * @param string $action
     * @param string $detail
     * @description Add a record to the estimation log table
     */
    public function addLog(Accounts $user, $proposalId, $action = "", $detail = "")
    {
        $log = new EstimateLog();
        $log->setUserId($user->getAccountId());
        $log->setUserName($user->getFullName());
        $log->setProposalId($proposalId);
        $log->setAction($action);
        $log->setDetails($detail);

        $this->em->persist($log);
        $this->em->flush();
    }

    /**
     * @param Companies $company
     * @param ServiceField $serviceField
     * @return CompanyEstimateServiceField
     */
    public function getEstimateServiceField(Companies $company, ServiceField $serviceField)
    {
        // Look for a record for this company in this field ID
        $companyField = $this->getCompanyEstimateServiceField($company, $serviceField);

        // Return it if we have it
        if ($companyField) {
            return $companyField;
        }

        // Otherwise get default
        $defaultField = $this->getDefaultEstimateServiceField($serviceField);

        // Return it if we have it
        if ($defaultField) {
            return $defaultField;
        }

        // Return an empty one otherwise
        $newField = new CompanyEstimateServiceField();
        return $newField;

    }

    /**
     * @param Companies $company
     * @param ServiceField $serviceField
     * @return mixed
     */
    public function getCompanyEstimateServiceField(Companies $company, ServiceField $serviceField)
    {
        $dql = "SELECT cesf FROM models\CompanyEstimateServiceField cesf
                WHERE cesf.field_id = :fieldId
                AND cesf.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':fieldId', $serviceField->getFieldId());
        $query->setParameter(':companyId', $company->getCompanyId());

        return $query->getOneOrNullResult();
    }

    /**
     * @param ServiceField $serviceField
     * @return mixed
     */
    public function getDefaultEstimateServiceField(ServiceField $serviceField)
    {
        $dql = "SELECT cesf FROM models\CompanyEstimateServiceField cesf
                WHERE cesf.field_id = :fieldId
                AND cesf.company_id IS NULL";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':fieldId', $serviceField->getFieldId());

        return $query->getOneOrNullResult();
    }

    /**
     * @param $serviceId
     */
    public function clearDefaultCesf($serviceId)
    {
        $dql = "DELETE \models\CompanyEstimateServiceField cesf
        WHERE cesf.service_id = :serviceId
        AND cesf.company_id IS NULL";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':serviceId', $serviceId);
        $query->execute();
    }

    //$note_count = $this->em->createQuery("SELECT count(n) as note_count FROM models\Notes n WHERE n.type='estimate_line_item' AND n.relationId= $est_line_id ")->getSingleScalarResult();

    /**
     * @param Companies $company
     * @param $serviceId
     */
    public function clearCompanyCesf(Companies $company, $serviceId)
    {
        $dql = "DELETE \models\CompanyEstimateServiceField cesf
        WHERE cesf.service_id = :serviceId
        AND cesf.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':serviceId', $serviceId);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->execute();
    }

    /**
     * @param Companies $company
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServiceSortedLineItemsPhase(Companies $company, $proposalServiceId, $phaseId)
    {
        $allLineItems = $this->getAllProposalServiceLineItemsPhaseNonSub($proposalServiceId, $phaseId);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            //if($lineItem->getItemId() != 0){

            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();


            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getPhaseCategoryBaseCost($phaseId, $category);

                $aggOverheadCost = $this->getPhaseCategoryOverheadCost($phaseId, $category);
                $aggProfitCost = $this->getPhaseProfitCost($phaseId, $category);
                $aggOverheadRate = (($aggOverheadCost > 0) && ($aggBaseCost > 0)) ? round(($aggOverheadCost / $aggBaseCost) * 100) : 0;
                $aggProfitRate = (($aggProfitCost > 0) && ($aggBaseCost > 0)) ? round(($aggProfitCost / $aggBaseCost) * 100) : 0;


                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                ];
            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //}
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getAllProposalServiceLineItemsPhaseNonSub($proposalServiceId, $phaseId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.fees=0 AND  eli.permit=0 AND eli.fixed_template!=1
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);

        return $query->getResult();
    }

    /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseCategoryBaseCost($phaseId, EstimationCategory $category)
    {
        //$sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        $sql = "SELECT COALESCE(SUM((eli.total_price - eli.profit_price - eli.overhead_price - eli.tax_price)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseCategoryBaseCostWithFixedTemplate($phaseId, EstimationCategory $category)
    {
        //$sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        $sql = "SELECT COALESCE(SUM((eli.total_price - eli.profit_price - eli.overhead_price - eli.tax_price)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_base_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.phase_id = " . (int)$phaseId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_base_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.phase_id = " . (int)$phaseId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseCategoryOverheadCostWithFixedTemplate($phaseId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;

        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_oh_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.phase_id = " . (int)$phaseId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_oh_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.phase_id = " . (int)$phaseId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

    /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseCategoryOverheadCost($phaseId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    
     /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseTaxCost($phaseId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseTaxCostWithFixedTemplate($phaseId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseTotal($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli

        WHERE eli.phase_id = " . (int)$phaseId  ;

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseTotalCostWithFixedTemplate($phaseId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.phase_id = " . (int)$phaseId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.phase_id = " . (int)$phaseId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }

     /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseTotalCost($phaseId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }
    /**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseProfitCost($phaseId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

/**
     * @param $phaseId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getPhaseProfitCostWithFixedTemplate($phaseId, EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20 
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        //return $result->totalPrice;
        $total = $result->totalPrice;
        $temp_equipment_total =0;
        $temp_labor_total =0;
        if($category->getId() ==\models\EstimationCategory::EQUIPMENT){
            $sql = "SELECT COALESCE(SUM((eli.fixed_equipment_pm_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.phase_id = " . (int)$phaseId;
            $result = $this->getSingleResult($sql);
            $temp_equipment_total = $result->totalPrice;
        }

        if($category->getId() ==\models\EstimationCategory::LABOR){
            $sql = "SELECT COALESCE(SUM((eli.fixed_labor_pm_total)), 0.00) AS totalPrice
            FROM estimate_line_items eli
            WHERE eli.phase_id = " . (int)$phaseId;
            $result = $this->getSingleResult($sql);
            $temp_labor_total = $result->totalPrice;

        }

        return $total + $temp_labor_total + $temp_equipment_total;
    }


    /**
     * @param Companies $company
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServiceSortedLineItemsPhaseNonTemplate(Companies $company, $proposalServiceId, $phaseId)
    {
        $allLineItems = $this->getAllProposalServiceLineItemsPhaseNonSubNonTemplate($proposalServiceId, $phaseId);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            //if($lineItem->getItemId() != 0){

            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();


            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                } 
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getPhaseCategoryBaseCost($phaseId, $category);

                $aggOverheadCost = $this->getPhaseCategoryOverheadCost($phaseId, $category);
                $aggProfitCost = $this->getPhaseProfitCost($phaseId, $category);
                $aggOverheadRate = (($aggOverheadCost > 0) && ($aggBaseCost > 0)) ? round(($aggOverheadCost / $aggBaseCost) * 100) : 0;
                $aggProfitRate = (($aggProfitCost > 0) && ($aggBaseCost > 0)) ? round(($aggProfitCost / $aggBaseCost) * 100) : 0;


                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                ];
            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //}
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getAllProposalServiceLineItemsPhaseNonSubNonTemplate($proposalServiceId, $phaseId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.fees=0 AND  eli.permit=0
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND (eli.template_id=0 OR eli.template_id IS NULL)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @param $proposalId
     * @return array
     */
    public function getProposalSortedLineItemsNonTemplate(Companies $company, $proposalId)
    {
        $allLineItems = $this->getAllProposalLineItemsNonSubNonTemplate($proposalId);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            //if($lineItem->getItemId() != 0){

            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();


            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getCategoryBaseCost($category);

                $aggOverheadCost = $this->getCategoryOverheadCost($category);
                $aggProfitCost = $this->getProfitCost($category);
                $aggOverheadRate = (($aggOverheadCost > 0) && ($aggBaseCost > 0)) ? round(($aggOverheadCost / $aggBaseCost) * 100) : 0;
                $aggProfitRate = (($aggProfitCost > 0) && ($aggBaseCost > 0)) ? round(($aggProfitCost / $aggBaseCost) * 100) : 0;


                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                ];
            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //}
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getAllProposalLineItemsNonSubNonTemplate($proposalId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposal_id
        AND eli.fees=0 AND  eli.permit=0
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND (eli.template_id=0 OR eli.template_id IS NULL)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposalId);

        return $query->getResult();
    }

    /**
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getCategoryBaseCost(EstimationCategory $category)
    {
        //$sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        $sql = "SELECT COALESCE(SUM((eli.total_price - eli.profit_price - eli.overhead_price - eli.tax_price)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getCategoryOverheadCost(EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProfitCost(EstimationCategory $category)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND et.category_id = " . $category->getId();

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param Companies $company
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServiceSortedLineItemsNonTemplate(Companies $company, $proposalServiceId)
    {
        $allLineItems = $this->getAllProposalServiceLineItemsNonSubNonTemplate($proposalServiceId);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            //if($lineItem->getItemId() != 0){

            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();


            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getCategoryBaseCost($category);

                $aggOverheadCost = $this->getCategoryOverheadCost($category);
                $aggProfitCost = $this->getProfitCost($category);
                $aggOverheadRate = (($aggOverheadCost > 0) && ($aggBaseCost > 0)) ? round(($aggOverheadCost / $aggBaseCost) * 100) : 0;
                $aggProfitRate = (($aggProfitCost > 0) && ($aggBaseCost > 0)) ? round(($aggProfitCost / $aggBaseCost) * 100) : 0;


                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                ];
            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //}
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getAllProposalServiceLineItemsNonSubNonTemplate($proposalServiceId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :proposal_service_id
        AND eli.fees=0 AND  eli.permit=0
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND (eli.template_id=0 OR eli.template_id IS NULL)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_service_id', $proposalServiceId);

        return $query->getResult();
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getAllProposalServiceLineItemsPhase($proposalServiceId, $phaseId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @param $phaseId
     * @param $service_id
     * @return array
     */
    public function getPhaseSortedLineItems(Companies $company, $phaseId, $service_id)
    {
        $allLineItems = $this->getAllPhaseLineItems($phaseId, $service_id);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            //if($lineItem->getItemId() != 0){

            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }

            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
                //$lineItem->saved_values=[];
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }
            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getPhaseCategoryBaseCost($phaseId, $category);
                $aggOverheadCost = $this->getPhaseCategoryOverheadCost($phaseId, $category);
                $aggProfitCost = $this->getPhaseProfitCost($phaseId, $category);
                $aggTotalCost = $this->getPhaseTotalCost($phaseId, $category);
                $aggTaxCost = $this->getPhaseTaxCost($phaseId, $category);
                $aggTaxRate = (($aggTaxCost > 0) && ($aggBaseCost)) ? round(($aggTaxCost / $aggBaseCost) * 100) : 0;
                $aggOverheadRate = (($aggBaseCost > 0) && ($aggOverheadCost)) ? round(($aggOverheadCost / $aggBaseCost) * 100) : 0;
                $aggProfitRate = (($aggBaseCost > 0) && ($aggProfitCost > 0)) ? round(($aggProfitCost / $aggBaseCost) * 100) : 0;

                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'aggregateTaxPrice' => $aggTaxCost,
                    'aggregateTaxRate' => $aggTaxRate,
                    'aggregateTotalRate' => $aggTotalCost,
                ];

            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //}
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param Companies $company
     * @param $phaseId
     * @param $service_id
     * @return array
     */
    public function getPhaseSortedLineItemsWithFixedTemplate(Companies $company, $phaseId, $service_id)
    {
        $allLineItems = $this->getAllPhaseLineItems($phaseId, $service_id);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            //if($lineItem->getItemId() != 0){

            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }

            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
                //$lineItem->saved_values=[];
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                continue;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }
            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getPhaseCategoryBaseCostWithFixedTemplate($phaseId, $category);
                $aggOverheadCost = $this->getPhaseCategoryOverheadCostWithFixedTemplate($phaseId, $category);
                $aggProfitCost = $this->getPhaseProfitCostWithFixedTemplate($phaseId, $category);
                $aggTotalCost = $this->getPhaseTotalCostWithFixedTemplate($phaseId, $category);
                $aggTaxCost = $this->getPhaseTaxCostWithFixedTemplate($phaseId, $category);
                $aggTaxRate = (($aggTaxCost > 0) && ($aggBaseCost)) ? round(($aggTaxCost / $aggBaseCost) * 100) : 0;
                $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2)  : 0;
                $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;

                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'aggregateTaxPrice' => $aggTaxCost,
                    'aggregateTaxRate' => $aggTaxRate,
                    'aggregateTotalRate' => $aggTotalCost,
                ];

            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //}
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

        /**
     * @param Companies $company
     * @param $phaseId
     * @param $service_id
     * @return array
     */
    public function getPhaseSortedLineItemsWithoutFixedTemplate(Companies $company, $phaseId, $service_id)
    {
        $allLineItems = $this->getAllPhaseLineItemsWithoutFixedTemplate($phaseId, $service_id);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            //if($lineItem->getItemId() != 0){

            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }

            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
                //$lineItem->saved_values=[];
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                continue;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }
            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getPhaseCategoryBaseCostWithFixedTemplate($phaseId, $category);
                $aggOverheadCost = $this->getPhaseCategoryOverheadCostWithFixedTemplate($phaseId, $category);
                $aggProfitCost = $this->getPhaseProfitCostWithFixedTemplate($phaseId, $category);
                $aggTotalCost = $this->getPhaseTotalCostWithFixedTemplate($phaseId, $category);
                $aggTaxCost = $this->getPhaseTaxCostWithFixedTemplate($phaseId, $category);
                $aggTaxRate = (($aggTaxCost > 0) && ($aggBaseCost)) ? round(($aggTaxCost / $aggBaseCost) * 100) : 0;
                $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2)  : 0;
                $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;

                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'aggregateTaxPrice' => $aggTaxCost,
                    'aggregateTaxRate' => $aggTaxRate,
                    'aggregateTotalRate' => $aggTotalCost,
                ];

            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //}
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getAllPhaseLineItems($phaseId, $service_id)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.proposal_service_id = :service_id
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1";
        //AND (eli.fees=0 OR eli.fees IS NULL)  

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $query->setParameter(':service_id', $service_id);
        return $query->getResult();
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getAllPhaseLineItemsWithoutFixedTemplate($phaseId, $service_id)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.proposal_service_id = :service_id
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0
        AND eli.fixed_template=0";
        //AND (eli.fees=0 OR eli.fees IS NULL)  

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $query->setParameter(':service_id', $service_id);
        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @param $phaseId
     * @return array
     */
    public function getProposalPhaseSortedLineItems(Companies $company, $phaseId)
    {
        $allLineItems = $this->getAllProposalPhaseLineItems($phaseId);
        $out = [];

        foreach ($allLineItems as $lineItem) {
            //if($lineItem->getItemId() != 0){

            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();


            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $lineItem->saved_values = [];
            }

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                $aggBaseCost = $this->getPhaseCategoryBaseCost($phaseId, $category);

                $aggOverheadCost = $this->getPhaseCategoryOverheadCost($phaseId, $category);
                $aggProfitCost = $this->getPhaseProfitCost($phaseId, $category);

                $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;



                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                ];
            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //}
        }

        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];

        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }

        return $sortedOut;
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getAllProposalPhaseLineItems($phaseId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND (eli.sub_id=0 OR eli.sub_id IS NULL) AND eli.is_custom_sub = 0  ";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        return $query->getResult();
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getSubContractorProposalSortedLineItems($proposalId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId
        AND (eli.sub_id >0 OR  eli.is_custom_sub=1)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposalId);

        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getProposalSubContractorBaseCost($proposalId);
            $aggOverheadCost = $this->getProposalSubContractorOverheadCost($proposalId);
            $aggProfitCost = $this->getProposalSubContractorProfitCost($proposalId);
            $aggTotalCost = $this->getProposalSubContractorTotalCost($proposalId);
            $aggTaxCost = $this->getProposalSubContractorTaxCost($proposalId);
            $aggTaxRate = round(($aggTaxCost / $aggBaseCost) * 100);

            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;



            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
                'aggregateTaxPrice' => $aggTaxCost,
                'aggregateTaxRate' => $aggTaxRate,
                'aggregateTotalRate' => $aggTotalCost,
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalSubContractorBaseCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub > 0) ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalSubContractorOverheadCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalSubContractorProfitCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }


    /**
     * @param $proposalServiceId

     * @return mixed
     */
    public function getServiceSubContractorTotalCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }
    /**
     * @param $proposalId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalSubContractorTotalCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }


    /**
     * @param $proposalServiceId

     * @return mixed
     */
    public function getServiceSubContractorTaxCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }
    /**
     * @param $proposalServiceId
     * @param EstimationCategory $category
     * @return mixed
     */
    public function getProposalSubContractorTaxCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

     /**
     * @param $phaseId
     * @return array
     */
    public function getSubContractorServiceSortedLineItems($proposalServiceId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :proposalServiceId
        AND (eli.sub_id >0 OR eli.is_custom_sub=1)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getServiceSubContractorBaseCost($proposalServiceId);
            $aggOverheadCost = $this->getServiceSubContractorOverheadCost($proposalServiceId);
            $aggProfitCost = $this->getServiceSubContractorProfitCost($proposalServiceId);
            $aggTotalCost = $this->getServiceSubContractorTotalCost($proposalServiceId);
            $aggTaxCost = $this->getServiceSubContractorTaxCost($proposalServiceId);
            $aggTaxRate = round(($aggTaxCost / $aggBaseCost) * 100);

            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;



            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
                'aggregateTaxPrice' => $aggTaxCost,
                'aggregateTaxRate' => $aggTaxRate,
                'aggregateTotalRate' => $aggTotalCost,
            ];



            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getSubContractorServiceJobCostItems($proposalServiceId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :proposalServiceId
        AND (eli.sub_id >0 OR eli.is_custom_sub=1)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $out[0] = [
                'items' => [],
                
            ];



            foreach ($allLineItems as $lineItem) {

                $jobCostItem = $this->em->getRepository('models\JobCostItem')->findOneBy(array(
                    'estimate_line_item_id' => $lineItem->getId()
                ));
                $old_line_total = $lineItem->getTotalPrice();
                $old_quantity = $lineItem->getQuantity();
                $lineItem->job_cost = 0;
                $lineItem->job_cost_item_id = 0;
                $lineItem->job_cost_files =[];
                if($jobCostItem){
                    $lineItem->job_cost_item_id = $jobCostItem->getId();
                    $lineItem->setDay($jobCostItem->getDay());
                    $lineItem->setNumPeople($jobCostItem->getNumPeople());
                    $lineItem->setHoursPerDay($jobCostItem->getHpd());
                    $lineItem->setQuantity($jobCostItem->getActualQty());
                    
                    $lineItem->setTotalPrice($jobCostItem->getActualTotalPrice());
                    $lineItem->base_total = $jobCostItem->getActualTotalPrice();
                    $lineItem->job_costing =1;
                    $lineItem->area = $jobCostItem->getArea();
                    $lineItem->depth = $jobCostItem->getDepth();
                    $lineItem->job_cost = 1;
                    $jobCostItemFiles = $this->getJobCostItemFiles($jobCostItem->getId());
                    $lineItem->job_cost_files = $jobCostItemFiles;
                }else{
                    $lineItem->job_costing =0;
                    $lineItem->base_total = ($lineItem->getBasePrice() * $lineItem->getQuantity()) ;
                }
                $lineItem->old_total = $old_line_total;
                $lineItem->old_quantity = $old_quantity;
                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getProposalSubContractorJobCostItems($proposalId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId
        AND (eli.sub_id >0 OR eli.is_custom_sub=1)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposalId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $out[0] = [
                'items' => [],
                
            ];



            foreach ($allLineItems as $lineItem) {

                $jobCostItem = $this->em->getRepository('models\JobCostItem')->findOneBy(array(
                    'estimate_line_item_id' => $lineItem->getId()
                ));
                $old_line_total = $lineItem->getTotalPrice();
                $old_quantity = $lineItem->getQuantity();
                $lineItem->job_cost = 0;
                $lineItem->job_cost_item_id = 0;
                $lineItem->job_cost_files =[];
                if($jobCostItem){
                    $lineItem->job_cost_item_id = $jobCostItem->getId();
                    $lineItem->setDay($jobCostItem->getDay());
                    $lineItem->setNumPeople($jobCostItem->getNumPeople());
                    $lineItem->setHoursPerDay($jobCostItem->getHpd());
                    $lineItem->setQuantity($jobCostItem->getActualQty());
                    
                    $lineItem->setTotalPrice($jobCostItem->getActualTotalPrice());
                    $lineItem->base_total = $jobCostItem->getActualTotalPrice();
                    $lineItem->job_costing =1;
                    $lineItem->area = $jobCostItem->getArea();
                    $lineItem->depth = $jobCostItem->getDepth();
                    $lineItem->act_total = $jobCostItem->getActualTotalPrice();
                    $lineItem->act_qty = $jobCostItem->getActualQty();
                    $lineItem->diff = $jobCostItem->getPriceDifference();
                    $lineItem->job_cost = 1;
                    $jobCostItemFiles = $this->getJobCostItemFiles($jobCostItem->getId());
                    $lineItem->job_cost_files = $jobCostItemFiles;
                }else{
                    $lineItem->job_costing =0;
                    $lineItem->act_total = 0;
                    $lineItem->act_qty = 0;
                    $lineItem->diff = 0;
                    $lineItem->base_total = ($lineItem->getBasePrice() * $lineItem->getQuantity()) ;
                }
                $lineItem->old_total = $old_line_total;
                $lineItem->old_quantity = $old_quantity;
                $out[0]['items'][] = $lineItem;
                //}

            }
        }


        return $out;
    }
    /**
     * @param $phaseId
     * @return mixed
     */
    public function getServiceSubContractorBaseCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getServiceSubContractorOverheadCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getServiceSubContractorProfitCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }


    /**
     * @param $phaseId
     * @return array
     */
    public function getSubContractorPhaseSortedLineItems($phaseId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND (eli.sub_id >0 OR eli.is_custom_sub=1)";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getPhaseSubContractorBaseCost($phaseId);
            $aggOverheadCost = $this->getPhaseSubContractorOverheadCost($phaseId);
            $aggProfitCost = $this->getPhaseSubContractorProfitCost($phaseId);
            $aggTotalCost = $this->getPhaseSubContractorTotalCost($phaseId);
            $aggTaxCost = $this->getPhaseSubContractorTaxCost($phaseId);
            $aggTaxRate = round(($aggTaxCost / $aggBaseCost) * 100);
            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;

            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
                'aggregateTaxPrice' => $aggTaxCost,
                'aggregateTaxRate' => $aggTaxRate,
                'aggregateTotalRate' => $aggTotalCost,
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }





        }


        return $out;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseSubContractorBaseCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseSubContractorOverheadCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseSubContractorTaxCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }
    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseSubContractorTotalCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }
    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseSubContractorProfitCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposal_service_id
     * @return array
     */
    public function getTemplateSortedLineItems($proposal_service_id)
    {

        $sql = "SELECT eli.template_id
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :proposal_service_id
        AND eli.template_id >0
        GROUP BY  eli.template_id";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':proposal_service_id', $proposal_service_id);
        $allTemplateIds = $query->getResult();
        $out = [];

        foreach ($allTemplateIds as $allTemplateId) {

            $template_id = $allTemplateId['template_id'];
            $dql = "SELECT eli
            FROM \models\EstimationLineItem eli
            WHERE eli.proposal_service_id = :proposal_service_id
            AND eli.template_id = :templateId
            AND eli.fixed_template !=1";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':proposal_service_id', $proposal_service_id);
            $query->setParameter(':templateId', $template_id);

            $allLineItems = $query->getResult();
            //$out[$allTemplateId->template_id] = [];
            if (count($allLineItems) > 0) {


                $aggBaseCost = $this->getTemplateBaseCost($proposal_service_id);
                $aggOverheadCost = $this->getTemplateOverheadCost($proposal_service_id);
                $aggProfitCost = $this->getTemplateProfitCost($proposal_service_id);
                $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;

                $template = $this->em->find('\models\EstimationTemplate', $allTemplateId['template_id']);
                $out[$allTemplateId['template_id']] = [
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'template_name' => $template->getName(),

                ];
                foreach ($allLineItems as $lineItem) {


                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }
            }

        }
        return $out;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getTemplateBaseCost($proposal_service_id)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposal_service_id . "
        AND eli.template_id > 0";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getTemplateOverheadCost($proposal_service_id)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposal_service_id . "
        AND eli.template_id > 0";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getTemplateProfitCost($proposal_service_id)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposal_service_id . "
        AND eli.template_id > 0";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getProposalTemplateSortedLineItems($proposalId)
    {

        $sql = "SELECT eli.template_id
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId
        AND eli.template_id >0
        GROUP BY  eli.template_id";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':proposalId', $proposalId);
        $allTemplateIds = $query->getResult();
        $out = [];

        foreach ($allTemplateIds as $allTemplateId) {

            $template_id = $allTemplateId['template_id'];
            $dql = "SELECT eli
            FROM \models\EstimationLineItem eli
            WHERE eli.proposal_id = :proposalId
            AND eli.template_id = :templateId
            AND eli.fixed_template !=1";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':proposalId', $proposalId);
            $query->setParameter(':templateId', $template_id);

            $allLineItems = $query->getResult();
            //$out[$allTemplateId->template_id] = [];
            if (count($allLineItems) > 0) {


                $aggBaseCost = $this->getProposalTemplateBaseCost($proposalId);
                $aggOverheadCost = $this->getProposalTemplateOverheadCost($proposalId);
                $aggProfitCost = $this->getProposalTemplateProfitCost($proposalId);
                $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;

                $template = $this->em->find('\models\EstimationTemplate', $allTemplateId['template_id']);
                $out[$allTemplateId['template_id']] = [
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'template_name' => $template->getName(),

                ];
                foreach ($allLineItems as $lineItem) {


                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }
            }

        }
        return $out;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalTemplateBaseCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.template_id > 0";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalTemplateOverheadCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.template_id > 0";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalTemplateProfitCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.template_id > 0";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getTemplatePhaseSortedLineItems($phaseId)
    {

        $sql = "SELECT eli.template_id
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.template_id >0
        GROUP BY  eli.template_id";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':phaseId', $phaseId);
        $allTemplateIds = $query->getResult();
        $out = [];

        foreach ($allTemplateIds as $allTemplateId) {

            $template_id = $allTemplateId['template_id'];
            $dql = "SELECT eli
            FROM \models\EstimationLineItem eli
            WHERE eli.phase_id = :phaseId
            AND eli.template_id = :templateId
            AND eli.fixed_template !=1";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':phaseId', $phaseId);
            $query->setParameter(':templateId', $template_id);

            $allLineItems = $query->getResult();
            //$out[$allTemplateId->template_id] = [];
            if (count($allLineItems) > 0) {


                $aggBaseCost = $this->getPhaseTemplateBaseCost($phaseId, $template_id);
                $aggOverheadCost = $this->getPhaseTemplateOverheadCost($phaseId, $template_id);
                $aggProfitCost = $this->getPhaseTemplateProfitCost($phaseId, $template_id);
                $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;


                $template = $this->em->find('\models\EstimationTemplate', $allTemplateId['template_id']);
                $out[$allTemplateId['template_id']] = [
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'template_name' => $template->getName(),
                    'is_fixed_template' => 0,
                ];
                $is_fixed_template = false;
                foreach ($allLineItems as $lineItem) {

                    if ($lineItem->getFixedTemplate() == 2) {
                        $is_fixed_template = true;
                    }
                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }

                if ($is_fixed_template) {
                    $sql = "SELECT eli.total_price
                    FROM estimate_line_items eli
                    WHERE eli.phase_id = " . (int)$phaseId . "
                    AND eli.template_id =" . $template_id . "
                    AND eli.fixed_template = 1";

                    $result = $this->getSingleResult($sql);
                    $out[$allTemplateId['template_id']]['is_fixed_template'] = 1;
                    $out[$allTemplateId['template_id']]['fixed_template_total'] = $result->total_price;

                }
            }

        }
        return $out;
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getTemplatePhaseItemSummaryLineItems($phaseId)
    {

        $sql = "SELECT eli.template_id
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.template_id >0
        GROUP BY  eli.template_id";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':phaseId', $phaseId);
        $allTemplateIds = $query->getResult();
        $out = [];

        foreach ($allTemplateIds as $allTemplateId) {
            $is_fixed_template = false;

            $template_id = $allTemplateId['template_id'];
            $dql = "SELECT eli
            FROM \models\EstimationLineItem eli
            WHERE eli.phase_id = :phaseId
            AND eli.template_id = :templateId
            AND eli.fixed_template !=1";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':phaseId', $phaseId);
            $query->setParameter(':templateId', $template_id);

            $allLineItems = $query->getResult();
            //$out[$allTemplateId->template_id] = [];

            $aggBaseCost = $this->getPhaseTemplateBaseCost($phaseId, $template_id);
                $aggOverheadCost = $this->getPhaseTemplateOverheadCost($phaseId, $template_id);
                $aggProfitCost = $this->getPhaseTemplateProfitCost($phaseId, $template_id);
                $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;


                $template = $this->em->find('\models\EstimationTemplate', $allTemplateId['template_id']);
                $out[$allTemplateId['template_id']] = [
                    'items' => [],
                    'aggregateBaseCost' => $aggBaseCost,
                    'aggregateOverheadPrice' => $aggOverheadCost,
                    'aggregateProfitPrice' => $aggProfitCost,
                    'aggregateOverheadRate' => $aggOverheadRate,
                    'aggregateProfitRate' => $aggProfitRate,
                    'template_name' => $template->getName(),
                    'is_fixed_template' => 0,
                ];
            if (count($allLineItems) > 0) {

                foreach ($allLineItems as $lineItem) {

                    if ($lineItem->getFixedTemplate() == 2) {
                        $is_fixed_template = true;
                    }
                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }
                $out[$allTemplateId['template_id']]['is_empty_template'] = 0;
                //if ($is_fixed_template) {
                   

                //}
            }else{
                $is_fixed_template = true;
                $dql = "SELECT eli
                FROM \models\EstimationLineItem eli
                WHERE eli.phase_id = :phaseId
                AND eli.template_id = :templateId
                AND eli.fixed_template =1";
    
                $query = $this->em->createQuery($dql);
                $query->setParameter(':phaseId', $phaseId);
                $query->setParameter(':templateId', $template_id);
    
                $allLineItems = $query->getResult();
                foreach ($allLineItems as $lineItem) {

                    
                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }
                $out[$allTemplateId['template_id']]['is_empty_template'] = 1;
            }
            if ($is_fixed_template) {
                $sql = "SELECT eli.total_price
                FROM estimate_line_items eli
                WHERE eli.phase_id = " . (int)$phaseId . "
                AND eli.template_id =" . $template_id . "
                AND eli.fixed_template = 1";

                $result = $this->getSingleResult($sql);
                $out[$allTemplateId['template_id']]['is_fixed_template'] = 1;
                $out[$allTemplateId['template_id']]['fixed_template_total'] = $result->total_price;
            }else{
                $out[$allTemplateId['template_id']]['is_fixed_template'] = 0;
            }

        }
        return $out;
    }

    /**
     * @param $proposal_service_id
     * @return array
     */
    public function getServiceTemplateSortedItemSummaryLineItems($proposal_service_id)
    {

        $sql = "SELECT eli.template_id
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :proposal_service_id
        AND eli.template_id >0
        GROUP BY  eli.template_id";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':proposal_service_id', $proposal_service_id);
        $allTemplateIds = $query->getResult();
        $out = [];

        foreach ($allTemplateIds as $allTemplateId) {
            $is_fixed_template = false;

            $template_id = $allTemplateId['template_id'];
            $dql = "SELECT eli
            FROM \models\EstimationLineItem eli
            WHERE eli.proposal_service_id = :proposal_service_id
            AND eli.template_id = :templateId
            AND eli.fixed_template !=1";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':proposal_service_id', $proposal_service_id);
            $query->setParameter(':templateId', $template_id);

            $allLineItems = $query->getResult();
            $aggBaseCost = $this->getServiceTemplateBaseCost($proposal_service_id,$template_id);
            $aggOverheadCost = $this->getServiceTemplateOverheadCost($proposal_service_id,$template_id);
            $aggProfitCost = $this->getServiceTemplateProfitCost($proposal_service_id,$template_id);
            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;

            $template = $this->em->find('\models\EstimationTemplate', $allTemplateId['template_id']);
            $out[$allTemplateId['template_id']] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
                'template_name' => $template->getName(),

            ];

            if (count($allLineItems) > 0) {

                
                foreach ($allLineItems as $lineItem) {

                    if ($lineItem->getFixedTemplate() == 2) {
                        $is_fixed_template = true;
                    }
                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }
                $out[$allTemplateId['template_id']]['is_empty_template'] = 0;

                
            }else{

                $is_fixed_template = true;
                $dql = "SELECT eli
                FROM \models\EstimationLineItem eli
                WHERE eli.proposal_service_id = :serviceId
                AND eli.template_id = :templateId
                AND eli.fixed_template =1";
    
                $query = $this->em->createQuery($dql);
                $query->setParameter(':serviceId', $proposal_service_id);
                $query->setParameter(':templateId', $template_id);
    
                $allLineItems = $query->getResult();
                foreach ($allLineItems as $lineItem) {

                    
                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }
                $out[$allTemplateId['template_id']]['is_empty_template'] = 1;

            }

            if ($is_fixed_template) {
                $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS total_price
                FROM estimate_line_items eli
                WHERE eli.proposal_service_id = " . (int)$proposal_service_id . "
                AND eli.template_id =" . $template_id . "
                AND eli.fixed_template = 1";

                $result = $this->getSingleResult($sql);
                $out[$allTemplateId['template_id']]['is_fixed_template'] = 1;
                $out[$allTemplateId['template_id']]['fixed_template_total'] = $result->total_price;
            }else{
                $out[$allTemplateId['template_id']]['is_fixed_template'] = 0;
            }

        }
        return $out;
    }

    /**
     * @param $proposal_service_id
     * @return array
     */
    public function getProposalTemplateSortedItemSummaryLineItems($proposal_id)
    {

        $sql = "SELECT eli.template_id
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposal_id
        AND eli.template_id >0
        GROUP BY  eli.template_id";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':proposal_id', $proposal_id);
        $allTemplateIds = $query->getResult();
        $out = [];

        foreach ($allTemplateIds as $allTemplateId) {
            $is_fixed_template = false;

            $template_id = $allTemplateId['template_id'];
            $dql = "SELECT eli
            FROM \models\EstimationLineItem eli
            WHERE eli.proposal_id = :proposal_id
            AND eli.template_id = :templateId
            AND eli.fixed_template !=1";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':proposal_id', $proposal_id);
            $query->setParameter(':templateId', $template_id);

            $allLineItems = $query->getResult();
            $aggBaseCost = $this->getProposalTemplateIdBaseCost($proposal_id,$template_id);
            $aggOverheadCost = $this->getProposalTemplateIdOverheadCost($proposal_id,$template_id);
            $aggProfitCost = $this->getProposalTemplateIdProfitCost($proposal_id,$template_id);
            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;

            $template = $this->em->find('\models\EstimationTemplate', $allTemplateId['template_id']);
            $out[$allTemplateId['template_id']] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
                'template_name' => $template->getName(),

            ];

            if (count($allLineItems) > 0) {

                
                foreach ($allLineItems as $lineItem) {

                    if ($lineItem->getFixedTemplate() == 2) {
                        $is_fixed_template = true;
                    }
                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }
                $out[$allTemplateId['template_id']]['is_empty_template'] = 0;

                
            }else{

                $is_fixed_template = true;
                $dql = "SELECT eli
                FROM \models\EstimationLineItem eli
                WHERE eli.proposal_id = :proposalId
                AND eli.template_id = :templateId
                AND eli.fixed_template =1";
    
                $query = $this->em->createQuery($dql);
                $query->setParameter(':proposalId', $proposal_id);
                $query->setParameter(':templateId', $template_id);
    
                $allLineItems = $query->getResult();
                foreach ($allLineItems as $lineItem) {

                    
                    $out[$allTemplateId['template_id']]['items'][] = $lineItem;

                    //}
                }
                $out[$allTemplateId['template_id']]['is_empty_template'] = 1;

            }

            if ($is_fixed_template) {
                $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS total_price
                FROM estimate_line_items eli
                WHERE eli.proposal_id = " . (int)$proposal_id . "
                AND eli.template_id =" . $template_id . "
                AND eli.fixed_template = 1";

                $result = $this->getSingleResult($sql);
                $out[$allTemplateId['template_id']]['is_fixed_template'] = 1;
                $out[$allTemplateId['template_id']]['fixed_template_total'] = $result->total_price;
            }else{
                $out[$allTemplateId['template_id']]['is_fixed_template'] = 0;
            }

        }
        return $out;
    }

    public function getProposalTemplateIdBaseCost($proposal_id, $template_id)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposal_id . "
        AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    public function getProposalTemplateIdOverheadCost($proposal_id, $template_id)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposal_id . "
        AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    public function getProposalTemplateIdProfitCost($proposal_id, $template_id)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposal_id . "
        AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }



    public function getServiceTemplateBaseCost($proposal_service_id, $template_id)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposal_service_id . "
        AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    public function getServiceTemplateOverheadCost($proposal_service_id, $template_id)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposal_service_id . "
        AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    public function getServiceTemplateProfitCost($proposal_service_id, $template_id)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$proposal_service_id . "
        AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }


    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseTemplateBaseCost($phaseId, $template_id)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseTemplateOverheadCost($phaseId, $template_id)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
         AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseTemplateProfitCost($phaseId, $template_id)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
         AND eli.template_id =" . $template_id;

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $serviceId
     * @return array
     */
    public function getFeesServiceSortedLineItems($serviceId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :serviceId
        AND eli.fees =1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':serviceId', $serviceId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getServiceFeesBaseCost($serviceId);

            $aggOverheadCost = $this->getServiceFeesOverheadCost($serviceId);
            $aggProfitCost = $this->getServiceFeesProfitCost($serviceId);

            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;



            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $serviceId
     * @return mixed
     */
    public function getServiceFeesBaseCost($serviceId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$serviceId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $serviceId
     * @return mixed
     */
    public function getServiceFeesOverheadCost($serviceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$serviceId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $serviceId
     * @return mixed
     */
    public function getServiceFeesProfitCost($serviceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$serviceId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getFeesProposalSortedLineItems($proposalId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId
        AND eli.fees =1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposalId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getProposalFeesBaseCost($proposalId);

            $aggOverheadCost = $this->getProposalFeesOverheadCost($proposalId);
            $aggProfitCost = $this->getProposalFeesProfitCost($proposalId);

            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;


            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalFeesBaseCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalFeesOverheadCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalFeesProfitCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getPermitProposalSortedLineItems($proposalId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId
        AND eli.permit =1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposalId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getProposalPermitBaseCost($proposalId);

            $aggOverheadCost = $this->getProposalPermitOverheadCost($proposalId);
            $aggProfitCost = $this->getProposalPermitProfitCost($proposalId);
            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;



            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getDisposalProposalSortedLineItems($proposalId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId
        AND eli.disposal_load_check =1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposalId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            

            $out[0] = [
                'items' => [],
                
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }
    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalPermitBaseCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalPermitOverheadCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalPermitProfitCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getFeesPhaseSortedLineItems($phaseId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.fees =1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $allLineItems = $query->getResult();
        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getPhaseFeesBaseCost($phaseId);

            $aggOverheadCost = $this->getPhaseFeesOverheadCost($phaseId);
            $aggProfitCost = $this->getPhaseFeesProfitCost($phaseId);

            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;



            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseFeesBaseCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseFeesOverheadCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseFeesProfitCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND eli.fees = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $serviceId
     * @return array
     */
    public function getPermitServiceSortedLineItems($serviceId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :serviceId
        AND eli.permit = 1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':serviceId', $serviceId);
        $allLineItems = $query->getResult();

        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getServicePermitBaseCost($serviceId);
            $aggOverheadCost = $this->getServicePermitOverheadCost($serviceId);
            $aggProfitCost = $this->getServicePermitProfitCost($serviceId);

            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;


            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $serviceId
     * @return array
     */
    public function getDisposalServiceSortedLineItems($serviceId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_service_id = :serviceId
        AND eli.disposal_load_check = 1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':serviceId', $serviceId);
        $allLineItems = $query->getResult();

        $out = [];
        if (count($allLineItems) > 0) {


           

            $out[0] = [
                'items' => [],
                
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $serviceId
     * @return mixed
     */
    public function getServicePermitBaseCost($serviceId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$serviceId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $serviceId
     * @return mixed
     */
    public function getServicePermitOverheadCost($serviceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$serviceId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $serviceId
     * @return mixed
     */
    public function getServicePermitProfitCost($serviceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.proposal_service_id = " . (int)$serviceId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return array
     */
    public function getPermitPhaseSortedLineItems($phaseId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.permit = 1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $allLineItems = $query->getResult();

        $out = [];
        if (count($allLineItems) > 0) {


            $aggBaseCost = $this->getPhasePermitBaseCost($phaseId);
            $aggOverheadCost = $this->getPhasePermitOverheadCost($phaseId);
            $aggProfitCost = $this->getPhasePermitProfitCost($phaseId);

            $aggOverheadRate = (($aggBaseCost != 0) && ($aggOverheadCost !=0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
            $aggProfitRate = (($aggBaseCost != 0) && ($aggProfitCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;


            $out[0] = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

        /**
     * @param $phaseId
     * @return array
     */
    public function getDisposalPhaseSortedLineItems($phaseId)
    {

        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.phase_id = :phaseId
        AND eli.disposal_load_check = :disposalValue";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phaseId', $phaseId);
        $query->setParameter(':disposalValue', 1);
        //die($query->getSQL());
        $allLineItems = $query->getResult();

        $out = [];
        if (count($allLineItems) > 0) {




            $out[0] = [
                'items' => [],
                
            ];
            foreach ($allLineItems as $lineItem) {

                $out[0]['items'][] = $lineItem;
                //}
            }
        }


        return $out;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhasePermitBaseCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);
        //$result->totalPrice; die;
        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhasePermitOverheadCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhasePermitProfitCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND eli.permit = 1";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    /**
     * @param $proposal_service_id
     * @return mixed
     */
    public function get_base_proposal_service_total($proposal_service_id)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE  eli.proposal_service_id = :proposalServiceId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposal_service_id);
        $results = $query->getResult();
        $total = 0;
        foreach ($results as $results) {
            $qun = $results->getQuantity();
            $pr = $results->getBasePrice();
            $temp_total = $qun * $pr;
            $total = $total + $temp_total;
        }
        return $total;
    }

    /**
     * @param $serviceId
     * @return array
     */
    public function getDefaultStages($serviceId)
    {
        $dql = "SELECT eds FROM models\EstimateDefaultStage eds
                WHERE eds.service_id = :serviceId
                AND eds.company_id IS NULL
                ORDER BY eds.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':serviceId', $serviceId);

        return $query->getResult();
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getProposalPriceBreakdown($proposalId)
    {
        $sql = "SELECT
        COALESCE(SUM(eli.total_price ), 0.00) AS basePrice,
        COALESCE(SUM(eli.total_price), 0.00) AS totalPrice,
        COALESCE(SUM(eli.profit_price), 0.00) AS profitPrice,
        COALESCE(SUM(eli.overhead_price), 0.00) AS overheadPrice,
        COALESCE(SUM(eli.tax_price), 0.00) AS taxPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_id = " . (int)$proposalId;

        $result = $this->getSingleResult($sql);

        return [
            'basePrice' => $result->basePrice - $result->profitPrice - $result->overheadPrice - $result->taxPrice,
            'totalPrice' => $result->totalPrice,
            'profitPrice' => $result->profitPrice,
            'overheadPrice' => $result->overheadPrice,
            'taxPrice' => $result->taxPrice
        ];

    }

    public function getCalculationTypes()
    {
        $dql = "SELECT ect FROM models\EstimateCalculationType ect
                ORDER BY ect.id ASC";

        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    /**
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServicePriceBreakdown($proposalServiceId)
    {
        $sql = "SELECT
        COALESCE(SUM(eli.total_price), 0.00) AS basePrice,
        COALESCE(SUM(eli.total_price), 0.00) AS totalPrice,
        COALESCE(SUM(eli.profit_price), 0.00) AS profitPrice,
        COALESCE(SUM(eli.overhead_price), 0.00) AS overheadPrice,
        COALESCE(SUM(eli.tax_price), 0.00) AS taxPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId;

        $result = $this->getSingleResult($sql);

        return [
            'basePrice' => $result->basePrice - $result->profitPrice - $result->overheadPrice,
            'totalPrice' => $result->totalPrice,
            'profitPrice' => $result->profitPrice,
            'overheadPrice' => $result->overheadPrice,
            'taxPrice' => $result->taxPrice
        ];
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getSubcontractors(Companies $company)
    {
        $dql = "SELECT esc FROM models\EstimateSubContractor esc
                WHERE esc.company_id = :companyId
                ORDER BY esc.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getActiveSubcontractors(Companies $company)
    {
        $dql = "SELECT esc FROM models\EstimateSubContractor esc
                WHERE esc.company_id = :companyId
                AND esc.deleted = 0
                ORDER BY esc.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        return $query->getResult();
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getUncompletedEstimate($proposalId)
    {

        $sql = "SELECT COUNT(ep.id) AS uncomplete
        FROM estimation_phases ep
        WHERE ep.proposal_id = '$proposalId'
        AND ep.complete =0";

        $result = $this->getSingleResult($sql);
        return $result->uncomplete;
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getEstimateProposalSubContractors($proposalId)
    {
        $sql = "SELECT DISTINCT(eli.sub_id) AS subId
        FROM estimate_line_items eli
        WHERE eli.proposal_id = '$proposalId'
        AND (eli.sub_id > 0 OR eli.is_custom_sub>0)";

        $results = $this->getAllResults($sql);

        $subs = [];

        foreach ($results as $result) {
            $sub = $this->em->findEstimateSubContractor($result->subId);

            if ($sub) {
                $subs[] = $sub;
            }
        }

        return $subs;
    }

    /**
     * @param $measuremnt
     * @param $depth
     * @param $item_base_price
     * @param $overheadRate
     * @param $profitRate
     * @param $taxRate
     * @param $measurement_unit
     * @return array
     */
    public function calculate_measurement($measuremnt, $depth, $item_base_price, $overheadRate, $profitRate, $taxRate, $measurement_unit)
    {

        if ($measurement_unit == 'square feet') {
            $measuremnt = ($measuremnt / 9);
        }
        $quantity = $measuremnt * (0.055 * $depth);

        $tempoverheadPrice = (($item_base_price * $overheadRate) / 100);
        $tempprofitPrice = (($item_base_price * $profitRate) / 100);
        $overheadPrice = $tempoverheadPrice * $quantity;
        $profitPrice = $tempprofitPrice * $quantity;

        $item_price = $item_base_price + $tempoverheadPrice + $tempprofitPrice;
        $temp_total = $quantity * $item_price;

        $temptaxPrice = (($temp_total * $taxRate) / 100);
        $cost_per_unit = $temp_total / $measuremnt;
        $total = $temp_total + $temptaxPrice;
        return [
            'item_price' => $item_price,
            'quantity' => $quantity,
            'cost_per_yard' => $cost_per_unit,
            'profitPrice' => $profitPrice,
            'overheadPrice' => $overheadPrice,
            'taxPrice' => $temptaxPrice,
            'total' => $total,
        ];


    }

    /**
     * @param $measuremnt
     * @param $depth
     * @param $item_base_price
     * @param $overheadRate
     * @param $profitRate
     * @param $taxRate
     * @param $measurement_unit
     * @param $lineItemId
     */
    public function calculate_measurement_save($measuremnt, $depth, $item_base_price, $overheadRate, $profitRate, $taxRate, $measurement_unit, $lineItemId)
    {


        if ($measurement_unit == 'square feet') {
            $measuremnt = ($measuremnt / 9);
        }
        $quantity = $measuremnt * (0.055 * $depth);

        $tempoverheadPrice = (($item_base_price * $overheadRate) / 100);
        $tempprofitPrice = (($item_base_price * $profitRate) / 100);
        $overheadPrice = $tempoverheadPrice * $quantity;
        $profitPrice = $tempprofitPrice * $quantity;

        $item_price = $item_base_price + $tempoverheadPrice + $tempprofitPrice;
        $temp_total = $quantity * $item_price;

        $temptaxPrice = (($temp_total * $taxRate) / 100);
        $cost_per_unit = $temp_total / $measuremnt;
        $total = $temp_total + $temptaxPrice;
        // return [
        //     'item_price' => $item_price,
        //     'quantity' => $quantity,
        //     'cost_per_yard' => $cost_per_unit,
        //     'profitPrice' => $profitPrice,
        //     'overheadPrice' => $overheadPrice,
        //     'taxPrice' => $temptaxPrice,
        //     'total' => $total,
        // ];
        $eli = $this->em->findEstimationLineItem($lineItemId);
        // Unit Price
        $eli->setOverheadPrice($overheadPrice);
        $eli->setProfitPrice($profitPrice);
        $eli->setTaxPrice($temptaxPrice);
        // Custom Unit Price - 0 or 1

        // Quantity
        $eli->setQuantity($quantity);
        // Total Price
        $eli->setTotalPrice($total);
        // Save it
        $this->em->persist($eli);

        // Flush to DB
        $this->em->flush();
    }

    /**
     * @param $lineItemId
     */
    public function UpdateChildItemAsPerentUpdated($lineItemId)
    {
        $dql = "UPDATE \models\EstimationLineItem eli
        SET eli.parent_updated = :parent_updated
        WHERE eli.parent_line_item_id = :parent_line_item_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parent_updated', '1');
        $query->setParameter(':parent_line_item_id', $lineItemId);
        $query->execute();
    }

    /**
     * @param $lineItemId
     */
    public function UpdateChildItemAsPerentUpdated2($lineItemId)
    {
        $dql = "UPDATE \models\EstimationLineItem eli
        SET eli.parent_updated = :parent_updated
        WHERE eli.parent_line_item_id = :parent_line_item_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parent_updated', '0');
        $query->setParameter(':parent_line_item_id', $lineItemId);
        $query->execute();
    }

    /**
     * @param $lineItemId
     * @return array
     */
    public function getChildTruckingItems($lineItemId)
    {
        $sql = "SELECT eli.*
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei
        ON eli.item_id = ei.id
        WHERE ei.type_id = 20
        AND eli.parent_line_item_id = " . $lineItemId;
        return $this->getAllResults($sql);
    }

    /**
     * @param $lineItemId
     * @return array
     */
    public function getSealcoatDefualtChildItems($lineItemId)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.parent_line_item_id = :parent_line_item_id
        AND eli.child_material =1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parent_line_item_id', $lineItemId);

        return $query->getResult();
    }

    /**
     * @param $companyId
     */
    public function defaultCategoryServiceAssignment($companyId)
    {
        // Materials
        $baseAsphalt = 27;
        $asphalt = 1;
        $gravel = 5;
        $concrete = 2;
        $leveling = 31;
        $pavementSealer = 10;
        $sealerAdditive = 11;
        $sealerSand = 12;
        $paint = 25;
        $crackSealer = 32;

        // Equipment (Excludes Universal)
        $millMachines = 17;
        $pavers = 16;
        $compactors = 33;
        $excavators = 6;
        $skidSteers = 7;
        $sealcoatTanks = 39;

        // These types apply to all service categories
        $universalEstimatingTypes = [
            3,      // Support Trucks
            34,     // Hardware
            36,     // Sweepers
            37,     // Transport
            38,     // Rentals
            9,      // Foreman
            18,     // Superintendent
            8,      // Skilled Labor
            4,      // Unskilled Labor
            20,     // Trucking
            21      // Traffic Management
        ];

        // Service Categories with assigned types, excluding universal
        $serviceCategories = [
            30 => [     // Paving
                // Materials
                $asphalt, $baseAsphalt, $gravel, $leveling,
                // Equipment
                $millMachines, $pavers, $compactors, $excavators, $skidSteers
            ],
            7 => [      // Asphalt Repair
                $asphalt, $baseAsphalt, $gravel, $leveling,
                $millMachines, $pavers, $compactors, $excavators, $skidSteers
            ],
            5 => [      // Sealcoating
                $pavementSealer, $sealerAdditive, $sealerSand,
                $sealcoatTanks
            ],
            49 => [     // Concrete
                $gravel, $concrete, $leveling,
                $millMachines, $pavers, $compactors, $excavators, $skidSteers
            ],
            2 => [      // Line Striping
                $paint,
            ],
            37 => [     // Crack Sealing
                $crackSealer
            ],
            45 => [     // Curb
                $gravel, $concrete,
                $excavators, $skidSteers
            ],
            21 => [     // Drainage
                $asphalt, $baseAsphalt, $gravel, $concrete, $leveling,
                $compactors, $excavators, $skidSteers
            ],
            54 => [     // Pavement Milling
                $leveling
            ],
            82 => [     // Sweeping
                $skidSteers
            ],
            112 => [     // Grading
                $asphalt, $baseAsphalt, $gravel, $leveling,
                $compactors, $excavators, $skidSteers
            ],
        ];

        $finalAssignments = [];

        // Merge specified with universal
        foreach ($serviceCategories as $k => $serviceCategory) {
            $merged = array_merge($serviceCategory, $universalEstimatingTypes);
            $finalAssignments[$k] = $merged;
        }

        // Now save them all for this company
        foreach ($finalAssignments as $serviceId => $types) {

            // Loop through each type in the array
            foreach ($types as $typeId) {
                // Save the record
                $companyServiceType = new EstimationCompanyServiceType();
                $companyServiceType->setCompany($companyId);
                $companyServiceType->setServiceId($serviceId);
                $companyServiceType->setTypeId($typeId);
                $this->em->persist($companyServiceType);
            }
        }
        // Flsuh to DB
        $this->em->flush();
    }

    /**
     * @param Companies $company
     * @param EstimationType $type
     */
    public function assignNewEstimatingType(Companies $company, EstimationType $type)
    {
        $categories = $company->getCategories();

        foreach ($categories as $category) {
            $companyServiceType = new EstimationCompanyServiceType();
            $companyServiceType->setCompany($company->getCompanyId());
            $companyServiceType->setServiceId($category->getServiceId());
            $companyServiceType->setTypeId($type->getId());
            $this->em->persist($companyServiceType);
        }
        $this->em->flush();
    }

    /**
     * Returns a count of line items belonging to a proposal service
     * @param $proposalId
     * @return array
     */
    public function getProposalEstimateLineItemsCount($proposalId)
    {
        $sql = "SELECT COUNT(eli.id) AS numLineItems
        FROM estimate_line_items eli
        WHERE eli.proposal_id = '$proposalId'";

        $result = $this->getSingleResult($sql);

        return $result->numLineItems;
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        $dql = "SELECT es
        FROM \models\EstimateStatus es
        ORDER BY es.id ASC";

        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

        /**
     * @return array
     */
    public function getJobCostStatuses()
    {
        $dql = "SELECT es
        FROM \models\JobCostStatus es
        ORDER BY es.id ASC";

        $query = $this->em->createQuery($dql);
        //Cache It
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_JOB_COST_STATUS);
        return $query->getResult();
    }

    /**
     * @return array
     */
    public function getUpdateableEstimateStatuses()
    {
        $out = [
            $this->em->findEstimateStatus(EstimateStatus::IN_PROGRESS),
            $this->em->findEstimateStatus(EstimateStatus::ALL_SERVICES_ESTIMATED),
            $this->em->findEstimateStatus(EstimateStatus::COMPLETE),
        ];

        return $out;
    }

    /**
     * Apply price changes to affected line items
     * @param Accounts $account
     * @param $statusId
     * @param EstimationItem $oldItem
     * @param EstimationItem $newItem
     */
    public function applyItemChanges(Accounts $account, $statusId, EstimationItem $oldItem, EstimationItem $newItem)
    {
        // Get the proposals for the user's company, based on estimate status
        $proposals = $this->getEstimationRepository()->getCompanyProposalsByEstimateStatus($account->getCompany(), $statusId);

        // Loop through each proposal
        foreach ($proposals as $proposal) {
            /* @var Proposals $proposal */
            
            // Retrieve relevant line items
            $lineItems = $this->getEstimateLineItemsByProposalAndItem($proposal->getProposalId(), $newItem->getId());

            // Loop through each item
            foreach ($lineItems as $lineItem) {
                /* @var EstimationLineItem $lineItem */

                // Only non sub items
                if ($lineItem->getSubId() == 0) {

                    // Logging Info
                    $addLog = false;
                    $logMessage = '<strong>Item Adjusted by Price Update</strong><br /><br />' .
                        '<strong>' . $lineItem->getItem()->getName() . "</strong> item updated in " . $lineItem->getProposalService()->getServiceName() . '<br/>';

                    // Adjust PM/OH rate based on proposal setting
                    if ($proposal->getEstimateCalculationType() == 2) {

                        $ohRate = $newItem->getOverheadRate();
                        $pmRate = $newItem->getProfitRate();

                        if ($pmRate != $lineItem->getProfitRate()) {
                            $logMessage .= '<strong>PM Rate:</strong> From ' . number_format($lineItem->getProfitRate(), 2) . '% to ' . number_format($newItem->getProfitRate(), 2) . '%';
                            $logMessage .= ' <br/>';
                            $addLog = true;
                        }
                        if ($ohRate != $lineItem->getOverheadRate()) {
                            $logMessage .= '<strong>OH Rate from:</strong> From' . number_format($lineItem->getOverheadRate(), 2) . '% to ' . number_format($newItem->getOverheadRate(), 2) . '%';
                            $logMessage .= '<br/>';
                            $addLog = true;
                        }

                    } else {
                        $ohRate = $lineItem->getOverheadRate();
                        $pmRate = $lineItem->getProfitRate();
                    };

                    // Base Price
                    if ($oldItem->getBasePrice() != $newItem->getBasePrice()) {
                        //$logMessage .='<strong>Base Price:</strong> From $' . number_format($lineItem->getBasePrice(), 2) . ' to $' . number_format($newItem->getBasePrice(), 2). '';
                        //$logMessage .='<br/>';
                        $addLog = true;
                    }

                    // Calculate new Price
                    // Base Price is the new unit price * qty
                    $itemBasePrice = ($newItem->getBasePrice() * $lineItem->getQuantity());
                    // Get OH unit rate
                    $itemUnitOhRate = $newItem->getBasePrice() * ($ohRate / 100);
                    // Calculate the OH price
                    $itemOhPrice = $itemBasePrice * ($ohRate / 100);
                    // Get PM unit rate
                    $itemUnitPmRate = $newItem->getBasePrice() * ($pmRate / 100);
                    // Calculate the PM price
                    $itemPmPrice = $itemBasePrice * ($pmRate / 100);
                    // Add together and then round
                    $totalUnitPrice = ($newItem->getBasePrice() + $itemUnitOhRate + $itemUnitPmRate);
                    // Calculate pre tax price
                    $itemPreTaxPrice = ($totalUnitPrice * $lineItem->getQuantity());
                    // Calculate the tax
                    $itemTaxPrice = $itemPreTaxPrice * ($lineItem->getTaxRate() / 100);
                    // Total Price
                    $itemTotalPrice = $itemBasePrice + $itemOhPrice + $itemPmPrice + $itemTaxPrice;

                    // Grab the old price
                    $oldLineItemPrice = $lineItem->getTotalPrice();

                    // Update the line item
                    $lineItem->setBasePrice(round($newItem->getBasePrice(), 2));
                    $lineItem->setOverheadRate(round($ohRate, 2));
                    $lineItem->setOverheadPrice(round($itemOhPrice, 2));
                    $lineItem->setProfitRate(round($pmRate, 2));
                    $lineItem->setProfitPrice(round($itemPmPrice, 2));
                    $lineItem->setUnitPrice(round($totalUnitPrice, 2));
                    $lineItem->setTaxPrice(round($itemTaxPrice, 2));
                    $lineItem->setTotalPrice(round($itemTotalPrice, 2));
                    $this->em->persist($lineItem);
                    $this->em->flush();


                    $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                    if ($calculator) {

                        $newdata = json_decode(json_encode(json_decode($calculator[0]['saved_values'])), true);

                        $tempdata = array();
                        foreach ($newdata as $data) {
                            if($data['name']=='cal_overhead'){
                                    $data['value'] = round($ohRate, 2).'%';
                            }
                            if($data['name']=='cal_profit'){
                                $data['value'] = round($pmRate, 2).'%';
                            }

                            
                            $tempdata[] = $data;
                        }
                        $scv = $this->em->find('models\EstimationCalculatorValue', $calculator[0]['id']);

                            $valuesText = json_encode($tempdata);

                            $scv->setSavedValues($valuesText);
                            $this->em->persist($scv);
                            $this->em->flush();

                    }

                    // Update the service Price
                    $proposalService = $lineItem->getProposalService();
                    $estimate = $this->getProposalServiceEstimate($proposalService);
                    $estimate->setTotalPrice($this->getEstimationRepository()->getProposalServiceLineItemTotal($proposalService->getServiceId()));
                    $price = '$' . number_format($estimate->getTotalPrice(), 0, '.', ',');
                    $proposalService->setPrice($price);
                    $this->em->persist($proposalService);
                    $this->em->flush();

                    // Now we can update the proposal price
                    updateProposalPrice($proposal->getProposalId());

                    if ($addLog) {
                        //$logMessage .='<strong>Unit Price:</strong> From $' . number_format($oldItem->getUnitPrice(), 2) . ' to $' . number_format($totalUnitPrice, 2). '';
                        //$logMessage .='<br/>';
                        $logMessage .= '<strong>Total Price:</strong> From $' . number_format($oldLineItemPrice, 2) . ' to $' . number_format($lineItem->getTotalPrice(), 2) . '';
                        $logMessage .= '<br/>';
                        $this->getEstimationRepository()->addLog(
                            $account,
                            $proposal->getProposalId(),
                            'update_item',
                            $logMessage
                        );
                    }
                }
            }
        }
    }

    /**
     * Returns an array of proposal objects - proposals belonging to a company with the specified estimate status
     * @param Companies $company
     * @param $estimateStatusId
     * @return array|Proposals
     */
    public function getCompanyProposalsByEstimateStatus(Companies $company, $estimateStatusId)
    {
        $sql = "SELECT proposals.proposalId
                FROM proposals
               
                WHERE proposals.company_id = " . $company->getCompanyId() . "
                AND proposals.estimate_status_id = " . $estimateStatusId;

        $results = $this->db->query($sql)->result();

        $out = [];

        foreach ($results as $result) {
            $proposal = $this->em->findProposal($result->proposalId);
            if ($proposal) {
                $out[] = $proposal;
            }
        }

        return $out;
    }

    /**
     * Returns an array of line items of a specific item, belonging to a specific proposal
     * @param $proposalId
     * @param $itemId
     * @return array
     */
    public function getEstimateLineItemsByProposalAndItem($proposalId, $itemId)
    {
        $dql = "SELECT eli
                FROM \models\EstimationLineItem eli
                WHERE eli.item_id = :itemId
                AND eli.proposal_id = :proposalId AND eli.custom_total_price=0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':itemId', $itemId);
        $query->setParameter(':proposalId', $proposalId);

        return $query->getResult();
    }

    /**
     * @param Proposal_services $proposalService
     * @return Estimate|object
     */
    public function getProposalServiceEstimate(Proposal_services $proposalService)
    {
        $estimate = $this->em->getRepository('\models\Estimate')->findOneBy([
            'proposal_service_id' => $proposalService->getServiceId()
        ]);

        if (!$estimate) {
            return $this->createProposalServiceEstimate($proposalService);
        }

        return $estimate;
    }

    /**
     * @param Proposal_services $proposalService
     * @return Estimate
     */
    public function createProposalServiceEstimate(Proposal_services $proposalService)
    {
        // Load the company via the proposal
        $proposalId = $proposalService->getProposal();
        $proposal = $this->em->findProposal($proposalId);
        if ($proposal->getEstimateStatusId() == \models\EstimateStatus::COMPLETE) {
            $proposal->setEstimateStatusId(\models\EstimateStatus::IN_PROGRESS);
            $this->em->persist($proposal);
            $this->em->flush();
        }
        $company = $proposal->getClient()->getCompany();

        // Grab the settings for setting defaults
        $settings = $this->getCompanySettings($company);

        // Create the estimate
        $estimate = new Estimate();
        $estimate->setProposalServiceId($proposalService->getServiceId());
        $estimate->setProposalId($proposalId);
        $estimate->setCustomPrice(0);
        $estimate->setCompleted(0);
        $estimate->setOverheadRate($settings->getDefaultOverhead());
        $estimate->setProfitRate($settings->getDefaultProfit());
        $estimate->setTotalPrice('0.00');
        $this->em->persist($estimate);
        $this->em->flush();

        return $estimate;
    }

    /**
     * @param Companies $company
     * @return EstimationSetting
     */
    public function getCompanySettings(Companies $company)
    {
        $settings = $this->em->getRepository('\models\EstimationSetting')->findOneBy([
            'company_id' => $company->getCompanyId()
        ]);

        if (!$settings) {
            return $this->createCompanySettings($company);
        }

        return $settings;
    }

    /**
     * @param Companies $company
     * @return EstimationSetting
     */
    public function createCompanySettings(Companies $company)
    {
        //$settings = new EstimationSetting();
        $settings = $this->em->getRepository('\models\EstimationSetting')->findOneBy([
            'company_id' => 0
        ]);
        $newsetting = clone $settings;
        $newsetting->setCompanyId($company->getCompanyId());

        $this->em->persist($newsetting);
        $this->em->flush();

        return $settings;
    }

    public function getAdminCompanySettings()
    {
        $settings = $this->em->getRepository('\models\EstimationSetting')->findOneBy([
            'company_id' => 0
        ]);


        return $settings;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getAllCompanyItems(Companies $company)
    {
        $dql = "SELECT ei FROM \models\EstimationItem ei
        WHERE ei.company_id = :companyId
        ORDER BY ei.type_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getAllCompanyItemsPdf(Companies $company)
    {
        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];
        $company_id = $company->getCompanyId();
        foreach ($sortedCategories as $category) {

            if ($category->getId() != EstimationCategory::CUSTOM) {

                $category_id = $category->getId();
                $sql = "SELECT ei.*, et.name AS typeName, ei.name AS itemName
                FROM estimation_items ei
                LEFT JOIN estimation_types et ON ei.type_id = et.id
                WHERE ei.company_id = '" . $company_id . "'
                AND et.category_id = '" . $category_id . "'
                ORDER BY ei.type_id ASC, ei.name ASC";

                $results = $this->getAllResults($sql);
                $out = [];

                foreach ($results as $result) {
                    $item = $this->em->findEstimationItem($result->id);

                    if ($item) {
                        $out[] = $item;
                    }
                }

                $data['items'] = $out;
                $data['category'] = $category;
                $sortedOut[] = $data;
            }
        }

        return $sortedOut;
    }

    /**
     * @param Companies $company
     * @param EstimationCategory $category
     * @return array
     * @description Returns a collection of types belonging to a category for a company
     */
    public function getCompanyCategoryTypeItems(Companies $company, EstimationCategory $category)
    {
        $sql = "SELECT ei.name AS item_name,ei.id AS item_id,et.name AS typeName,ei.overhead_rate,ei.profit_rate,ei.tax_rate,ei.unit_price,eu.name AS unit_name,COALESCE(SUM(eli.quantity), 0.00) AS totalQuantity,COALESCE(SUM(eli.total_price), 0.00) AS totalPrice,COUNT(DISTINCT(eli.proposal_id)) AS proposal_count
        FROM estimation_items ei
        LEFT JOIN estimate_line_items eli ON ei.id = eli.item_id
        LEFT JOIN estimation_units eu ON ei.unit = eu.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE et.category_id = " . (int)$category->getId() . " GROUP BY eli.item_id";

        return $this->getAllResults($sql);
    }

    public function delete_proposal($proposal_id)
    {
        $dql = "SELECT eli FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposal_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposal_id);

        $est_line_items = $query->getResult();

        echo '<pre>';
        //print_r($est_line_items);


        $dql = "SELECT el FROM \models\EstimateLog el
        WHERE el.proposal_id = :proposal_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposal_id);

        $est_logs = $query->getResult();
        //print_r($est_logs);

        $dql = "SELECT e FROM \models\Estimate e
        WHERE e.proposal_id = :proposal_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposal_id);

        $estimates = $query->getResult();
        //print_r($estimates);


        $dql = "SELECT ep FROM \models\EstimationPhase ep
        WHERE ep.proposal_id = :proposal_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposal_id);

        $est_phases = $query->getResult();
        //print_r($est_phases);

        $sql = "SELECT ps.*,ecv.*
        FROM proposal_services ps
        LEFT JOIN estimate_calculator_values ecv ON ps.serviceId = ecv.proposal_service_id
        WHERE ps.proposal = " . (int)$proposal_id;
        $proposal_services = $this->getAllResults($sql);
        //print_r($proposal_services);


        $dql = "SELECT p FROM \models\Proposals p
        WHERE p.proposalId = :proposal_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposal_id);

        $Proposals = $query->getResult();
        foreach ($Proposals as $Proposal) {
            echo $Proposal->getProposalId();
        }
    }

    /**
     * @param Companies $company
     * @param bool $count
     * @return array|int
     */
    public function getPricingReportData(Companies $company, $count = false)
    {
        // Base Query
        $sql = "SELECT
                    ei.id AS itemId,
                    ei.name AS itemName,
                    ei.base_price AS itemBasePrice,
                    ei.overhead_rate as itemOhRate,
                    ei.overhead_price as itemOhPrice,
                    ei.profit_rate AS itemPmRate,
                    ei.profit_price AS itemPmPrice,
                    ei.taxable AS itemTaxable,
                    ei.tax_rate AS itemTaxRate,
                    ei.unit_price AS itemUnitPrice,
                    ei.capacity AS itemCapacity,
                    ei.vendor AS itemVendor,
                    ei.sku AS itemSku,
                    ei.notes AS itemNotes,
                    et.id AS typeId,
                    et.name AS typeName,
                    ec.id AS categoryId,
                    ec.name AS categoryName,
                    eu.name AS unitName,
                    eu.id AS unitId
                FROM
                    estimation_items ei
                LEFT JOIN
                    estimation_types et ON ei.type_id = et.id
                LEFT JOIN
                  estimation_categories ec ON et.category_id = ec.id
                LEFT JOIN
                  estimation_units eu ON ei.unit = eu.id
                WHERE ei.company_id = " . (int)$company->getCompanyId();

        // Filter on categories
        if ($this->ci->input->post('categories')) {
            $sql .= ' AND ec.id IN(' . implode(',', $this->ci->input->post('categories')) . ')';
        }

        // Sorting
        $order = $this->ci->input->post('order');
        $sortCol = $order[0]['column'];
        $sortDir = $order[0]['dir'];

        $sortCols = [
            0 => 'categoryName',
            1 => 'typeName',
            2 => 'itemName',
            3 => 'itemBasePrice',
            4 => 'unitName',
            5 => 'itemPmRate',
            6 => 'itemOhRate',
            7 => 'itemTaxRate',
            8 => 'itemUnitPrice'
        ];

        // Search
        $searchVal = $this->ci->input->post('search')['value'];
        if ($searchVal) {
            $sql .= " AND (" .
                "(ei.name LIKE '%" . $searchVal . "%')" .
                "OR (et.name LIKE '%" . $searchVal . "%')" .
                "OR (ec.name LIKE '%" . $searchVal . "%')" .
                ")";
        }

        $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;

        // Handle Limit. Ignore if we're counting
        if ($this->ci->input->post('length') && !$count) {
            // Check it's not for all
            if ($this->ci->input->post('length') != -1) {
                $sql .= ' LIMIT ' . $this->ci->input->post('length');
                $sql .= ' OFFSET ' . $this->ci->input->post('start');
            }
        }

        // Organize the data
        $rows = $this->getAllResults($sql);

        // If counting, just return the count
        if ($count) {
            return count($rows);
        }

        // Build the data
        $tableData = [];

        foreach ($rows as $data) {
            $row = [
                0 => $data->categoryName,
                1 => $data->typeName,
                2 => $data->itemName,
                3 => '$' . $data->itemBasePrice,
                4 => $data->unitName,
                5 => $data->itemPmRate . '%',
                6 => $data->itemOhRate . '%',
                7 => '$' . $data->itemTaxRate,
                8 => '$' . $data->itemUnitPrice,
                9 => $this->ci->load->view('templates/estimate_reports/table/item-actions', ['data' => $data], true),
            ];

            $tableData[] = $row;
        }

        return $tableData;
    }

    /**
     * @param Companies $company
     * @return mixed
     */
    public function getPricingDataCountAll(Companies $company)
    {
        // Base Query
        $sql = "SELECT COUNT(ei.id) AS numItems
                FROM estimation_items ei
                WHERE ei.company_id = " . (int)$company->getCompanyId();

        $result = $this->getSingleResult($sql);

        return $result->numItems;
    }

    /**
     * @param Companies $company
     * @param $categoryId
     * @return array
     */
    public function getCategoryReportData(Companies $company, $categoryId, $count = false)
    {
        $sql = "SELECT
                  ei.name AS itemName,
                  ei.id AS itemId,
                  et.id AS typeId,
                  et.name AS typeName,
                  eu.name AS unitName,
                  eu.abbr AS unitAbbr,
                  COALESCE(SUM(eli.quantity), 0.00) AS totalQuantity,
                  COALESCE(SUM(eli.total_price), 0.00) AS totalPrice,
                  COUNT(DISTINCT(eli.proposal_id)) AS proposalCount
                FROM
                  estimation_items ei
                LEFT JOIN
                  estimation_units eu ON ei.unit = eu.id
                LEFT JOIN
                  estimation_types et ON ei.type_id = et.id
                LEFT JOIN
                  estimate_line_items eli ON ei.id = eli.item_id
                LEFT JOIN
                  proposals p ON eli.proposal_id = p.proposalId
                WHERE
                  ei.company_id = " . (int)$company->getCompanyId() . "
                AND
                  et.category_id = " . (int)$categoryId . "
                GROUP BY
                    ei.id";

        // Filter on categories

        // Sorting
        $order = $this->ci->input->post('order');
        $sortCol = $order[0]['column'];
        $sortDir = $order[0]['dir'];

        $sortCols = [
            0 => 'ei.type_id',
            1 => 'ei.name',
            2 => 'proposalCount',
            3 => 'totalPrice',
            4 => 'totalQuantity',
        ];

        // Search
        $searchVal = $this->ci->input->post('search')['value'];
        if ($searchVal) {
            $sql .= " AND (" .
                "(ei.name LIKE '%" . $searchVal . "%')" .
                "OR (et.name LIKE '%" . $searchVal . "%')" .
                ")";
        }

        $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;

        // Handle Limit
        if ($this->ci->input->post('length') && !$count) {
            $sql .= ' LIMIT ' . $this->ci->input->post('length');
            $sql .= ' OFFSET ' . $this->ci->input->post('start');
        }

        // Organize the data
        $rows = $this->getAllResults($sql);

        // If counting, just return the count
        if ($count) {
            return count($rows);
        }

        $tableData = [];

        foreach ($rows as $data) {
            $row = [
                0 => $data->typeName,
                1 => $data->itemName,
                2 => number_format($data->proposalCount),
                3 => '$' . number_format($data->totalPrice),
                4 => number_format($data->totalQuantity) . ' ' . $data->unitAbbr,
            ];

            $tableData[] = $row;
        }

        return $tableData;
    }

    /**
     * @param Companies $company
    
     * @return array
     */
    public function getJobCostReportData(Companies $company, $count = false)
    {
        $CI =& get_instance();
        $CI->load->library('session');
        $sql = "SELECT
                  ei.name AS itemName,
                  ei.id AS itemId,
                  et.id AS typeId,
                  et.name AS typeName,
                  eu.name AS unitName,
                  eu.abbr AS unitAbbr,
                  COALESCE(SUM(jci.actual_qty), 0.00) AS totalQuantity,
                  COALESCE(SUM(jci.estimated_total_price), 0.00) AS estimatedTotalPrice,
                  COALESCE(SUM(jci.price_difference), 0.00) AS priceDifference,
                  
                  COALESCE(SUM(jci.actual_total_price), 0.00) AS totalPrice,
                  SUM(jci.price_difference) *100 / SUM(jci.actual_total_price) AS percent,
                  COUNT(DISTINCT(eli.proposal_id)) AS proposalCount
                FROM
                    job_cost_item jci
                LEFT JOIN
                  estimate_line_items eli ON jci.estimate_line_item_id = eli.id
                LEFT JOIN
                 estimation_items ei ON eli.item_id = ei.id
                LEFT JOIN
                  estimation_units eu ON ei.unit = eu.id
                LEFT JOIN
                  estimation_types et ON ei.type_id = et.id
                
                
                LEFT JOIN
                  proposals p ON eli.proposal_id = p.proposalId
                WHERE
                  ei.company_id = " . (int)$company->getCompanyId() . "
                
                GROUP BY
                    ei.id";

        // Filter on categories

        // Sorting
        $order = $this->ci->input->post('order');
        $sortCol = $order[0]['column'];
        $sortDir = $order[0]['dir'];

        $sortCols = [
            0 => 'ei.type_id',
            1 => 'ei.name',
            2 => 'proposalCount',
            3 => 'estimatedTotalPrice',
            4 => 'totalPrice',
            5 => 'priceDifference',
            6 => 'percent',
            7 => 'totalQuantity',
        ];

        // Search
        $searchVal = $this->ci->input->post('search')['value'];
        if ($searchVal) {
            $sql .= " AND (" .
                "(ei.name LIKE '%" . $searchVal . "%')" .
                "OR (et.name LIKE '%" . $searchVal . "%')" .
                ")";
        }

         //Created Date from
         if ($CI->session->userdata('jcCreatedFrom')) {
            // $start = $CI->session->userdata('jcCreatedFrom');
            // $sql .= " AND (p.job_cost_completed_at >= {$start})";
            $start = $CI->session->userdata('jcCreatedFrom');
           // echo $CI->session->userdata('jcCreatedFrom') ;die;
            $sql .= " AND (p.created >= {$start})";
        }
        // Created Date To
        if ($CI->session->userdata('jcCreatedTo')) {
            // $end = $CI->session->userdata('jcCreatedTo');
            // $sql .= " AND (p.job_cost_completed_at <= {$end})";
            $end = $CI->session->userdata('jcCreatedTo');
            
            $sql .= " AND (p.created <= {$end})";
        }

        $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;

        // Handle Limit
        if ($this->ci->input->post('length') && !$count) {
            $sql .= ' LIMIT ' . $this->ci->input->post('length');
            $sql .= ' OFFSET ' . $this->ci->input->post('start');
        }
        //echo $sql;die;

        // Organize the data
        $rows = $this->getAllResults($sql);

        // If counting, just return the count
        if ($count) {
            return count($rows);
        }

        $tableData = [];

        foreach ($rows as $data) {
            $row = [
                0 => $data->typeName,
                1 => $data->itemName,
                2 => number_format($data->proposalCount),
                3 => '$' . number_format($data->estimatedTotalPrice),
                4 => '$' . number_format($data->totalPrice),
                5 => ($data->priceDifference<0)?  '-$'.number_format(abs($data->priceDifference), 2, '.', ',') : '$'.number_format(abs($data->priceDifference), 2, '.', ','),
                6 => number_format($data->percent, 2, '.', ',').' %',
                7 => number_format($data->totalQuantity) . ' ' . $data->unitAbbr,
            ];

            $tableData[] = $row;
        }

        return $tableData;
    }
    

    public function getCompanyResendList(Companies $company,$account)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\ProposalGroupResend', 'pgr');
        $rsm->addFieldResult('pgr', 'resend_name', 'resend_name');
        $rsm->addFieldResult('pgr', 'id', 'id');
        $rsm->addFieldResult('pgr', 'created', 'created');
        $rsm->addFieldResult('pgr', 'account_id', 'account_id');
        $rsm->addFieldResult('pgr', 'account_name', 'account_name');
        $rsm->addFieldResult('pgr', 'ip_address', 'ip_address');
        $rsm->addFieldResult('pgr', 'email_content', 'email_content');
        $rsm->addFieldResult('pgr', 'company_id', 'company_id');
        $rsm->addFieldResult('pgr', 'resend_name', 'resend_name');
        $rsm->addFieldResult('pgr', 'is_deleted', 'is_deleted');
        $rsm->addFieldResult('pgr', 'subject', 'subject');
        $rsm->addFieldResult('pgr', 'email_cc', 'email_cc');
        $rsm->addFieldResult('pgr', 'custom_sender', 'custom_sender');
        $rsm->addFieldResult('pgr', 'custom_sender_name', 'custom_sender_name');
        $rsm->addFieldResult('pgr', 'custom_sender_email', 'custom_sender_email');
        $rsm->addFieldResult('pgr', 'parent_resend_id', 'parent_resend_id');
        $rsm->addFieldResult('pgr', 'filters', 'filters');
        $rsm->addFieldResult('pgr', 'excluded_override', 'excluded_override');
        
        $dql = "SELECT pgr.resend_name,pgr.id,pgr.created,pgr.account_id,pgr.ip_address,pgr.account_name,pgr.email_content,
                        pgr.company_id,pgr.resend_name,pgr.is_deleted,pgr.subject,pgr.email_cc,pgr.custom_sender,pgr.custom_sender_name,
                        pgr.custom_sender_email,pgr.parent_resend_id,pgr.filters,pgr.excluded_override
                FROM proposal_group_resends pgr";

        if ($account->isAdministrator() || $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $dql .= ' WHERE  pgr.company_id= :companyId';

        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $dql .= ' INNER JOIN proposal_group_resend_email AS pgre ON pgr.id = pgre.resend_id LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   
            WHERE a2.branch = :branch 
            AND a2.company = :companyId';

        } else {
            $dql .= ' WHERE pgr.id IN(SELECT DISTINCT
            (pgre.resend_id)
        FROM
            proposal_group_resend_email pgre
                LEFT JOIN
            proposals ON pgre.proposal_id = proposals.proposalId
        WHERE
            proposals.owner = :accountId) ';
        }

        $dql .=" AND pgr.is_deleted =0 order by id desc";

        $query = $this->em->createNativeQuery($dql, $rsm);
        $query->setParameter('branch', $account->getBranch());
        $query->setParameter('companyId', $company->getCompanyId());
        $query->setParameter('accountId', $account->getAccountId());
        $resend_list = $query->getResult();
        
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_PROPOSAL_RESEND_LIST . $company->getCompanyId());
        return $resend_list;
    }

    public function getCompanyResendList22(Companies $company,$account)
    {

        $sql = "SELECT pgr.resend_name,pgr.id FROM proposal_group_resends pgr"; 
                //WHERE pgr.company_id = " . (int)$company->getCompanyId()." AND pgr.is_deleted =0 order by id desc";


        if ($account->isAdministrator() || $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= ' INNER JOIN proposal_group_resend_email AS pgre ON pgr.id = pgre.resend_id LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE a2.branch = ' . $account->getBranch() . '
                AND pgr.company_id=' . $company->getCompanyId();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();

            $sql .= ' WHERE pgr.id IN(SELECT DISTINCT
            (pgre.resend_id)
        FROM
            proposal_group_resend_email pgre
                LEFT JOIN
            proposals ON pgre.proposal_id = proposals.proposalId
        WHERE
            proposals.owner = ' . $account->getAccountId().') ';
        }

        $sql .=" AND pgr.is_deleted =0 order by id desc";
        return $this->getAllResults($sql);

    }

        /**
     * @param Companies $company
    
     * @return array
     */
    public function getGroupResendData(Companies $company, $count = false,$account=NULL)
    {
        $CI =& get_instance();
        $CI->load->library('session');

        if ($account->isAdministrator() || $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $failed_subquery = " (SELECT SUM(pgre2.is_failed) FROM proposal_group_resend_email AS pgre2 WHERE pgre2.resend_id = pgr.id ) AS failed";
        }else if ($account->isBranchAdmin()) {
                //branch admin, can access only his branch
                $failed_subquery = " (SELECT SUM(pgre2.is_failed) FROM proposal_group_resend_email AS pgre2   
                
                LEFT JOIN proposals p2 ON pgre2.proposal_id = p2.proposalId
                LEFT JOIN accounts AS a2 ON p2.account = a2.accountId
                WHERE pgre2.resend_id = pgr.id 
                a2.branch = " . $account->getBranch() . "
                    AND pgr.company_id=" . $company->getCompanyId()."
                ) AS failed";
                
            } else {
                $failed_subquery = " (SELECT SUM(pgre2.is_failed) FROM proposal_group_resend_email AS pgre2
                LEFT JOIN proposals p2 ON pgre2.proposal_id = p2.proposalId
                 WHERE pgre2.resend_id = pgr.id  AND 
                 p2.owner = " . $account->getAccountId()." ) AS failed";
            
            }

        $sql = "SELECT pgr.*,a.firstname,a.lastname,pgrp.resend_name as parent_name,
                    COUNT(pgre.delivered_at) AS delivered,
                    COUNT(pgre.id) AS total_resend,
                    COUNT(pgre.bounced_at) AS bounced,
                    COUNT(pgre.opened_at) AS opened,
                    COUNT(pgre.clicked_at) as clicked,
                    COUNT(pgre.sent_at) AS sent_count,
                    ".$failed_subquery.",
                    (COUNT(pgre.clicked_at) / COUNT(pgre.id)) AS cct,
                    (COUNT(pgre.opened_at) / COUNT(pgre.id)) AS pct 
                    FROM proposal_group_resends pgr 
                    LEFT JOIN proposal_group_resend_email AS pgre ON pgr.id = pgre.resend_id AND pgre.is_failed = 0
                    LEFT JOIN accounts AS a ON pgr.account_id = a.accountId 
                    LEFT JOIN proposal_group_resends AS pgrp ON pgr.parent_resend_id = pgrp.id";

        // Filter on categories

        // Sorting
        $order = $this->ci->input->get('order');
        $sortCol = $order[0]['column'];
        $sortDir = $order[0]['dir'];

        $sortCols = [
            1 => 'pgr.id',
            2 => 'pgr.created',
            3 => 'pgr.resend_name',
            4 => 'pgr.account_name',
            5 => 'total_resend',
            6 => 'delivered',
            7 => 'bounced',
            8 => 'opened',
            9 => 'clicked',
            10 => 'cct',
            12 => 'pct',
        ];


        if ($account->isAdministrator() || $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= ' LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE a2.branch = ' . $account->getBranch() . '
                AND pgr.company_id=' . $company->getCompanyId();
        } else {

            $sql .= ' LEFT JOIN
            proposals  ON pgre.proposal_id = proposals.proposalId WHERE proposals.owner =' . $account->getAccountId();

       
        }
        //$sql .= ' AND pgr.is_deleted=0 AND pgr.parent_resend_id IS NULL';
        $sql .= ' AND pgr.is_deleted=0';

        // // Search
        $searchVal = $this->ci->input->get('search')['value'];
        if ($searchVal) {
            $sql .= " AND (" .
                "(pgr.account_name  LIKE '%" . $searchVal . "%')" .
                "OR (pgr.resend_name  LIKE '%" . $searchVal . "%')" .
                ") GROUP BY pgr.id";
        }else{
            $sql .= ' GROUP BY pgr.id';
        }

        $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;

        // Handle Limit
        if ($this->ci->input->get('length') && !$count) {
            $sql .= ' LIMIT ' . $this->ci->input->get('length');
            $sql .= ' OFFSET ' . $this->ci->input->get('start');
        }
        //echo $sql;die;

        // Organize the data
        $rows = $this->getAllResults($sql);

        // If counting, just return the count
        if ($count) {
            return count($rows);
        }

        $tableData = [];
        
        foreach ($rows as $data) {
            // Not sure what's going on here but I'll keep it for now
            $names = '';
            $names2 = explode(' ', trim($data->firstname . ' ' . $data->lastname));
            foreach ($names2 as $name) {
                $names .= substr($name, 0, 1) . ' . ';
            }

        $account_name = '<span class="tiptip" title="'. $data->firstname . ' ' . $data->lastname.'">'. $names.'</span>';
            $date=date_create($data->created);
            $open = ($data->total_resend - ($data->delivered+$data->bounced));
            
            $unsend = $this->getUnopenedProposals($data->id);
            $unsend = count($unsend);
            $open_p = $data->opened ? round(($data->pct) * 100) : '0';
            $click_p = $data->clicked ? round(($data->cct) * 100) : '0';
            $failed_info = '';
            if($data->failed>0){
                $failed_info = '<a href="/proposals/resend/' . $data->id . '/failed" class="right" style="position: absolute;right: 0;"><i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="'.$data->failed.' Proposal Failed to send" ></i></a>';
            }
            $create_date = date_format($date, "m/d/y g:i A");
        //if (($account->isAdministrator() && $account->hasFullAccess()) || $data->account_id == $account->getAccountId()) {
            $action = '<div class="dropdownButton">
                        <a class="dropdownToggle" href="#">Go</a>
                        <div class="dropdownMenuContainer single">
                            <ul class="dropdownMenu">
                            <li>
                                <a data-resend-name="'.$data->resend_name.'" data-resend-id="'.$data->id.'" href="javascript:void(0);" class="edit_resend_name "><i class="fa fa-fw fa-pencil"></i>Edit Resend Name</a>
                            </li> 
                            <li>
                                <a  href="javascript:void(0);" data-resend-id="'.$data->id.'" class="show_email_content "><i class="fa fa-fw fa-pencil-square-o"></i> Summary</a>
                            </li>
                            <li>
                                <a href="../proposals/resend/'.$data->id.'" class="show_email_content22 " ><i class="fa fa-fw fa-files-o"></i> View Proposals</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-val="'.$data->id.'" class="delete_campaign " ><i class="fa fa-fw fa-trash"></i> Delete Campaign</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-val="'.$data->id.'"  data-unclicked="0" data-bounced="0" class="resend_upopened " ><i class="fa fa-fw fa-share-square"></i> Resend Unopened Proposals</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" data-val="'.$data->id.'" data-unclicked="1" data-bounced="0" class="resend_upopened " ><i class="fa fa-fw fa-share-square-o"></i> Resend Unclicked Proposals</a>
                            </li>';

            if($data->bounced > 0){
                $action .= '<li>
                                <a href="javascript:void(0);" data-val="'.$data->id.'" data-unclicked="0" data-bounced="1" class="resend_bounced " ><i class="fa fa-fw fa-share-square-o"></i> Resend Bounced Proposals</a>
                            </li>';
            }
            $action .= '<li>
                                <a href="javascript:void(0);" data-val="'.$data->id.'" class="campaign_stats " ><i class="fa fa-fw fa-line-chart"></i> Campaign Stats</a>
                            </li>
                                
                            </ul>
                        </div>
                    </div>';

                    $total_resend = '<div style="position: relative;"><a href="/proposals/resend/' . $data->id . '">' . $data->total_resend . '</a>'.$failed_info.'</div>';
                    if($data->sent_count < $data->total_resend){
                        $total_sending = $data->total_resend;
                        if($data->failed>0){
                            $total_sending = $data->failed + $total_sending;
                        }
                        $total_resend = '<div style="position: relative;"><a href="/proposals/resend/' . $data->id . '">' .$data->sent_count.' / '. $total_sending . '</a>'.$failed_info.'</div>';
                        $create_date .= ' <i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="Campaign is in progress" ></i>';
                    }
                    $delivered = '<a href="/proposals/resend/' . $data->id . '/delivered">' . $data->delivered . '</a>';
                    $bounced = '<a href="/proposals/resend/' . $data->id . '/bounced">' . $data->bounced . '</a>';
                    $opened = '<div style="display: flex;justify-content: space-between;"><a href="/proposals/resend/' . $data->id . '/opened">' . $data->opened . '</a><a  href="/proposals/resend/' . $data->id . '/opened">' . $open_p . '%</a></div>';
                    $clicked = '<div style="display: flex;justify-content: space-between;"><a href="/proposals/resend/' . $data->id . '/clicked">' . $data->clicked . '</a><a href="/proposals/resend/' . $data->id . '/clicked">' . $click_p . '%</a></div>';
                    
                    $badge = "R";
                    $resend_type_text = "Resend";
                    if($data->resend_type == 1){
                        $badge = "RUO";
                        $resend_type_text = "Resend Unopened";
                    }
                    if($data->resend_type == 2){
                        $badge = "RUC";
                        $resend_type_text = "Resend Unclicked";
                    }
                    if($data->resend_type == 3){
                        $badge = "RB";
                        $resend_type_text = "Resend Bounced";
                    }
                $campaign_name = $data->parent_name?'[<span class="tiptip" title ="'.$resend_type_text.' of '.$data->parent_name.' ">'.$badge.'</span>] '.$data->resend_name:$data->resend_name;
                    
            //$campaign_name = $data->parent_name?'[<span class="tiptip" title ="Resend of '.$data->parent_name.' ">R</span>] '.$data->resend_name:$data->resend_name;
            
            $row = [
                0 => '<input type="checkbox" class="campaignCheck" data-campaign-id="' . $data->id . '" />',
                1 => $action,
                2 => $create_date,
                3 => $campaign_name,
                4 => $account_name,
                5 => $total_resend,
                6 => $delivered,
                7 => $bounced,
                8 => $opened,
                9 => $clicked,
                10 =>  $open_p,
                11 => $click_p,
            ];

            $tableData[] = $row;
        }

        return $tableData;
    }
    
    function getUnopenedProposals($resend_id){

        $sql = "SELECT p.proposalId FROM proposal_group_resend_email pgre 
        LEFT JOIN proposals p ON pgre.proposal_id = p.proposalId
        LEFT JOIN proposal_group_resends pgr on pgre.resend_id = pgr.id
        WHERE p.lastOpenTime > UNIX_TIMESTAMP(pgr.created)
        AND pgr.id = ".$resend_id." group by p.proposalId";

        return $this->getAllResults($sql);
      }


      function getUnopenedProposalsStatusCount($resend_id,$clicked=false){

        $sql = "SELECT p.proposalStatus, p.resend_excluded, pgre.proposal_status_id, pgre.proposal_id
        FROM proposal_group_resend_email pgre 
        LEFT JOIN proposals p ON pgre.proposal_id = p.proposalId";

        if($clicked){
            $sql .= " WHERE pgre.opened_at IS NOT NULL AND pgre.clicked_at IS NULL
            AND pgre.resend_id = ".$resend_id;
        }else{
            $sql .= " WHERE pgre.opened_at IS NULL
            AND pgre.resend_id = ".$resend_id;
        }
        


        $proposals = $this->getAllResults($sql);

        $sql2 = "SELECT COUNT(pgre.proposal_id) as total_proposals
        FROM proposal_group_resend_email pgre
        LEFT JOIN proposals ON pgre.proposal_id = proposals.proposalId
        
        WHERE pgre.resend_id = ".$resend_id;

        $proposals_count = $this->getAllResults($sql2);

        if($proposals_count){
           
            $total_proposals = $proposals_count[0]->total_proposals;
        }else{
           
            $total_proposals = 0;
        }

        $data =array();
        $data['total_opened'] = count($proposals);
        $data['total_proposals'] = $total_proposals;
       
        $total_not_sent = 0;
        $total_excluded = 0;
        
        foreach($proposals as $proposal){
            if($proposal->proposalStatus != $proposal->proposal_status_id){
                $total_not_sent++;
            }else if($proposal->resend_excluded ==1){
                $total_excluded++;
            }
        }
        
        $data['total_not_sent'] = $total_not_sent;
        $data['total_resending'] = $data['total_opened'] - $total_not_sent;
        $data['total_excluded'] = $total_excluded;
        return $data;
      }


      function getBouncedProposalsStatusCount($resend_id){

        $sql = "SELECT p.proposalStatus, p.resend_excluded, pgre.proposal_status_id, pgre.proposal_id
        FROM proposal_group_resend_email pgre 
        LEFT JOIN proposals p ON pgre.proposal_id = p.proposalId";

       
        $sql .= " WHERE pgre.bounced_at IS NOT NULL
        AND pgre.resend_id = ".$resend_id;
        
        


        $proposals = $this->getAllResults($sql);

        $sql2 = "SELECT COUNT(pgre.proposal_id) as total_proposals
        FROM proposal_group_resend_email pgre
        LEFT JOIN proposals ON pgre.proposal_id = proposals.proposalId
        
        WHERE pgre.resend_id = ".$resend_id;

        $proposals_count = $this->getAllResults($sql2);

        if($proposals_count){
           
            $total_proposals = $proposals_count[0]->total_proposals;
        }else{
           
            $total_proposals = 0;
        }

        $data =array();
        $data['total_bounced'] = count($proposals);
        $data['total_proposals'] = $total_proposals;
       
        $total_not_sent = 0;
        $total_excluded = 0;
        
        
        
        $data['total_not_sent'] = $total_not_sent;
        $data['total_resending'] = $data['total_bounced'] - $total_not_sent;
        $data['total_excluded'] = $total_excluded;
        return $data;
      }

     /**
     * @param Companies $company
 
     * @return mixed
     */
    public function getJobCostReportDataCountAll(Companies $company)
    {
        // Base Query
        $sql = "SELECT COUNT(ei.id) AS numItems
                FROM estimation_items ei
                LEFT JOIN estimation_types et ON ei.type_id = et.id
                WHERE ei.company_id = " . (int)$company->getCompanyId();

        $result = $this->getSingleResult($sql);

        return $result->numItems;
    }

    /**
     * @param Companies $company
     * @param $categoryId
     * @return mixed
     */
    public function getCategoryReportDataCountAll(Companies $company, $categoryId)
    {
        // Base Query
        $sql = "SELECT COUNT(ei.id) AS numItems
                FROM estimation_items ei
                LEFT JOIN estimation_types et ON ei.type_id = et.id
                WHERE ei.company_id = " . (int)$company->getCompanyId() . "
                AND et.category_id = " . (int)$categoryId;

        $result = $this->getSingleResult($sql);

        return $result->numItems;
    }

    public function EstimationItemPriceChanges($oldItem, $item, $account)
    {


        $logMessage = '<strong>Item Adjusted by Price Update</strong><br />';

        if ($item->getBasePrice() != $oldItem->getBasePrice()) {
            $logMessage .= '<strong>Base Price:</strong> From $' . number_format($oldItem->getBasePrice(), 2) . ' to $' . number_format($item->getBasePrice(), 2);
            $logMessage .= ' <br/>';

        }
        if ($item->getUnitPrice() != $oldItem->getUnitPrice()) {
            $logMessage .= '<strong>Unit Price:</strong> From $' . number_format($oldItem->getUnitPrice(), 2) . ' to $' . number_format($item->getUnitPrice(), 2);
            $logMessage .= '<br/>';

        }

        if ($item->getProfitRate() != $oldItem->getProfitRate()) {
            $logMessage .= '<strong>PM Rate:</strong> From ' . number_format($oldItem->getProfitRate(), 2) . '% to ' . number_format($item->getProfitRate(), 2) . '%';
            $logMessage .= ' <br/>';

        }
        if ($item->getOverheadRate() != $oldItem->getOverheadRate()) {
            $logMessage .= '<strong>OH Rate:</strong> From ' . number_format($oldItem->getOverheadRate(), 2) . '% to ' . number_format($item->getOverheadRate(), 2) . '%';
            $logMessage .= '<br/>';

        }
        if ($item->getTaxRate() != $oldItem->getTaxRate()) {
            //print_r($oldItem->getTaxRate());die;
            $logMessage .= '<strong>Tax Rate:</strong> From ' . number_format(floatval($oldItem->getTaxRate()), 2) . '% to ' . number_format(floatval($item->getTaxRate()), 2) . '%';
            $logMessage .= '<br/>';

        }

        $eipc = new EstimationItemPriceChange();

        // Proposal ID
        $eipc->setItemId($item->getId());
        // ProposalService ID
        $eipc->setOldBasePrice($oldItem->getBasePrice());
        // Item ID
        $eipc->setOldOverheadRate($oldItem->getOverheadRate());
        // Phase ID
        $eipc->setOldProfitRate($oldItem->getProfitRate());
        // Phase ID
        $eipc->setOldUnitPrice($oldItem->getUnitPrice());
        // Child material - 0 or 1
        $eipc->setOldTaxRate($oldItem->getTaxRate());
        // Unit Price
        $eipc->setNewBasePrice($item->getBasePrice());
        // Custom Unit Price - 0 or 1
        $eipc->setNewOverheadRate($item->getOverheadRate());
        // Quantity
        $eipc->setNewProfitRate($item->getProfitRate());
        // Total Price
        $eipc->setNewUnitPrice($item->getUnitPrice());
        // Base price
        $eipc->setNewTaxRate($item->getTaxRate());
        // setOverheadRate
        $eipc->setCreatedAt(Carbon::now());
        // set Profit Rate
        $eipc->setAccountId($account->getAccountId());
        // set OverheadPrice
        $eipc->setUserName($account->getFullname());
        // set Profit Price
        $eipc->setOldOverheadPrice($oldItem->getOverheadPrice());
        // Set Tax Rate
        $eipc->setOldProfitPrice($oldItem->getProfitPrice());
        // Set Tax Price
        $eipc->setNewOverheadPrice($item->getOverheadPrice());

        // setOverheadRate
        $eipc->setNewProfitPrice($item->getProfitPrice());

        // set Profit Rate
        $eipc->setIp($this->getUserIpAddr());
        // set OverheadPrice
        //$eipc->setNewTaxPrice($item->getTaxPrice());
        $eipc->setDetail($logMessage);

        // Save it
        $this->em->persist($eipc);
        $this->em->flush();

    }

    function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }

    /**
     * @param $itemId
     * @param $account
     * @return string
     */
    public function findTemplates($itemId, $account)
    {
        $sql = "SELECT eti.template_id,et.name
        FROM estimate_template_items eti
        LEFT JOIN estimation_templates et ON eti.template_id = et.id
        WHERE eti.item_id = " . $itemId . " AND et.company_id = " . (int)$account;

        $results = $this->getAllResults($sql);
        return json_encode($results, true);
    }

    /**
     * @param Companies $company
     * @param $templateId
     * @return array
     */
    public function getCompanyTemplateServices(Companies $company, $templateId)
    {
        $dql = "SELECT est
        FROM \models\EstimationServiceTemplate est
        WHERE est.company_id = :companyId
        AND est.template_id = :templateId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':templateId', $templateId);

        $services = [];

        $results = $query->getResult();

        foreach ($results as $result) {
            $services[] = $result->getServiceId();
        }

        return $services;
    }

    /**
     * @param Companies $company
     * @param $templateId
     * @return array
     */
    public function getCompanyBranchPlants(Companies $company, $plant_id)
    {
         $dql = "SELECT ebp
        FROM \models\EstimationBranchPlant ebp
        WHERE ebp.company_id = :companyId
        AND ebp.plant_id = :plantId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':plantId', $plant_id);

        $branches = [];

        $results = $query->getResult();

        foreach ($results as $result) {
            $branches[] = $result->getBranchId();
        }

        return $branches;
    }

    /**
     * @param Companies $company
     * @param $templateId
     * @return array
     */
    public function getAllCompanyTemplateServices(Companies $company, $templateId)
    {
        $dql = "SELECT est
        FROM \models\EstimationServiceTemplate est
        WHERE est.company_id = :companyId
        AND est.template_id = :templateId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':templateId', $templateId);

        $results = $query->getResult();


        return $results;
    }


    /**
     * @param Companies $company
     * @param $templateId
     * @return array
     */
    public function getAdminTemplateServices($templateId)
    {
        $dql = "SELECT est
        FROM \models\EstimationServiceTemplate est
        WHERE est.company_id = 0
        AND est.template_id = :templateId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':templateId', $templateId);

        $results = $query->getResult();


        return $results;
    }

    public function getAdminCompanyTemplateServices($templateId)
    {
        $dql = "SELECT est
        FROM \models\EstimationServiceTemplate est
        WHERE est.company_id = 0 AND est.template_id = :templateId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':templateId', $templateId);

        $services = [];

        $results = $query->getResult();

        foreach ($results as $result) {
            $services[] = $result->getServiceId();
        }

        return $services;
    }

    /**
     * Reset all estimate data for a proposal
     * @param Proposals $proposal
     */
    public function resetEstimation(Proposals $proposal)
    {
        // Get the line item data for this estimate
        $estimateLineItems = $this->getProposalEstimateLineItems($proposal->getProposalId());

        // Delete calculator values for the line items
        foreach ($estimateLineItems as $estimateLineItem) {
            $this->deleteLineItemCalculatorValues($estimateLineItem->id);
        }

        // Delete the line items
        $this->clearProposalLineItems($proposal);

        // Delete the job cost Items
        $this->clearJobCostItems($proposal);

        // Get the proposal services
        $proposalServices = $proposal->getServices();

        foreach ($proposalServices as $proposalService) {
            /* @var Proposal_services $proposalService */

            // Update the price of the Proposal Service
            $proposalService->setPrice(0);
            $proposalService->setTaxPrice('0.00');
            $this->em->persist($proposalService);

            // Get the estimate and update the status and price
            $estimate = $this->getProposalServiceEstimate($proposalService);
            $estimate->setTotalPrice('0.00');
            $estimate->setCompleted('0');
            $this->em->persist($estimate);

            // Get the phases
            $phases = $this->getProposalServicePhases($proposalService, $proposal->getProposalId());

            foreach ($phases as $phase) {
                // Update phase status
                $this->resetPhase($phase);
            }

        }

        // Flush to DB
        $this->em->flush();
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getProposalEstimateLineItems($proposalId)
    {
        $sql = "SELECT eli.*, ec.name AS categoryName, et.name AS typeName, ei.name AS itemName
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        WHERE eli.proposal_id = '" . $proposalId . "'";

        return $this->getAllResults($sql);
    }

    /**
     * @param $proposalServiceId
     * @param $itemId
     */
    public function deleteLineItemCalculatorValues($lineItemId)
    {
        $dql = "DELETE \models\EstimationCalculatorValue ecv
        WHERE ecv.line_item_id = :lineItemId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':lineItemId', $lineItemId);
        $query->execute();
    }

    /**
     * @param Proposals $proposal
     */
    public function clearProposalLineItems(Proposals $proposal)
    {
        $dql = "DELETE \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposal->getProposalId());
        $query->execute();
    }

    /**
     * @param Proposals $proposal
     */
    public function clearJobCostItems(Proposals $proposal)
    {
        $dql = "DELETE \models\JobCostItem jci
        WHERE jci.proposal_id = :proposalId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposal->getProposalId());
        $query->execute();
    }

    public function clearJobCostItemsByServiceId($proposalServiceId)
    {
        $dql = "DELETE \models\JobCostItem jci
        WHERE jci.proposal_service_id = :proposalServiceId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        $query->execute();
    }

    public function clearJobCostItemsByEstimateLineId($estimateLineId)
    {
        $dql = "DELETE \models\JobCostItem jci
        WHERE jci.estimate_line_item_id = :estimateLineId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':estimateLineId', $estimateLineId);
        $query->execute();
    }

    public function clearJobCostItemsByEstimateItems($Items)
    {
        foreach($Items as $item){
            $dql = "DELETE \models\JobCostItem jci
            WHERE jci.estimate_line_item_id = :estimateLineId";
    
            $query = $this->em->createQuery($dql);
            $query->setParameter(':estimateLineId', $item['id']);
            $query->execute();
        }
        
    }

    public function resetPhase(EstimationPhase $phase)
    {
        $phase->setMaterial(0);
        $phase->setEquipment(0);
        $phase->setLabor(0);
        $phase->setTrucking(0);
        $phase->setComplete(0);

        $this->em->persist($phase);
        $this->em->flush();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getCompanyCrews(Companies $company)
    {
        $dql = "SELECT ec
        FROM \models\EstimationCrew ec
        WHERE ec.company_id = :companyId
        AND ec.deleted = 0
        ORDER BY ec.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        return $query->getResult();
    }

    /**
     * @param $crewId
     * @return array
     */
    public function getEstimateCrewItemsData($crewId)
    {
        $sql = "SELECT ei.*, ec.name AS categoryName,
          et.name AS typeName,
          eci.id AS etiId, eci.default_qty, eci.default_days, eci.default_hpd,
          eut.id as unitType
        FROM estimate_crew_items eci
        LEFT JOIN estimation_items ei ON eci.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        LEFT JOIN estimation_categories ec ON et.category_id = ec.id
        LEFT JOIN estimation_units eu ON ei.unit = eu.id
        LEFT JOIN estimation_unit_types eut ON eu.unit_type = eut.id
        WHERE eci.crew_id = " . $crewId;

        // Search
        $search = $this->ci->input->get('search');
        $searchVal = $search['value'];

        if ($searchVal) {
            $sql .= " AND (
                ei.name LIKE '%" . $searchVal . "%'
                OR et.name LIKE '%" . $searchVal . "%'
                OR ec.name LIKE '%" . $searchVal . "%')";
        }


        // Sorting
        $order = $this->ci->input->get('order');
        $sort = $order[0]['column'];
        $sortDir = $order[0]['dir'];
        $sortCol = '';

        switch ($sort) {

            case 0:
                $sortCol = 'eci.ord';
                break;

            case 1:
                $sortCol = 'et.name';
                break;

            case 2:
                $sortCol = 'ei.name';
                break;
        }

        $sql .= ' ORDER BY ' . $sortCol . " " . $sortDir;
        $sql .= ' LIMIT ' . $this->ci->input->get('length');
        $sql .= ' OFFSET ' . $this->ci->input->get('start');

        return $this->getAllResults($sql);
    }

    /**
     * @param $crewId
     * @return mixed
     */
    public function getEstimateCrewItemsCount($crewId)
    {
        $sql = "SELECT COUNT(*) AS numItems
            FROM estimate_crew_items eti
            WHERE eti.crew_id = " . $crewId;

        $result = $this->getSingleResult($sql);
        return $result->numItems;
    }

    /**
     * @param $itemId
     * @param $templateId
     */
    public function removeTemplateEstimationLineItem($itemId, $templateId)
    {
        $dql = "UPDATE \models\EstimationLineItem eli
        SET eli.template_id = NULL
        WHERE eli.item_id = :item_id
        AND eli.template_id = :template_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':template_id', $templateId);
        $query->setParameter(':item_id', $itemId);
        $query->execute();
    }

    /**
     * @param $phaselId
     * @return mixed
     */
    public function getPhaseItemMaxDays($phaselId)
    {
        $sql = "SELECT MAX(eli.days) AS maxdays
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaselId;

        $result = $this->getSingleResult($sql);

        return $result->maxdays;
    }

    public function updateProposalEstimate(Proposals $proposal, $is_completed)
    {

        //Get proposal Estimate
        $proposalEstimate = $this->em->getRepository('models\ProposalEstimate')->findOneBy(array(
            'proposal_id' => $proposal->getProposalId()));
        if ($proposalEstimate) {

            $materialItemCount = $this->getProposalCategoryItemCount($proposal->getProposalId(), \models\EstimationCategory::MATERIAL);
            $equipmentItemCount = $this->getProposalCategoryItemCount($proposal->getProposalId(), \models\EstimationCategory::EQUIPMENT);
            $laborItemCount = $this->getProposalCategoryItemCount($proposal->getProposalId(), \models\EstimationCategory::LABOR);
            $maxDays = $this->getProposalItemMaxDays($proposal->getProposalId());
            $completionPercentage = $this->calculate_estimate_completion_percentage($proposal->getProposalId());

            $proposalEstimate->setMaterial(($materialItemCount) ? 1 : 0);
            $proposalEstimate->setEquipment(($equipmentItemCount) ? 1 : 0);
            $proposalEstimate->setLabor(($laborItemCount) ? 1 : 0);
            $proposalEstimate->setDays($maxDays);
            $proposalEstimate->setStatusId($proposal->getEstimateStatusId());
            $proposalEstimate->setCompletionPercent($completionPercentage);
            if ($is_completed) {
                $proposalEstimate->setCompletedAt(date("Y-m-d H:i:s"));
            } else {
                $proposalEstimate->setCompletedAt(null);
            }

            $this->em->persist($proposalEstimate);
            $this->em->flush();
        }

    }

    /**
     * @param $proposalId
     * @param $categoryId
     * @return mixed
     */
    public function getProposalCategoryItemCount($proposalId, $categoryId)
    {
        $sql = "SELECT COUNT(eli.id) AS totalItems
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND et.category_id = " . (int)$categoryId;

        $result = $this->getSingleResult($sql);

        return $result->totalItems;
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalItemMaxDays($proposalId)
    {
        $sql = "SELECT MAX(eli.days) AS maxdays
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.proposal_id = " . (int)$proposalId;

        $result = $this->getSingleResult($sql);

        return $result->maxdays;
    }

    function calculate_estimate_completion_percentage($proposalId)
    {

        //get total proposal service count
        $dql = "SELECT COUNT(ps.serviceId)as total_services FROM \models\Proposal_services ps
        WHERE ps.proposal = :proposal_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposalId);
        $query->setMaxResults(1);
        $Proposal_services = $query->getResult();

        $total_proposal_services = $Proposal_services[0]['total_services'];

        //get completed service count
        $sql = "SELECT COUNT(ps.serviceId) AS total_completed_services
        FROM proposal_services ps
        LEFT JOIN estimates e ON ps.serviceId = e.proposal_service_id
        WHERE e.completed = '1' AND ps.proposal = " . $proposalId;

        $result = $this->getSingleResult($sql);

        $completed_proposal_services = $result->total_completed_services;

        if ($completed_proposal_services) {
            $proposal_estimate_completion_percent = number_format((($completed_proposal_services * 100) / $total_proposal_services), 2);
        } else {
            $proposal_estimate_completion_percent = 0;
        }

        return $proposal_estimate_completion_percent;
    }

    public function updateEstimatePhase(EstimationPhase $phase)
    {
        $materialItemCount = $this->getProposalPhaseCategoryItemCount($phase->getId(), \models\EstimationCategory::MATERIAL);
        $equipmentItemCount = $this->getProposalPhaseCategoryItemCount($phase->getId(), \models\EstimationCategory::EQUIPMENT);
        $laborItemCount = $this->getProposalPhaseCategoryItemCount($phase->getId(), \models\EstimationCategory::LABOR);
        $truckingItemCount = $this->getProposalPhaseTypeItemCount($phase->getId(), 20);

        $phase->setMaterial(($materialItemCount) ? 1 : 0);
        $phase->setEquipment(($equipmentItemCount) ? 1 : 0);
        $phase->setLabor(($laborItemCount) ? 1 : 0);
        $phase->setTrucking(($truckingItemCount) ? 1 : 0);

        $this->em->persist($phase);
        $this->em->flush();

    }

    public function getProposalPhaseCategoryItemCount($phaseId, $categoryId)
    {
        $sql = "SELECT COUNT(eli.id) AS totalItems
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        LEFT JOIN estimation_types et ON ei.type_id = et.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND et.category_id = " . (int)$categoryId;

        $result = $this->getSingleResult($sql);

        return $result->totalItems;
    }

    public function getProposalPhaseTypeItemCount($phaseId, $typeId)
    {
        $sql = "SELECT COUNT(eli.id) AS totalItems
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND ei.type_id = " . (int)$typeId;

        $result = $this->getSingleResult($sql);

        return $result->totalItems;
    }

    public function checkChildLineItemsDays($estimate_line_id, $days)
    {
        //print_r($days);die;
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE (eli.parent_line_item_id = :parentId
          OR eli.id = :parentId)
        AND eli.days != :newdays AND eli.days != 0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parentId', $estimate_line_id);
        $query->setParameter(':newdays', $days);

        return $query->getResult();
    }

    public function checkChildParentLineItemsDays($child_line_id, $estimate_line_id, $days)
    {
        //print_r($days);die;
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE  (eli.parent_line_item_id = :parentId
          OR eli.id = :parentId)
        AND eli.days != :newdays AND eli.days != 0 AND eli.id != :child_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':parentId', $estimate_line_id);
        $query->setParameter(':child_id', $child_line_id);
        $query->setParameter(':newdays', $days);

        return $query->getResult();
    }

    public function searchEstimationItemByName($itemName, Companies $company)
    {
        $itemName = '%' . $itemName . '%';
        $sql = "SELECT ei.id,ei.name as label,ei.name as value,ei.type_id,et.name as type_name,ec.name as category_name,ec.id as category_id
            FROM estimation_items ei
            LEFT JOIN estimation_types et ON ei.type_id = et.id
            LEFT JOIN estimation_categories ec ON et.category_id = ec.id
            WHERE (ei.company_id IS NULL OR ei.company_id =" . $company->getCompanyId() . "  ) AND ei.name LIKE '$itemName' AND ei.deleted ='0'";

        $result = $this->getAllResults($sql);
        $sql2 = "SELECT '0' as id,'Open type' as label,et.name as value,et.id as type_id,et.name as type_name,ec.name as category_name,ec.id as category_id
            FROM estimation_types et

            LEFT JOIN estimation_categories ec ON et.category_id = ec.id
            WHERE (et.company_id IS NULL OR et.company_id =" . $company->getCompanyId() . "  ) AND et.name LIKE '$itemName' AND et.deleted ='0'";

        $result2 = $this->getAllResults($sql2);
        $data = array_merge($result2, $result);
        //$difference = array_merge(array_diff($result,$result2), array_diff($result2,$result));
        return $data;
    }

    /**
     * @param Companies $company
     * @return int
     */
    public function getCompanyEstimatingItemCount(Companies $company)
    {
        return count($this->getCompanySortedItems($company));
    }

    /**
     * @param Companies $company
     * @return array
     * Retrieves the company list of sorted items
     */
    public function getCompanySortedItems(Companies $company)
    {
        $out = [];

        // Get the sorted Types
        $sortedTypes = $this->getCompanySortedTypes($company);

        // First level is categories - skip this
        foreach ($sortedTypes as $categoryId => $categoryTypes) {
            $out[$categoryId] = [];
            // Next level is the types
            foreach ($categoryTypes as $type) {
                $out[$categoryId][$type->getId()] = [];
                // Now we get the items
                $typeItems = $this->getCompanyTypeItems($company, $type);

                // Populate the array
                foreach ($typeItems as $item) {
                    $out[$categoryId][$type->getId()][] = $item;
                }
            }
        }

        return $out;
    }

    /**
     * @param Companies $company
     */
    public function migrateDefaultEstimatingItems(Companies $company)
    {
        $defaultItems = $this->getEstimationRepository()->getDefaultItems();

        foreach ($defaultItems as $defaultItem) {

            $dupeItem = clone $defaultItem;
            $dupeItem->setId(null);
            $dupeItem->setCompanyId($company->getCompanyId());
            $dupeItem->setDefaultItemId($defaultItem->getId());
            $this->em->persist($dupeItem);
            $this->em->flush();
        }
    }

    /**
     * @return array
     */
    public function getDefaultItems()
    {
        $dql = "SELECT ei FROM \models\EstimationItem ei
        WHERE ei.company_id IS NULL
        AND ei.id > 0
        AND ei.deleted = 0";

        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    public function createDemoCustomer(Companies $company)
    {
        $account = $company->getAdministrator();

        $clientAccount2 = new \models\ClientCompany();
        $clientAccount2->setCreated(time());
        $clientAccount2->setOwnerCompany($company);
        $clientAccount2->setOwnerUser($account);
        $clientAccount2->setName('CBRE');
        $this->em->persist($clientAccount2);

        $this->em->flush();

        /*
         * Step 1 - create clients
         */
        $client = new \models\Clients();
        $client->setFirstName('Mike2');
        $client->setLastName('Barrett');
        $client->setBusinessPhone('513-477-2727');
        $client->setEmail('mike@pavementlayers.com');
        $client->setCellPhone('513-477-2727');
        $client->setFax('');
        $client->setTitle('Property Manager');
        $client->setState('OH');
        $client->setWebsite(site_url());
        $client->setAddress('123 Main Street');
        $client->setCity('Cincinnati');
        $client->setZip('45227');
        $client->setCountry('USA');
        $client->setAccount($account);
        $client->setCompany($company);
        $client->setClientAccount($clientAccount2);
        $this->em->persist($client);
        //Client #2

        $this->em->flush();

        ///////////////////
        $openStatus = $client->getCompany()->getDefaultStatus(\models\Status::OPEN);
        //$ownerAccount = $this->em->find('models\Accounts', $this->input->post('owner'));

        $proposal = $this->getProposalRepository()->create($company->getCompanyId());
        $proposal->setProjectAddress('12345 Kenwood Rd');
        $proposal->setProjectCity('Cincinnati');
        $proposal->setProjectState('OH');
        $proposal->setProjectZip('45242');
        $proposal->setProjectName('Demo Project');
        $proposal->setProposalTitle('Demo Project');
        $proposal->setPaymentTerm($company->getPaymentTerm());
        $proposal->setClient($client);
        $proposal->setProposalStatus($openStatus);
        $proposal->setEmailStatus(\models\Proposals::EMAIL_UNSENT);
        $proposal->setOwner($account);
        $proposal->setCompanyId($company->getCompanyId());
        // Geocode
        $this->getProposalRepository()->setLatLng($proposal);

        //set the default texts selected in my account -> custom texts
        //$this->load->library('Repositories/CustomtextRepository');
        //$proposal->setTextsCategories($this->customtextrepository->getDefaultCategories($company->getCompanyId()));

        // Set the job number if set
        if ($company->getUseAutoNum()) {
            $proposal->setJobNumber($company->getProposalAutoNum());
        }

        //set up the default texts
        //$texts = $this->customtexts->getTexts($proposal->getClient()->getCompany()->getCompanyId());
        $txts = '';
        // $k = 0;
        // foreach ($texts as $textId => $text) {
        //     $k++;
        //     if ($text->getChecked() == 'yes') {
        //         $txts .= $textId;
        //         if ($k < count($texts)) {
        //             $txts .= ',';
        //         }
        //     }
        // }
        $proposal->setTexts($txts);
        $this->em->persist($proposal);
        $this->em->flush();
        
        //Create Proposal preview Client Link
        $this->getProposalRepository()->createClientProposalLink($proposal->getProposalId());

        //Copy All default Video 
        $this->getProposalRepository()->copyDefaultCompanyVideo($this->account()->getCompany()->getCompanyId(),$proposal->getProposalId());

        //Delete user query Cache
        $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($company->getCompanyId());

        /*
         * Add Services to the above proposals
         */
        $serviceIds = array(8 => '$6,000', 38 => '$6,900', 27 => '$54,380', 31 => '$74,280', 3 => '$2,374');
        $serviceFields = array(
            8 => array(
                'measurement' => '500',
                'area_unit' => 'square yards',
                'depth' => '2',
                'depth_unit' => 'Inches',
            ),
            38 => array(
                'lineal_feet_cracks' => '10,000'
            ),
            27 => array(
                'area' => '7,000',
                'area_unit' => 'square yards',
                'number_of_coats' => '2',
                'trips' => '1',
                'day_of_week' => 'Weekend',
                'application' => 'Spray',
                'warranty' => '1 Year',
            ),
            31 => array(
                'area_of_paving' => '1,000',
                'unit' => 'square yards',
                'tons_of_leveling' => '12',
                'depth_of_paving' => '2',
                'number_of_parking_blocks' => '57',
                'trips' => '2',
            ),
            3 => array(),
        );
        $k = 0;
        $proposal_services = array();
        $textCounter = 0;
        foreach ($serviceIds as $serviceId => $servicePrice) {
            $k++;
            //get service name and texts
            $service = $this->em->find('models\Services', $serviceId);
            if ($service) {
                $proposal_services[$k] = new \models\Proposal_services();
                $proposal_services[$k]->setOrd($k);
                $proposal_services[$k]->setPrice($servicePrice);
                $proposal_services[$k]->setProposal($proposal->getProposalId());
                $proposal_services[$k]->setInitialService($serviceId);
                $proposal_services[$k]->setServiceName($service->getServiceName());
                $proposal_services[$k]->setOptional(0);
                $proposal_services[$k]->setTax(0);
                $proposal_services[$k]->setApproved(1);
                $this->em->persist($proposal_services[$k]);
                $this->em->flush(); //save the proposal service so it has a valid ID
                //add the texts
                $txts = (getServiceTexts($serviceId, $company->getCompanyId()));
                $texts = array();
                foreach ($txts as $textValue) {
                    $textCounter++;
                    $text = new \models\Proposal_services_texts();
                    $text->setServiceId($proposal_services[$k]->getServiceId());
                    $text->setText($textValue);
                    $text->setOrd($textCounter);
                    $texts[$textCounter] = $text;
                    $this->em->persist($texts[$textCounter]);
                }
                //add the fields
                $fieldsCounter = 0;
                $fields = array();
                foreach ($serviceFields[$serviceId] as $fieldCode => $fieldValue) {
                    $fieldsCounter++;
                    $field = new \models\Proposal_services_fields();
                    $field->setServiceId($proposal_services[$k]->getServiceId());
                    $field->setFieldCode($fieldCode);
                    $field->setFieldValue($fieldValue);
                    $fields[$fieldsCounter] = $field;
                    $this->em->persist($fields[$fieldsCounter]);
                }
            }
        }
        $this->em->flush();

        $this->createDefaultPhases($company, $proposal);
        echo 'test2';
        die;
    }

    /**
     * @param Companies $company
     * @param Proposals $proposal
     */
    public function createDefaultPhases(Companies $company, Proposals $proposal)
    {
        $proposalServices = $proposal->getServices();

        if (count($proposalServices)) {

            foreach ($proposalServices as $proposalService) {
                $numPhases = count($this->getProposalServicePhases($proposalService, $proposal->getProposalId()));

                if ($numPhases < 1) {
                    $this->createDefaultPhase($company, $proposalService);
                }
            }
        }
    }

    /**
     * @param Companies $company
     * @param Proposal_services $proposalService
     * @return EstimationPhase
     * @description Create a default phase for a proposal service
     */
    public function createDefaultPhase(Companies $company, Proposal_services $proposalService)
    {
        // Load the service
        $parentService = $this->em->findService($proposalService->getInitialService());

        $defaultStages = $this->getCompanyDefaultEstimateStages($company, $parentService->getServiceId());

        if (count($defaultStages)) {
            foreach ($defaultStages as $defaultStage) {

                $defaultPhase = new EstimationPhase();
                $defaultPhase->setOrd(0);
                $defaultPhase->setComplete(0);
                $defaultPhase->setProposalServiceId($proposalService->getServiceId());
                $defaultPhase->setProposalId($proposalService->getProposal());
                $defaultPhase->setName($defaultStage->getName());
                $this->em->persist($defaultPhase);
            }
        } else {
            $defaultPhase = new EstimationPhase();
            $defaultPhase->setOrd(0);
            $defaultPhase->setComplete(0);
            $defaultPhase->setProposalServiceId($proposalService->getServiceId());
            $defaultPhase->setProposalId($proposalService->getProposal());
            $defaultPhase->setName('Phase 1');
            $this->em->persist($defaultPhase);
        }

        $this->em->flush();
    }

    /**
     * @param Companies $company
     * @param $serviceId
     * @return array
     */
    public function getCompanyDefaultEstimateStages(\models\Companies $company, $serviceId)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\EstimateDefaultStage', 'eds');
        $rsm->addFieldResult('eds', 'id', 'id');
        $rsm->addFieldResult('eds', 'company_id', 'company_id');
        $rsm->addFieldResult('eds', 'service_id', 'service_id');
        $rsm->addFieldResult('eds', 'name', 'name');
        $rsm->addFieldResult('eds', 'ord', 'ord');

        $dql = "SELECT eds.*
                FROM estimate_default_stages eds
                LEFT JOIN estimation_company_default_stages_order edcso ON eds.id = edcso.default_stage_id AND edcso.company_id = :company
                LEFT JOIN estimation_company_default_stages_deleted ecdsd ON eds.id = ecdsd.default_stage_id AND ecdsd.company_id = :company1
                WHERE (eds.company_id IS NULL
                  OR eds.company_id = :company2)
                AND ecdsd.id IS NULL
                AND eds.service_id = :serviceId
                ORDER BY COALESCE(edcso.ord, 99999), eds.ord, eds.id";

        $query = $this->em->createNativeQuery($dql, $rsm);
        $query->setParameter('company', $company->getCompanyId());
        $query->setParameter('company1', $company->getCompanyId());
        $query->setParameter('company2', $company->getCompanyId());
        $query->setParameter('serviceId', $serviceId);

        $stages = $query->getResult();

        return $stages;
    }

    public function assignAllEstimateCompanyServiceTypes(Companies $company)
    {
        $dql = "SELECT ecst
        FROM \models\EstimationCompanyServiceType ecst
        WHERE ecst.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());


        $types = [];

        $results = $query->getResult();
        if (!$results) {
            $EstimationCompanyServiceTypes = $this->db->query("SELECT 'null' as company_id,ecst.service_id,ecst.estimate_type_id FROM estimate_company_service_types as ecst
            where ecst.company_id = 0");

            foreach ($EstimationCompanyServiceTypes->result() as $EstimationCompanyServiceType) {

                $EstimationCompanyServiceType->id = null;
                $EstimationCompanyServiceType->company_id = $company->getCompanyId();

                $this->db->insert('estimate_company_service_types', $EstimationCompanyServiceType);

            }
        }


    }


    public function getAdminServices()
    {

        $dql = 'SELECT c
                FROM models\Services c
                WHERE c.parent = 0
                AND c.company IS NULL
                ORDER BY c.ord';

        $query = $this->em->createQuery($dql);


        return $query->getResult();
    }

    public function createDefualtPlantDump(Companies $company)
    {
        $dql = "SELECT ed
        FROM \models\EstimationPlant ed
        WHERE ed.company_id = :companyId";
        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $result = $query->getResult();
        if (!$result) {


            $addrString = $company->getCompanyAddress();

            if ($company->getCompanyCity()) {
                $addrString .= ' ' . $company->getCompanyCity();
            }

            if ($company->getCompanyState()) {
                $addrString .= ' ' . $company->getCompanyState();
            }

            if ($company->getCompanyState()) {
                $addrString .= ' ' . $company->getCompanyZip();
            }

            //print_r($addrString);die;
            $curl = new \Ivory\HttpAdapter\CurlHttpAdapter();
            $geocoder = new \Geocoder\Provider\GoogleMaps($curl, null, null, true, $_ENV['GOOGLE_API_SERVER_KEY']);
            //if(){}
            $geoResults = $geocoder->geocode($addrString);

            // echo '<pre>';
            // //echo $geoResults[0]->getLatitude();
            // print_r($geoResults);
            foreach ($geoResults as $geoResult) {
                $geoLatitude = $geoResult->getLatitude();
                $geoLongitude = $geoResult->getLongitude();
                // echo '<br/>';
            }
            //die;

            $plant = new EstimationPlant();

            $plant->setCompanyId($company->getCompanyId());
            $plant->setDeleted(0);

            $plant->setCompanyName($company->getCompanyName());
            $plant->setName($company->getCompanyName());
            $plant->setAddress($company->getCompanyAddress());
            $plant->setCity($company->getCompanyCity());
            $plant->setState($company->getCompanyState());
            $plant->setZip($company->getCompanyZip());
            $plant->setPhone($company->getCompanyPhone());
            $plant->setOrd(999);
            $plant->setLat($geoLatitude);
            $plant->setLng($geoLongitude);
            $plant->setPlant('1');
            $plant->setDump('0');
            // Save
            $this->em->persist($plant);


            $dump = new EstimationPlant();
            $dump->setCompanyId($company->getCompanyId());
            $dump->setDeleted(0);

            $dump->setCompanyName($company->getCompanyName());
            $dump->setName($company->getCompanyName());
            $dump->setAddress($company->getCompanyAddress());
            $dump->setCity($company->getCompanyCity());
            $dump->setState($company->getCompanyState());
            $dump->setZip($company->getCompanyZip());
            $dump->setPhone($company->getCompanyPhone());
            $dump->setOrd(999);
            $dump->setLat($geoLatitude);
            $dump->setLng($geoLongitude);
            $dump->setPlant('0');
            $dump->setDump('1');
            // Save
            $this->em->persist($dump);
            $this->em->flush();
        }
    }

    public function createDefaultTemplates(Companies $company)
    {
        $dql = "SELECT et
        FROM \models\EstimationTemplate et
        WHERE et.company_id = :companyId
        ORDER BY et.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        $result = $query->getResult();

        if (!$result) {
            $dql = "SELECT et
            FROM \models\EstimationTemplate et
            WHERE et.company_id = :companyId AND et.deleted =0";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':companyId', 0);

            $adminTemplates = $query->getResult();
            foreach ($adminTemplates as $adminTemplate) {

                $newTemplate = clone $adminTemplate;
                $newTemplate->setId(null);
                $newTemplate->setCompanyId($company->getCompanyId());
                $this->em->persist($newTemplate);
                $this->em->flush();

                $dql = "SELECT est
                FROM \models\EstimationServiceTemplate est
                WHERE est.company_id = :companyId AND est.template_id = :templateId";

                $query = $this->em->createQuery($dql);
                $query->setParameter(':companyId', 0);
                $query->setParameter(':templateId', $adminTemplate->getId());
                $estimationServiceTemplates = $query->getResult();

                foreach ($estimationServiceTemplates as $estimationServiceTemplate) {
                    $newEstimationServiceTemplate = clone $estimationServiceTemplate;
                    $newEstimationServiceTemplate->setCompanyId($company->getCompanyId());
                    $newEstimationServiceTemplate->setTemplateId($newTemplate->getId());

                    $this->em->persist($newEstimationServiceTemplate);
                }

                $dql = "SELECT eti
                FROM \models\EstimateTemplateItem eti
                WHERE eti.template_id = :template_id";

                $query = $this->em->createQuery($dql);
                $query->setParameter(':template_id', $adminTemplate->getId());

                $estimateTemplateItems = $query->getResult();

                foreach ($estimateTemplateItems as $estimateTemplateItem) {
                    // Get the company item, not the admin one
                    $companyDefaultItem = $this->getCompanyDefaultItem($company, $estimateTemplateItem->getItemId());

                    if ($companyDefaultItem) {
                        $newEstimateTemplateItem = clone $estimateTemplateItem;
                        $newEstimateTemplateItem->setId(null);
                        $newEstimateTemplateItem->setTemplateId($newTemplate->getId());
                        $newEstimateTemplateItem->setItemId($companyDefaultItem->getId());

                        $this->em->persist($newEstimateTemplateItem);
                    }
                }

                $this->em->flush();
            }
        }
    }

    public function getAdminTemplates()
    {

        $dql = 'SELECT et
                FROM models\EstimationTemplate et
                WHERE et.company_id = 0 AND et.deleted=0
                ORDER BY et.ord';

        $query = $this->em->createQuery($dql);


        return $query->getResult();
    }

    public function getEstimatesStartedCount()
    {
        $CI =& get_instance();
        $CI->load->library('session');
        // $this->session->userdata('pFilterEmailStatus');
        $sql = "SELECT COUNT(pe.id) AS numLineItems
        FROM proposal_estimates pe";
        if ($CI->session->userdata('pECreatedFrom')) {
            $start = $CI->session->userdata('pECreatedFrom');
            $sql .= " WHERE (pe.created_at >= '$start')";
        }
        // Created Date To
        if ($CI->session->userdata('pECreatedTo')) {
            $end = $CI->session->userdata('pECreatedTo');
            $sql .= " AND (pe.created_at <= '$end')";
        }
        //echo $sql;die;
        $result = $this->getSingleResult($sql);

        return $result->numLineItems;
    }

    public function getEstimatesCompletedCount()
    {
        $CI =& get_instance();
        $CI->load->library('session');
        $status = \models\EstimateStatus::COMPLETE;
        $sql = "SELECT COUNT(pe.id) AS numLineItems
        FROM proposal_estimates pe
        where status_id = " . $status;

        if ($CI->session->userdata('pECreatedFrom')) {
            $start = $CI->session->userdata('pECreatedFrom');
            $sql .= " AND (pe.created_at >= '$start')";
        }
        // Created Date To
        if ($CI->session->userdata('pECreatedTo')) {
            $end = $CI->session->userdata('pECreatedTo');
            $sql .= " AND (pe.created_at <= '$end')";
        }
        $result = $this->getSingleResult($sql);

        return $result->numLineItems;
    }

    public function getEstimatedValueTotal()
    {
        $CI =& get_instance();
        $CI->load->library('session');
        $sql = "SELECT SUM(p.price) AS total
        FROM proposal_estimates pe
        LEFT JOIN proposals p ON pe.proposal_id = p.proposalId";

        if ($CI->session->userdata('pECreatedFrom')) {
            $start = $CI->session->userdata('pECreatedFrom');
            $sql .= " WHERE (pe.created_at >= '$start')";
        }
        // Created Date To
        if ($CI->session->userdata('pECreatedTo')) {
            $end = $CI->session->userdata('pECreatedTo');
            $sql .= " AND (pe.created_at <= '$end')";
        }
        $result = $this->getSingleResult($sql);

        return $result->total;
    }

    public function getAdminPieChartData()
    {
        $CI =& get_instance();
        $CI->load->library('session');
        $sql = "SELECT count(pe.id) AS value, es.name as name
        FROM proposal_estimates pe
        LEFT JOIN estimate_statuses es ON pe.status_id = es.id";
        if ($CI->session->userdata('pECreatedFrom')) {
            $start = $CI->session->userdata('pECreatedFrom');
            $sql .= " WHERE (pe.created_at >= '$start')";
        }
        // Created Date To
        if ($CI->session->userdata('pECreatedTo')) {
            $end = $CI->session->userdata('pECreatedTo');
            $sql .= " AND (pe.created_at <= '$end')";
        }
        $sql .= " group by pe.status_id";

        $result = $this->getAllResults($sql);

        return $result;
    }

    public function getEstimatesCompanyCount()
    {
        $CI =& get_instance();
        $CI->load->library('session');
        $sql = "SELECT COUNT(DISTINCT c.company) AS total
        FROM proposal_estimates pe
        LEFT JOIN proposals p ON pe.proposal_id = p.proposalId
        LEFT JOIN clients c ON p.client = c.clientId";

        if ($CI->session->userdata('pECreatedFrom')) {
            $start = $CI->session->userdata('pECreatedFrom');
            $sql .= " WHERE (pe.created_at >= '$start')";
        }
        // Created Date To
        if ($CI->session->userdata('pECreatedTo')) {
            $end = $CI->session->userdata('pECreatedTo');
            $sql .= " AND (pe.created_at <= '$end')";
        }
        //echo $sql .= " group by c.company";
        $result = $this->getSingleResult($sql);

        return $result->total;
    }

    function getHighestEstimateBid($companyId)
    {

        $sql = "SELECT MAX(p.price) AS maxPrice
        FROM proposal_estimates pe
        LEFT JOIN proposals p ON pe.proposal_id = p.proposalId
        --LEFT JOIN clients c ON p.client = c.clientId
        WHERE p.company_id =" . $companyId;

        $result = $this->getSingleResult($sql);
        return $result->maxPrice;
    }

    public function deleteDumpLineItem($lineItemId)
    {

        $dql = "DELETE \models\EstimationLineItem eli
        WHERE eli.dump_trucking_id = :lineItemId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':lineItemId', $lineItemId);
        $query->execute();

    }

    public function getPhaseTemplatesTotal($phaseId)
    {
        $dql = "SELECT eli.id,eli.total_price,eli.template_id,eli.days,eli.hours_per_day,eli.unit_price
        FROM \models\EstimationLineItem eli
        WHERE   eli.phase_id = :phase_id AND eli.fixed_template =1 ";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':phase_id', $phaseId);

        return $query->getResult();
    }

    public function deleteFixedParentTemplateItem($template_id, $phase_id)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.template_id = :template_id
        AND eli.phase_id =:phase_id
        AND eli.fixed_template =1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':template_id', $template_id);
        $query->setParameter(':phase_id', $phase_id);
        $items = $query->getResult();
        foreach ($items as $item) {
            $this->em->remove($item);
        }

        $this->em->flush();
    }

    public function deleteFixedTemplateItem($template_id, $phase_id)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.template_id = :template_id
        AND eli.phase_id =:phase_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':template_id', $template_id);
        $query->setParameter(':phase_id', $phase_id);
        $items = $query->getResult();

        foreach ($items as $item) {
            $this->em->remove($item);
        }

        $this->em->flush();
        return count($items);
    }

    public function getFixedParentTemplateItem($template_id, $phase_id)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.template_id = :template_id
        AND eli.phase_id =:phase_id
        AND eli.fixed_template =1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':template_id', $template_id);
        $query->setParameter(':phase_id', $phase_id);
        $items = $query->getResult();
        if ($items) {
            return $items[0];
        } else {
            return NULL;
        }

    }

    public function getSavedEstimateTemplateItem($template_id, $phase_id)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.template_id = :template_id
        AND eli.phase_id =:phase_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':template_id', $template_id);
        $query->setParameter(':phase_id', $phase_id);
        $items = $query->getResult();
        if ($items) {
            return $items;
        } else {
            return NULL;
        }

    }

    public function getFixedChildTemplateItem($template_id, $phase_id)
    {
        $dql = "SELECT eli
        FROM \models\EstimationLineItem eli
        WHERE eli.template_id = :template_id
        AND eli.phase_id =:phase_id
        AND eli.fixed_template =2";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':template_id', $template_id);
        $query->setParameter(':phase_id', $phase_id);
        $items = $query->getResult();
        return $items;
    }



    public function distributeEstimatingItem(EstimationItem $item)
    {
        $companies = $this->getEstimationEnabledCompanies();

        foreach ($companies as $company) {
            $dupeItem = clone $item;
            $dupeItem->setId(null);
            $dupeItem->setCompanyId($company->getCompanyId());
            $dupeItem->setDefaultItemId($item->getId());
            $this->em->persist($dupeItem);
            $this->em->flush();
        }
    }

    /**
     * @return array
     */
    public function getEstimationEnabledCompanies()
    {
        $dql = "SELECT c
        FROM \models\Companies c
        WHERE c.estimating = 1";

        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    /**
     * Returns an array of proposal objects - proposals belonging to a company with the specified estimate status
     * @param Companies $company
     * @return array|Proposals
     */
    public function getCompanyEstimatedProposals($companyId)
    {
        $sql = "SELECT proposals.proposalId
                FROM proposals
                --LEFT JOIN clients ON proposals.client = clients.clientId
                WHERE proposals.estimate_status_id > 1 AND proposals.company_id = " . $companyId;

        $results = $this->db->query($sql)->result();

        $out = [];

        foreach ($results as $result) {
            $proposal = $this->em->findProposal($result->proposalId);
            if ($proposal) {
                $out[] = $proposal;
            }
        }

        return $out;
    }

    public function deleteComapnyAllTemplates($companyId)
    {

        $dql = "SELECT et
        FROM \models\EstimationTemplate et
        WHERE et.company_id = :companyId
        ORDER BY et.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);

        $templates = $query->getResult();

        foreach ($templates as $template) {
            $this->deleteTemplateItems($template);
            $this->em->remove($template);
        }

        $this->em->flush();
    }

    /**
     * Removes all records of items in a template. Used when deleting a template
     * @param EstimationTemplate $template
     */
    public function deleteTemplateItems(EstimationTemplate $template)
    {
        $dql = "DELETE \models\EstimateTemplateItem eti
        WHERE eti.template_id = :templateId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':templateId', $template->getId());
        $query->execute();
    }

    /**
     * @param Companies $company
     */
    public function deleteCompanyAllItems($companyId)
    {

        $dql = "DELETE \models\EstimationItem ei
        WHERE ei.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);
        $query->execute();
    }

    /**
     * Reset all estimate data for a proposal
     * @param Proposals $proposal
     */
    public function resetProposalEstimation(Proposals $proposal)
    {


        // Delete the line items
        $this->clearProposalLineItems($proposal);

        // Get the proposal services
        $proposalServices = $proposal->getServices();

        foreach ($proposalServices as $proposalService) {
            /* @var Proposal_services $proposalService */
            $this->deleteProposalServiceCalculatorValues($proposalService->getServiceId());
            // Update the price of the Proposal Service
            $proposalService->setPrice(0);
            $proposalService->setTaxPrice('0.00');
            $this->em->persist($proposalService);

            // Get the estimate and update the status and price
            $estimate = $this->em->getRepository('\models\Estimate')->findOneBy([
                'proposal_service_id' => $proposalService->getServiceId()
            ]);
            if ($estimate) {
                $estimate->setTotalPrice('0.00');
                $estimate->setCompleted('0');
                $this->em->persist($estimate);
            }

            // Get the phases
            $phases = $this->getProposalServicePhases($proposalService, $proposal->getProposalId());

            foreach ($phases as $phase) {
                // Update phase status
                $this->resetPhase($phase);
            }

        }

        // Flush to DB
        $this->em->flush();
    }

    /**
     * @param $proposalServiceId
     */
    public function deleteProposalServiceCalculatorValues($proposalServiceId)
    {
        $dql = "DELETE \models\EstimationCalculatorValue ecv
        WHERE ecv.proposal_service_id = :proposalServiceId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $proposalServiceId);
        $query->execute();
    }

    /**
     * @param Companies $company
     * @param $adminDefaultItemId
     * @return mixed
     */
    public function getCompanyDefaultItem(Companies $company, $adminDefaultItemId)
    {
        $dql = "SELECT ei
        FROM \models\EstimationItem ei
        WHERE ei.company_id = :companyId
        AND ei.default_item_id = :default_item_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':default_item_id', $adminDefaultItemId);

        return $query->getSingleResult();
    }

    /**
     * @param Companies $company
     * @param $serviceId
     */
    public function clearCompanyPhaseOrder(Companies $company, $serviceId)
    {
        $dql = "DELETE \models\EstimationCompanyPhaseOrder ecpo
        WHERE ecpo.service_id = :serviceId
        AND ecpo.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':serviceId', $serviceId);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->execute();
    }

    /**
     * @param $proposalId
     * @return array
     */
    public function getProposalLineItemsCount($proposalId)
    {
        $dql = "SELECT COUNT(eli.id) as item_count
        FROM \models\EstimationLineItem eli
        WHERE eli.proposal_id = :proposalId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalId', $proposalId);
        $result = $query->getSingleResult();

        return $result['item_count'];
    }

    public function pricePerUnit($measurement, $price, $unit)
    {

        if (!$measurement || !$price || !$unit) {
            return '-';
        }

        $remove = ['$', ','];
        $replace = ['', ''];

        $measurement = floatval(str_replace($remove, $replace, $measurement));
        $price = floatval(str_replace($remove, $replace, $price));

        $rate = $price / $measurement;
        $formattedRate = number_format($rate, 2);

        if (substr($unit, -1) == 's') {
            $unit = substr($unit, 0, -1);
        }

        return '$' . $formattedRate . ' / ' . ucwords($unit);
    }


    /**\
     * @param Proposal_services $service
     * @param $typeId
     * @return mixed
     */
    public function serviceHasItemOfType(Proposal_services $service, $typeId)
    {
        $sql = "SELECT COUNT(eli.id) AS totalItems
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.proposal_service_id = " . $service->getServiceId() . "
        AND ei.type_id = " . $typeId;

        $result = $this->getSingleResult($sql);

        return $result->totalItems;
    }

    /**
     * @param $phaseId
     * @param $typeId
     * @return mixed
     */
    public function phaseHasItemOfType($phaseId, $typeId)
    {
        $sql = "SELECT COUNT(eli.id) AS totalItems
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.phase_id = " . $phaseId . "
        AND ei.type_id = " . $typeId;

        $result = $this->getSingleResult($sql);

        return $result->totalItems;
    }

    /**
     * @param Proposal_services $service
     * @return mixed
     */
    public function getServiceMaxTonsValue(Proposal_services $service)
    {
        $asphaltService = $this->getServiceAsphaltItem($service);
        return $asphaltService->getQuantity();
    }

    /**
     * @param $phaseId
     * @return mixed
     */
    public function getPhaseMaxTonsValue($phaseId)
    {
        $asphaltService = $this->getPhaseAsphaltItem($phaseId);
        return $asphaltService->getQuantity();
    }

    /**
     * @param $price
     * @param $tons
     * @return string
     */
    public function pricePerTon($price, $tons)
    {
        if (!$price || !$tons) {
            return '-';
        }

        $remove = ['$', ','];
        $replace = ['', ''];

        $price = floatval(str_replace($remove, $replace, $price));

        $rate = $price / $tons;
        $formattedRate = number_format($rate, 2);

        return '$' . $formattedRate;
    }

    /**
     * @param Proposal_services $service
     * @return EstimationLineItem|null
     */
    public function getServiceAsphaltItem(Proposal_services $service)
    {
        $sql = "SELECT eli.id AS lineItemId
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.proposal_service_id = " . $service->getServiceId() . "
        AND ei.type_id = " . EstimationType::ASPHALT . "
        LIMIT 1";

        $result = $this->getSingleResult($sql);
        $lineItemId = $result->lineItemId;

        $asphaltLineItem = $this->em->findEstimationLineItem($lineItemId);

        if ($asphaltLineItem) {
            return $asphaltLineItem;
        }

        return null;
    }

    /**
     * @param $phaseId
     * @return EstimationLineItem|null
     */
    public function getPhaseAsphaltItem($phaseId)
    {
        $sql = "SELECT eli.id AS lineItemId
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.phase_id = " . $phaseId . "
        AND ei.type_id = " . EstimationType::ASPHALT . "
        LIMIT 1";

        $result = $this->getSingleResult($sql);
        $lineItemId = $result->lineItemId;

        $asphaltLineItem = $this->em->findEstimationLineItem($lineItemId);

        if ($asphaltLineItem) {
            return $asphaltLineItem;
        }

        return null;
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);

          if ($unit == "K") {
            return ($miles * 1.609344);
          } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
            return $miles;
          }
        }
      }


      function create_demo_estimate($company,$account,$client){

        $items = $this->getEstimationRepository()->getAllCompanyItems($company);

        if(!$items){
           $this->getEstimationRepository()->migrateDefaultEstimatingItems($company);
        }
        
        $this->getEstimationRepository()->createDefualtPlantDump($company);
        $this->getEstimationRepository()->createDefaultTemplates($company);

        $proposalRepository = new \Pms\Repositories\Proposal();
        /*
         * Adding of 6x Proposals to populate the Pie Chart
         */
        $proposal = $proposalRepository->create();
        $proposal->setProjectAddress('123 Main');
        $proposal->setProjectCity('Cincinnati');
        $proposal->setProjectState('OH');
        $proposal->setProjectZip('45227');
        $proposal->setProjectName('Green Acre Apartment');
        $proposal->setProposalTitle('Pavement Maintenance Proposal');
        $proposal->setPaymentTerm($company->getPaymentTerm());
        $proposal->setOwner($account);
        $proposal->setCompanyId($company->getCompanyId());
        //$proposal->setStatus('Open');
        //new status system - unnecessary step added in all the places
        //$this->load->database();
        $openStatus = $client->getCompany()->getDefaultStatus(\models\Status::OPEN);
        $proposal->setProposalStatus($openStatus);
        $proposal->setStatusChangeDate(time());
        //set up the default texts
        // $texts = $this->customtexts->getTexts($company->getCompanyId());
        // $txts = '';
        // $k = 0;
        // foreach ($texts as $textId => $text) {
        //     $k++;
        //     if ($text->getChecked() == 'yes') {
        //         $txts .= $textId;
        //         if ($k < count($texts)) {
        //             $txts .= ',';
        //         }
        //     }
        // }
        $proposal->setPaymentTerm(20);
        //$proposal->setTexts($txts);
        $proposal->setClient($client);
        $this->em->persist($proposal);
        $this->em->flush();
                //Delete user query Cache
                $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($company->getCompanyId());
        /*
         * Add Services to the above proposals
         */
        $serviceIds = array(8 => '$6,000', 38 => '$6,900', 27 => '$54,380', 31 => '$74,280', 3 => '$2,374');
        $serviceFields = array(
            8 => array(
                'measurement' => '500',
                'area_unit' => 'square yards',
                'depth' => '2',
                'depth_unit' => 'Inches',
            ),
            38 => array(
                'lineal_feet_cracks' => '10,000'
            ),
            27 => array(
                'area' => '7,000',
                'area_unit' => 'square yards',
                'number_of_coats' => '2',
                'trips' => '1',
                'day_of_week' => 'Weekend',
                'application' => 'Spray',
                'warranty' => '1 Year',
            ),
            31 => array(
                'area_of_paving' => '1,000',
                'unit' => 'square yards',
                'tons_of_leveling' => '12',
                'depth_of_paving' => '2',
                'number_of_parking_blocks' => '57',
                'trips' => '2',
            ),
            3 => array(),
        );

        $asphalt_miling_repair_phase_id = 0;//8
        $new_asphalt_pavement_overlay_phase_id = 0;//31
        // $asphalt_miling_repair_phase_id = 0;
        // $asphalt_miling_repair_phase_id = 0;
        // $asphalt_miling_repair_phase_id = 0;
        $k = 0;
        $proposal_services = array();
        $textCounter = 0;
        foreach ($serviceIds as $serviceId => $servicePrice) {
            $k++;
            //get service name and texts
            $service = $this->em->find('models\Services', $serviceId);
            if ($service) {
                $proposal_services[$k] = new \models\Proposal_services();
                $proposal_services[$k]->setOrd($k);
                $proposal_services[$k]->setPrice($servicePrice);
                $proposal_services[$k]->setProposal($proposal->getProposalId());
                $proposal_services[$k]->setInitialService($serviceId);
                $proposal_services[$k]->setServiceName($service->getServiceName());
                $proposal_services[$k]->setOptional(0);
                $proposal_services[$k]->setTax(0);
                $proposal_services[$k]->setApproved(1);
                $this->em->persist($proposal_services[$k]);
                $this->em->flush(); //save the proposal service so it has a valid ID

                $defaultPhase = new EstimationPhase();
                $defaultPhase->setOrd(0);
                $defaultPhase->setComplete(0);
                $defaultPhase->setProposalServiceId($proposal_services[$k]->getServiceId());
                $defaultPhase->setProposalId($proposal_services[$k]->getProposal());
                $defaultPhase->setName('Phase 1');
                $this->em->persist($defaultPhase);
                $this->em->flush();
                if($serviceId ==8){
                    $asphalt_miling_repair_phase_id = $defaultPhase->getId();
                    $asphalt_miling_repair_proposal_service_id =$proposal_services[$k]->getServiceId();
                }else if($serviceId ==38){
                    $crack_sealing_phase_id = $defaultPhase->getId();
                    $crack_sealing_proposal_service_id =$proposal_services[$k]->getServiceId();
                }else if($serviceId ==31){
                    $new_asphalt_pavement_overlay_phase_id = $defaultPhase->getId();
                    $new_asphalt_pavement_overlay_proposal_service_id =$proposal_services[$k]->getServiceId();
                }else if($serviceId ==3){
                    $line_striping_phase_id = $defaultPhase->getId();
                    $line_striping_proposal_service_id =$proposal_services[$k]->getServiceId();
                }else if($serviceId ==27){
                    $sealcoat_phase_id = $defaultPhase->getId();
                    $sealcoat_proposal_service_id =$proposal_services[$k]->getServiceId();
                }
                //add the texts
                $txts = (getServiceTexts($serviceId, $company->getCompanyId()));
                $texts = array();
                foreach ($txts as $textValue) {
                    $textCounter++;
                    $text = new \models\Proposal_services_texts();
                    $text->setServiceId($proposal_services[$k]->getServiceId());
                    $text->setText($textValue);
                    $text->setOrd($textCounter);
                    $texts[$textCounter] = $text;
                    $this->em->persist($texts[$textCounter]);
                }
                $this->em->flush();
                //add the fields
                $fieldsCounter = 0;
                $fields = array();
                foreach ($serviceFields[$serviceId] as $fieldCode => $fieldValue) {
                    $fieldsCounter++;
                    $field = new \models\Proposal_services_fields();
                    $field->setServiceId($proposal_services[$k]->getServiceId());
                    $field->setFieldCode($fieldCode);
                    $field->setFieldValue($fieldValue);
                    $fields[$fieldsCounter] = $field;
                    $this->em->persist($fields[$fieldsCounter]);
                }
                $this->em->flush();
            }
        }

       // $this->getEstimationRepository()->createDefaultPhases($account->getCompany(), $proposal);
        // create default ProposalEstimate if needed
        $this->getEstimationRepository()->createDefaultProposalEstimate($proposal);

        ///Add ashpalt Item
        $companyDefaultItem = $this->getCompanyDefaultItem($company, '131');


        $eli = new EstimationLineItem();
         //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
            // Proposal ID
            $eli->setProposalId($proposal->getProposalId());
            // ProposalService ID
            $eli->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
            // Item ID
            $eli->setItemId($companyDefaultItem->getId());
            // Phase ID
            $eli->setPhaseId($asphalt_miling_repair_phase_id);
            // Sub ID
            $eli->setSubId(0);
            // Unit Price
            $eli->setUnitPrice('42.48');
            // Custom Unit Price - 0 or 1
            $eli->setCustomUnitPrice(1);
            // Quantity
            $eli->setQuantity('55.00');
            // Total Price
            $eli->setTotalPrice('2336.40');
            // Base price
            $eli->setBasePrice('36.00');
            // setOverheadRate
            $eli->setOverheadRate('9.00');
            // set Profit Rate
            $eli->setOverheadPrice('178.20');
            // set OverheadPrice
            $eli->setProfitRate('9.00');
            // set Profit Price
            $eli->setProfitPrice('178.20');
            // Set Tax Rate
            $eli->setTaxRate('0.00');
            // Set Tax Price
            $eli->setTaxPrice('0.00');
            // Set Plant ID
            $eli->setPlantId(null);
            // Set Template ID
            $eli->setTemplateId(null);
            // Set day
            $eli->setDay(0);
            // Set Num people
            $eli->setNumPeople(0);
            // Set hours_per_day
            $eli->setHoursPerDay('0.00');

            $eli->setCustomTotalPrice(0);
            // Set Expected total
            $eli->setExpectedTotal('1980.00');
            // Save it
            $this->em->persist($eli);
            $this->em->flush();
            // Update the phase status - pass by reference to update
           

                $scv = new \models\EstimationCalculatorValue();
         
        
            $valuesText = '[{"name":"measurement","value":"500"},{"name":"measurement_unit","value":"square yards"},{"name":"depth","value":"2"},{"name":"cal_overhead","value":"9.00%"},{"name":"cal_profit","value":"9.00%"},{"name":"cal_trucking_oh","value":"10.00%"},{"name":"cal_trucking_pm","value":"10.00%"},{"name":"cal_tax","value":"0%"}]';
            

            $scv->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
            $scv->setItemId($companyDefaultItem->getId());
            $scv->setSavedValues($valuesText);
            $scv->setCalculatorName('asphalt_form');
            $scv->setLineItemId($eli->getId());
            $this->em->persist($scv);
            $this->em->flush();


        // Add trucking child            
        $companyDefaultItem2 = $this->getCompanyDefaultItem($company, '121');
            $dql = "SELECT ed
            FROM \models\EstimationPlant ed
            WHERE ed.company_id = :companyId";
            $query = $this->em->createQuery($dql);
            $query->setParameter(':companyId', $company->getCompanyId());
            $plants = $query->getResult();
            $plant  = $plants[0];
            $eli2 = new EstimationLineItem();
         //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
            // Proposal ID
            $eli2->setProposalId($proposal->getProposalId());
            // ProposalService ID
            $eli2->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
            // Item ID
            $eli2->setItemId($companyDefaultItem2->getId());
            // Phase ID
            $eli2->setPhaseId($asphalt_miling_repair_phase_id);
            $eli2->setParentLineItemId($eli->getId());
            // Sub ID
            $eli2->setSubId(0);
            // Unit Price
            $eli2->setUnitPrice('59.00');
            // Custom Unit Price - 0 or 1
            $eli2->setCustomUnitPrice(1);
            // Quantity
            $eli2->setQuantity('6.00');
            // Total Price
            $eli2->setTotalPrice('354.00');
            // Base price
            $eli2->setBasePrice('50.00');
            // setOverheadRate
            $eli2->setOverheadRate('9.00');
            // set Profit Rate
            $eli2->setOverheadPrice('24.00');
            // set OverheadPrice
            $eli2->setProfitRate('9.00');
            // set Profit Price
            $eli2->setProfitPrice('24.00');
            // Set Tax Rate
            $eli2->setTaxRate('0.00');
            // Set Tax Price
            $eli2->setTaxPrice('0.00');
            // Set Plant ID
            $eli2->setPlantId(null);
            // Set Template ID
            $eli2->setTemplateId(null);
            // Set day
            $eli2->setDay(1);
            // Set Num people
            $eli2->setNumPeople(1);
            // Set hours_per_day
            $eli2->setHoursPerDay('4.92');

            $eli2->setCustomTotalPrice(0);
            // Set Expected total
            $eli2->setExpectedTotal('300.00');
            // Save it
            $this->em->persist($eli2);
            $this->em->flush();
            // Update the phase status - pass by reference to update
           

                $scv = new \models\EstimationCalculatorValue();
         
        
            $valuesText = '[{"name":"trucking_item","value":"'.$companyDefaultItem2->getId().'"},{"name":"cal_overhead","value":"9.00%"},{"name":"cal_profit","value":"9.00%"},{"name":"truck_capacity","value":"15"},{"name":"plantselect","value":"'.$plant->getId().'"},{"name":"child_trucking_start_searchBox","value":""},{"name":"trucking_start_lat","value":""},{"name":"trucking_start_long","value":""},{"name":"dumpselect","value":""},{"name":"child_trucking_end_searchBox","value":""},{"name":"trucking_end_lat","value":""},{"name":"trucking_end_long","value":""},{"name":"trip_time","value":"25"},{"name":"site_turnaround2","value":""},{"name":"plant_turnaround","value":"0.25"},{"name":"site_turnaround","value":"0.25"},{"name":"hours_per_day","value":"8"},{"name":"child_minimum_hours","value":"6"},{"name":"daily_production_rate","value":"55"},{"name":"trip_miles","value":"8"},{"name":"total_trips","value":"4"},{"name":"trucking_day","value":"1"},{"name":"truck_per_day","value":"1"},{"name":"total_time_hours","value":"6"},{"name":"dump_rate","value":"$0"},{"name":"hours_per_trucks","value":"4.92"}]';
            

            $scv->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
            $scv->setItemId($companyDefaultItem2->getId());
            $scv->setSavedValues($valuesText);
            $scv->setCalculatorName(null);
            $scv->setLineItemId($eli2->getId());
            $this->em->persist($scv);
            $this->em->flush();

            $companyDefaultItem3 = $this->getCompanyDefaultItem($company, '141');


        $eli3 = new EstimationLineItem();
         //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
            // Proposal ID
            $eli3->setProposalId($proposal->getProposalId());
            // ProposalService ID
            $eli3->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
            // Item ID
            $eli3->setItemId($companyDefaultItem3->getId());
            // Phase ID
            $eli3->setPhaseId($asphalt_miling_repair_phase_id);
            //$eli3->setParentLineItemId($eli->getId());
            // Sub ID
            $eli3->setSubId(0);
            // Unit Price
            $eli3->setUnitPrice('177.00');
            // Custom Unit Price - 0 or 1
            $eli3->setCustomUnitPrice(1);
            // Quantity
            $eli3->setQuantity('64.00');
            // Total Price
            $eli3->setTotalPrice('11328.00');
            // Base price
            $eli3->setBasePrice('150.00');
            // setOverheadRate
            $eli3->setOverheadRate('9.00');
            // set Profit Rate
            $eli3->setOverheadPrice('864.00');
            // set OverheadPrice
            $eli3->setProfitRate('9.00');
            // set Profit Price
            $eli3->setProfitPrice('864.00');
            // Set Tax Rate
            $eli3->setTaxRate('0.00');
            // Set Tax Price
            $eli3->setTaxPrice('0.00');
            // Set Plant ID
            $eli3->setPlantId(null);
            // Set Template ID
            $eli3->setTemplateId(null);
            // Set day
            $eli3->setDay(2);
            // Set Num people
            $eli3->setNumPeople(4);
            // Set hours_per_day
            $eli3->setHoursPerDay('8.00');

            $eli3->setCustomTotalPrice(0);
            // Set Expected total
            $eli3->setExpectedTotal('9600.00');
            // Save it
            $this->em->persist($eli3);
            $this->em->flush();
            // Update the phase status - pass by reference to update
           

                $scv = new \models\EstimationCalculatorValue();
         
        
            $valuesText = '[{"name":"time_type_input","value":"2"},{"name":"number_of_person","value":"4"},{"name":"hour_per_day","value":"8"},{"name":"excavator_measurement","value":""},{"name":"excavator_measurement_unit","value":"square yards"},{"name":"excavator_depth","value":""},{"name":"cal_overhead","value":"9.00%"},{"name":"cal_profit","value":"9.00%"},{"name":"cal_tax","value":"0%"}]';
            

            $scv->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
            $scv->setItemId($companyDefaultItem3->getId());
            $scv->setSavedValues($valuesText);
            $scv->setCalculatorName('time_type_form');
            $scv->setLineItemId($eli3->getId());
            $this->em->persist($scv);
            $this->em->flush();
            $this->getEstimationRepository()->updatePhaseStatus($eli3->getPhase());

            $companyDefaultItem4 = $this->getCompanyDefaultItem($company, '114');


        $eli4 = new EstimationLineItem();
         //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
            // Proposal ID
            $eli4->setProposalId($proposal->getProposalId());
            // ProposalService ID
            $eli4->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
            // Item ID
            $eli4->setItemId($companyDefaultItem4->getId());
            // Phase ID
            $eli4->setPhaseId($asphalt_miling_repair_phase_id);
            //$eli3->setParentLineItemId($eli->getId());
            // Sub ID
            $eli4->setSubId(0);
            // Unit Price
            $eli4->setUnitPrice('44.84');
            // Custom Unit Price - 0 or 1
            $eli4->setCustomUnitPrice(1);
            // Quantity
            $eli4->setQuantity('32.00');
            // Total Price
            $eli4->setTotalPrice('1434.88');
            // Base price
            $eli4->setBasePrice('38.00');
            // setOverheadRate
            $eli4->setOverheadRate('9.00');
            // set Profit Rate
            $eli4->setOverheadPrice('109.44');
            // set OverheadPrice
            $eli4->setProfitRate('9.00');
            // set Profit Price
            $eli4->setProfitPrice('109.44');
            // Set Tax Rate
            $eli4->setTaxRate('0.00');
            // Set Tax Price
            $eli4->setTaxPrice('0.00');
            // Set Plant ID
            $eli4->setPlantId(null);
            // Set Template ID
            $eli4->setTemplateId(null);
            // Set day
            $eli4->setDay(1);
            // Set Num people
            $eli4->setNumPeople(4);
            // Set hours_per_day
            $eli4->setHoursPerDay('8.00');

            $eli4->setCustomTotalPrice(0);
            // Set Expected total
            $eli4->setExpectedTotal('1216.00');
            // Save it
            $this->em->persist($eli4);
            $this->em->flush();

            $eli5 = new EstimationLineItem();
            //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
               // Proposal ID
               $eli5->setProposalId($proposal->getProposalId());
               // ProposalService ID
               $eli5->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
               // Item ID
               $eli5->setItemId(0);
               // Phase ID
               $eli5->setPhaseId($asphalt_miling_repair_phase_id);
                $eli5->setCustomName('Signs');
                $eli5->setWorkOrder('Signs');
               // Sub ID
               $eli5->setSubId(0);
               // Unit Price
               $eli5->setUnitPrice('62.50');
               // Custom Unit Price - 0 or 1
               $eli5->setCustomUnitPrice(1);
               // Quantity
               $eli5->setQuantity('2.00');
               // Total Price
               $eli5->setTotalPrice('125.00');
               // Base price
               $eli5->setBasePrice('50.00');
               // setOverheadRate
               $eli5->setOverheadRate('10.00');
               // set Profit Rate
               $eli5->setOverheadPrice('10.00');
               // set OverheadPrice
               $eli5->setProfitRate('15.00');
               // set Profit Price
               $eli5->setProfitPrice('15.00');
               // Set Tax Rate
               $eli5->setTaxRate('0.00');
               // Set Tax Price
               $eli5->setTaxPrice('0.00');
               // Set Plant ID
               $eli5->setPlantId(null);
               // Set Template ID
               $eli5->setTemplateId(null);
               // Set day
               $eli5->setDay(1);
               // Set Num people
               $eli5->setNumPeople(4);
               // Set hours_per_day
               $eli5->setHoursPerDay('8.00');
   
               $eli5->setCustomTotalPrice(0);
               // Set Expected total
               $eli5->setExpectedTotal('100.00');
               // Save it
               $this->em->persist($eli5);
               $this->em->flush();

            // Update the phase status - pass by reference to update
           

                $scv = new \models\EstimationCalculatorValue();
         
        
            $valuesText = '[{"name":"time_type_input","value":"1"},{"name":"number_of_person","value":"4"},{"name":"hour_per_day","value":"8"},{"name":"excavator_measurement","value":""},{"name":"excavator_measurement_unit","value":"square yards"},{"name":"excavator_depth","value":""},{"name":"cal_overhead","value":"9.00%"},{"name":"cal_profit","value":"9.00%"},{"name":"cal_tax","value":"0%"}]';
            

            $scv->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
            $scv->setItemId($companyDefaultItem4->getId());
            $scv->setSavedValues($valuesText);
            $scv->setCalculatorName('time_type_form');
            $scv->setLineItemId($eli4->getId());
            $this->em->persist($scv);
            $this->em->flush();


            ///get non-fixed template id

            $dql = "SELECT ei
            FROM \models\EstimationTemplate ei
            WHERE ei.company_id = :companyId
            AND ei.fixed = 0 AND ei.deleted = 0";
    
            $query = $this->em->createQuery($dql);
            $query->setParameter(':companyId', $company->getCompanyId());
    
            $template = $query->getResult();
            $template = $template[0];
            $template_id = $template->getId();

            
           
           
            $template_items = $this->getEstimationRepository()->getTemplateItems($template,$proposal->getProposalId());
            
            foreach ($template_items as $lineItem) {
                $defaults = $lineItem->$template_id;
                $default_qty = $defaults['default_qty'];
                $default_days = $defaults['default_days'];
                $default_hpd = $defaults['default_hpd'];
                if ($default_qty && $default_qty > 0
                    && $default_days && $default_days > 0
                    && $default_hpd && $default_hpd > 0) {
    
                    $calculator = new \Pms\Calculators\Material\TimeCalculator();
    
                    $calculator->setItemBasePrice($lineItem->getBasePrice());
                    $calculator->setQuantity($default_qty);
                    $calculator->setDays($default_days);
                    $calculator->setHoursPerDay($default_hpd);
                    $calculator->setUnitType($lineItem->single_name);
                    
                        $calculator->setOhRate($lineItem->getOverheadRate());
                        $calculator->setPmRate($lineItem->getProfitRate());
                        
                    
                    $calculator->setTaxRate($lineItem->getTaxRate());
                    $result = $calculator->run();
    
                    if (count($result) > 0) {
                        $eli = new EstimationLineItem();
    
                        $expected_total =   $lineItem->getBasePrice() * $result->quantity;
                        // Proposal ID
                        $eli->setProposalId($proposal->getProposalId());
                        // ProposalService ID
                        $eli->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
                        // Item ID
                        $eli->setItemId($lineItem->getId());
                        // Phase ID
                        $eli->setPhaseId($asphalt_miling_repair_phase_id);
                        // Sub ID
                        $eli->setSubId(0);
                        // Unit Price
                        $eli->setUnitPrice($result->itemPrice);
                        // Custom Unit Price - 0 or 1
                        $eli->setCustomUnitPrice(0);
                        // Quantity
                        $eli->setQuantity($result->quantity);
                        // Total Price
                        $eli->setTotalPrice($result->totalPrice);
                        // Base price
                        $eli->setBasePrice($lineItem->getBasePrice());
                        // setOverheadRate
                        $eli->setOverheadRate($result->overheadUnitPrice);
                        // set Profit Rate
                        $eli->setProfitRate($result->profitUnitPrice);
                        // set OverheadPrice
                        $eli->setOverheadPrice($result->overheadPrice);
                        // set Profit Price
                        $eli->setProfitPrice($result->profitPrice);
                        // Set Tax Rate
                        $eli->setTaxRate($lineItem->getTaxRate());
                        // Set Tax Price
                        $eli->setTaxPrice($result->taxPrice);
                        // Set Plant ID
                        $eli->setPlantId(null);
                        // Set Template ID
                        $eli->setTemplateId($template_id);
                        // Set day
                        $eli->setDay($default_days);
                        // Set Num people
                        $eli->setNumPeople($default_qty);
                        // Set hours_per_day
                        $eli->setHoursPerDay($default_hpd);
                        // Set Expected total
                        $eli->setExpectedTotal($expected_total);
                        // Save it
                        $this->em->persist($eli);
                       
                    }
    
                }
    
            }




////////////////get fixed rate template id

        $dql = "SELECT ei
                    FROM \models\EstimationTemplate ei
                    WHERE ei.company_id = :companyId
                    AND ei.fixed = 1 AND ei.deleted = 0";
    
            $query = $this->em->createQuery($dql);
            $query->setParameter(':companyId', $company->getCompanyId());
    
            $template = $query->getResult();
            $template = $template[0];
            $default_days = 2;
            $default_hpd = 8;
            $template_id = $template->getId();
        
        if (!$template) {
            return 'not template';
            die;
        }
       
        $priceRate =$template->getBasePrice();
        
        
        $template_items = $this->getEstimationRepository()->getTemplateItems($template,$proposal->getProposalId());
        
        $save_item_count = 0;
        $total_default_qty = 0;
        $temp_total_quantity =0;
        
        foreach ($template_items as $lineItem) {
            $defaults = $lineItem->$template_id;
            $default_qty = $defaults['default_qty'];
            $total_default_qty =  $total_default_qty +$default_qty;
            // $default_days = $defaults['default_days'];
            // $default_hpd = $defaults['default_hpd'];
            if ($default_qty && $default_qty > 0
                && $default_days && $default_days > 0) {

                $calculator = new \Pms\Calculators\Material\TimeCalculator();

                $calculator->setItemBasePrice($priceRate);
                $calculator->setQuantity($default_qty);
                $calculator->setDays($default_days);
                
                $unit_type ='Hour'; 
            
                $calculator->setHoursPerDay($default_hpd);
              
                $calculator->setUnitType($unit_type);
                //  if($calculation_type==1){
                //      $calculator->setOhRate($DefaultOverhead);
                //      $calculator->setPmRate($DefaultProfit);
                    
                //  }else{
                    $calculator->setOhRate(0);
                    $calculator->setPmRate(0);
                    
               // }
                $calculator->setTaxRate(0);
                $result = $calculator->run();

                //get item unit price
               // $lineItem->getUnitPrice();
                //get item type
                
                //calculate total as per type
    
                if (count($result) > 0) {
                    

                    $temp_total_quantity = $temp_total_quantity + $result->quantity;
                    $eli = new EstimationLineItem();

                    $expected_total =  '0.00';
                    // Proposal ID
                    $eli->setProposalId($proposal->getProposalId());
                    // ProposalService ID
                    $eli->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
                    // Item ID
                    $eli->setItemId($lineItem->getId());
                    // Phase ID
                    $eli->setPhaseId($asphalt_miling_repair_phase_id);
                    // Sub ID
                    $eli->setSubId(0);
                    // Unit Price
                    $eli->setUnitPrice('0.00');
                    // Custom Unit Price - 0 or 1
                    $eli->setCustomUnitPrice(0);
                    // Quantity
                    $eli->setQuantity($result->quantity);
                    // Total Price
                    $eli->setTotalPrice('0.00');
                    // Base price
                    $eli->setBasePrice('0.00');
                    // setOverheadRate
                    $eli->setOverheadRate('0.00');
                    // set Profit Rate
                    $eli->setProfitRate('0.00');
                    // set OverheadPrice
                    $eli->setOverheadPrice('0.00');
                    // set Profit Price
                    $eli->setProfitPrice('0.00');
                    // Set Tax Rate
                    $eli->setTaxRate('0.00');
                    // Set Tax Price
                    $eli->setTaxPrice('0.00');
                    // Set Plant ID
                    $eli->setPlantId(null);
                    // Set Template ID
                    $eli->setTemplateId($template_id);
                    // Set day
                    $eli->setDay($default_days);
                    // Set Num people
                    $eli->setNumPeople($default_qty);
                    // Set hours_per_day
                    $eli->setHoursPerDay($default_hpd);
                    //fixed template
                    $eli->setFixedTemplate(2);
                    // Set Expected total
                    $eli->setExpectedTotal($expected_total);
                    // Save it
                    $this->em->persist($eli);
                    
                   
                }

            }

        }

        
            $DefaultOverhead = $template->getOverheadRate();
            $DefaultProfit = $template->getProfitRate();
            $defaultPriceRate = $template->getPriceRate();
        
       //$unitPrice = $priceRate+$overheadUnitRate+$profitUnitRate;
       $rate = (($DefaultOverhead + $DefaultProfit) / 100) + 1;
       $basePrice = $defaultPriceRate / $rate;
       $overheadUnitRate = (($basePrice * $DefaultOverhead)/100);
       
       $profitUnitRate = (($basePrice * $DefaultProfit)/100);
       
   
      
        if($template->getCalculationType()==1){
            $temp_parent_total = $defaultPriceRate*$default_days;
            $temp_overhead_total = $overheadUnitRate*$default_days;
            $temp_profit_total = $profitUnitRate*$default_days;
            $expected_total = $defaultPriceRate*$default_days;
            $temp_total_quantity = $default_days;
        }else{
            $temp_parent_total = $defaultPriceRate*$default_days*$default_hpd;
            $temp_overhead_total = $overheadUnitRate*$default_days*$default_hpd;
            $temp_profit_total = $profitUnitRate*$default_days*$default_hpd;
            $expected_total = $defaultPriceRate*$default_days*$default_hpd;
            $temp_total_quantity = $default_days*$default_hpd;
        }
        
         if($temp_parent_total != $expected_total){

            $diff = $expected_total - $temp_parent_total;
            $temp_parent_total = $expected_total;
            $temp_profit_total = $temp_profit_total + $diff;
         }
         
         

                ///main template item
                $eli = new EstimationLineItem();

                    $expected_total = $basePrice * $temp_total_quantity;
                    // Proposal ID
                    $eli->setProposalId($proposal->getProposalId());
                    // ProposalService ID
                    $eli->setProposalServiceId($asphalt_miling_repair_proposal_service_id);
                    // Item ID
                    $eli->setItemId(0);
                    // Phase ID
                    $eli->setPhaseId($asphalt_miling_repair_phase_id);
                    // Sub ID
                    $eli->setSubId(0);
                    // Unit Price
                    $eli->setUnitPrice($defaultPriceRate);
                    // Custom Unit Price - 0 or 1
                    $eli->setCustomUnitPrice(0);
                    // Quantity
                    $eli->setQuantity($temp_total_quantity);
                    // Total Price
                    $eli->setTotalPrice($temp_parent_total);
                    // Base price
                    $eli->setBasePrice($basePrice);
                    // setOverheadRate
                    $eli->setOverheadRate($overheadUnitRate);
                    // set Profit Rate
                    $eli->setProfitRate($profitUnitRate);
                    // set OverheadPrice
                    $eli->setOverheadPrice($temp_overhead_total);
                    // set Profit Price
                    $eli->setProfitPrice($temp_profit_total);
                    // Set Tax Rate
                    $eli->setTaxRate('0.00');
                    // Set Tax Price
                    $eli->setTaxPrice('0.00');
                    // Set Plant ID
                    $eli->setPlantId(null);
                    // Set Template ID
                    $eli->setTemplateId($template_id);
                    //set custom name
                    $eli->setCustomName($template->getName()); 
                    
                    // Set day
                    $eli->setDay($default_days);
                    // Set Num people
                    $eli->setNumPeople($total_default_qty);
                    // Set hours_per_day
                    $eli->setHoursPerDay($default_hpd);
                    //fixed template
                    $eli->setFixedTemplate(1);
                    // Set Expected total
                    $eli->setExpectedTotal($expected_total);
                    // Save it
                    $this->em->persist($eli);
        

            $this->getEstimationRepository()->updatePhaseStatus($eli4->getPhase());
            $this->updateFixedTemplateTotalPrice($template_id,$asphalt_miling_repair_phase_id);



            $numLineItems = $this->getEstimationRepository()->getProposalServiceUncompletedPhasesCount($asphalt_miling_repair_proposal_service_id);

        // Update the Estimate Object
        $proposalService = $this->em->findProposalService($asphalt_miling_repair_proposal_service_id);
      
        $estimate = $this->getEstimationRepository()->getProposalServiceEstimate($proposalService);
        //$estimate->setCompleted($apply);
        if ($numLineItems > 0) {
            $estimate->setCompleted(0);
        } else {
            $estimate->setCompleted(1);
        }
        $price = $this->getEstimationRepository()->getProposalServiceLineItemTotal($asphalt_miling_repair_proposal_service_id);
        $newPrice = '$' . number_format($price, 2);
        $estimate->setTotalPrice($newPrice);
        $estimate->setCustomPrice(0);
        $this->em->persist($estimate);

        // Update the proposal service price
        $proposalService->setPrice($newPrice);
        $this->em->persist($proposalService);
        $this->em->flush();


        $companyDefaultItem = $this->getCompanyDefaultItem($company, '147');
       
       
        $eli = new EstimationLineItem();
         //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
            // Proposal ID
            $eli->setProposalId($proposal->getProposalId());
            // ProposalService ID
            $eli->setProposalServiceId($crack_sealing_proposal_service_id);
            // Item ID
            $eli->setItemId($companyDefaultItem->getId());
            // Phase ID
            $eli->setPhaseId($crack_sealing_phase_id);
            // Sub ID
            $eli->setSubId(0);
            // Unit Price
            $eli->setUnitPrice('53.10');
            // Custom Unit Price - 0 or 1
            $eli->setCustomUnitPrice(1);
            // Quantity
            $eli->setQuantity('312.50');
            // Total Price
            $eli->setTotalPrice('16593.75');
            // Base price
            $eli->setBasePrice('45.00');
            // setOverheadRate
            $eli->setOverheadRate('9.00');
            // set Profit Rate
            $eli->setOverheadPrice('1265.63');
            // set OverheadPrice
            $eli->setProfitRate('9.00');
            // set Profit Price
            $eli->setProfitPrice('1265.63');
            // Set Tax Rate
            $eli->setTaxRate('0.00');
            // Set Tax Price
            $eli->setTaxPrice('0.00');
            // Set Plant ID
            $eli->setPlantId(null);
            // Set Template ID
            $eli->setTemplateId(null);
            // Set day
            $eli->setDay(0);
            // Set Num people
            $eli->setNumPeople(0);
            // Set hours_per_day
            $eli->setHoursPerDay('0.00');

            $eli->setCustomTotalPrice(0);
            // Set Expected total
            $eli->setExpectedTotal('14062.50');
            // Save it
            $this->em->persist($eli);
            $this->em->flush();
            // Update the phase status - pass by reference to update
           

                $scv = new \models\EstimationCalculatorValue();
         
        
            $valuesText = '[{"name":"crackseakLength","value":"10,000","field_code":"lineal_feet_cracks"},{"name":"cwidth","value":"4"},{"name":"cdepth","value":"4"},{"name":"cal_overhead","value":"9.00%"},{"name":"cal_profit","value":"9.00%"},{"name":"cal_tax","value":"0%"}]';
            

            $scv->setProposalServiceId($crack_sealing_proposal_service_id);
            $scv->setItemId($companyDefaultItem->getId());
            $scv->setSavedValues($valuesText);
            $scv->setCalculatorName('crack_sealer_form');
            $scv->setLineItemId($eli->getId());
            $this->em->persist($scv);
            $this->em->flush();
            $phase = $this->em->findEstimationPhase($crack_sealing_phase_id);
            $this->getEstimationRepository()->updatePhaseStatus($phase);
             //Update Phase category flag
        
        $this->getEstimationRepository()->updateEstimatePhase($phase);
        // Flush to DB
        $this->em->flush();
        
        $numLineItems = $this->getEstimationRepository()->getProposalServiceUncompletedPhasesCount($crack_sealing_proposal_service_id);

        // Update the Estimate Object
        $proposalService = $this->em->findProposalService($crack_sealing_proposal_service_id);
      
        $estimate = $this->getEstimationRepository()->getProposalServiceEstimate($proposalService);
        //$estimate->setCompleted($apply);
        if ($numLineItems > 0) {
            $estimate->setCompleted(0);
        } else {
            $estimate->setCompleted(1);
        }
        $price = $this->getEstimationRepository()->getProposalServiceLineItemTotal($crack_sealing_proposal_service_id);
        $newPrice = '$' . number_format($price, 2);
        $estimate->setTotalPrice($newPrice);
        $estimate->setCustomPrice(0);
        $this->em->persist($estimate);

        // Update the proposal service price
        $proposalService->setPrice($newPrice);
        $this->em->persist($proposalService);
        $this->em->flush();

            $companyDefaultItem = $this->getCompanyDefaultItem($company, '105');
       
            
            $eli = new EstimationLineItem();
             //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
                // Proposal ID
                $eli->setProposalId($proposal->getProposalId());
                // ProposalService ID
                $eli->setProposalServiceId($new_asphalt_pavement_overlay_proposal_service_id);
                // Item ID
                $eli->setItemId($companyDefaultItem->getId());
                // Phase ID
                $eli->setPhaseId($new_asphalt_pavement_overlay_phase_id);
                // Sub ID
                $eli->setSubId(0);
                // Unit Price
                $eli->setUnitPrice('61.36');
                // Custom Unit Price - 0 or 1
                $eli->setCustomUnitPrice(1);
                // Quantity
                $eli->setQuantity('110.00');
                // Total Price
                $eli->setTotalPrice('6749.60');
                // Base price
                $eli->setBasePrice('52.00');
                // setOverheadRate
                $eli->setOverheadRate('9.00');
                // set Profit Rate
                $eli->setOverheadPrice('514.80');
                // set OverheadPrice
                $eli->setProfitRate('9.00');
                // set Profit Price
                $eli->setProfitPrice('514.80');
                // Set Tax Rate
                $eli->setTaxRate('0.00');
                // Set Tax Price
                $eli->setTaxPrice('0.00');
                // Set Plant ID
                $eli->setPlantId(null);
                // Set Template ID
                $eli->setTemplateId(null);
                // Set day
                $eli->setDay(0);
                // Set Num people
                $eli->setNumPeople(0);
                // Set hours_per_day
                $eli->setHoursPerDay('0.00');
    
                $eli->setCustomTotalPrice(0);
                // Set Expected total
                $eli->setExpectedTotal('5720.00');
                // Save it
                $this->em->persist($eli);
                $this->em->flush();
                // Update the phase status - pass by reference to update
               
    
                    $scv = new \models\EstimationCalculatorValue();
             
            
                $valuesText = '[{"name":"measurement","value":"1,000","field_code":"area_of_paving"},{"name":"measurement_unit","value":"square yards","field_code":"unit"},{"name":"depth","value":"2","field_code":"depth_of_paving"},{"name":"cal_overhead","value":"9.00%"},{"name":"cal_profit","value":"9.00%"},{"name":"cal_trucking_oh","value":"10.00%"},{"name":"cal_trucking_pm","value":"10.00%"},{"name":"cal_tax","value":"0%"}]';
                
    
                $scv->setProposalServiceId($new_asphalt_pavement_overlay_proposal_service_id);
                $scv->setItemId($companyDefaultItem->getId());
                $scv->setSavedValues($valuesText);
                $scv->setCalculatorName('asphalt_form');
                $scv->setLineItemId($eli->getId());
                $this->em->persist($scv);
                $this->em->flush();
                $phase = $this->em->findEstimationPhase($new_asphalt_pavement_overlay_phase_id);
                $this->getEstimationRepository()->updatePhaseStatus($phase);
                $this->em->flush();

                $numLineItems = $this->getEstimationRepository()->getProposalServiceUncompletedPhasesCount($new_asphalt_pavement_overlay_proposal_service_id);

                // Update the Estimate Object
                $proposalService = $this->em->findProposalService($new_asphalt_pavement_overlay_proposal_service_id);
              
                $estimate = $this->getEstimationRepository()->getProposalServiceEstimate($proposalService);
                //$estimate->setCompleted($apply);
                if ($numLineItems > 0) {
                    $estimate->setCompleted(0);
                } else {
                    $estimate->setCompleted(1);
                }
                $price = $this->getEstimationRepository()->getProposalServiceLineItemTotal($new_asphalt_pavement_overlay_proposal_service_id);
                $newPrice = '$' . number_format($price, 2);
                $estimate->setTotalPrice($newPrice);
                $estimate->setCustomPrice(0);
                $this->em->persist($estimate);
        
                // Update the proposal service price
                $proposalService->setPrice($newPrice);
                $this->em->persist($proposalService);
                $this->em->flush();

                $companyDefaultItem = $this->getCompanyDefaultItem($company, '127');
       
            
            $eli = new EstimationLineItem();
             //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
                // Proposal ID
                $eli->setProposalId($proposal->getProposalId());
                // ProposalService ID
                $eli->setProposalServiceId($line_striping_proposal_service_id);
                // Item ID
                $eli->setItemId($companyDefaultItem->getId());
                // Phase ID
                $eli->setPhaseId($line_striping_phase_id);
                // Sub ID
                $eli->setSubId(0);
                // Unit Price
                $eli->setUnitPrice('53.10');
                // Custom Unit Price - 0 or 1
                $eli->setCustomUnitPrice(1);
                // Quantity
                $eli->setQuantity('31.25');
                // Total Price
                $eli->setTotalPrice('1659.37');
                // Base price
                $eli->setBasePrice('45.00');
                // setOverheadRate
                $eli->setOverheadRate('9.00');
                // set Profit Rate
                $eli->setOverheadPrice('126.56');
                // set OverheadPrice
                $eli->setProfitRate('9.00');
                // set Profit Price
                $eli->setProfitPrice('126.56');
                // Set Tax Rate
                $eli->setTaxRate('0.00');
                // Set Tax Price
                $eli->setTaxPrice('0.00');
                // Set Plant ID
                $eli->setPlantId(null);
                // Set Template ID
                $eli->setTemplateId(null);
                // Set day
                $eli->setDay(0);
                // Set Num people
                $eli->setNumPeople(0);
                // Set hours_per_day
                $eli->setHoursPerDay('0.00');
    
                $eli->setCustomTotalPrice(0);
                // Set Expected total
                $eli->setExpectedTotal('1406.25');
                // Save it
                $this->em->persist($eli);
                $this->em->flush();
                // Update the phase status - pass by reference to update
               
    
                    $scv = new \models\EstimationCalculatorValue();
             
            
                $valuesText = '[{"name":"stripingFeet","value":"10,000","field_code":"lineal_ft"},{"name":"stripingPailSize","value":"1"},{"name":"stripingPailColor","value":"320"},{"name":"cal_overhead","value":"9.00%"},{"name":"cal_profit","value":"9.00%"},{"name":"cal_tax","value":"0%"}]';
                
    
                $scv->setProposalServiceId($line_striping_proposal_service_id);
                $scv->setItemId($companyDefaultItem->getId());
                $scv->setSavedValues($valuesText);
                $scv->setCalculatorName('striping_form');
                $scv->setLineItemId($eli->getId());
                $this->em->persist($scv);
                $this->em->flush();
                $phase = $this->em->findEstimationPhase($line_striping_phase_id);
                $this->getEstimationRepository()->updatePhaseStatus($phase);
                $this->em->flush();

        // Update the proposal price
        updateProposalPrice($proposal->getProposalId());
        $numLineItems = $this->getEstimationRepository()->getProposalServiceUncompletedPhasesCount($line_striping_proposal_service_id);

        // Update the Estimate Object
        $proposalService = $this->em->findProposalService($line_striping_proposal_service_id);
      
        $estimate = $this->getEstimationRepository()->getProposalServiceEstimate($proposalService);
        //$estimate->setCompleted($apply);
        if ($numLineItems > 0) {
            $estimate->setCompleted(0);
        } else {
            $estimate->setCompleted(1);
        }
        $price = $this->getEstimationRepository()->getProposalServiceLineItemTotal($line_striping_proposal_service_id);
        $newPrice = '$' . number_format($price, 2);
        $estimate->setTotalPrice($newPrice);
        $estimate->setCustomPrice(0);
        $this->em->persist($estimate);

        // Update the proposal service price
        $proposalService->setPrice($newPrice);
        $this->em->persist($proposalService);
        $this->em->flush();


        

        $companyDefaultItem = $this->getCompanyDefaultItem($company, '107');

        $additiveCompanyDefaultItem = $this->getCompanyDefaultItem($company, '133');

        $sandCompanyDefaultItem = $this->getCompanyDefaultItem($company, '132');

        $eli = new EstimationLineItem();
             //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
                // Proposal ID
                $eli->setProposalId($proposal->getProposalId());
                // ProposalService ID
                $eli->setProposalServiceId($sealcoat_proposal_service_id);
                // Item ID
                $eli->setItemId($companyDefaultItem->getId());
                // Phase ID
                $eli->setPhaseId($sealcoat_phase_id);
                // Sub ID
                $eli->setSubId(0);
                // Unit Price
                $eli->setUnitPrice('9.44');
                // Custom Unit Price - 0 or 1
                $eli->setCustomUnitPrice(1);
                // Quantity
                $eli->setQuantity('350.00');
                // Total Price
                $eli->setTotalPrice('3304.00');
                // Base price
                $eli->setBasePrice('8.00');
                // setOverheadRate
                $eli->setOverheadRate('9.00');
                // set Profit Rate
                $eli->setProfitRate('9.00');
                // set OverheadPrice
                $eli->setOverheadPrice('252.00');
                // set Profit Price
                $eli->setProfitPrice('252.00');
                // Set Tax Rate
                $eli->setTaxRate('0.00');
                // Set Tax Price
                $eli->setTaxPrice('0.00');
                // Set Plant ID
                $eli->setPlantId(null);
                // Set Template ID
                $eli->setTemplateId(null);
                // Set day
                $eli->setDay(0);
                // Set Num people
                $eli->setNumPeople(0);
                // Set hours_per_day
                $eli->setHoursPerDay('0.00');
    
                $eli->setCustomTotalPrice(0);
                // Set Expected total
                $eli->setExpectedTotal('2800.00');
                // Save it
                $this->em->persist($eli);
                $this->em->flush();
                // Update the phase status - pass by reference to update
               
    
                    $scv = new \models\EstimationCalculatorValue();
             
                //$addtivecompanyDefaultItem = $this->getCompanyDefaultItem($company, '143');
                $valuesText = '[{"name":"sealcoatArea","value":"7,000"},{"name":"sealcoatUnit","value":"square yards"},{"name":"sealcoatCoats","value":"1"},{"name":"sealcoatApplicationRate","value":"0.05"},{"name":"sealcoatApplicationRate2","value":"0.005"},{"name":"sealcoatWater","value":"0"},{"name":"additive_sealer_item","value":"'.$additiveCompanyDefaultItem->getId().'"},{"name":"sealcoatAdditive","value":"1"},{"name":"sand_sealer_item","value":"'.$sandCompanyDefaultItem->getId().'"},{"name":"sealcoatSand","value":"1"},{"name":"sealcoatAdditiveTotalInput","value":"3.50"},{"name":"sealcoatSandTotalInput","value":"350.00"},{"name":"cal_overhead","value":"9.00%"},{"name":"cal_profit","value":"9.00%"},{"name":"cal_tax","value":"0%"}]';
                
    
                $scv->setProposalServiceId($sealcoat_proposal_service_id);
                $scv->setItemId($companyDefaultItem->getId());
                $scv->setSavedValues($valuesText);
                $scv->setCalculatorName('striping_form');
                $scv->setLineItemId($eli->getId());
                $this->em->persist($scv);
                $this->em->flush();
                $phase = $this->em->findEstimationPhase($sealcoat_phase_id);
                $this->getEstimationRepository()->updatePhaseStatus($phase);
                $this->em->flush();


                $eli2 = new EstimationLineItem();
                //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
                   // Proposal ID
                   $eli2->setProposalId($proposal->getProposalId());
                   // ProposalService ID
                   $eli2->setProposalServiceId($sealcoat_proposal_service_id);
                   // Item ID
                   $eli2->setItemId($additiveCompanyDefaultItem->getId());
                   $eli2->setParentLineItemId($eli->getId());
                   // Phase ID
                   $eli2->setPhaseId($sealcoat_phase_id);
                   // Sub ID
                   $eli2->setSubId(0);
                   // Unit Price
                   $eli2->setUnitPrice('16.25');
                   // Custom Unit Price - 0 or 1
                   $eli2->setCustomUnitPrice(1);
                   // Quantity
                   $eli2->setQuantity('3.50');
                   // Total Price
                   $eli2->setTotalPrice('56.88');
                   // Base price
                   $eli2->setBasePrice('13.00');
                   // setOverheadRate
                   $eli2->setOverheadRate('10.00');
                   // set Profit Rate
                   $eli2->setProfitRate('15.00');
                   // set OverheadPrice
                   $eli2->setOverheadPrice('1.30');
                   // set Profit Price
                   $eli2->setProfitPrice('1.95');
                   // Set Tax Rate
                   $eli2->setTaxRate('0.00');
                   // Set Tax Price
                   $eli2->setTaxPrice('0.00');
                   // Set Plant ID
                   $eli2->setPlantId(null);
                   // Set Template ID
                   $eli2->setTemplateId(null);
                   // Set day
                   $eli2->setDay(0);
                   // Set Num people
                   $eli2->setNumPeople(0);
                   // Set hours_per_day
                   $eli2->setHoursPerDay('0.00');
       
                   $eli2->setCustomTotalPrice(0);
                   // Set Expected total
                   $eli2->setExpectedTotal('45.50');
                   // Save it
                   $this->em->persist($eli2);
                   $this->em->flush();
                   // Update the phase status - pass by reference to update
                  
       
                   $eli3 = new EstimationLineItem();
                   //$expected_total =$lineItem['basePrice'] * $lineItem['quantity'];
                      // Proposal ID
                      $eli3->setProposalId($proposal->getProposalId());
                      // ProposalService ID
                      $eli3->setProposalServiceId($sealcoat_proposal_service_id);
                      // Item ID
                      $eli3->setItemId($sandCompanyDefaultItem->getId());
                      $eli3->setParentLineItemId($eli->getId());
                      // Phase ID
                      $eli3->setPhaseId($sealcoat_phase_id);
                      // Sub ID
                      $eli3->setSubId(0);
                      // Unit Price
                      $eli3->setUnitPrice('0.14');
                      // Custom Unit Price - 0 or 1
                      $eli3->setCustomUnitPrice(1);
                      // Quantity
                      $eli3->setQuantity('350.00');
                      // Total Price
                      $eli3->setTotalPrice('49.00');
                      // Base price
                      $eli3->setBasePrice('0.11');
                      // setOverheadRate
                      $eli3->setOverheadRate('10.00');
                      // set Profit Rate
                      $eli3->setProfitRate('10.00');
                      // set OverheadPrice
                      $eli3->setOverheadPrice('0.01');
                      // set Profit Price
                      $eli3->setProfitPrice('0.02');
                      // Set Tax Rate
                      $eli3->setTaxRate('0.00');
                      // Set Tax Price
                      $eli3->setTaxPrice('0.00');
                      // Set Plant ID
                      $eli3->setPlantId(null);
                      // Set Template ID
                      $eli3->setTemplateId(null);
                      // Set day
                      $eli3->setDay(0);
                      // Set Num people
                      $eli3->setNumPeople(0);
                      // Set hours_per_day
                      $eli3->setHoursPerDay('0.00');
          
                      $eli3->setCustomTotalPrice(0);
                      // Set Expected total
                      $eli3->setExpectedTotal('38.50');
                      // Save it
                      $this->em->persist($eli3);
                      $this->em->flush();

        // Update the proposal price
        updateProposalPrice($proposal->getProposalId());

        $numLineItems = $this->getEstimationRepository()->getProposalServiceUncompletedPhasesCount($sealcoat_proposal_service_id);

        // Update the Estimate Object
        $proposalService = $this->em->findProposalService($sealcoat_proposal_service_id);
      
        $estimate = $this->getEstimationRepository()->getProposalServiceEstimate($proposalService);
        //$estimate->setCompleted($apply);
        if ($numLineItems > 0) {
            $estimate->setCompleted(0);
        } else {
            $estimate->setCompleted(1);
        }
        $price = $this->getEstimationRepository()->getProposalServiceLineItemTotal($sealcoat_proposal_service_id);
        $newPrice = '$' . number_format($price, 2);
        $estimate->setTotalPrice($newPrice);
        $estimate->setCustomPrice(0);
        $this->em->persist($estimate);

        // Update the proposal service price
        $proposalService->setPrice($newPrice);
        $this->em->persist($proposalService);
        $this->em->flush();



        //Update Phase category flag
        
        $this->getEstimationRepository()->updateEstimatePhase($phase);
        $proposal->setEstimateStatusId(\models\EstimateStatus::COMPLETE);
        $this->em->persist($proposal);
        // Flush to DB
        $this->em->flush();


        }



        public function updateFixedTemplateTotalPrice($templateId,$phaseId){
            
            $childItems = $this->getFixedChildTemplateItem($templateId,$phaseId);
            $temp_equipment_total =0;
            $temp_labor_total= 0;
            $temp_equipment_base_total =0;
            $temp_labor_base_total= 0;
            $temp_labor_pm_total = 0;
            $temp_labor_oh_total = 0;
            $temp_equipment_pm_total = 0;
            $temp_equipment_oh_total = 0;
            foreach($childItems as $lineItem){

                // echo 'child Item unit price-'.$lineItem->getItem()->getUnitPrice();
                // echo '<br>';

                $temp_item_total = $lineItem->getItem()->getUnitPrice() * $lineItem->getQuantity();
                
                    if($lineItem->getItem()->getType()->getCategoryId() ==\models\EstimationCategory::EQUIPMENT){
                        $temp_equipment_total = $temp_equipment_total + $temp_item_total;
                    }
                    else{
                        $temp_labor_total = $temp_labor_total + $temp_item_total;
                    }
            }
   

        $temp_labor_percent = 0;
        $temp_equipment_percent = 0;
        $fixed_labor_total = 0;
        $fixed_equipment_total = 0;
        $temp_labor_base_total = 0;
        $temp_equipment_base_total =0;
        $temp_labor_oh_total = 0;
        $temp_equipment_oh_total = 0;
        $temp_labor_pm_total = 0;
        $temp_equipment_pm_total = 0;
        
        if($temp_labor_total>0 || $temp_equipment_total>0){

            $category_total = $temp_equipment_total + $temp_labor_total;
            $temp_labor_percent =  ($temp_labor_total/$category_total)*100;
            $temp_equipment_percent =  ($temp_equipment_total/$category_total)*100;
        }
        // echo 'temp_labor_percent'.$temp_labor_percent;
        // echo '<br>';
        // echo 'temp_equipment_percent'.$temp_equipment_percent;
        // echo '<br>';
        $parentItem = $this->getEstimationRepository()->getFixedParentTemplateItem($templateId,$phaseId);
        if($temp_labor_percent>0){
            $fixed_labor_total = number_format((($temp_labor_percent * $parentItem->getTotalPrice()) / 100),2,'.','');
            $temp_labor_base_total = number_format((($temp_labor_percent *($parentItem->getBasePrice() * $parentItem->getQuantity()))/100),2,'.','');
            $temp_labor_oh_total = number_format((($temp_labor_percent * $parentItem->getOverheadPrice()) / 100),2,'.','');
            $temp_labor_pm_total = number_format((($temp_labor_percent * $parentItem->getProfitPrice()) / 100),2,'.','');
            $check_total = $temp_labor_base_total+$temp_labor_oh_total+$temp_labor_pm_total;
            if($fixed_labor_total != $check_total){
                $diff = $fixed_labor_total-$check_total;
                $temp_labor_pm_total = $temp_labor_pm_total + $diff;
            }
        }
        
        if($temp_equipment_percent>0){
            $fixed_equipment_total = number_format((($temp_equipment_percent * $parentItem->getTotalPrice()) / 100),2,'.','');
            $temp_equipment_base_total = number_format((($temp_equipment_percent *($parentItem->getBasePrice() * $parentItem->getQuantity()))/100),2,'.','');
            $temp_equipment_oh_total = number_format((($temp_equipment_percent * $parentItem->getOverheadPrice()) / 100),2,'.','');
            $temp_equipment_pm_total = number_format((($temp_equipment_percent * $parentItem->getProfitPrice()) / 100),2,'.','');
            $check_total = $temp_equipment_base_total+$temp_equipment_oh_total+$temp_equipment_pm_total;
            if($fixed_equipment_total != $check_total){
                $diff = $fixed_equipment_total-$check_total;
                $temp_equipment_pm_total = $temp_equipment_pm_total + $diff;
            }
        
        }
        
        
        $parentItem->setFixedLaborTotal($fixed_labor_total);
        $parentItem->setFixedEquipmentTotal($fixed_equipment_total);

        $parentItem->setFixedLaborBaseTotal($temp_labor_base_total);
        $parentItem->setFixedEquipmentBaseTotal($temp_equipment_base_total);

        $parentItem->setFixedLaborOhTotal($temp_labor_oh_total);
        $parentItem->setFixedEquipmentOhTotal($temp_equipment_oh_total);

        $parentItem->setFixedLaborPmTotal($temp_labor_pm_total);
        $parentItem->setFixedEquipmentPmTotal($temp_equipment_pm_total);
    $this->em->persist($parentItem);
    $this->em->flush();
    }
    

    public function getProposalJobCostSubContractorTotal(Companies $company, $proposalId){
      
        $sortedOut = [];
       
        
            $dql = "SELECT COALESCE(SUM(jci.price_difference), 0.00) AS difference_total,
            COALESCE(SUM(jci.estimated_qty), 0.00) AS estimated_qty_total,
            COALESCE(SUM(jci.actual_qty), 0.00) AS actual_qty_total,
            COALESCE(SUM(jci.estimated_total_price), 0.00) AS estimated_total,
            COALESCE(SUM(jci.actual_total_price), 0.00) AS actual_total
             
            FROM \models\JobCostItem jci
            WHERE jci.proposal_id = :proposal_id
             AND jci.is_sub_contractor = 1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposalId);
        $sortedOut[] = $query->getSingleResult();

        return $sortedOut;
    }

    public function getProposalServiceJobCostSubContractorTotal($proposal_service_id){
        
        $sortedOut = [];
       
       
            $dql = "SELECT COALESCE(SUM(jci.price_difference), 0.00) AS difference_total,
            COALESCE(SUM(jci.estimated_qty), 0.00) AS estimated_qty_total,
            COALESCE(SUM(jci.actual_qty), 0.00) AS actual_qty_total,
            COALESCE(SUM(jci.estimated_total_price), 0.00) AS estimated_total,
            COALESCE(SUM(jci.actual_total_price), 0.00) AS actual_total
            FROM \models\JobCostItem jci
            WHERE jci.proposal_service_id = :proposal_service_id
            AND jci.is_sub_contractor = 1";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_service_id', $proposal_service_id);
        $sortedOut[] = $query->getSingleResult();
        

        return $sortedOut;
    
    }

    public function getProposalJobCostCategoryTotal(Companies $company, $proposalId){
        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];
       
        foreach ($sortedCategories as $category) {
            $dql = "SELECT COALESCE(SUM(jci.price_difference), 0.00) AS difference_total,
            COALESCE(SUM(jci.estimated_qty), 0.00) AS estimated_qty_total,
            COALESCE(SUM(jci.actual_qty), 0.00) AS actual_qty_total,
            COALESCE(SUM(jci.estimated_total_price), 0.00) AS estimated_total,
            COALESCE(SUM(jci.actual_total_price), 0.00) AS actual_total,
             '".$category->getName()."' as category_name,'".$category->getId()."' as category_id
            FROM \models\JobCostItem jci
            WHERE jci.proposal_id = :proposal_id
            AND jci.category_id = :category_id AND jci.is_sub_contractor = 0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposalId);
        $query->setParameter(':category_id', $category->getId());
        $sortedOut[] = $query->getSingleResult();
        }

        return $sortedOut;
    
    }

    public function getProposalServiceJobCostCategoryTotal(Companies $company, $proposal_service_id){
        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];
       
        foreach ($sortedCategories as $category) {
            $dql = "SELECT COALESCE(SUM(jci.price_difference), 0.00) AS difference_total,
            COALESCE(SUM(jci.estimated_qty), 0.00) AS estimated_qty_total,
            COALESCE(SUM(jci.actual_qty), 0.00) AS actual_qty_total,
            COALESCE(SUM(jci.estimated_total_price), 0.00) AS estimated_total,
            COALESCE(SUM(jci.actual_total_price), 0.00) AS actual_total,
             '".$category->getName()."' as category_name
            FROM \models\JobCostItem jci
            WHERE jci.proposal_service_id = :proposal_service_id
            AND jci.category_id = :category_id AND jci.is_sub_contractor = 0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_service_id', $proposal_service_id);
        $query->setParameter(':category_id', $category->getId());
        $sortedOut[] = $query->getSingleResult();
        }

        return $sortedOut;
    
    }

    /**
     * @param Companies $company
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServiceNontruckingJobCostItems(Companies $company, $proposalServiceId)
    {
        //$allLineItems = $this->getAllProposalServiceLineItems($proposalServiceId);

        $sql = "SELECT eli.id
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id !=20 " ;

        $allLineItems =  $this->getAllResults($sql);
        
        $out = [];

        foreach ($allLineItems as $lineItemId) {
            /* @var \models\EstimationLineItem $lineItem */
            $lineItem = $this->em->findEstimationLineItem($lineItemId->id);
            $category = $lineItem->getItemTypeCategory();
            $jobCostItem = $this->em->getRepository('models\JobCostItem')->findOneBy(array(
                'estimate_line_item_id' => $lineItem->getId()
            ));
            $old_line_total = $lineItem->getTotalPrice();
            $old_quantity = $lineItem->getQuantity();
            $lineItem->job_cost = 0;
            $lineItem->job_cost_item_id = 0;
            $lineItem->job_cost_files =[];
            if($jobCostItem){
                $lineItem->job_cost_item_id = $jobCostItem->getId();
                $lineItem->setDay($jobCostItem->getDay());
                $lineItem->setNumPeople($jobCostItem->getNumPeople());
                $lineItem->setHoursPerDay($jobCostItem->getHpd());
                $lineItem->setQuantity($jobCostItem->getActualQty());

                $lineItem->setDisposalLoads($jobCostItem->getDisposalLoad());

                $lineItem->setTotalPrice($jobCostItem->getActualTotalPrice());
                $lineItem->base_total = $jobCostItem->getActualTotalPrice();
                $lineItem->job_costing =1;
                $lineItem->area = $jobCostItem->getArea();
                $lineItem->depth = $jobCostItem->getDepth();
                $lineItem->job_cost = 1;

                // $jobCostItemFiles = $this->em->getRepository('models\JobCostItemFile')->findOneBy(array(
                //     'job_cost_item_id' => $jobCostItem->getId()
                // ));
                $jobCostItemFiles = $this->getJobCostItemFiles($jobCostItem->getId());
                $lineItem->job_cost_files = $jobCostItemFiles;
            }else{
                $lineItem->job_costing =0;
                $lineItem->base_total = ($lineItem->getBasePrice() * $lineItem->getQuantity()) ;
            }
            $lineItem->old_total = $old_line_total;
            $lineItem->old_quantity = $old_quantity;
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                
                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'job_cost_items' => []
                   // 'job_cost_items' => $this->getJobCostItemsByCategory($category->getId(),$proposalServiceId),
                ];

            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //$out[$category->getId()]['job_cost_items'] = $this->getJobCostItemsByCategory($category->getId(),$proposalServiceId);
        }
        $jobCostItmes = $this->getJobCostItems($proposalServiceId);
        foreach($jobCostItmes as $jobCostItme){
            $jobCostItemFiles = $this->getJobCostItemFiles($jobCostItme->getId());
            $jobCostItme->job_cost_files = $jobCostItemFiles;
            $out[$jobCostItme->getCategoryId()]['category'] = $this->em->find('models\EstimationCategory', $jobCostItme->getCategoryId());
            $out[$jobCostItme->getCategoryId()]['job_cost_items'][] =$jobCostItme;
        }

        
        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];
       
        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }
// echo '<pre>';
// print_r($sortedOut);
// die;
        return $sortedOut;
    }


    /**
     * @param Companies $company
     * @param $proposalServiceId
     * @return array
     */
    public function getProposalServiceJobCostItems(Companies $company, $proposalServiceId)
    {
        $allLineItems = $this->getAllProposalServiceLineItems($proposalServiceId);
        
        $out = [];

        foreach ($allLineItems as $lineItem) {
            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();
            $jobCostItem = $this->em->getRepository('models\JobCostItem')->findOneBy(array(
                'estimate_line_item_id' => $lineItem->getId()
            ));
            $old_line_total = $lineItem->getTotalPrice();
            $old_quantity = $lineItem->getQuantity();
            $lineItem->job_cost = 0;
            $lineItem->job_cost_item_id = 0;
            $lineItem->job_cost_files =[];
            if($jobCostItem){
                $lineItem->job_cost_item_id = $jobCostItem->getId();
                $lineItem->setDay($jobCostItem->getDay());
                $lineItem->setNumPeople($jobCostItem->getNumPeople());
                $lineItem->setHoursPerDay($jobCostItem->getHpd());
                $lineItem->setQuantity($jobCostItem->getActualQty());
                
                $lineItem->setTotalPrice($jobCostItem->getActualTotalPrice());
                $lineItem->base_total = $jobCostItem->getActualTotalPrice();
                $lineItem->job_costing =1;
                $lineItem->area = $jobCostItem->getArea();
                $lineItem->depth = $jobCostItem->getDepth();
                $lineItem->job_cost = 1;

                // $jobCostItemFiles = $this->em->getRepository('models\JobCostItemFile')->findOneBy(array(
                //     'job_cost_item_id' => $jobCostItem->getId()
                // ));
                $jobCostItemFiles = $this->getJobCostItemFiles($jobCostItem->getId());
                $lineItem->job_cost_files = $jobCostItemFiles;
            }else{
                $lineItem->job_costing =0;
                $lineItem->base_total = ($lineItem->getBasePrice() * $lineItem->getQuantity()) ;
            }
            $lineItem->old_total = $old_line_total;
            $lineItem->old_quantity = $old_quantity;
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }

            // Crate the array item if we need it
            if (!array_key_exists($category->getId(), $out)) {

                
                $out[$category->getId()] = [
                    'category' => $category,
                    'items' => [],
                    'job_cost_items' => []
                   // 'job_cost_items' => $this->getJobCostItemsByCategory($category->getId(),$proposalServiceId),
                ];

            }

            // Add the item
            $out[$category->getId()]['items'][] = $lineItem;
            //$out[$category->getId()]['job_cost_items'] = $this->getJobCostItemsByCategory($category->getId(),$proposalServiceId);
        }
        $jobCostItmes = $this->getJobCostItems($proposalServiceId);
        foreach($jobCostItmes as $jobCostItme){
            $jobCostItemFiles = $this->getJobCostItemFiles($jobCostItme->getId());
            $jobCostItme->files = $jobCostItemFiles;
            
            $out[$jobCostItme->getCategoryId()]['category'] = $this->em->find('models\EstimationCategory', $jobCostItme->getCategoryId());
            $out[$jobCostItme->getCategoryId()]['job_cost_items'][] =$jobCostItme;
        }

        
        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];
       
        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }
// echo '<pre>';
// print_r($sortedOut);
// die;
        return $sortedOut;
    }

    public function getJobCostItemsByCategory($categoryId,$proposalServiceId){
        $dql = "SELECT jci
        FROM \models\JobCostItem jci
        WHERE jci.proposal_service_id = :proposal_service_id
        AND jci.category_id = :category_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_service_id', $proposalServiceId);
        $query->setParameter(':category_id', $categoryId);
        return $query->getResult();

    }

    public function getJobCostItemsProposal($proposalId){
        $dql = "SELECT jci
        FROM \models\JobCostItem jci
        WHERE jci.proposal_id = :proposal_id
        AND jci.estimate_line_item_id = 0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposalId);
        return $query->getResult();

    }

    public function getJobCostItems($proposalServiceId){
        $dql = "SELECT jci
        FROM \models\JobCostItem jci
        WHERE jci.proposal_service_id = :proposal_service_id
        AND jci.estimate_line_item_id = 0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_service_id', $proposalServiceId);
        return $query->getResult();

    }

    public function getJobCostItemsByProposal($categoryId,$proposalId){
        $dql = "SELECT jci
        FROM \models\JobCostItem jci
        WHERE jci.proposal_id = :proposal_id
        AND jci.category_id = :category_id
        AND jci.estimate_line_item_id = 0";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposal_id', $proposalId);
        $query->setParameter(':category_id', $categoryId);
        $results = $query->getResult();
       // print_r($results);die;
        $out =[];
        foreach($results as $result){
            $result->files =$this->getJobCostItemFiles($result->getId());
            $out[] =$result;
           
        }
        return $out;
        //print_r($out);die;

    }

    public function getServiceJobCostPriceDifference($proposalServiceId){
        $sql = "SELECT COALESCE(SUM(jci.price_difference), 0.00) AS totalPrice
        FROM job_cost_item jci
        WHERE jci.proposal_service_id = '$proposalServiceId'";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

    public function getProposalJobCostPriceDifference($proposalId){
        $sql = "SELECT COALESCE(SUM(jci.price_difference), 0.00) AS totalPrice
        FROM job_cost_item jci
        WHERE jci.proposal_id ='$proposalId'";

        $result = $this->getSingleResult($sql);

        return  $result->totalPrice;
    }

    public function getProposalJobCostActualOhPrice($proposalId){
        $sql = "SELECT COALESCE(SUM(jci.actual_oh_price), 0.00) AS totalPrice
        FROM job_cost_item jci
        WHERE jci.proposal_id ='$proposalId'";

        $result = $this->getSingleResult($sql);
   
        return  $result->totalPrice;
    }

    public function getProposalJobCostActualTaxPrice($proposalId){
        $sql = "SELECT COALESCE(SUM(jci.actual_tax_price), 0.00) AS totalPrice
        FROM job_cost_item jci
        WHERE jci.proposal_id ='$proposalId'";

        $result = $this->getSingleResult($sql);
   
        return  $result->totalPrice;
    }

    public function getProposalJobCostActualPrice($proposalId){
        $sql = "SELECT COALESCE(SUM(jci.actual_total_price), 0.00) AS totalPrice
        FROM job_cost_item jci
        WHERE jci.proposal_id ='$proposalId'";

        $result = $this->getSingleResult($sql);

        return  $result->totalPrice;
    }

    /**
     * @param Companies $company
     * @param $proposalId
     * @return array
     */
    public function getProposalJobCostSortedLineItemsTotal(Companies $company, $proposalId)
    {
        $allLineItems = $this->getAllProposalLineItems($proposalId);
        $out = [];
    

        foreach ($allLineItems as $lineItem) {
            /* @var \models\EstimationLineItem $lineItem */
            $category = $lineItem->getItemTypeCategory();
            $jobCostItem = $this->em->getRepository('models\JobCostItem')->findOneBy(array(
                'estimate_line_item_id' => $lineItem->getId()
            ));
            $old_line_total = $lineItem->getTotalPrice();
            $lineItem->job_cost = 0;
            $lineItem->files = [];
            if($jobCostItem){
                $lineItem->setDay($jobCostItem->getDay());
                $lineItem->setNumPeople($jobCostItem->getNumPeople());
                $lineItem->setHoursPerDay($jobCostItem->getHpd());
                
                $lineItem->job_costing =1;
                $lineItem->area = $jobCostItem->getArea();
                $lineItem->depth = $jobCostItem->getDepth();

                $lineItem->act_total = $jobCostItem->getActualTotalPrice();
                $lineItem->act_qty = $jobCostItem->getActualQty();
                $lineItem->diff = $jobCostItem->getPriceDifference();
               
                $lineItem->job_cost = 1;
                $lineItem->files = $this->getJobCostItemFiles($jobCostItem->getId());
            
                $lineItem->old_total = $old_line_total;
                if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                    $lineItem->item_type_time = 1;
                    $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                    if (count($calculator) > 0) {
                        $lineItem->saved_values = $calculator[0]['saved_values'];
                    } else {
                        $lineItem->saved_values = [];
                    }
                } else {
                    $lineItem->item_type_time = 0;
                    $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                    if (count($calculator) > 0) {
                        $lineItem->saved_values = $calculator[0]['saved_values'];
                    } else {
                        $lineItem->saved_values = [];
                    }
                }

                if ($lineItem->getItem()->getTypeId() == 20) {
                    $address = '';
                    $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                    $address = '';
                    if (count($calculator) > 0) {

                        $saved_values = json_decode($calculator[0]['saved_values']);
                        for ($i = 0; $i < count($saved_values); $i++) {


                            if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                                $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                            } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                                $address = '<br>' . $saved_values[$i]->value;
                            }
                        }
                    }
                    $lineItem->item_type_trucking = 1;
                    $lineItem->plant_dump_address = $address;
                } else {
                    $lineItem->item_type_trucking = 0;
                    $lineItem->plant_dump_address = '';
                }

                // Crate the array item if we need it
                if (!array_key_exists($category->getId(), $out)) {

                    
                    $out[$category->getId()] = [
                        'category' => $category,
                        'items' => [],
                        'job_cost_items' => []
                    // 'job_cost_items' => $this->getJobCostItemsByCategory($category->getId(),$proposalServiceId),
                    ];

                }
                //print_r($category->getId());die;

                // Add the item
                $out[$category->getId()]['items'][] = $lineItem;
            }
            //$out[$category->getId()]['job_cost_items'] = $this->getJobCostItemsByProposal($category->getId(),$proposalId);
        }
         $jobCostItmes = $this->getJobCostItemsProposal($proposalId);
        foreach($jobCostItmes as $jobCostItme){
            $jobCostItemFiles = $this->getJobCostItemFiles($jobCostItme->getId());
            $jobCostItme->files = $jobCostItemFiles;
            $out[$jobCostItme->getCategoryId()]['category'] = $this->em->find('models\EstimationCategory', $jobCostItme->getCategoryId());
            $out[$jobCostItme->getCategoryId()]['job_cost_items'][] =$jobCostItme;
        }
        //$out[$category->getId()]['job_cost_items'][] = $this->getJobCostItemsByCategory($category->getId(),$proposalServiceId);
        $sortedCategories = $this->getCompanyCategories($company);
        $sortedOut = [];
        
        foreach ($sortedCategories as $category) {
            if (array_key_exists($category->getId(), $out)) {
                $sortedOut[] = $out[$category->getId()];
            }
        }
        // echo '<pre>';
        // print_r($sortedOut);
        // die;
        return $sortedOut;
    }

    public function getJobCostReportSummary(Proposals $proposal){
        
        $return =[];
        $breakdownData = $this->getProposalPriceBreakdown($proposal->getProposalId());
        $actual_total_price = $this->getProposalJobCostActualPrice($proposal->getProposalId());
        $job_cost_oh_price = $this->getProposalJobCostActualOhPrice($proposal->getProposalId());
        $job_cost_tax_price = $this->getProposalJobCostActualTaxPrice($proposal->getProposalId());
         //echo '<pre>';
         //print_r($breakdownData);
         //echo ($breakdownData['totalPrice'] + $breakdownData['overheadPrice'] + $breakdownData['taxPrice']);
        // die;
        $return['gross_profit'] =  ($breakdownData['totalPrice']) - ($actual_total_price + $job_cost_oh_price);
        //$return['gross_profit'] = ($breakdownData['totalPrice']) - ($job_cost_price_diff + $breakdownData['basePrice'] );
        if($actual_total_price>0){
            $return['profit_margin'] = (($return['gross_profit'] / ($actual_total_price + $job_cost_oh_price))*100);
            $return['overhead_percent'] = (($job_cost_oh_price / $actual_total_price)*100);
            $return['tax_percent'] = (($job_cost_tax_price / $actual_total_price)*100);
        }else{
            $return['profit_margin'] = '0.00';
            $return['overhead_percent'] = '0.00';
            $return['tax_percent'] = '0.00';
        }
        
        $return['overhead_price'] = $job_cost_oh_price;
        $return['tax_price'] = $job_cost_tax_price;
        
        
        $return['estimate_total'] = $breakdownData['totalPrice'];
        $return['job_cost_total'] = $actual_total_price;
        
        $return['estimate_gross_profit'] =  $breakdownData['profitPrice'];
       
        if($breakdownData['basePrice']>0){
            $return['estimate_profit_margin'] = (($breakdownData['profitPrice'] / $breakdownData['basePrice'])*100);
            $return['estimate_overhead_percent'] = (($breakdownData['overheadPrice'] / $breakdownData['basePrice'])*100);
        }else{
            $return['estimate_profit_margin'] = 0;
            $return['estimate_overhead_percent'] =0;
        }

        $return['estimate_overhead_price'] = $breakdownData['overheadPrice'];
       // echo $breakdownData['basePrice'];
         $return['estimate_tax_price'] = $breakdownData['taxPrice'];

         $total_without_tax = $breakdownData['totalPrice'] - $breakdownData['taxPrice'];
         if($total_without_tax>0){
            $return['estimate_tax_percent'] = (($breakdownData['taxPrice'] / ($breakdownData['totalPrice'] - $breakdownData['taxPrice']))*100);
         }else{
            $return['estimate_tax_percent'] = 0;
         }
         

        $return['gross_profit_diff'] = $return['gross_profit'] - $return['estimate_gross_profit'];
        $return['profit_margin_diff']  = $return['profit_margin'] - $return['estimate_profit_margin'];
        $return['overhead_percent_diff'] = $return['overhead_percent'] - $return['estimate_overhead_percent'];
        $return['overhead_price_diff'] = $return['overhead_price'] - $return['estimate_overhead_price'];

        $return['tax_percent_diff'] = $return['tax_percent'] - $return['estimate_tax_percent'];
        $return['tax_price_diff'] = $return['tax_price'] - $return['estimate_tax_price'];
       
        return $return;

    }

    /**
     * @param Companies $company
     * @param $proposalId
     * @return array
     */
    public function getTruckingProposalSortedLineItems($proposalId)
    {
       // $allLineItems = $this->getAllProposalLineItems($proposalId);
         $sql = "SELECT eli.id
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 " ;

        $allLineItems =  $this->getAllResults($sql);
        $out = [];
        if(count($allLineItems)>0){
            $aggBaseCost = $this->getProposalTruckingBaseCost($proposalId);
                $aggOverheadCost = $this->getProposalTruckingOverheadCost($proposalId);
                $aggProfitCost = $this->getProposalTruckingProfitCost($proposalId);
                $aggTotalCost = $this->getProposalTruckingTotalCost($proposalId);
                $aggOverheadRate = (($aggOverheadCost != 0) && ($aggBaseCost != 0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggProfitCost != 0) && ($aggBaseCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;
                $aggTaxCost = $this->getProposalTruckingTaxCost($proposalId);
                $aggTaxRate = (($aggTaxCost > 0) && ($aggBaseCost > 0)) ? number_format(($aggTaxCost / $aggBaseCost) * 100, 2) : 0;

                 $out = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
                'aggregateTaxPrice' => $aggTaxCost,
                'aggregateTaxRate' => $aggTaxRate,
                'aggregateTotalRate' => $aggTotalCost,
            ];
        

        foreach ($allLineItems as $lineItemId) {
            /* @var \models\EstimationLineItem $lineItem */
            $lineItem = $this->em->findEstimationLineItem($lineItemId->id);
            
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }

            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            
            // Crate the array item if we need it
           
                
           
                
                $out['items'][] = $lineItem;
            
        

            }
       
        }
    }

         return $out;
    }


    /**
     * @param Companies $company
     * @param $proposalId
     * @return array
     */
    public function getTruckingProposalServiceLineItems(Companies $company, $proposalServiceId)
    {
       // $allLineItems = $this->getAllProposalLineItems($proposalId);
         $sql = "SELECT eli.id
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 " ;

        $allLineItems =  $this->getAllResults($sql);
        $out = [];

        foreach ($allLineItems as $lineItemId) {
            /* @var \models\EstimationLineItem $lineItem */
            $lineItem = $this->em->findEstimationLineItem($lineItemId->id);
            
            $category = $lineItem->getItemTypeCategory();
            $jobCostItem = $this->em->getRepository('models\JobCostItem')->findOneBy(array(
                'estimate_line_item_id' => $lineItem->getId()
            ));
            $old_line_total = $lineItem->getTotalPrice();
            $old_quantity = $lineItem->getQuantity();
            $lineItem->job_cost = 0;
            $lineItem->job_cost_item_id = 0;
            $lineItem->job_cost_files =[];
            if($jobCostItem){
                $lineItem->job_cost_item_id = $jobCostItem->getId();
                $lineItem->setDay($jobCostItem->getDay());
                $lineItem->setNumPeople($jobCostItem->getNumPeople());
                $lineItem->setHoursPerDay($jobCostItem->getHpd());
                $lineItem->setQuantity($jobCostItem->getActualQty());
                
                $lineItem->setTotalPrice($jobCostItem->getActualTotalPrice());
                $lineItem->base_total = $jobCostItem->getActualTotalPrice();
                $lineItem->job_costing =1;
                $lineItem->area = $jobCostItem->getArea();
                $lineItem->depth = $jobCostItem->getDepth();
                $lineItem->job_cost = 1;

                // $jobCostItemFiles = $this->em->getRepository('models\JobCostItemFile')->findOneBy(array(
                //     'job_cost_item_id' => $jobCostItem->getId()
                // ));
                $jobCostItemFiles = $this->getJobCostItemFiles($jobCostItem->getId());
                $lineItem->job_cost_files = $jobCostItemFiles;
            }else{
                $lineItem->job_costing =0;
                $lineItem->base_total = ($lineItem->getBasePrice() * $lineItem->getQuantity()) ;
            }
            $lineItem->old_total = $old_line_total;
            $lineItem->old_quantity = $old_quantity;
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());

                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            } else {
                $lineItem->item_type_trucking = 0;
                $lineItem->plant_dump_address = '';
            }

            $out[0]['items'][] = $lineItem;
       
        }

         return $out;
    }


    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalTruckingBaseCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
       
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);
        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalTruckingOverheadCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
       
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalTruckingProfitCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalTruckingTotalCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalServiceId
     * @return mixed
     */
    public function getProposalTruckingTaxCost($proposalId)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.proposal_id = " . (int)$proposalId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }


    /**
     * @param Companies $company
     * @param $proposalServiceId
     * @return array
     */
    public function getTruckingProposalServiceSortedLineItems($proposalServiceId)
    {
       // $allLineItems = $this->getAllProposalLineItems($proposalId);
         $sql = "SELECT eli.id
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 " ;

        $allLineItems =  $this->getAllResults($sql);
        $out = [];
        if(count($allLineItems)>0){

                $aggBaseCost = $this->getProposalServiceTruckingBaseCost($proposalServiceId);
                $aggOverheadCost = $this->getProposalServiceTruckingOverheadCost($proposalServiceId);
                $aggProfitCost = $this->getProposalServiceTruckingProfitCost($proposalServiceId);
                $aggTotalCost = $this->getProposalServiceTruckingTotalCost($proposalServiceId);
                $aggOverheadRate = (($aggOverheadCost != 0) && ($aggBaseCost != 0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggProfitCost != 0) && ($aggBaseCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;
                $aggTaxCost = $this->getProposalServiceTruckingTaxCost($proposalServiceId);
                $aggTaxRate = (($aggTaxCost > 0) && ($aggBaseCost > 0)) ? number_format(($aggTaxCost / $aggBaseCost) * 100, 2) : 0;

                 $out = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
                'aggregateTaxPrice' => $aggTaxCost,
                'aggregateTaxRate' => $aggTaxRate,
                'aggregateTotalRate' => $aggTotalCost,
            ];
           
        foreach ($allLineItems as $lineItemId) {
            /* @var \models\EstimationLineItem $lineItem */
            $lineItem = $this->em->findEstimationLineItem($lineItemId->id);
            
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }

            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                }
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            
            // Crate the array item if we need it
           
                
                
                $out['items'][] = $lineItem;
            
        

            }
       
        }
    }

         return $out;
    }


    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalServiceTruckingBaseCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
       
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);
        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalServiceTruckingOverheadCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
       
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalServiceTruckingProfitCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getProposalServiceTruckingTotalCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalServiceId
     * @return mixed
     */
    public function getProposalServiceTruckingTaxCost($proposalServiceId)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.proposal_service_id = " . (int)$proposalServiceId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }


        /**
   
     * @param $phaseId
     * @return array
     */
    public function getTruckingPhaseSortedLineItems($phaseId)
    {
       // $allLineItems = $this->getAllProposalLineItems($proposalId);
         $sql = "SELECT eli.id
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 " ;

        $allLineItems =  $this->getAllResults($sql);
        $out = [];

        if(count($allLineItems)>0){
            $aggBaseCost = $this->getPhaseTruckingBaseCost($phaseId);
                $aggOverheadCost = $this->getPhaseTruckingOverheadCost($phaseId);
                $aggProfitCost = $this->getPhaseTruckingProfitCost($phaseId);
                $aggTotalCost = $this->getPhaseTruckingTotalCost($phaseId);
                $aggOverheadRate = (($aggOverheadCost != 0) && ($aggBaseCost != 0)) ? number_format(($aggOverheadCost / $aggBaseCost) * 100, 2) : 0;
                $aggProfitRate = (($aggProfitCost != 0) && ($aggBaseCost != 0)) ? number_format(($aggProfitCost / $aggBaseCost) * 100, 2) : 0;
                $aggTaxCost = $this->getPhaseTruckingTaxCost($phaseId);
                $aggTaxRate = (($aggTaxCost > 0) && ($aggBaseCost > 0)) ? number_format(($aggTaxCost / $aggBaseCost) * 100, 2) : 0;

                 $out = [
                'items' => [],
                'aggregateBaseCost' => $aggBaseCost,
                'aggregateOverheadPrice' => $aggOverheadCost,
                'aggregateProfitPrice' => $aggProfitCost,
                'aggregateOverheadRate' => $aggOverheadRate,
                'aggregateProfitRate' => $aggProfitRate,
                'aggregateTaxPrice' => $aggTaxCost,
                'aggregateTaxRate' => $aggTaxRate,
                'aggregateTotalRate' => $aggTotalCost,
            ];
        
        foreach ($allLineItems as $lineItemId) {
            /* @var \models\EstimationLineItem $lineItem */
            $lineItem = $this->em->findEstimationLineItem($lineItemId->id);
            
            if ($lineItem->getItem()->getUnitModel()->getUnitType() == 6) {
                $lineItem->item_type_time = 1;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }

            } else {
                $lineItem->item_type_time = 0;
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                if (count($calculator) > 0) {
                    $lineItem->saved_values = $calculator[0]['saved_values'];
                } else {
                    $lineItem->saved_values = [];
                }
            }

            if ($lineItem->getItem()->getTypeId() == 20) {
                $address = '';
                $calculator = $this->getEstimateCalculatorValue($lineItem->getId());
                $address = '';
                if (count($calculator) > 0) {

                    $saved_values = json_decode($calculator[0]['saved_values']);
                    for ($i = 0; $i < count($saved_values); $i++) {


                        if (($saved_values[$i]->name == 'plantselect' && $saved_values[$i]->value != '') || ($saved_values[$i]->name == 'dumpselect' && $saved_values[$i]->value != '')) {

                            $address = $this->getPlantDumpAddressById($saved_values[$i]->value);
                        } else if ($saved_values[$i]->name == 'sep_trucking_end_searchBox') {
                            $address = '<br>' . $saved_values[$i]->value;
                        }
                    }
                } 
                $lineItem->item_type_trucking = 1;
                $lineItem->plant_dump_address = $address;
            
            // Crate the array item if we need it
           
                
                $out['items'][] = $lineItem;
            
        

            }
       
        }
    }

         return $out;
    }


    /**
     * @param $proposalId
     * @return mixed
     */
    public function getPhaseTruckingBaseCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM((eli.base_price * eli.quantity)), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
       
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)   AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);
        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getPhaseTruckingOverheadCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.overhead_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
       
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getPhaseTruckingProfitCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.profit_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalId
     * @return mixed
     */
    public function getPhaseTruckingTotalCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.total_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND eli.fixed_template!=1
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
        
    }

    /**
     * @param $proposalServiceId
     * @return mixed
     */
    public function getPhaseTruckingTaxCost($phaseId)
    {
        $sql = "SELECT COALESCE(SUM(eli.tax_price), 0.00) AS totalPrice
        FROM estimate_line_items eli
        LEFT JOIN estimation_items ei ON eli.item_id = ei.id
        WHERE eli.phase_id = " . (int)$phaseId . "
        AND (eli.sub_id=0 OR eli.sub_id IS NULL)  AND eli.is_custom_sub = 0
        AND ei.type_id =20 ";

        $result = $this->getSingleResult($sql);

        return $result->totalPrice;
    }

  
    public function getJobCostItemFiles($job_cost_item_id)
    {
        $dql = "SELECT jcif
        FROM \models\JobCostItemFile jcif
        WHERE jcif.job_cost_item_id = :job_cost_item_id";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':job_cost_item_id', $job_cost_item_id);
        return $query->getResult();

    }

    public function getCompanyForemenList(Companies $company){
        $dql = "SELECT fr
        FROM \models\Foremen fr
        WHERE fr.company = :companyId
        AND fr.is_deleted = 0
        ORDER BY fr.ord";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        //Cache It
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_FOREMEN . $company->getCompanyId());
        return $query->getResult();
        
    }
    

    /**
     * @param Proposals $proposal
     */
    public function countProposalEstimate(Proposals $proposal)
    {
        $proposalId = $proposal->getProposalId();

        $sql = "SELECT COUNT(pe.id) AS numLineItems
            FROM proposal_estimates pe
            WHERE pe.proposal_id = " . (int)$proposalId;

        $result = $this->getSingleResult($sql);
        
        return $result->numLineItems;

    }

    /**
     * @param Proposals $proposal
     */
    public function modifyProposalEstimatePrice(Accounts $account , Proposals $proposal,$multiplier)
    {
        $proposalId = $proposal->getProposalId();
        $allLineItems = $this->getAllProposalLineItems($proposalId);
        

        foreach ($allLineItems as $lineItem) {

            $oldPrice = $lineItem->getTotalPrice();
            $total_price = round($oldPrice * $multiplier);
           // $total_price = str_replace(['$', ','], ['', ''], $this->input->post('total_price'));
        // $estimate_line_id = $this->input->post('estimate_line_id');
        // $proposalServiceId = $this->input->post('proposalServiceId');
        // $phase_id = $this->input->post('phase_id');
        $eli = $lineItem;
        $old_item = clone $eli;

        $OverheadRate = $eli->getOverheadRate();

        $ProfitRate = $eli->getProfitRate();

        $TaxRate = $eli->getTaxRate();

        $quantity = $eli->getQuantity();

        $TaxRate = ($TaxRate / 100) + 1;

        $before_tax_total =$total_price;

        $total_price = ($total_price/ $TaxRate);

        $total_tax =$before_tax_total-$total_price;

         $total_rate = (($OverheadRate + $ProfitRate) / 100) + 1;

         $unit_price = ($total_price/ $quantity);

         $base_cost = ($unit_price/ $total_rate);

         $overheadUnitPrice = (($base_cost * $OverheadRate)/100);

         $profitUnitPrice = (($base_cost * $ProfitRate)/100);

         $taxUnitPrice = (($base_cost * $TaxRate)/100);

         $temp_overhead_total = $overheadUnitPrice*$eli->getQuantity();

        $temp_profit_total = $profitUnitPrice*$eli->getQuantity();



            $eli->setUnitPrice($unit_price);


            // Total Price
            $eli->setTotalPrice($before_tax_total);
            // Base price
            $eli->setBasePrice($base_cost);
            // setOverheadRate
            //$eli->setOverheadRate($overheadUnitPrice);
            // set Profit Rate
            //$eli->setProfitRate($profitUnitPrice);
            // set OverheadPrice
            $eli->setOverheadPrice($temp_overhead_total);
            // set Profit Price
            $eli->setProfitPrice($temp_profit_total);
            $eli->setTaxPrice($total_tax);
            $eli->setCustomTotalPrice(1);
            // Save it
            $this->em->persist($eli);
            $this->em->flush();
            $logMessage = 'Price Adjusted by global price update.<br/>';
            $logMessage .= '<strong>Item Name:</strong> '.$eli->getItem()->getName().' <br/>';
            $logMessage .= '<strong>Total Price:</strong> From $' . number_format($oldPrice, 2) . ' to $' . number_format($lineItem->getTotalPrice(), 2) . '';
            //$logMessage .= '<br/>';
            $this->getEstimationRepository()->addLog(
                $account,
                $proposal->getProposalId(),
                'update_item',
                $logMessage
            );

        }
    }
    
    
}