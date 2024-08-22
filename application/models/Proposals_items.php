<?php

namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposals_items")
 */
class Proposals_items
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $linkId;
    /**
     * @ORM\ManyToOne(targetEntity="Proposals", cascade={"persist"}, inversedBy="proposalItems")
     * @ORM\JoinColumn(name="proposal", referencedColumnName="proposalId")
     */
    private $proposal;
    /**
     * @ORM\ManyToOne(targetEntity="Items", cascade={"persist"}, inversedBy="proposals")
     * @ORM\JoinColumn(name="item", referencedColumnName="itemId")
     */
    private $item;
    /**
     * @ORM\OneToMany(targetEntity="Fields_values", mappedBy="proposalItem", cascade={"persist"})
     */
    private $fieldsValues;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;

    function __construct()
    {
        $this->fieldsValues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ord = 0;
    }

    public function getLinkId()
    {
        return $this->linkId;
    }

    public function getProposal()
    {
        return $this->proposal;
    }

    public function setProposal($proposal)
    {
        $this->proposal = $proposal;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function setItem($item)
    {
        $this->item = $item;
    }

    public function getFieldsValues()
    {
        return $this->fieldsValues;
    }

    public function getFieldValue($fieldName)
    {
        $fields = $this->getFieldsValues();
        foreach ($fields as $fieldValue) {
            if ($fieldValue->getField()->getFieldLabel() == $fieldName) {
                return $fieldValue->getFieldValue();
            }
        }
        return NULL;
    }

    public function getPrice($number = false)
    {
        $s = array('$', ',');
        $r = array('', '');
        $fields = $this->getFieldsValues();
        foreach ($fields as $field) {
            if ($field->getField()->getFieldLabel() == 'price') {
                if ($number) {
                    return $price = str_replace($s, $r, $field->getFieldValue());
                } else {
                    return $field->getFieldValue();
                }
            }
        }
        return 0;
    }

    public function getSpecs()
    {
        $specs = array();
        $fields = $this->getFieldsValues();
        foreach ($fields as $fieldValue) {
            $search = '##' . $fieldValue->getField()->getFieldLabel() . '_' . $fieldValue->getFieldValue() . '##';
            if (strstr($this->getItem()->getSpecs(), $search) != FALSE) {
                $specText = substr($this->getItem()->getSpecs(), (strpos($this->getItem()->getSpecs(), $search) + strlen($search)));
                if (strpos($specText, '##')) {
                    $specText = substr($specText, 0, strpos($specText, '##'));
                }
                $specs[$this->getItem()->getItemName()][$search] = $specText;
            }
        }
        return $specs;
    }

    public function updateFields($em = NULL)
    {
        if ($em) {
            $fields = $this->getItem()->getFields();
            $fieldsValues = $this->getFieldsValues();
            $fieldsIds = array();
            //just check if new fields have popped up... and add values with default value to this item.
            foreach ($fields as $f) {
                $fieldsIds[$f->getFieldId()] = $f;
            }
            foreach ($fieldsValues as $fv) {
                unset($fieldsIds[$fv->getField()->getFieldId()]);
            }
            if (count($fieldsIds)) {
                $newFieldValues = array();
                foreach ($fieldsIds as $f) {
                    $nfv = new Fields_values();
                    $nfv->setField($f);
                    $nfv->setFieldValue($f->getdefaultValue());
                    $nfv->setProposalItem($this);
                    $newFieldValues[] = $nfv;
                    unset($nfv);
                }
                foreach ($newFieldValues as $key => $nfw) {
                    $em->persist($newFieldValues[$key]);
                    $this->fieldsValues->add($newFieldValues[$key]);
                }
                $em->flush();
                $em->clear();
            }
        }
    }

    public function getItemText_old()
    {
        $itemText = $this->getItem()->getItemText();
        $search = array();
        $replace = array();
        $fvs = $this->getFieldsValues();
        foreach ($fvs as $fv) {
            $search[] = '##' . $fv->getField()->getFieldLabel() . '##';
            $replace[] = $fv->getFieldValue();
            if ($fv->getField()->getFieldLabel() == 'depth') {
                $search[] = '##base_size##';
                $replace[] = $fv->getFieldValue() - 2;
            }
        }
        return str_replace($search, $replace, $itemText);
    }

    public function getItemText()
    {
        $itemText = $this->getItem()->getItemText();
        $search = array();
        $replace = array();
        $fieldsValues = array();
        $fvs = $this->getFieldsValues();
        foreach ($fvs as $fv) {
            $fieldsValues[$fv->getField()->getFieldLabel()] = $fv->getFieldValue();
            $search[] = '##' . $fv->getField()->getFieldLabel() . '##';
            $replace[] = $fv->getFieldValue();
            if ($fv->getField()->getFieldLabel() == 'depth') {
                $search[] = '##base_size##';
                $replace[] = $fv->getFieldValue() - 2;
            }
        }
        $text = '';
        $content = explode('%%%', $itemText);
        foreach ($content as $content_item) {
            if ($content_item) {
                $content_item = explode('%%', $content_item);
                if ($content_item[0] == 'static') {
                    $text .= $content_item[1];
                } else {
                    $conditionals = explode('|', $content_item[0]);
                    //check if its a different than type of thing.
                    $check_item = @$fieldsValues[$conditionals[0]];
                    $check_value = @$conditionals[1];
                    $isNegation = false;
                    $neg = substr($check_value, 0, 1);
                    if ($neg == '!') {
                        $isNegation = true;
                        $check_value = substr($check_value, 1);
                    }
                    if ($isNegation) {
                        if (($check_item != $check_value)) {
                            $text .= @$content_item[1];
                        }
                    } else {
                        if (($check_item == $check_value)) {
                            $text .= @$content_item[1];
                        }
                    }
                }
            }
        }
        if ($this->getItem()->getItemId() == 11) {
            $text = nl2br(trim(str_replace($search, $replace, $text)));
            $text_array = explode('</h2>', $text);
            $text = @$text_array[0] . '</h2>';
            $list_items = explode('<br />', @$text_array[1]);
            $text .= '<ol>';
            foreach ($list_items as $li) {
                if (strlen(trim($li)) > 0) {
                    $text .= '<li>' . $li . '</li>';
                }
            }
            $text .= '</ol>';
        }
        return str_replace($search, $replace, $text);
    }

    public function getOrder()
    {
        return $this->ord;
    }

    public function setOrder($ord)
    {
        $this->ord = $ord;
    }
}
