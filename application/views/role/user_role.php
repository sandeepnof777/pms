<?php $this->load->view('global/header-admin'); ?>
<style>
.cwidth3_container div.selector span{width:50px!important;}
.cwidth3_container div.selector{width:75px!important;}
#roleNameDialog input:focus
{
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
}
table.formTable label.error {
    margin-top: 6px;

}
#content
{
    height: 500px;
}
</style>
<div id="content" class="clearfix">
        <div class="widthfix">
<h3>Role Permission</h3>


<!---Start Filter button---->
<div class="materialize" style="min-width: 100px !important;top: 4px;float:right;white-space: nowrap;">
        <div class="m-btn groupAction tiptip"  style="position: relative;display:none;font-size: 14px;" title="Carry out actions on selected Assemblies" >
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="groupActionsContainer materialize" style="width:160px">
                <div class="collection groupActionItems" >
                    
                    <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                        <i class="fa fa-fw fa-trash"></i> Delete Assembly
                    </a>
                    
                </div>
            </div>
        </div>
        <a class="m-btn" id="addEstTemplate" href="#" style="margin: 10px 10px 10px 0;">
            <i class="fa fa-fw fa-plus"></i>
            Add Role
        </a>
        <div class="clearfix"></div>
</div>
<!---End Filter button---->

<table class="boxed-table defaultTable" width="100%" id="estimationTemplates">
    <thead >
   
    <!-- <th width="3%"><span class="span_checkbox_th"><input type="checkbox" class="check_all"></span></th> -->
    <th style="padding: 5px;"> </th>
    <th style="padding: 10px; text-align: left;">Name</th>

        <th style="padding: 10px; text-align: left;">Actions</th>
    </tr>
    </thead>
    <tbody>
       <?php foreach($role as $roleUser) {?>
         <tr>
            <td style="text-align: center" width="2%">          
            </td>
            <td><?php echo $roleUser['name']; ?></td>
            <td style="text-align: center" width="20%">
            <a   href="javascript:void(0);" class="btn tiptip editTemplate" title="Edit Role Name"
                    data-role-id="<?php echo $roleUser['id'];  ?>">
            <i class="fa fa-edit"></i>
            </a>
            <a  href="<?php echo site_url('userrole/edit_role_permission/' . $roleUser['id']); ?>" class="btn tiptip assignTemplate" title="Assign Assembly to Services"
                       data-role-id=" " data-template-name=" ">
                        <i class="fa fa-list-alt"></i>
             </a>
             <a href="javascript:void(0);" class="btn tiptip deleteTemplate" title="Delete Assembly"
                       data-role-id="">
                        <i class="fa fa-trash"></i>
             </a>
           </td>
         </tr>
        <?php }  ?>

      

     </tbody>
</table>
</div>
</div>

<div id="roleNameDialog" title="Save Assembly ">

<div style="padding-top: 10px;">
    <form id="saveTemplateForm" action="<?php echo site_url('userrole/saveRoleName') ?>" method="post">
        <input type="hidden" name="roleId" id="roleId">
        <input type="hidden" name="isTemplateDuplicate" id="isTemplateDuplicate">  

<table class="formTable boxed-table-error">
    <tr>
        <td>
            <label style="font-weight: bold;">Role Name</label>
        </td>
        <td>
            <input type="text" class="text" name="roleName" id="roleName" style="width: 250px;">
        </td>
    </tr>
 
   
  
 
 
    
</table>
    </form>
</div>

</div>

 

 <?php $this->load->view('global/footer'); ?>
<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">
 $(document).ready(function() {
    console.log("hello");
// Click to add new Assembly
        $(".editTemplate").click(function() {
            console.log("hello2");
            // Clear the inputs
            $("#roleId").val($(this).data('role-id'));
            $("#isTemplateDuplicate").val(0);
            $("#roleName").val($(this).data('template-name'));
            
            if($(this).data('template-type')){
                
                $("#templateType").prop('checked',true);
                $("#templateRate").val($(this).data('template-rate'));
                $("#templateOverheadRate").val($(this).data('template-overhead-rate'));
                $("#templateOverheadPrice").val($(this).data('template-overhead-price'));
                $("#templateOverheadPriceSpan").text('$'+addCommas($(this).data('template-overhead-price')));
                $("#templateBasePrice").val($(this).data('template-base-price'));
                $("#templateProfitRate").val($(this).data('template-profit-rate'));
                $("#templateProfitPrice").val($(this).data('template-profit-price'));
                $("#templateProfitPriceSpan").text('$'+addCommas($(this).data('template-profit-price')));


                $("#calculation_type").val($(this).data('calculation-type'));
                $("#calculation_type").trigger('change');
                $(".templateRateRow").show();
            }else{
               
                $("#templateType").prop('checked',false);
                $(".templateRateRow").hide();
            }
            $("#templateType").attr("disabled", true);
            $("#templateTypeMsgSpan").show();
            $.uniform.update();
            // SHow the dialog
            $( "#saveTemplateForm" ).valid();
            $("#roleNameDialog").dialog('option', 'title', 'Edit Role');
            $("#roleNameDialog").dialog('open');
            return false;
        });

              // Instantiate Dialogs
              $("#roleNameDialog").dialog({
            autoOpen: false,
            modal: true,
            width: 500,
            buttons: {
                "Cancel": {
                    html: '<i class="fa fa-fw fa-close"></i> Cancel',
                    'class': 'btn left',
                    click: function () {
                        $(this).dialog('close');
                    }
                },
                "Save": {
                    html: '<i class="fa fa-fw fa-save"></i> Save Role',
                    'class': 'btn blue-button',
                    click: function () {

                        if (!$("#roleName").val()) {
                            swal('Please enter a Role name!');
                            return false;
                        } else {
                            $("#templateType").removeAttr("disabled");
                            $("#saveTemplateForm").submit();
                        }

                    }
                }
            }
        });

             // Click to add new assembly
             $("#addEstTemplate").click(function() {
            // Clear the inputs
            $("#roleId").val('');
            $("#isTemplateDuplicate").val(0);
            $("#roleName").val('');
            $("#templateRate").val('0.00');
            $("#templateBasePrice").val('0.00');

            $("#templateOverheadRate").val();
            $("#templateProfitRate").val();
         

            $("#templateOverheadPriceSpan").text('$0.00');
            $("#templateProfitPriceSpan").text('$0.00');
            $("#templateOverheadPrice").val('0.00');
            $("#templateProfitPrice").val('0.00');

            $("#templateType").prop("checked",false);
           
            $("#templateType").removeAttr("disabled");
            $("#templateTypeMsgSpan").hide();
            $.uniform.update();
            $(".templateRateRow").hide();
            
            // SHow the dialog
            $( "#saveTemplateForm" ).valid();
            $("#roleNameDialog").dialog('option', 'title', 'Add New Assembly');
            $("#roleNameDialog").dialog('open');
            return false;
        });
 

    });

    </script>