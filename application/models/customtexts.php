<?php
class Customtexts extends CI_Model {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;

    function __construct() {
        parent::__construct();
        $this->em = $this->doctrine->em;
    }

    function getCategories($companyId) {
        if ($companyId != 0) {
            $cats = $this->em->createQuery('SELECT c FROM models\Customtext_categories c where (c.company=' . $companyId . ' or c.company=0)')->getResult();
        } else {
            $cats = $this->em->createQuery('SELECT c FROM models\Customtext_categories c where (c.company=0)')->getResult();
        }
        $categories = array();
        foreach ($cats as $cat) {
            $categories[$cat->getCategoryId()] = $cat;
        }
        return $categories;
    }

    function getTexts($companyId) {
        //get active texts
        $texts = $this->em->createQuery('SELECT t FROM models\Customtext t where (t.company=' . $companyId . ' or t.company=0) and (t.textId not in (select d.textId from models\Deleted_customtexts d where d.companyId=' . $companyId . ')) order by t.ord')->getResult();
        $replacedTexts = $this->em->createQuery('SELECT d FROM models\Deleted_customtexts d where (d.companyId=' . $companyId . ' and d.replacedBy > 0)')->getResult();
        $rt = array();
        foreach ($replacedTexts as $replacedText) {
            $rt[$replacedText->getReplacedBy()] = $replacedText->getTextId();
        }
        $processedTexts = array();
        foreach ($texts as $text) {
            $id = $text->getTextId();
            if (@$rt[$id]) {
                $id = $rt[$id];
            }
            $processedTexts[$id] = $text;
        }
        //reorder as the company has them ordered algorythm
        if ($companyId != 0) {
            $processedAndOrderedTexts = array();
            $company = $this->em->find('models\Companies', $companyId);
            $textOrders = explode(',', $company->getCustomTextsOrder());
            foreach ($textOrders as $orderedId) {
                if (isset($processedTexts[$orderedId])) {
                    $processedAndOrderedTexts[$orderedId] = $processedTexts[$orderedId];
                    unset($processedTexts[$orderedId]);
                }
            }
            foreach ($processedTexts as $textId => $text) {
                $processedAndOrderedTexts[$textId] = $text;
            }
            $processedTexts = $processedAndOrderedTexts;
        }
        return $processedTexts;
    }

    function reorderTexts() {
    }

    function reorderCategories() {
    }

    function editText($text, $newValues, $companyId) {
        //$newValues = array('category','text','checked')
        //echo "<pre>";print_r($newValues);die;
        if (($companyId == 0) || ($text->getCompany() != 0)) {
            //update current text
            $text->setCategory($newValues[0]);
            $text->setText($newValues[1]);
            $text->setChecked($newValues[2]);
            $text->setServiceId($newValues[4]);

            $this->em->persist($text);
        } else {
            //delete current text from company and create new one that replaces it
            $newText = new models\Customtext();
            $newText->setCategory($newValues[0]);
            $newText->setText($newValues[1]);
            $newText->setChecked($newValues[2]);
            $newText->setCompany($companyId);
            $text->setServiceId($newValues[4]);
            $newText->setOrd($text->getOrd());
            $this->em->persist($newText);
            $this->em->flush();
            $this->deleteText($text, $companyId, $newText->getTextId());
        }
        $this->em->flush();
    }

    function deleteText($text, $companyId, $replacedBy = NULL) {
        if (($companyId === 0) || ($text->getCompany() !== 0)) {
            //find out if there is an original text that originated from this one and mark it just as deleted, removing the replacedBy with Null
            $deleted_text = $this->em->getRepository('models\Deleted_customtexts')->findOneBy(array('replacedBy' => $text->getTextId(), 'companyId' => $companyId));
            if ($deleted_text) {
                $deleted_text->setReplacedBy(NULL);
                $this->em->persist($deleted_text);
            }
            //delete the text
            $this->em->remove($text);
        } else {
            $d = new models\Deleted_customtexts();
            $d->setCompanyId($companyId);
            $d->setTextId($text->getTextId());
            $d->setReplacedBy($replacedBy);
            $this->em->persist($d);
        }
        $this->em->flush();
    }

    function editCategory() {
    }

    function deleteCategory() {
    }

    function addText() {
    }

    function addCategory() {
    }
}