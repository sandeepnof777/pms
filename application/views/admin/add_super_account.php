<?php $this->load->view('global/header-admin'); ?>
<style>
    .select2-container {
    width: 290px !important;
    padding: 0;
}

</style>
<div id="content" class="clearfix">
    <div class="widthfix">
        <form class="form-validated" action="<?php echo site_url('admin/add_super_account/' . $this->uri->segment(3)) ?>" method="post" style="margin:auto; width: 600px;">
            <div class="content-box" style="width: 100%;">
                <div class="box-header">
                    Add New Account
                    <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
                </div>
                <div class="box-content">
                    <div class="box-content">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table form-validated">
                            <thead>
                            <tr>
                                <td>Account Info</td>
                            </tr>
                            </thead>
                            <tr class="">
                                <td>
                                    <p class="clearfix" style="margin-left: 150px;">
                                        <input type="radio" class="dont-uniform superUserType" checked="checked" name="superUserType" value="1"><label style="width: 115px;text-align: left;margin-left: 5px;margin-top: -4px;">Select existing user</label>
                                        
                                        <input type="radio" class="dont-uniform superUserType" name="superUserType" value="2"><label style="width: 115px;text-align: left;margin-left: 5px;margin-top: -4px;">Create new user</label>
                                    </p>
                                </td>
                            </tr>
                            <tr class="add_new_user even hide">
                                <td width="50%">
                                    <p class="clearfix">
                                        <label>Email <span>*</span></label>
                                        <input type="text" name="accountEmail" id="accountEmail" class="text  email tiptip" title="Enter user's email" value="">
                                    </p>
                                </td>
                            </tr>
                            <tr class="add_new_user hide">
                                <td width="50%">
                                    <p class="clearfix">
                                        <label>First Name <span>*</span></label>
                                        <input type="text" name="firstName" id="firstName" class="text  tiptip" title="Enter user's first name" value="">
                                    </p>
                                </td>
                            </tr>
                            <tr class="add_new_user even hide">
                                <td>
                                    <p class="clearfix">
                                        <label>Last Name <span>*</span></label>
                                        <input type="text" name="lastName" id="lastName" class="text  tiptip" title="Enter user's last name" value="">
                                    </p>
                                </td>
                            </tr>
                            <tr class="add_new_user hide">
                                <td>
                                    <p class="clearfix">
                                        <label>Password <span>*</span></label>
                                        <input type="text" name="password" id="password" class="text  tiptip" title="Enter user's password" value="">
                                    </p>
                                </td>
                            </tr>


                            <tr class="add_old_user ">
                                <td>
                                    <p class="clearfix ">
                                    
                                        <label>Select Super User <span>*</span></label>
                                        <select name="SeachaccountName" id="SeachaccountName" class="dont-uniform required"  ><option></option></select></p>
                                        <input type="hidden" id="existing_user_id" name="existing_user_id">
                                    </p>
                                </td>
                            </tr>
                            
                            <tr class="add_new_user even hide">
                                <td>
                                    <label>Expiration Date</label>
                                    <input class="text tiptip" title="Set Company Expiration Date" name="expires" id="expires" type="text" style="width: 75px; text-align: center;" value="<?php echo date('n/j').'/'.(date('Y') + 1) ?>">
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
                                        <input type="submit" value="Add" name="addNewAccount" class="btn update-button" style="float: none; margin: 0 auto; display: block;">
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
        $("#expires, #expires2").datepicker({
            dateFormat:'m/d/yy'
        });



        //Select2 start

$("#SeachaccountName").select2({
    ajax: {
        url: '<?php echo site_url('ajax/ajaxSelect2SearchSuperUser') ?>',
        dataType: 'json',
        delay: 250,
        
        data: function (params) {
        return {
            startsWith: params.term, // search term
            firstName: '',
            lastName: '',
            page: params.page
        };
        },
        processResults: function (data, params) {
        
        params.page = params.page || 1;
        // if($('.add_new_class').length<1){
        //     $('.select2-results').after('<span class="add_new_class"><ul style="padding: 7px;border-top: 1px solid #ccc;"><li><a href="javascript:void(0);" onclick="add_new_lead()" style="color: #25AAE1;">+ New Contact</li></ul></span>');
        // }
        
        return {
            results: data.items,
            pagination: {
            more: (params.page * 30) < data.total_count
            }
        };
        

        //'<span class="select2-results"><ul class="select2-results__options" role="listbox" id="select2-SeachcompanyName-results" aria-expanded="true" aria-hidden="false"><li role="alert" aria-live="assertive" class="select2-results__option select2-results__message">+Add New</li></ul></span>';
        },
        cache: true
    },
    placeholder: 'Search for a User',
    allowClear: true,
    debug: true,
    minimumInputLength: 1,
    language: {
        inputTooShort: function () { return ''; },
        noResults: function(){
            return "User Not Found";
        }
    },
    templateResult: formatRepo2,
    templateSelection: formatRepoSelection2
    });


function formatRepo2 (repo) {
  if (repo.loading) {
    return repo.label;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      
      "<div class='select2-result-repository__meta'>" +
        "<table >"+
        "<tr><th style='vertical-align: top;'>Name:</th><td class='select2-result-repository_account'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Email:</th><td class='select2-result-repository_email'></td></tr>"+
        "<tr><th style='vertical-align: top;'>Company:</th><td class='select2-result-repository_company'></td></tr>"+
      "</div>" +
    "</div>"
  );
  
  $container.find(".select2-result-repository_account").text(repo.label);
  $container.find(".select2-result-repository_email").text(repo.email);
  $container.find(".select2-result-repository_company").html(repo.company);

  return $container;
}

function formatRepoSelection2 (repo) {
    
    return '('+repo.label+') ' + repo.company;
    
    }
$(".select2-selection__placeholder").text('Search ')

    $('#SeachaccountName').on("select2:selecting", function(e) { 

       // $(".chilCompaniesMultiple").val("").trigger('change');

        // what you would like to happen
        var company_id = e.params.args.data.company_id;
        $(".chilCompaniesMultiple option[value='" + company_id + "']").prop("selected", true);
       // $(".chilCompaniesMultiple option[value='" + company_id + "']").prop("disabled", true);
                

        var select_id = e.params.args.data.id;  
        $('#existing_user_id').val(select_id)
            event.preventDefault();
    });


    $('.superUserType').click(function() {
        var superUserType = $('.superUserType:checked').val();
        console.log(superUserType);
        if(superUserType == '1'){

            $('.add_old_user').removeClass('hide');
            $('.add_new_user').addClass('hide');

            $('#SeachaccountName').addClass('required');

            $('#firstName').removeClass('required');
            $('#password').removeClass('required');
            $('#accountEmail').removeClass('required');
            $('#lastName').removeClass('required');

        }else{
            $('.add_old_user').addClass('hide');
            $('.add_new_user').removeClass('hide');

            $('#SeachaccountName').removeClass('required');

            $('#firstName').addClass('required');
            $('#password').addClass('required');
            $('#accountEmail').addClass('required');
            $('#lastName').addClass('required');
            
        }
    });





    });
</script>
<?php $this->load->view('global/footer'); ?>
