<?php /** @var $proposal \models\Proposals */ ?>
<?php $this->load->view('global/header'); ?>
<style>

#content{
    line-height: 1.7em;
    
}
#top_menu{
    display:none;
}
#top_panel{
    display:none;
}
h2 {
    font-size: 26px!important;
}
h3 {
    font-size: 22px!important;
}
</style>
<div id="content" class="clearfix estimate-item-sheet materialize" xmlns="http://www.w3.org/1999/html">


<div class="et_pb_text_inner">
    <h2>Privacy &amp; Security Policy</h2>
<h3>Information Collected &amp; Use</h3>
<p>When you come to the <?php echo SITE_NAME; ?> web site, we log your current Internet address (this is usually a temporary address assigned by your Internet service provider when you log in), the type of operating system you are using, and the type of browser software used. In addition, we may keep track of what areas of our web site you visit. This tracking will occur in the form of a “Cookie” or similar file that will permit tailoring of the web site to better match your interests and/or preferences.</p>
<p>While we track this information about the technology you are using, we do not identify who you are. You will remain anonymous to our system unless you choose to tell us who you are. For example, when you submit a question via our e-mail submission form or submit your resume for consideration of employment, this information is kept confidential and only disclosed to those who may be able to help answer your question or considers you for employment within the company.</p>
<p>We do not disclose your personal information to other companies who intend to sell their products or services to you. For example, we will not sell your name or E-mail address to a direct-marketing company.</p>
<h3>Security</h3>
<p><?php echo SITE_NAME; ?> utilizes some of the most advanced technology for Internet security available today using industry standard Secure Socket Layer (SSL) technology, your information is protected using both server authentication and data encryption, ensuring that your data is safe, secure, and available only to registered users in your company. Your data will be completely inaccessible to your competitors.</p>
<p>When you log in, the URLs used to access your data are all preceded with https:// instead of http://, which indicates that a secure connection has been established.&nbsp; This is a verified secure link that you will notice most url’s do not use.</p>
<p><?php echo SITE_NAME; ?> provides each User in your organization with a unique user name and password that must be entered each time a User logs on.&nbsp;<?php echo SITE_NAME; ?> issues a session “cookie” only to record encrypted authentication information for the duration of a specific session. The session “cookie” does not include either the username or password of the user.&nbsp;<?php echo SITE_NAME; ?>does not use “cookies” to store other confidential user and session information, but instead implements more advanced security methods based on dynamic data and encoded session IDs.</p>
<p>In addition,&nbsp;<?php echo SITE_NAME; ?> is hosted in a secure server environment with Rackspace that uses a firewall and other advanced technology to prevent interference or access from outside intruders.</p>
<p><?php echo SITE_NAME; ?> does not review, share, distribute, print, or reference your data except as provided in the <?php echo SITE_NAME; ?> Terms of Use, or as may be required by law.</p>
<h3>Your Proposal &amp; Client Data</h3>
<p>At any point in time you are able to import &amp; export data within <?php echo SITE_NAME; ?></p>
<p>You will always be able to export all of your data from <?php echo SITE_NAME; ?>&nbsp; It is a simple procedure where all client data and proposal information can be exported out as a csv/xls file for your use.&nbsp; We also urge you to do this as a routine to back up any and all of your data.</p>
<p><?php echo SITE_NAME; ?>, any of their employees or affiliate will not copy, share or access any of your proposal or client data at any time without your authorization.&nbsp; You have complete control of this and can import/export this information at any time.&nbsp; At times when a user needs assistance, with your authorization we will assist you as required with uploading/downloading as required.</p></div>


</div>


<?php $this->load->view('global/footer'); ?>
<script src='/static/js/inputmask.js'></script>
