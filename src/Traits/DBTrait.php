<?php
namespace Pms\Traits;

/**
 * Database Trait to be used in conjunction with Repositories or other classes who initialize the $db class.
 * Class DBTrait
 * @package Pms\Traits
 * @requires CITrait
 */
trait DBTrait
{
    /**
     * @var \CI_Controller
     */
    protected $ci;

    /**
     * @var \CI_DB_active_record
     */
    protected $db;

    /**
     * Returns result of the quried SQL
     * @param $sql
     * @return mixed
     */
    public function query($sql)
    {
        return $this->db->query($sql);
    }

    /**
     * Returns scalar query result
     * @param $sql
     * @param string $scalar
     * @return mixed value of the scalar value, null on failure
     */
    public function scalar($sql, $scalar)
    {
        $query = $this->query($sql);
        if ($query->num_rows()) {
            return $query->row()->$scalar;
        }
        return NULL;
    }

    /**
     * Returns single result
     * @param $sql
     * @param string $type object | array
     * @return mixed, FALSE on fail
     */
    public function getSingleResult($sql, $type = 'object')
    {
        $query = $this->query($sql);
        if ($query->num_rows()) {
            if ($type == 'array') {
                return $query->row_array();
            }
            return $query->row();
        }
        return false; //no result found
    }

    /**
     * Returns all results of a query in the given format
     * @param $sql
     * @param string $type 'object' | 'array'
     * @return array of objects or arrays
     */
    public function getAllResults($sql, $type = 'object')
    {
        $query = $this->query($sql);
        if ($query->num_rows()) {
            if ($type == 'array') {
                return $query->result_array();
            }
            return $query->result();
        }
        return []; //no results
    }

    /**
     * @param $dql
     * @return mixed
     */
    public function getDqlResults($dql)
    {
        $query = $this->em->createQuery($dql);
        return $query->getResult();
    }

    /**
     * Returns all results of a query in given format, with indexes from the $index column parameter
     * @param string $type 'object' | 'array'
     * @return array of objects or arrays
     * @param $index - column index to be used, usually 'id'
     */
    public function getAllResultsIndexed($sql, $index, $type = 'object')
    {
        $unindexed_results = $this->getAllResults($sql, $type);
        $results = [];
        foreach ($unindexed_results as $result) {
            if ($type == 'array') {
                $results[$result[$index]] = $result;
            }
            $results[$result->$index] = $result;
        }
        return $results;
    }

    /**
     * Inserts data array in the table name provided
     * @param $tableName
     * @param array $data
     */
    public function insert($tableName, array $data)
    {
        $this->db->insert($tableName, $data);
        return $this->db->insert_id();
    }

    /**
     * Updates data in the table name provided by the id and id column
     * @param $tableName
     * @param $idColumn
     * @param $id
     * @param array $data
     */
    public function update($tableName, $idColumn, $id, array $data)
    {
        $this->db->update($tableName, $data, array($idColumn => $id));
    }

}