<?php 

// echo '<pre>';
// print_r($childCompanies);die;


$this->load->view('global/header-admin'); ?>

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

.locked-tag .select2-selection__choice__remove{
            display: none!important;
        }
        .locked-tag:before {
            font-family: "FontAwesome";
            content: "\f023";
            border-right: 1px solid #aaa;
            cursor: pointer;
            font-weight: bold;
            padding: 0 4px;
        }
</style>
<div id="content" class="clearfix">
    <div class="widthfix">
        <form class="form-validated" action="<?php echo site_url('admin/add_master_company') ?>" method="post">
            <div class="content-box">
                <div class="box-header">
                    Add Parent Company
                    <a href="<?php echo site_url('admin/master_company_list') ?>" class="box-action tiptip" title="Go Back">Back</a>
                </div>
                <div class="box-content">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table">
                        <thead>
                        <tr>
                            <td>Company Info</td>
                            <td>Admin Account Information</td>
                        </tr>
                        </thead>
                        <tr>
                            <td width="50%">
                                <p class="clearfix">
                                    <label>Company Name <span>*</span></label>
                                    <input tabindex="1" type="text" name="companyName" id="companyName" class="text required tiptip" title="Enter company's name" value="">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix" style="margin-left: 150px;">
                                    <input type="radio" class="dont-uniform superUserType" checked="checked" name="superUserType" value="1"><label style="width: 115px;text-align: left;margin-left: 5px;margin-top: -4px;">Select existing user</label>
                                      
                                    <input type="radio" class="dont-uniform superUserType" name="superUserType" value="2"><label style="width: 115px;text-align: left;margin-left: 5px;margin-top: -4px;">Create new user</label>
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Company Address</label>
                                    <input tabindex="2" type="text" name="companyAddress" id="companyAddress" class="text  tiptip" title="Enter company's street address" value="">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix ifOldUser">
                                   
                                    <label>Select Super User <span>*</span></label>
                                    <select name="SeachaccountName" id="SeachaccountName" class="dont-uniform required"  ><option></option></select></p>
                                    <input type="hidden" id="company_admin_id" name="company_admin_id">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix">
                                    <label>Company City</label>
                                    <input tabindex="3" type="text" name="companyCity" id="companyCity" class="text  tiptip" title="Enter company's city" value="">
                                </p>
                            </td>
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
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Company State</label>
                                    <input tabindex="4" type="text" name="companyState" id="companyState" class="text  tiptip" title="Enter company's state" value="">
                                </p>
                            </td>
                            <td>
                                <label>Expiration Date</label>
                                <input tabindex="24" class="text tiptip" title="Set Company Expiration Date" name="expires" id="expires" type="text" style="width: 75px; text-align: center;" value="<?php echo date('n/j') . '/' . (date('Y') + 1) ?>">
                            </td>
                            
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix">
                                    <label>Company Zip</label>
                                    <input tabindex="5" type="text" name="companyZip" id="companyZip" class="text  tiptip" title="Enter company's zip code" value="">
                                </p>
                            </td>
                            <td >
                                <p class="clearfix ifNewUser hide">
                                    <label>Email <span>*</span></label>
                                    <input tabindex="21" type="text" name="accountEmail" id="accountEmail" class="text  email tiptip" title="Enter user's email" value="">
                                </p>
                            </td>
                            
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Company Website</label>
                                    <input tabindex="7" type="text" name="companyWebsite" id="companyWebsite" class="text  tiptip" title="Enter company's website" value="">
                                </p>
                            </td>
                            <td >
                                <p class="clearfix ifNewUser hide">
                                    <label>First Name <span>*</span></label>
                                    <input tabindex="22" type="text" name="firstName" id="firstName" class="text  tiptip" title="Enter user's first name" value="">
                                </p>
                            </td>
                            
                        </tr>
                        <tr class="">
                            <td>
                                <p class="clearfix ">
                                    <label>Company Phone</label>
                                    <input tabindex="8" type="text" name="companyPhone" id="companyPhone" class="text  tiptip" title="Enter company's phone number" value="">
                                </p>
                            </td>
                            <td>
                                <p class="clearfix ifNewUser hide">
                                    <label>Last Name <span>*</span></label>
                                    <input tabindex="23" type="text" name="lastName" id="lastName" class="text  tiptip" title="Enter user's last name" value="">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Fax</label>
                                    <input tabindex="9" type="text" name="alternatePhone" id="alternatePhone" class="text  tiptip" title="Enter company's alternate phone" value="">
                                </p>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                        <tr class="">
                            <td>
                                <p class="clearfix">
                                    <label>Company Status</label>
                                    <select name="companyStatus" id="companyStatus">
                                        <option>Active</option>
                                        <option>Test</option>
                                        <option>Inactive</option>
                                    </select>
                                </p>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="even">
                            <td colspan="2">
                                <p class="clearfix">
                                    <label style="width: 100%;"><span>* = Required Field</span></label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p class="clearfix">
                                    <input tabindex="29" type="submit" value="Add" name="addNewCompany" class="btn update-button" style="float: none; margin: 0 auto; display: block;">
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {


        $( document ).on( 'focus', ':input', function(){
            $( this ).attr( 'autocomplete', 'new-password' );
        }); 
    $( "input.select2-search__field" ).attr( 'autocomplete', 'new-password' );


        $("#companyPhone").mask("999-999-9999");
        $("#alternatePhone").mask("999-999-9999");
        $("#expires").datepicker({
            dateFormat:'m/d/yy'
        });

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
                
        $(".chilCompaniesMultiple").trigger('change');


        var select_id = e.params.args.data.id;  
        $('#company_admin_id').val(select_id)
            event.preventDefault();
    });


    $('.superUserType').click(function() {
        var superUserType = $('.superUserType:checked').val();
        console.log(superUserType);
        if(superUserType == '1'){

            $('.ifOldUser').removeClass('hide');
            $('.ifNewUser').addClass('hide');

            $('#SeachaccountName').addClass('required');

            $('#firstName').removeClass('required');
            $('#accountEmail').removeClass('required');
            $('#lastName').removeClass('required');

        }else{
            $('.ifOldUser').addClass('hide');
            $('.ifNewUser').removeClass('hide');

            $('#SeachaccountName').removeClass('required');

            $('#firstName').addClass('required');
            $('#accountEmail').addClass('required');
            $('#lastName').addClass('required');
            
        }
    });




    });
</script>
<?php $this->load->view('global/footer'); ?>
