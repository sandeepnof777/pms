<h1 class="centered">Crack Sealer Calculator</h1>
<div class="clearfix">
    <div class="half left">
        <div class="content-box left half black">
            <div class="box-header centered">Job Criteria</div>
            <div class="box-content">
                <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td>
                            <label>Crack Length (Ft)</label>
                            <input type="text" name="crackseakLength" id="crackseakLength" size="5" value="0" class="numberFormat">
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <label>Product</label>
                            <select name="cracksealProduct" id="cracksealProduct" class="select-big">
                                <option value="1">AcrylaSeal</option>
                                <option value="2">PLS</option>
                                <option value="3">Spec+Plus</option>
                                <option value="4">Thermoflex</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Typical Crack Width</label>
                            <span class="cwidth1_container">
                            <select class="cwidth cwidth1">
                                <option value="8" selected="selected">1/8"</option>
                                <option value="4">1/4"</option>
                                <option value="2">1/2"</option>
                            </select>
                            </span>
                            <span class="cwidth2_container">
                            <select class="cwidth cwidth2">
                                <option value="4" selected="selected">1/4"</option>
                                <option value="2">1/2"</option>
                                <option value="1.5">3/4"</option>
                                <option value="1">1"</option>
                            </select>
                            </span>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <label>Typical Crack Depth</label>
                            <span class="cdepth1_container">
                            <select class="cdepth cdepth1">
                                <option value="8" selected="selected">1/8"</option>
                                <option value="4">1/4"</option>
                                <option value="2">1/2"</option>
                            </select>
                            </span>
                            <span class="cdepth2_container">
                            <select class="cdepth cdepth2">
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
                            <label>Product Cost</label>
                            <input type="text" name="crackseakCost" id="crackseakCost" size="5" value="0" class="numberFormat">
                            <span>$ per <span id="cracksealUnit"></span></span>
                            </p>
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
                    <tr>
                        <td width="150">
                            <label>Total Sealant</label>
                        </td>
                        <td>
                            <span id="cracksealTotalMaterial"></span> <span id="cracksealUnit2"></span>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <label>Total Sealant Cost</label>
                        </td>
                        <td>
                            $<span id="cracksealTotalPrice"></span>
                        </td>
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
                            <input type="button" value="Print" class="print">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /***************************
         * Crack Sealing Calculator *
         ****************************/
        var cracksealFields = "#crackseakLength, #cracksealWidth, #cracksealDepth, #cracksealProduct, #cracksealPackage, #crackseakCost";
        $(cracksealFields).live('change keyup', function () {
            cracksealCalculator();
        });
        var requestAuth;

        function cracksealCalculator() {
            if ($("#cracksealProduct").val() == 1) {
                $("#cracksealUnit, #cracksealUnit2").html('Gal');
                $(".cwidth").removeAttr('id');
                $(".cwidth1").attr("id", 'cracksealWidth');
                $(".cdepth").removeAttr('id');
                $(".cdepth1").attr("id", 'cracksealDepth');
                $(".cwidth1_container").show();
                $(".cwidth2_container").hide();
                $(".cdepth1_container").show();
                $(".cdepth2_container").hide();
            } else {
                $("#cracksealUnit, #cracksealUnit2").html('Lbs');
                $(".cwidth").removeAttr('id').hide();
                $(".cwidth2").attr("id", 'cracksealWidth').show();
                $(".cdepth").removeAttr('id').hide();
                $(".cdepth2").attr("id", 'cracksealDepth').show();
                $(".cwidth2_container").show();
                $(".cwidth1_container").hide();
                $(".cdepth2_container").show();
                $(".cdepth1_container").hide();
            }
            requestAuth = Math.floor((Math.random() * 1000) + 1);
            var request = $.ajax({
                url: "<?php echo site_url('ajax/ajaxCalculators') ?>",
                type: "POST",
                data: {
                    "action": "calculator_crackseal",
                    "product": $("#cracksealProduct").val(),
                    "width": $("#cracksealWidth").val(),
                    "depth": $("#cracksealDepth").val(),
                    "length": $("#crackseakLength").val(),
                    "price": $("#crackseakCost").val(),
                    "requestAuth": requestAuth
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        if (data.requestAuth == requestAuth) {
                            $("#cracksealTotalMaterial").html(addCommas(data.material.toFixed(2)));
                            $("#cracksealTotalPrice").html(addCommas(data.cost.toFixed(2)));
                        }
                    } else {
                        alert('error handling request');
                    }
                }
            });
        }

        cracksealCalculator();
        $(".print").click(function () {
            var productNames = new Array();
            productNames[1] = 'AcrylaSeal';
            productNames[2] = 'PLS';
            productNames[3] = 'Spec+Plus';
            productNames[4] = 'Thermoflex';
            var productName = productNames[$("#cracksealProduct").val()];
            var settings = {
                "title": "Crack Sealing Job Cost Sheet",
                "project_name": $("#sealcoatProjectName").val(),
                "boxes": {
                    left: {
                        0: {
                            "heading": "Project Specifications",
                            data: new Array(
                                ['Crack Length', $("#crackseakLength").val()],
                                ['Product', productName],
                                ['Crack Width', $("#cracksealWidth").val()],
                                ['Crack Depth', $("#cracksealDepth").val()],
                                ['Product Cost', $("#crackseakCost").val()]
                            )
                        }
                    },
                    right: {
                        0: {
                            "heading": "Total Material Requirements",
                            data: new Array(
                                ['Total Sealant', $("#cracksealTotalMaterial").html() + ' ' + $("#cracksealUnit2").html()],
                                ['Total Sealant Cost', '$' + $("#cracksealTotalPrice").html()]
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