<?php

    namespace models;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\Table(name="statuses")
     */
    class Status extends \MY_Model{
        /**
         * @ORM\Id
         * @ORM\Column(type="integer", nullable=false)
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;
        /**
         * @ORM\Column(type="integer")
         */
        private $company;
        /**
         * @ORM\Column(type="string")
         */
        private $text;
        /**
         * @ORM\Column(type="integer", nullable=true)
         */
        private $displayOrder;
        /**
        * @ORM\Column(type="integer")
        */
        private $defaultStatus;
        /**
         * @ORM\Column(type="integer")
         */
        private $visible;
        /**
         * @ORM\Column(type="integer")
         */
        private $sales;
        /**
         * @ORM\Column(type="integer")
         */
        private $prospect = 0;
        /**
         * @ORM\Column(type="integer")
         */
        private $on_hold = 0;
        /**
         * @ORM\Column(type="string")
         */
        private $color;

        // Useful status values
        const OPEN = 1;
        const WON = 2;
        const COMPLETED = 3;
        const LOST = 4;
        const CANCELED = 5;
        const ON_HOLD = 6;
        const INVOICED_QB = 7;
        const DELETE_REQUEST = 15839;
        const AUDIT_READY = 17366;
        const SIGNED = 18995;

        function __construct() {
        }

        public function getStatusId() {
            return $this->id;
        }

        public function setStatusId($statusId){
            $this->id = $statusId;
        }

        public function getCompany() {
            return $this->company;
        }

        public function setCompany($company){
            $this->company = $company;
        }

        public function getText() {
            return $this->text;
        }

        public function setText($text){
            $this->text = $text;
        }

        public function setOrder($order){
            $this->displayOrder = $order;
        }

        public function getOrder(){
            return $this->displayOrder;
        }

        public function setDefaultStatus($defaultStatus){
            $this->defaultStatus = $defaultStatus;
        }

        public function getDefaultStatus(){
            return $this->defaultStatus;
        }

        public function setVisible($visible){
            $this->visible = $visible;
        }

        public function getVisible(){
            return $this->visible;
        }

        /**
         * @return mixed
         */
        public function getSales()
        {
            return $this->sales;
        }

        /**
         * @param mixed $sales
         */
        public function setSales($sales)
        {
            $this->sales = $sales;
        }

        /**
         * @return mixed
         */
        public function getProspect()
        {
            return $this->prospect;
        }

        /**
         * @param mixed $prospect
         */
        public function setProspect($prospect)
        {
            $this->prospect = $prospect;
        }

        /**
         * @return mixed
         */
        public function getOnHold()
        {
            return $this->on_hold;
        }

        /**
         * @param mixed $onHold
         */
        public function setOnHold($onHold)
        {
            $this->on_hold = $onHold;
        }

        /**
         * @return mixed
         */
        public function getColor()
        {
            return $this->color;
        }

        /**
         * @param mixed $color
         */
        public function setColor($color)
        {
            $this->color = $color;
        }


        /**
         * Check if a status is unique for the specified account (defaults to NULL - the default texts)
         *
         * @param $text
         * @param Accounts $account
         * @return bool
         */
        public static function isUnique($text, \models\Accounts $account = null){

            $CI = &get_instance();

            $dql = "SELECT COUNT(s.id) FROM models\Status s
                    WHERE s.text = :statusText";

            if($account){
                $dql.= " AND s.company = " . $account->getCompany()->getCompanyId();
            }
            else {
                $dql.= " AND s.company IS NULL";
            }

            $query = $CI->em->createQuery($dql);
            $query->setParameter('statusText', $text);

            $count = $query->getSingleScalarResult();

            if($count) {
                return false;
            }

            return true;
        }

        /**
         * Returns a collection of the default statuses
         */
        public static function getDefaultStatuses(){
            $CI =& get_instance();

            $q = 'SELECT s FROM models\Status s
                WHERE s.company IS NULL
                AND s.visible = 1
                ORDER BY s.displayOrder ASC';

            $query = $CI->em->createQuery($q);

            return $query->getResult();
        }

        /**
         * @return boolean
         */
        public function isSales()
        {
            return $this->getSales() ? true : false;
        }

        /**
         * @return boolean
         */
        public function isProspect()
        {
            return $this->getProspect() ? true : false;
        }

        /**
         * @return boolean
         */
        public function isOnHold()
        {
            return $this->getOnHold() ? true : false;
        }

    }