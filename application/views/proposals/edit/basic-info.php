<div class="content-box">
    <div class="box-header">
        Update Project Info &nbsp; &nbsp; &nbsp;
        <a href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/items') ?>"
           class="box-action tiptip" title="Build your proposal">Back</a>
    </div>
    <div class="box-content">
        <?php
        echo form_open('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4), array('class' => ''));
        ?>
        <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
            <tr class="even">
                <td>
                    <p class="clearfix">
                        <label>Job #</label>
                        <input class="text" type="text" name="jobNumber" id="jobNumber"
                               value="<?php echo $proposal->getJobNumber() ?>" style="width: 100px;">
                        <label style="width: 165px;">* Leave blank not to display</label>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Proposal Title</label>
                        <input class="text" type="text" name="proposalTitle" id="proposalTitle"
                               value="<?php echo $proposal->getProposalTitle() ?>">
                        <a class="btn" href="#" id="titleChoices">View Choices</a>
                    </p>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <p class="clearfix">
                        <label>Project Name</label>
                        <input class="text" type="text" name="projectName" id="projectName"
                               value="<?php echo $proposal->getProjectName() ?>">
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix" id="textarea_validator" style="position: relative;">
                        <label for="projectAddress">Project Address</label>
                        <input type="text" class="text" name="projectAddress" id="projectAddress"
                               value="<?php echo $proposal->getProjectAddress() ?>"/>
                        <span class="message info"
                              style="position: absolute; right: 70px; top: -2px; width: 300px; padding-top: 14px;"><b>VIP:</b> Please enter Project Address here so that your Work Order Driving Directions will be ACCURATE.</span>
                    </p>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <p class="clearfix">
                        <label for="projectAddress">City</label>
                        <input type="text" class="text" name="projectCity" id="projectCity"
                               value="<?php echo $proposal->getProjectCity() ?>" style="width: 130px;"/>
                        <label for="projectAddress" style="width: 40px;">State</label>
                        <input type="text" class="text" name="projectState" id="projectState"
                               value="<?php echo $proposal->getProjectState() ?>" style="width: 80px;"/>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label for="projectAddress">Zip</label>
                        <input type="text" class="text" name="projectZip" id="projectZip"
                               value="<?php echo $proposal->getProjectZip() ?>" style="width: 50px;"/>
                    </p>
                </td>
            </tr>
            <tr class="">
                <td>
                    <p class="clearfix">
                        <label>&nbsp;</label>
                        <input class="btn update-button" type="submit" value="Update">
                    </p>
                </td>
            </tr>
        </table>
        <?php
        echo form_close();
        ?>
    </div>
    <div id="choices" title="Choices">
        <p class="clearfix"><span id="choice-8">Line Striping Proposal</span> <a class="btn choice" href="#"
                                                                                 rel="#choice-8">Select</a></p>

        <p class="clearfix"><span id="choice-1">Pavement Maintenance Proposal</span> <a class="btn choice"
                                                                                        href="#"
                                                                                        rel="#choice-1">Select</a>
        </p>

        <p class="clearfix"><span id="choice-2">Pavement Maintenance Plan</span> <a class="btn choice" href="#"
                                                                                    rel="#choice-2">Select</a>
        </p>

        <p class="clearfix"><span id="choice-5">Pavement Maintenance & Beautification Proposal</span> <a
                class="btn choice" href="#" rel="#choice-5">Select</a></p>

        <p class="clearfix"><span id="choice-6">Parking Lot Sweeping</span> <a class="btn choice" href="#"
                                                                               rel="#choice-6">Select</a></p>

        <p class="clearfix"><span id="choice-4">Pavement Repair Plan</span> <a class="btn choice" href="#"
                                                                               rel="#choice-4">Select</a></p>

        <p class="clearfix"><span id="choice-7">Property Drainage Proposal</span> <a class="btn choice" href="#"
                                                                                     rel="#choice-7">Select</a>
        </p>

        <p class="clearfix"><span id="choice-3">Your Parking Lot Proposal</span> <a class="btn choice" href="#"
                                                                                    rel="#choice-3">Select</a>
        </p>
    </div>
</div>