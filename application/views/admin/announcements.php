<?php $this->load->view('global/header-admin'); ?>
<style>
#cke_ann_content .cke_reset_all
{
    display:none;
}
#cke_ann_content{
    border: 0px;
}
#preview_popup .tox-tinymce{
    border: 0px;   
}
#preview_popup .tox-statusbar{
    display:none;
}
</style>
    <div id="content" class="clearfix">
    <div class="widthfix">

        <?php
        if (count($announcements)) {
        ?>
            <div class="content-box">

                <div class="box-header">
                    Active Announcements
                </div>

                <div class="box-content">

                    <table class="boxed-table" width="100%">
                        <thead>
                        <tr>
                            <td></td>
                            <td>Title</td>
                            <td>Admin</td>
                            <td>Sticky</td>
                            <td>Release</td>
                            <td>Expires</td>
                            <td>Actions</td>
                        </tr>
                        </thead>
                        <tbody id="sortableAnnouncements">
                        <?php foreach ($announcements as $ann) {
                            /* @var $ann \models\Announcement */
                            ?>
                            <tr id="announcement_<?php echo $ann->getId(); ?>">
                                <td class="text-center sortableHandle"><a href=""><i class="fa fa-fw fa-unsorted"></i> </a></td>
                                <td><?php echo $ann->getTitle(); ?></td>
                                <td class="text-center"><i
                                            class="fa fa-fw fa-<?php echo $ann->getAdmin() ? 'check' : 'close'; ?>"></i>
                                </td>
                                <td class="text-center"><i
                                            class="fa fa-fw fa-<?php echo $ann->getSticky() ? 'check' : 'close'; ?>"></i>
                                </td>
                                <td><?php echo $ann->getReleased()->format('m/d/Y'); ?></td>
                                <td><?php echo $ann->getExpires()->format('m/d/Y'); ?></td>
                                <td data-title="<?php echo $ann->getTitle(); ?>"
                                    data-content="<?php echo htmlspecialchars($ann->getText()); ?>"
                                    data-id="<?php echo $ann->getId() ?>"
                                    data-admin="<?php echo $ann->getAdmin() ? 1 : 0 ?>"
                                    data-sticky="<?php echo $ann->getSticky() ? 1 : 0 ?>"
                                    data-release="<?php echo $ann->getReleased()->format('m/d/Y'); ?>"
                                    data-expires="<?php echo $ann->getExpires()->format('m/d/Y'); ?>">
                                    <a href="#" class="preview">Preview</a> /
                                    <a href="#" class="editAnnouncement">Edit</a> /
                                    <a href="#" class="deleteAnnouncement">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>

            </div>
            <br/><br/>

        <?php
        }
        ?>

        <?php
        if (count($expiredAnnouncements)) {
        ?>
        <div class="content-box">


            <div class="box-header">
                Expired Announcements
            </div>

            <div class="box-content">

                <table class="boxed-table" width="100%">
                    <thead>
                    <tr>
                        <td>Title</td>
                        <td>Admin</td>
                        <td>Sticky</td>
                        <td>Release</td>
                        <td>Expires</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($expiredAnnouncements as $ann) {
                        /* @var $ann \models\Announcement */
                        ?>
                        <tr>
                            <td><?php echo $ann->getTitle(); ?></td>
                            <td class="text-center"><i
                                        class="fa fa-fw fa-<?php echo $ann->getAdmin() ? 'check' : 'close'; ?>"></i>
                            </td>
                            <td class="text-center"><i
                                        class="fa fa-fw fa-<?php echo $ann->getSticky() ? 'check' : 'close'; ?>"></i>
                            </td>
                            <td><?php echo $ann->getReleased()->format('m/d/Y'); ?></td>
                            <td><?php echo $ann->getExpires()->format('m/d/Y'); ?></td>
                            <td data-title="<?php echo $ann->getTitle(); ?>"
                                data-content="<?php echo htmlspecialchars($ann->getText()); ?>"
                                data-id="<?php echo $ann->getId() ?>"
                                data-admin="<?php echo $ann->getAdmin() ? 1 : 0 ?>"
                                data-sticky="<?php echo $ann->getSticky() ? 1 : 0 ?>"
                                data-release="<?php echo $ann->getReleased()->format('m/d/Y'); ?>"
                                data-expires="<?php echo $ann->getExpires()->format('m/d/Y'); ?>">
                                <a href="#" class="preview">Preview</a> /
                                <a href="#" class="editAnnouncement">Edit</a> /
                                <a href="#" class="deleteAnnouncement">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>

        </div>
        <br/><br/>
        <?php
        }
        ?>


        <div class="content-box">

            <div class="box-header">
                Announcement Form
            </div>

            <div class="box-content">

                <form method="post">
                    <input type="hidden" name="announcementId" id="announcementId"/>
                    <table class="boxed-table" style="    width: 100%;">
                        <tr>
                            <td>
                                <label>Title</label>
                            </td>
                            <td>
                                <input type="text" class="text" id="title" name="title" placeholder="Title"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Text</label>
                            </td>
                            <td>
                                <textarea id="announceText" name="announceText" style="width:100%"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Admins Only</label>
                            </td>
                            <td>
                                <input type="checkbox" id="admin" name="admin"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Sticky</label>
                            </td>
                            <td>
                                <input type="checkbox" id="sticky" name="sticky"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Release</label>
                            </td>
                            <td>
                                <input type="text" class="text narrow" id="release" name="release"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Expires</label>
                            </td>
                            <td>
                                <input type="text" class="text narrow" id="expires" name="expires"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <button class="btn update-button saveIcon" name="saveAnnouncement" value="1">Save
                                    Announcement
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
 
    <script type="application/javascript">

        $(document).ready(function () {

            $("#sortableAnnouncements").sortable({
                handle: ".sortableHandle",
                helper: 'clone',
                stop: function () {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('admin/updateAnnouncementsOrder') ?>",
                        data: $(this).sortable("serialize"),
                        async: false
                    });
                }
            });

            // Editor
           
            // var editor = CKEDITOR.replace( 'announceText',{
            //                 toolbar: [
            //                     { name: 'styles', items: [ 'Font', 'FontSize' ] },
            //                     { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            //                     { name: 'editing', groups: ['spellchecker' ], items: [ 'Scayt' ] },
            //                     { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline','-', 'RemoveFormat' ] },
            //                     { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
            //                     { name: 'links', items: [ 'Link', 'Unlink' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
            //                     [ 'Cut', 'Copy', 'Paste', 'PasteText', ],			// Defines toolbar group without name.
            //                     '/',																					// Line break - next group will be placed in new line.
            //                 ],
            //                 height: 100,
            //                 width: 705
            //             }, );
            
                tinymce.init({
                        selector: "textarea#announceText",
                        menubar: false,
                        elementpath: false,
                        relative_urls : false,
                        remove_script_host : false,
                        convert_urls : true,
                        browser_spellcheck : true,
                        contextmenu :false,
                        paste_as_text: true,
                        height:'200',
                        plugins: "link image code lists paste preview ",
                        toolbar: tinyMceMenus.email,
                        forced_root_block_attrs: tinyMceMenus.root_attrs,
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });
            // Datepickers
            $("#release, #expires").datepicker();

            // Preview functionality
            $(".preview").click(function () {
                var parent = $(this).parent('td');
                var title = '<i class="fa fa-fw fa-bullhorn"></i> ' + parent.data('title');
                var content = '<textarea id="ann_content">'+parent.data('content')+'</textarea>';

                swal({
                    title: title,
                    html: content,
                    onOpen:function() { 
                        
                        //CKEDITOR.replace( 'ann_content',{removePlugins: 'elementspath',readOnly:true,height:'auto'} );
                        tinymce.init({selector: "textarea#ann_content",elementpath: false, relative_urls : false,remove_script_host : false,convert_urls : true,menubar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true})
                        $('.swal2-modal').attr('id','preview_popup')
                    }
                });
                return false;
            });

            // Edit functionality
            $(".editAnnouncement").click(function () {
                var parent = $(this).parent('td');
                var id = parent.data('id');
                var title = parent.data('title');
                var content = parent.data('content');
                var admin = parent.data('admin') == 1;
                var sticky = parent.data('sticky') == 1;
                var release = parent.data('release');
                var expires = parent.data('expires');

                // Fill in the form
                $("#announcementId").val(id);
                $("#title").val(title);
                //CKEDITOR.instances.announceText.setData(content);
                tinymce.get("announceText").setContent(content);
                $("#admin").attr('checked', admin);
                $("#sticky").attr('checked', sticky);
                $("#release").val(release);
                $("#expires").val(expires);

                // Refresh checkboxes
                $.uniform.update();
            });

            // Delete Functionality
            $(".deleteAnnouncement").click(function () {
                var parent = $(this).parent('td');
                var id = parent.data('id');

                swal({
                    title: 'Delete Announcement',
                    text: "Are you sure?",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    window.location.href = '/admin/deleteAnnouncement/' + id;
             })
                return false;
            });
        });

    </script>

<?php $this->load->view('global/footer'); ?>