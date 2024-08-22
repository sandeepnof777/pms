<style>
    .bigdrop {
        width: 400px !important;

    }

    .bigdrop .select2-results__group {
        background: #dad9d6 !important;
    }

    .estimateFields:hover {
        color: #25AAE1;
    }

    input.parsley-error {
        color: #B94A48 !important;
        background: #F2DEDE !important;
        border: 1px solid #EED3D7 !important;
    }

    .left-bar {
        width: 33.33%;
        float: left;
    }

    .boxed-table label {
        width: 105px;
    }

    .orange {
        background: #25aae1 !important;
        color: #fff !important
    }

    /* .orange input{color:#fff!important} */
    .boxed-table5 label {
        width: 135px !important;
    }

    .field_input:focus,
    #quantity_calculation input:focus,
    #add_fees_child_item_model input:focus,
    #add_custom_child_item_model input:focus,
    #labor_model input:focus,
    #equipement_model input:focus,
    #map_model input:focus,
    #edit_template_item_values_model input:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(102, 175, 233, .6);
    }

    .serviceFieldValues22 li {
        float: left;
        width: 91%;
    }

    table.customItemsTable {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 5px;
    }

    table.customItemsTable th {
        background: #e2e2e2;
        padding: 7px;
    }

    table.subcontractItemsTable {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 5px;
    }

    table.subcontractItemsTable th {
        background: #e2e2e2;
        padding: 7px;
    }

    table.subcontractItemsTable {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 5px;
    }

    table.subcontractItemsTable th {
        background: #e2e2e2;
        padding: 7px;
    }

    table.subcontractItemsTable td {
        padding: 5px;
    }

    table.feesItemsTable {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 5px;
    }

    table.feesItemsTable th {
        background: #e2e2e2;
        padding: 7px;
    }

    table.feesItemsTable td {
        padding: 5px;
    }

    table.permitItemsTable {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        overflow: hidden;
        border-radius: 5px;
    }

    table.permitItemsTable th {
        background: #e2e2e2;
        padding: 7px;
    }

    table.permitItemsTable td {
        padding: 5px;
    }

    table.templateItemsTable {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        /* overflow: hidden; */
        border-radius: 5px;
    }

    table.templateItemsTable th {
        background: #e2e2e2;
        padding: 7px;
    }

    table.proposal_final_total_table td {
        padding: 5px;
    }

    table.proposal_final_total_table {
        text-align: right;
        font-size: 15px;
        border-collapse: collapse;
        position: absolute;
        bottom: 10px;
        right: 0;
    }

    .boxed-table td {
        border: 0px;
    }

    .show_phase_name {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .MicrosoftMap .as_container_search {
        margin-top: 27px !important;
    }

    div.selector span {
        width: 70px !important;
    }

    .cwidth2_container div.selector span {
        width: 45px !important;
    }

    .cwidth2_container div.selector {
        width: 70px !important;
    }

    .cwidth3_container div.selector span {
        width: 35px !important;
    }

    .cwidth3_container div.selector {
        width: 60px !important;
    }

    .cwidth4_container div.selector span {
        width: 124px !important;
    }

    .cwidth4_container div.selector {
        width: 150px !important;
    }

    .cwidth5_container div.selector span {
        width: 85px !important;
    }

    .cwidth5_container div.selector {
        width: 110px !important;
    }

    .cdepth2_container div.selector span {
        width: 45px !important;
    }

    .cdepth2_container div.selector {
        width: 70px !important;
    }

    div.selector {
        width: 95px !important;
    }

    input.text {
        width: 90px !important;
    }

    input.text2 {
        width: 50px !important;
    }

    input.input30 {
        width: 30px !important;
    }

    input.input45 {
        width: 45px !important;
    }

    input.input50 {
        width: 50px !important;
    }

    input.input60 {
        width: 60px !important;
        font-size: 12px
    }

    input.input22 {
        width: 22px !important;
        margin-right: 5px !important
    }

    input.input75 {
        width: 75px !important;
    }

    input.input100 {
        width: 100px !important;
    }

    input.input140 {
        width: 130px !important;
    }

    input.input135 {
        width: 135px !important;
    }

    .items_checkbox {
        display: none;
    }

    .show_overhead_and_profit {
        display: none;
    }

    .show_labor_overhead_and_profit {
        display: none;
    }

    .show_trucking_overhead_and_profit {
        display: none;
    }

    .show_sep_trucking_overhead_and_profit {
        display: none;
    }

    .show_equipement_overhead_and_profit {
        display: none;
    }

    .show_custom_overhead_and_profit {
        display: none;
    }

    .service {
        background: #fff !important
    }

    .boxed-table input.text {
        height: 15px !important;
        border-radius: 3px !important;
        border-top: solid 1px #aaa;
        border-left: solid 1px #aaa;
        border-bottom: solid 1px #ccc;
        border-right: solid 1px #ccc;
        margin-top: 2px;
        padding: 3px
    }

    .set_loader {
        position: relative;
        top: 19px;
        right: 25px;
        float: left;
    }

    .set_loader_item {
        position: relative;
        top: 19px;
        right: 87px
    }

    .phase_name {
        line-height: initial;
        width: calc(100% - 42px);
        display: inline-block;
    }

    .items_checkbox div span {
        margin-left: 5px;
        margin-top: 1px;
    }

    .input_aling_left {
        text-align: left !important;
        margin-top: 1px;
    }

    .time_type {
        float: left
    }

    li a:has(.show) {
        color: #25AAE1
    }

    .serviceFieldValues li:nth-child(odd) {
        background-color: #fafafa;
    }

    .serviceFieldValues li:nth-child(even) {
        background-color: #efefef;
    }

    .has_item_value {
        background-color: #b1e5fb !important
    }

    .has_item_value2 {
        background-color: #b1e5fb !important
    }

    .has_value_changed {
        background-color: #ffeb91 !important
    }

    #service_html_box {
        width: 100%;
        float: left;
    }

    #service_html_box ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    #service_html_box2 {
        width: 100%;
        float: left;
    }

    #service_html_box2 ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    #service_html_box3 {
        width: 100%;
        float: left;
    }

    #service_html_box3 ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    #service_html_box4 {
        width: 100%;
        float: left;
    }

    #service_html_box4 ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    #service_html_box5 {
        width: 100%;
        float: left;
    }

    #service_html_box5 ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    #service_html_box6 {
        width: 100%;
        float: left;
    }

    #service_html_box6 ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    #service_html_box7 {
        width: 100%;
        float: left;
    }

    #service_html_box7 ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    #service_html_box8 {
        width: 100%;
        float: left;
    }

    #service_html_box8 ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    #service_html_box9 {
        width: 100%;
        float: left;
    }

    #service_html_box9 ul li {
        list-style: none;
        line-height: 38px;
        padding: 0px 5px;
    }

    .ui-dialog .ui-dialog-title {
        float: none;
        margin: 0;
        text-align: center;
        display: inline-block;
        width: 100%;
    }

    #proposalServicesContainer h4 {
        text-align: center;
    }

    .calculator_service_title {
        float: left;
        width: 44%;
        text-align: left;
    }

    .dialog_title {
        text-align: left;
        margin: 0px auto;
        display: inline-block;
        width: 40%;
    }

    .full-width {
        width: 100% !important;
        float: left !important;
    }

    #page_load_message {
        border: 1px solid #cccccc;
        border-radius: 5px;
        min-height: 350px;
        text-align: center;
    }

    #page_loading {
        border: 1px solid #cccccc;
        border-radius: 5px;
        height: 300px;
        text-align: center;
    }

    .est_checked_hide {
        color: transparent !important;
    }

    .phase_checked_hide {
        color: transparent !important;
    }

    /* .phase_checked{position: absolute;margin-top: 3px;left: 200px;} */
    .pad0 {
        padding: 0px !important;
    }

    .unit_price_td {
        text-align: right;
        padding-right: 30px !important;
    }

    .items_checkbox {
        display: none
    }

    .deleteLineItem {
        display: none;
    }

    .estimate_item_notes {
        display: none;
    }

    .templateActionsColumn .dropdownButton {
        display: none !important;
    }

    .has_item_value .templateActionsColumn .dropdownButton {
        display: inline-table !important
    }

    .has_item_value .estimate_item_notes {
        display: inline-table !important
    }

    .template_items_checkbox {
        display: none
    }

    .template_deleteLineItem {
        display: none;
    }

    .has_item_value .items_checkbox {
        display: inline !important
    }

    .has_item_value .deleteLineItem {
        display: inline-table !important;
    }

    .has_value_changed .items_checkbox {
        display: none !important
    }

    .has_value_changed .deleteLineItem {
        display: none !important
    }

    .has_item_value .template_items_checkbox {
        display: inline !important
    }

    .has_item_value .template_deleteLineItem {
        display: inline-table !important;
    }

    .has_value_changed .template_items_checkbox {
        display: none !important
    }

    .has_value_changed .template_deleteLineItem {
        display: none !important
    }

    .after_input {
        position: relative;
    }

    .after_input2 {
        padding: 6px;
        padding-left: 0px;
        display: inline-block;
    }

    .after_input3 {
        padding-top: 6px;
        display: inline-block;
    }

    .cal_total_price {
        font-weight: bold;
    }

    ;

    .label135 {
        width: 135px !important;
    }

    .input75 {
        width: 75px !important;
    }

    .if_trucking_check {
        display: none;
    }

    .if_trucking_check2 {
        display: none;
    }

    .show_map {
        display: none;
    }

    .sep_show_map {
        display: none;
    }

    .cust_textarea {
        width: 110px;
        height: 60px
    }

    .truck_cal_span {
        float: left;
        margin-left: 17px;
        margin-top: 6px;
    }

    .one-box {
        width: 100%;
        float: left;
    }

    .job_site_addr {
        text-align: center;
        font-weight: 100;
    }

    .job_site_addr span {
        font-weight: bold;
        color: #000;
    }

    .info_tip {
        font-size: 17px;
        float: right;
        margin-right: 2px;
        margin-top: 5px;
        display: none;
    }

    .info_tip2 {
        font-size: 17px;
        float: left;
        margin-right: 5px;
        margin-top: 3px;
        display: none;
    }

    .tr_info_tip:hover .info_tip {
        display: inline-block !important;
    }

    .tr_info_tip2 .info_tip2 {
        display: inline-block !important;
    }

    #sep_printoutPanel {
        width: 373px;
        float: left;
        height: 500px;
        overflow: scroll;
    }

    .if_ast_change {
        display: none;
    }

    .asp_span {
        margin-top: 7px;
        position: absolute;
    }

    .hide_input_style {
        box-shadow: none;
        border: 0px;
        background: transparent;
        margin-top: 5px;
    }

    .hide_input_style2 {
        box-shadow: none;
        border: 0px;
        background: transparent;
    }

    .hide_input_style3 {
        box-shadow: none;
        border: 0px;
        background: transparent;
        margin-top: 5px;
        margin-right: 20px;
    }

    .hide_select_style {
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .hide_select_style:focus {
        outline: none;
    }

    .hide_input_style:focus {
        outline: none;
    }

    .hide_input_style2:focus {
        outline: none;
    }

    .select_width div.selector span {
        width: 155px !important;
    }

    .select_width div.selector {
        width: 180px !important;
    }

    .sortable-phase li {
        padding: 0px !important;
        line-height: 34px;
        float: left;
        width: 98%;
        border-left: 5px solid transparent
    }

    .stripping-row tr:nth-child(even) {
        background-color: #efefef !important;
    }

    .stripping-row tr:nth-child(odd) {
        background-color: #fafafa !important;
    }

    /* .selected_phase span .handle{color:#fff!important;} */
    .handle {
        background: transparent !important;
        margin: 0px 0px 0px 2px !important;
        display: inline-flex;
    }

    .printoutpanel {
        display: none;
        width: 373px;
        float: left;
        max-height: 500px;
        overflow: scroll;
    }

    .add_phase_input_li {
        display: none;
        float: left;
        width: 94%;
    }

    .selected_phase {
        border-color: #25AAE1 !important;
        font-weight: bold;
    }

    .select_box_error {
        border-radius: 2px;
        border: 1px solid #e47074 !important;
        background-color: #ffedad !important;
        box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
        -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
    }

    .select2_box_error {
        padding: 2px;
        border-radius: 2px;
        border: 1px solid #e47074 !important;
        background-color: #ffedad !important;
        box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
        -moz-box-shadow: 0 0 2px rgba(159, 0, 6, 0.3) inset;
    }

    .if_child_trucking_check,
    .if_child_labor_check,
    .if_child_custom_check,
    .if_child_fees_check,
    .if_child_permit_check,
    .if_child_equipment_check,
    .if_child_parent_total,
    .if_child_default_check {
        display: none
    }

    .if_child_trucking_check_tax,
    .if_child_labor_check_tax,
    .if_child_custom_check_tax,
    .if_child_fees_check_tax,
    .if_child_permit_check_tax,
    .if_child_equipment_check_tax,
    .if_child_material_check_tax {
        display: none
    }

    .child_table_item_name {
        text-align: left !important;
        padding-left: 20px !important;
    }

    .child_table_total_price {
        text-align: right !important;
        padding-right: 20px !important;
        font-weight: bold
    }




    .input-group-button {
        padding: 0 2px;
    }

    .quantity22::-webkit-inner-spin-button,
    .quantity22::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .quantity22 {
        text-align: center;
    }

    .content-box {
        margin-bottom: 10px !important
    }

    .tiptip {
        border-bottom: 0px !important
    }

    .hide_calculator {
        display: none
    }

    .hide_delete_btn {
        display: none
    }

    .custom_line_item_total_price {
        font-weight: bold
    }

    .total-price {
        font-weight: bold
    }

    .fa-exclamation-triangle2 {
        margin-right: 5px;
        position: relative;
        top: 1px;
    }


    .parent_updated .fa-exclamation-triangle2:before {
        content: "\f071";
    }

    .parent_updated td {
        background-color: #fff46c !important;
    }

    .text-active-color:has(> a.service_child_flag:visible) {
        background-color: #ff8b28 !important;
    }

    .locked_tr:not(.has_item_value) {
        display: none;
    }

    .item_has_template {
        background-color: #FBF6B2 !important;
    }

    .child_icons_active {
        background-color: #a6d7ea !important;
        float: left;
        border: 1px solid #999;
        border-radius: 3px;
    }

    tr.item_has_template .items_checkbox,
    tr.item_has_template .open_calculator,
    tr.item_has_template .estimate_item_notes,
    tr.item_has_template .deleteLineItem {
        display: none !important;
    }

    select.select_template_option {
        position: relative;
        top: 7px;
        height: 25px;
        margin-left: 10px;
        border-radius: 3px;
    }

    select.select_template_option option {
        text-indent: 3px;
    }

    .ui-dialog-title {
        float: left !important;
        display: block !important;
        text-align: left !important;
        font-size: 16px;
    }

    .child_check_icon:hover {
        background-color: #bbbbbb;
        border-radius: 2px;
    }

    .child_checkbox_pad .DataTables_sort_wrapper {
        padding: 0px !important
    }

    .ui-menu-item a.ui-state-focus {
        background: #D6ECF6;
        border: 0px;
        font-weight: 200;
        border-radius: 0px;
    }

    .ui-menu {
        max-height: 300px;
        overflow-y: auto;
    }

    .reduce_opacity:not(.text-active-color):not(.text-active-color2) {
        opacity: 0.4 !important;
    }

    .superScriptT {
        font-size: 11px;
        color: #444444;
        padding: 2px 7px;
        border: 1px solid #888888;
        border-radius: 7px;
        background: #FFFFFF;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
    }

    .if_edit_item_total_price {
        display: none;
    }

    .if_edit_item_unit_price {
        display: none;
    }

    .table_row_negative_price {
        color: red !important;
    }

    table.templateEmptyItemsTable {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
        border-radius: 5px;
    }

    table.templateEmptyItemsTable th {
        background: #e2e2e2;
        padding: 7px;
    }

    table.templateEmptyItemsTable td {
        text-align: center;
    }
</style>
<?php
$plantInfo = [];
foreach ($plants as $plant) :
    if ($plant->getLat() != '0.00000000' && $plant->getLng() != '0.00000000') {


        $plantInfoObj = new stdClass();
        $plantInfoObj->id = $plant->getId();
        $plantInfoObj->plant_name = $plant->getName();
        $plantInfoObj->company_name = $plant->getCompanyName();
        $plantInfoObj->address = $plant->getAddress();
        $plantInfoObj->city = $plant->getCity();
        $plantInfoObj->state = $plant->getState();
        $plantInfoObj->zip = $plant->getZip();
        $plantInfoObj->phone = ($plant->getPhone()) ? $plant->getPhone() : '';
        $plantInfoObj->lat = $plant->getLat();
        $plantInfoObj->lng = $plant->getLng();
        $plantInfoObj->type = 'plant';


        $plantInfo[] = $plantInfoObj;
    }
endforeach;

$dumpInfo = [];
foreach ($dumps as $dump) :
    if ($dump->getLat() != '0.00000000' && $dump->getLng() != '0.00000000') {


        $dumpInfoObj = new stdClass();
        $dumpInfoObj->id = $dump->getId();
        $dumpInfoObj->plant_name = $dump->getName();
        $dumpInfoObj->company_name = $dump->getCompanyName();
        $dumpInfoObj->address = $dump->getAddress();
        $dumpInfoObj->city = $dump->getCity();
        $dumpInfoObj->state = $dump->getState();
        $dumpInfoObj->zip = $dump->getZip();
        $dumpInfoObj->phone = ($dump->getPhone()) ? $dump->getPhone() : '';
        $dumpInfoObj->lat = $dump->getLat();
        $dumpInfoObj->lng = $dump->getLng();
        $dumpInfoObj->type = 'dump';
        number_format(1000.5, 2, '.', '');

        $dumpInfo[] = $dumpInfoObj;
    }
endforeach;
?>
<div id="categoryTabs" style="display:none;margin-left:5px;float: left;width:100%">
    <ul>
        <!-- <li><a href="#estimateTab">Estimator</a></li> -->
        <li><a href="#summaryTab">Phase Items</a></li>
        <!-- <li ><a href="#previewTab"><i class="fa fa-fw fa-file-text-o"></i></a></li> -->
        <!--<li style="float: right;"><a href="#estimateTab">Items</a></li>-->
        <?php

        foreach ($categories as $category) : ?>
            <li><a class="cate_tabs" href="#categoryTab<?php echo $category->getId(); ?>"><i class="fa fa-exclamation-triangle category_child_flag tiptip category_child_has_updated_flag_<?php echo $category->getId(); ?>" style="margin-right: 2px; display:none;" title="This category has items that need to be checked"></i><?php echo $category->getName(); ?> [<span class="cat_service_count<?php echo $category->getId(); ?> tiptip" title=""></span>] </a></li>
        <?php endforeach; ?>
        <li><a href="#templatesTab">Assemblies [<span class="template_active_table_count"></span>]</a></li>

    </ul>
    <!-- <div id="previewTab" class="materialized" style="height: 600px;">
        
    </div> -->

    <div id="summaryTab" style="overflow:auto; -webkit-overflow-scrolling: touch; padding: 5px;">
        <div id="serviceItemsSummaryContent"></div>
        <div class="clearfix"></div>
    </div>


    <?php foreach ($categories as $category) : ?>
        <div id="categoryTab<?php echo $category->getId(); ?>" style="padding:1em 3px;">

            <div class="accordionContainer">

                <?php if (count($sortedTypes[$category->getid()]) && ($category->getId() != $customCategoryId)) : ?>
                    <?php foreach ($sortedTypes[$category->getid()] as $categoryType) : ?>

                        <h3 class="accordionHeader" id="typeHeading<?php echo $categoryType->getId(); ?>" data-type-id="<?php echo $categoryType->getId() ?>"><i class="fa fa-exclamation-triangle tiptip table_child_flag table_child_has_updated_flag_<?php echo $categoryType->getId(); ?>" style="margin-right: 2px;display:none" title="This type has items that need to be checked"></i>
                            <?php echo $categoryType->getName(); ?> [<span id="heading_span_<?= $categoryType->getId(); ?>"><?php echo count($sortedItems[$category->getId()][$categoryType->getId()]) ?></span>]
                            <span style="float:right">
                                <a href="javascript:void(0);" style="display:none; float:left; bottom:4px;" class="delete_estimate_items btn blue-button" onclick="delete_estimated_items(event,this);" id="delete_btn_<?php echo $categoryType->getId(); ?>">
                                    <i class="fa fa-fw fa-trash"></i> Delete
                                </a>
                                <!-- <a href="javascript:void(0);" class="addToEstimate btn blue-button" onclick="save_estimation_table(event,this);"  style="float:right;margin-bottom:2px;" id="save_btn_<?php echo $categoryType->getId(); ?>">
                                                    <i class="fa fa-fw fa-plus"></i> Save
                                                </a> -->
                                <span style="margin-right: 10px;" class="table_total_<?php echo $categoryType->getId(); ?>"><span>
                                    </span>
                        </h3>
                        <div style="padding:2px 3px !important;">

                            <?php if (count($sortedItems[$category->getId()][$categoryType->getId()])) : ?>
                                <table id="itemsType<?php echo $categoryType->getId(); ?>" class="estimatingItemsTable" style="text-align:center">
                                    <thead>
                                        <tr>
                                            <th width="3%"></th>
                                            <th width="6%"></th>
                                            <th width="2%"></th>
                                            <th width="2%"></th>
                                            <th width="25%">Item</th>
                                            <th width="12%">Unit Price</th>
                                            <th width="19%">Qty</th>
                                            <th width="15%">Total Price</th>
                                            <th width="16%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($sortedItems[$category->getId()][$categoryType->getId()] as $typeItem) : ?>
                                            <tr id="items_<?php echo $typeItem->getId(); ?>" class="<?php if ($proposal_status_id == 5) {
                                                                                                        echo 'locked_tr';
                                                                                                    } ?>" style="border-bottom: 1px solid #ffffff;">
                                                <td><span class="items_checkbox">
                                                        <?php if ($proposal_status_id != 5) { ?>
                                                            <input type="checkbox" class="item_delete_checkbox" name="checkbox_name_<?php echo $categoryType->getId(); ?>" value="" id="items_checkbox_<?php echo $typeItem->getId(); ?>" />
                                                        <?php } ?>
                                                    </span></td>
                                                <td>
                                                    <?php //if($proposal_status_id !=5){
                                                    ?>

                                                    <a class="btn tiptip open_calculator" title="Calculate Quantity" data-item-id="<?php

                             echo $typeItem->getId(); ?>" data-estimate-line-id="" data-template-type-id="" data-templates='<?php echo $typeItem->getTemplates($company_id); ?>' data-unit-id="<?php echo $typeItem->getUnit(); ?>" data-unit-type-id="<?php echo $typeItem->getUnitModel()->getUnitType(); ?>" data-unit-name="<?php echo $typeItem->getUnitModel()->getName(); ?>" data-unit-single-name="<?= $typeItem->getUnitModel()->getSingleName() ?>" data-category-id="<?php echo $category->getId() ?>" data-type-id="<?php echo $categoryType->getId() ?>" data-item-name="<?php echo $typeItem->getName() ?>" data-item-unit-price="<?php echo $typeItem->getUnitPrice() ?>" data-item-base-price="<?php echo $typeItem->getBasePrice() ?>" data-item-taxable="<?php echo $typeItem->getTaxable(); ?>" data-item-tax-rate="<?php echo $typeItem->getTaxRate(); ?>" data-category-name="<?php echo $category->getName(); ?>" data-type-name="<?php echo $typeItem->getType()->getName(); ?>" data-item-capacity="<?php echo $typeItem->getCapacity(); ?>" data-item-minimum-hours="<?php echo $typeItem->getMinimumHours(); ?>" data-item-overhead-rate="<?php echo $typeItem->getOverheadRate(); ?>" data-item-profit-rate="<?php echo $typeItem->getProfitRate(); ?>" data-custom-total-price="" data-custom-unit-price="" data-item-total-price="" data-edited-base-price="" data-edited-unit-price="" data-edited-total-price="">
                                                        <i class="fa fa-fw fa-calculator"></i>
                                                    </a>

                                                    <?php //}
                                                    ?>
                                                </td>
                                                <td>
                                                    <i class="fa fa-exclamation-triangle child_has_updated_flag tiptip" style="margin-right: 2px;display:none" title="This item has items that need to be checked"></i>
                                                    <i class="fa fa-exclamation-triangle item_has_nagetive_flag tiptip" style="margin-right: 2px;display:none" title="This item is priced below cost"></i>
                                                </td>
                                                <td><i class="fa fa-info-circle item_added_template tiptip" style="margin-right: 2px;display:none" title=""></i></td>

                                                <td style="text-align:left"><?php echo $typeItem->getName(); ?></td>
                                                <td class="unit_price_td">
                                                    <input type="text" class="text currency_field unit-price" style="width: 80px;display:none" value="$<?php echo number_format($typeItem->getUnitPrice(), 2); ?>" />
                                                    <span class="span_unit_price1">$<?php echo number_format($typeItem->getUnitPrice(), 2); ?></span><span class="edited_unit_price_flag"></span>
                                                </td>

                                                <td style="text-align: right;">
                                                    <!-- <input type="text" class="text number_field quantity" id="number-mask1" style="width: 60px" value="0" />-->
                                                    <span class="quantity">0</span>
                                                    <?php echo $typeItem->getUnitModel()->getAbbr(); ?>
                                                </td>

                                                <td style="text-align: right;">
                                                    $<span class="total-price" /></span>

                                                </td>
                                                <td style="text-align:right">
                                                    <div class="set_loader_item">
                                                        <div class="cssloader" style="display: none;">loading</div>
                                                    </div>
                                                    <span class="show_child_icon tiptipleft" style="display:none;" title="This item has child items"><i class="fa fa-fw fa-window-restore"></i></span>
                                                    <?php if ($typeItem->getId()) { ?>
                                                        <?php if ($proposal_status_id != 5) { ?>
                                                            <a href="JavaScript:void(0);" class="estimate_item_notes btn tiptipleft" title="Notes"><i class="fa fa-clipboard"></i></a>
                                                            <a href="JavaScript:void(0);" class="deleteLineItem btn tiptipleft" title="Remove From Estimate" data-estimate-line-id="">
                                                                <i class="fa fa-fw fa-trash"></i>
                                                            </a>
                                                    <?php }
                                                    } ?>

                                                    <a href="javascript:void(0);" class="btn blue-button tiptipleft save_est_btn" title="Save Estimate" onclick="save_estimation_table(event,this,0);" style="margin-bottom:2px; display:none">Save</a>
                                                    <a href="JavaScript:void(0);" class="undo_item_line btn tiptipleft" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a>
                                                    <a href="JavaScript:void(0);" class="reset_item_line btn tiptipleft" title="Clear Item" style="display:none;"><i class="fa fa-fw fa-minus-circle"></i></a>

                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>


                            <?php else : ?>
                                <?php if ($categoryType->getId() == 30) { ?>
                                    <table id="subcontract_item_table" class="subcontractItemsTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Item</th>
                                                <th>Unit Price</th>
                                                <th>Qty</th>
                                                <th>Total Price</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <?php if ($proposal_status_id != 5) { ?>
                                        <a class="addSubcontractorsItem btn blue-button" data-type-id="<?php echo $categoryType->getId() ?>" style="float: right; margin-top: 10px;">
                                            Add Item
                                        </a>
                                    <?php } ?>
                                    <div class="clearfix"></div>
                                <?php } else if ($categoryType->getId() == 41) { ?>
                                    <table id="fees_item_table" class="feesItemsTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Item</th>
                                                <th>Unit Price</th>
                                                <th>Qty</th>

                                                <th>Total Price</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <?php if ($proposal_status_id != 5) { ?>
                                        <a class="addCustomItem btn blue-button" data-type-id="<?php echo $categoryType->getId() ?>" data-type-name="fees" style="float: right; margin-top: 10px;">
                                            Add Item
                                        </a>
                                    <?php } ?>
                                    <div class="clearfix"></div>

                                <?php } else if ($categoryType->getId() == 40) { ?>
                                    <table id="permit_item_table" class="permitItemsTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Item</th>
                                                <th>Unit Price</th>
                                                <th>Qty</th>

                                                <th>Total Price</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <?php if ($proposal_status_id != 5) { ?>
                                        <a class="addCustomItem btn blue-button" data-type-id="<?php echo $categoryType->getId() ?>" data-type-name="permit" style="float: right; margin-top: 10px;">
                                            Add Item
                                        </a>
                                    <?php } ?>
                                    <div class="clearfix"></div>

                                <?php } else { ?>
                                    <p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i> There are no items in this category</p>
                                <?php } ?>

                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php if ($category->getId() != $customCategoryId) : ?>
                        <p>There are no types in this category!</p>
                    <?php endif; ?>
                <?php endif ?>
                <?php if ($category->getId() == $customCategoryId) : ?>

                    <h3 class="accordionHeader" id="typeHeading0"
                        data-type-id="0" >
                        Custom Items [<span id="custom_heading_span"></span>]
                        <span style="float:right">
                            <a href="javascript:void(0);" style="display:none; float:left; bottom:4px;" class="delete_custom_estimate_items btn blue-button" onclick="delete_custom_estimated_items(event,this);">
                                <i class="fa fa-fw fa-trash"></i> Delete
                            </a>
                            <!-- <a href="javascript:void(0);" class="addToEstimate btn blue-button" onclick="save_estimation_table(event,this);"  style="float:right;margin-bottom:2px;" id="save_btn_<?php echo $categoryType->getId(); ?>">
                                                    <i class="fa fa-fw fa-plus"></i> Save
                                                </a> -->
                            <span style="margin-right: 10px;" class="custom_table_total"><span>
                                </span>
                    </h3>
                    <div>

                        <table id="custom_item_table" class="customItemsTable" style="display:none">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Item</th>
                                    <th>Unit Price</th>
                                    <th>Qty</th>

                                    <th>Total Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <?php if ($proposal_status_id != 5) { ?>
                            <a class="addCustomItem btn blue-button" data-type-id="<?php echo $categoryType->getId() ?>" data-type-name="custom" style="float: right; margin-top: 10px;">
                                Add Custom Item
                            </a>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div id="templatesTab" style="padding: 1em 3px;">
        <div class="accordionContainer2">
            <?php foreach ($templates as $template) : ?>

                <?php if ($template['template']->getIsEmpty() == 1 || count($template['items']) > 0) { ?>
                    <h3 class="accordionHeader" id="templateHeading<?php echo $template['template']->getId(); ?>" data-old-template-rate="<?php echo $template['template']->getPriceRate(); ?>" data-template-rate="<?php echo $template['template']->getPriceRate(); ?>" data-template-id="<?php echo $template['template']->getId() ?>" data-template-name="<?php echo $template['template']->getName() ?>" data-template-type="<?php echo $template['template']->getCalculationType() ?>" data-template-fixed="<?php echo $template['template']->getFixed() ?>">


                        <?php
                        if ($template['template']->getFixed()) { ?>
                            <span class="superScriptT tiptip" title="Fixed Rate Assembly">FR</span><?php if ($template['template']->getIsEmpty()) { ?> <span class="superScriptT tiptip" title="Empty Assembly">E</span> <?php } ?> <?php echo $template['template']->getName(); ?><span class=""><?php echo ' [ $<span class="fixed_template_rate">' . number_format(floatval($template['template']->getPriceRate())) . '</span>';
                                                                                                                                                                                                                                                                                                echo ($template['template']->getCalculationType() == 1) ? ' / Day ]' : ' / Hour ]'; ?></span>
                        <?php } else {
                            echo $template['template']->getName();
                        } ?>

                        <!-- <span class="template_table_item_<?php echo  $template['template']->getId(); ?>"></span> -->

                        <span style="float:right;">
                            <?php if ($template['template']->getFixed()) { ?>
                                <a href="javascript:void(0);" style="display:none;float: left; bottom: 3px;width:100px" class="edit_estimate_items_price btn blue-button" onclick="edit_template_price(event,this);" id="edit_price_btn_<?php echo $template['template']->getId() ?>">
                                    <i class="fa fa-fw fa-pencil"></i> Edit Price
                                </a>
                            <?php } else { ?>
                                <a href="javascript:void(0);" style="display:none;float: left; bottom: 3px;width:100px" class="edit_template_total_price btn blue-button" onclick="edit_template_total_price(event,this);" id="edit_price_btn_<?php echo $template['template']->getId() ?>">
                                    <i class="fa fa-fw fa-pencil"></i> Edit Price
                                </a>

                            <?php } ?>
                            <a href="javascript:void(0);" style="display:none;float: left; bottom: 3px;width:50px" class="delete_template_items btn blue-button" onclick="delete_template_all_items(event,this);" id="delete_all_items_btn_<?php echo $template['template']->getId() ?>">
                                <i class="fa fa-fw fa-trash"></i>
                            </a>
                            <a href="javascript:void(0);" style="display:none;float: left; bottom: 3px;width:100px" class="edit_estimate_items btn blue-button" onclick="edit_templates_items_value(event,this);" id="edit_value_btn_<?php echo $template['template']->getId() ?>">
                                <i class="fa fa-fw fa-pencil"></i> Edit value
                            </a>
                            <a href="javascript:void(0);" style="display:none;float: left; bottom: 3px;" class="delete_estimate_items btn blue-button" onclick="delete_templates_items(event,this);" id="delete_btn_<?php echo $template['template']->getId() ?>">
                                <i class="fa fa-fw fa-trash"></i> Delete
                            </a>
                            <a href="javascript:void(0);" style="float: left; bottom: 3px;padding:0px" class="next_estimate_items btn blue-button" <?php if ($template['template']->getFixed()) { ?> onclick="next_fixed_templates_items(event,this);" <?php } else { ?> onclick="next_templates_items(event,this);" <?php } ?> id="next_btn_<?php echo $template['template']->getId() ?>">
                                Next <i class="fa fa-fw fa-chevron-right"></i>
                            </a>
                            <span style="margin-right: 10px;" class="template_table_total_<?php echo  $template['template']->getId(); ?>"><span>
                                </span>
                    </h3>
                    <div style="padding-right: 3px !important;padding-left: 3px !important;overflow: visible;">
                        <?php if ($template['template']->getFixed()) {

                        ?>
                            <p class="templateInfoMsg">
                                <?php if (!$template['template']->getIsEmpty()) { ?>
                                    <span class="adminInfoMessage " style="width:50%;float:left"><i class="fa fa-fw fa-info-circle"></i> Individual Assembly items can be deleted.</span>
                                <?php } ?>
                                <span style="float: right;padding: 15px 0px;"><b>Days: </b> <span style="margin-right: 20px;" id="fixed_template_total_day_<?php echo  $template['template']->getId(); ?>"></span><b>Hours / Day: </b><span style="margin-right: 20px;" id="fixed_template_total_hpd_<?php echo  $template['template']->getId(); ?>"></span> <?php if ($template['template']->getCalculationType() == 2) { ?><b>Total Hours: </b><span id="fixed_template_total_hours_<?php echo  $template['template']->getId(); ?>"></span><?php } ?> <a class="btn tiptip " id="template_value_edit<?php echo $template['template']->getId(); ?>" title="Calculate" data-template-rate="<?php echo $template['template']->getPriceRate(); ?>" data-template-id="<?php echo $template['template']->getId() ?>" data-template-name="<?php echo $template['template']->getName() ?>" data-template-type="<?php echo $template['template']->getCalculationType() ?>" data-template-fixed="<?php echo $template['template']->getFixed() ?>" onclick="edit_fixed_templates_values(event,this);" style="margin-left: 10px;"> <i class="fa fa-fw fa-calculator"></i></a> </span>
                            </p>
                        <?php  } else { ?><p class="adminInfoMessage templateInfoMsg"><i class="fa fa-fw fa-info-circle"></i> Individual Assembly items can be deleted.</p> <?php } ?>

                        <?php if ($template['template']->getIsEmpty()) { ?>
                            <table id="template_itemsType<?php echo $template['template']->getId(); ?>" data-template-id="<?php echo $template['template']->getId(); ?>" data-empty-template="1" class="templateItemsTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Rate</th>
                                        <th class="templateEmptyDayColumn">Days</th>
                                        <th class="templateEmptyHrsColumn">Hrs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="template_items_<?php echo $template['template']->getId(); ?>_0">
                                        <td><?php echo $template['template']->getName(); ?></td>
                                        <td><span><?php echo '$<span class="fixed_template_rate">' . number_format(floatval($template['template']->getPriceRate())) . '</span>';
                                                    echo ($template['template']->getCalculationType() == 1) ? ' Per Day ' : ' Per Hour '; ?></span></td>
                                        <td class="templateEmptyDayColumn">-</td>
                                        <td class="templateEmptyHrsColumn">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <table id="template_itemsType<?php echo $template['template']->getId(); ?>" data-template-id="<?php echo $template['template']->getId(); ?>" class="templateItemsTable">
                                <thead>
                                    <tr>
                                        <th class="templateCheckColumn check_save_template_items">
                                            <input type="checkbox" name="master_template_checkbox_name" value="<?php echo $template['template']->getId(); ?>" id="master_template_items_checkbox" class="master_template_items_checkbox" />
                                        </th>
                                        <th class="templateCalculatorColumn check_save_template_items"></th>
                                        <th class="templateCategoryColumn">Category</th>
                                        <th class="templateTypeColumn">Type</th>
                                        <th class="templateItemColumn">Item</th>


                                        <?php if ($template['template']->getFixed()) { ?>
                                            <th class="templateQtyColumn">Qty</th>
                                            <th class="templateDefaultDaysColumn">Days</th>
                                            <th class="templateDefaultNumColumn">#</th>
                                            <th class="templateDefaultHoursColumn">Hrs</th>
                                        <?php } else { ?>
                                            <th class="templateUnitPriceColumn">Unit Price</th>
                                            <th class="templateQtyColumn">Qty</th>
                                            <th class="templateTotalPriceColumn">Total Price</th>
                                            <th class="templateDefaultDaysColumn">Days</th>
                                            <th class="templateDefaultNumColumn">#</th>
                                            <th class="templateDefaultHoursColumn">Hrs</th>

                                        <?php } ?>

                                        <th class="templateActionsColumn"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($template['items'] as $typeItem) :
                                        $templateId = $template['template']->getId();
                                        $defaults = $typeItem->$templateId;
                                        //print_r($t['default_days']);
                                    ?>
                                        <tr id="template_items_<?php echo $template['template']->getId(); ?>_<?php echo $typeItem->getId(); ?>" class="<?php if ($proposal_status_id == 5) {
                                                                                                                                                            echo 'locked_tr';
                                                                                                                                                        } ?>" style="border-bottom: 1px solid #ffffff;">
                                            <td class="templateCheckColumn check_save_template_items"><span class="template_items_checkbox">
                                                    <?php if ($proposal_status_id != 5) { ?>
                                                        <input type="checkbox" class="template_item_delete_checkbox" name="template_checkbox_name_<?php echo $template['template']->getId(); ?>" value="" id="template_items_checkbox_<?php echo $typeItem->getId(); ?>" />
                                                    <?php } ?>
                                                </span></td>
                                            <td class="templateCalculatorColumn check_save_template_items">
                                                <?php //if($proposal_status_id !=5){
                                                ?>
                                                <i class="fa fa-exclamation-triangle child_has_updated_flag tiptip" style="margin-right: 2px;display:none" title="This item has items that need to be checked"></i>
                                                <!-- <i class="fa fa-exclamation-triangle item_has_nagetive_flag tiptip" style="margin-right: 2px;display:none" title="This item is priced below cost"></i> -->
                                                <a class="btn tiptip open_calculator" title="Calculate Quantity" data-item-id="<?php echo $typeItem->getId(); ?>" data-estimate-line-id="" data-templates='<?php echo $typeItem->getTemplates($company_id); ?>' data-unit-id="<?php echo $typeItem->getUnit(); ?>" data-unit-type-id="<?php echo $typeItem->getUnitModel()->getUnitType(); ?>" data-unit-name="<?php echo $typeItem->getUnitModel()->getName(); ?>" data-unit-single-name="<?= $typeItem->getUnitModel()->getSingleName() ?>" data-category-id="<?php echo $category->getId() ?>" data-type-id="<?php echo $typeItem->getType()->getId() ?>" data-item-name="<?php echo $typeItem->getName() ?>" data-item-unit-price="<?php echo $typeItem->getUnitPrice() ?>" data-item-base-price="<?php echo $typeItem->getBasePrice() ?>" data-item-taxable="<?php echo $typeItem->getTaxable(); ?>" data-item-tax-rate="<?php echo $typeItem->getTaxRate(); ?>" data-category-name="<?php echo $typeItem->categoryName; ?>" data-type-name="<?php echo $typeItem->getType()->getName(); ?>" data-item-capacity="<?php echo $typeItem->getCapacity(); ?>" data-item-overhead-rate="<?php echo $typeItem->getOverheadRate(); ?>" data-item-profit-rate="<?php echo $typeItem->getProfitRate(); ?>" data-template-item-default-days="<?php echo $defaults['default_days']; ?>" data-template-item-default-qty="<?php echo $defaults['default_qty']; ?>" data-template-item-default-hpd="<?php echo $defaults['default_hpd']; ?>" data-template-type-id="<?php echo $template['template']->getId(); ?>" data-custom-total-price="" data-item-total-price="">
                                                    <i class="fa fa-fw fa-calculator"></i>
                                                </a>
                                                <?php //}
                                                ?>
                                            </td>
                                            <td class="templateCategoryColumn"><?php echo $typeItem->categoryName; ?></td>
                                            <td class="templateTypeColumn"><?php echo $typeItem->getType()->getName(); ?></td>
                                            <td class="templateItemColumn"><?php echo $typeItem->getName(); ?></td>


                                            <?php if ($template['template']->getFixed()) { ?>
                                                <td class="templateQtyColumn" style="text-align: center;">
                                                    <!-- <input type="text" class="text number_field quantity" id="number-mask1" style="width: 60px" value="0" />-->
                                                    <input type="text" class="text currency_field unit-price" style="width: 80px;display:none" value="$<?php echo number_format($typeItem->getUnitPrice(), 2); ?>" />
                                                    <span class="quantity">0</span>
                                                    <?php echo $typeItem->getUnitModel()->getName(); ?>
                                                </td>
                                                <td class="templateDefaultDaysColumn" style="text-align: center;"><span class="default_days"><?php echo $defaults['default_days']; ?></span></td>
                                                <td class="templateDefaultNumColumn" style="text-align: center;"><span class="default_qty"><?php echo $defaults['default_qty']; ?></span></td>
                                                <td class="templateDefaultHoursColumn" style="text-align: center;"><span class="default_hpd"><?php echo ((int) $defaults['default_hpd']) + 0; ?></span></td>
                                            <?php } else { ?>
                                                <td class="unit_price_td templateUnitPriceColumn">
                                                    <input type="text" class="text currency_field unit-price" style="width: 80px;display:none" value="$<?php echo number_format($typeItem->getUnitPrice(), 2); ?>" />
                                                    <span class="span_unit_price1">$<?php echo number_format($typeItem->getUnitPrice(), 2); ?></span>
                                                </td>
                                                <td class="templateQtyColumn" style="text-align: center;">
                                                    <!-- <input type="text" class="text number_field quantity" id="number-mask1" style="width: 60px" value="0" />-->
                                                    <span class="quantity">0</span>
                                                    <?php echo $typeItem->getUnitModel()->getName(); ?>
                                                </td>
                                                <td class="templateTotalPriceColumn" style="text-align: right;">$<span class="total-price"></span></td>
                                                <td class="templateDefaultDaysColumn" style="text-align: center;"><span class="default_days"><?php echo $defaults['default_days']; ?></span></td>
                                                <td class="templateDefaultNumColumn" style="text-align: center;"><span class="default_qty"><?php echo $defaults['default_qty']; ?></span></td>
                                                <td class="templateDefaultHoursColumn" style="text-align: center;"><span class="default_hpd"><?php echo ((int) $defaults['default_hpd']) + 0; ?></span></td>

                                            <?php } ?>

                                            <td class="templateActionsColumn" style="text-align:right">
                                                <div class="set_loader_item">
                                                    <div class="cssloader" style="display: none;">loading</div>
                                                </div>
                                                <span class="show_child_icon tiptipleft" style="display:none;" title="This item has child items"><i class="fa fa-window-restore fa-fw"></i></span>



                                                <!-- <a href="JavaScript:void(0);" class="remove_template_item_line btn tiptip" title="remove from template" style="display:none;"><i class="fa fa-fw fa-minus"></i></a> -->

                                                <?php if ($typeItem->getId()) { ?>
                                                    <?php if ($proposal_status_id != 5) { ?>
                                                        <!-- <a href="JavaScript:void(0);" class="estimate_item_notes btn tiptipleft" title="Notes" ><i class="fa fa-fw fa-clipboard"></i></a>
                                                    <a href="JavaScript:void(0);" class="deleteLineItem btn tiptipleft" title="Remove From Estimate"  data-estimate-line-id=""><i class="fa fa-fw fa-trash"></i></a>
                                                     -->
                                                        <div class="dropdownButton" style="float:right;margin-left: 5px;">
                                                            <a class="dropdownToggle btn" href="#"><i class="fa fa-bars"></i> <i class="fa fa-chevron-down"></i></a>
                                                            <div class="dropdownMenuContainer openAbove" style="display: none;width: 110px;    left: -80px;">

                                                                <ul class="dropdownMenu" style="width: 110px">
                                                                    <li>
                                                                        <a href="JavaScript:void(0);" class="estimate_item_notes tiptipleft" style="display: block!important;" title="Notes"><i class="fa fa-fw fa-clipboard"></i> Notes</a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="JavaScript:void(0);" class="deleteLineItem  tiptipleft" style="display: block!important;" title="Remove From Estimate" data-estimate-line-id=""><i class="fa fa-fw fa-trash"></i> Delete</a>
                                                                    </li>

                                                                </ul>

                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>

                                                <a href="javascript:void(0);" class="btn blue-button tiptipleft save_est_btn" title="Save Estimate" onclick="save_estimation_table(event,this,0);" style="margin-bottom:2px; display:none">Save</a>
                                                <a href="JavaScript:void(0);" class="undo_item_line btn tiptipleft" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a>
                                                <a href="JavaScript:void(0);" class="reset_item_line btn tiptipleft" title="Clear Item" style="display:none;"><i class="fa fa-fw fa-minus-circle"></i></a>

                                            </td>



                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        <?php } ?>
                    </div>

            <?php
                }

            endforeach; ?>
        </div>
        <p class="no_template_msg" style="font-size: 14px;margin-bottom: 10px;border-radius: 2px;padding: 5px 5px 5px 10px;background-color: #e8e3e3;"><i class="fa fa-info-circle"></i> &nbsp;No Assemblies have been assigned to this service category</p>
    </div>
</div>
<div id="page_load_message" style="margin-left:5px;width: 100%;float: left;position: relative;">

    <h3 class="welcome_msg" style="display:none;">Welcome To Item Estimator Section </h3>
    <h3 class="show_pending_est_msg" style="display:none;"></h3>
    <h3 class="show_complete_est_msg" style="display:none;">Congrats, all of your services have been estimated</h3>
    <div class="welcome_msg" style="width: 100%;margin: 0px auto;display: none;">
        <p style="width:20%;float:left;height: 85px;">
            <!-- <i class="fa fa-3x fa-long-arrow-left" style="float:right;color:#763699"></i> -->
            <img src="/static/images/light_blue_arrow_35.png" style="float: right;width:142px;">
        </p>
        <p style="font-size: 18px;width: 60%;padding: 10px;float: left;border: 1px solid #DDDDDD;border-radius: 5px;background: #EEEEEE;">Begin Estimate by opening each service. When the service estimate is completed, you will see check mark on right side</p>
    </div>
    <!--
    <div id="estimateSummaryTable" style="float:left;position: relative;top: 75px;"></div>
    -->

    <div id="piechartParent" style="    width: 58%;position: absolute;bottom: 1px;">
        <div id="piechart" style="display: inline-block;
    margin: 0 auto;"></div>
    </div>
    <table class="stripping-row proposal_final_total_table" style="">
        <tr>
            <td style="text-align: left;font-weight:bold;">Total Cost:</td>
            <td style="text-align: center;padding:0 20px"></td>
            <td class="final_table_proposal_cost">$0</td>
        </tr>
        <tr>
            <td style="text-align: left;font-weight:bold;">Total Profit:</td>
            <td style="text-align: center;padding:0 20px" class="final_table_proposal_profit_percent">0%</td>
            <td class="final_table_proposal_profit_amount">$0</td>
        </tr>
        <tr>
            <td style="text-align: left;font-weight:bold;">Total Overhead:</td>
            <td style="text-align: center;padding:0 20px" class="final_table_proposal_overhead_percent">0%</td>
            <td class="final_table_proposal_overhead_amount">$0</td>
        </tr>
        <tr>
            <td style="text-align: left;font-weight:bold;">Total Tax:</td>
            <td style="text-align: center;padding:0 20px"></td>
            <td class="final_table_proposal_total_tax">$0</td>
        </tr>
        <tr>
            <td style="text-align: left;font-weight:bold;">Total Price:</td>
            <td style="text-align: center;padding:0 20px"></td>
            <td class="final_table_proposal_total_price">$0</td>
        </tr>
    </table>

</div>
<div id="page_loading" style="margin-left:5px;width: 100%;float: left;display:none">
    <div style="position:relative;top:100px">
        <p class="clearfix">Loading, Please wait</p>

        <p class="clearfix">&nbsp;</p>

        <p><img src="/static/loading_animation.gif" alt="Loading"></p>
    </div>
</div>
<div id="estimatingItemModal">

    <div class="content-box" id="add-type">
        <div class="box-header">
            Add Estimation Item
        </div>
        <div class="box-content">
            <form autocomplete="off" class="form-validated" accept-charset="utf-8" method="post" action="<?php echo site_url('account/saveEstimatingItem') ?>">
                <input type="hidden" name="itemId" id="itemId" />

                <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table">
                    <tbody>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>Item Name</label>
                                    <input type="text" value="" id="itemName" name="itemName" class="text required" tabindex="2">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <p class="clearfix left">
                                    <label>Category</label>
                                    <select name="categoryId" id="categoryId" class="required">
                                        <option value="">-- Select Category</option>
                                        <?php
                                        foreach ($categories as $cat) {
                                        ?>
                                            <option value="<?php echo $cat->getId() ?>"><?php echo $cat->getName() ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <p class="clearfix left">
                                    <label>Type</label>
                                    <select name="typeId" id="typeId" class="required">
                                        <option value="">-- Select Type</option>
                                        <?php
                                        foreach ($types as $type) {
                                        ?>
                                            <option value="<?php echo $type->getId() ?>" data-category="<?php echo $type->getCategoryId();  ?>">
                                                <?php echo $type->getName() ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <p class="clearfix left">
                                    <label>Unit</label>
                                    <select name="unitId" id="unitId">
                                        <option value="">-- Select Unit</option>
                                        <?php foreach ($sortedUnits as $sortedUnit) { ?>

                                            <optgroup label="<?php echo $sortedUnit['unitType']->getName() ?>">
                                                <?php foreach ($sortedUnit['units'] as $unit) { ?>
                                                    <option value="<?php echo $unit->getId(); ?>"><?php echo $unit->getName(); ?> (<?php echo $unit->getAbbr(); ?>)</option>
                                                <?php } ?>
                                            </optgroup>
                                        <?php } ?>
                                    </select>
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>Unit Price <span>*</span></label>
                                    <input type="text" value="" id="unitPrice" name="unitPrice" class="text required" tabindex="" style="width: 100px;">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix left">
                                    <label>Taxable</label>
                                    <input type="checkbox" id="taxable" name="taxable" class="" tabindex="">
                                </p>
                            </td>
                        </tr>
                        <tr class="even" style="display: none;" id="taxRateRow">
                            <td>
                                <p class="clearfix left">
                                    <label>Tax Rate</label>
                                    <input type="text" id="tax_rate" name="tax_rate" class="text" tabindex="" style="width: 100px;"> %
                                </p>
                            </td>
                        </tr>

                        <tr class="">
                            <td>
                                <label>&nbsp;</label>
                                <button type="submit" class="btn blue-button" role="button" id="addType">
                                    <i class="fa fa-fw fa-plus"></i> Save Item
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

</div>
<div id="quantity_calculation" ontouchstart="myTestFunction()" title="<h4 class='calculator_heading22' style='text-align:center;margin:0px'></h4>">
    <div class="according-body body2">
        <div class="full-width">
            <!--<h4 class="calculator_service_title" style="text-align:left;width: 450px;float: left;"></h4>-->
            <span class="if_no_estimate_fields tiptip" title=""><a href="javascript:void('0');" class=" estimateFields tiptip" title="Choose the automatic calculator fields" style="font-weight: 100;font-size: 12px;float: left;position: absolute;top: 16px;width: 141px;display:none">Set up Estimating Fields</a></span>
            <h4 class='calculator_heading' style='text-align:center;'>
                <span class="if_template_item_saved tiptip" title="" style="left: 17px;top: 9px;position: absolute;width: 140px;padding: 3px 5px;border-radius: 3px;background-color: #25AAE1;color: rgb(255, 255, 255);display: block;"><i class="fa fa-fw fa-info-circle " style="font-size: 18px;margin-top: 3px;float:left;"></i><span style="color: #fff;position: relative;top: 2px;">Assembly Item</span></span>

                <span class="calculatorHeadingCategory"></span>
                <span class="calculatorHeadingType"></span> |
                <span class="calculatorHeadingItem"></span>
                <span class="if_item_saved" style="right: 17px;top: 9px;position: absolute;width: 80px;padding: 3px 5px;border-radius: 3px;background-color: rgb(81, 166, 75);color: rgb(255, 255, 255);display: block;"><i class="fa fa-fw fa-check-circle " style="font-size: 18px;margin-top: 3px;float:left;"></i><span style="color: #fff;position: relative;top: 2px;">Saved</span></span>
            </h4>
        </div>
        <!-- <div id="service_html_box">
        </div> -->
        <div style="width:250px;float:left;margin-right: 10px;" class="hide_in_asphalt">
            <div class="content-box" style="overflow:hidden">
                <div class="box-header centered calculator_service_title2" style="width:100%;text-align:center">Details</div>
                <div id="service_html_box" class="box-content service_html_box">

                </div>
            </div>

        </div>
        <form id="sealcoating_form">
            <div style="width:300px;float:left;margin-right: 10px;" class="show_in_sealcoating">
                <div class="content-box" style="overflow:hidden">
                    <div class="box-header centered calculator_service_title2" style="width:100%;text-align:center">Details</div>
                    <div id="service_html_box5" class="box-content service_html_box">

                    </div>
                </div>
            </div>
            <div class="half left sealcoating_section" style="display:none;width: 253px;margin-right: 10px;">
                <div class="content-box">
                    <div class="box-header centered ">Enter Details</div>
                    <table class="boxed-table stripping-row  text-right-table" border="0" style="width: 100%;margin: 0px auto;" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>

                            <tr>
                                <td>
                                    <label>Area</label>
                                    <input type="text" name="sealcoatArea" id="sealcoatArea" value="<?php echo ($service) ? $fields['area'] : 0; ?>" value="0" class="text number_field input75">

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Unit</label>
                                    <!-- <input type="text" name="sealcoatUnit" id="sealcoatUnit"   value="0" class=" input75"> -->
                                    <span class="cwidth5_container">
                                        <select style="float: right; border-radius: 3px; padding: 0.1em; width: 110px;" name="sealcoatUnit" id="sealcoatUnit" class="field_input ">
                                            <option value="square yards" selected="">square yards</option>
                                            <option value="square feet">square feet</option>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Number of coats</label>
                                    <span class="cwidth3_container">
                                        <select name="sealcoatCoats" id="sealcoatCoats">
                                            <?php
                                            for ($i = 1; $i <= 4; $i++) {
                                            ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Application Rate</label>
                                    <span class="apprate1_container cwidth3_container">
                                        <?php
                                        $selectedApprateValue = ($service) ? $this->calculator->getValue($service->getServiceId(), 'sealcoatApplicationRate') : 0.16;
                                        ?>
                                        <select class="apprate apprate1" name="sealcoatApplicationRate">
                                            <?php
                                            for ($i = 0.05; $i <= 0.23; $i += 0.01) {
                                            ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
                                                                                                        }
                                                                                                            ?>
                                        </select>
                                    </span>
                                    <span class="apprate2_container cwidth3_container">
                                        <?php
                                        $selectedApprateValue2 = ($service) ? $this->calculator->getValue($service->getServiceId(), 'sealcoatApplicationRate') : 1000;
                                        ?>
                                        <select class="apprate apprate2" name="sealcoatApplicationRate2">
                                            <?php
                                            for ($i = 0.005; $i <= 0.022; $i += 0.001) {
                                            ?>
                                                <option <?php echo (abs($i - $selectedApprateValue2) < 0.00001) ? 'selected="selected" x="c"' : '' ?>><?php echo $i; ?></option><?php
                                                                                                                                                                            }
                                                                                                                                                                                ?>
                                        </select>
                                    </span>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>% of Water</label>
                                    <span class="cwidth3_container">
                                        <select name="sealcoatWater" id="sealcoatWater">
                                            <?php
                                            for ($i = 0; $i <= 50; $i += 5) {
                                            ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
                                                                                                        }
                                                                                                            ?>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr class="hide_in_sand_additive">
                                <td>
                                    <label>Additive Items</label>
                                    <span class="cwidth5_container">
                                        <select class="text input45 additive_sealer_item" name="additive_sealer_item">

                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>% of Additive</label>
                                    <span class="cwidth3_container">
                                        <select name="sealcoatAdditive" id="sealcoatAdditive">
                                            <?php
                                            for ($i = 0; $i <= 6; $i += 1) {
                                            ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
                                                                                                        }
                                                                                                            ?>
                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr class="hide_in_sand_additive">
                                <td>
                                    <label>Sand Items</label>
                                    <span class="cwidth5_container">
                                        <select class="text input45 sand_sealer_item" name="sand_sealer_item">

                                        </select>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Sand</label>
                                    <span class="cwidth3_container">
                                        <select name="sealcoatSand" id="sealcoatSand">
                                            <?php
                                            for ($i = 0; $i <= 6; $i += 1) {
                                            ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
                                                                                                        }
                                                                                                            ?>
                                        </select></span> <i class="fa fa-info-circle fa-2x info_tip tiptip" style="display:block;margin-right: 0px;" title="Lb / Gal"></i>

                                </td>
                            </tr>
                            <?php if ($proposal_status_id != 5) { ?>
                                <tr>
                                    <td>

                                        <p class="labor_child_icon child_check_icon labor_check tiptip" title="Add Labor" style="cursor:pointer;width: 44%;float: left;">
                                            <span style="float:left;margin: 0px 5px;">
                                                <i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i>
                                            </span>

                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>

                                        </p>
                                        <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                        <p class="equipement_child_icon child_check_icon equipement_check tiptip" title="Add Equipment" style="cursor:pointer;width: 43%;float: left;">
                                            <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-wrench fa-fw fa-2x"></i></span>
                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="custom_child_icon child_check_icon custom_child_check tiptip" title="Add Custom" style="cursor:pointer;width: 25%;float: left;">
                                            <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>
                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>
                                        </p>
                                        <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                        <p class="fees_child_icon child_check_icon fees_child_check tiptip" data-type="fees" title="Add Fees" style="cursor:pointer;width: 25%;float: left;">
                                            <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-usd fa-fw fa-2x"></i></span>
                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>
                                        </p>
                                        <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                        <p class="permit_child_icon child_check_icon fees_child_check tiptip" data-type="permits" style="cursor:pointer;width: 25%;float: left;">
                                            <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-file-text-o fa-fw fa-2x"></i></span>
                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" class="fees_child_check tiptip" data-type="permits" title="Add Permits" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>
                                        </p>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="left sealcoating_section_right" style="display:none;width:300px;">
                <div class="content-box right half blue" style="width:100%;">
                    <div class="box-header centered">Calculation</div>
                    <div class="box-content">
                        <table class="boxed-table stripping-row " border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100">
                                        <label>Sealer</label>
                                    </td>
                                    <td>
                                        <strong id="sealcoatSealerTotal"></strong> Gallons
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>Water</label>
                                    </td>
                                    <td>
                                        <strong id="sealcoatWaterTotal"></strong> Gallons
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Additive</label>
                                    </td>
                                    <td>
                                        <strong id="sealcoatAdditiveTotal"></strong> Gallons
                                        <input type="hidden" name="sealcoatAdditiveTotalInput" class="sealcoatAdditiveTotalInput">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Sand</label>
                                    </td>
                                    <td>
                                        <strong id="sealcoatSandTotal"></strong> Lb / <strong id="sealcoatSandTotalGal"></strong> Gal
                                        <input type="hidden" name="sealcoatSandTotalInput" class="sealcoatSandTotalInput">
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>
                                        <label>Total Gallons</label>
                                    </td>
                                    <td>
                                        <strong id="sealcoatTotal"></strong> Gallons
                                    </td>
                                </tr>
                                <!-- <tr >
                                <td>
                                    <label class="unit_price_label">Unit Price</label>
                                </td>
                                <td>

                                
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                    <?php //if($oh_pm_type==2){
                                    ?>
                                        <span style="float:right;">
                                        <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                    <?php //} 
                                    ?>
                                    
                                </td>
                            </tr> -->
                                <tr>
                                    <td>
                                        <label class="unit_price_label">Unit Price</label>
                                    </td>
                                    <td>
                                        <span class="hide_if_edit_item_unit_price" style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                        <input type="text" name="custom_unit_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_price_input" style="margin-right:2px">
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>

                                        <!--Edit Unit Price Buttons-->

                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="if_edit_item_unit_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_unit_price_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_unit_price" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>

                                            <span class="item_unit_edit_icon  tiptipleft" title="Edit Unit Price" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                        <!--End Edit Unit Price Buttons-->
                                    </td>
                                </tr>
                                <tr class="if_edit_item_unit_price">
                                    <td>
                                        <label class="base_price_label">Base Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><input type="text" name="custom_unit_base_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_base_price_input" style="margin-right:2px"><span class="cal_unit_single_name" style="margin-top: 5px;float: left;"></span></span>

                                    </td>
                                </tr>
                                <tr class="even show_overhead_and_profit">
                                    <td>
                                        <label>Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_overhead" class="percentFormatN  text2 cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                        <span class="cal_overhead_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>
                                <!-- <tr >
                                <td>
                                    <label>Overhead Price</label>
                                </td>
                                <td>
                                    <span class="cal_overhead_price after_input" ></span>
                                </td>
                            </tr> -->
                                <tr class="show_overhead_and_profit">
                                    <td>
                                        <label>Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_profit" class="percentFormatN  text2 cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                        <span class="cal_profit_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>
                                <!-- <tr >
                                <td>
                                    <label>Profit Price</label>
                                </td>
                                <td>
                                    <span class="cal_profit_price after_input" ></span>
                                </td>
                            </tr> -->
                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: left;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="cal_tax_amount after_input2" style="float:right"></span>
                                    </td>
                                </tr>
                                <!-- <tr class="cal_tax_amount_row" style="display:none">
                                <td>
                                    <label>Tax Amount</label>
                                </td>
                                <td>
                                    <input type="text" name="cal_tax_amount" class="number_field text text2 cal_tax_amount" value="0" style="width: 60px; text-align: right;">
                                </td>
                            </tr> -->
                                <tr class="cost_per_unit_tr  ">
                                    <td>
                                        <label>Cost / <span class="total_surface_unit_text2" style="color:#333"></span></label>
                                    </td>
                                    <td>

                                        <span style="float:left;margin-top: 1px;">$<span class="cost_per_unit"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_tax_total  ">
                                    <td>
                                        <label>Total Tax</label>
                                    </td>
                                    <td>

                                        <span style="float:left;margin-top: 1px;">$<span class="cal_total_tax_amount"></span></span>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="show_child_item_total_tax_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="if_child_material_check_tax ">
                                    <td>
                                        <label>Material Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_material_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_equipment_check_tax ">
                                    <td>
                                        <label>Equipment Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_trucking_check_tax ">
                                    <td>
                                        <label>Trucking Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price_tax"></span></span>


                                    </td>
                                </tr>
                                <tr class="if_child_labor_check_tax ">
                                    <td>
                                        <label>Labor Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_custom_check_tax">
                                    <td>
                                        <label>Custom Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_parent_total" style="display: table-row;">
                                    <td>
                                        <label class="total_price_label">Total Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;font-weight: bold;" class="if_not_edit_parent_item_total_price">$<span class="cal_child_parent_total_price"></span></span>
                                        <input type="text" class="text input60 currency_field if_edit_parent_item_total_price custom_parent_total_price_input" style="margin-right:2px">
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="show_child_item_total_check if_not_edit_parent_item_total_price" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <span class="if_edit_parent_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_parent_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_parent_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_parant_total_edit_icon if_not_edit_parent_item_total_price tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr class="if_nochild_items show_child_item_total">
                                    <td>
                                        <label class="if_child_items_lable_text total_price_label">Material Total</label>
                                    </td>
                                    <td>

                                        <span style="float:left;margin-top: 1px;" class="if_not_edit_item_total_price">$<span class="cal_total_price"></span></span>
                                        <input type="text" class="text input60 currency_field if_edit_item_total_price custom_total_price_input" style="margin-right:2px">
                                        <span class="if_edit_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_total_edit_icon if_not_edit_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                        <span style="float:right;" class="parent_total_percent">
                                    </td>
                                </tr>
                                <tr class="if_child_equipment_check ">
                                    <td>
                                        <label>Equipment Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price"></span></span>
                                        <span style="float:right;" class="child_equipment_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_trucking_check ">
                                    <td>
                                        <label>Trucking Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price"></span></span>
                                        <span style="float:right;" class="child_trucking_total_percent"></span>

                                    </td>
                                </tr>
                                <tr class="if_child_labor_check ">
                                    <td>
                                        <label>Labor Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price"></span></span>
                                        <span style="float:right;" class="child_labor_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_default_check show_child_item_total">
                                    <td>
                                        <label>Additive / Sand</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_default_total_price"></span></span>
                                        <span style="float:right;" class="child_default_total_percent"></span>
                                    </td>
                                </tr>

                                <tr class="if_child_custom_check">
                                    <td>
                                        <label>Custom Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price"></span></span>
                                        <span style="float:right;" class="child_custom_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_fees_check">
                                    <td>
                                        <label>Fees Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_fees_total_price"></span></span>
                                        <span style="float:right;" class="child_fees_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_permit_check">
                                    <td>
                                        <label>Permit Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_permit_total_price"></span></span>
                                        <span style="float:right;" class="child_permit_total_percent"></span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </form>
        <div class="clearfix crack_sealer_section" style="display:none;">
            <form id="crack_sealer_form">
                <div style="width:300px;float:left;margin-right: 10px;" class="show_in_crack_sealer">
                    <div class="content-box" style="overflow:hidden">
                        <div class="box-header centered calculator_service_title2" style="width:100%;text-align:center">Details</div>
                        <div id="service_html_box7" class="box-content service_html_box">

                        </div>
                    </div>
                </div>
                <div class="left" style="width: 250px;margin-right: 10px;">
                    <div class="content-box">
                        <div class="box-header centered ">Enter Details</div>

                        <div class="box-content" style="width: 100%;margin: 0px auto;">
                            <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label style="width:120px;">Crack Length (Ft)</label>
                                            <input type="text" name="crackseakLength" id="crackseakLength" value="0" class="text number_field input45">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label style="width:126px;">Typical Crack Width</label>

                                            <span class="cwidth2_container">
                                                <select class="cwidth cwidth2" name="cwidth">
                                                    <option value="4" selected="selected">1/4"</option>
                                                    <option value="2">1/2"</option>
                                                    <option value="1.5">3/4"</option>
                                                    <option value="1">1"</option>
                                                </select>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label style="width:126px;">Typical Crack Depth</label>

                                            <span class="cdepth2_container">
                                                <select class="cdepth cdepth2" name="cdepth">
                                                    <option value="4" selected="selected">1/4"</option>
                                                    <option value="2">1/2"</option>
                                                    <option value="1.5">3/4"</option>
                                                    <option value="1">1"</option>
                                                </select>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php if ($proposal_status_id != 5) { ?>
                                        <tr>
                                            <td>

                                                <p class="labor_child_icon child_check_icon labor_check tiptip" title="Add Labor" style="cursor:pointer;width: 44%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;">
                                                        <i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i>
                                                    </span>

                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>

                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="equipement_child_icon child_check_icon equipement_check tiptip" title="Add Equipment" style="cursor:pointer;width: 43%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-wrench fa-fw fa-2x"></i></span>
                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="custom_child_icon child_check_icon custom_child_check tiptip" title="Add Custom" style="cursor:pointer;width: 25%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>
                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="fees_child_icon child_check_icon fees_child_check tiptip" data-type="fees" title="Add Fees" style="cursor:pointer;width: 25%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-usd fa-fw fa-2x"></i></span>
                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="permit_child_icon child_check_icon fees_child_check tiptip" data-type="permits" style="cursor:pointer;width: 25%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-file-text-o fa-fw fa-2x"></i></span>
                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" class="fees_child_check tiptip" data-type="permits" title="Add Permits" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="left" style="width:300px;">
                    <div>
                        <div class="content-box blue">
                            <div class="box-header centered">Calculation</div>
                            <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="100">
                                            <label>Total Sealant</label>
                                        </td>
                                        <td>
                                            <span id="cracksealTotalMaterial"></span> <span id="cracksealUnit2"></span>
                                        </td>
                                    </tr>

                                    <!-- <tr >
                                    <td>
                                        <label class="unit_price_label">Unit Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                            <span style="float:right;">
                                            <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                        <?php //}
                                        ?>
                                    </td>
                                </tr> -->
                                    <tr>
                                        <td>
                                            <label class="unit_price_label">Unit Price</label>
                                        </td>
                                        <td>
                                            <span class="hide_if_edit_item_unit_price" style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                            <input type="text" name="custom_unit_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_price_input" style="margin-right:2px">
                                            <?php //if($oh_pm_type==2){
                                            ?>
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                            <?php //}
                                            ?>

                                            <!--Edit Unit Price Buttons-->

                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="if_edit_item_unit_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_unit_price_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_unit_price" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>

                                                <span class="item_unit_edit_icon  tiptipleft" title="Edit Unit Price" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                            <!--End Edit Unit Price Buttons-->
                                        </td>
                                    </tr>
                                    <tr class="if_edit_item_unit_price">
                                        <td>
                                            <label class="base_price_label">Base Price</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;"><input type="text" name="custom_unit_base_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_base_price_input" style="margin-right:2px"><span class="cal_unit_single_name" style="margin-top: 5px;float: left;"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="even show_overhead_and_profit">
                                        <td>
                                            <label>Overhead %</label>
                                        </td>
                                        <td>
                                            <input type="text" name="cal_overhead" class="percentFormatN  text2 cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                            <span class="cal_overhead_price after_input2" style="float:right"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr >
                                    <td>
                                        <label>Overhead Price</label>
                                    </td>
                                    <td>
                                        <span class="cal_overhead_price after_input" ></span>
                                    </td>
                                </tr> -->
                                    <tr class="show_overhead_and_profit">
                                        <td>
                                            <label>Profit %</label>
                                        </td>
                                        <td>
                                            <input type="text" name="cal_profit" class="percentFormatN  text2 cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                            <span class="cal_profit_price after_input2" style="float:right"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr >
                                    <td>
                                        <label>Profit Price</label>
                                    </td>
                                    <td>
                                        <span class="cal_profit_price after_input" ></span>
                                    </td>
                                </tr> -->
                                    <tr>
                                        <td>

                                            <label style="margin-right: 0px;float: left;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                        </td>
                                        <td>

                                            <input type="text" name="cal_tax" class="percentFormat text text2 cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                            <span class="cal_tax_amount after_input2" style="float:right"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr class="cal_tax_amount_row" style="display:none">
                                    <td>
                                        <label>Tax Amount</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_tax_amount" class="number_field text text2 cal_tax_amount" value="0" style="width: 60px; text-align: right;">
                                    </td>
                                </tr> -->
                                    <tr class="if_tax_total  ">
                                        <td>
                                            <label>Total Tax</label>
                                        </td>
                                        <td>

                                            <span style="float:left;margin-top: 1px;">$<span class="cal_total_tax_amount"></span></span>
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="show_child_item_total_tax_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_material_check_tax ">
                                        <td>
                                            <label>Material Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_material_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_equipment_check_tax ">
                                        <td>
                                            <label>Equipment Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_trucking_check_tax ">
                                        <td>
                                            <label>Trucking Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price_tax"></span></span>


                                        </td>
                                    </tr>
                                    <tr class="if_child_labor_check_tax ">
                                        <td>
                                            <label>Labor Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_custom_check_tax">
                                        <td>
                                            <label>Custom Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_parent_total">
                                        <td>
                                            <label class="total_price_label">Total Price</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;font-weight: bold;" class="if_not_edit_parent_item_total_price">$<span class="cal_child_parent_total_price"></span></span>
                                            <input type="text" class="text input60 currency_field if_edit_parent_item_total_price custom_parent_total_price_input" style="margin-right:2px">
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="show_child_item_total_check if_not_edit_parent_item_total_price" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                            <span class="if_edit_parent_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_parent_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_parent_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="item_parant_total_edit_icon if_not_edit_parent_item_total_price tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr class="if_nochild_items ">
                                        <td>
                                            <label class="if_child_items_lable_text total_price_label">Total Price</label>
                                        </td>
                                        <td>

                                            <span style="float:left;margin-top: 1px;" class="if_not_edit_item_total_price">$<span class="cal_total_price"></span></span>
                                            <input type="text" class="text input60 currency_field if_edit_item_total_price custom_total_price_input" style="margin-right:2px">
                                            <span class="if_edit_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="item_total_edit_icon if_not_edit_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                            <span style="float:right;" class="parent_total_percent">

                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_equipment_check ">
                                        <td>
                                            <label>Equipment Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price"></span></span>
                                            <span style="float:right;" class="child_equipment_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_trucking_check ">
                                        <td>
                                            <label>Trucking Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price"></span></span>
                                            <span style="float:right;" class="child_trucking_total_percent"></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_labor_check ">
                                        <td>
                                            <label>Labor Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price"></span></span>
                                            <span style="float:right;" class="child_labor_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_default_check ">
                                        <td>
                                            <label>Additive / Sand</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_default_total_price"></span></span>
                                            <span style="float:right;" class="child_default_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_custom_check">
                                        <td>
                                            <label>Custom Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price"></span></span>
                                            <span style="float:right;" class="child_custom_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_fees_check">
                                        <td>
                                            <label>Fees Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_fees_total_price"></span></span>
                                            <span style="float:right;" class="child_fees_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_permit_check">
                                        <td>
                                            <label>Permit Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_permit_total_price"></span></span>
                                            <span style="float:right;" class="child_permit_total_percent"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <form id="striping_form">
            <div class="striping_section" style="display:none;">
                <div style="width:300px;float:left;margin-right: 10px;" class="show_in_striping">
                    <div class="content-box" style="overflow:hidden">
                        <div class="box-header centered calculator_service_title2" style="width:100%;text-align:center">Details</div>
                        <div id="service_html_box6" class="box-content service_html_box">

                        </div>
                    </div>
                </div>
                <div class="left" style="width:250px;margin-right:10px;">
                    <div class="content-box">
                        <div class="box-header centered ">Enter Details</div>

                        <div class="box-content" style="width: 100%;margin: 0px auto;">
                            <table class="boxed-table stripping-row " border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label style="margin-right: 13px;">Total Lineal Ft</label>
                                            <input type="text" name="stripingFeet" id="stripingFeet" value="0" class="text number_field input45">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Pail size of Paint</label>
                                            <select name="stripingPailSize" id="stripingPailSize">
                                                <option value="1">1 Gallon</option>
                                                <option value="5">5 Gallons</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Paint Color</label>
                                            <select name="stripingPailColor" id="stripingPailColor">
                                                <option value="320">White</option>
                                                <option value="310">Yellow</option>
                                                <option value="300">Red</option>
                                                <option value="300">Blue</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php if ($proposal_status_id != 5) { ?>
                                        <tr>
                                            <td>

                                                <p class="labor_child_icon child_check_icon labor_check tiptip" title="Add Labor" style="cursor:pointer;width: 44%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;">
                                                        <i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i>
                                                    </span>

                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>

                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="equipement_child_icon child_check_icon equipement_check tiptip" title="Add Equipment" style="cursor:pointer;width: 43%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-wrench fa-fw fa-2x"></i></span>
                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="custom_child_icon child_check_icon custom_child_check tiptip" title="Add Custom" style="cursor:pointer;width: 25%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>
                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="fees_child_icon child_check_icon fees_child_check tiptip" data-type="fees" title="Add Fees" style="cursor:pointer;width: 25%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-usd fa-fw fa-2x"></i></span>
                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="permit_child_icon child_check_icon fees_child_check tiptip" data-type="permits" style="cursor:pointer;width: 25%;float: left;">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-file-text-o fa-fw fa-2x"></i></span>
                                                    <span style="float:right;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" class="fees_child_check tiptip" data-type="permits" title="Add Permits" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="left" style="width:300px">
                    <div>
                        <div class="content-box blue">
                            <div class="box-header centered">Calculation</div>
                            <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>

                                    <tr>
                                        <td width="100">
                                            <label>Material Total</label>
                                        </td>
                                        <td>
                                            <span id="stripingMaterialTotal"></span> Gallons

                                            <i class="fa fa-info-circle fa-2x info_tip tiptipleft" style="display:block;margin-top:0px" title="Material usage based on striping applied 4in wide @ 15 mils"></i>
                                        </td>
                                    </tr>


                                    <!-- <tr >
                                    <td>
                                        <label class="unit_price_label">Unit Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                            <span style="float:right;">
                                            <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                        <?php //}
                                        ?>
                                    </td>
                                </tr> -->
                                    <tr>
                                        <td>
                                            <label class="unit_price_label">Unit Price</label>
                                        </td>
                                        <td>
                                            <span class="hide_if_edit_item_unit_price" style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                            <input type="text" name="custom_unit_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_price_input" style="margin-right:2px">
                                            <?php //if($oh_pm_type==2){
                                            ?>
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                            <?php //}
                                            ?>

                                            <!--Edit Unit Price Buttons-->

                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="if_edit_item_unit_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_unit_price_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_unit_price" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>

                                                <span class="item_unit_edit_icon  tiptipleft" title="Edit Unit Price" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                            <!--End Edit Unit Price Buttons-->
                                        </td>
                                    </tr>
                                    <tr class="if_edit_item_unit_price">
                                        <td>
                                            <label class="base_price_label">Base Price</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;"><input type="text" name="custom_unit_base_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_base_price_input" style="margin-right:2px"><span class="cal_unit_single_name" style="margin-top: 5px;float: left;"></span></span>

                                        </td>
                                    </tr>

                                    <tr class="even show_overhead_and_profit">
                                        <td>
                                            <label>Overhead %</label>
                                        </td>
                                        <td>
                                            <input type="text" name="cal_overhead" class="percentFormatN  text2 cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                            <span class="cal_overhead_price after_input2" style="float:right"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr >
                                    <td>
                                        <label>Overhead Price</label>
                                    </td>
                                    <td>
                                        <span class="cal_overhead_price after_input" ></span>
                                    </td>
                                </tr> -->
                                    <tr class="show_overhead_and_profit">
                                        <td>
                                            <label>Profit %</label>
                                        </td>
                                        <td>
                                            <input type="text" name="cal_profit" class="percentFormatN  text2 cal_profit  <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                            <span class="cal_profit_price after_input2" style="float:right"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr >
                                    <td>
                                        <label>Profit Price</label>
                                    </td>
                                    <td>
                                        <span class="cal_profit_price after_input" ></span>
                                    </td>
                                </tr> -->
                                    <tr>
                                        <td>

                                            <label style="margin-right: 0px;float: left;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                        </td>
                                        <td>

                                            <input type="text" name="cal_tax" class="percentFormat text text2 cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                            <span class="cal_tax_amount after_input2" style="float:right"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr class="cal_tax_amount_row" style="display:none">
                                    <td>
                                        <label>Tax Amount</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_tax_amount" class="number_field text text2 cal_tax_amount" value="0" style="width: 60px; text-align: right;">
                                    </td>
                                </tr> -->
                                    <tr class="if_tax_total  ">
                                        <td>
                                            <label>Total Tax</label>
                                        </td>
                                        <td>

                                            <span style="float:left;margin-top: 1px;">$<span class="cal_total_tax_amount"></span></span>
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="show_child_item_total_tax_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_material_check_tax ">
                                        <td>
                                            <label>Material Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_material_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_equipment_check_tax ">
                                        <td>
                                            <label>Equipment Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_trucking_check_tax ">
                                        <td>
                                            <label>Trucking Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price_tax"></span></span>


                                        </td>
                                    </tr>
                                    <tr class="if_child_labor_check_tax ">
                                        <td>
                                            <label>Labor Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_custom_check_tax">
                                        <td>
                                            <label>Custom Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_parent_total">
                                        <td>
                                            <label class="total_price_label">Total Price</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;font-weight: bold;" class="if_not_edit_parent_item_total_price">$<span class="cal_child_parent_total_price"></span></span>
                                            <input type="text" class="text input60 currency_field if_edit_parent_item_total_price custom_parent_total_price_input" style="margin-right:2px">
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="show_child_item_total_check if_not_edit_parent_item_total_price" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                            <span class="if_edit_parent_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_parent_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_parent_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="item_parant_total_edit_icon if_not_edit_parent_item_total_price tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr class="if_nochild_items ">
                                        <td>
                                            <label class="if_child_items_lable_text total_price_label">Total Price</label>
                                        </td>
                                        <td>

                                            <span style="float:left;margin-top: 1px;" class="if_not_edit_item_total_price">$<span class="cal_total_price"></span></span>
                                            <input type="text" class="text input60 currency_field if_edit_item_total_price custom_total_price_input" style="margin-right:2px">
                                            <span class="if_edit_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="item_total_edit_icon if_not_edit_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                            <span style="float:right;" class="parent_total_percent">

                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_equipment_check ">
                                        <td>
                                            <label>Equipment Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price"></span></span>
                                            <span style="float:right;" class="child_equipment_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_trucking_check ">
                                        <td>
                                            <label>Trucking Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price"></span></span>
                                            <span style="float:right;" class="child_trucking_total_percent"></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_labor_check ">
                                        <td>
                                            <label>Labor Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price"></span></span>
                                            <span style="float:right;" class="child_labor_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_default_check ">
                                        <td>
                                            <label>Additive / Sand</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_default_total_price"></span></span>
                                            <span style="float:right;" class="child_default_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_custom_check">
                                        <td>
                                            <label>Custom Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price"></span></span>
                                            <span style="float:right;" class="child_custom_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_fees_check">
                                        <td>
                                            <label>Fees Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_fees_total_price"></span></span>
                                            <span style="float:right;" class="child_fees_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_permit_check">
                                        <td>
                                            <label>Permit Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_permit_total_price"></span></span>
                                            <span style="float:right;" class="child_permit_total_percent"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>

            </div>
        </form>
        <form id="asphalt_form">
            <div class="one-box">
                <div style="width:300px;float:left;margin-right: 10px;" class="show_in_asphalt">
                    <div class="content-box" style="overflow:hidden">
                        <div class="box-header centered calculator_service_title2" style="width:100%;text-align:center">Details</div>
                        <div id="service_html_box3" class="box-content service_html_box">

                        </div>
                    </div>
                </div>
                <div class="left-bar" style="width:250px;float:left;margin-right: 10px;">
                    <div class="content-box">
                        <div class="box-header centered ">Enter Details</div>


                        <div class="box-content" style="width: 100%;margin: 0px auto;">
                            <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Measurement</label>
                                            <!-- <span id="measurement" class="asp_span"></span> -->
                                            <input type="text" class="text number_field input45" name="measurement" id="measurement">

                                        </td>
                                    </tr>
                                    <tr class="extra_ton_tr" style="display:none">
                                        <td>
                                            <label>Additional Tons</label>
                                            <input type="text" class="text number_field input45" value="0" name="extra_ton" id="extra_ton">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Unit</label>
                                            <!-- <span class="measurement_unit asp_span"></span> -->
                                            <!-- <input type="text" class="measurement_unit  input75"   name="measurement_unit"> -->
                                            <select style="float: right; border-radius: 3px; padding: 0.1em; width: 110px;" name="measurement_unit" class="measurement_unit field_input ">
                                                <option value="square yards">square yards</option>
                                                <option value="square feet">square feet</option>
                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label>Depth (In)</label>
                                            <!-- <span class=" asp_span" id="depth"></span> -->
                                            <input type="text" class="text number_field  input45" name="depth" id="depth">
                                        </td>
                                    </tr>
                                    <tr class="measurement_lbs_tr">
                                        <td>
                                            <label>Lbs/SY/In</label>
                                            <!-- <span class="measurement_unit asp_span"></span> -->
                                            <!-- <input type="text" class="measurement_unit  input75"   name="measurement_unit"> -->
                                            <select style="float: right; border-radius: 3px; padding: 0.1em; width: 110px;" name="measurement_lbs" class="measurement_lbs field_input ">
                                                <option value="0.055">110 Lbs</option>
                                                <option value="0.06">120 Lbs</option>
                                            </select>

                                        </td>
                                    </tr>
                                    <!-- <tr class="if_head_type_excavatoin" style="display:none; ">
                                    <td>
                                        <label>Fee / Ton</label>
                                       
                                        <input type="text" class="text currency_field  input45"  name="fee_per_ton" id="fee_per_ton">
                                    </td>
                                </tr> -->
                                    <?php if ($proposal_status_id != 5) { ?>
                                        <?php if (count($plants) > 0) { ?>
                                            <!-- <tr>
                                    <td>
                                    <span style="float:left" ><i style ="margin-top: 6px;font-size: 1.2em;" class="fa fa-truck fa-fw fa-2x "></i></span>
                                                <label>Trucking</label>
                                    <span style="float:right">
                                        <a href="javascript:void('0');" class="trucking_check" style="color:#000"><i style ="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                    </span>
                                    </td>
                                </tr> -->
                                        <?php } ?>
                                        <tr>
                                            <td>
                                                <?php if (count($plants) > 0) { ?>
                                                    <p class="trucking_child_icon child_check_icon trucking_check tiptip" title="Add Trucking" style="cursor:pointer;float:left">
                                                        <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-truck fa-fw fa-2x "></i></span>
                                                        <span style="float:left;margin: 0px 5px;"><a href="javascript:void('0');" class="" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a></span>
                                                    </p>
                                                    <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <?php } ?>
                                                <p class="labor_child_icon child_check_icon labor_check tiptip" title="Add Labor" style="cursor:pointer;float:left">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i></span>
                                                    <span style="float:left;margin: 0px 5px;"><a href="javascript:void('0');" class="" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a></span>
                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="equipement_child_icon child_check_icon equipement_check tiptip" title="Add Equipment" style="cursor:pointer;float:left">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-wrench fa-fw fa-2x"></i></span>
                                                    <span style="float:left;margin: 0px 5px;"><a href="javascript:void('0');" class="" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a></span>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="custom_child_icon child_check_icon custom_child_check tiptip" title="Add Custom" style="cursor:pointer;float:left">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>
                                                    <span style="float:left;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" class="" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="fees_child_icon child_check_icon tiptip fees_child_check" data-type="fees" title="Add Fees" style="cursor:pointer;float:left">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-usd fa-fw fa-2x"></i></span>
                                                    <span style="float:left;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" class=" " style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                                <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                                <p class="permit_child_icon child_check_icon tiptip fees_child_check" data-type="permits" title="Add Permits" style="cursor:pointer;float:left">
                                                    <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-file-text-o fa-fw fa-2x"></i></span>
                                                    <span style="float:left;margin: 0px 5px;">
                                                        <a href="javascript:void('0');" class=" " style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                    </span>
                                                </p>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                    <td>
                                        <span style="float:left"  ><i style ="margin-top: 6px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>
                                        <label>Custom</label>
                                        <span style="float:right">
                                            <a href="javascript:void('0');" class="custom_child_check" style="color:#000"><i style ="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                        </span>
                                    </td>
                                </tr> -->
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- <div class="if_trucking_check" style="display:none;width:560px;float:left;margin-right: 10px;">

                </div> -->

                <div class="left asphalt-right" style="width:300px">
                    <div>
                        <div class="content-box blue">
                            <div class="box-header centered">Calculation</div>
                            <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                                    <tr>
                                        <td width="100">
                                            <label>Total Surface</label>
                                        </td>
                                        <td>
                                            <span class="total_surface">0.00</span> <span class="total_surface_unit_text">Sq. Yds.</span>
                                        </td>
                                    </tr>
                                    <tr class="even">
                                        <td>

                                            <label class="item_name"> <a href="javascript:void('0');" class="add_extra_ton tiptip" title="Additional Tons" style="color:#000; float:left;   margin-right: 2px;"><i style="top: 3px;position: relative;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>Tons</label>
                                        </td>
                                        <td>
                                            <span class="item_quantity">0.00 </span><span class="black-slim-text"> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label class="unit_price_label">Unit Price</label>
                                        </td>
                                        <td>
                                            <span class="hide_if_edit_item_unit_price" style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                            <input type="text" name="custom_unit_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_price_input" style="margin-right:2px">
                                            <?php //if($oh_pm_type==2){
                                            ?>
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                            <?php //}
                                            ?>

                                            <!--Edit Unit Price Buttons-->

                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="if_edit_item_unit_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_unit_price_btn blue-button">Ok</a>
                                                <a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_unit_price" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>

                                                <span class="item_unit_edit_icon  tiptipleft" title="Edit Unit Price" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                            <!--End Edit Unit Price Buttons-->
                                        </td>
                                    </tr>
                                    <tr class="if_edit_item_unit_price">
                                        <td>
                                            <label class="base_price_label">Base Price</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;"><input type="text" name="custom_unit_base_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_base_price_input" style="margin-right:2px"><span class="cal_unit_single_name" style="margin-top: 5px;float: left;"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="even show_overhead_and_profit">
                                        <td>
                                            <label>Overhead %</label>
                                        </td>
                                        <td>
                                            <input type="text" name="cal_overhead" class="percentFormatN  text2 cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="" style="width: 60px; text-align: right;">
                                            <span class="cal_overhead_price after_input2 currency_span" style="float:right"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr >
                                    <td>
                                        <label>Overhead Price</label>
                                    </td>
                                    <td>

                                    </td>
                                </tr> -->
                                    <tr class="show_overhead_and_profit">
                                        <td>
                                            <label>Profit %</label>
                                        </td>
                                        <td>
                                            <input type="text" name="cal_profit" class="percentFormatN  text2 cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : 'text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="" style="width: 60px; text-align: right;">
                                            <div class="cal_profit_price after_input2 " style="float:right"></div>
                                        </td>
                                    </tr>
                                    <tr class="if_trucking_check2">
                                        <td>
                                            <label>Trucking OH %</label>
                                        </td>
                                        <td>
                                            <input type="text" name="cal_trucking_oh" class="percentFormat text text2 cal_trucking_oh" value="10.00" style="width: 60px; text-align: right;">
                                            <span class="cal_trucking_oh_price after_input2" style="float:right"></span>
                                        </td>
                                    </tr>
                                    <tr class="even if_trucking_check2">
                                        <td>
                                            <label>Trucking PM %</label>
                                        </td>
                                        <td>
                                            <input type="text" name="cal_trucking_pm" class="percentFormat text text2 cal_trucking_pm" value="10.00" style="width: 60px; text-align: right;">
                                            <span class="cal_trucking_pm_price after_input2"></span>
                                        </td>
                                    </tr>
                                    <!-- <tr >
                                    <td>
                                        <label>Profit Price</label>
                                    </td>
                                    <td>

                                    </td>
                                </tr> -->
                                    <tr>
                                        <td>

                                            <label style="margin-right: 0px;float: right;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px; margin-top: 1px;"><input type="checkbox" class="cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                        </td>
                                        <td>

                                            <input type="text" name="cal_tax" class="percentFormat text text2 cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                            <span class="cal_tax_amount after_input2" style="float:right"></span>
                                        </td>
                                    </tr>

                                    <tr class="even if_trucking_check2">
                                        <td>
                                            <label>Material Total</label>
                                        </td>
                                        <td>
                                            $<span class="cal_material_total_price">0</span>
                                        </td>
                                    </tr>

                                    <tr class=" if_trucking_check2">
                                        <td>
                                            <label>Trucking Total</label>
                                        </td>
                                        <td>
                                            $<span class="cal_trucking_total_price">0</span>
                                        </td>
                                    </tr>
                                    <tr class="cost_per_unit_tr  ">
                                        <td>
                                            <label>Cost / <span class="total_surface_unit_text2" style="color:#333"></span></label>
                                        </td>
                                        <td>

                                            <span style="float:left;margin-top: 1px;">$<span class="cost_per_unit"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_tax_total  ">
                                        <td>
                                            <label>Total Tax</label>
                                        </td>
                                        <td>

                                            <span style="float:left;margin-top: 1px;">$<span class="cal_total_tax_amount"></span></span>
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="show_child_item_total_tax_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_material_check_tax ">
                                        <td>
                                            <label>Material Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_material_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_equipment_check_tax ">
                                        <td>
                                            <label>Equipment Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_trucking_check_tax ">
                                        <td>
                                            <label>Trucking Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price_tax"></span></span>


                                        </td>
                                    </tr>
                                    <tr class="if_child_labor_check_tax ">
                                        <td>
                                            <label>Labor Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_custom_check_tax">
                                        <td>
                                            <label>Custom Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_fees_check_tax">
                                        <td>
                                            <label>Fees Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_fees_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_permit_check_tax">
                                        <td>
                                            <label>Permit Tax</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_permit_total_price_tax"></span></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_parent_total">
                                        <td>
                                            <label class="total_price_label">Total Price</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;font-weight: bold;" class="if_not_edit_parent_item_total_price">$<span class="cal_child_parent_total_price"></span></span>
                                            <input type="text" class="text input60 currency_field if_edit_parent_item_total_price custom_parent_total_price_input" style="margin-right:2px">
                                            <span style="float:right;">
                                                <a href="javascript:void('0');" class="show_child_item_total_check if_not_edit_parent_item_total_price" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                            </span>
                                            <span class="if_edit_parent_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_parent_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_parent_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="item_parant_total_edit_icon if_not_edit_parent_item_total_price tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <tr class="if_nochild_items ">
                                        <td>
                                            <label class="if_child_items_lable_text total_price_label">Total Price</label>
                                        </td>
                                        <td>

                                            <span style="float:left;margin-top: 1px;" class="if_not_edit_item_total_price">$<span class="cal_total_price"></span></span>
                                            <input type="text" class="text input60 currency_field if_edit_item_total_price custom_total_price_input" style="margin-right:2px">
                                            <span class="if_edit_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                            <?php if ($account->getEditPrice()) { ?>
                                                <span class="item_total_edit_icon if_not_edit_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                            <?php } ?>
                                            <span style="float:right;" class="parent_total_percent">

                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_equipment_check ">
                                        <td>
                                            <label>Equipment Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price"></span></span>
                                            <span style="float:right;" class="child_equipment_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_trucking_check ">
                                        <td>
                                            <label>Trucking Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price"></span></span>
                                            <span style="float:right;" class="child_trucking_total_percent"></span>

                                        </td>
                                    </tr>
                                    <tr class="if_child_labor_check ">
                                        <td>
                                            <label>Labor Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price"></span></span>
                                            <span style="float:right;" class="child_labor_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_default_check ">
                                        <td>
                                            <label>Additive / Sand</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_default_total_price"></span></span>
                                            <span style="float:right;" class="child_default_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_custom_check">
                                        <td>
                                            <label>Custom Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price"></span></span>
                                            <span style="float:right;" class="child_custom_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_fees_check">
                                        <td>
                                            <label>Fees Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_fees_total_price"></span></span>
                                            <span style="float:right;" class="child_fees_total_percent"></span>
                                        </td>
                                    </tr>
                                    <tr class="if_child_permit_check">
                                        <td>
                                            <label>Permit Total</label>
                                        </td>
                                        <td>
                                            <span style="float:left;margin-top: 1px;">$<span class="cal_child_permit_total_price"></span></span>
                                            <span style="float:right;" class="child_permit_total_percent"></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>


        </form>
        <form id="trucking_form" parsley-validate>
            <input type="hidden" name="hidden_sep_trucking_start_searchBox" class="hidden_sep_trucking_start_searchBox">
            <input type="hidden" name="hidden_sep_trucking_end_searchBox" class="hidden_sep_trucking_end_searchBox">
            <input type="hidden" name="hidden_sep_trip_time" class="hidden_sep_trip_time">
            <input type="hidden" name="hidden_sep_plant_turnaround" class="hidden_sep_plant_turnaround">
            <input type="hidden" name="hidden_sep_site_turnaround" class="hidden_sep_site_turnaround">
            <a class="sep_close_map btn blue-button " style="font-size:12px;float:right;display:none;margin-bottom: 5px;">Close Map</a>
            <div id="sep_divMap" class="sep_divMap" style="width:500px;float:left;display:none"></div>
            <div id='sep_printoutPanel' class="sep_printoutpanel" style="display:none"></div>
            <div class="content-box trucking_box" style="float:left; width:100%;">
                <div class="box-header centered "><i style="margin-top: 4px;font-size: 1.2em;" class="fa fa-truck fa-fw fa-2x"></i> Trucking Calculator</div>
                <h4 class="job_site_addr"><span>Job Site:</span> <?= $proposalRepository->getProjectAddressString($proposal); ?></h4>
                <div class="box-content" style="width: 49%; float:left; border-right:1px solid #ccc;">

                    <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr class="select_width">
                                <td>
                                    <label>Material</label>
                                    <input type="text" class="round_off_field text input45 sep_trucking_malerial" name="sep_trucking_malerial" required data-parsley-trigger="focusout" data-parsley-errors-messages-disabled><span class="after_input3">Tons</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="trucking_unit_price_label">Trucking Price</label>
                                    <p style="margin-top: 6px;"> $<span class="cal_trucking_unit_price">0</span> / Hour
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="sep_trucking_cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>
                                    </p>
                                </td>

                            </tr>
                            <tr class="show_sep_trucking_overhead_and_profit">

                                <td>
                                    <label>Overhead %</label>
                                    <input type="text" name="cal_overhead" class="percentFormatN  text2 sep_trucking_cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="10" style="width: 60px; text-align: right;">
                                    <span class="sep_trucking_cal_overhead_price after_input2" style="float:right">$0.00</span>
                                </td>
                            </tr>

                            <tr class="show_sep_trucking_overhead_and_profit">

                                <td>
                                    <label>Profit %</label>
                                    <input type="text" name="cal_profit" class="percentFormatN  text2 sep_trucking_cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="10" style="width: 60px; text-align: right;">
                                    <span class="sep_trucking_cal_profit_price after_input2" style="float:right">$0.00</span>
                                </td>
                            </tr>
                            <tr class="">
                                <td>
                                    <label>Truck Capacity</label>
                                    <input type="text" class=" hide_input_style input22 sep_truck_capacity" name="truck_capacity" style="text-align:left;float: left;box-shadow: none;border: 0px;background: transparent;"><span class="after_input3">Tons</span>
                                </td>
                            </tr>
                            <!--remove for sep-->
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Round Time</label>

                                    <select id="sep_custom_round_time" class="text input45 sep_custom_round_time" name="sep_custom_round_time">
                                        <option value="">Select</option>
                                        <option value="0.5">0.5 Hours</option>
                                        <option value="1">1 Hour</option>
                                        <option value="1.5">1.5 Hour</option>
                                        <option value="2">2 Hours</option>
                                        <option value="2.5">2.5 Hours</option>
                                        <option value="3">3 Hours</option>
                                        <option value="3.5">3.5 Hours</option>
                                        <option value="4">4 Hours</option>
                                        <option value="4.5">4.5 Hours</option>
                                        <option value="5">5 Hours</option>
                                    </select>

                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="(Trip Time x 2) + Plant Time + Site Time" aria-hidden="true"></i>
                                    <span style="top: 3px;position: relative;left: 150px;cursor:pointer" class=" round_time_cal_span"><i class="fa fa-fw fa-calculator tiptipleft" title="Calculate Round Time" aria-hidden="true"></i></span>
                                </td>
                            </tr>

                            <tr class="tr_info_tip">
                                <td>
                                    <div style="width:100%;float: left;">
                                        <label>Hours / Day</label>
                                        <input type="text" class="number_field text input45 sep_hours_per_day" value="8" name="hours_per_day">
                                        <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Hours available for trucking per day" aria-hidden="true"></i>
                                    </div>
                                    <div style="width:45%;float: left;">
                                        <!-- <label style="width: 50px;float: left;">Trucks per day</label>
                                    <input type="text" class="round_off_field text input75 sep_truck_per_day " value="1"  name="sep_truck_per_day">
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="days available for trucking" aria-hidden="true"></i> -->
                                    </div>
                                </td>
                            </tr>
                            <tr class="tr_info_tip">
                                <td>
                                    <div style="width:100%;float: left;">
                                        <label>Minimum Hours</label>
                                        <input type="text" class="number_field text input45 sep_minimum_hours" value="8" name="sep_minimum_hours">
                                        <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Minimum Hours available for trucking per day" aria-hidden="true"></i>
                                    </div>
                                    <div style="width:45%;float: left;">
                                        <!-- <label style="width: 50px;float: left;">Trucks per day</label>
                                    <input type="text" class="round_off_field text input75 sep_truck_per_day " value="1"  name="sep_truck_per_day">
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="days available for trucking" aria-hidden="true"></i> -->
                                    </div>
                                </td>
                            </tr>

                            <tr class="tr_info_tip">
                                <td>
                                    <label>Production Rate</label>
                                    <input type="text" class="round_off_field text input45 sep_daily_production_rate " value="<?= $settings->getProductionRate(); ?>" name="sep_daily_production_rate"><span class="after_input3" style="float:left">Tons / Day</span>
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Daily Production Rate" aria-hidden="true"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-content" style="width: 50%; float:left;">
                    <table class="boxed-table5 boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>


                            <tr class="tr_info_tip">
                                <td>
                                    <label>Miles</label>
                                    <input type="text" class="number_field hide_input_style input75 sep_trip_miles input_aling_left" readonly="readonly" style="text-align:left;float:left;box-shadow: none;border:0px;background:transparent;margin-left: 15px" name="trip_miles">

                                    <a class="sep_show_map btn blue-button " style="font-size:12px;float:right">Map</a>
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Trip distance - optimized for trucks" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Trips</label>
                                    <input type="text" class="number_field total_trips input_aling_left" readonly="readonly" style="text-align:left; width: 45px;box-shadow: none;border:0px;background:transparent;margin-left: 20px;margin-top: 6px;" name="total_trips">
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Tons divided by Truck Capacity" aria-hidden="true"></i>
                                </td>
                            </tr>
                            
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Rounds / Day</label>
                                    <span class="round_per_day truck_cal_span"></span>
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Hours divided by round time. Rounded down" aria-hidden="true"></i>
                                </td>
                            </tr>

                            <tr class="tr_info_tip">
                                <td>
                                    <label>Days</label>
                                    <input type="text" class="round_off_field text input30  sep_trucking_day" value="1" name="trucking_day">
                                    <!-- <span class="sep_trucking_day truck_cal_span"></span> -->
                                    <i style="float:left;" class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Tons / Tons per Truck per day. Rounded up" aria-hidden="true"></i>

                                    <label style="width:100px!important;position: absolute;right: 110px;">Trucks / day</label>
                                    <input type="text" class="round_off_field text input30 sep_truck_per_day " value="0" style="text-align: right;position: absolute;right: 60px;" name="truck_per_day">
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="# of trucks that be managed on site each day" aria-hidden="true"></i>

                                </td>
                            </tr>
                            
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Tons / Day</label>
                                    <span class="sep_tons_per_day truck_cal_span"></span>
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Tons per Day per Truck x # Trucks" aria-hidden="true"></i>
                                    <span style="display:none" class="recommended_trucks truck_cal_span"></span>
                                </td>
                            </tr>
                            <!-- <tr class="tr_info_tip" >
                            <td>
                                <labetr_info_tip># Trucks</label>
                                <span class="recommended_trucks truck_cal_span"></span>
                                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Number of trucks needed" aria-hidden="true"></i>
                            </td>
                        </tr> -->
                            <tr class="">
                                <td>
                                    <label>Total Hours</label>
                                    <input type="text" class="number_field perent_total_time input40 total_time_hours input_aling_left" readonly="readonly" style="width:40px;float: left;box-shadow: none;border:0px;background:transparent;margin-top: 6px;margin-left: 20px;text-align:left" name="total_time_hours">
                                    <input type="hidden" name="perent_custom_total_time" class="perent_custom_total_time" value="0">
                                    <i class="fa fa-exclamation-triangle fa-2x info_tip tiptipleft if_use_minimum_hours" title="Total hours have been increased to the minimum hours" aria-hidden="true"></i>
                                    <span class=" edit_perent_total_hours tiptipleft" title="Edit Total Hours" style="margin-right: 3px;float:right;margin-top: 5px;"><i class="fa fa-1x fa-pencil " style="position: relative;cursor:pointer;" aria-hidden="true"></i></span>
                                </td>
                            </tr>
                            
                            <tr class=" ">
                                <td>
                                    <label class="trucking_total_price_label">Trucking Total</label>

                                    <span style="margin-left: 15px;margin-top: 6px;float: left;" class="if_not_edit_item_total_price">$<span class="cal_total_price"></span></span>
                                    <input type="text" class="text input60 currency_field if_edit_item_total_price custom_total_price_input" style="margin-right:2px">
                                    <span class="if_edit_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                    <span class="item_total_edit_icon if_not_edit_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right;margin-top: 5px;"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>

                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    </form>

    <form id="time_type_form">
        <div class="form-group time_type" style="display:none; width: 300px;margin-right: 10px;">
            <div class="content-box">
                <div class="box-header centered ">Enter Details</div>

                <div class="box-content" style="width:100%; margin: 0px auto">
                    <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <label class="unit_type_name_text22">Days</label>
                                    <input type="text" name="time_type_input" id="time_type_input" value="0" class="text input45  round_off_field ">
                                    <i class="fa fa-info-circle  tiptip" title="Number of Days" style="float:right;margin-top: 8px;"></i>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="time_unit_type">Quantity</label>
                                    <input type="text" name="number_of_person" id="number_of_person" value="0" class="text input45  round_off_field ">
                                    <i class="fa fa-info-circle  tiptip" title="How many of this item" style="float:right;margin-top: 8px;"></i>
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <label>Hours per day</label>
                                    <input type="text" name="hour_per_day" id="hour_per_day" value="0" class="text input45  round_off_field ">
                                    <i class="fa fa-info-circle  tiptip" title="Number of hours per Day for this item" style="float:right;margin-top: 8px;"></i>
                                </td>
                            </tr>

                            <tr class="if_head_type_excavator" style="display:none; ">
                                <td style="border-top:2px solid #afafaf">
                                    <label>Measurement</label>
                                    <input type="text" class="text number_field input90 excavator_measurement" name="excavator_measurement">
                                </td>
                            </tr>
                            <tr class="if_head_type_excavator" style="display:none;">
                                <td>
                                    <label>Unit</label>
                                    <select style="float: right; border-radius: 3px; padding: 0.1em; width: 100px;" name="excavator_measurement_unit" class="excavator_measurement_unit field_input ">
                                        <option value="square yards">square yards</option>
                                        <option value="square feet">square feet</option>
                                    </select>

                                </td>
                            </tr>
                            <tr class="if_head_type_excavator" style="display:none;">
                                <td>
                                    <label>Depth (In)</label>
                                    <input type="text" class="text number_field  input90 excavator_depth" name="excavator_depth">
                                </td>
                            </tr>
                            <tr class="time_form_show_labor_big" style="display:none;">
                                <td>
                                    <p class="labor_check labor_child_icon child_check_icon  tiptip" title="Add Labor" style="cursor:pointer;float:left;width: 94%;padding: 0px 10px;">
                                        <span style="float:left">
                                            <i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i>
                                        </span>
                                        <label style="cursor:pointer">Labor</label>
                                        <span style="float:right">
                                            <a href="javascript:void('0');" style="color:#000"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                        </span>
                                    </p>
                                </td>
                            </tr>
                            <tr class="time_form_show_equipment_big" style="display:none;">
                                <td>
                                    <p class="equipement_check equipement_child_icon child_check_icon  tiptip" title="Add Equipment" style="cursor:pointer;float:left;width: 94%;padding: 0px 10px;">
                                        <span style="float:left"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-wrench fa-2x"></i></span>
                                        <label style="cursor:pointer">Equipment</label>
                                        <span style="float:right">
                                            <a href="javascript:void('0');" class="equipement_check" style="color:#000"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                        </span>
                                    </p>
                                </td>
                            </tr>
                            <?php if ($proposal_status_id != 5) { ?>

                                <tr class="first_small_icons">
                                    <td>
                                        <?php if (count($plants) > 0) { ?>

                                            <p class="if_head_type_excavator trucking_child_icon child_check_icon trucking_check tiptip" title="Add Trucking" style="display:none;width: 44%;float: left;cursor:pointer">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-truck fa-fw fa-2x "></i></span>


                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                            <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                        <?php } ?>
                                        <p class="time_form_show_labor_small labor_child_icon child_check_icon labor_check tiptip" title="Add Labor" style="cursor:pointer;display:none;width: 44%;float: left; ">
                                            <span style="float:left;margin: 0px 5px;">
                                                <i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i>
                                            </span>
                                            <!-- <label>Labor</label> -->
                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>
                                        </p>

                                        <!-- <p class="time_form_show_equipment"  style="display:none;">
                                    <span style="float:left;margin: 0px 5px;"  ><i style ="margin-top: 6px;font-size: 1.2em;" class="fa fa-wrench fa-fw fa-2x"></i></span>
                                    <span style="float:left;margin: 0px 5px;">
                                    <a href="javascript:void('0');" class="equipement_check tiptip" title="Add Equipment" style="color:#464646"><i style ="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                    </span>
                                </p> -->
                                    </td>
                                </tr>

                                <tr class="second_small_icons">
                                    <td>
                                        <p class="custom_child_icon child_check_icon custom_child_check tiptip" title="Add Custom" style="cursor:pointer;width: 25%;float: left;">
                                            <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>
                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>
                                        </p>
                                        <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                        <p class="fees_child_icon child_check_icon fees_child_check tiptip" data-type="fees" title="Add Fees" style="cursor:pointer;width: 25%;float: left;">
                                            <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-usd fa-fw fa-2x"></i></span>
                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>
                                        </p>
                                        <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                        <p class="permit_child_icon child_check_icon fees_child_check tiptip" data-type="permits" style="cursor:pointer;width: 25%;float: left;">
                                            <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-file-text-o fa-fw fa-2x"></i></span>
                                            <span style="float:right;margin: 0px 5px;">
                                                <a href="javascript:void('0');" class="fees_child_check tiptip" data-type="permits" title="Add Permits" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                            </span>
                                        </p>
                                    </td>
                                </tr>


                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="left time_type_calculation" style="width:300px;display:none;">
            <div>
                <div class="content-box blue">
                    <div class="box-header centered">Calculation</div>
                    <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <label class="blue-text time_unit_text"></label>
                                </td>
                                <td>
                                    <span class="total_time_value">0.00</span>

                                </td>
                            </tr>
                            <tr class="if_head_type_excavator">
                                <td>
                                    <label class="">Tons</label>
                                </td>
                                <td>
                                    <span class="excavator_item_quantity">0.00 </span><span class="black-slim-text"> </span>
                                </td>
                            </tr>
                            <tr class="if_fixed_rate_template_calculator_open">
                                <td>
                                    <label class="unit_price_label">Unit Price</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span> / <span class="unit_type_name_text2"></span></span>
                                    <?php //if($oh_pm_type==2){
                                    ?>
                                    <span style="float:right;">
                                        <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                    </span>
                                    <?php //}
                                    ?>
                                </td>
                            </tr>
                            <tr class="even show_overhead_and_profit if_fixed_rate_template_calculator_open">
                                <td>
                                    <label>Overhead %</label>
                                </td>
                                <td>
                                    <input type="text" name="cal_overhead" class="percentFormatN text2 cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="10" style="width: 60px; text-align: right;">
                                    <span class="cal_overhead_price after_input2" style="float:right"></span>
                                </td>
                            </tr>
                            <!-- <tr >
                            <td>
                                <label>Overhead Price</label>
                            </td>
                            <td>
                                <span class="cal_overhead_price after_input" ></span>
                            </td>
                        </tr> -->
                            <tr class="even show_overhead_and_profit if_fixed_rate_template_calculator_open">
                                <td>
                                    <label>Profit %</label>
                                </td>
                                <td>
                                    <input type="text" name="cal_profit" class="percentFormatN  text2 cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="10" style="width: 60px; text-align: right;">
                                    <span class="cal_profit_price after_input2" style="float:right"></span>
                                </td>
                            </tr>
                            <!-- <tr >
                            <td>
                                <label>Profit Price</label>
                            </td>
                            <td>
                                <span class="cal_profit_price after_input" ></span>
                            </td>
                        </tr> -->
                            <tr class="if_fixed_rate_template_calculator_open">
                                <td>

                                    <label style="margin-right: 0px;float: left;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                </td>
                                <td>

                                    <input type="text" name="cal_tax" class="percentFormat text text2 cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                    <span class="cal_tax_amount after_input2" style="float:right"></span>
                                </td>
                            </tr>
                            <!-- <tr class="cal_tax_amount_row" style="display:none">
                            <td>
                                <label>Tax Amount</label>
                            </td>
                            <td>
                                <input type="text" name="cal_tax_amount" class="number_field text text2 cal_tax_amount" value="0" style="width: 60px; text-align: right;">
                            </td>
                        </tr> -->
                            <tr class="if_tax_total  ">
                                <td>
                                    <label>Total Tax</label>
                                </td>
                                <td>

                                    <span style="float:left;margin-top: 1px;">$<span class="cal_total_tax_amount"></span></span>
                                    <span style="float:right;">
                                        <a href="javascript:void('0');" class="show_child_item_total_tax_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                    </span>
                                </td>
                            </tr>
                            <tr class="if_child_material_check_tax ">
                                <td>
                                    <label>Material Tax</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_material_total_price_tax"></span></span>

                                </td>
                            </tr>
                            <tr class="if_child_equipment_check_tax ">
                                <td>
                                    <label>Equipment Tax</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price_tax"></span></span>

                                </td>
                            </tr>
                            <tr class="if_child_trucking_check_tax ">
                                <td>
                                    <label>Trucking Tax</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price_tax"></span></span>


                                </td>
                            </tr>
                            <tr class="if_child_labor_check_tax ">
                                <td>
                                    <label>Labor Tax</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price_tax"></span></span>

                                </td>
                            </tr>
                            <tr class="if_child_custom_check_tax">
                                <td>
                                    <label>Custom Tax</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price_tax"></span></span>

                                </td>
                            </tr>
                            <tr class="if_child_parent_total">
                                <td>
                                    <label class="total_price_label">Total Price</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;font-weight: bold;" class="if_not_edit_parent_item_total_price">$<span class="cal_child_parent_total_price"></span></span>
                                    <input type="text" class="text input60 currency_field if_edit_parent_item_total_price custom_parent_total_price_input" style="margin-right:2px">
                                    <span style="float:right;">
                                        <a href="javascript:void('0');" class="show_child_item_total_check if_not_edit_parent_item_total_price" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                    </span>
                                    <span class="if_edit_parent_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_parent_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_parent_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                    <?php if ($account->getEditPrice()) { ?>
                                        <span class="item_parant_total_edit_icon if_not_edit_parent_item_total_price tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                    <?php } ?>
                                </td>
                            </tr>

                            <tr class="if_nochild_items if_fixed_rate_template_calculator_open">
                                <td>
                                    <label class="if_child_items_lable_text total_price_label">Total Price</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;" class="if_not_edit_item_total_price">$<span class="cal_total_price"></span></span>
                                    <input type="text" class="text input60 currency_field if_edit_item_total_price custom_total_price_input" style="margin-right:2px">
                                    <span class="if_edit_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                    <?php if ($account->getEditPrice()) { ?>
                                        <span class="item_total_edit_icon if_not_edit_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                    <?php } ?>
                                    <span style="float:right;" class="parent_total_percent">

                                    </span>
                                </td>
                            </tr>
                            <tr class="if_child_equipment_check ">
                                <td>
                                    <label>Equipment Total</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price"></span></span>
                                    <span style="float:right;" class="child_equipment_total_percent"></span>
                                </td>
                            </tr>
                            <tr class="if_child_trucking_check ">
                                <td>
                                    <label>Trucking Total</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price"></span></span>
                                    <span style="float:right;" class="child_trucking_total_percent"></span>

                                </td>
                            </tr>
                            <tr class="if_child_labor_check ">
                                <td>
                                    <label>Labor Total</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price"></span></span>
                                    <span style="float:right;" class="child_labor_total_percent"></span>
                                </td>
                            </tr>
                            <tr class="if_child_default_check ">
                                <td>
                                    <label>Additive / Sand</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_default_total_price"></span></span>
                                    <span style="float:right;" class="child_default_total_percent"></span>
                                </td>
                            </tr>
                            <tr class="if_child_custom_check">
                                <td>
                                    <label>Custom Total</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price"></span></span>
                                    <span style="float:right;" class="child_custom_total_percent"></span>
                                </td>
                            </tr>
                            <tr class="if_child_fees_check">
                                <td>
                                    <label>Fees Total</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_fees_total_price"></span></span>
                                    <span style="float:right;" class="child_fees_total_percent"></span>
                                </td>
                            </tr>
                            <tr class="if_child_permit_check">
                                <td>
                                    <label>Permit Total</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_child_permit_total_price"></span></span>
                                    <span style="float:right;" class="child_permit_total_percent"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <!-- <p class="adminInfoMessage if_fixed_rate_template_calculator_open" style="width: 289px;margin: 0px 1px 0px 0px;float: right;display:none;"><i class="fa fa-fw fa-info-circle"></i>Item is part of fixed template so price cannot be edited.</p> -->
    </form>


    <form id="concrete_form">
        <div class="clearfix">
            <div style="width:300px;float:left;margin-right: 10px;" class="show_in_concrete">
                <div class="content-box" style="overflow:hidden">
                    <div class="box-header centered calculator_service_title2" style="width:100%;text-align:center">Details</div>
                    <div id="service_html_box4" class="box-content service_html_box">

                    </div>
                </div>
            </div>
            <div class="left" style="width: 250px;margin-right: 10px;">
                <div class="content-box">
                    <div class="box-header centered ">Enter Details</div>

                    <div class="box-content" style="width: 100%;margin: 0px auto;">
                        <table class="boxed-table stripping-row " border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <label style="width:120px;">Measurement</label>
                                        <input type="text" name="concrete_measurement" id="concrete_measurement" value="0" class="text number_field input75">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label style="width:120px;">Depth</label>
                                        <input type="text" name="concrete_depth" id="concrete_depth" value="0" class="text number_field input75">
                                    </td>
                                </tr>
                                <?php if (count($plants) > 0) { ?>


                                    <!-- <tr>
                                    <td>
                                        <span style="float:left" >
                                        <i style ="margin-top: 6px;font-size: 1.2em;" class="fa fa-truck fa-2x "></i>
                                        </span>
                                        <label>Trucking</label>
                                        <span style="float:right">

                                        <a href="javascript:void('0');" class="trucking_check" style="color:#000"><i style ="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                        </span>
                                    </td>
                                </tr> -->
                                <?php } ?>
                                <?php if ($proposal_status_id != 5) { ?>
                                    <tr>
                                        <td>

                                            <p class="labor_child_icon child_check_icon labor_check tiptip" title="Add Labor" style="cursor:pointer;width: 44%;float: left;">
                                                <span style="float:left;margin: 0px 5px;">
                                                    <i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i>
                                                </span>

                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>

                                            </p>
                                            <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                            <p class="equipement_child_icon child_check_icon equipement_check tiptip" title="Add Equipment" style="cursor:pointer;width: 43%;float: left;">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-wrench fa-fw fa-2x"></i></span>
                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="custom_child_icon child_check_icon custom_child_check tiptip" title="Add Custom" style="cursor:pointer;width: 25%;float: left;">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>
                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                            <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                            <p class="fees_child_icon child_check_icon fees_child_check tiptip" data-type="fees" title="Add Fees" style="cursor:pointer;width: 25%;float: left;">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-usd fa-fw fa-2x"></i></span>
                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                            <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                            <p class="permit_child_icon child_check_icon fees_child_check tiptip" data-type="permits" style="cursor:pointer;width: 25%;float: left;">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-file-text-o fa-fw fa-2x"></i></span>
                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" class="fees_child_check tiptip" data-type="permits" title="Add Permits" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="left" style="width:300px;">
                <div>
                    <div class="content-box blue">
                        <div class="box-header centered">Calculation</div>
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100">
                                        <label>Cubic Yards</label>
                                    </td>
                                    <td>
                                        <span id="concrete_area"></span> <span id="concrete_area_unit"></span>
                                    </td>
                                </tr>

                                <!-- <tr >
                                <td>
                                    <label class="unit_price_label">Unit Price</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                    <?php //if($oh_pm_type==2){
                                    ?>
                                        <span style="float:right;">
                                        <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                    <?php //}
                                    ?>
                                </td>
                            </tr> -->

                                <tr>
                                    <td>
                                        <label class="unit_price_label">Unit Price</label>
                                    </td>
                                    <td>
                                        <span class="hide_if_edit_item_unit_price" style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                        <input type="text" name="custom_unit_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_price_input" style="margin-right:2px">
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>

                                        <!--Edit Unit Price Buttons-->

                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="if_edit_item_unit_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_unit_price_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_unit_price" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>

                                            <span class="item_unit_edit_icon  tiptipleft" title="Edit Unit Price" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                        <!--End Edit Unit Price Buttons-->
                                    </td>
                                </tr>
                                <tr class="if_edit_item_unit_price">
                                    <td>
                                        <label class="base_price_label">Base Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><input type="text" name="custom_unit_base_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_base_price_input" style="margin-right:2px"><span class="cal_unit_single_name" style="margin-top: 5px;float: left;"></span></span>

                                    </td>
                                </tr>
                                <tr class="even show_overhead_and_profit">
                                    <td>
                                        <label>Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_overhead" class="percentFormatN  text2 cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                        <span class="cal_overhead_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>
                                <!-- <tr >
                                <td>
                                    <label>Overhead Price</label>
                                </td>
                                <td>
                                    <span class="cal_overhead_price after_input" ></span>
                                </td>
                            </tr> -->
                                <tr class="even show_overhead_and_profit">
                                    <td>
                                        <label>Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_profit" class="percentFormatN  text2 cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                        <span class="cal_profit_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>
                                <!-- <tr >
                                <td>
                                    <label>Profit Price</label>
                                </td>
                                <td>
                                    <span class="cal_profit_price after_input" ></span>
                                </td>
                            </tr> -->
                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: left;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="cal_tax_amount after_input2"></span>
                                    </td>
                                </tr>
                                <!-- Per Load Input Start -->
                                <tr>
                                    <td>
                                        <label style="margin-right: 0px;float: left;">Disposal <span class="cal_disposal_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="cal_disposal_checkbox" name="cal_disposal_checkbox" value="1" /> </span> </label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_disposal_input" class="text text2 cal_disposal_input" value="0" style="width: 60px; text-align: right; display:none"> <span class="per_load" style="margin-top:6px;display: block;"> # loads</span>
                                    </td>
                                </tr>
                                <tr style="display:none" class="per_load">
                                    <td>

                                    </td>
                                    <td>
                                        <input type="text" name="cal_disposal_per_load_input" class="currency_field text text2 cal_disposal_per_load_input" value="<?= $settings->getDisposalLoad();?>" style="width: 60px; text-align: right;"> <span style="margin-top:6px;position: absolute;">$ Per Load</span>
                                    </td>
                                </tr>
                                <tr class="disposalTotalAmount" style="display:none;">
                                    <td>
                                        <label>Disposal Total </label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_total_disposal_amount"></span></span>
                                    </td>
                                </tr>
                                <!-- Per Load Input End -->
                                <!-- <tr class="cal_tax_amount_row" style="display:none">
                                <td>
                                    <label>Tax Amount</label>
                                </td>
                                <td>
                                    <input type="text" name="cal_tax_amount" class="number_field text text2 cal_tax_amount" value="0" style="width: 60px; text-align: right;">
                                </td>
                            </tr> -->
                                <tr class="cost_per_unit_tr  ">
                                    <td>
                                        <label>Cost / yard</label>
                                    </td>
                                    <td>

                                        <span style="float:left;margin-top: 1px;">$<span class="cost_per_unit"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_tax_total  ">
                                    <td>
                                        <label>Total Tax</label>
                                    </td>
                                    <td>

                                        <span style="float:left;margin-top: 1px;">$<span class="cal_total_tax_amount"></span></span>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="show_child_item_total_tax_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="if_child_material_check_tax ">
                                    <td>
                                        <label>Material Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_material_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_equipment_check_tax ">
                                    <td>
                                        <label>Equipment Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_trucking_check_tax ">
                                    <td>
                                        <label>Trucking Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price_tax"></span></span>


                                    </td>
                                </tr>
                                <tr class="if_child_labor_check_tax ">
                                    <td>
                                        <label>Labor Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_custom_check_tax">
                                    <td>
                                        <label>Custom Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_parent_total">
                                    <td>
                                        <label class="total_price_label">Total Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;font-weight: bold;" class="if_not_edit_parent_item_total_price">$<span class="cal_child_parent_total_price"></span></span>
                                        <input type="text" class="text input60 currency_field if_edit_parent_item_total_price custom_parent_total_price_input" style="margin-right:2px">
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="show_child_item_total_check if_not_edit_parent_item_total_price" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>

                                        <span class="if_edit_parent_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_parent_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_parent_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>

                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_parant_total_edit_icon if_not_edit_parent_item_total_price tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr class="if_nochild_items ">
                                    <td>
                                        <label class="if_child_items_lable_text total_price_label">Total Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;" class="if_not_edit_item_total_price">$<span class="cal_total_price"></span></span>
                                        <input type="text" class="text input60 currency_field if_edit_item_total_price custom_total_price_input" style="margin-right:2px">
                                        <span class="if_edit_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_total_edit_icon if_not_edit_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                        <span style="float:right;" class="parent_total_percent">

                                        </span>
                                    </td>
                                </tr>
                                <tr class="if_child_equipment_check ">
                                    <td>
                                        <label>Equipment Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price"></span></span>
                                        <span style="float:right;" class="child_equipment_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_trucking_check ">
                                    <td>
                                        <label>Trucking Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price"></span></span>
                                        <span style="float:right;" class="child_trucking_total_percent"></span>

                                    </td>
                                </tr>
                                <tr class="if_child_labor_check ">
                                    <td>
                                        <label>Labor Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price"></span></span>
                                        <span style="float:right;" class="child_labor_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_default_check ">
                                    <td>
                                        <label>Additive / Sand</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_default_total_price"></span></span>
                                        <span style="float:right;" class="child_default_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_custom_check">
                                    <td>
                                        <label>Custom Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price"></span></span>
                                        <span style="float:right;" class="child_custom_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_fees_check">
                                    <td>
                                        <label>Fees Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_fees_total_price"></span></span>
                                        <span style="float:right;" class="child_fees_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_permit_check">
                                    <td>
                                        <label>Permit Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_permit_total_price"></span></span>
                                        <span style="float:right;" class="child_permit_total_percent"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <form id="sealcoating_material_form">
        <div class="clearfix">
            <div style="width:300px;float:left;margin-right: 10px;" class="">
                <div class="content-box" style="overflow:hidden">
                    <div class="box-header centered calculator_service_title2" style="width:100%;text-align:center">Details</div>
                    <div id="service_html_box9" class="box-content service_html_box">

                    </div>
                </div>
            </div>
            <div class="left" style="width: 250px;margin-right: 10px;">
                <div class="content-box">
                    <div class="box-header centered ">Enter Details</div>

                    <div class="box-content" style="width: 100%;margin: 0px auto;">
                        <table class="boxed-table stripping-row " border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <label style="width:120px;">Quantity</label>
                                        <input type="text" name="sealcoating_material_quantity" id="sealcoating_material_quantity" value="" class="text input75">
                                    </td>
                                </tr>
                                <?php if ($proposal_status_id != 5) { ?>
                                    <tr>
                                        <td>

                                            <p class="labor_child_icon child_check_icon labor_check tiptip" title="Add Labor" style="cursor:pointer;width: 44%;float: left;">
                                                <span style="float:left;margin: 0px 5px;">
                                                    <i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i>
                                                </span>

                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>

                                            </p>
                                            <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                            <p class="equipement_child_icon child_check_icon equipement_check tiptip" title="Add Equipment" style="cursor:pointer;width: 43%;float: left;">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-wrench fa-fw fa-2x"></i></span>
                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="custom_child_icon child_check_icon custom_child_check tiptip" title="Add Custom" style="cursor:pointer;width: 25%;float: left;">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>
                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                            <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                            <p class="fees_child_icon child_check_icon fees_child_check tiptip" data-type="fees" title="Add Fees" style="cursor:pointer;width: 25%;float: left;">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-usd fa-fw fa-2x"></i></span>
                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                            <hr style="border: none;border-left:    1px solid hsla(200, 10%, 50%,100);height: 25px;width:1px;float: left;margin: 0px 12px;">
                                            <p class="permit_child_icon child_check_icon fees_child_check tiptip" data-type="permits" style="cursor:pointer;width: 25%;float: left;">
                                                <span style="float:left;margin: 0px 5px;"><i style="margin-top: 6px;font-size: 1.2em;" class="fa fa-file-text-o fa-fw fa-2x"></i></span>
                                                <span style="float:right;margin: 0px 5px;">
                                                    <a href="javascript:void('0');" class="fees_child_check tiptip" data-type="permits" title="Add Permits" style="color:#464646"><i style="margin-top: 4px;font-size: 1.6em;" class="fa fa-plus-circle fa-2x"></i></a>
                                                </span>
                                            </p>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="left" style="width:300px;">
                <div>
                    <div class="content-box blue">
                        <div class="box-header centered">Calculation</div>
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td width="100">
                                        <label>Total Quantity</label>
                                    </td>
                                    <td>
                                        <span id="sealcoating_material_total_quantity">0</span> <span id="sealcoating_material_quantity_unit"></span>
                                    </td>
                                </tr>

                                <!-- <tr >
                                <td>
                                    <label class="unit_price_label">Unit Price</label>
                                </td>
                                <td>
                                    <span style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                    <?php //if($oh_pm_type==2){
                                    ?>
                                        <span style="float:right;">
                                        <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                    <?php // }
                                    ?>
                                </td>
                            </tr> -->

                                <tr>
                                    <td>
                                        <label class="unit_price_label">Unit Price</label>
                                    </td>
                                    <td>
                                        <span class="hide_if_edit_item_unit_price" style="float:left;margin-top: 1px;">$<span class="cal_unit_price"></span><span class="cal_unit_single_name"></span></span>
                                        <input type="text" name="custom_unit_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_price_input" style="margin-right:2px">
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>

                                        <!--Edit Unit Price Buttons-->

                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="if_edit_item_unit_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_unit_price_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_unit_price" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>

                                            <span class="item_unit_edit_icon  tiptipleft" title="Edit Unit Price" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                        <!--End Edit Unit Price Buttons-->
                                    </td>
                                </tr>
                                <tr class="if_edit_item_unit_price">
                                    <td>
                                        <label class="base_price_label">Base Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><input type="text" name="custom_unit_base_price_input" class="text input60 currency_field if_edit_item_unit_price custom_unit_base_price_input" style="margin-right:2px"><span class="cal_unit_single_name" style="margin-top: 5px;float: left;"></span></span>

                                    </td>
                                </tr>

                                <tr class="even show_overhead_and_profit">
                                    <td>
                                        <label>Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_overhead" class="percentFormatN  text2 cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                        <span class="cal_overhead_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>
                                <!-- <tr >
                                <td>
                                    <label>Overhead Price</label>
                                </td>
                                <td>
                                    <span class="cal_overhead_price after_input" ></span>
                                </td>
                            </tr> -->
                                <tr class="even show_overhead_and_profit">
                                    <td>
                                        <label>Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_profit" class="percentFormatN  text2 cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> style="width: 60px; text-align: right;">
                                        <span class="cal_profit_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>
                                <!-- <tr >
                                <td>
                                    <label>Profit Price</label>
                                </td>
                                <td>
                                    <span class="cal_profit_price after_input" ></span>
                                </td>
                            </tr> -->
                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: left;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="cal_tax_amount after_input2" style="float:right"></span>
                                    </td>
                                </tr>
                                <!-- <tr class="cal_tax_amount_row" style="display:none">
                                <td>
                                    <label>Tax Amount</label>
                                </td>
                                <td>
                                    <input type="text" name="cal_tax_amount" class="number_field text text2 cal_tax_amount" value="0" style="width: 60px; text-align: right;">
                                </td>
                            </tr> -->
                                <!-- <tr class="cost_per_unit_tr  ">
                                    <td>
                                        <label >Cost / yard</label>
                                    </td>
                                    <td>
                                        
                                        <span style="float:left;margin-top: 1px;" >$<span class="cost_per_unit"></span></span>
                                        
                                    </td>
                                </tr> -->
                                <tr class="if_tax_total  ">
                                    <td>
                                        <label>Total Tax</label>
                                    </td>
                                    <td>

                                        <span style="float:left;margin-top: 1px;">$<span class="cal_total_tax_amount"></span></span>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="show_child_item_total_tax_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="if_child_material_check_tax ">
                                    <td>
                                        <label>Material Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_material_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_equipment_check_tax ">
                                    <td>
                                        <label>Equipment Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_trucking_check_tax ">
                                    <td>
                                        <label>Trucking Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price_tax"></span></span>


                                    </td>
                                </tr>
                                <tr class="if_child_labor_check_tax ">
                                    <td>
                                        <label>Labor Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price_tax"></span></span>

                                    </td>
                                </tr>
                                <tr class="if_child_custom_check_tax">
                                    <td>
                                        <label>Custom Tax</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price_tax"></span></span>

                                    </td>
                                </tr>



                                <tr class="if_child_parent_total">
                                    <td>
                                        <label class="total_price_label">Total Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;font-weight: bold;" class="if_not_edit_parent_item_total_price">$<span class="cal_child_parent_total_price"></span></span>
                                        <input type="text" class="text input60 currency_field if_edit_parent_item_total_price custom_parent_total_price_input" style="margin-right:2px">
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="show_child_item_total_check if_not_edit_parent_item_total_price" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <span class="if_edit_parent_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_parent_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_parent_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_parant_total_edit_icon if_not_edit_parent_item_total_price tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr class="if_nochild_items ">
                                    <td>
                                        <label class="if_child_items_lable_text total_price_label">Total Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;" class="if_not_edit_item_total_price">$<span class="cal_total_price"></span></span>
                                        <input type="text" class="text input60 currency_field if_edit_item_total_price custom_total_price_input" style="margin-right:2px">
                                        <span class="if_edit_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_total_edit_icon if_not_edit_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                        <span style="float:right;" class="parent_total_percent">

                                        </span>
                                    </td>
                                </tr>




                                <!-- <tr class="if_child_parent_total">
                                    <td>
                                        <label>Total Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;font-weight: bold;" >$<span class="cal_child_parent_total_price"></span></span>
                                        <span style="float:right;">
                                        <a href="javascript:void('0');" class="show_child_item_total_check" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="if_nochild_items ">
                                    <td>
                                        <label class="if_child_items_lable_text">Total Price</label>
                                    </td>
                                    <td>
                                        
                                        <span style="float:left;margin-top: 1px;" >$<span class="cal_total_price"></span></span>
                                        <span style="float:right;" class="parent_total_percent">
                                        
                                        </span>
                                    </td>
                                </tr> -->
                                <tr class="if_child_equipment_check ">
                                    <td>
                                        <label>Equipment Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_equipment_total_price"></span></span>
                                        <span style="float:right;" class="child_equipment_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_trucking_check ">
                                    <td>
                                        <label>Trucking Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_trucking_total_price"></span></span>
                                        <span style="float:right;" class="child_trucking_total_percent"></span>

                                    </td>
                                </tr>
                                <tr class="if_child_labor_check ">
                                    <td>
                                        <label>Labor Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_labor_total_price"></span></span>
                                        <span style="float:right;" class="child_labor_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_default_check ">
                                    <td>
                                        <label>Additive / Sand</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_default_total_price"></span></span>
                                        <span style="float:right;" class="child_default_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_custom_check">
                                    <td>
                                        <label>Custom Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_custom_total_price"></span></span>
                                        <span style="float:right;" class="child_custom_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_fees_check">
                                    <td>
                                        <label>Fees Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_fees_total_price"></span></span>
                                        <span style="float:right;" class="child_fees_total_percent"></span>
                                    </td>
                                </tr>
                                <tr class="if_child_permit_check">
                                    <td>
                                        <label>Permit Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;">$<span class="cal_child_permit_total_price"></span></span>
                                        <span style="float:right;" class="child_permit_total_percent"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <div class="full-width materialize" style="margin-bottom:10px">

        <a href="JavaScript:void(0);" class="estimate_item_notes m-btn m-btn-default tiptip" title="Notes" style="width:80px;float:left;display:block; margin-top: 6px;margin-right:10px;font-size: 14px;"><i class="fa fa-clipboard"></i>&nbsp; Notes</a>
        <p class="if_error_show_msg_parent" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 70%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
        <p class="if_trucking_change_show_msg_parent" style="float:left;text-align: center;border: 2px solid red;padding: 7px 10px;width: 70%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Material Quantity Changed. Trucking will automatically update.</p>
        <!-- <a href="JavaScript:void(0);" class="select_template_show_btn btn tiptip" title="Templates" style="width:100px;float:left;display:block; margin-top: 6px;"><i class="fa fa-files-o"></i> Templates</a>
        <span class="select_template_show" style="display:none"><select class="select_template_option dont-uniform"></select></span> -->
        <!---Start Filter button---->
        <div class="materialize" style="float: left;margin-top: 6px;margin-right: 10px;">

            <div class="m-btn groupAction tiptip" id="groupAction" style="position: relative;display:none;font-size: 14px;" title="Carry out actions on selected contacts">
                <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                <div class="groupActionsContainer materialize" style="width:160px">
                    <div class="collection groupActionItems">

                        <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                            <i class="fa fa-fw fa-trash"></i> Delete Items
                        </a>

                    </div>
                </div>
            </div>

        </div>
        <!---End Filter button---->
        <?php if ($proposal_status_id != 5) { ?>
            <a href="JavaScript:void(0);" class="m-btn save_estimation" id="continue2" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
        <?php } ?>
    </div>
    <div class="child_items_list"></div>

    <div class="full-width">
        <!-- <p class="if_error_show_msg_parent" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 70%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p> -->
        <!-- <a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" style="width:80px;float:left;display:block"><i class="fa fa-clipboard"></i> Notes</a>
        <input class="btn update-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only save_estimation" id="continue2" style="padding: 0.7em 1em;float:right" type="button"   value="Save"> -->
    </div>
</div>

<div id="add_custom_item_model">
    <div class="according-body body2">

        <div class="full-width">
            <h4 class='' style='text-align:center!important;'><span style="padding: 3px 5px;border-radius: 3px;background-color: #282828;color: #ececec;" class="add_custom_item_model_title_service">Custom</span> <span class="add_custom_item_model_title_type" style="color: #3f3f41;"> Custom Items</span> | <span style="color: #3f3f41;" class="add_custom_item_model_title_item">Custom Item</span>
                <span class="if_custom_item_saved" style="right: 17px; top: 9px; position: absolute; width: 80px; padding: 3px 5px; border-radius: 3px; background-color: rgb(81, 166, 75); color: rgb(255, 255, 255);display: block;"><i class="fa fa-fw fa-check-circle " style="font-size: 18px;margin-top: 3px;float:left;"></i><span style="color: #fff;position: relative;top: 2px;">Saved</span></span>
            </h4>

        </div>
        <div style="width:250px;float:left;margin-right: 10px;">
            <div class="content-box" style="overflow:hidden">
                <div class="box-header centered custom_item_calculator_heading22">Details</div>
                <div id="service_html_box2" class="box-content">

                </div>
            </div>

        </div>
        <form id="add_custom_item_form">
            <div style=" width: 300px;float:left;margin-right: 10px;">
                <div class="content-box ">
                    <div class="box-header centered">Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="time_unit_type">Name</label>
                                        <input type="text" name="custom_item_name" id="custom_item_name" value="" class="text   " style="width:150px!important;">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Quantity</label>
                                        <input type="text" name="custom_item_quantity" id="custom_item_quantity" value="" class="text  round_off_field " style="width:130px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="custom_unit_price_label">Base Unit Price</label>
                                        <input type="text" name="custom_item_unit_price" id="custom_item_unit_price" class="text  currency_field " style="width:130px;">
                                        <input type="hidden" name="custom_item_type" id="custom_item_type">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Notes</label>
                                        <textarea name="custom_item_notes" id="custom_item_notes" class="cust_textarea" style="width:155px;"></textarea>
                                        <br />
                                        <label class="unit_type_name_text22">&nbsp;</label>
                                        <input name="custom_work_order" id="custom_work_order" value="1" type="checkbox">
                                        <span style="top: 5px;position: relative;">Include in Work Order</span>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="left " style="width:300px;">
                <div>
                    <div class="content-box blue">
                        <div class="box-header centered">Calculation</div>
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>


                                <tr>
                                    <td>
                                        <label class="unit_price_label">Unit Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><span class="custome_item_unit_price_text"></span></span>
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="custom_cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>
                                    </td>
                                </tr>
                                <tr class="even show_custom_overhead_and_profit">
                                    <td>
                                        <label>Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="custome_item_overhead" class="percentFormatN  text2 custome_item_overhead <?php if ($oh_pm_type == 1) {
                                                                                                                                                echo 'hide_input_style3';
                                                                                                                                            } else {
                                                                                                                                                echo 'text';
                                                                                                                                            } ?>" value="10" style="width: 60px; text-align: right;" <?php if ($oh_pm_type == 1) {
                                                                                                                                                                                                                                                                            echo 'readonly';
                                                                                                                                                                                                                                                                        } ?>>
                                        <span class="custome_item_overhead_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>

                                <tr class="even show_custom_overhead_and_profit">
                                    <td>
                                        <label>Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="custome_item_profit" class="percentFormatN text2 custome_item_profit <?php if ($oh_pm_type == 1) {
                                                                                                                                            echo 'hide_input_style3';
                                                                                                                                        } else {
                                                                                                                                            echo 'text';
                                                                                                                                        } ?>" value="10" style="width: 60px; text-align: right;" <?php if ($oh_pm_type == 1) {
                                                                                                                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                                                                                                                    } ?>>
                                        <span class="custome_item_profit_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: left;">Tax <span class="custome_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="custome_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 custome_tax_rate" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="custome_tax_amount after_input2" style="float:right"></span>
                                    </td>
                                </tr>

                                <tr class="even">
                                    <td>
                                        <label class="total_price_label">Total Price</label>
                                    </td>
                                    <td>
                                        <span class="if_not_edit_custom_item_total_price">$<span class="custom_item_total_price ">0</span></span>
                                        <input type="text" class="text input60 currency_field if_edit_custom_item_total_price custom_total_price_input_sep" style="margin-right:2px">
                                        <span class="if_edit_custom_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_custom_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_custom_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="custom_item_total_edit_icon if_not_edit_custom_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;text-align: center;border: 2px solid red;padding: 7px 10px;width: 85%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>


            <?php if ($proposal_status_id != 5) { ?>
                <a href="JavaScript:void(0);" class="m-btn " onclick="save_custom_item('');" id="continue3" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>
<div id="add_custom_child_item_model" title="Add Custom Item">
    <div class="according-body body2">

        <div class="full-width">
            <!-- <h4 class="custom_child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4> -->
            <h4 class='' style='text-align:center!important;'><span style="padding: 3px 5px;border-radius: 3px;background-color: #282828;color: #ececec;">Custom</span> <span style="color: #3f3f41;"> Custom Items</span> | <span style="color: #3f3f41;">Custom Item</span></h4>
        </div>

        <form id="add_custom_child_item_form">
            <div style=" width: 425px;float:left;margin-right: 10px;">
                <div class="content-box ">
                    <div class="box-header centered">Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="time_unit_type">Name</label>
                                        <input type="text" name="custom_child_item_name" id="custom_child_item_name" value="" class="text   " style="width:130px;">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Quantity</label>
                                        <input type="text" name="custom_child_item_quantity" id="custom_child_item_quantity" value="" class="text  round_off_field " style="width:130px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Base Unit Price</label>
                                        <input type="text" name="custom_child_item_unit_price" id="custom_child_item_unit_price" class="text  currency_field " style="width:130px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Notes</label>
                                        <p style="width: 300px">
                                            <textarea name="custom_child_item_notes" id="custom_child_item_notes" class="cust_textarea" style="width:155px;"></textarea>

                                            <label class="unit_type_name_text22">&nbsp;</label>
                                            <input name="child_custom_work_order" id="child_custom_work_order" value="1" type="checkbox">
                                            <span style="top: 5px;position: relative;">Include in Work Order</span>
                                        </p>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="left " style="width:425px;">
                <div>
                    <div class="content-box blue">
                        <div class="box-header centered">Calculation</div>
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>


                                <tr>
                                    <td>
                                        <label>Unit Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><span class="custome_child_item_unit_price_text"></span></span>
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="custom_child_cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>
                                    </td>
                                </tr>
                                <tr class="even show_custom_child_overhead_and_profit">
                                    <td>
                                        <label>Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" data-old-val="" name="custome_child_item_overhead" class="percentFormatN  text2 custome_child_item_overhead <?php if ($oh_pm_type == 1) {
                                                                                                                                                                            echo 'hide_input_style3';
                                                                                                                                                                        } else {
                                                                                                                                                                            echo 'text';
                                                                                                                                                                        } ?>" value="10" style="width: 60px; text-align: right;" <?php if ($oh_pm_type == 1) {
                                                                                                                                                                                                                                                                                                        echo 'readonly';
                                                                                                                                                                                                                                                                                                    } ?>>
                                        <span style="float:right;" class="custome_child_item_overhead_price after_input2"></span>
                                    </td>
                                </tr>

                                <tr class="even show_custom_child_overhead_and_profit">
                                    <td>
                                        <label>Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" data-old-val="" name="custome_child_item_profit" class="percentFormatN text2 custome_child_item_profit <?php if ($oh_pm_type == 1) {
                                                                                                                                                                        echo 'hide_input_style3';
                                                                                                                                                                    } else {
                                                                                                                                                                        echo 'text';
                                                                                                                                                                    } ?>" value="10" style="width: 60px; text-align: right;" <?php if ($oh_pm_type == 1) {
                                                                                                                                                                                                                                                                                                    echo 'readonly';
                                                                                                                                                                                                                                                                                                } ?>>
                                        <span style="float:right;" class="custome_child_item_profit_price after_input2"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: left;">Tax <span class="custome_child_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="custome_child_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 custome_child_tax_rate" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="custome_child_tax_amount after_input2"></span>
                                    </td>
                                </tr>

                                <tr class="even">
                                    <td>
                                        <label>Total Price</label>
                                    </td>
                                    <td>



                                        <span class="if_not_edit_custom_item_total_price">$<span class="custom_child_item_total_price">0.00</span></span>
                                        <input type="text" class="text input60 currency_field  custom_custom_total_price_input" style="margin-right:2px">
                                        <span class="if_edit_custom_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_custom_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_custom_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_custom_total_edit_icon  tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 85%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>
                <a href="JavaScript:void(0);" class="m-btn save_custom_child_estimation" id="custom_child_save_btn" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>
<div id="add_fees_child_item_model" title="">
    <div class="according-body body2">

        <div class="full-width">
            <!-- <h4 class="fees_child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4> -->
            <h4 class='fees_type_name' style='text-align:center;width: 100%;'>Fees Item</h4>
        </div>

        <form id="add_fees_child_item_form">
            <div style=" width: 425px;float:left;margin-right: 10px;">
                <div class="content-box ">
                    <div class="box-header centered">Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="time_unit_type">Name</label>
                                        <input type="text" name="fees_child_item_name" id="fees_child_item_name" value="" class="text   " style="width:200px!important;">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Quantity</label>
                                        <input type="text" name="fees_child_item_quantity" id="fees_child_item_quantity" value="1" class="text  round_off_field " style="width:130px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Fee</label>
                                        <input type="text" name="fees_child_item_unit_price" id="fees_child_item_unit_price" class="text  currency_field " style="width:130px;">
                                        <input type="hidden" name="is_fees_type" id="is_fees_type">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Notes</label>
                                        <p style="width:300px">
                                            <textarea name="fees_child_item_notes" id="fees_child_item_notes" class="cust_textarea" style="width:155px;"></textarea>
                                            <label class="">&nbsp;</label>
                                            <input name="child_fees_work_order" id="child_fees_work_order" value="1" type="checkbox">
                                            <span style="top: 5px;position: relative;">Include in Work Order</span>
                                        </p>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="left " style="width:425px;">
                <div>
                    <div class="content-box blue">
                        <div class="box-header centered">Calculation</div>
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>


                                <tr>
                                    <td>
                                        <label>Unit Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><span class="fees_child_item_unit_price_text"></span></span>
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="custom_child_cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>
                                    </td>
                                </tr>
                                <tr class="even show_custom_child_overhead_and_profit">
                                    <td>
                                        <label>Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" data-old-val="" name="fees_child_item_overhead" class="percentFormatN  text2 fees_child_item_overhead <?php if ($oh_pm_type == 1) {
                                                                                                                                                                        echo 'hide_input_style3';
                                                                                                                                                                    } else {
                                                                                                                                                                        echo 'text';
                                                                                                                                                                    } ?>" value="10" style="width: 60px; text-align: right;" <?php if ($oh_pm_type == 1) {
                                                                                                                                                                                                                                                                                                    echo 'readonly';
                                                                                                                                                                                                                                                                                                } ?>>
                                        <span style="float:right;" class="fees_child_item_overhead_price after_input2"></span>
                                    </td>
                                </tr>

                                <tr class="even show_custom_child_overhead_and_profit">
                                    <td>
                                        <label>Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" data-old-val="" name="fees_child_item_profit" class="percentFormatN  text2 fees_child_item_profit <?php if ($oh_pm_type == 1) {
                                                                                                                                                                    echo 'hide_input_style3';
                                                                                                                                                                } else {
                                                                                                                                                                    echo 'text';
                                                                                                                                                                } ?>" value="10" style="width: 60px; text-align: right;" <?php if ($oh_pm_type == 1) {
                                                                                                                                                                                                                                                                                                echo 'readonly';
                                                                                                                                                                                                                                                                                            } ?>>
                                        <span style="float:right;" class="fees_child_item_profit_price after_input2"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: left;">Tax <span class="fees_child_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="fees_child_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 fees_child_tax_rate" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="fees_child_tax_amount after_input2"></span>
                                    </td>
                                </tr>

                                <tr class="even">
                                    <td>
                                        <label class="fees_child_item_total_price_lable">Total Price</label>
                                    </td>
                                    <td>

                                        <span class="if_not_edit_fees_item_total_price">$<span class="fees_child_item_total_price">0.00</span></span>
                                        <input type="text" class="text input60 currency_field  custom_fees_total_price_input" style="margin-right:2px">
                                        <span class="if_edit_fees_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_fees_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_fees_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_fees_total_edit_icon  tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 85%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>
                <a href="JavaScript:void(0);" class="m-btn save_fees_child_estimation" id="fees_child_save_btn" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>
<div id="add_sub_contractors_item_model">
    <div class="according-body body2">

        <div class="full-width">
            <h4 class='' style='text-align:center!important;'><span style="padding: 3px 5px;border-radius: 3px;background-color: #282828;color: #ececec;">Services</span> <span style="color: #3f3f41;"> SubContractors</span> | <span style="color: #3f3f41;"> Item</span>
                <span class="if_custom_item_saved" style="right: 17px; top: 9px; position: absolute; width: 80px; padding: 3px 5px; border-radius: 3px; background-color: rgb(81, 166, 75); color: rgb(255, 255, 255);display: block;"><i class="fa fa-fw fa-check-circle " style="font-size: 18px;margin-top: 3px;float:left;"></i><span style="color: #fff;position: relative;top: 2px;">Saved</span></span>
            </h4>


        </div>
        <div style="width:250px;float:left;margin-right: 10px;">
            <div class="content-box" style="overflow:hidden">
                <div class="box-header centered custom_item_calculator_heading22">Details</div>
                <div id="service_html_box8" class="box-content">

                </div>
            </div>

        </div>
        <form id="add_sub_contractors_item_form">
            <div style=" width: 300px;float:left;margin-right: 10px;">
                <div class="content-box ">
                    <div class="box-header centered">Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="time_unit_type">Select Sub</label>
                                        <span class="cwidth4_container">
                                            <select class="text input45 subcontractors_id" name="subcontractors_id">
                                                <?php foreach ($subContractors as $subContractor) {
                                                    echo '<option value="' . $subContractor->getId() . '" >' . $subContractor->getCompanyName() . '</option>';
                                                } ?>
                                                <option value="0">Custom</option>
                                            </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="custom_sub_name_tr">
                                    <td>
                                        <label>Sub Name</label>
                                        <input type="text" name="subcontractors_custom_name" id="subcontractors_custom_name" class="text" style="width:130px;">
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>Price</label>
                                        <input type="text" name="subcontractors_item_unit_price" id="subcontractors_item_unit_price" class="text  currency_field " style="width:130px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Notes</label>
                                        <textarea name="subcontractors_item_notes" id="subcontractors_item_notes" class="cust_textarea" style="width:155px;"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="">Include in Work Order</label>
                                        <input name="subcontractors_work_order" id="subcontractors_work_order" value="1" type="checkbox">
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="left " style="width:300px;">
                <div>
                    <div class="content-box blue">
                        <div class="box-header centered">Calculation</div>
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>


                                <tr>
                                    <td>
                                        <label>Unit Price</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><span class="subcontractors_item_unit_price_text"></span></span>
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="subcontractors_cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>
                                    </td>
                                </tr>
                                <tr class="even show_subcontractors_overhead_and_profit">
                                    <td>
                                        <label>Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="subcontractors_item_overhead" class="percentFormatN text text2 subcontractors_item_overhead" value="10" style="width: 60px; text-align: right;">
                                        <span class="subcontractors_item_overhead_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>

                                <tr class="even show_subcontractors_overhead_and_profit">
                                    <td>
                                        <label>Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="subcontractors_item_profit" class="percentFormatN text text2 subcontractors_item_profit" value="10" style="width: 60px; text-align: right;">
                                        <span class="subcontractors_item_profit_price after_input2" style="float:right"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: left;">Tax <span class="subcontractors_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="subcontractors_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 subcontractors_tax_rate" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="subcontractors_tax_amount after_input2" style="float:right"></span>
                                    </td>
                                </tr>

                                <tr class="even">
                                    <td>
                                        <label>Total Price</label>
                                    </td>
                                    <td>


                                        <span class="if_not_edit_sub_item_total_price">$<span class="subcontractors_item_total_price ">0</span></span>
                                        <input type="text" class="text input60 currency_field if_edit_sub_item_total_price sub_total_price_input_sep" style="margin-right:2px">
                                        <span class="if_edit_sub_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_sub_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_sub_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="sub_item_total_edit_icon if_not_edit_sub_item_total_price tiptipleft" title="Edit Price Total" style="margin-left: 5px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;text-align: center;border: 2px solid red;padding: 7px 10px;width: 85%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>
                <a href="JavaScript:void(0);" class="m-btn " id="savesubcontractors" onclick="save_subcontractors_item('')" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>
<div id="map_model" title="Add Trucking Item">
    <div class="according-body body2">
        <div class="full-width">
            <!-- <h4 class="child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4>
            <h4 class='parant_item_name' style='text-align:right;width: 360px;float: right;'></h4> -->
            <h4 class='parant_item_name' style='text-align:center;'>
                <span class="calculatorHeadingCategory"></span>
                <span class="calculatorHeadingType"></span> |
                <span class="calculatorHeadingItem"></span>
            </h4>
        </div>
        <div class="content-box trucking_box" style="float:left; width:100%;">
            <div class="box-header centered "><i style="margin-top: 4px;font-size: 1.2em;" class="fa fa-truck fa-fw fa-2x"></i> Trucking Calculator</div>
            <div style="width: 75%;float: left;">
                <h4 class="job_site_addr" style="text-align: left;margin-left:5px"><span>Job Site:</span> <?= $proposalRepository->getProjectAddressString($proposal); ?></h4>
            </div>
            <div style="width: 20%;margin: 0.5em 0.5em;font-size: 15px;text-align: right;float: right;"><span style="font-weight: bold;">Tons: </span><span class="show_material_quat"> </span></div>
            <form id="temp_trucking_form">
                    <input type="hidden" name="hidden_child_trucking_start_searchBox" class="hidden_child_trucking_start_searchBox">
                    <input type="hidden" name="hidden_child_trucking_plant_select" class="hidden_child_trucking_plant_select">
                    <input type="hidden" name="hidden_child_trucking_dump_select" class="hidden_child_trucking_dump_select">
                    <input type="hidden" name="hidden_child_trip_time" class="hidden_child_trip_time">
                    <input type="hidden" name="hidden_child_round_time" class="hidden_child_round_time">
                    <input type="hidden" name="hidden_child_plant_turnaround" class="hidden_child_plant_turnaround">
                    <input type="hidden" name="hidden_child_site_turnaround" class="hidden_child_site_turnaround">
                <div class="box-content" style="width: 49%; float:left; border-right:1px solid #ccc;">

                    <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr class="select_width">
                                <td>
                                    <label>Trucking Item</label>
                                    <select class="text input45 trucking_item" name="trucking_item">
                                        <option value="35" data-unit-price="72">Material trucking</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Trucking Price</label>
                                    <p style="margin-top: 6px;"> $<span class="cal_trucking_unit_price">0</span> / Hour
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="trucking_cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //}
                                        ?>
                                    </p>
                                </td>

                            </tr>
                            <tr class="show_trucking_overhead_and_profit">

                                <td>
                                    <label>Overhead %</label>
                                    <input type="text" name="cal_overhead" class="percentFormatN  text2 trucking_cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="" style="width: 60px; text-align: right;">
                                    <span class="trucking_cal_overhead_price after_input2" style="float:right">$0.00</span>
                                </td>
                            </tr>

                            <tr class="show_trucking_overhead_and_profit">

                                <td>
                                    <label>Profit %</label>
                                    <input type="text" name="cal_profit" class="percentFormatN  text2 trucking_cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="" style="width: 60px; text-align: right;">
                                    <span class="trucking_cal_profit_price after_input2" style="float:right">$0.00</span>
                                </td>
                            </tr>
                            <tr class="">
                                <td>
                                    <label>Truck Capacity</label>
                                    <input type="text" class=" hide_input_style input22 truck_capacity" readonly="readonly" style="text-align:left;float: left;box-shadow: none;border: 0px;background: transparent;" name="truck_capacity"><span class="after_input3">Tons</span>
                                </td>
                            </tr>
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Round Time</label>

                                    <select id="child_custom_round_time" class="text input45 child_custom_round_time" name="sep_custom_round_time">
                                        <option value="">Select</option>
                                        <option value="0.5">0.5 Hour</option>
                                        <option value="1">1 Hour</option>
                                        <option value="1.5">1.5 Hours</option>
                                        <option value="2">2 Hours</option>
                                        <option value="2.5">2.5 Hours</option>
                                        <option value="3">3 Hour</option>
                                        <option value="3.5">3.5 Hours</option>
                                        <option value="4">4 Hours</option>
                                        <option value="4.5">4.5 Hours</option>
                                        <option value="5">5 Hours</option>
                                    </select>

                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="(Trip Time x 2) + Plant Time + Site Time" aria-hidden="true"></i>
                                    <span style="top: 3px;position: relative;left: 150px;cursor:pointer" class="child_round_time_cal_span"><i class="fa fa-fw fa-calculator tiptipleft" title="Calculate Round Time" aria-hidden="true"></i></span>
                                </td>
                            </tr>

                           
                            <tr class="tr_info_tip">
                                <td>
                                    <div style="width:100%;float: left;">
                                        <label>Hours / Day</label>
                                        <input type="text" class="number_field text input45 hours_per_day" value="8" name="hours_per_day">
                                        <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Hours available for trucking per day" aria-hidden="true"></i>
                                    </div>
                                    <!-- <div style="width:45%;float: left;">
                                    
                                </div> -->
                                </td>
                            </tr>
                            <tr class="tr_info_tip">
                                <td>
                                    <div style="width:100%;float: left;">
                                        <label>Minimum Hours</label>
                                        <input type="text" class="number_field text input45 child_minimum_hours" value="" name="child_minimum_hours">

                                        <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Minimum Hours available for trucking per day" aria-hidden="true"></i>
                                    </div>

                                </td>
                            </tr>
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Production Rate</label>
                                    <input type="text" class="round_off_field text input45 daily_production_rate " value="<?= $settings->getProductionRate(); ?>" name="daily_production_rate"><span class="after_input3" style="float:left">Tons / Day</span>
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Daily Production Rate" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <!-- <tr class="tr_info_tip">
                            <td>
                                <label >Trucks per day</label>
                                <input type="text" class="round_off_field text input75 truck_per_day " value="0"  name="truck_per_day">
                                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="# of trucks that be managed on site each day" aria-hidden="true"></i>
                            </td>
                        </tr> -->
                        </tbody>
                    </table>
                </div>
                <div class="box-content trucking_form_right_box" style="width: 50%; float:left;">
                    <table class="boxed-table5 boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>


                            <tr class="tr_info_tip">
                                <td>
                                    <label>Miles</label>
                                    <input type="text" class="number_field hide_input_style input75 trip_miles input_aling_left" readonly="readonly" style="text-align:left;float:left;box-shadow: none;border:0px;background:transparent;margin-left: 15px" name="trip_miles">

                                    <a class="show_map btn blue-button " style="font-size:12px;float:right">Map</a>
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Trip distance - optimized for trucks" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Trips</label>
                                    <input type="text" class="number_field   total_trips input_aling_left" readonly="readonly" style="text-align:left; width: 45px;box-shadow: none;border:0px;background:transparent;margin-left: 20px;margin-top: 6px;" name="total_trips">
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Tons divided by Truck Capacity" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Rounds / Day</label>
                                    <span class="round_per_day truck_cal_span"></span>
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Hours divided by round time. Rounded down" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Days</label>
                                    <input type="text" class="round_off_field text input30  trucking_day" data-old-val="" value="1" style="text-align: right;margin-left: 15px;" name="trucking_day">
                                    <!-- <span class="trucking_day truck_cal_span"></span> -->
                                    <i style="float:left;" class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Tons / Tons per Truck per day. Rounded up" aria-hidden="true"></i>
                                    <label style="width:100px!important;position: absolute;right: 110px;">Trucks / Day</label>
                                    <input type="text" class="round_off_field text input30 truck_per_day " value="0" data-old-val="" name="truck_per_day" style="text-align: right;position: absolute;right: 60px;">
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="# of trucks that be managed on site each day" aria-hidden="true"></i>
                                </td>
                            </tr>
                            
                            <tr class="tr_info_tip">
                                <td>
                                    <label>Tons / Day</label>
                                    <span class="tons_per_day truck_cal_span"></span>
                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Tons per Day per Truck x # Trucks"" aria-hidden=" true"></i>
                                    <span style="display:none" class="recommended_trucks truck_cal_span"></span>
                                </td>
                            </tr>
                            <!-- <tr class="tr_info_tip" style="display:none">
                            <td>
                                <label># Trucks</label>
                                <span class="recommended_trucks truck_cal_span"></span>
                                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Number of trucks needed" aria-hidden="true"></i>
                            </td>
                        </tr> -->
                            <tr class="">
                                <td>
                                    <label>Total Hours</label>
                                    <input type="text" class="number_field child_total_time input40 total_time_hours input_aling_left hide_input_style2" readonly="readonly" style="margin-top: 5px;width:40px;float: left;margin-left: 15px;text-align:left" name="total_time_hours">
                                    <input type="hidden" name="child_custom_total_time" class="child_custom_total_time" value="0">
                                    <i class="fa fa-exclamation-triangle fa-2x info_tip tiptipleft if_child_use_minimum_hours" title="Total hours have been increased to the minimum hours" aria-hidden="true"></i>
                                    <i class="fa fa-1x fa-pencil tiptip edit_child_total_hours" title="Edit" style="cursor:pointer;vertical-align: -webkit-baseline-middle;  margin-left: 3px;" aria-hidden="true"></i>
                                </td>
                            </tr>
                            <tr class="tr_info_tip if_dump_type">
                                <td>
                                    <label>Dump Fee</label>

                                    <span style="position: absolute;margin-left:10px;"><input type="checkbox" name="dump_fee_apply" class="dump_fee_apply" value="1"></span>
                                    <span class="if_dump_fee_apply"><input type="text" class="currency_field text input60  dump_rate" name="dump_rate"> <span class="after_input3" style="float:left">Per Ton</span></span>

                                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Dump Rate" aria-hidden="true"></i>

                                </td>
                            </tr>
                            
                            <tr class=" ">
                                <td>
                                    <label class="cal_trucking_total_price_lable">Trucking Total</label>



                                    <span style="margin-left: 16px;margin-top: 5px;position: reletive;float:left;font-weight:bold" class="if_not_edit_trucking_item_total_price">$<span class="cal_trucking_total_price">0.00</span></span>
                                    <input type="text" class="text input60 currency_field  custom_trucking_total_price_input" style="margin-right:2px">
                                    <span class="if_edit_trucking_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_trucking_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_trucking_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                    <?php if ($account->getEditPrice()) { ?>
                                        <span class="item_trucking_total_edit_icon  tiptipleft" title="Edit Price Total" style="margin-left: 10px;float: left;display: block;"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;vertical-align: -webkit-baseline-middle;cursor:pointer;"></i></span>
                                    <?php } ?>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="box-content show_marker_map" style="width: 50%; float:left;display:none">
                    <a class="recenter-map btn tiptipright" title="Center Map on Job Site" style="font-size:8px;position: absolute;top: 75px;right: 414px;z-index: 999;"><i class="fa fa-home fa-2x "></i></a>
                    <a class="close-marker-map btn tiptipleft" title="Close Map" style="font-size:8px;position: absolute;top: 75px;right: 9px;z-index: 999;"><i class="fa fa-close fa-2x "></i></a>
                    <div id="mapDiv" style="width:440px;height: 400px"></div>
                </div>
            </form>
        </div>
    </div>
    <div class="full-width materialize">
        <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 85%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
        <?php if ($proposal_status_id != 5) { ?>
            <a href="JavaScript:void(0);" class="m-btn save_trucking_estimation" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
        <?php } ?>
        <a class="close_map btn blue-button " style="font-size:12px;float:right;display:none;margin-bottom: 5px;">Close Map</a>
    </div>
    <div id="divMap" class="divMap" style="width:500px;float:left;display:none"></div>
    <div id='printoutPanel' class="printoutpanel"></div>
</div>
</div>
<div id="labor_model" title="Add Labor Item">
    <div class="according-body body2">
        <div class="full-width">
            <!-- <h4 class="child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4> -->
            <!-- <h4 class='parant_item_name' style='text-align:right;width: 360px;float: right;'></h4> -->
            <h4 class='parant_item_name' style='text-align:center;'>
                <span class="calculatorHeadingCategory"></span>
                <span class="calculatorHeadingType"></span> |
                <span class="calculatorHeadingItem"></span>
            </h4>
        </div>
        <a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes"><i class="fa fa-clipboard"></i>Notes</a>

        <form id="time_type_form2">
            <div class="form-group" style=" width: 49%;margin-right: 10px;float:left;">
                <div class="content-box">
                    <div class="box-header centered "><i style="margin-top: 4px;font-size: 0.9em;" class="fa fa-male fa-fw fa-2x"></i> Enter Details</div>
                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>

                                <tr>
                                    <td>
                                        <label class="">Item Type</label>
                                        <select class="text input45 labor_type dont-uniform" name="labor_type" style="width:170px;">


                                            <option value="">Select Item Type</option>
                                            <?php
                                            foreach ($laborGroupItems as $laborGroupItem) {
                                                echo '<option  value="' . $laborGroupItem['name'] . '">' . $laborGroupItem['name'] . '</option>';
                                            }
                                            ?>


                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="time_unit_type">Item</label>
                                        <select class="text input45 labor_item dont-uniform" name="labor_item" style="width:170px;">


                                            <option value="">Select Item</option>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Unit Price</label>
                                        <span class="labor_cal_unit_price" style="top:6px;position: relative;"></span><span class="labor_cal_unit_single_name" style="position: relative;top:6px;margin-left:5px;"></span>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Days</label>
                                        <input type="text" name="labor_time_type_input" value="0" class="text input45   round_off_field labor_time_type_input">
                                        <i class="fa fa-info-circle tiptip" title="Number of Days" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="time_unit_type">Quantity</label>
                                        <input type="text" name="labor_number_of_person" value="0" class="text input45   round_off_field labor_number_of_person">
                                        <i class="fa fa-info-circle  tiptip" title="How many of this item" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>

                                <tr>

                                    <td>
                                        <label>Hours per day</label>
                                        <input type="text" name="labor_hour_per_day" value="0" class="text input45   round_off_field labor_hour_per_day">
                                        <i class="fa fa-info-circle  tiptip" title="Number of hours per Day for this item" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="left " style="width:49%;float:left;">
                <div>
                    <div class="content-box blue">
                        <div class="box-header centered">Calculation</div>
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="blue-text time_unit_text" style="float:right;">Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><span class="labor_total_time_value">0.00</span></span>
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="labor_cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php // } 
                                        ?>
                                    </td>
                                </tr>


                                <tr class="show_labor_overhead_and_profit">
                                    <td>
                                        <label style="float:right;">Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_overhead" class="percentFormatN  text2 labor_cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="" style="width: 60px; text-align: right;">
                                        <span class="labor_cal_overhead_price after_input2" style="float:right">$0.00</span>
                                    </td>
                                </tr>

                                <tr class="show_labor_overhead_and_profit">
                                    <td>
                                        <label style="float:right;">Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_profit" class="percentFormatN  text2 labor_cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="" style="width: 60px; text-align: right;">
                                        <span class="labor_cal_profit_price after_input2" style="float:right">$0.00</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: right;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="labor_cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 labor_cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="labor_cal_tax_amount after_input2" style="float:right">$0.00</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="labor_cal_total_price_label" style="float:right;">Total Price</label>
                                    </td>
                                    <td>
                                        <span class="if_not_edit_labor_item_total_price">$<span class="labor_cal_total_price">0.00</span></span>
                                        <input type="text" class="text input60 currency_field  custom_labor_total_price_input" style="margin-right:2px">
                                        <span class="if_edit_labor_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_labor_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_labor_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_labor_total_edit_icon  tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 85%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>
                <a href="JavaScript:void(0);" class="m-btn save_labor_estimation" id="labor_submit" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>

<div id="equipement_model" title="Add Equipment Item">
    <div class="according-body body2">
        <div class="full-width">
            <!-- <h4 class="child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4>
            <h4 class='parant_item_name' style='text-align:right;width: 360px;float: right;'></h4> -->
            <h4 class='parant_item_name' style='text-align:center;'>
                <span class="calculatorHeadingCategory"></span>
                <span class="calculatorHeadingType"></span> |
                <span class="calculatorHeadingItem"></span>
            </h4>
        </div>
        <a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes"><i class="fa fa-clipboard"></i>Notes</a>
        <form id="equipement_time_type_form">
            <div class="form-group" style=" width: 49%;margin-right: 10px;float:left;">
                <div class="content-box">
                    <div class="box-header centered "> <i style="margin-top: 4px;font-size: 0.9em;" class="fa fa-wrench fa-2x"></i> Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>

                                <tr>
                                    <td>
                                        <label class="time_unit_type">Type</label>
                                        <select class="text input45 equipement_type dont-uniform" id="equipement_type" name="equipement_type" style="width:170px;">
                                            <option value="">Select Type</option>
                                            <?php
                                            foreach ($equipments as $equipment) {
                                                if ($equipment['items']) {

                                                    echo '<option  value="' . $equipment['type_id'] . '">' . $equipment['name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="time_unit_type">Item</label>
                                        <select class="text input45 equipement_item dont-uniform" id="equipement_item" name="equipement_item" style="width:170px;">
                                            <option value="">Select Item</option>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Unit Price</label>
                                        <span class="equipement_cal_unit_price" style="top:6px;position: relative;"></span><span class="equipement_cal_unit_single_name" style="position: relative;top:6px;margin-left:5px;"></span>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <label class="unit_type_name_text22">Days</label>
                                        <input type="text" name="equipement_time_type_input" value="0" class="text input45   round_off_field equipement_time_type_input">
                                        <i class="fa fa-info-circle  tiptip" title="Number of Days" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="time_unit_type">Quantity</label>
                                        <input type="text" name="equipement_number_of_person" value="0" class="text input45   round_off_field equipement_number_of_person">
                                        <i class="fa fa-info-circle  tiptip" title="How many of this item" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label>Hours per day</label>
                                        <input type="text" name="equipement_hour_per_day" value="0" class="text input45   round_off_field equipement_hour_per_day">
                                        <i class="fa fa-info-circle tiptip" title="Number of hours per Day for this item" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="left " style="width:49%;float:left;">
                <div>
                    <div class="content-box blue">
                        <div class="box-header centered">Calculation</div>
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="blue-text time_unit_text" style="float:right;">Total</label>
                                    </td>
                                    <td>
                                        <span style="float:left;margin-top: 1px;"><span class="equipment_total_time_value">0.00</span></span>
                                        <?php //if($oh_pm_type==2){
                                        ?>
                                        <span style="float:right;">
                                            <a href="javascript:void('0');" class="equipement_cal_overhead_profit_checkbox" style="color:#373737"><i style="margin-top: -1px;font-size: 1.2em;" class="fa fa-chevron-down fa-2x"></i></a>
                                        </span>
                                        <?php //} 
                                        ?>
                                    </td>
                                </tr>


                                <tr class="show_equipement_overhead_and_profit">
                                    <td>
                                        <label style="float:right;">Overhead %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_overhead" class="percentFormatN  text2 equipement_cal_overhead <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="10" style="width: 60px; text-align: right;">
                                        <span class="equipement_cal_overhead_price after_input2" style="float:right">$0.00</span>
                                    </td>
                                </tr>

                                <tr class="show_equipement_overhead_and_profit">
                                    <td>
                                        <label style="float:right;">Profit %</label>
                                    </td>
                                    <td>
                                        <input type="text" name="cal_profit" class="percentFormatN  text2 equipement_cal_profit <?= ($oh_pm_type != 2) ? 'hide_input_style3' : ' text'; ?>" <?= ($oh_pm_type != 2) ? 'readonly="readonly"' : ' '; ?> value="10" style="width: 60px; text-align: right;">
                                        <span class="equipement_cal_profit_price after_input2" style="float:right">$0.00</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <label style="margin-right: 0px;float: right;">Item Tax <span class="cal_tax_checkbox_tr" style="float:right;margin-left: 10px;"><input type="checkbox" class="equipement_cal_tax_checkbox" name="cal_tax_checkbox" value="1" /></span></label>

                                    </td>
                                    <td>

                                        <input type="text" name="cal_tax" class="percentFormat text text2 equipement_cal_tax" value="0" style="width: 60px; text-align: right; display:none">
                                        <span class="equipement_cal_tax_amount after_input2" style="float:right">$0.00</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label class="equipement_cal_total_price_label" style="float:right;">Total Price</label>
                                    </td>
                                    <td>
                                        <span class="if_not_edit_equipement_item_total_price"><span class="equipement_cal_total_price">0.00</span></span>
                                        <input type="text" class="text input60 currency_field  custom_equipement_total_price_input" style="margin-right:2px">
                                        <span class="if_edit_equipement_item_total_price"><a href="javascript:void(0);" style="  float: right;margin-right: 1px;margin-left: 1px;" class="btn mb-5px  update_equipement_itam_total_btn blue-button">Ok</a><a href="javascript:void(0);" style="float:right;margin-left: 1px;" class="btn  tiptip cancel_edit_equipement_item_total" title="Cancel"><i class="fa fa-fw fa-1x fa-close "></i></a></span>
                                        <?php if ($account->getEditPrice()) { ?>
                                            <span class="item_equipement_total_edit_icon  tiptipleft" title="Edit Price Total" style="margin-right: 10px;float:right"><i class="fa fa-fw fa-1x fa-pencil  " style="position: relative;cursor:pointer;"></i></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 85%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>
                <a href="JavaScript:void(0);" class="m-btn save_equipement_estimation" id="equipement_submit" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>


<div id="fixed_template_item_values_model" title="Add values">
    <div class="according-body body2">
        <div class="full-width">
            <!-- <h4 class="child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4> -->
            <h4 class='fixed_template_model_title' style='text-align:left;'></h4>

        </div>

        <form id="fixed_template_item_form">
            <div class="form-group" style=" width: 100%;margin-right: 10px;float:left;">
                <div class="content-box">
                    <div class="box-header centered "> <i style="margin-top: 4px;font-size: 0.9em;" class="fa fa-wrench fa-2x"></i> Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>


                                <tr>
                                    <td>
                                        <label style="width:200px" class="unit_type_name_text22">Days</label>

                                        <input type="text" name="fixed_template_value_time_type_input" value="0" class="text input45 round_off_field fixed_template_value_time_type_input">
                                        <i class="fa fa-info-circle  tiptip" title="Number of Days" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>


                                <tr>
                                    <td>
                                        <label style="width:200px">Hours per Day</label>

                                        <input type="text" name="fixed_template_value_hour_per_day" value="0" class="text input45   round_off_field fixed_template_value_hour_per_day">

                                        <input type="hidden" id="fixed_template_value_template_id">
                                        <i class="fa fa-info-circle tiptip" title="Number of hours per Day for this item" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 65%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>

                <a href="JavaScript:void(0);" class="m-btn save_fixed_template_values" id="fixed_template_values_submit" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>

<div id="edit_template_item_values_model" title="Edit values">
    <div class="according-body body2">
        <p class="adminInfoMessage templateInfoMsg" style="display: block;margin: 0px 0px 10px 0px;"><i class="fa fa-fw fa-info-circle"></i> Check the box for the fields you want to update. Enter value and save</p>
        <div class="full-width">
            <!-- <h4 class="child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4>
            <h4 class='parant_item_name' style='text-align:right;width: 360px;float: right;'></h4> -->

        </div>

        <form id="edit_template_item_values_form">
            <div class="form-group" style=" width: 100%;margin-right: 10px;float:left;">
                <div class="content-box">
                    <div class="box-header centered "> <i style="margin-top: 4px;font-size: 0.9em;" class="fa fa-wrench fa-2x"></i> Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>


                                <tr class="if_not_fixed_template">
                                    <td>
                                        <label style="width:200px" class="unit_type_name_text22">Days</label>
                                        <input type="checkbox" name="check_edit_tamplate_days_value" class="check_edit_tamplate_days_value">
                                        <input type="text" name="edit_template_value_time_type_input" value="0" class="text input45 round_off_field edit_template_value_time_type_input">
                                        <i class="fa fa-info-circle  tiptip" title="Number of Days" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label style="width:200px" class="time_unit_type">Quantity</label>
                                        <input type="checkbox" name="check_edit_tamplate_quantity_value" class="check_edit_tamplate_quantity_value">
                                        <input type="text" name="edit_template_value_number_of_person" value="0" class="text input45   round_off_field edit_template_value_number_of_person">
                                        <i class="fa fa-info-circle  tiptip" title="How many of this item" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>

                                <tr class="if_not_fixed_template">
                                    <td>
                                        <label style="width:200px">Hours per Day</label>
                                        <input type="checkbox" name="check_edit_tamplate_hpd_value" class="check_edit_tamplate_hpd_value">
                                        <input type="text" name="edit_template_value_hour_per_day" value="0" class="text input45   round_off_field edit_template_value_hour_per_day">

                                        <input type="hidden" id="edit_template_value_template_id">
                                        <i class="fa fa-info-circle tiptip" title="Number of hours per Day for this item" style="float:right;margin-top: 8px;"></i>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </form>
        <p class=" templateInfoMsg" style="float: left;width: 97%;margin: 0px 0px 10px 0px;">This will update the <b class="editTemplateItemsCount">0</b> selected items with the checked values</p>
        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 65%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>

                <a href="JavaScript:void(0);" class="m-btn save_edit_template_values" id="edit_template_values_submit" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>

<div id="edit_template_price_model" title="Edit values">
    <div class="according-body body2">

        <div class="full-width">
            <!-- <h4 class="child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4>
            <h4 class='parant_item_name' style='text-align:right;width: 360px;float: right;'></h4> -->

        </div>

        <form id="">
            <div class="form-group" style=" width: 100%;margin-right: 10px;float:left;">
                <div class="content-box">
                    <div class="box-header centered "> <i style="margin-top: 4px;font-size: 0.9em;" class="fa fa-wrench fa-2x"></i> Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>


                                <tr class="">
                                    <td>
                                        <label style="width:200px" class="unit_type_name_text22">Price</label>
                                        <input type="text" name="edit_template_price" value="0" class="text input70 currency_field edit_template_price"><span class="after_input3"> Per <span class="edit_fixed_template_price_type"></span></span>
                                        <input type="hidden" id="edit_template_price_template_id">
                                        <!-- <i class="fa fa-info-circle  tiptip" title="Number of Days" style="float:right;margin-top: 8px;"></i> -->
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 65%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>

                <a href="JavaScript:void(0);" class="m-btn save_edit_template_price" id="edit_template_price_submit" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>

<div id="edit_standard_template_price_model" title="Edit values">
    <div class="according-body body2">

        <div class="full-width">
            <!-- <h4 class="child_item_calculator_heading" style="text-align:left;width: 500px;float: left;"></h4>
            <h4 class='parant_item_name' style='text-align:right;width: 360px;float: right;'></h4> -->

        </div>

        <form id="">
            <div class="form-group" style=" width: 100%;margin-right: 10px;float:left;">
                <div class="content-box">
                    <div class="box-header centered "> <i style="margin-top: 4px;font-size: 0.9em;" class="fa fa-wrench fa-2x"></i> Enter Details</div>

                    <div class="box-content" style="width:100%; margin: 0px auto">
                        <table class="boxed-table stripping-row" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>


                                <tr class="">
                                    <td>
                                        <label style="width:200px" class="">Price</label>
                                        <input type="text" name="edit_standard_template_price" value="0" class="text input70 currency_field edit_standard_template_price">
                                        <input type="hidden" id="edit_standard_template_price_template_id">
                                        <input type="hidden" id="old_edit_template_price">
                                        <!-- <i class="fa fa-info-circle  tiptip" title="Number of Days" style="float:right;margin-top: 8px;"></i> -->
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </form>

        <div class="full-width materialize">
            <p class="if_error_show_msg" style="text-align: center;border: 2px solid red;padding: 7px 10px;width: 65%;font-weight: bold;float: left;border-radius: 5px;font-size: 14px;display:none;">Please complete all highlighted fields</p>
            <?php if ($proposal_status_id != 5) { ?>

                <a href="JavaScript:void(0);" class="m-btn save_edit_standard_template_price" id="edit_standard_template_price_submit" style="font-size: 14px;margin-top: 6px;float:right"><i class="fa fa-save"></i>&nbsp; Save</a>
            <?php } ?>
        </div>
    </div>
</div>

<div id="estimate_item_notes_model" title="Estimate Item Notes" style="display:none;">
    <!-- <textarea class="text estimate_item_notes_text" style="width:98%; margin-bottom:10px;" rows="9"></textarea>
    <input type="button" class="btn blue-button estimate_item_notes_btn" value="Save" style="margin-bottom:10px;float:right"/> -->
    <form action="#" id="add-note22">
        <p>
            <label>Add Note</label>
            <input type="text" name="noteText" id="estimateItemNoteText" style="width: 500px;">
            <input type="hidden" name="estimateId" id="estimateId" value="0">
            <input type="hidden" name="estimateItemId" id="estimateItemId" value="0">
            <input type="submit" value="Add">
        </p>
        <p style="padding-top: 10px;padding-left: 56px;"><span style="position: relative;top: 2px;">Include in Work Order</span> <input type="checkbox" name="inline_work_order_note" id="inline_work_order_note"> </p>
        <iframe id="estimateItemNotesFrame" src="" frameborder="0" width="100%" height="250"></iframe>
    </form>
</div>
<div id="estimate_child_item_notes_model" title="Estimate Item Notes" style="display:none;">
    <textarea class="text estimate_child_item_notes_text" style="width:98%; margin-bottom:10px;" rows="9"></textarea>
    <input type="button" class="btn blue-button estimate_child_item_notes_btn" value="Save" style="margin-bottom:10px;float:right" />
</div>
<div id="loading_model" title="" style="display:none;">
    <div id="javascript_loading">
        <p class="clearfix">Loading, Please wait</p>

        <p class="clearfix">&nbsp;</p>

        <p><img src="/static/loading_animation.gif" alt="Loading"></p>
    </div>
</div>
<!-- Confirm delete dialog -->
<div id="delete-child-Items" title="Confirmation">
    <h3>Confirmation - Delete Items</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> items.</p>
    <br />
    <p><strong>Items used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-child-items-status" title="Confirmation">
    <h3>Confirmation - Delete Items</h3>

    <p id="deletechildItemsStatus"></p>
</div>


<!-- Estimating fields dialog -->
<div id="estimatingServiceFieldsDialog" title="Edit Estimating Service Fields">
    <h3>Estimation Fields: <span id="estimateFieldsServiceName"></span></h3>

    <form id="estimationFieldsForm">
        <input type="hidden" name="serviceId" id="serviceId" />
        <input type="hidden" name="proposalServiceId" id="proposalServiceId" />
        <table id="estimationFieldsTable">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Measurement</th>
                    <th>Unit</th>
                    <th>Excavation Depth</th>
                    <th>Base Depth</th>
                    <th>Depth</th>
                    <th>Gravel Depth</th>
                    <th>Area</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </form>
</div>

<div id="round_time_calculation_model" title="Calculate Round Time">
    <table class="boxed-table stripping-row" width="100%">
        <tr class="tr_info_tip select_width">
            <td>
                <label>Start Address</label>
                <div>
                    <div id='searchBoxContainer1'>
                        <input type='text' class="text" style="width: 120px!important;" name="sep_trucking_start_searchBox" id='sep_trucking_start_searchBox' />
                        <input type='hidden' name="sep_trucking_start_lat" id="sep_trucking_start_lat" />
                        <input type='hidden' name="sep_trucking_start_long" id="sep_trucking_start_long" />
                    </div>
                    <select style="width:120px" class="selectTruckingStart  dont-uniform" name="selectTruckingStart">
                        <option value="">-Select</option>
                        <option data-job-site="1" data-lat="<?php echo $proposal->getLat(); ?>" data-lng="<?php echo $proposal->getLng() ?>" data-address="<?= $proposalRepository->getProjectAddressString($proposal); ?>"><?= $proposalRepository->getProjectAddressString($proposal); ?></option>
                        <optgroup label="Plants">
                            <?php foreach ($plants as $plant) : ?>
                                <option data-job-site="0" value="<?php echo $plant->getId(); ?>" data-option-name="<?php echo $plant->getName(); ?>" data-company-name="<?= $plant->getCompanyName(); ?>" data-address="<?php echo $plant->getAddress() . ', ' . $plant->getCity() . ', ' . $plant->getState() . ' ' . $plant->getZip(); ?>" data-lat="<?php echo $plant->getLat(); ?>" data-lng="<?php echo $plant->getLng() ?>">
                                    <?php echo $plant->getCompanyName() . ': ' . $plant->getName() . ' ' . $plant->getAddress() . ', ' . $plant->getCity() . ', ' . $plant->getState() . ' ' . $plant->getZip(); ?>
                                </option>
                            <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="Dumps">
                            <?php foreach ($dumps as $dump) : ?>
                                <option data-job-site="0" value="<?php echo $dump->getId(); ?>" data-option-name="<?php echo $dump->getName(); ?>" data-company-name="<?= $dump->getCompanyName(); ?>" data-address="<?php echo $dump->getAddress() . ', ' . $dump->getCity() . ', ' . $dump->getState() . ' ' . $dump->getZip(); ?>" data-lat="<?php echo $dump->getLat(); ?>" data-lng="<?php echo $dump->getLng() ?>">
                                    <?php echo $dump->getCompanyName() . ': ' . $dump->getName() . ' ' . $dump->getAddress() . ', ' . $dump->getCity() . ', ' . $dump->getState() . ' ' . $dump->getZip(); ?>
                                </option>
                            <?php endforeach; ?>
                        </optgroup>


                    </select>
                    <?php if ($proposal->getLat() && (count($plants) > 0 || count($dumps) > 0)) { ?>
                        <i class="fa fa-info-circle fa-2x info_tip tiptipleft " title="Enter the start address of the trucking route" aria-hidden="true"></i>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <tr class="tr_info_tip select_width">

            <td>
                <label>End Address</label>
                <div id='searchBoxContainer2'>
                    <input type='text' class="text" style="width: 120px!important;" name="sep_trucking_end_searchBox" id='sep_trucking_end_searchBox' />
                    <input type='hidden' name="sep_trucking_end_lat" id="sep_trucking_end_lat" />
                    <input type='hidden' name="sep_trucking_end_long" id="sep_trucking_end_long" />
                </div>
                <select style="width:120px" class="selectTruckingEnd  dont-uniform" name="selectTruckingEnd">
                    <option value="">-Select</option>
                    <option data-job-site="1" data-lat="<?php echo $proposal->getLat(); ?>" data-lng="<?php echo $proposal->getLng() ?>" data-address="<?= $proposalRepository->getProjectAddressString($proposal); ?>"><?= $proposalRepository->getProjectAddressString($proposal); ?></option>
                    <optgroup label="Plants">
                        <?php foreach ($plants as $plant) : ?>
                            <option data-job-site="0" value="<?php echo $plant->getId(); ?>" data-option-name="<?php echo $plant->getName(); ?>" data-company-name="<?= $plant->getCompanyName(); ?>" data-address="<?php echo $plant->getAddress() . ', ' . $plant->getCity() . ', ' . $plant->getState() . ' ' . $plant->getZip(); ?>" data-lat="<?php echo $plant->getLat(); ?>" data-lng="<?php echo $plant->getLng() ?>">
                                <?php echo $plant->getCompanyName() . ': ' . $plant->getName() . ' ' . $plant->getAddress() . ', ' . $plant->getCity() . ', ' . $plant->getState() . ' ' . $plant->getZip(); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Dumps">
                        <?php foreach ($dumps as $dump) : ?>
                            <option data-job-site="0" value="<?php echo $dump->getId(); ?>" data-option-name="<?php echo $dump->getName(); ?>" data-company-name="<?= $dump->getCompanyName(); ?>" data-address="<?php echo $dump->getAddress() . ', ' . $dump->getCity() . ', ' . $dump->getState() . ' ' . $dump->getZip(); ?>" data-lat="<?php echo $dump->getLat(); ?>" data-lng="<?php echo $dump->getLng() ?>">
                                <?php echo $dump->getCompanyName() . ': ' . $dump->getName() . ' ' . $dump->getAddress() . ', ' . $dump->getCity() . ', ' . $dump->getState() . ' ' . $dump->getZip(); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>

                </select>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Enter the end address of the trucking route" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip">
            <td>
                <label>Trip Time</label>

                <input type="text" class="number_field text input45 sep_trip_time" name="trip_time"><span class="after_input3" style="float:left">Minutes</span>
                <div class="set_loader">
                    <div class="cssloader" style="display:none">loading</div>
                </div>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Time in minutes of a one-way trip" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip">
            <td>
                <label>Plant Time</label>
                <select class="text input45 sep_plant_turnaround" name="plant_turnaround">
                    <option value="">Select</option>
                    <option value="0.25">15 Minutes</option>
                    <option value="0.5">30 Minutes</option>
                    <option value="0.75">45 Minutes</option>
                    <option value="1">1 Hour</option>
                    <option value="1.25">1 Hours 15 Minutes</option>
                    <option value="1.5">1 Hours 30 Minutes</option>
                    <option value="1.75">1 Hours 45 Minutes</option>
                    <option value="2">2 Hours</option>
                    <option value="2.25">2 Hours 15 Minutes</option>
                    <option value="2.5">2 Hours 30 Minutes</option>
                </select>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Turnaround time at the plant" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip">
            <td>
                <label>Site Time</label>
                <select class="text input45 sep_site_turnaround" name="site_turnaround">
                    <option value="">Select</option>
                    <option value="0.25">15 Minutes</option>
                    <option value="0.5">30 Minutes</option>
                    <option value="0.75">45 Minutes</option>
                    <option value="1">1 Hour</option>
                    <option value="1.25">1 Hours 15 Minutes</option>
                    <option value="1.5">1 Hours 30 Minutes</option>
                    <option value="1.75">1 Hours 45 Minutes</option>
                    <option value="2">2 Hours</option>
                    <option value="2.25">2 Hours 15 Minutes</option>
                    <option value="2.5">2 Hours 30 Minutes</option>

                </select>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Turnaround time at the job site" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip">

            <td> <label>Round Time</label><span style="position: relative;top: 7px;" class="calculated_round_time"></span> <span style="position: relative;top: 7px;">Minutes</span> <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Round Time will be rounded up to next 30 mintues" aria-hidden="true"></i></td>
        </tr>
        <tr class="if_calculated_round_time">

            <td> <input type="button" style="float:right" class="btn blue-button use_round_time right" value="Apply Round Time" /></td>
        </tr>
    </table>
</div>

<div id="child_round_time_calculation_model" title="Calculate Round Time">
    <table class="boxed-table stripping-row" width="100%">
        <tr class="tr_info_tip select_width if_not_excavation">
            <td>
                <label>Plant</label>
                <select style="width:240px" class="plantSelect dont-uniform" name="plantselect">
                    <option value="">- Select</option>
                    <?php foreach ($plants as $plant) : ?>
                        <option value="<?php echo $plant->getId(); ?>" data-lat="<?php echo $plant->getLat(); ?>" data-lng="<?php echo $plant->getLng() ?>">
                            <?php echo $plant->getCompanyName() . ': ' . $plant->getName(); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($proposal->getLat() && count($plants) > 0) { ?>
                    <!-- <a class="show-marker-map btn tiptip" title="View on Map" style="font-size: 8px;width: 24px;position: relative;top: 2.5px;"><i class="fa fa-map-marker fa-2x "></i></a> -->
                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Select the Plant" aria-hidden="true"></i>
                <?php } ?>
            </td>
        </tr>
        <tr class="tr_info_tip select_width if_excavation">
            <td>
                <label>Start Address</label>
                <div id='searchBoxContainer3'>

                    <input type='text' class="text" style="width: 240px!important;" name="child_trucking_start_searchBox" id='child_trucking_start_searchBox' />

                    <input type='hidden' name="trucking_start_lat" id="trucking_start_lat" />
                    <input type='hidden' name="trucking_start_long" id="trucking_start_long" />
                </div>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft " title="Enter the start address of the trucking route" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip select_width if_excavation">

            <td>
                <label>Dump</label>
                <select style="width:240px" class="dumpSelect dont-uniform" name="dumpselect">
                    <option value="">-Select</option>
                    <optgroup label="Plants">
                        <?php foreach ($plants as $plant) : ?>
                            <option value="<?php echo $plant->getId(); ?>" data-lat="<?php echo $plant->getLat(); ?>" data-lng="<?php echo $plant->getLng() ?>">
                                <?php echo $plant->getCompanyName() . ': ' . $plant->getName(); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>
                    <optgroup label="Dumps">
                        <?php foreach ($dumps as $dump) : ?>
                            <option value="<?php echo $dump->getId(); ?>" data-price-rate="<?php echo $dump->getPriceRate(); ?>" data-lat="<?php echo $dump->getLat(); ?>" data-lng="<?php echo $dump->getLng() ?>">
                                <?php echo $dump->getCompanyName() . ': ' . $dump->getName(); ?>
                            </option>
                        <?php endforeach; ?>
                    </optgroup>

                    <option value="custom">Custom</option>
                </select>
                <?php if ($proposal->getLat() && (count($plants) > 0 || count($dumps) > 0)) { ?>
                    <a class="show-dump-marker-map btn tiptip" title="View on Map" style="font-size: 8px;width: 24px;position: relative;top: 2.5px;"><i class="fa fa-map-marker fa-2x "></i></a>
                    <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Select the Dump" aria-hidden="true"></i>
                <?php } ?>
            </td>
        </tr>
        <tr class="tr_info_tip select_width if_excavation_custom">
            <td>
                <label>End Address</label>
                <div id='searchBoxContainer4'>

                    <input type='text' class="text" style="width: 240px!important;" name="child_trucking_end_searchBox" id='child_trucking_end_searchBox' />
                    <input type='hidden' name="trucking_end_lat" id="trucking_end_lat" />
                    <input type='hidden' name="trucking_end_long" id="trucking_end_long" />
                </div>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Enter the end address of the trucking route" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip">
            <td>
                <label>Trip Time</label>
                <input type="text" class="number_field text input45 trip_time" name="trip_time"><span class="after_input3" style="float:left">Minutes</span>
                <div class="set_loader">
                    <div class="cssloader" style="display:none">loading</div>
                </div>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Time in minutes of a one-way trip" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip if_excavation">
            <td>
                <label>Site Time</label>
                <select class="text input45 site_turnaround2" name="site_turnaround2">
                    <option value="">Select</option>
                    <option value="0.25">15 Minutes</option>
                    <option value="0.5">30 Minutes</option>
                    <option value="0.75">45 Minutes</option>
                    <option value="1">1 Hour</option>
                    <option value="1.25">1 Hours 15 Minutes</option>
                    <option value="1.5">1 Hours 30 Minutes</option>
                    <option value="1.75">1 Hours 45 Minutes</option>
                    <option value="2">2 Hours</option>
                    <option value="2.25">2 Hours 15 Minutes</option>
                    <option value="2.5">2 Hours 30 Minutes</option>

                </select>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Turnaround time at the job site" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip">
            <td>
                <label class="plant_time_label">Plant Time</label>
                <select class="text input45 plant_turnaround" name="plant_turnaround">
                    <option value="">Select</option>
                    <option value="0.25">15 Minutes</option>
                    <option value="0.5">30 Minutes</option>
                    <option value="0.75">45 Minutes</option>
                    <option value="1">1 Hour</option>
                    <option value="1.25">1 Hours 15 Minutes</option>
                    <option value="1.5">1 Hours 30 Minutes</option>
                    <option value="1.75">1 Hours 45 Minutes</option>
                    <option value="2">2 Hours</option>
                    <option value="2.25">2 Hours 15 Minutes</option>
                    <option value="2.5">2 Hours 30 Minutes</option>
                </select>
                <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Turnaround time at the plant" aria-hidden="true"></i>
            </td>
        </tr>
        <tr class="tr_info_tip if_not_excavation">
                    <td>
                        <label>Site Time</label>
                        <select class="text input45 site_turnaround" name="site_turnaround" >
                            <option value="">Select</option>
                            <option value="0.25">15 Minutes</option><option value="0.5">30 Minutes</option>
                            <option value="0.75">45 Minutes</option><option value="1">1 Hour</option>
                            <option value="1.25">1 Hours 15 Minutes</option><option value="1.5">1 Hours 30 Minutes</option>
                            <option value="1.75">1 Hours 45 Minutes</option><option value="2">2 Hours</option>
                            <option value="2.25">2 Hours 15 Minutes</option><option value="2.5">2 Hours 30 Minutes</option>

                        </select>
                        <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Turnaround time at the job site" aria-hidden="true"></i>
                    </td>
                </tr>
        <tr class="tr_info_tip">

            <td> <label>Round Time</label><span style="position: relative;top: 7px;" class="child_calculated_round_time"></span> <span style="position: relative;top: 7px;">Minutes</span> <i class="fa fa-info-circle fa-2x info_tip tiptipleft" title="Round Time will be rounded up to next 30 mintues" aria-hidden="true"></i></td>
        </tr>
        <tr class="if_child_calculated_round_time">

            <td> <input type="button" style="float:right" class="btn blue-button child_use_round_time right" value="Apply Round Time" /></td>
        </tr>
    </table>
</div>
<script src='/static/js/inputmask.js'></script>
<script src='https://parsleyjs.org/dist/parsley.min.js'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" integrity="sha256-MeSf8Rmg3b5qLFlijnpxk6l+IJkiR91//YGPCrCmogU=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.full.min.js"></script>

<script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=AvhgGCWtyecSauMJHutkPO3pTSrfaj3OPNn5U7qsmHD_tZbgOq_47YDjpR7d1DcN' async defer></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    var startLat, startLng, start_position;
    var destLat = '<?= $proposal->getLat() ?>';
    var destLng = '<?= $proposal->getLng() ?>';
    var jon_site_company = "<?= $proposal->getClient()->getClientAccount()->getName(); ?>";
    var job_site_contact_name = "<?= $proposal->getClient()->getFullName(); ?>";
    var job_site_address = "<?= $proposalRepository->getProjectAddressStringLineBreak($proposal); ?>";
    var jon_site_email = "<?= $proposal->getClient()->getEmail(); ?>";
    var jon_site_phone = "<?= $proposal->getClient()->getCellPhone(); ?>";
    var bingMapsKey = 'AvhgGCWtyecSauMJHutkPO3pTSrfaj3OPNn5U7qsmHD_tZbgOq_47YDjpR7d1DcN';
    var cogServicesKey = '27cd23115ffb4cff9f78fd0098830f57';
    var map = null;
    var bmKey = bingMapsKey;
    var mapHeight = 0;
    var allPoints = <?php echo json_encode($plantInfo); ?>;
    var plant_dump_map_type = null;
    $(document).on('click', ".show_map", function() {
        //$("#map_model").dialog('open');
        $('.printoutpanel').show();
        $('.divMap').show();

        //$('.close_map').show();
        $('.save_trucking_estimation').hide();
        $('.trucking_box').hide();

        if (head_type_id == excavation_type_id || head_type_id == excavator_type_id) {
            startLat = $("#trucking_start_lat").val();
            startLng = $("#trucking_start_long").val();

            // destLat = $(this).closest('form').find("#trucking_end_lat").val();
            // destLng = $(this).closest('form').find("#trucking_end_long").val();
            if ($(".dumpSelect").val() == 'custom') {
                destLat = $("#trucking_end_lat").val();
                destLng = $("#trucking_end_long").val();
            } else {
                destLat = $(".dumpSelect").find(":selected").attr('data-lat');
                destLng = $(".dumpSelect").find(":selected").attr('data-lng');
            }
        } else {
            startLat = $(".plantSelect").find(":selected").attr('data-lat');
            startLng = $(".plantSelect").find(":selected").attr('data-lng');
            destLat = '<?= $proposal->getLat() ?>';
            destLng = '<?= $proposal->getLng() ?>';
        }

        ChildGetMap();

    })

    $(document).on('click', ".show-dump-marker-map", function() {
        //$("#map_model").dialog('open');
        $('.show_marker_map').show();
        //$('.close_map').show();
        $('.trucking_form_right_box').hide();
        plant_dump_map_type = 'dump';
        allPoints = <?php echo json_encode(array_merge($plantInfo, $dumpInfo)); ?>;
        if (MapObj) {
            clearMap();
        }
        initialize(0);
        createHomeMarker()
        console.log(allPoints);

    })
    $(document).on('click', ".show-marker-map", function() {
        //$("#map_model").dialog('open');
        $('.show_marker_map').show();

        plant_dump_map_type = 'plant';
        //$('.close_map').show();
        $('.trucking_form_right_box').hide();

        allPoints = <?php echo json_encode($plantInfo); ?>;
        console.log(allPoints);
        if (MapObj) {
            clearMap();
        }
        initialize(0);
        createHomeMarker()

    });

    function clearMap() {
        var all_markers = MapObj.GetMarkers();
        for (var i = 0; i < all_markers.length; i++) {
            all_markers[i].setMap(null);

        }
    }
    $(document).on('click', ".close-marker-map", function() {

        $('.show_marker_map').hide();

        $('.trucking_form_right_box').show();


    })


    $(document).on('click', ".close_map", function() {
        //$("#map_model").dialog('open');
        $('.printoutpanel').hide();
        $('.divMap').hide();

        $('.close_map').hide();
        $('.save_trucking_estimation').show();
        $('.trucking_box').show();


    })

    $(document).on('click', ".sep_close_map", function() {
        //$("#map_model").dialog('open');
        $('.sep_printoutpanel').hide();
        $('.sep_divMap').hide();
        $('.sep_close_map').hide();
        $('.save_estimation').show();
        $('.trucking_box').show();


    })




    var proposalId = <?php echo $proposal->getProposalId(); ?>;
    var iTable;
    $("#quantity_calculation").dialog({
        autoOpen: false,
        modal: true,
        width: 900,
        draggable: true,
        beforeClose: function(e, ui) {
            if ($("#sep_divMap").is(":visible")) {
                e.preventDefault();
                $('.sep_printoutpanel').hide();
                $('.sep_divMap').hide();

                $('.sep_close_map').hide();
                $('.save_estimation').show();
                $('.trucking_box').show();
            } else {
                if (unsave_cal == true) {
                    if (calculator_form_id == 'trucking_form' || calculator_form_id == 'time_type_form') {
                        check_validation3(calculator_form_id);
                    }
                    e.preventDefault();
                    swal({
                        title: "Calculation Incomplete",
                        text: "Are you sure you want to exit?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: "No",
                        dangerMode: false,
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            unsave_cal = false;
                            $("#quantity_calculation").dialog('close');
                        } else {
                            swal("Cancelled", "Your Calculation is safe :)", "error");
                        }
                    });
                }
            }
        }
    });

    $("#add_custom_item_model").dialog({
        autoOpen: false,
        modal: true,
        width: 900,
        draggable: false,
        beforeClose: function(e, ui) {

            if (unsave_cal == true) {
                check_validation('add_custom_item_form');
                e.preventDefault();
                swal({
                    title: "Calculation Incomplete",
                    text: "Are you sure you want to exit?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        unsave_cal = false;
                        $("#add_custom_item_model").dialog('close');
                    } else {
                        swal("Cancelled", "Your Calculation is safe :)", "error");
                    }
                });
            }

        }
    });
    $("#add_sub_contractors_item_model").dialog({
        autoOpen: false,
        modal: true,
        width: 900,
        draggable: false,
        beforeClose: function(e, ui) {

            if (unsave_cal == true) {
                check_validation('add_sub_contractors_item_form');
                e.preventDefault();
                swal({
                    title: "Calculation Incomplete",
                    text: "Are you sure you want to exit?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        unsave_cal = false;
                        $("#add_sub_contractors_item_model").dialog('close');
                    } else {
                        swal("Cancelled", "Your Calculation is safe :)", "error");
                    }
                });
            }

        }
    });
    $("#add_custom_child_item_model").dialog({
        autoOpen: false,
        modal: true,
        width: 900,
        draggable: false,
        beforeClose: function(e, ui) {
            if (unsave_cal == true) {
                check_validation('add_custom_child_item_form');
                e.preventDefault();
                swal({
                    title: "Calculation Incomplete",
                    text: "Are you sure you want to exit?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        unsave_cal = false;
                        $("#add_custom_child_item_model").dialog('close');
                        $('.save_estimation').show();
                    } else {
                        swal("Cancelled", "Your Calculation is safe :)", "error");
                    }
                });
            } else {
                if (!child_save_done) {
                    $('.save_estimation').show();
                }

            }
        }
    });
    $("#add_fees_child_item_model").dialog({
        autoOpen: false,
        modal: true,
        width: 900,
        draggable: false,
        beforeClose: function(e, ui) {
            if (unsave_cal == true) {
                check_validation('add_fees_child_item_form');
                e.preventDefault();
                swal({
                    title: "Calculation Incomplete",
                    text: "Are you sure you want to exit?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        unsave_cal = false;
                        $("#add_fees_child_item_model").dialog('close');
                        $('.save_estimation').show();
                    } else {
                        swal("Cancelled", "Your Calculation is safe :)", "error");
                    }
                });
            } else {
                if (!child_save_done) {
                    $('.save_estimation').show();
                }
            }
        }
    });

    $("#map_model").dialog({
        autoOpen: false,
        modal: true,
        width: 900,
        draggable: false,
        beforeClose: function(e, ui) {
            if ($("#divMap").is(":visible")) {
                e.preventDefault();
                $('.printoutpanel').hide();
                $('.divMap').hide();

                $('.close_map').hide();
                $('.save_trucking_estimation').show();
                $('.trucking_box').show();
            } else {
                if (unsave_cal == true) {
                    check_validation('temp_trucking_form');
                    e.preventDefault();
                    swal({
                        title: "Calculation Incomplete",
                        text: "Are you sure you want to exit?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: "No",
                        dangerMode: false,
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            unsave_cal = false;
                            $("#map_model").dialog('close');
                            $('.save_estimation').show();
                        } else {
                            swal("Cancelled", "Your Calculation is safe :)", "error");
                        }
                    });
                } else {
                    if (!child_save_done) {
                        $('.save_estimation').show();
                    }
                }
            }
        }
    });
    $("#labor_model").dialog({
        autoOpen: false,
        modal: true,
        width: 900,
        draggable: false,
        beforeClose: function(e, ui) {
            check_validation('time_type_form2');
            if (unsave_cal == true) {
                e.preventDefault();

                swal({
                    title: "Calculation Incomplete",
                    text: "Are you sure you want to exit?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        unsave_cal = false;
                        $("#labor_model").dialog('close');
                        $('.save_estimation').show();
                    } else {
                        swal("Cancelled", "Your Calculation is safe :)", "error");
                    }
                });
            } else {
                console.log('child_save_done');
                console.log(child_save_done);
                if (!child_save_done) {
                    $('.save_estimation').show();
                }
            }
        }
    });

    function check_validation(form_id) {
        var $form = $("#" + form_id);
        var form_data = $("#" + form_id).serializeArray();
        var error_free = true;
        for ($i = 0; $i < form_data.length; $i++) {

            if (!form_data[$i].value || form_data[$i].value == 0) {
                var $field = $form.find('[name=' + form_data[$i].name + ']');
                if ($($field).is("select")) {
                    if ($field.is(":visible")) {
                        $($field).closest('div').addClass('select_box_error');

                    }
                } else if (!$field.is("textarea")) {
                    if (!$field.is('[readonly]')) {
                        if ($field.is(":visible")) {
                            $field.addClass('error');
                        }
                    }

                }
            }

        }

        if ($('.error').length > 0 || $('.select_box_error').length > 0) {
            $('.if_error_show_msg').show();
        } else {
            $('.if_error_show_msg').hide();
        }

    }

    function check_validation3(form_id) {
        var $form = $("#" + form_id);
        var form_data = $("#" + form_id).serializeArray();
        var error_free = true;
        for ($i = 0; $i < form_data.length; $i++) {

            if (!form_data[$i].value || form_data[$i].value == 0) {
                var $field = $form.find('[name=' + form_data[$i].name + ']');
                if ($($field).is("select")) {
                    if ($field.is(":visible")) {
                        $($field).closest('div').addClass('select_box_error');

                    }
                } else if (!$field.is("textarea")) {
                    if (!$field.is('[readonly]')) {
                        if ($field.is(":visible")) {
                            $field.addClass('error');
                        }
                    }

                }
            }

        }

        if ($('.error').length > 0 || $('.select_box_error').length > 0) {
            $('.if_error_show_msg_parent').show();
        } else {
            $('.if_error_show_msg_parent').hide();
        }

    }

    function check_validation2(form_id) {
        var $form = $("#" + form_id);
        var form_data = $("#" + form_id).serializeArray();
        var error_free = true;
        for ($i = 0; $i < form_data.length; $i++) {
            console.log($($field).is("select"));
            if (!form_data[$i].value || form_data[$i].value == 0) {
                var $field = $form.find('[name=' + form_data[$i].name + ']');
                if ($($field).is("select")) {
                    if ($field.is(":visible")) {

                        $($field).closest('td').find('.select2').addClass('select2_box_error');
                    }
                } else if (!$field.is("textarea")) {
                    if (!$field.is('[readonly]')) {
                        if ($field.is(":visible")) {
                            $field.addClass('error');
                        }
                    }

                }
            }

        }

        if ($('.error').length > 0 || $('.select2_box_error').length > 0) {
            $('.if_error_show_msg').show();
        } else {
            $('.if_error_show_msg').hide();
        }

    }
    $("#equipement_model").dialog({
        autoOpen: false,
        modal: true,
        width: 900,
        draggable: false,
        beforeClose: function(e, ui) {
            if (unsave_cal == true) {
                check_validation2('equipement_time_type_form');
                e.preventDefault();
                swal({
                    title: "Calculation Incomplete",
                    text: "Are you sure you want to exit?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        unsave_cal = false;
                        $("#equipement_model").dialog('close');
                        $('.save_estimation').show();
                    } else {
                        swal("Cancelled", "Your Calculation is safe :)", "error");
                    }
                });
            } else {
                if (!child_save_done) {
                    $('.save_estimation').show();
                }
            }
        }
    });
    $("#edit_template_item_values_model").dialog({
        autoOpen: false,
        modal: true,
        width: 500,
        draggable: false
    });
    $("#edit_template_price_model").dialog({
        autoOpen: false,
        modal: true,
        width: 500,
        draggable: false
    });

    $("#edit_standard_template_price_model").dialog({
        autoOpen: false,
        modal: true,
        width: 500,
        draggable: false
    });

    $("#estimate_item_notes_model").dialog({
        autoOpen: false,
        modal: true,
        width: 700,
        draggable: false
    });
    $("#estimate_child_item_notes_model").dialog({
        autoOpen: false,
        modal: true,
        width: 500,
        draggable: false
    });
    $("#loading_model").dialog({
        autoOpen: false,
        modal: true,
        width: 500,
        draggable: false
    });

    $("#fixed_template_item_values_model").dialog({
        autoOpen: false,
        modal: true,
        width: 500,
        draggable: false
    });

    $("#round_time_calculation_model").dialog({
        autoOpen: false,
        modal: true,
        width: 500,
        draggable: false
    });

    $("#child_round_time_calculation_model").dialog({
        autoOpen: false,
        modal: true,
        width: 500,
        draggable: false
    });

    function setDropdowns() {

        if (!$("#categoryId").val()) {
            $("#typeId").prop('disabled', 'disabled');
            $("#unitId").prop('disabled', 'disabled');
        } else {
            $("#typeId").prop('disabled', '');
            if (!$("#typeId").val()) {
                $("#unitId").prop('disabled', 'disabled');
            } else {
                $("#unitId").prop('disabled', '');
            }
        }
        $.uniform.update();
    }

    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

    function initTable() {

        if (!iTable) {
            iTable = $("#estimateLineItemTable").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "bProcessing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "ajax": {
                    "url": "<?php echo site_url('ajax/proposalEstimateItems'); ?>/" + proposalId,
                    "type": "GET"
                },
                "aoColumns": [{
                        'bVisible': true
                    },
                    {
                        'bSearchable': true
                    },
                    {
                        'bSearchable': true
                    },
                    {
                        'bSearchable': true
                    },
                    {
                        'bSearchable': true
                    },
                    {
                        'bSearchable': true
                    },
                    {
                        'bSearchable': true
                    },
                ],
                "bJQueryUI": true,
                "bAutoWidth": true,
                "sPaginationType": "full_numbers",
                "sDom": 'HtiprF',
            });
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {



        $(".plantSelect").change(function() {
            unsave_cal = true;
            if ($(this).val()) {
                var form_id = $(this).closest('form').attr('id');
                startLat = $(this).find(":selected").data('lat');
                startLng = $(this).find(":selected").data('lng');
                if(!child_saved_cal){
                    calculateRoute(form_id);
                }
                
            }
        });

        $(".dumpSelect").change(function() {
            unsave_cal = true;
            if ($(this).val()) {
                var form_id = $(this).closest('form').attr('id');
                if ($(this).val() == 'custom') {
                    $('.if_excavation_custom').show();
                    child_trucking_end_add_search();
                } else {
                    $('.if_excavation_custom').hide();
                    startLat = $(this).find(":selected").data('lat');
                    startLng = $(this).find(":selected").data('lng');
                    if(!child_saved_cal){
                        calculateRoute(form_id);
                    }
                }


                // start_position = $(this).find(":selected").text();
                // start_position =  $.trim(start_position);

            }
        });

        $(".sep_plantSelect").change(function() {
            if ($(this).val()) {
                var form_id = $(this).closest('form').attr('id');
                startLat = $(this).find(":selected").data('lat');
                startLng = $(this).find(":selected").data('lng');
                // start_position = $(this).find(":selected").text();
                // start_position =  $.trim(start_position);
                calculateRoute(form_id);
            }
        });


    });

    function calculateRoute(form_id) {
        if (!destLat) {
            swal('', 'Job Site could not be mapped. Please enter trip time manually');
            return false;
        }
        $('.cssloader').show();
        var postData = {
            "waypoints": [{
                "latitude": startLat,
                "longitude": startLng
            }, {
                "latitude": destLat,
                "longitude": destLng
            }],
            "vehicleSpec": {
                "vehicleWeight": 40000,
                "weightUnit": "lb",
                "vehicleLength": 50,
                "dimensionUnit": "ft"
            },
            "routeAttributes": 'routePath',
        };

        $.ajax({
                type: "post",
                url: "https://dev.virtualearth.net/REST/v1/Routes/Truck?key=AvhgGCWtyecSauMJHutkPO3pTSrfaj3OPNn5U7qsmHD_tZbgOq_47YDjpR7d1DcN",
                data: JSON.stringify(postData)
            })
            .done(function(data) {
                var distance = data.resourceSets[0].resources[0].travelDistance;

                var duration = (data.resourceSets[0].resources[0].travelDuration / 60);
                if (form_id == 'trucking_form') {
                    $('#trucking_form').find(".sep_trip_miles").val(distance.toFixed(2));

                    $('#trucking_form').find(".sep_trip_time").val((5 * Math.ceil(duration / 5)));
                    $('#trucking_form').find(".sep_trip_time").removeClass('error');
                    calculate_trucking_type();
                } else {
                    $('#map_model').find(".trip_miles").val(distance.toFixed(2));

                    $(".trip_time").val((5 * Math.ceil(duration / 5)));
                    $(".trip_time").removeClass('error');
                    //calculate_trucking_type2($("#measurement").closest('form').attr('id'));
                    calculate_child_trucking_round_time();
                

                }

                $('.cssloader').hide();

            }).fail(function(data) {
                swal('', 'Mapping error occurred. Please enter trip time manually');
                console.log('ddddd');
                $('.cssloader').hide();
            });


    }

    function displayRoute(response, color, setView) {
        var locations = [];
        var route = response.resourceSets[0].resources[0].routePath.line.coordinates;

        for (i = 0; i < route.length; i++) {
            locations.push(new Microsoft.Maps.Location(route[i][0], route[i][1]));
        }

        var polyline = new Microsoft.Maps.Polyline(locations, {
            strokeColor: color,
            strokeThickness: 3
        });
        map.entities.push(polyline);

        if (setView) {
            map.setView({
                bounds: Microsoft.Maps.LocationRect.fromLocations(locations)
            });
        }
    }

    function ChildGetMap() {
        map = new Microsoft.Maps.Map('#divMap', {
            credentials: bmKey,
            center: new Microsoft.Maps.Location(startLat, startLng),
            showDashboard: false,
            zoom: 12
        });
        Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function() {

            directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);
            directionsManager.setRenderOptions({

                waypointPushpinOptions: {
                    title: ''
                },
                itineraryContainer: '#printoutPanel'
            });
            directionsManager.setRequestOptions({
                routeMode: Microsoft.Maps.Directions.RouteMode.truck,
                vehicleSpec: {
                    dimensionUnit: 'ft',
                    weightUnit: 'lb',
                    vehicleLength: 50,
                    vehicleWeight: 40000,

                }
            });
            //Create waypoints to route between.

            var seattleWaypoint = new Microsoft.Maps.Directions.Waypoint({
                location: new Microsoft.Maps.Location(startLat, startLng)
            });
            directionsManager.addWaypoint(seattleWaypoint);

            //var workWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: des_position, location: new Microsoft.Maps.Location(destLat,destLng) });
            var workWaypoint = new Microsoft.Maps.Directions.Waypoint({
                location: new Microsoft.Maps.Location(destLat, destLng)
            });
            directionsManager.addWaypoint(workWaypoint);

            //directionsManager.setRenderOptions({ itineraryContainer: '#printoutPanel' });
            //Calculate directions.
            map.center = new Microsoft.Maps.Location(startLat, startLng);
            directionsManager.calculateDirections();


        });

        resize();
    }

    function resize() {
        var mapDiv = document.getElementById("divMap");

        mapDiv.style.height = "500px";
    }

    // Item Delete Update
    $("#delete-child-items-status").dialog({
        width: 500,
        modal: true,
        beforeClose: function(e, ui) {
            //location.reload();
        },
        buttons: {
            OK: function() {
                $(this).dialog('close');
                //location.reload();
            }
        },
        autoOpen: false
    });

    // Delete dialog
    $("#delete-child-Items").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Delete": {
                text: 'Delete Items',
                'class': 'btn ui-button update-button',
                'id': 'confirmDelete',
                click: function() {

                    $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {
                                'ids': getSelectedIds()
                            },
                            url: "<?php echo site_url('ajax/childitemsGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                        .success(function(data) {

                            if (data.success) {
                                var deleteText = data.count + ' Items were deleted';
                            } else {
                                var deleteText = 'An error occurred. Please try again';
                            }
                            get_child_items_list(data.parent_id, false)
                            get_service_item_list_by_phase_id();
                            get_proposal_breakdown();
                            update_proposal_overhead_profit();
                            var itemIds = getSelectedIds();
                            // for($i=0;$i<itemIds.length;$i++){

                            //    var row =  $("tr#items_" + itemIds[$i]);
                            //    var table = $(row).closest('table');
                            //    table.DataTable().row(row).remove().draw();
                            //    var typeId = table.data('type-id');
                            //    $('.items_count[data-type-id="' + typeId+'"]').text(table.DataTable().rows().count());
                            //    //table.closest('.accordionHeader').find('.items_count').text(table.DataTable().rows().count())
                            //    console.log(table.DataTable().rows().count());

                            // }
                            $("#deletechildItemsStatus").html(deleteText);
                            $("#delete-child-items-status").dialog('open');
                        });

                    $(this).dialog('close');
                    $("#deletechildItemsStatus").html('Deleting Items...<img src="/static/loading.gif" />');
                    $("#delete-child-items-status").dialog('open');
                }
            },
            Cancel: function() {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
</script>

<script type="text/javascript" src="/static/js/markerclusterer.js"></script>
<script type="text/javascript" src="/static/js/MapLibrary.js"></script>

<script type="text/javascript">
    var leadsNoAdrss = null;

    var map = null;
    var MapObj;

    var selections = [];
    var directionsService;
    var directionsDisplay;
    var stepDisplay;
    var wayTmpPnt = new Array();
    //console.log(allPoints.length);

    $(document).ready(function() {

        $("#markersLoading").dialog({
            modal: true,
            autoOpen: false,
            width: 400
        });


        // initiate the function


    });

    function initialize(i) {

        if (!allPoints.length) {
            swal({
                html: '<p style="font-size: 14px:">You do not have any leads mapped!</p><br /><p style="font-size: 14px:">Make sure you add accurate address information for each lead to enable mapping.</p>'
            });

            return false;
        }


        if (MapObj == undefined) {
            initMap(destLat, destLng, i);
        } // initiate the map when 1st address geocoded to set the map center
        else {
            console.log(allPoints);
            createMarker(i); // create markers
            var j = ++i;
            // check the recurssive condition
            if (j < allPoints.length) {
                setTimeout(function() {
                    initialize(j);
                }, 100); //call same function for loop
            }

        }

    }

    // map initialization
    function initMap(lat, lng, i) {

        directionsService = new google.maps.DirectionsService;
        MapObj = new GetMap('mapDiv', {
            zoom: 8,
            //center: {lat: parseFloat(lat), lng: parseFloat(lng)}, // center to set the map
            initMap: true, // initialize the map by default
            callback: function() { // function to run once on map idle event or map after map finish loading
                createMarker(i);
                createHomeMarker();
                var j = ++i;
                if (j < allPoints.length) // check the recurssive condition
                    initialize(j);
            },
            zoomControl: true,
            zoomControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            streetViewControl: true,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            mapTypeControl: false,
            fullscreenControl: false,
            gestureHandling: 'greedy'
        });

        map = MapObj.getMap();



    }


    function createHomeMarker() {
        homePoint = new google.maps.Marker({});
        myLatLng = new google.maps.LatLng(parseFloat(destLat), parseFloat(destLng));

        var iconImg = '<?php echo site_url('static/house.png'); ?>';

        var icon = new google.maps.MarkerImage(iconImg, new google.maps.Size(25, 25));
        homePoint.zIndex = 9999;
        homePoint.position = myLatLng;
        homePoint.icon = icon; // set the icon for marker
        homePoint.infowindow = true; // set infowindow parameter to true to open infowindow on click of marker

        var markerContent = '<div style="min-height: 50px; color:#4682B4; margin:auto;">';
        markerContent += '<table>';
        markerContent += '<tr>';
        markerContent += '<td style="text-align: right;"><strong>Company:</strong></td>';
        markerContent += '<td style="padding-left: 10px;">' + jon_site_company + '</td>';
        markerContent += '</tr>';
        markerContent += '<tr>';
        markerContent += '<td style="text-align: right;"><strong>Contact:</strong></td>';
        markerContent += '<td style="padding-left: 10px;">' + job_site_contact_name + '</td>';
        markerContent += '</tr>';
        markerContent += '<tr>';
        markerContent += '<tr>';
        markerContent += '<td style="text-align: right;"><strong>Address:</strong></td>';
        markerContent += '<td style="padding-left: 10px;">' + job_site_address + '</td>';
        markerContent += '</tr>';
        markerContent += '<tr>';
        markerContent += '<td style="text-align: right;"><strong>Email:</strong></td>';
        markerContent += '<td style="padding-left: 10px;"><a href="mailto:' + jon_site_email + '">' + jon_site_email + '</a></td>';
        markerContent += '</tr>';
        markerContent += '<tr>';
        markerContent += '<td style="text-align: right;"><strong>Phone:</strong></td>';
        markerContent += '<td style="padding-left: 10px;">' + jon_site_phone + '</td>';
        markerContent += '</tr>';
        // markerContent += '<tr>';
        // markerContent += '<td style="text-align: right;"><strong>Company:</strong></td>';
        // markerContent += '<td style="padding-left: 10px;">' +allPoints[i].company_name + '</td>';
        // markerContent += '</tr>';

        markerContent += '</table>';
        markerContent += '</div>';
        homePoint.infowindowContent = markerContent; // set the content to show on infowindow
        // marker = MapObj.createMarker(homePoint); // call function to create single markers.

        MapObj.createMarker(homePoint);

    }
    // create markers
    function createMarker(i) {

        if (allPoints[i].lat != undefined && allPoints[i].lng != undefined) {
            myLatLng = new google.maps.LatLng(allPoints[i].lat, allPoints[i].lng);

            var j = 1;
            if (allPoints[i].type == 'plant') {
                var label = 'Plant';
                var color = 'rgb(1,51,134)';
                var iconImg = '<?php echo site_url('static/images/plant-icon.png'); ?>';
            } else {
                var label = 'Dump';
                var color = 'rgb(220,122,0)';
                var iconImg = '<?php echo site_url('static/images/dump-icon.png'); ?>';
            }



            // var icon = new google.maps.MarkerImage(iconImg, new google.maps.Size(20,20));
            var icon = {
                anchor: new google.maps.Point(16, 16),
                url: 'data:image/svg+xml;utf-8, \
      <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"> \
      <circle cx="10" cy="10" r="10" fill="' + color + '" /><text font-family="Helvetica, Arial, sans-serif"  font-size="12px" x="10"  y="14.5" text-anchor="middle" fill="white">' + allPoints[i].company_name.charAt(0).toUpperCase() + '</text> \
      </svg>'
            };
            allPoints[i].position = new google.maps.LatLng(allPoints[i].lat, allPoints[i].lng);
            allPoints[i].icon = icon; // set the icon for marker
            allPoints[i].i = i;
            allPoints[i].infowindow = true; // set infowindow parameter to true to open infowindow on click of marker

            var markerContent = '<div style="min-height: 50px; color:#4682B4; margin:auto;">';
            markerContent += '<table>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>' + label + ' Name:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' + allPoints[i].plant_name + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Company:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' + allPoints[i].company_name + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Address:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' + allPoints[i].address + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>City:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' + allPoints[i].city + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>State:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' + allPoints[i].state + '</td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Zip:</strong></td>';
            markerContent += '<td style="padding-left: 10px;">' + allPoints[i].zip + '</td>';
            markerContent += '</tr>';
            // markerContent += '<tr>';
            // markerContent += '<td style="text-align: right;"><strong>Distance:</strong></td>';
            // markerContent += '<td style="padding-left: 10px;">' +allPoints[i].distance + '</td>';
            // markerContent += '</tr>';
            // markerContent += '<tr>';
            // markerContent += '<td style="text-align: right;"><strong>Email:</strong></td>';
            // markerContent += '<td style="padding-left: 10px;"><a href="mailto:' + allPoints[i].email + '">' + allPoints[i].email + '</a></td>';
            // markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td style="text-align: right;"><strong>Phone:</strong></td>';
            markerContent += '<td style="padding-left: 10px;"><a href="tel:' + allPoints[i].phone + '">' + allPoints[i].phone + '</a></td>';
            markerContent += '</tr>';
            markerContent += '<tr>';
            markerContent += '<td colspan="2" style="text-align: center; font-size: 0.8em;"><a href="#" style="padding:5px" class="btn select_plant ui-button ui-state-default ui-corner-all" data-val="' + allPoints[i].id + '" data-type="' + allPoints[i].type + '">Use this ' + label + '</a></td>';
            markerContent += '</tr>';
            markerContent += '</table>';
            markerContent += '</div>';
            allPoints[i].infowindowContent = markerContent; // set the content to show on infowindow
            marker = MapObj.createMarker(allPoints[i]); // call function to create single markers.

            if ($('#group').val() == 1) {
                selections.push(marker);
                if (allPoints.length - 1 == i)
                    startDrawRoute();
            }

            if (i == allPoints.length - 1) {
                //MapObj.setMarkerCluster();      // to set the marker cluster
                MapObj.SetBounds();
            }

        }
        google.maps.event.trigger(map, "resize");
        var myLatLng = {
            lat: parseFloat(destLat),
            lng: parseFloat(destLng)
        };
        map.setCenter(myLatLng);
        map.setZoom(8);
        // MapObj.SetBounds();

    }



    $(document).on('click', ".select_plant", function() {
        if (plant_dump_map_type == 'dump') {
            $('.dumpSelect').val($(this).data('val'));
            $('.dumpSelect').trigger('change');
        } else {
            $('.plantSelect').val($(this).data('val'));
            $('.plantSelect').trigger('change');
        }
        $.uniform.update();
        $('.show_marker_map').hide();

        $('.trucking_form_right_box').show();
        marker.infoWindow.close();
    })

    $(document).on('click', ".recenter-map", function() {
        map.panTo(myLatLng);
    })

    $(".selectTruckingStart").change(function() {
        unsave_cal = true;
        if ($(this).val()) {
            var form_id = $(this).closest('form').attr('id');
            sep_startLat = $(this).find(":selected").data('lat');
            sep_startLng = $(this).find(":selected").data('lng');
            var startSelect = $(this).find(":selected").data('address');

            $('#sep_trucking_start_searchBox').removeClass('error');
            $('#sep_trucking_start_searchBox').val(startSelect);
            $('#sep_trucking_start_lat').val(sep_startLat);
            $('#sep_trucking_start_long').val(sep_startLng);
            //$('#sep_trucking_start_searchBox').focus();
            if (!sep_startLat) {
                setTimeout(function() {
                    $('#sep_trucking_start_searchBox').focus()
                }, 500);
            } else {
                if ($(".selectTruckingEnd").val()) {
                    sep_calculateRoute();

                }
            }
        }
    });

    $(".selectTruckingEnd").change(function() {
        unsave_cal = true;
        if ($(this).val()) {
            var form_id = $(this).closest('form').attr('id');
            sep_destLat = $(this).find(":selected").data('lat');
            sep_destLng = $(this).find(":selected").data('lng');
            var endSelect = $(this).find(":selected").data('address');

            $('#sep_trucking_end_searchBox').removeClass('error');
            $('#sep_trucking_end_searchBox').val(endSelect);
            $('#sep_trucking_end_lat').val(sep_destLat);
            $('#sep_trucking_end_long').val(sep_destLng);
            if (!sep_destLat) {
                setTimeout(function() {
                    $('#sep_trucking_end_searchBox').focus()
                }, 500);
            } else {
                if ($(".selectTruckingStart").val()) {
                    sep_calculateRoute();

                }
            }

        }
    });
</script>