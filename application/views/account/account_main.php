<style>
    /* Zebra Striping for ul li */
.card ul.container li:nth-child(odd) {
    background-color: #cccccc9c; /* Change this to the background color you want */
}

.card ul.container li:nth-child(even) {
    background-color: #ffffff; /* Change this to the background color you want */
}
</style>
<?php $this->load->view('global/header') ?>
<?php $this->load->view('account/settingSearch') ?> 
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="nav-box clearfix">
            <!--common sidebar-->
                <?php //$this->load->view('account/account_sidebar'); ?>
            <!--common sidebar-->
             <!--Main body-->
             <div class="nav-box clearfix">
                <div class="proposal-setting" style="float:right; min-height:500px;">
                <?php if(in_array($this->uri->segment(2), array('my_account'))) {?>
                            <div class="parent-container">
                                        <div class="filter-account-item">
                                            <div id="account_filter" class="account_filter">
                                                <label><span style="font-weight: bold;">Search:&nbsp;&nbsp;</span>
                                            <input name="search-text" type="text"
                                                    class="account-setting-search"
                                                    id="account-item-search"
                                                    style="border: 1px solid #ccc!important;background:#ddd"
                                                    >
                                                </label>
                                            </div>
                                        </div>
                                    <div style="float:left;margin-left:328px;">
                                    <?php if (help_box(58)) { ?>
                                    <div class="help right tiptip" title="Help"><?php help_box(58, true) ?></div>
                                    <?php } ?>
                                    </div>

                            </div>
                <?php } ?>

       

                <?php if ($account->isAdministrator()) { ?>
                    <div id="company_setting"><?php $this->load->view('account/company_setting'); ?></div>
                    <div id="proposal_setting"><?php $this->load->view('account/proposal_setting'); ?></div>
                
                    <?php } else{?>
                        <div id="company_setting"><?php $this->load->view('account/user_account'); ?></div>
                    <?php } ?>
    <!--for searching --> 

      <!--for second demo-->
      <div class="search-result-card2">
                     <div class="filter-setting"></div>
            </div>
<!--for second demo -->
                    <div class="filter-setting-error"></div>
                    <!--for searching filter -->
                </div>
             </div>
             <!--Main body-->
    
        </div>
    </div>
</div>
<!--#content-->
 <script>
$(document).ready(function() {
 
       <?php  $urlCheck = $this->uri->segment(3); ?>
        var uri = "<?php echo $urlCheck ?>";
        $("#company_setting").show();
        $('[data-target="company_setting"]').closest('li').addClass('active');   
        $("div[id^='proposal_setting'], div[id^='event_types']").hide();
        // Handle the click event on the links
        $(".show-div").on("click", function() {
        /*hide search when click on setting*/
        $("#account-item-search").val("");
        $('.grid-container').css("display", "block");
        $('.search-result-card').hide();
        $('.grid-container').show();
        /*hide search when click on setting*/
        var target = $(this).data("target");
        // Hide all div elements except the one to be shown
        $("div[id^='company_setting'], div[id^='proposal_setting'], div[id^='company_info'], div[id^='event_types']").not("#" + target).hide();
        // Show the targeted div
        $("#" + target).show();
        $("li").removeClass("active");
        $(this).parent().addClass("active");
    }); 
        if(uri.trim()=="proposal_settings")
        {
            $("div[id^='company_setting'], div[id^='company_info'], div[id^='event_types']").not("#proposal_setting").hide();
            $("#proposal_setting").show();
            $("li").removeClass("active");
            $('[data-target="proposal_setting"]').closest('li').addClass('active');
        }  
});
</script>
<?php $this->load->view('global/footer') ?>
 
 