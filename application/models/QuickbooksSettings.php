<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="quickbook_settings")
 */
class QuickbooksSettings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $company_id;
    /**
     * @ORM\Column(type="string")
     */
    private $access_token;
    /**
     * @ORM\Column(type="string")
     */
    private $refresh_token;
    /**
     * @ORM\Column(type="string")
     */
    private $error_message;
    /**
     * @ORM\Column(type="string")
     */
    private $realm_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $income_account_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $expense_account_id;
    /**
     * @ORM\Column(type="string")
     */
    private $qb_connection_type;
    /**
     * @ORM\Column(type="string")
     */
    private $qbd_income_account_name;
    /**
     * @ORM\Column(type="string")
     */
    private $qbd_expense_account_name;
    /**
     * @ORM\Column(type="string")
     */
    private $username;
    /**
     * @ORM\Column(type="integer")
     */
    private $updated_at;

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
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->company_id = $companyId;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param mixed $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * @param mixed $refresh_token
     */
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $refresh_token;
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->error_message;
    }

    /**
     * @param mixed $error_message
     */
    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    /**
     * @return mixed
     */
    public function getRealmId()
    {
        return $this->realm_id;
    }

    /**
     * @param mixed $realmId
     */
    public function setRealmId($realmId)
    {
        $this->realm_id = $realmId;
    }

    /**
     * @return mixed
     */
    public function getIncomeAccountId()
    {
        return $this->income_account_id;
    }

    /**
     * @param mixed $income_account_id
     */
    public function setIncomeAccountId($income_account_id)
    {
        $this->income_account_id = $income_account_id;
    }

    /**
     * @return mixed
     */
    public function getExpenseAccountId()
    {
        return $this->expense_account_id;
    }

    /**
     * @param mixed $expense_account_id
     */
    public function setExpenseAccountId($expense_account_id)
    {
        $this->expense_account_id = $expense_account_id;
    }

    /**
     * @return mixed
     */
    public function getQbConnectionType()
    {
        if ($this->qb_connection_type == 'desktop') {
            return 'desktop';
        }

        return 'online';
    }

    /**
     * @param mixed $qb_connection_type
     */
    public function setQbConnectionType($qb_connection_type)
    {
        $this->qb_connection_type = $qb_connection_type;
    }

    /**
     * @return mixed
     */
    public function getQbdIncomeAccountName()
    {
        return $this->qbd_income_account_name;
    }

    /**
     * @param mixed $qbd_income_account_name
     */
    public function setQbdIncomeAccountName($qbd_income_account_name)
    {
        $this->qbd_income_account_name = $qbd_income_account_name;
    }

    /**
     * @return mixed
     */
    public function getQbdExpenseAccountName()
    {
        return $this->qbd_expense_account_name;
    }

    /**
     * @param mixed $qbd_expense_account_name
     */
    public function setQbdExpenseAccountName($qbd_expense_account_name)
    {
        $this->qbd_expense_account_name = $qbd_expense_account_name;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    

}