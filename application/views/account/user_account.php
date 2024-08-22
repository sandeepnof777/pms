
<div class="nav-box clearfix">
            <div class="nav-right proposal-setting main-account-setting"  >
            <div class="grid-container">
                <div class="card">
                    <div class="header">
                    <p>Company</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/company_info') ?>">Company info</a></li>
                    <li><a href="<?php echo site_url('account/company_videos') ?>">My info</a></li>
                    <li><a href="<?php echo site_url('account/psa') ?>">ProSiteAudit</a></li>


                    </ul>
                </div>

                <div class="card">
                    <div class="header">
                    <p>Other</p>
                    </div>
                    <ul class="container">
                    <li><a href="<?php echo site_url('account/proposal_filters') ?>">Saved Filters</a></li>
                    </ul>
                </div>
 

                <?php if ($account->hasFullAccess()) { ?>
                        <div class="card">
                            <div class="header">
                                    <p>QuickBooks</p>
                            </div>
                                <ul class="container">
                                <li><a href="<?php echo site_url('account/qbsettings') ?>">QuickBooks</a>
                                </li>
                                </ul>
                        </div>
                    <?php } ?>


              </div>
              <!-- <div class="filter-setting"></div>
              <div class="filter-setting-error"></div> -->

            </div>
    
        </div>

<!--#content-->

 
