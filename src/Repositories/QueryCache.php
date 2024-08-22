<?php

namespace Pms\Repositories;

use Carbon\Carbon;
use Doctrine\ORM\Query\ResultSetMapping;
use EmailTemplateParser;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class QueryCache extends RepositoryAbstract
{
    use DBTrait;

    public function deleteCompanyForemenCache($companyId)
    {
        //Temp Delete Cache result
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_FOREMEN . $companyId);
    }

    public function deleteCompanyServiceCaches($companyId)
    {
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_SERVICES . $companyId);
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_SERVICES_MAP . $companyId);
    }

    public function deleteCompanyServiceCache($companyId)
    {
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_SERVICES . $companyId);
    }

    public function deleteCompanyServiceMapCache($companyId)
    {
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_SERVICES_MAP . $companyId);
    }

    public function deleteCompanyStatusCache($companyId)
    {
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_STATUSES . $companyId);
    }

    public function deleteCompanyWorkOrderRecipCache($companyId)
    {
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_WORK_ORDER_RECIP . $companyId);
    }

    public function deleteCompanyBusinessTypeCache($companyId)
    {
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_BUSINESS_TYPE . $companyId);
    }

    public function deleteCompanyLeadsCountCache($companyId)
    {
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_ADMIN_HEADER_LEAD_COUNT . $companyId);
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_BRANCH_HEADER_LEAD_COUNT . $companyId);
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_USER_HEADER_LEAD_COUNT . $companyId);
    }

    public function deleteCompanyUserAllCache($companyId)
    {
        $this->deleteCompanyHeaderProposalCache($companyId);
        $this->deleteCompanyLeadsCountCache($companyId);
    }

    public function deleteCompanyHeaderProposalCache($companyId)
    {

        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_ADMIN_HEADER_QUEUED_PROPOSAL_COUNT . $companyId);
        //$this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_ADMIN_HEADER_DECLINED_PROPOSAL_COUNT . $companyId);
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_BRANCH_HEADER_QUEUED_PROPOSAL_COUNT . $companyId);
        //$this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_BRANCH_HEADER_DECLINED_PROPOSAL_COUNT . $companyId);
        $this->deleteProposalsCache($companyId);
    }

    public function deleteCompanyContactsAllCache($companyId)
    {
        $this->deleteCompanyHeaderProposalCache($companyId);
        
    }

    public function deleteEmailTemplateListCache($companyId,$templateTypeId){
        
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_TYPE_USER_PROPOSAL_PAGE_TEMPLATE_LIST . $companyId.'_'.$templateTypeId);
    }

    public function deleteAdminEmailTemplateListCache($templateTypeId){
        
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_TYPE_ADMIN_PROPOSAL_PAGE_TEMPLATE_LIST . $templateTypeId);
    }


    public function deleteProposalsCache($companyId){
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_PROPOSAL_MAX_PRICE . $companyId);
        
    }
    public function deleteProposalsResendListCache($companyId){
        $this->em->getConfiguration()->getResultCacheImpl()->delete(CACHE_COMPANY_PROPOSAL_RESEND_LIST . $companyId);
        
    }

}
