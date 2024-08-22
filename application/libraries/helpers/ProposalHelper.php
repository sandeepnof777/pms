<?php

class ProposalHelper extends BaseHelper {

    /* @var \models\Proposals */
    private $proposal;

    /* @var string */
    private $uploadDirPath;


    public function __construct(array $params = [])
    {
        parent::__construct($params);

        if (isset($params['field'])){
            $this->setField($params['field']);
        }
    }

    /**
     * @return \models\Proposals
     */
    public function getProposal()
    {
        return $this->proposal;
    }

    /**
     * @param \models\Proposals
     */
    public function setProposal($proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * @return string
     */
    public function getUploadDirPath()
    {
        return $this->uploadDirPath;
    }

    /**
     * Set the upload path
     */
    public function setUploadDirPath()
    {
        $this->uploadDirPath = $this->getProposal()->getUploadDir();
    }


    public function requestDelete()
    {
        // Load the proposal
        $proposal = $this->getProposal();
        // Get the delete status
        $deleteStatus = $this->getAccount()->getCompany()->getDefaultStatus(\models\Status::DELETE_REQUEST);

        // Apply to the proposal
        if ($deleteStatus && $proposal) {
            $proposal->setProposalStatus($deleteStatus);
            $this->em->persist($proposal);
            $this->em->flush();
        }
        // Log it
        $this->logManager->add('delete_request', "User requested delete for '" . $proposal->getProjectName() . "' proposal");
    }


    public function delete($deleteDuplicates = false)
    {
        // Load the proposal
        $proposal = $this->getProposal();

        if ($proposal) {

            // Deal with duplicates
            if ($proposal->hasDuplicates()) {

                // Get the duplicates
                $duplicates = $proposal->getDuplicates();

                // Are we deleting duplicates as well?
                if ($deleteDuplicates) {
                    // Yes, so delete all the duplicates
                    foreach ($duplicates as $duplicate) {
                        /* @var $duplicate \models\Proposals */
                        $duplicate->deleteFilesAndDir();
                        $this->em->remove($duplicate);
                        $this->logManager->add('delete_proposal', "Proposal '" . $duplicate->getProjectName() . "' deleted");
                    }
                }
                else {
                    // Shift first element off
                    $firstDuplicate = array_shift($duplicates);
                    /* @var $firstDuplicate \models\Proposals */

                    // Set first duplicate as standalone
                    $firstDuplicate->setDuplicateOf(null);
                    $this->em->persist($firstDuplicate);

                    // Now make other duplicates belong to the first duplicate
                    foreach ($duplicates as $duplicate) {
                        /* @var $duplicate \models\Proposals */
                        $duplicate->setDuplicateOf($firstDuplicate->getProposalId());
                        $this->em->persist($duplicate);
                    }
                }
            }

            // Remove images and attachments
            $proposal->deleteFilesAndDir();
            $this->em->remove($proposal);
            $this->em->flush();

            //Delete user query Cache
            $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($this->getAccount()->getCompany()->getCompanyId());

            // Log it
            $this->logManager->add('delete_proposal', "Proposal '" . $proposal->getProjectName() . "' deleted");
        }
    }

}