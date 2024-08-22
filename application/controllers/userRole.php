<?php
use Carbon\Carbon;
use Doctrine\ORM\Tools\SchemaValidator;
use Intervention\Image\ImageManager;
use League\Csv\Reader;
use League\Csv\Writer;
use models\EstimationCategory;
use models\EstimationItem;
use models\EstimationType;
use models\EstimationPlant;
use models\EstimationDump;
use models\EstimationCrew;
use Ipdata\ApiClient\Ipdata;


class UserRole extends MY_Controller
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var CI_Form_validation
     */
    var $form_validation;
    /**
     * @var CI_Session
     */
    var $session;
    /**
     * @var CI_Input
     */
    var $input;
    /**
     * @var Log_manager
     */
    var $log_manager;
    /**
     * @var Customtexts
     */
    var $customtexts;
    /**
     * @var Html
     */
    var $html;
    /**
     * @var AccountSettings
     */
    var $accountSettings;
    /**
     * @var Calculator
     */
    var $calculator;
    /**
     * @var System_email
     */
    var $system_email;
    /**
     * @var ClientEmail
     */
    var $clientEmail;
    /**
     * @var branchesapi
     */
    var $branchesapi;

    /**
     * @var ServiceFieldHelper
     */
    var $servicefieldhelper;

    /**
     * @var ServiceTextHelper
     */
    var $servicetexthelper;

    /** @var ServiceHelper */
    var $servicehelper;

    /**
     * @var CustomtextRepository
     */
    var $customtextrepository;

   
    

    function index()
    {


        // $testAcc = $this->em->getRepository('models\UserRole')->findAll();
        // foreach($testAcc as $testAc){
        //     print_r($testAc->getRoleName());
            
        //     echo '<br>';
        // }
        // echo '<pre>';
        //     print_r($testAcc);die;

         if($this->account()->getIsSuperUser() && $this->account()->getParentCompanyId()==0){
            redirect('dashboard/super_user');
         }else{
            redirect('dashboard'); //new world order caused this. nothing to see here anymore.
        }
        
    }

 
  
 

function user_role()
{
    // Assuming you have a repository for the Role entity
    $testAcc = $this->em->getRepository('models\UserRole')->findAll();
    //$userRoleArr = array();
   
    foreach($testAcc as $testAc){
       // print_r($testAc->getRoleName());
       $userRoleArr[] = array(
        'id' => $testAc->getId(),
        'name' => $testAc->getRoleName()
    );

     }
    $data['role']= $userRoleArr;
    $this->load->view('role/user_role',$data);

}

function saveRoleName(){
 
   $roleId = $this->input->post('roleId');
   $roleName = $this->input->post('roleName');
    if($roleId!="")
    {
            $rolesave = $this->em->find('models\UserRole', $roleId);
            $rolesave->setRoleName($roleName);
            $this->em->persist($rolesave);
            $this->em->flush();
    }

    $this->session->set_flashdata('success', 'Role Saved');
    redirect('userrole/user_role');
 
}

function edit_role_permission(){
    echo "work in progress";die;
}




    
    
        
  
 
}
