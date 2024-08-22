<div id="mapInfoSlider" class="materialize">
    <form style="display: none";>
    <!-- <input type="checkbox" id="mapInfoCheck" class="groupSelect" data-proposal-id="" /> -->
    </form>
    <div id="mapInfoSliderContent">
        <div class="card-panel nativeColorBg" id="infoHeading">
            <div id="mapInfoClose">
                <a href="#" id="mapInfoSliderClose" style="color: #fff;">
                    <i class="fa fa-fw fa-arrow-left"></i>
                </a>
            </div>
            <h3>
                Proposal Info
                <span style="width: 30px; float: right;">
                    <a href="#" id="mapSendProposal" data-proposal-id="" class="tiptip" title="Send Proposal">
                        <i class="fa fa-fw fa-envelope"></i>
                    </a>
                </span>
                <span style="width: 30px; float: right;">
                    <a href="#" id="mapPreviewProposal" data-proposal-id="" class="tiptip" title="Preview Proposal">
                        <i class="fa fa-fw fa-file-text-o"></i>
                    </a>
                </span>
            </h3>
        </div>

        <div class="row" id="infoLoading">
            <div class="col s12">
                <p class="text-center" style="margin-top: 10px;">
                    Loading data...
                </p>
            </div>
        </div>

        <div id="proposalData">
        <div class="row">
            <div class="col s12">
                <div class="mapInfoHeading">
                    <i class="fa fa-fw fa-building"></i> Account
                </div>
                <div class="mapInfoDetail">
                    <span id="accountName"></span>
                </div>
                <div class="mapInfoDetail">
                    <span id="projectName" style="font-weight: bold"></span>
                </div>
                <div class="mapInfoDetail">
                    <span id="projectAddress"></span>
                </div>
                <div class="mapInfoDetail" style="width: 100%">
                    <table style="width: 100%">
                        <tr>
                            <td class="mapInfoHeading">Total:</td>
                            <td style="text-align: right;" >$<span id="proposalPrice"></span></td>
                        </tr>
                        <tr>
                            <td class="mapInfoHeading">Status</td>
                            <td class="statusHighlight">
                                <span id="proposalStatus"></span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row" id="proposalMapContactInfo">
            <div class="col s12">
                <div class="mapInfoHeading">
                    <i class="fa fa-fw fa-address-card"></i> Contact
                </div>
                <div class="mapInfoDetail" style="width: 100%">
                    <table style="width: 100%">
                        <tr>
                            <td>Name:</td>
                            <td><span id="contactName"></span></td>
                        </tr>
                        <tr>
                            <td>Title:</td>
                            <td><span id="contactTitle"></span></td>
                        </tr>
                        <tr>
                            <td>Office Phone:</td>
                            <td><a id="contactOfficePhone"></a></td>
                        </tr>
                        <tr>
                            <td>Cell Phone:</td>
                            <td><a id="contactCellPhone"></a></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><a id="contactEmail"></a></td>
                        </tr>
                        <tr>
                            <td class="mapInfoHeading">Owner:</td>
                            <td><span id="proposalOwner"></span></td>
                        </tr>
                        <tr>
                            <td class="mapInfoHeading">Created:</td>
                            <td><span id="proposalDate"></span></td>
                        </tr>
                            <td class="mapInfoHeading">Last Activity:</td>
                            <td>
                                <a href="#" data-proposal-id="" id="mapLastActivityLink" class="lastActivityLink"
                                    data-project-name="">
                                    <span id="proposalLastActivity"></span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div class="mapInfoHeading">
                    <i class="fa fa-fw fa-list"></i> Services
                </div>
                <div class="mapInfoDetail" style="width: 100%">
                    <table id="proposalServicesTable" style="width: 100%" class="striped">
                    </table>
                </div>
            </div>
        </div>

        <div class="row" id="proposalOptionalServices">
            <div class="col s12">
                <div class="mapInfoHeading">
                    <i class="fa fa-fw fa-list"></i> Optional Services
                </div>
                <div class="mapInfoDetail" style="width: 100%">
                    <table id="proposalOptionalServicesTable" style="width: 100%" class="striped">
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div class="mapInfoHeading">
                    <i class="fa fa-fw fa-sticky-note-o"></i> Notes
                </div>
                <table id="mapInfoNotes" class="striped">
                </table>
            </div>
        </div>

        <div class="clearfix"></div>

    </div>
    </div>

</div>