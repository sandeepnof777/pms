<h1 class="centered">Seal Coating Calculator</h1>
<?php
if ($service) {
    ?>
    <div class="clearfix centered">
        <h4>Calculator for <span><?php echo $service->getServiceName() ?></span> <span>(<?php echo $proposal->getProjectName() ?>)</span>. Click Save or Back to go back to the proposal.</h4>
    </div>
<?php
}
?>
<div class="clearfix">
<div class="half left">
<div class="content-box left half black">
    <div class="box-header centered">1. Enter Material Costs</div>
    <div class="box-content">
        <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            <tr>
                <td>
                    <label>Sealer Cost</label>
                    <input type="text" name="sealcoatSealerCost" id="sealcoatSealerCost" size="5" value="<?php
                    if ($service) {
                        $value = $this->calculator->getValue($service->getServiceId(), 'sealcoatSealerCost');
                        if ($value == false) {
                            $cachedValue = $this->calculator->getLastValue($service->getInitialService(), $account->getCompany()->getCompanyId(), 'sealcoatSealerCost');
                            echo ($cachedValue) ? $cachedValue : 0;
                        } else {
                            echo $value;
                        }
                    } else {
                        echo 0;
                    }
                    ?>" class="numberFormat">
                    <label style="text-align: left;"> $ / Gal</label>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Sand Cost</label>
                    <input type="text" name="sealcoatSandCost" id="sealcoatSandCost" size="5" value="<?php
                    if ($service) {
                        $value = $this->calculator->getValue($service->getServiceId(), 'sealcoatSandCost');
                        if ($value == false) {
                            $cachedValue = $this->calculator->getLastValue($service->getInitialService(), $account->getCompany()->getCompanyId(), 'sealcoatSandCost');
                            echo ($cachedValue) ? $cachedValue : 0;
                        } else {
                            echo $value;
                        }
                    } else {
                        echo 0;
                    }
                    ?>" class="numberFormat">
                    <label style="text-align: left;"> $ / 100Lb</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Additive Cost</label>
                    <input type="text" name="sealcoatAdditiveCost" id="sealcoatAdditiveCost" size="5" value="<?php
                    if ($service) {
                        $value = $this->calculator->getValue($service->getServiceId(), 'sealcoatAdditiveCost');
                        if ($value == false) {
                            $cachedValue = $this->calculator->getLastValue($service->getInitialService(), $account->getCompany()->getCompanyId(), 'sealcoatAdditiveCost');
                            echo ($cachedValue) ? $cachedValue : 0;
                        } else {
                            echo $value;
                        }
                    } else {
                        echo 0;
                    }
                    ?>" class="numberFormat">
                    <label style="text-align: left;"> $ / Gal</label>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Labor Hourly Rate</label>
                    <input type="text" name="sealcoatHourlyCost" id="sealcoatHourlyCost" size="5" value="<?php
                    if ($service) {
                        $value = $this->calculator->getValue($service->getServiceId(), 'sealcoatHourlyCost');
                        if ($value == false) {
                            $cachedValue = $this->calculator->getLastValue($service->getInitialService(), $account->getCompany()->getCompanyId(), 'sealcoatHourlyCost');
                            echo ($cachedValue) ? $cachedValue : 0;
                        } else {
                            echo $value;
                        }
                    } else {
                        echo 0;
                    }
                    ?>" class="numberFormat">
                    <label style="text-align: left; width: 220px;"> $ (+ all taxes + insurance)</label>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="content-box left half black">
    <div class="box-header centered">2. Project Specifications</div>
    <div class="box-content">
        <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            <tr>
                <td>
                    <label>Number of coats</label>
                    <select name="sealcoatCoats" id="sealcoatCoats">
                        <?php
                        for ($i = 1; $i <= 4; $i++) {
                            ?>
                            <option <?php echo ($service && (@$fields['number_of_coats'] == $i)) ? ' selected="selected"' : ''; ?>><?php echo $i ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Area</label>
                    <input type="text" name="sealcoatArea" id="sealcoatArea" size="5" value="<?php echo ($service) ? $fields['area'] : '0'; ?>" class="numberFormat">
                    <select name="sealcoatUnit" id="sealcoatUnit">
                        <option value="yd" <?php echo ($service && (@$fields['area_unit'] == 'square yards')) ? ' selected="selected"' : ''; ?>>Sq. Yds.</option>
                        <option value="ft" <?php echo ($service && (@$fields['area_unit'] == 'square feet')) ? ' selected="selected"' : ''; ?>>Sq. Ft.</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Application Rate</label>
                        <span class="apprate1_container">
                            <?php
                            $selectedApprateValue = ($service) ? $this->calculator->getValue($service->getServiceId(), 'sealcoatApplicationRate') : 0.16;
                            ?>
                            <select class="apprate apprate1" name="sealcoatApplicationRate">
                                <?php
                                for ($i = 0.05; $i <= 0.23; $i += 0.01) {
                                    ?>
                                    <option <?php echo ($selectedApprateValue == $i) ? 'selected="selected"' : '' ?>><?php echo $i; ?></option><?php
                                }
                                ?>
                            </select>
                        </span>
                        <span class="apprate2_container">
                            <?php
                            $selectedApprateValue2 = ($service) ? $this->calculator->getValue($service->getServiceId(), 'sealcoatApplicationRate') : 1000;
                            ?>
                            <select class="apprate apprate2" name="sealcoatApplicationRate">
                                <?php
                                for ($i = 0.005; $i <= 0.022; $i += 0.001) {
                                    ?>
                                    <option <?php echo (abs($i - $selectedApprateValue2) < 0.00001) ? 'selected="selected" x="c"' : '' ?>><?php echo $i; ?></option><?php
                                }
                                ?>
                            </select>
                        </span>
                    <span>Gal / <span id="sealCoatUnitValue2"></span></span>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>% of Water</label>
                    <select name="sealcoatWater" id="sealcoatWater">
                        <?php
                        for ($i = 0; $i <= 50; $i += 5) {
                            ?>
                            <option <?php echo ($service && $this->calculator->getValue($service->getServiceId(), 'sealcoatWater') == $i) ? 'selected="selected"' : '' ?>><?php echo $i; ?></option><?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>% of Additive</label>
                    <select name="sealcoatAdditive" id="sealcoatAdditive">
                        <?php
                        for ($i = 0; $i <= 6; $i += 1) {
                            ?>
                            <option <?php echo ($service && $this->calculator->getValue($service->getServiceId(), 'sealcoatAdditive') == $i) ? 'selected="selected"' : '' ?>><?php echo $i; ?></option><?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Sand</label>
                    <select name="sealcoatSand" id="sealcoatSand">
                        <?php
                        for ($i = 0; $i <= 6; $i += 1) {
                            ?>
                            <option <?php echo ($service && $this->calculator->getValue($service->getServiceId(), 'sealcoatSand') == $i) ? 'selected="selected"' : '' ?>><?php echo $i; ?></option><?php
                        }
                        ?>
                    </select> Lb / Gal
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="content-box left half black">
    <div class="box-header centered">3. Labor for Project</div>
    <div class="box-content">
        <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            <tr>
                <td>
                    <label>Trip Count</label>
                    <select name="sealcoatTrips" id="sealcoatTrips">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            ?>
                            <option <?php echo ($service && (@$fields['trips'] == $i)) ? ' selected="selected"' : ''; ?>><?php echo $i ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Men #</label>
                    <input type="text" name="sealcoatMen" id="sealcoatMen" size="5" value="<?php
                    if ($service) {
                        $value = $this->calculator->getValue($service->getServiceId(), 'sealcoatMen');
                        echo ($value) ? $value : '0';
                    } else {
                        echo 0;
                    }
                    ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Hours per Trip</label>
                    <input type="text" name="sealcoatTripHours" id="sealcoatTripHours" size="5" value="<?php
                    if ($service) {
                        $value = $this->calculator->getValue($service->getServiceId(), 'sealcoatTripHours');
                        echo ($value) ? $value : '0';
                    } else {
                        echo 0;
                    }
                    ?>">
                </td>
            </tr>
            <tr class="even">
                <td>
                    <label>Overhead</label>
                    <input type="text" name="sealcoatOverhead" id="sealcoatOverhead" size="5" value="<?php
                    if ($service) {
                        $value = $this->calculator->getValue($service->getServiceId(), 'sealcoatOverhead');
                        echo ($value) ? $value : '0';
                    } else {
                        echo 0;
                    }
                    ?>" class="numberFormat">
                    <label style="text-align: left;">$ / Trip</label>
                </td>
            </tr>
            <tr>
                <td class="last">
                    <label>Profit</label>
                    <input type="text" name="sealcoatProffit" id="sealcoatProffit" size="5" value="<?php
                    if ($service) {
                        $value = $this->calculator->getValue($service->getServiceId(), 'sealcoatProffit');
                        echo ($value) ? $value : '0';
                    } else {
                        echo 0;
                    }
                    ?>" class="numberFormat">
                    <label style="text-align: left;">$ / Trip</label>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
<div class="half right">
    <div class="content-box right half blue">
        <div class="box-header centered">Total Material Breakdown</div>
        <div class="box-content">
            <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td width="150">
                        <label>Total Bulk Sealer</label>
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
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Sand</label>
                    </td>
                    <td>
                        <strong id="sealcoatSandTotal"></strong> Lb / <strong id="sealcoatSandTotalGal"></strong> Gal
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Total Project Gallons</label>
                    </td>
                    <td>
                        <strong id="sealcoatTotal"></strong> Gallons
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="content-box right half blue">
        <div class="box-header centered">Project Costs</div>
        <div class="box-content">
            <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <td>&nbsp;</td>
                    <td style="text-align: left;">
                        Total Cost
                    </td>
                    <td style="text-align: left;">
                        Cost/Unit
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label>Sealer Cost:</label>
                    </td>
                    <td>$<span id="sealcoatTotalSealerValue"></span></td>
                    <td>$<span id="sealcoatTotalSealerValuePerArea"></span></td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Sand Cost:</label>
                    </td>
                    <td>$<span id="sealcoatTotalSandValue"></span></td>
                    <td>$<span id="sealcoatTotalSandValuePerArea"></span></td>
                </tr>
                <tr>
                    <td>
                        <label>Additive Cost:</label>
                    </td>
                    <td>$<span id="sealcoatTotalAdditiveValue"></span></td>
                    <td>$<span id="sealcoatTotalAdditiveValuePerArea"></span></td>
                </tr>
                <tr class="even">
                    <td class="">
                        <label>Total Material Cost:</label>
                    </td>
                    <td>$<span id="sealcoatMaterialCost"></span></td>
                    <td>$<span id="sealcoatMaterialCostPerArea"></span></td>
                </tr>
                <tr>
                    <td class="">
                        <label>Total Labor Cost</label>
                    </td>
                    <td>$<span id="sealcoatLaborCost"></span></td>
                    <td>$<span id="sealcoatLaborCostPerArea"></span></td>
                </tr>
                <tr class="even">
                    <td class="">
                        <label>Overhead+Profit</label>
                    </td>
                    <td>$<span id="sealcoatOverheadAndProffit"></span></td>
                    <td>$<span id="sealcoatOverheadAndProffitPerArea"></span></td>
                </tr>
                <tr>
                    <td class="black last">
                        <label>Total Project Cost:</label>
                    </td>
                    <td>$<span id="sealcoatTotalCost"></span></td>
                    <td>$<span id="sealcoatTotalCostPerArea"></span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="content-box right half blue">
        <div class="box-header centered">Print</div>
        <div class="box-content">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="boxed-table">
                <tbody>
                <tr>
                    <td>
                        <label>Project Name</label>
                        <input type="text" style="width: 250px;" name="sealcoatProjectName" id="sealcoatProjectName">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>&nbsp;</label>
                        <?php
                        if ($service) {
                            ?>
                            <a class="btn update-button" href="<?php echo site_url('proposals/edit/' . $proposal->getProposalId()) ?>" id="saveFields">Save</a>
                            <a href="#" class="print btn">Print</a>
                            <a class="btn" href="<?php echo site_url('proposals/edit/' . $proposal->getProposalId()) ?>" id="backToProposal">Cancel</a>
                        <?php
                        } else {
                            ?>
                            <a href="#" class="print btn">Print</a>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php if ($service) { ?>
    <div id="cancel">
        Are you sure you want to cancel? All of your changes will be lost!
    </div>
<?php } ?>
<script type="text/javascript">
$(document).ready(function () {
    <?php if ($service) { ?>
    $("#backToProposal").click(function () {
        $("#cancel").dialog('open');
        return false;
    });
    $("#cancel").dialog({
        autoOpen: false,
        width: 500,
        buttons: {
            Ok: function () {
                document.location.href = $("#backToProposal").attr('href');
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        }
    });
    $("#saveFields").click(function () {
        //save the fields in question to their respective service and redirect
        var data = {};
        data.number_of_coats = $("#sealcoatCoats").val();
        data.area = $("#sealcoatArea").val();
        data.area_unit = $("#sealcoatUnit").val();
        if (data.area_unit == 'ft') {
            data.area_unit = 'square feet';
        } else {
            data.area_unit = 'square yards';
        }
        data.trips = $("#sealcoatTrips").val();
        var postData = {};
        postData.price = '$' + $("#sealcoatTotalCost").html();
        postData.serviceId = <?php echo $service->getServiceId() ?>;
        postData.fields = data;
        //save the other fields to the calculators database
        var fieldsPostData = {};
        var fields = {};
        //fields start
        fields.sealcoatApplicationRate = $("#sealcoatApplicationRate").val();
        fields.sealcoatWater = $("#sealcoatWater").val();
        fields.sealcoatAdditive = $("#sealcoatAdditive").val();
        fields.sealcoatSand = $("#sealcoatSand").val();
        fields.sealcoatSealerCost = $("#sealcoatSealerCost").val();
        fields.sealcoatSandCost = $("#sealcoatSandCost").val();
        fields.sealcoatAdditiveCost = $("#sealcoatAdditiveCost").val();
        fields.sealcoatHourlyCost = $("#sealcoatHourlyCost").val();
        fields.sealcoatMen = $("#sealcoatMen").val();
        fields.sealcoatTripHours = $("#sealcoatTripHours").val();
        fields.sealcoatOverhead = $("#sealcoatOverhead").val();
        fields.sealcoatProffit = $("#sealcoatProffit").val();
        //fields end
        fieldsPostData.serviceId = <?php echo $service->getServiceId() ?>;
        fieldsPostData.initialService = <?php echo $service->getInitialService() ?>;
        fieldsPostData.fields = fields;
        $.post('<?php echo site_url('ajax/serviceSaveFields') ?>', postData, function () {
            $.post('<?php echo site_url('ajax/calculatorSaveFields') ?>', fieldsPostData, function () {
                document.location.href = $("#saveFields").attr('href');
            });
        });
        return false;
    });
    <?php  } ?>
    /**********************
     * Seal Coat Calculator *
     ************************/
    var sealcoatFields = "#sealcoatOverhead, #sealcoatProffit, #sealcoatHourlyCost, #sealcoatTripHours, #sealcoatMen, #sealcoatTrips, #sealcoatCoats, #sealcoatUnit, #sealcoatArea, #sealcoatWater, #sealcoatAdditive, #sealcoatSand, #sealcoatApplicationRate, #sealcoatSealerCost, #sealcoatSandCost, #sealcoatAdditiveCost";
    $(sealcoatFields).live('change keyup', function () {
        sealcoatCalculator();
    });
    var requestAuth;

    function sealcoatCalculator() {
        if ($("#sealcoatUnit").val() == 'ft') {
            $("#sealCoatUnitValue2").html('Sq.Feet');
            $(".apprate").removeAttr('id');
            $(".apprate2").attr('id', 'sealcoatApplicationRate');
            $(".apprate1_container").hide();
            $(".apprate2_container").show();
        } else {
            $("#sealCoatUnitValue2").html('Sq.Yards');
            $(".apprate").removeAttr('id');
            $(".apprate1").attr('id', 'sealcoatApplicationRate');
            $(".apprate2_container").hide();
            $(".apprate1_container").show();
        }
        requestAuth = Math.floor((Math.random() * 1000) + 1);
        var request = $.ajax({
            url: "<?php echo site_url('ajax/ajaxCalculators') ?>",
            type: "POST",
            data: {
                "action": "calculator_sealcoat",
                'area': $("#sealcoatArea").val(),
                'applicationRate': $("#sealcoatApplicationRate").val(),
                'water': $("#sealcoatWater").val(),
                'additive': $("#sealcoatAdditive").val(),
                'sand': $("#sealcoatSand").val(),
                'sealerPrice': $("#sealcoatSealerCost").val(),
                'sandPrice': $("#sealcoatSandCost").val(),
                'additivePrice': $("#sealcoatAdditiveCost").val(),
                'tripCount': $("#sealcoatTrips").val(),
                'tripHours': $("#sealcoatTripHours").val(),
                'tripMen': $("#sealcoatMen").val(),
                'tripHourlyCost': $("#sealcoatHourlyCost").val(),
                'overhead': $("#sealcoatOverhead").val(),
                'proffit': $("#sealcoatProffit").val(),
                'requestAuth': requestAuth
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    if (data.requestAuth == requestAuth) {
                        $("#sealcoatSealerTotal").html(addCommas(data.sealer.toFixed(2)));
                        $("#sealcoatWaterTotal").html(addCommas(data.water.toFixed(2)));
                        $("#sealcoatAdditiveTotal").html(addCommas(data.additive.toFixed(2)));
                        $("#sealcoatSandTotal").html(addCommas(data.sand.toFixed(2)));
                        $("#sealcoatSandTotalGal").html(addCommas(data.sandInGall.toFixed(2)));
                        $("#sealcoatTotal").html(addCommas(data.totalGallons.toFixed(2)));
                        $("#sealcoatTotalSealerValue").html(addCommas(data.sealerCost.toFixed(2)));
                        $("#sealcoatTotalSealerValuePerArea").html(addCommas(data.sealerCostPerUnit.toFixed(2)));
                        $("#sealcoatTotalSandValue").html(addCommas(data.sandCost.toFixed(2)));
                        $("#sealcoatTotalSandValuePerArea").html(addCommas(data.sandCostPerUnit.toFixed(2)));
                        $("#sealcoatTotalAdditiveValue").html(addCommas(data.additiveCost.toFixed(2)));
                        $("#sealcoatTotalAdditiveValuePerArea").html(addCommas(data.additiveCostPerUnit.toFixed(2)));
                        $("#sealcoatMaterialCost").html(addCommas(data.materialCost.toFixed(2)));
                        $("#sealcoatMaterialCostPerArea").html(addCommas(data.materialCostPerUnit.toFixed(2)));
                        $("#sealcoatLaborCost").html(addCommas(data.laborCost.toFixed(2)));
                        $("#sealcoatLaborCostPerArea").html(addCommas(data.laborCostPerUnit.toFixed(2)));
                        $("#sealcoatOverheadAndProffit").html(addCommas(data.overheadAndProffit.toFixed(2)));
                        $("#sealcoatOverheadAndProffitPerArea").html(addCommas(data.overheadAndProffitPerUnit.toFixed(2)));
                        $("#sealcoatTotalCost").html(addCommas(data.totalCost.toFixed(2)));
                        $("#sealcoatTotalCostPerArea").html(addCommas(data.totalCostPerUnit.toFixed(2)));
                    }
                } else {
                    alert('error handling request');
                }
            }
        });
    }

    sealcoatCalculator();
    $(".print").click(function () {
        var settings = {
            "title": "Sealcoating Job Cost Sheet",
            "project_name": $("#sealcoatProjectName").val(),
            "boxes": {
                left: {
                    0: {
                        "heading": "Material Costs",
                        data: new Array(
                            ['Sealer Cost', '$' + $("#sealcoatSealerCost").val() + ' / Gal'],
                            ['Sand Cost', '$' + $("#sealcoatSandCost").val() + ' / 100Lb'],
                            ['Additive Cost', '$' + $("#sealcoatAdditiveCost").val() + ' / Gal'],
                            ['Labor Hourly Rate', '$' + $("#sealcoatHourlyCost").val() + '(+All taxes+Ins.)']
                        )
                    },
                    1: {
                        "heading": "Labor for Project",
                        data: new Array(
                            ['Trip Count', $("#sealcoatTrips").val()],
                            ['Men #', $("#sealcoatMen").val()],
                            ['Hours per Trip', $("#sealcoatTripHours").val()],
                            ['Overhead', '$' + $("#sealcoatOverhead").val() + ' / Trip'],
                            ['Profit', '$' + $("#sealcoatProffit").val() + ' / Trip']
                        )
                    },
                    2: {
                        "heading": "Project Costs",
                        data: new Array(
                            ['', 'Total Cost', 'Cost/Unit'],
                            ['Sealer Cost', '$' + $("#sealcoatTotalSealerValue").html(), '$' + $("#sealcoatTotalSealerValuePerArea").html()],
                            ['Sand Cost', '$' + $("#sealcoatTotalSandValue").html(), '$' + $("#sealcoatTotalSandValuePerArea").html()],
                            ['Additive Cost', '$' + $("#sealcoatTotalAdditiveValue").html(), '$' + $("#sealcoatTotalAdditiveValuePerArea").html()],
                            ['Total Material Cost', '$' + $("#sealcoatMaterialCost").html(), '$' + $("#sealcoatMaterialCostPerArea").html()],
                            ['Total Labor Cost', '$' + $("#sealcoatLaborCost").html(), '$' + $("#sealcoatLaborCostPerArea").html()],
                            ['Overhead+Profit', '$' + $("#sealcoatOverheadAndProffit").html(), '$' + $("#sealcoatOverheadAndProffitPerArea").html()],
                            ['Total Project Cost', '$' + $("#sealcoatTotalCost").html(), '$' + $("#sealcoatTotalCostPerArea").html(), 'black']
                        )
                    }
                },
                right: {
                    0: {
                        "heading": "Project Specifications",
                        data: new Array(
                            ['Number of coats', $("#sealcoatCoats").val()],
                            ['Area', $("#sealcoatArea").val() + ' Sq.' + $("#sealcoatUnit").val().charAt(0).toUpperCase() + $("#sealcoatUnit").val().slice(1) + '.'],
                            ['Application Rate', $("#sealcoatApplicationRate").val()],
                            ['% of Water', $("#sealcoatWater").val()],
                            ['% of Additive', $("#sealcoatAdditive").val()],
                            ['Sand', $("#sealcoatSand").val()]
                        )
                    },
                    1: {
                        "heading": "Total Material Breakdown",
                        data: new Array(
                            ['Total Bulk Sealer', $("#sealcoatSealerTotal").html() + ' Gal'],
                            ['Water', $("#sealcoatWaterTotal").html() + ' Gal'],
                            ['Additive', $("#sealcoatAdditiveTotal").html() + ' Gal'],
                            ['Sand', $("#sealcoatSandTotal").html() + ' Lb', $("#sealcoatSandTotalGal").html() + ' Gal'],
                            ['Total Project Gal', $("#sealcoatTotal").html() + ' Gal']
                        )
                    }
                }
            }
        };
        $.printCalc(settings);
        return false;
    });
});
</script>