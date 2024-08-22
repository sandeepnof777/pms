<div id="proposal-user-permission" style="display: flex;">
    <input type="text" class="text permissionUsersfilterSearch" placeholder="Search Users" style="right: 37%;padding: 5px;position:absolute;width: 200px;">
    <a href="javascript:void(0);" class="clearFilterSearch" style="display: none;font-size: 25px;position: absolute;right: 34%;">×</a>
    <div class="padded" style="float: left;margin-top:35px;display: grid;grid-template-columns: repeat(3,1fr);">
    <?php
    $users = array();
    foreach($user_permissions as $user_permission){
        $users[] = $user_permission->getUserId();
    }
    $proposalOwnerBanch = $proposal->getOwner()->getBranch();
    $owners = [];
    $accountsArray = [];
    foreach ($permissionUserAccounts as $userAccount) {
        
        if($userAccount->getAccountId() == $proposal->getOwner()->getAccountId()){
            $owners[] = $userAccount;
            continue;
        }

        if($userAccount->getUserClass() == 2 || $userAccount->getUserClass() == 3 || $userAccount->isGlobalAdministrator()){
           
            continue;

        }
        if($userAccount->getUserClass() == 1 && $userAccount->getBranch() == $proposalOwnerBanch){
           
            continue;

        }

        $accountsArray[] = $userAccount;
    }

    if(isset($owners[0])){
        array_unshift($accountsArray, $owners[0]);
    }
    

    $first = true;

    foreach ($accountsArray as $accountCheck) {
        $owner = '';
        $ownerClass = '';
        if ($first) {
            $owner = ' [Proposal Owner]';
            $ownerClass = 'permission_owner';
            $first = false;
        }
        $checked = '';
        $disabled = '';
        $checkedClass = '';
        if(in_array($accountCheck->getAccountId(),$users) ){
            $checked = 'checked';
            $checkedClass = 'user_permission_checked';
        }
        if($proposal->getOwner()->getAccountId() == $accountCheck->getAccountId() ){
            $disabled = 'disabled';
            $checked = 'checked';
            $checkedClass = 'user_permission_checked';
        }
        
        ?>
        <label class="nice-label <?=$checkedClass.' '.$ownerClass;?>" style="width: 255px;" for="permission_user_<?php echo $accountCheck->getAccountId() ?>"><input type="checkbox" value="<?php echo $accountCheck->getAccountId() ?>" class="account_users"  name="account_users" id="account_users_<?php echo $accountCheck->getAccountId() ?>" <?=$checked;?> <?=$disabled;?> /><span class="user_label"><span style="font-weight: bold;"><?php echo $accountCheck->getFullName().$owner;?></span><br/><span><?=$accountCheck->getUserClass(true,true) ; ?></span></span></label>
    <?php
    }
    
    ?>
</div>

<a class="btn update-button saveIcon" style="position: absolute;right: 20px;bottom: 5px;" id="user_permission_save"> Save</a>

</div>