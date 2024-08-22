<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="zoho_subscriptions")
 */
class ZohoSubscription {

    /**
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false)
     */
    private $zs_id;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $company_id;
    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('recurring', 'fixed')")
     */
    private $type = 'recurring';
    /**
     * @ORM\Column(type="date")
     */
    private $start;
    /**
     * @ORM\Column(type="date")
     */
    private $expiry;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $plu;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $wio;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $sec;
    /**
     * @ORM\Column(type="string")
     */
    private $ref;
    /**
     * @ORM\Column(type="string")
     */
    private $notes;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $user_rate;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $plan_code;


    /**
     * @return mixed
     */
    public function getZsId()
    {
        return $this->zs_id;
    }

    /**
     * @param mixed $zs_id
     */
    public function setZsId($zs_id)
    {
        $this->zs_id = $zs_id;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }


    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getExpiry()
    {
        return $this->expiry;
    }

    /**
     * @param mixed $expiry
     */
    public function setExpiry($expiry)
    {
        $this->expiry = $expiry;
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

    /**
     * @return mixed
     */
    public function getPlu()
    {
        return $this->plu;
    }

    /**
     * @param mixed $plu
     */
    public function setPlu($plu)
    {
        $this->plu = $plu;
    }

    /**
     * @return mixed
     */
    public function getWio()
    {
        return $this->wio;
    }

    /**
     * @param mixed $wio
     */
    public function setWio($wio)
    {
        $this->wio = $wio;
    }

    /**
     * @return mixed
     */
    public function getSec()
    {
        return $this->sec;
    }

    /**
     * @param mixed $sec
     */
    public function setSec($sec)
    {
        $this->sec = $sec;
    }

    /**
     * @return mixed
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param mixed $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return mixed
     */
    public function getUserRate()
    {
        return $this->user_rate;
    }

    /**
     * @param mixed $user_rate
     */
    public function setUserRate($user_rate)
    {
        $this->user_rate = $user_rate;
    }

    /**
     * @return mixed
     */
    public function getPlanCode()
    {
        return $this->plan_code;
    }

    /**
     * @param mixed $plan_code
     */
    public function setPlanCode($plan_code)
    {
        $this->plan_code = $plan_code;
    }

    /**
     * @return array
     */
    public function buildSubscriptionData()
    {
        $plan = new \stdClass();
        $plan->plan_code = 'PL';
        $plan->name = SITE_NAME.' Activation';
        $plan->price = 0;
        $plan->quantity = 1;

        $addons = [];

        if ($this->getPlu()) {
            $addon = new \stdClass();
            $addon->addon_code = $this->getPlanCode();
            $addon->quantity = $this->getPlu();
            $addons[] = $addon;
        }

        if ($this->getWio()) {
            $addon = new \stdClass();
            $addon->addon_code = 'WIO';
            $addon->quantity = $this->getWio();
            $addons[] = $addon;
        }

        if ($this->getSec()) {
            $addon = new \stdClass();
            $addon->addon_code = 'SEC';
            $addon->quantity = $this->getSec();
            $addons[] = $addon;
        }

        $subData = [
            'plan' => $plan,
            'auto_collect' => false,
            'addons' => $addons
        ];

        return $subData;
    }

}