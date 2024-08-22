<?php $this->load->view('global/header'); ?>
    <div id="content" class="clearfix">
        <div class="dropdownButton">
            <a class="dropdownToggle" href="#">Action</a>
            <ul class="dropdownMenu">
                <li><a href="#link1"><img src="/3rdparty/icons/email_go.png">Link 1</a></li>
                <li><a href="#link2">Link 2</a></li>
                <li><a href="#link3">Link 3</a>
                    <ul>
                        <li><a href="#submenu1">Submenu 1</a></li>
                        <li><a href="#submenu2">Submenu 2</a></li>
                        <li><a href="#submenu3">Submenu 3</a></li>
                        <li><a href="#submenu4">Submenu 4</a></li>
                    </ul>
                </li>
                <li><a href="#link4">Link 4</a></li>
            </ul>
        </div>
        <div class="dropdownButton">
            <a class="dropdownToggle" href="#">Etcetera</a>
            <ul class="dropdownMenu">
                <li><a href="#link1">Link 1</a></li>
                <li><a href="#link2">Link 2</a></li>
                <li><a href="#link3">Link 3</a></li>
                <li><a href="#link4">Link 4</a></li>
            </ul>
        </div>
        <div class="dropdownButton">
            <a class="dropdownToggle" href="#">Info</a>
            <ul class="dropdownMenu">
                <li><a href="#link1">Link 1</a></li>
                <li><a href="#link2">Link 2</a></li>
                <li><a href="#link3">Link 3</a></li>
                <li><a href="#link4">Link 4</a></li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            function toggleButton(button) {
                var container = button.parent();
                var menu = container.find('ul:first');
                if (button.hasClass('open')) {
                    button.removeClass('open');
                    $(".dropdownButton > ul").hide();
                } else {
                    closeButtons();
                    button.addClass('open');
                    menu.show();
                }
            }

            function closeButtons() {
                $(".dropdownButton ul.dropdownMenu").hide();
                $(".dropdownToggle.open").removeClass('open');
            }

            $(".dropdownToggle").live('click', function () {
                toggleButton($(this));
                return false;
            });
            $(".dropdownButton").live('click', function (e) {
                e.stopPropagation();
            });
            $(document).click(function () {
                closeButtons();
            });
            //ipad crap
            $(document).on('touchstart', function (event) {
                if (!$(event.target).closest('.dropdownButton').length) {
                    closeButtons();
                }
            });


        });
    </script>
<?php $this->load->view('global/footer'); ?>