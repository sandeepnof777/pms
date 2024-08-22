<?php
namespace Pms\Repositories;


use Pms\RepositoryAbstract;
use Pms\Traits\CITrait;
use Pms\Traits\DBTrait;

class ProposalLinks extends RepositoryAbstract
{
    use DBTrait;
    use CITrait;

    /**
     * Get Links per proposal
     * @param $proposalId
     * @return array
     */
    public function getProposalLinks($proposalId, $companyId)
    {
        return $this->getAllResults("select * from proposal_links where proposal={$proposalId} or (proposal = 0 and company = {$companyId})");
    }

    /**
     * Get Links per Company
     * @param $companyId
     * @return array
     */
    public function getCompanyProposalLinks($companyId)
    {
        return $this->getAllResults('select * from proposal_links where company=' . $companyId . ' and proposal = 0');
    }

    /**
     * Add link
     * @param $company
     * @param int $proposal
     * @param string $name
     * @param string $url
     */
    public function addLink($name, $url, $company, $proposal = 0)
    {
        $data = [
            'name' => $name,
            'url' => $url,
            'company' => $company,
            'proposal' => $proposal,
        ];
        return $this->insert('proposal_links', $data);
    }

    /**
     * Edit Link
     * @param $id
     * @param $name
     */
    public
    function saveLinkName($id, $name)
    {
        $this->query("update proposal_links set name='{$name}' where id={$id}");
    }

    /**
     * Edit Link
     * @param $id
     * @param $url
     */
    public
    function saveLinkURL($id, $url)
    {
        $this->query("update proposal_links set url='{$url}' where id={$id}");
    }

    /**
     * @param $id
     * @param $name
     * @param $url
     */
    public function updateLinkDetails($id, $name, $url)
    {
        $this->query("update proposal_links set url='{$url}', name='{$name}' where id={$id}");
    }

    /**
     * Deletes a link
     * @param $id
     */
    public
    function deleteLink($id)
    {
        $this->query("delete from proposal_links where id={$id} limit 1");
    }
}