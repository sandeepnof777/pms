<?php $this->load->view('global/header-admin'); ?>
<style>
    .select2-container {
    width: 290px !important;
    padding: 0;
}
.select2-selection.select2-selection--multiple{
    min-height: 26px!important;
}

.chilCompanies_box .select2-container{
    
    border: 1px solid #aaa;
    border-radius: 4px;

}

.chilCompanies_box .select2-selection--multiple{
    border: none!important;
}

.select2-selection--multiple ul.select2-selection__rendered{
    float: left;
}


</style>
<div id="content" class="clearfix">
    <div class="widthfix">
        <form class="form-validated" action="<?php echo site_url('admin/add_child_company/' . $this->uri->segment(3)) ?>" method="post" style="margin:auto; width: 600px;">
            <div class="content-box" style="width: 100%;">
                <div class="box-header">
                    Add New Child Company
                    <a href="<?php echo site_url('admin/master_company_list') ?>" class="box-action tiptip" title="Go Back">Back</a>
                </div>
                <div class="box-content">
                    <div class="box-content">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table form-validated">
                            <thead>
                            <tr>
                                <td>Company Info</td>
                            </tr>
                            </thead>
                            


                            <tr >
                                <td>
                                        <p class="clearfix chilCompanies_box">
                                        <label>Child Companies</label>
                                        <select class="dont-uniform chilCompaniesMultiple required" id="chilCompaniesMultiple" style="width: 64%" name="child_companies[]" multiple="multiple">
                                            <?php
                                            foreach ($childCompanies as $childCompany) {
                                                echo '<option value="' . $childCompany['companyId'] . '">' . $childCompany['companyName'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </p>
                                </td>
                            </tr>
                            
                            
                            <tr class=" ">
                                <td>
                                    <p class="clearfix">
                                        <label style="width: 100%;"><span>* = Required Field</span></label>
                                    </p>
                                </td>
                            </tr>
                            <tr class=" even">
                                <td>
                                    <p class="clearfix">
                                        <input type="submit" value="Add" name="addNewChildCompany" class="btn update-button" style="float: none; margin: 0 auto; display: block;">
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        


        $('.chilCompaniesMultiple').select2({
                placeholder: "Select one or many",
                html: true,
                templateSelection: function(tag, container) {
                    var $option = $('.chilCompaniesMultiple option[value="' + tag.id + '"]');
                    if ($option.attr('disabled')) {
                        $(container).addClass('locked-tag');
                        $(container).addClass('tag_tiptip');
                        tag.title = 'This Company User added as Super user';
                        tag.locked = true;
                    }
                    return tag.text;
                },
            });





    });
</script>
<?php $this->load->view('global/footer'); ?>
