<form action="<?php echo site_url('account/company_proposal_intro') ?>" method="post" class="form-validated">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
        <tr class="even">
            <td>
                <div class="clearfix">
                    <textarea tabindex="30" name="companyIntro" class="trackChanges" id="companyIntro" cols="30"
                              rows="20"
                              style="width: 100%; clear: right;"><?php echo $company->getCompanyIntro() ?></textarea>
                </div>
                <p class="clearfix" id="wordCountText"><br>
                    <strong><span id="numWordsRemaining"><?= COMPANY_INTRO_WORD_LIMIT; ?></span></strong> words remaining
                </p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <input type="submit" class="btn blue" name="save" value="Save"/>
            </td>
        </tr>
        </tbody>
    </table>
</form>

<script type="text/javascript">
    var wordLimit = <?= COMPANY_INTRO_WORD_LIMIT; ?>;

    $(document).ready(function () {
        //CKEDITOR.replace('aboutCompany');
        tinymce.init({
            selector: "textarea#companyIntro",
            menubar: false,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            browser_spellcheck: true,
            contextmenu: false,
            paste_as_text: true,
            height: '320',
            elementpath: false,
            plugins: "link image code lists paste preview wordcount",
            toolbar: tinyMceMenus.email,
            forced_root_block_attrs: tinyMceMenus.root_attrs,
            font_formats: 'Arial=arial,sans-serif;' +
                'Helvetica=helvetica;' +
                'Times New Roman=times new roman,times;' +
                'Verdana=verdana,geneva;',
            fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px",
            setup: function(editor) {
                editor.on('init', function() {
                    var numWords = editor.plugins.wordcount.body.getWordCount();
                    //var numChars = editor.plugins.wordcount.body.getCharacterCount();
                    var wordsRemaining = (wordLimit - numWords);
                    $("#numWordsRemaining").text(wordsRemaining);

                    if (wordsRemaining < 25) {
                        $("#wordCountText").css('color', "red");
                    } else {
                        $("#wordCountText").css('color', "000000");
                    }
                });

                editor.on('keyup', function () {
                    var numWords = editor.plugins.wordcount.body.getWordCount();
                    //var numChars = editor.plugins.wordcount.body.getCharacterCount();
                    var wordsRemaining = (wordLimit - numWords);

                    $("#numWordsRemaining").text(wordsRemaining);

                    if (wordsRemaining < 25) {
                        $("#wordCountText").css('color', "red");
                    } else {
                        $("#wordCountText").css('color', "000000");
                    }

                    if (numWords > wordLimit) {
                        swal("You have reached the word limit for your <strong>About Us</strong> section!");
                        return false;
                    }

                });

            }
        });
    });
</script>