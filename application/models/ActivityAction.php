<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="activity_action")
 */
class ActivityAction extends \MY_Model
{
    const USER_ACTIONS = 1;
    const COMPANY_ACTIONS = 2;
    const PROSPECT_ACTIONS = 3;
    const LEAD_ACTIONS = 4;
    const CONTACT_ACTIONS = 5;
    const PROPOSAL_ACTIONS = 6;

    //USER
    const LOGIN = 11;
    const LOGOUT = 12;
    const CHANGE_PASSWORD = 13;
    const RESET_PASSWORD = 14;
    const RECOVER_PASSWORD = 15;

    //COMPANY
    const ADD_COMPANY = 16;
    const UPDATE_COMPANY = 17;
    const DELETE_COMPANY = 18;
    const COMPANY_ADD_WORK_ORDER_ADDRESS = 108;
    const COMPANY_EDIT_WORK_ORDER_ADDRESS = 109;
    const COMPANY_DELETE_WORK_ORDER_ADDRESS = 110;
    const COMPANY_UPDATE_BID_APPROVAL = 111;
    const COMPANY_ADD_SERVICE_TEXT = 112;
    const COMPANY_EDIT_SERVICE_TEXT = 113;
    const COMPANY_DELETE_SERVICE_TEXT = 114;
    const COMPANY_RESTORE_SERVICE_TEXT = 115;
    const COMPANY_SETTING = 116;
    const COMPANY_PROPOSAL_ASSEMBLY_ADD = 117;
    const COMPANY_PROPOSAL_ASSEMBLY_EDIT = 118;
    const COMPANY_PROPOSAL_ASSEMBLY_DELETE = 119;
    const COMPANY_PROPOSAL_ASSEMBLY_DUPLICATE = 120;
    const COMPANY_PROPOSAL_ASSEMBLY_GROUP_DELETE = 121;

    const COMPANY_ADD_COVER_IMAGE_PROPOSAL_VIDEO = 122;
    const COMPANY_DELETE_COVER_IMAGE_PROPOSAL_VIDEO = 123;
    const COMPANY_PROPOSAL_VIDEO_ADD = 124;
    const COMPANY_PROPOSAL_VIDEO_EDIT = 125;
    const COMPANY_PROPOSAL_VIDEO_DELETE = 126;
    const COMPANY_PROPOSAL_VIDEO_GROUP_DELETE = 127;

    const COMPANY_ITEM_GROUP_DELETE = 128;

    const COMPANY_PLANT_GROUP_DELETE = 129;
    const COMPANY_CREW_GROUP_DELETE = 130;

    const COMPANY_ESTIMATE_ACTIVATE = 131;
    const COMPANY_ESTIMATE_INACTIVATE = 132;

    const COMPANY_EXPORT_DELETED = 133;
    const COMPANY_EXPORT_EDITED = 134;

    const COMPANY_ADD_PROSPECT_SOURCE = 135;
    const COMPANY_ADD_PROSPECT_RATING = 136;
    const COMPANY_ADD_PROSPECT_STATUS = 215;


    const COMPANY_ADD_LEAD_SOURCE = 137;

    const CLIENT_EMAIL_TEMPLATE_ADD = 138;
    const CLIENT_EMAIL_TEMPLATE_EDIT = 139;
    const CLIENT_EMAIL_TEMPLATE_DELETE = 140;
    const CLIENT_EMAIL_TEMPLATE_DISABLE = 141;
    const CLIENT_EMAIL_TEMPLATE_ENABLE = 142;

    const COMPANY_ADD_USER = 192;
    const COMPANY_EDIT_USER = 193;
    const COMPANY_DELETE_USER = 194;

    const COMPANY_ADD_BRANCH = 195;
    const COMPANY_EDIT_BRANCH = 196;
    const COMPANY_DELETE_BRANCH = 197;

    const UPDATE_COMPANY_LOGO = 198;

    const COMPANY_ADD_BUSINESS_TYPE = 201;
    const COMPANY_EDIT_BUSINESS_TYPE = 202;
    const COMPANY_DELETE_BUSINESS_TYPE = 203;

    const COMPANY_ADD_ATTACHMENT = 204;
    const COMPANY_DELETE_ATTACHMENT = 205;
    const ADD_PROPOSAL_STATUS = 207;


    //PROPOSAL
    const ADD_PROPOSAL = 19;
    const EDIT_PROPOSAL = 20;
    const DELETE_PROPOSAL = 21;
    const COPY_PROPOSAL = 22;
    const DUPLICATE_PROPOSAL = 23;
    const STANDALONE_PROPOSAL = 24;
    const ADD_PROPOSAL_SERVICE = 25;
    const EDIT_PROPOSAL_SERVICE = 26;
    const DELETE_PROPOSAL_SERVICE =27;
    const UPDATE_PROJECT_INFO = 28;
    const UPDATE_PROPOSAL_SETTING = 29;
    const SET_PROPOSAL_STATUS = 30;
    const CHANGE_PROPOSAL_STATUS = 31;
    const PROPOSAL_REASSIGN = 32;
    const PROPOSAL_ESTIMATE_ACTIVATE = 33;
    const GROUP_CHANGE_PROPOSAL_STATUS = 34;
    const CHANGE_PROPOSAL_WIN_DATE = 35;
    const ADD_PROPOSAL_IMAGE = 36;
    
    const DELETE_PROPOSAL_IMAGE = 37;
    
    const PROPOSAL_IMAGE_ADD_TO_PROPOSAL = 38;
    const PROPOSAL_IMAGE_ADD_TO_WORKORDER = 39;
    const PROPOSAL_IMAGE_REMOVE_FROM_PROPOSAL = 40;
    const PROPOSAL_IMAGE_REMOVE_FROM_WORKORDER = 41;
    const PROPOSAL_IMAGE_LAYOUT_CHANGE = 42;
    const PROPOSAL_IMAGE_GROUP_DELETE = 43;
    const CHANGE_PROPOSAL_STATUS_DATE = 44;
    const GROUP_CHANGE_PROPOSAL_STATUS_DATE = 45;
    const GROUP_CHANGE_PROPOSAL_DATE = 46;
    const ADD_PROPOSAL_VIDEO = 47;
    const UPDATE_PROPOSAL_VIDEO = 48;
    const DELETE_PROPOSAL_VIDEO = 49;
    const ADD_COVER_IMAGE_PROPOSAL_VIDEO = 50;
    const DELETE_COVER_IMAGE_PROPOSAL_VIDEO = 51;
    const VISIBLE_PROPOSAL_VIDEO_IN_PROPOSAL = 52;
    const HIDDEN_PROPOSAL_VIDEO_IN_PROPOSAL = 53;
    const VISIBLE_PROPOSAL_VIDEO_IN_WORKORDER = 54;
    const HIDDEN_PROPOSAL_VIDEO_IN_WORKORDER = 55;

    const PROPOSAL_ESTIMATE_ADD_ITEM = 56;
    const PROPOSAL_ESTIMATE_DELETE_ITEM = 57;
    const PROPOSAL_ESTIMATE_EDIT_ITEM = 58;
    const PROPOSAL_ESTIMATE_ITEM_PRICE_ADJUST = 59;
    const PROPOSAL_ESTIMATE_ITEM_REVERT_PRICE = 60;
    const PROPOSAL_ESTIMATE_LINE_ITEM_PRICE_CHANGE = 61;
    const GROUP_DELETE_PROPOSAL_ESTIMATE_LINE_ITEM = 62;
    const PROPOSAL_ESTIMATE_ADD_PHASE = 63;
    const PROPOSAL_ESTIMATE_EDIT_PHASE = 64;
    const PROPOSAL_ESTIMATE_DELETE_PHASE = 65;
    const PROPOSAL_ESTIMATE_NOTE_ADD = 66;
    const PROPOSAL_ESTIMATE_ADD_SERVICE_FIELD = 67;
    const PROPOSAL_ESTIMATE_ADJUST_OH_RATE = 68;
    const PROPOSAL_ESTIMATE_ADJUST_PM_RATE = 69;
    const PROPOSAL_ESTIMATE_STATUS_CHANGE = 70;
    const GROUP_DELETE_PROPOSAL_ESTIMATE_TYPE = 71;
    const PROPOSAL_ESTIMATE_MOBILE_JOB_COSTING = 72;
    const PROPOSAL_ESTIMATE_SEND_JOB_COSTING_LINK = 73;

    const PROPOSAL_CAMPAIGN_DELETE = 74;

    const PROPOSAL_EMAIL_SEND = 75;
    const PROPOSAL_EMAIL_SEND_WORKORDER = 76;
    const PROPOSAL_APPROVAL_QUEUE = 77;
    const HIDE_PROPOSAL = 78;
    const VISIBLE_PROPOSAL = 79;
    const EXCLUDE_PROPOSAL_FROM_EMAIL = 80;
    const INCLUDE_PROPOSAL_FROM_EMAIL = 81;

    const GROUP_CHANGE_PROPOSAL_BUSINESS_TYPE = 82;
    const GROUP_CHANGE_PROPOSAL_WIN_DATE = 83;

    const WEB_PROPOSAL_PRINTED = 84;
    const WEB_PROPOSAL_DOWNLOAD = 85;
    const WEB_PROPOSAL_CLIENT_SIGN = 86;
    const WEB_PROPOSAL_USER_SIGN = 87;
    const WEB_PROPOSAL_CLIENT_SIGN_DELETED = 88;
    const WEB_PROPOSAL_USER_SIGN_DELETED = 89;
    const WEB_PROPOSAL_ASK_QUESTION = 90;

    const WEB_PROPOSAL_LINK_SET_EXPIRED = 91;
    const WEB_PROPOSAL_LINK_REMOVE_EXPIRED = 92;
    const WEB_PROPOSAL_LINK_DISABLE = 93;
    const WEB_PROPOSAL_LINK_ENABLE = 94;

    const PROPOSAL_ADD_USER_PERMISSION = 95;
    const PROPOSAL_REMOVE_USER_PERMISSION = 96;

    const PROPOSAL_AUDIT_ADD = 97;
    const PROPOSAL_AUDIT_VIEWED = 98;
    const PROPOSAL_AUDIT_REMOVED = 99;
    const PROPOSAL_AUDIT_EDIT = 100;


    const PROPOSAL_PDF_VIEWED = 101;
    const PROPOSAL_PDF_DOWNLOAD = 102;

    const PROPOSAL_EMAIL_BOUNCED = 103;
    const WEB_PROPOSAL_VIEWED = 104;

    const PROPOSAL_CAMPAIGN_SETTING_CHANGE = 105;
    const PROPOSAL_INVOICED = 106;
    const PROPOSAL_EMAIL_DELIVERED = 107;

    const PROPOSAL_CHANGE_LAYOUT = 206;
    const PROPOSAL_CHECKLIST = 208;


    //PROSPECT
    const ADD_PROSPECT = 143;
    const EDIT_PROSPECT = 144;
    const DELETE_PROSPECT = 145;

    const UPLOAD_PROSPECT = 146;
    const PROSPECT_EMAIL_SEND = 147;
    const PROSPECT_GROUP_REASSIGN = 148;
    const PROSPECT_GROUP_EMAIL = 149;
    const PROSPECT_CAMPAIGN_DELETE = 150;
    const PROSPECT_GROUP_CHANGE_BUSINESS_TYPE = 151;
    const PROSPECT_CHANGE_BUSINESS_TYPE = 191;

    const PROSPECT_CHANGE_SOURCE = 199;
    const PROSPECT_EXPORT = 200;
    


    //LEAD
    const ADD_LEAD = 169;
    const EDIT_LEAD = 170;
    const DELETE_LEAD = 171;
    const UPLOAD_LEAD = 172;
    const GROUP_LEAD_CHANGE_BUSINESS_TYPE = 173;
    const GROUP_LEAD_EMAIL = 174;
    const GROUP_LEAD_DELETE = 175;
    const GROUP_LEAD_REASSIGN = 176;
    const LEAD_CAMPAIGN_DELETE = 177;
    const LEAD_EMAIL_SEND = 178;
    const LEAD_CHANGE_BUSINESS_TYPE = 179;
    const LEAD_CONVERT = 180;
    const LEAD_EMAIL_DELIVERED = 181;
    const LEAD_SETTINGS = 216;

    //CONTACT
    const ADD_CONTACT = 152;
    const EDIT_CONTACT = 153;
    const DELETE_CONTACT = 154;
    const UPLOAD_CONTACT = 155;
    const REASSIGN_CONTACT = 156;
    const REASSIGN_CONTACT_ACCOUNT = 157;
    const GROUP_DELETE_CONTACT = 158;
    const GROUP_CONTACT_CHANGE_BUSINESS_TYPE = 159;
    const GROUP_CONTACT_EMAIL = 160;
    const GROUP_CONTACT_DELETE = 161;
    const GROUP_CONTACT_REASSIGN = 162;
    const GROUP_CONTACT_CAMPAIGN_DELETE = 163;
    const CONTACT_EMAIL_SEND = 164;
    const CONTACT_CHANGE_BUSINESS_TYPE = 165;
    const CONTACT_EMAIL_CHANGED = 166;
    const EXCLUDE_CONTACT_FROM_EMAIL = 167;
    const INCLUDE_CONTACT_FROM_EMAIL = 168;

    //ACCOUNT
    const ADD_ACCOUNT = 182;
    const EDIT_ACCOUNT = 183;
    const DELETE_ACCOUNT = 184;
    const ACCOUNT_MERGED = 185;
    const GROUP_DELETE_ACCOUNT = 186;
    const GROUP_ACCOUNT_CHANGE_BUSINESS_TYPE = 187;
    const GROUP_ACCOUNT_EMAIL = 188;
    const GROUP_ACCOUNT_DELETE = 189;
    const ACCOUNT_CHANGE_BUSINESS_TYPE = 190;
    //WORK ORDER
    const PROPOSAL_WORKORDER=210;
   //Notes 
   const ADD_NOTES=212;
   const DELETE_NOTES=213;
   const EDIT_NOTES=214;



    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parent_id;
    /**
     * @ORM\Column(type="string")
     */
    private $activity_action_name;
    

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @return mixed
     */
    public function getActivityActionName()
    {
        return $this->activity_action_name;
    }

    /**
     * @param mixed $activity_action_name
     */
    public function setActivityActionName($activity_action_name)
    {
        $this->activity_action_name = $activity_action_name;
    }
}
