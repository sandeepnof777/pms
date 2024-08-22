<?php

/**
 * Encapsulates business logic for custom texts
 * Ideally at some point we should move everything here related to custom texts...
 * Class CustomtextRepository
 */
class CustomtextRepository extends PmsRepository
{

    /**
     * Returns the formated string to be saved into the database with the category id's for the selected custom text categories
     * @param $companyId
     * @return string
     */
    public function getDefaultCategories($companyId)
    {
        $categories = [];
        $query = $this->db->query("SELECT (concat(cc.categoryId, ':', (select count(id) as enabled from customtext_default_categories where categoryId = cc.categoryId and company = $companyId))) as val
                FROM customtext_categories cc WHERE cc.company = 0 OR cc.company = {$companyId}");
        foreach ($query->result() as $row) {
            $categories[] = $row->val;
        }
        return implode('|', $categories);
    }


}