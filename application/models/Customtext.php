<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customtext")
 */
class Customtext {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $textId;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $category;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $company;
    /**
     * @ORM\Column (type="string", nullable=true)
     */
    private $text;
    /**
     * @ORM\Column (type="string", nullable=true, length=2048)
     */
    private $checked;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $ord;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $service_id;


    function __construct() {
        $this->checked = 'no';
        $this->ord = 0;
    }

    public function getTextId() {
        return $this->textId;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function getText() {
        //remove the last br tags for some browser issues that adds them
        return preg_replace('/^(<br>)*/', "", $this->text);
    }

    public function setText($text) {
        $allowed_tags = '<b><strong><i><em><u><br><a>';
        $this->text = strip_tags(str_replace('</p>', '<br>', $text), $allowed_tags);
    }

    public function getChecked() {
        return $this->checked;
    }

    public function setChecked($checked) {
        $this->checked = $checked;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getOrd() {
        return $this->ord;
    }

    public function setOrd($ord) {
        $this->ord = $ord;
    }

    /*service id */
    public function getServiceId() {
        return $this->service_id;
    }

    public function setServiceId($service_id) {
        $this->service_id = $service_id;
    }
}
