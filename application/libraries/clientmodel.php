<?php
/**
 * Created by JetBrains PhpStorm.
 * User: AL2
 * Date: 11/26/13
 * Time: 5:36 PM
 * To change this template use File | Settings | File Templates.
 */

class ClientModel {

    /**
     * @param $companyId
     * @param $qbId
     * @return \models\Clients
     */
    public static function loadByCompanyQb($companyId, $qbId){

        // Need an instance
        $CI =& get_instance();

        // Create the query
        $query = $CI->em->createQuery("SELECT c
                                        FROM \models\Clients c
                                        WHERE c.company = :companyId
                                        AND c.quickbooksId = :qbid")
            ->setParameter('companyId', $companyId)
            ->setParameter('qbid', $qbId)
            ->setMaxResults(1);

        try {

            // There can only be one
            $result = $query->getSingleResult();
        }
        catch (\Doctrine\ORM\NoResultException $e){  // Or none, in which case this exception is thrown
            return false;
        }
        // We are return the object searched for, or a blank object.
        return $result;
    }

    public static function findMatch($companyId, \QuickBooks_IPP_Object_Customer $customer){

        $CI =& get_instance();

        // Doesn't like me adding a parameter the usual way, so I've gone old school
        $lastName = $CI->db->escape($customer->getFamilyName());

        $query = $CI->em->createQuery("SELECT c
                    FROM \models\Clients c
                    WHERE c.lastName LIKE '" . $lastName . "'
                    AND c.company = :companyId")
            ->setParameter('companyId', $companyId);

        $results = $query->getResult();
        $out = array();

        if($results){
            foreach ($results as $result){
                $out[] = $result;
            }
        }

        return $out;

    }

    public static function findMatches(\QuickBooks_IPP_Object_Customer $customer, $clients){

        $out = array();

        // Construct the QB customer string
        $qbString = $customer->getGivenName() . ' ' . $customer->getFamilyName() . ' ' . $customer->getCompanyName();

        if(count($clients)){
            foreach($clients as $client){
                /* @var $client \models\Clients */

                if(!$client->getQuickbooksId()){

                    $clientString = $client->getFullName() . ' ' . $client->getCompanyName();

                    similar_text($qbString, $clientString, $pct);

                    if($pct > 50){
                        $out[] = $client;
                    }
                }
            }
        }

        return $out;
    }

}