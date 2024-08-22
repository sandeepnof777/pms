<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposals_images")
 */
class Proposals_images extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $imageId;
    /**
     * @ORM\ManyToOne(targetEntity="Proposals", cascade={"persist"}, inversedBy="proposalImages")
     * @ORM\JoinColumn(name="proposal", referencedColumnName="proposalId")
     */
    private $proposal;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $ord;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $active;
    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $active_workorder;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $notes;
    /**
     * @ORM\Column(type="integer")
     */
    private $optimized =0;
    /**
     * @ORM\Column(type="integer")
     */
    private $image_layout=0;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_service_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $map =0;

    function __construct()
    {
        $this->active = 0;
        $this->active_workorder = 0;
        $this->ord = 0;
    }

    public function getImageId()
    {
        return $this->imageId;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function setProposal($proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * @return \models\Proposals
     */
    public function getProposal()
    {
        return $this->proposal;
    }

    public function getOrder()
    {
        return $this->ord;
    }

    public function setOrder($ord)
    {
        $this->ord = $ord;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getActivewo()
    {
        return $this->active_workorder;
    }

    public function setActivewo($active)
    {
        $this->active_workorder = $active;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getImageLayout()
    {
        return $this->image_layout;
    }

    public function setImageLayout($image_layout)
    {
        $this->image_layout = $image_layout;
    }

    public function getOptimized()
    {
        return $this->optimized;
    }

    public function setOptimized($optimized)
    {
        $this->optimized = $optimized;
    }

    public function getMap()
    {
        return $this->map;
    }

    public function setMap($map)
    {
        $this->map = $map;
    }
    

    //TODO FIX THIS
    public function deleteFile()
    {
        /*
        $CI =& get_instance();
        $proposal = $this->getProposal();

        if ($proposal) {
            $directory = $proposal->getUploadDir();
            $filePath = $directory . $this->getFilePath();

            if (file_exists($filePath)) {
                // Delete file
                unlink($filePath);
            }
        }
        */
    }

    public function getWebPath()
    {
        return '/uploads/companies/' . $this->getProposal()->getOwner()->getCompanyId() . '/proposals/' . $this->getProposal()->getProposalId() . '/' . $this->getImage();
    }

    public function getFullWebPath()
    {
        return site_url('/uploads/companies/' . $this->getProposal()->getOwner()->getCompanyId() . '/proposals/' . $this->getProposal()->getProposalId() . '/' . $this->getImage());
    }

    public function getFullPath()
    {
        return $this->getProposal()->getUploadDir() . '/' . $this->getImage();
    }

    public function getProposalServiceId()
    {
        return $this->proposal_service_id;
    }

    public function setProposalServiceId($proposal_service_id)
    {
        $this->proposal_service_id = $proposal_service_id;
    }

}