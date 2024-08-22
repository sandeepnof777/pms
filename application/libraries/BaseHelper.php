<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 2/20/2015
 * Time: 4:15 PM
 */

class BaseHelper extends MY_Model{

    /* @var \models\Accounts */
    private $account;

    /* @var Log_manager */
    protected $logManager;

    /* @var String */
    protected $redirect;

    /* @var String */
    protected $redirectBase;

    /* @var String */
    protected $alertClass;

    /* @var String */
    protected $alertMessage;

    /* @var \Doctrine\ORM\EntityManager */
    public $em;

    public function __construct(array $params = [])
    {
        parent::__construct();

        if (isset($params['account'])){
            $this->setAccount($params['account']);
        }

        $this->logManager = new Log_manager();
    }

    /**
     * @return \models\Accounts
     */
    protected function getAccount()
    {
        return $this->account;
    }

    /**
     * @param \models\Accounts $account
     */
    protected function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return mixed
     */
    public function getAlertClass()
    {
        return $this->alertClass;
    }

    /**
     * @param mixed $alertClass
     */
    public function setAlertClass($alertClass)
    {
        $this->alertClass = $alertClass;
    }

    /**
     * @return mixed
     */
    public function getAlertMessage()
    {
        return $this->alertMessage;
    }

    /**
     * @param mixed $alertMessage
     */
    public function setAlertMessage($alertMessage)
    {
        $this->alertMessage = $alertMessage;
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param mixed $redirect
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @return String
     */
    public function getRedirectBase()
    {
        return $this->redirectBase;
    }

    /**
     * @param String $redirectBase
     */
    public function setRedirectBase($redirectBase)
    {
        $this->redirectBase = $redirectBase;
    }

}