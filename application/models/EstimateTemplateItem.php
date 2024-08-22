<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimate_template_items")
 */
class EstimateTemplateItem extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $template_id;
    /**
     * @ORM\Column(type="string")
     */
    private $item_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $deleted = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;
    /**
     * @ORM\Column(type="integer")
     */
    private $default_days;
    /**
     * @ORM\Column(type="integer")
     */
    private $default_qty;
    /**
     * @ORM\Column(type="integer")
     */
    private $default_hpd;

    function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @param mixed $template_id
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param mixed $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    /**
     * @return mixed
     */
    public function getDefaultDays()
    {
        return $this->default_days;
    }

    /**
     * @param mixed $default_days
     */
    public function setDefaultDays($default_days)
    {
        $this->default_days = $default_days;
    }

    /**
     * @return mixed
     */
    public function getDefaultQty()
    {
        return $this->default_qty;
    }

    /**
     * @param mixed $default_qty
     */
    public function setDefaultQty($default_qty)
    {
        $this->default_qty = $default_qty;
    }

    /**
     * @return mixed
     */
    public function getDefaultHpd()
    {
        return $this->default_hpd;
    }

    /**
     * @param mixed $default_hpd
     */
    public function setDefaultHpd($default_hpd)
    {
        $this->default_hpd = $default_hpd;
    }

}