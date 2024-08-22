<?php
class Calculator extends MY_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getValue($serviceId, $fieldName) {
        $value = $this->db->query("select fieldValue from service_calculator where serviceId={$serviceId} and fieldName='{$fieldName}'");
        if ($value->num_rows()) {
            return $value->row()->fieldValue;
        } else {
            return false;
        }
    }

    function getLastValue($initialService, $company, $fieldName) {
        $value = $this->db->query("select fieldValue from service_calculator where initialService={$initialService} and company={$company} and fieldName='{$fieldName}' order by id desc limit 1;");
        if ($value->num_rows()) {
            return $value->row()->fieldValue;
        } else {
            return false;
        }
    }

    function setValue($serviceId, $initialService, $company, $fieldName, $fieldValue) {
        $this->db->query("delete from service_calculator where serviceId={$serviceId} and fieldName='{$fieldName}'");
        $this->db->query("insert into service_calculator values(NULL, {$company}, {$serviceId},{$initialService},'{$fieldName}','{$fieldValue}')");
    }
}