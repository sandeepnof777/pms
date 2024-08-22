<?php

class Prospects extends MY_Controller {
    function __construct() {
        $this->login_restricted = true;
        parent::__construct();
    }

    function index() {
        $data = array();
        $data['accounts'] = $this->getCompanyAccounts();
        $data['account'] = $this->account();
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(), \models\ClientEmailTemplateType::PROSPECT, true);
        $this->load->model('branchesapi');
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $data['prospectStatuses'] = $this->prospectStatuses;
        $data['prospectRatings'] = $this->prospectRatings;
        $data['prospectSources'] = $this->getCompanyRepository()->getProspectSources($this->account()->getCompany());
        $data['resends'] = $this->getProspectRepository()->getCompanyProspectResendList($this->account()->getCompany(),$this->account());
        $data['email_template_fields'] = $this->getProspectRepository()->getProspectTemplateFields();
        
        $data['save_filters'] = $this->getProspectRepository()->getProspectSavedFilters($this->account());

        $this->html->addScript('dataTables');
        $this->html->addScript('ckeditor4');
        $this->html->addScript('scheduler');
        $data['resendId'] = $this->uri->segment(3) ?: '';
        $data['campaignEmailFilter'] = $this->uri->segment(4) ?: '';
        $data['filterResend'] = false;
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        $this->html->addScript('select2');
        if($this->uri->segment(2)=='resend'){
            $data['filterResend'] = true;
            
            $data['resend'] = $this->em->find('models\ProspectGroupResend', $data['resendId']);
            $data['resendStats'] = $this->getProspectRepository()->getProspectResendStats($data['resend'],$this->account());
            $data['child_resends'] = $this->getProspectRepository()->getProspectChildResend($data['resendId']);
            //print_r($data['resend']);die;
            $this->load->view('prospects/index-resend', $data);
            
        }else{
            $this->load->view('prospects/index', $data);
        }
        //$this->load->view('prospects/index', $data);
    }

    function group() {
        $this->index();
    }

    function add() {
        $data = array();
        if ($this->input->post('add')) {
            
            $prospect = new models\Prospects();
            $prospect->setFirstName($this->input->post('firstName'));
            $prospect->setLastName($this->input->post('lastName'));
            $prospect->setCompanyName($this->input->post('companyName'));
            $prospect->setTitle($this->input->post('title'));
            $prospect->setAddress($this->input->post('address'));
            $prospect->setCity($this->input->post('city'));
            $prospect->setState($this->input->post('state'));
            $prospect->setZip($this->input->post('zip'));
            $prospect->setCountry($this->input->post('country'));
            $prospect->setBusinessPhone($this->input->post('businessPhone'));
            $prospect->setBusinessPhoneExt($this->input->post('businessPhoneExt'));
            $prospect->setCellPhone($this->input->post('cellPhone'));
            $prospect->setFax($this->input->post('fax'));
            $prospect->setEmail($this->input->post('email'));
            $prospect->setWebsite($this->input->post('website'));
            //$prospect->setBusiness($this->input->post('business'));
            $prospect->setStatus($this->input->post('status'));
            $prospect->setRating($this->input->post('rating'));
            $prospect->setProspectSourceId($this->input->post('source'));
            $prospect->setCompany($this->account()->getCompany()->getCompanyId());
            if ($this->input->post('account')) {
                $prospect->setAccount($this->input->post('account'));
            } else {
                $prospect->setAccount($this->account()->getAccountId());
            }
            $prospect->setLatLng();
            $this->em->persist($prospect);
            $this->em->flush();
            $business_types = $this->input->post('business_type');
            if($business_types){
                foreach($business_types as $business_type){
                    
                    $assignment = new models\BusinessTypeAssignment();
                    $assignment->setBusinessTypeId($business_type);
                    $assignment->setCompanyId($this->account()->getCompany()->getCompanyId());
                    $assignment->setProspectId($prospect->getProspectId());
                    $this->em->persist($assignment);
                }

                $this->em->flush();
            }


            $this->log_manager->add(\models\ActivityAction::ADD_PROSPECT, 'Added Prospect #' . $prospect->getProspectId() . ' - ' . $prospect->getCompanyName() . ' (' . $prospect->getFirstName() . ' ' . $prospect->getLastName() . ')');
            $this->session->set_flashdata('success', 'Prospect Added!');
            redirect('prospects');
        }
        $data['statuses'] = $this->prospectStatuses;
        $data['businesses'] = $this->prospectBusinesses;
        $data['account'] = $this->account();
        $data['ratings'] = $this->prospectRatings;
        $data['accounts'] = $this->getCompanyRepository()->getSalesAccounts($this->account()->getCompanyId(), null, true);
        $data['sources'] = $this->getCompanyRepository()->getProspectSources($this->account()->getCompany(), true);
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        $this->html->addScript('select2');
        $this->load->view('prospects/add', $data);
    }

    function edit($id) {
        $data = array();
        $prospect = $this->em->findProspect($id);
        if ($prospect) {
            $oldAddressString = $prospect->getAddressString();
            $data['prospect'] = $prospect;
            if ($this->input->post('save')) {
                $this->getCompanyRepository()->clearProspectAssignedBusinessTypes($this->account()->getCompany(),$prospect->getProspectId());
                $prospect->setFirstName($this->input->post('firstName'));
                $prospect->setLastName($this->input->post('lastName'));
                $prospect->setCompanyName($this->input->post('companyName'));
                $prospect->setTitle($this->input->post('title'));
                $prospect->setAddress($this->input->post('address'));
                $prospect->setCity($this->input->post('city'));
                $prospect->setState($this->input->post('state'));
                $prospect->setZip($this->input->post('zip'));
                $prospect->setCountry($this->input->post('country'));
                $prospect->setBusinessPhone($this->input->post('businessPhone'));
                $prospect->setBusinessPhoneExt($this->input->post('businessPhoneExt'));
                $prospect->setCellPhone($this->input->post('cellPhone'));
                $prospect->setFax($this->input->post('fax'));
                $prospect->setEmail($this->input->post('email'));
                $prospect->setWebsite($this->input->post('website'));
                $prospect->setStatus($this->input->post('status'));
                $prospect->setRating($this->input->post('rating'));
                $prospect->setBusiness($this->input->post('business'));
                if ($this->input->post('account')) {
                    $prospect->setAccount($this->input->post('account'));
                }
                // Geocode
                $prospect->setLatLng();
                $prospect->setProspectSourceId($this->input->post('source'));
                $this->em->persist($prospect);
                $this->em->flush();
                $business_types = $this->input->post('business_type');
                if($business_types){
                    foreach($business_types as $business_type){
                        
                        $assignment = new models\BusinessTypeAssignment();
                        $assignment->setBusinessTypeId($business_type);
                        $assignment->setCompanyId($this->account()->getCompany()->getCompanyId());
                        $assignment->setProspectId($prospect->getProspectId());
                        $this->em->persist($assignment);
                    }

                 $this->em->flush();
                }
                $this->log_manager->add(\models\ActivityAction::EDIT_PROSPECT, 'Edited Prospect #' . $prospect->getProspectId() . ' - ' . $prospect->getCompanyName() . ' (' . $prospect->getFirstName() . ' ' . $prospect->getLastName() . ')');
                $this->session->set_flashdata('success', 'Prospect Edited!');
                redirect('prospects');
            }
            $data['statuses'] = $this->prospectStatuses;
            $data['businesses'] = $this->prospectBusinesses;
            $data['account'] = $this->account();
            $data['ratings'] = $this->prospectRatings;
            $data['events'] = $this->getEventRepository()->getSpecificEvents('prospect', $prospect->getProspectId());
            $data['assignedBusinessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypeAssignments($this->account()->getCompany(),'prospect',$prospect->getProspectId(),true);
            //print_r($data['assignedBusinessTypes']);die;
            $data['sources'] = $this->getCompanyRepository()->getProspectSources($this->account()->getCompany(), true);
            $data['accounts'] = $this->getCompanyRepository()->getSalesAccounts($this->account()->getCompanyId(), null, true);
            $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
            $this->html->addScript('dataTables');
            $this->html->addScript('scheduler');
            $this->html->addScript('select2');
            $this->load->view('prospects/edit', $data);
        } else {
            $this->session->set_flashdata('error', 'Prospect not found!');
            redirect('prospects');
        }
    }

    function delete() {
        $this->load->database();
        $prospect = $this->em->find('models\Prospects', $this->uri->segment(3));
        if ($prospect) {
            $prospect->deleteProspectGroupResendEmails();

            $this->getCompanyRepository()->clearProspectAssignedBusinessTypes($this->account()->getCompany(),$prospect->getProspectId());
            $this->log_manager->add(\models\ActivityAction::DELETE_PROSPECT, 'Deleted Prospect #' . $prospect->getProspectId() . ' - ' . $prospect->getCompanyName() . ' (' . $prospect->getFirstName() . ' ' . $prospect->getLastName() . ')');
            $this->em->remove($prospect);
            $this->em->flush();
            
            $this->session->set_flashdata('success', 'Prospect Deleted!');
        } else {
            $this->session->set_flashdata('error', 'Prospect not found!');
        }
        redirect('prospects');
    }

    function map() {
        $group = false;
        $prospects = [];

        if ($this->input->post('prospects')) {
            $group = true;
            foreach ($this->input->post('prospects')as $prospectId) {
                $prospects[] = $this->em->find('models\Prospects', $prospectId);
            }
        }
        else {
            $prospects = $this->account()->getMapProspects();
        }

        $prospectInfo = [];
        $prospectInfoNoAddress =[];

        foreach ($prospects as $prospect) {
            /* @var $prospect \models\Prospects */

            if ($prospect->isMapped()) {

                $prospectInfoObj = new stdClass();
                $prospectInfoObj->id = $prospect->getProspectId();
                $prospectInfoObj->name = $prospect->getFullName();
                $prospectInfoObj->address = $prospect->getAddress();
                $prospectInfoObj->city = $prospect->getCity();
                $prospectInfoObj->state = $prospect->getState();
                $prospectInfoObj->zip = $prospect->getZip();
                $prospectInfoObj->companyName = $prospect->getCompanyName();
                $prospectInfoObj->email = $prospect->getEmail();
                $prospectInfoObj->cellPhone = $prospect->getCellPhone();
                $prospectInfoObj->geocodeString = $prospectInfoObj->address . ' ' . $prospectInfoObj->zip;
                $prospectInfoObj->type = $prospect->getRating();
                $prospectInfoObj->readableDiff = date('m/d/Y g:i a', $prospect->getCreated(true));
                $prospectInfoObj->lat = $prospect->getLat();
                $prospectInfoObj->lng = $prospect->getLng();
                $prospectInfo[] = $prospectInfoObj;
            }
            else {
                $prospectInfoNoAddress[] = $prospect;
            }
        }

        $data = [];
        $data['prospects'] = $prospects;
        $data['account'] = $this->account();
        $data['group'] = $group;
        $this->html->addScript('dataTables');
        $this->load->view('prospects/map', $data);
    }

    public function table()
    {

        $prospects = $this->account()->getProspectsNew();
        $accounts = $this->getCompanyAccounts();

        $prospectsData = [];

        foreach ($prospects as $prospect) {


            $business_type = '<div style="text-align:center"><a href="javascript:void(0);" class="tiptip manage_business_type" title="Add Business Type"  rel="'.$prospect->prospectId.'"  style="font-size: 14px;color:#a5a2a2;"><i class="fa fa-fw fa-plus"  ></i></a></div>';
            if($prospect->types){
                $types = explode(',',$prospect->types);
                if(count($types)>1){
                    $business_type_tooltip = '';
                    foreach($types as $type){
                    
                        $business_type_tooltip .= $type.'<br/>';
                    }
                    
                    $business_type = '<div><span  class="tiptip manage_business_type" title="Update Business Type"  rel="'.$prospect->prospectId.'"  style="color:#25AAE1;">'.$types[0].'</span> <a class="tiptip" style="cursor:pointer" title="'.$business_type_tooltip.'"> +'. (count($types)-1) . '</a></div>';
                }else if(count($types)==1){
                    $business_type = '<div><span  class="tiptip manage_business_type" title="Update Business Type"  rel="'.$prospect->prospectId.'"  style="color:#25AAE1;">'.$types[0].'</span></div>';
                }
        }
            $prospect_status = $prospect->status.'<span style="width: 40px;display: flex;float: right; justify-content: flex-end;"> ';
            $displayAddNote = ($prospect->ncount) ? false : true;
            $prospect_status .= ' <a href="javascript:void(0);"  class="notes prospect_table_notes_tiptip hasNotes" rel="'.$prospect->prospectId.'"  data-val="'.$prospect->prospectId.'"  style="font-size: 14px;color:#a5a2a2; display:' . (($displayAddNote) ? 'none' : 'block') . '"><i class="fa fa-fw fa-sticky-note-o "  ></i></a>';
            $prospect_status .= '<a href="javascript:void(0);"class="notes tiptip hasNoNotes" title="Add Prospect Notes"  rel="'.$prospect->prospectId.'"  style="font-size: 14px;color:#a5a2a2;float:right; display:' . (($displayAddNote) ? 'block' : 'none') . '"><i class="fa fa-fw fa-plus"  ></i></a>';
            $prospect_status .= '</span>';

            $prospectsData[] = array(
                $this->load->view('templates/prospects/table/check', ['prospect' => $prospect], true),
                $this->load->view('templates/prospects/table/actions', ['prospect' => $prospect], true),
                $prospect->created,
                date('m/d/Y', $prospect->created + TIMEZONE_OFFSET),
                $prospect_status,
                $prospect->rating,
                $prospect->rating,
                $business_type,
                $prospect->companyName,
                $prospect->firstName . ' ' . $prospect->lastName,
                $this->load->view('templates/prospects/table/contact', ['prospect' => $prospect], true),
                $prospect->title,
                $this->load->view('templates/prospects/table/owner-text', ['prospect' => $prospect, 'accounts' => $accounts], true),
                $this->load->view('templates/prospects/table/owner', ['prospect' => $prospect, 'accounts' => $accounts], true),
            );
        }
        $data = [];
        $data['aaData'] = $prospectsData;
        $data['sEcho'] = $this->input->get('sEcho');
        $data["iTotalRecords"] = $this->account()->getProspectsNew(true);
        $data["iTotalDisplayRecords"] = $this->account()->getProspectsNew(true);
        echo json_encode($data);
    }

    public function table_resend()
    {
        //print_r($prospects);die;
        $action = $this->input->get('action') ?: null;
        $type = $this->input->get('type') ?: null;
        $resend_id = $this->input->get('resend_id') ?: null;
        
        $prospects = $this->account()->getProspectsNew(false,$action,$type,$resend_id);
        //$prospects = $this->account()->getProspects();
        //print_r($prospects);die;
        $accounts = $this->getCompanyAccounts();

        $prospectsData = [];

        // foreach ($prospects as $prospect) {
        //     //echo $prospect[0]->getProspectId();die;
        //     $prospectsData[] = array(
        //         $this->load->view('templates/prospects/table/check', ['prospect' => $prospect], true),
        //         $this->load->view('templates/prospects/table/actions', ['prospect' => $prospect], true),
        //         $prospect->getCreated(),
        //         date('m/d/Y', $prospect->getCreated(true) + TIMEZONE_OFFSET),
        //         $prospect->getCompanyName(),
        //         $prospect->getFirstName() . ' ' . $prospect->getLastName(),
        //         $this->load->view('templates/prospects/table/contact', ['prospect' => $prospect], true),
        //         $prospect->getBusiness(),
        //         $prospect->getRating(true),
        //         $prospect->getRating(),
        //         $prospect->getStatus(),
        //         $this->load->view('templates/prospects/table/owner-text', ['prospect' => $prospect, 'accounts' => $accounts], true),
        //         $this->load->view('templates/prospects/table/owner', ['prospect' => $prospect, 'accounts' => $accounts], true),
        //     );
        // }

        foreach ($prospects as $prospect) {

           // $types = $this->getProspectRepository()->getProspectBusinessTypes($prospect->prospectId);
            //$notes_count = $this->getProspectRepository()->getProspectNotesCount($prospect->prospectId);
            $types = $prospect->types;
            $business_type = '<div style="text-align:center"><a href="javascript:void(0);" class="tiptip manage_business_type" title="Add Business Type"  rel="'.$prospect->prospectId.'"  style="font-size: 14px;color:#a5a2a2;"><i class="fa fa-fw fa-plus"  ></i></a></div>';
            
            if($prospect->types){
                $types = explode(',',$prospect->types);
                if(count($types)>1){
                    $business_type_tooltip = '';
                    foreach($types as $type){
                    
                        $business_type_tooltip .= $type.'<br/>';
                    }
                    
                    $business_type = '<div><span  class="tiptip manage_business_type" title="Update Business Type"  rel="'.$prospect->prospectId.'"  style="color:#25AAE1;">'.$types[0].'</span> <a class="tiptip" style="cursor:pointer" title="'.$business_type_tooltip.'"> +'. (count($types)-1) . '</a></div>';
                }else if(count($types)==1){
                    $business_type = '<div><span  class="tiptip manage_business_type" title="Update Business Type"  rel="'.$prospect->prospectId.'"  style="color:#25AAE1;">'.$types[0].'</span></div>';
                }
        }
            $prospect_status = $prospect->status.'<span style="width: 40px;display: flex;float: right; justify-content: flex-end;"> ';
            $displayAddNote = ($prospect->ncount) ? false : true;
            $prospect_status .= ' <a href="javascript:void(0);"  class="notes prospect_table_notes_tiptip hasNotes" rel="'.$prospect->prospectId.'"  data-val="'.$prospect->prospectId.'"  style="font-size: 14px;color:#a5a2a2; display:' . (($displayAddNote) ? 'none' : 'block') . '"><i class="fa fa-fw fa-sticky-note-o "  ></i></a>';
            $prospect_status .= '<a href="javascript:void(0);"class="notes tiptip hasNoNotes" title="Add Prospect Notes"  rel="'.$prospect->prospectId.'"  style="font-size: 14px;color:#a5a2a2;float:right; display:' . (($displayAddNote) ? 'block' : 'none') . '"><i class="fa fa-fw fa-plus"  ></i></a>';
            $prospect_status .= '</span>';

            $prospectsData[] = array(
                $this->load->view('templates/prospects/table/check', ['prospect' => $prospect], true),
                $this->load->view('templates/prospects/table/actions', ['prospect' => $prospect], true),
                $prospect->created,
                date('m/d/Y', $prospect->created + TIMEZONE_OFFSET),
                $prospect_status,
                $prospect->rating,
                $prospect->rating,
                $business_type,
                $prospect->companyName,
                $prospect->firstName . ' ' . $prospect->lastName,
                $this->load->view('templates/prospects/table/contact', ['prospect' => $prospect], true),
                $this->load->view('templates/prospects/table/owner-text', ['prospect' => $prospect, 'accounts' => $accounts], true),
                $this->load->view('templates/prospects/table/owner', ['prospect' => $prospect, 'accounts' => $accounts], true),
            );
        }
        $data = [];
        $data['aaData'] = $prospectsData;
        $data['sEcho'] = $this->input->get('sEcho');
        $data["iTotalRecords"] = $this->account()->getProspectsNew(true,$action,$type,$resend_id);
        $data["iTotalDisplayRecords"] = $this->account()->getProspectsNew(true,$action,$type,$resend_id);
        echo json_encode($data);
    }

    public function group_resends()
    {   $data = [];
        $this->html->addScript('ckeditor4');
        $data['resends'] = $this->getProspectRepository()->getCompanyProspectResendList($this->account()->getCompany(),$this->account());
        
        
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(), \models\ClientEmailTemplateType::CLIENT, true);
        $data['account'] = $this->account();
        $data['layout'] = 'prospects/group_resends';
        $this->html->addScript('dataTables');
        $this->load->view('prospects/group_resends', $data);
    }

    public function group_resends_data()
    {
        $company = $this->account()->getCompany();

        $tableData = [];
        $rowsData = [];
       // $itemsData = [];
        $itemsData = $this->getProspectRepository()->getGroupResendData($company,false,$this->account());
        
        foreach ($itemsData as $dataRow) {
            $rowsData[] = $dataRow;
        }

        $tableData['sEcho'] = (int)$this->input->post('echo');
        $tableData['iTotalRecords'] = $this->getProspectRepository()->getGroupResendData($company, true,$this->account());
        $tableData['iTotalDisplayRecords'] = $this->getProspectRepository()->getGroupResendData($company, true,$this->account());
        $tableData['aaData'] = $rowsData;

        echo json_encode($tableData);
    }

    function resend()
    {
        // Auth checks
       
         $filter = $this->uri->segment(3);
        

        $this->session->set_userdata('pProspectResendFilter', 1);


        $this->session->set_userdata('pProspectResendFilterId', $filter);
    
       
        $this->index();
    }

    function groupExport()
    {
        $leadIds = $this->input->post('groupExportProspectIds');
       
         $fileName = str_replace(('/[^a-zA-Z0-9_-\s]/g'),'',$this->input->post('fileName'));

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
        return $this->getProspectRepository()->groupProspectExportCSV($this->account(), $leadIds);
    }
}
