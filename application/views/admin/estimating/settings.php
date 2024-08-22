
<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
<h3>Default Estimation Settings</h3>

<form action="<?php echo site_url('admin/saveEstimationSettings'); ?>" id="settingForm" method="post">

    <table class="boxed-table pl-striped" width="100%" cellpadding="0" cellspacing="0">
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
            </td>
        </tr>
        <tr>
            <td>
                <label for="defaultOverhead">Default Overhead %</label>
                <input type="number" name="defaultOverhead" id="defaultOverhead" class="text" style="width: 50px; text-align: right"
                       value="<?php echo $settings->getDefaultOverhead(); ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="defaultProfit">Default Profit Margin %</label>
                <input type="number" name="defaultProfit" id="defaultProfit" class="text"  style="width: 50px; text-align: right"
                       value="<?php echo $settings->getDefaultProfit(); ?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="productionRate">Default Production Rate</label>
                <input type="number" name="productionRate" id="productionRate" class="text"  style="width: 50px; text-align: right"
                       value="<?php echo $settings->getProductionRate(); ?>">
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
</div>
</div>

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
<?php $this->load->view('global/footer'); ?>