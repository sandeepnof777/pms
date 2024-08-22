
<!-- add a back button  -->
<!-- <a style="float: right;margin-right: 20px;margin-top: 12px;font-size: 14px;font-weight: bold;" href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
<h3>Default Estimation Settings</h3>
<form action="<?php echo site_url('account/saveEstimationSettings'); ?>" id="settingForm" method="post">

    <table class="boxed-table pl-striped" width="100%" cellpadding="0" cellspacing="0">
        <tr style="background-color: #dddddd;"><td style="padding:10px"><b style="font-size: 16px">Calculation Type</b></td></tr>
        <tr>
            <td>
                <label for="defaultOverhead">Default Calculation Type</label>
                <select name="calculationType">
                    <?php foreach ($calculationTypes as $calculationType) : ?>
                    <option value="<?php echo $calculationType->getId() ?>"<?php echo ($calculationType->getId() == $settings->getCalculationType()) ? ' selected' : '' ?>>
                        <?php echo $calculationType->getName(); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <i class="fa fa-info-circle fa-1x info_tip tiptip" style="padding-top: 5px;font-size:15px" title="Choose whether PM/OH cna be changed on a per item basis, or set for all items in a service" aria-hidden="true"></i>
            </td>
        </tr>
        
        <tr style="background-color: #dddddd;"><td style="padding:10px"><b style="font-size: 16px">Default Profit and Overhead</b></td></tr>
        <tr>
            <td>
                <label for="defaultOverhead">Default Overhead %</label>
                <input type="number" name="defaultOverhead" id="defaultOverhead" class="text" style="width: 50px; text-align: right"
                       value="<?php echo $settings->getDefaultOverhead(); ?>">
                       <i class="fa fa-info-circle fa-1x info_tip tiptip" style="padding-top: 5px;font-size:15px" title="Choose your default Overhead rate for items" aria-hidden="true"></i>
            </td>
        </tr>
        <tr>
            <td>
                <label for="defaultProfit">Default Profit Margin %</label>
                <input type="number" name="defaultProfit" id="defaultProfit" class="text"  style="width: 50px; text-align: right"
                       value="<?php echo $settings->getDefaultProfit(); ?>">
                <i class="fa fa-info-circle fa-1x info_tip tiptip" style="padding-top: 5px;font-size:15px" title="Choose your default Profit Margin for items" aria-hidden="true"></i>
                
            </td>
        </tr>
        <tr style="background-color: #dddddd;"><td style="padding:10px"><b style="font-size: 16px">Production Rate</b></td></tr>
        <tr>
            <td>
                <label for="productionRate">Default Production Rate</label>
                <input type="number" name="productionRate"  id="productionRate" class="text"  style="width: 50px; text-align: right"
                       value="<?php echo $settings->getProductionRate(); ?>"><span style="padding-top: 6px;display:inline-block;">Tons</span>
                <i class="fa fa-info-circle fa-1x info_tip tiptip" style="padding-top: 5px;font-size:15px" title="Default value for # tons that can be put down in a day. Used in Trucking Calculations" aria-hidden="true"></i>
            </td>
        </tr>
        <tr style="background-color: #dddddd;"><td style="padding:10px"><b style="font-size: 16px">Disposal Load Price</b></td></tr>
        <tr>
            <td>
                <label for="disposalLoad">Default Disposal Load </label>
                <input type="number" name="disposalLoad"  id="disposalLoad" class="text"  style="width: 50px; text-align: right"
                       value="<?php echo $settings->getDisposalLoad(); ?>"><span style="padding-top: 6px;display:inline-block;"></span>
                <i class="fa fa-info-circle fa-1x info_tip tiptip" style="padding-top: 5px;font-size:15px" title="Default value for Disposal Load. Used in Concrete Calculations" aria-hidden="true"></i>
            </td>
        </tr>
        <tr style="background-color: #dddddd;"><td style="padding:10px"><b style="font-size: 16px">Work Order Settings</b></td></tr>
        <tr>
            <td>
                <label for="">Work Order Layout</label>
                <select name="work_order_layout_type">
                  
                    <option value="service_and_phase" <?php echo ('service_and_phase' == $settings->getWorkOrderLayoutType()) ? ' selected' : '' ?>>Service & Phase</option>
                    <option value="service" <?php echo ('service' == $settings->getWorkOrderLayoutType()) ? ' selected' : '' ?>>Service</option>
                    <option value="all_items" <?php echo ('all_items' == $settings->getWorkOrderLayoutType()) ? ' selected' : '' ?>>All Items</option>
                   
                </select>
                <i class="fa fa-info-circle fa-1x info_tip tiptip" style="padding-top: 5px;font-size:15px" title="Choose how to break down your estimation items in the work order" aria-hidden="true"></i>

            </td>
        </tr>
        <tr>
            <td>
                <label for="">Group Assembly Items</label>
                <input type="checkbox" name="group_template_item" id="group_template_item" <?php echo ('1' == $settings->getGroupTemplateItem()) ? 'checked="checked"' : '' ?> value="1">
                <i class="fa fa-info-circle fa-1x info_tip tiptip " style="padding-top: 5px;font-size:15px" title="Choose whether or not assembly items are grouped together in a work order" aria-hidden="true"></i>
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn blue-button" type="submit">
                    <i class="fa fa-fw fa-save"></i> Save Settings
                </button>
            </td>
        </tr>

    </table>

</form>


<script type="text/javascript">

    $(document).ready(function() {
        $('#settingForm').validate({
        rules: {
            defaultOverhead: {
                required: true,
                min: 1,
                number: true
            },
            productionRate: {
                required: true,
                min: 1,
                number: true
            },
            defaultProfit: {
                required: true,
                min: 1,
                number: true
            }
        }
    });
    });

    $(document).on("keyup","#defaultOverhead,#productionRate,#defaultProfit",function() {
           
           $('#settingForm').valid();
       })
</script>