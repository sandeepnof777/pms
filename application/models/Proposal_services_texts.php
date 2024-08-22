<?php
namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_services_texts")
 */
class Proposal_services_texts {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $textId;
    /**
     * @ORM\Column(type="integer")
     */
    private $serviceId;
    /**
     * @ORM\Column(type="string")
     */
    private $text;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;

    function __construct() {
    }

    public function getTextId() {
        return $this->textId;
    }

    public function getServiceId() {
        return $this->serviceId;
    }

    public function setServiceId($serviceId) {
        $this->serviceId = $serviceId;
    }

    public function getText() {
        $s = array('<p>', '</p>');
        $r = array('', '');

        $content = strip_tags(str_replace($s, $r, $this->text), '<b><i><u><strong><em><a><span><ol><ul><li>');

        // Strip <br> tags in the ul
        $strippedContent = preg_replace('/(?<=<ul>|<\/li>)\s*?(?=<\/ul>|<li>)/is', '', $content);
        $strippedContent = preg_replace('/(?<=<ol>|<\/li>)\s*?(?=<\/ol>|<li>)/is', '', $strippedContent);
        return $strippedContent;
    }

    public function setText($text) {
        $s = array('<p>', '</p>');
        $r = array('', '');
//        $r = array('', '<br>');
        $this->text = strip_tags(str_replace($s, $r, $text), '<b><i><u><strong><em><a><span><ol><ul><li>');
    }

    public function getOrd() {
        return $this->ord;
    }

    public function setOrd($ord) {
        $this->ord = $ord;
    }
}