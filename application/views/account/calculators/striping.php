<h1 class="centered">Striping Calculator</h1>
<div class="half left">
    <div class="content-box left half black">
        <div class="box-header centered">Job Criteria</div>
        <div class="box-content">
            <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td>
                        <label>Total Lineal Ft</label>
                        <input type="text" name="stripingFeet" id="stripingFeet" value="0" size="5" class="numberFormat">
                    </td>
                </tr>
                <tr class="even">
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
                <tr class="even">
                    <td>
                        <label>Cost Per Pail. (US$)</label>
                        <input type="text" name="stripingPailCost" id="stripingPailCost" value="0" size="5" class="numberFormat">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="half right">
    <div class="content-box right half blue">
        <div class="box-header centered">Job Material Requirements</div>
        <div class="box-content">
            <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr class="even">
                    <td colspan="2">
                        <p class="clearfix">
                            *(material usage based on striping applied 4" wide @ 15 mils).
                        </p>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <label>Material Total</label>
                    </td>
                    <td>
                        <span id="stripingMaterialTotal"></span> Gallons
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Total QTY.</label>
                    </td>
                    <td>
                        <span id="stripingTotalQty"></span> Gallon Units
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Total material Cost.</label>
                    </td>
                    <td>
                        $<span id="stripingTotalMaterialCost"></span>
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Material Base Cost.</label>
                    </td>
                    <td>
                        $<span id="stripingMaterialBaseCost"></span> / Gallon
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /*******************************
         * Pavement Striping Calculator *
         ********************************/
        var stripingFields = "#stripingFeet, #stripingPailSize, #stripingPailColor, #stripingPailCost";
        $(stripingFields).live('change keyup', function () {
            stripingPaintRender();
        });
        var requestAuth;

        function stripingPaintRender() {
            var materialTotal = $("#stripingFeet").val() / $("#stripingPailColor").val();
//                $("#stripingMaterialTotal").html(materialTotal.toFixed(2));
            var totalQty = materialTotal / $("#stripingPailSize").val();
//                $("#stripingTotalQty").html(totalQty.toFixed(2));
            var materialTotalCost = totalQty * $("#stripingPailCost").val();
//                $("#stripingTotalMaterialCost").html(materialTotalCost.toFixed(2));
            var materialBaseCost = materialTotalCost / materialTotal;
//                $("#stripingMaterialBaseCost").html(materialBaseCost.toFixed(2));

            requestAuth = Math.floor((Math.random() * 1000) + 1);
            var request = $.ajax({
                url: "<?php echo site_url('ajax/ajaxCalculators') ?>",
                type: "POST",
                data: {
                    "action": "calculator_striping",
                    "length": $("#stripingFeet").val(),
                    "pail_size": $("#stripingPailSize").val(),
                    "color": $("#stripingPailColor").val(),
                    "pail_price": $("#stripingPailCost").val(),
                    "requestAuth": requestAuth
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        if (data.requestAuth == requestAuth) {
                            $("#stripingMaterialTotal").html(addCommas(data.totalMaterial.toFixed(2)));
                            $("#stripingTotalQty").html(addCommas(data.totalQty.toFixed(2)));
                            $("#stripingTotalMaterialCost").html(addCommas(data.cost.toFixed(2)));
                            $("#stripingMaterialBaseCost").html(addCommas(data.baseCost.toFixed(2)));
                        }
                    } else {
                        alert('error handling request');
                    }
                }
            });

        }

        stripingPaintRender();
    });
</script>