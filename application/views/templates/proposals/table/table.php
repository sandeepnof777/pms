
<style>

#dialog-message .clearfix {
    line-height: 1.7!important;
}
.dataTables_info {
    width: 46%!important;
    clear: none !important;
}

#email_events_table_wrapper .dataTables_info {
    width: 37%!important;
    clear: none !important;
}


.email_types_checkboxes .checker{
  margin-right: 3px!important;
  margin-top: -1px;
}
#addAtCursorEdit{
  position: absolute;
    margin-top: 1px;
    margin-left: 16px;
}
#addAtCursorEdit span{
  padding-top: 2px;
    padding-bottom: 2px;
}

</style>
<style>

/* The actual timeline (the vertical ruler) */
.timeline {
  
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
  content: '';
  position: absolute;
  width: 6px;
  background-color: white;
  top: 0;
  bottom: 0;
  left: 3%;
    margin-left: 2px;
}

/* Container around content */
#timeline .container {
    padding: 10px 45px;
  position: relative;
  background-color: inherit;
  width: 87.6%;
}

/* The circles on the timeline */
#timeline .container::after {
  content: '';
  position: absolute;
  width: 15px;
  height: 15px;
  right: -17px;
  background-color: white;
  border: 4px solid #25AAe1;
  top: 20px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
#timeline .left {
  left: 0;
}

/* Place the container to the right */
/* #timeline .right {
  left: 50%;
} */

/* Add arrows to the left container (pointing right) */
#timeline .left::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
#timeline .right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 35px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
}

/* Fix the circle for containers on the right side */
#timeline .right::after {
    left: 8px;
}

/* The actual content */
#timeline .content {
  padding: 20px 30px;
  background-color: white;
  position: relative;
  border-radius: 6px;
  -moz-box-shadow: 1px 2px 4px rgba(0, 0, 0,0.5);
  -webkit-box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
  box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
}

/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
  /* Place the timelime to the left */
  .timeline::after {
  left: 31px;
  }
  
  /* Full-width containers */
  #timeline .container {
  width: 100%;
  padding-left: 70px;
  padding-right: 25px;
  }
  
  /* Make sure that all arrows are pointing leftwards */
  #timeline .container::before {
  left: 60px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent white transparent transparent;
  }

  /* Make sure all circles are at the same spot */
  #timeline .left::after, #timeline>.right::after {
  left: 15px;
  }
  
  /* Make all right containers behave like the left ones */
  #timeline .right {
  left: 0%;
  }

  
}
.event-checkbox-inline, .radio-inline {
    position: relative;
    display: inline-block;
    padding-left: 0px;
    margin-bottom: 5px;
    font-weight: 400;
    vertical-align: middle;
    cursor: pointer;
    width: 12.5%;
}
#newProposalEventColumnFilters {
    position: absolute;
    top: 40px;
    right: 48px;
    background-color: #ebedea;
    width: 200px;
    -webkit-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
    box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.75);
    padding: 0 5px 10px 5px;
    z-index: 10000;
    display: none;
    border-radius: 5px;
    margin-top: 1px;
}

#proposalsMenuPopupContainer {
    position: relative;
    width: 100%;
    height: 0;
}

#proposalsMenuPopup {
    position: absolute;
    width: 660px;
    height: 350px;
    background: #fff;
    left: 145px;
    top: 70px;
    -webkit-box-shadow:  0 0 15px rgba(0, 0, 0, 0.8);
    -moz-box-shadow:  0 0 15px rgba(0, 0, 0, 0.8);
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.8);
    z-index: 99999;
    display: none;
}
#cke_event_email_content .cke_reset_all{
            display:none
        }

.error_editor{
  
  border: 2px solid #FBC2C4;
}
.proposal_table_checkbox div{padding: 0px!important;}
.scrolledTable{ overflow-y: auto; clear:both; }

#tabs-1{padding: 10px 2px;}
@font-face {
        font-family: "autography";
        src: url("<?php echo site_url('3rdparty/fonts/Autography-DOLnW.otf') ?>") format("opentype");
}
@font-face {
    font-family: "autosignature";
    src: url("<?php echo site_url('3rdparty/fonts/AngkanyaSebelas-VGPDB.ttf') ?>");
}
@font-face {
    font-family: "BrothersideSignature";
    src: url("<?php echo site_url('3rdparty/fonts/BrothersideSignature-w13o6.otf') ?>") format("opentype");
}

.choose_sign_canvas_option1{
    font-family: 'autography', Arial, sans-serif;
}

.choose_sign_canvas_option2{
    font-family: 'autosignature', Arial, sans-serif;
}
.choose_sign_canvas_option3{
    font-family: 'BrothersideSignature', Arial, sans-serif;
}
.choose_sign_div{
    position: relative;
}
#proposalSignatureDialog{
  min-height: 540px!important;
}
.sign_radio{
    position: absolute;
    top: 35px;
}
</style>
<link rel="stylesheet" href="<?php echo site_url('static') ?>/css/signature-pad.css">

<div id="proposalsMenuPopupContainer" position="relative" style="width: 0; height: 0" >

    <div id="proposalsMenuPopup">
        Menu
    </div>

</div>
<table cellpadding="0" cellspacing="0" border="0" class="dataTables-proposalsNew display" id="proposalsTable" style="display: none; width: 1100px;">
    <thead>
    <tr>
        <td class="proposal_table_checkbox"><input type="checkbox" id="proposalMasterCheck"></td>
        <td style="text-align: center;">Go</td>
        <td>Date</td>
        <td>Status</td>
        <td>Won</td>
        <td width="52">Job#</td>
        <td>Account</td>
        <td>Project Name</td>
        <td><i class="fa fa-fw fa-image"></td>
        <td>Price</td>
        <td>Contact</td>
        <td>User</td>
        <td>Last Activity</td>
        <td><img src="/3rdparty/icons/email_unsent.png" class="tiptiptop" style="margin-top: 9px;" title="Email Status"></td>
        <td width="30"><div class="badge blue tiptiptop" title="Delivery Status">D</div></td>
        <td width="30"><div class="badge green tiptiptop" title="Open Status">O</div></td>
        <td width="30"><div class="badge green tiptiptop" title="Audit Status">A</div></td>
        <td width="30"><div class="badge green tiptiptop" title="Estimate Status">E</div></td>
        <td width="30">GP</td>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>