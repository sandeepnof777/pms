<?php

namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_attachments")
 */
class Proposal_attachments extends \MY_Model{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $attachmentId;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposalId;
    /**
     * @ORM\Column(type="string")
     */
    private $fileName;
    /**
     * @ORM\Column(type="string")
     */
    private $filePath;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal;
    /**
     * @ORM\Column(type="integer")
     */
    private $work_order;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;

    function __construct() {
        $this->proposal = 0;
        $this->work_order = 0;
    }

    public function getAttachmentId() {
        return $this->attachmentId;
    }

    public function getProposalId() {
        return $this->proposalId;
    }

    public function setProposalId($proposalId) {
        $this->proposalId = $proposalId;
    }

    public function getFileName() {
        return $this->fileName;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    public function getFilePath() {
        return $this->filePath;
    }

    public function setFilePath($filePath) {
        $this->filePath = $filePath;
    }

    public function getProposal() {
        return $this->proposal;
    }

    public function setProposal($proposal) {
        $this->proposal = $proposal;
    }

    public function getWorkOrder() {
        return $this->work_order;
    }

    public function setWorkOrder($work_order) {
        $this->work_order = $work_order;
    }

    public function getOrd() {
        return $this->ord;
    }

    public function setOrd($ord) {
        $this->ord = $ord;
    }

    public function deleteFile()
    {
        $proposalId = $this->getProposal();
        $proposal = $this->doctrine->em->find('models\Proposals', $proposalId);

        if ($proposal) {
            $directory = $proposal->getUploadDir();
            $filePath = $directory . $this->getFilePath();

            if (file_exists($filePath)) {
                // Delete file
                unlink($filePath);
            }
        }
    }

}
