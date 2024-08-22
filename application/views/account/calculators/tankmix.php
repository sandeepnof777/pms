<h1 class="centered">Tank Mix Design Calculator</h1>
<div class="half left">
    <div class="content-box left half black">
        <div class="box-header centered">Job Criteria</div>
        <div class="box-content">
            <table class="boxed-table" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                <tr>
                    <td>
                        <label>Tank Size</label>
                        <input type="text" name="tankmixSize" id="tankmixSize" value="0" size="5">
                        <span>Gal</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Product</label>
                        <select name="tankmixProduct" id="tankmixProduct" class="select-big">
                            <option value="tarconite">Tarconite</option>
                            <option value="jennite">Jennite</option>
                            <option value="jenniteae">Jennite AE</option>
                            <option value="paveshield">Paveshield</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Additive</label>

                        <div id="tankmix_additives">
                            <span class="additive_tarconite_container">
                            <select class="additive additive_tarconite select-big" name="tankmixAdditive">
                                <option value="none">None</option>
                                <option value="armorflex2">Armorflex 2%</option>
                                <option value="armorflex3">Armorflex 3%</option>
                                <option value="qsa2">QSA 2%</option>
                                <option value="qsa3">QSA 3%</option>
                            </select>
                            </span>
                            <span class="additive_jennite_container">
                            <select class="additive additive_jennite select-big" name="tankmixAdditive">
                                <option value="none">None</option>
                                <option value="qsa2">QSA 2%</option>
                            </select>
                            </span>
                            <span class="additive_jenniteae_container">
                            <select class="additive additive_jenniteae select-big" name="tankmixAdditive">
                                <option value="none">None</option>
                            </select>
                            </span>
                            <span class="additive_paveshield_container">
                            <select class="additive additive_paveshield select-big" name="tankmixAdditive">
                                <option value="none">None</option>
                                <option value="maxum2">Maxum 2%</option>
                                <option value="maxum3">Maxum 3%</option>
                            </select>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Water</label>

                        <div id="tankmix_water">
                            <span class="water_tarconite_none_container water_tarconite_qsa2_container water_tarconite_qsa3_container">
                            <select class="water  water_tarconite_none water_tarconite_qsa2 water_tarconite_qsa3" name="water">
                                <option value="30">30%</option>
                                <option value="35">35%</option>
                            </select>
                            </span>
                            <span class="water_tarconite_armorflex2_container">
                            <select class="water water_tarconite_armorflex2" name="water">
                                <option value="40">40%</option>
                            </select>
                            </span>
                            <span class="water_tarconite_armorflex3_container">
                            <select class="water  water_tarconite_armorflex3" name="water">
                                <option value="45">45%</option>
                            </select>
                            </span>
                            <span class="water_jennite_none_container water_jennite_qsa2_container water_jenniteae_none_container">
                            <select class="water water_jennite_none water_jennite_qsa2 water_jenniteae_none" name="water">
                                <option value="0">0%</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                                <option value="15">15%</option>
                            </select>
                            </span>
                            <span class="water_paveshield_none_container">
                            <select class="water water_paveshield_none" name="water">
                                <option value="25">25%</option>
                            </select>
                            </span>
                            <span class="water_paveshield_maxum2_container water_paveshield_maxum3_container">
                            <select class="water  water_paveshield_maxum2 water_paveshield_maxum3" name="water">
                                <option value="30">30%</option>
                            </select>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Sand/Gal</label>

                        <div id="tankmix_sand">
                            <span class="sand_tarconite_none_container sand_tarconite_qsa2_container sand_tarconite_qsa3_container">
                            <select class="sand sand_tarconite_none sand_tarconite_qsa2 sand_tarconite_qsa3" name="water">
                                <option value="2">2 Lb</option>
                                <option value="3">3 Lb</option>
                                <option value="4">4 Lb</option>
                                <option value="5">5 Lb</option>
                            </select>
                            </span>
                            <span class="sand_tarconite_armorflex2_container sand_tarconite_armorflex3_container">
                            <select class="sand sand_tarconite_armorflex2 sand_tarconite_armorflex3" name="water">
                                <option value="2">2 Lb</option>
                                <option value="3">3 Lb</option>
                                <option value="4">4 Lb</option>
                                <option value="5">5 Lb</option>
                                <option value="6">6 Lb</option>
                            </select>
                            </span>
                            <span class="sand_jennite_none_container sand_jennite_qsa2_container sand_jenniteae_none_container sand_paveshield_none_container sand_paveshield_maxum2_container sand_paveshield_maxum3_container">
                            <select class="sand sand_jennite_none sand_jennite_qsa2 sand_jenniteae_none sand_paveshield_none sand_paveshield_maxum2 sand_paveshield_maxum3" name="water">
                                <option value="3">3 Lb</option>
                                <option value="4">4 Lb</option>
                                <option value="5">5 Lb</option>
                            </select>
                            </span>
                        </div>
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
                        <label>Tank Product</label>
                    </td>
                    <td>
                        <span id="tankmixTankProduct"></span> Gal
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Additive</label>
                    </td>
                    <td>
                        <span id="tankmixTankAdditive"></span> Gal
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Water</label>
                    </td>
                    <td>
                        <span id="tankmixTankWater"></span> Gal
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Sand</label>
                    </td>
                    <td>
                        <span id="tankmixTankSand"></span> Lb</strong> (<span id="tankmixTankSandGal"></span> Gal)
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Total Project Gal</label>
                    </td>
                    <td>
                        <span id="tankmixTankTotal"></span> Gal
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /****************************
         * Tank Mix Design Calculator *
         ******************************/
        var tankmixulatorFields = "#tankmixProduct, #tankmixSize, #tankmixMeasurement, #tankmixAdditive, #tankmixWater, #tankmixSand";
        $(tankmixulatorFields).live('change keyup', function () {
            tankmixulator();
        });
        var requestAuth;

        function tankmixulator() {
            $("#tankmix_additives .additive").removeAttr('id');
            $("#tankmix_additives > span").hide();
            var additiveClass = '#tankmix_additives .additive_' + $("#tankmixProduct").val();
            $(additiveClass + '_container').show();
            $(additiveClass).attr('id', 'tankmixAdditive');

            $("#tankmix_water .water").removeAttr('id');
            $("#tankmix_water > span").hide();
            var waterClass = '#tankmix_water .water_' + $("#tankmixProduct").val() + '_' + $("#tankmixAdditive").val();
            $(waterClass + '_container').show();
            $(waterClass).attr('id', 'tankmixWater');

            $("#tankmix_sand .sand").removeAttr('id');
            $("#tankmix_sand > span").hide();
            var sandClass = '#tankmix_sand .sand_' + $("#tankmixProduct").val() + '_' + $("#tankmixAdditive").val();
            $(sandClass + '_container').show();
            $(sandClass).attr('id', 'tankmixSand');
            requestAuth = Math.floor((Math.random() * 1000) + 1);
            var request = $.ajax({
                url: "<?php echo site_url('ajax/ajaxCalculators') ?>",
                type: "POST",
                data: {
                    "action": "calculator_tankmix",
                    "additive": $("#tankmixAdditive").val(),
                    "water": $("#tankmixWater").val(),
                    "sand": $("#tankmixSand").val(),
                    "tankSize": $("#tankmixSize").val(),
                    "requestAuth": requestAuth
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        if (data.requestAuth == requestAuth) {
                            $("#tankmixTankProduct").html(data.tankProduct.toFixed(2));
                            $("#tankmixTankAdditive").html(data.tankAdditive.toFixed(2));
                            $("#tankmixTankWater").html(data.tankWater.toFixed(2));
                            $("#tankmixTankSand").html(data.sandLb.toFixed(2));
                            $("#tankmixTankSandGal").html(data.sandGal.toFixed(2));
                            $("#tankmixTankTotal").html(data.totalProjectGallons.toFixed(2));
                        }
                    } else {
                        alert('error handling request');
                    }
                }
            });
        }

        tankmixulator();
    });
</script>