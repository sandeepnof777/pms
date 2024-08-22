<?php $this->load->view('global/header') ?>
<div id="content" class="clearfix">
    <div class="widthfix">

        <div class="content-box">
            <div class="box-header">
                Frequently Asked Questions
            </div>
            <div class="box-content clearfix" style="background: #fafafa;">
                <div class="clearfix" style="padding-bottom: 10px;">
                    <div id="faq-left">
                        <div class="faq-categories-header">FAQ Categories</div>
                        <ul class="faq-selector">
                            <!--<li class="active"><a href="#" rel="0">All Questions <span class="icon"></span></a></li>-->
                            <?php
                            $first = true;
                            foreach ($categories->result() as $category) {
                                
                                ?>
                                <li class="<?php echo $first ? 'active' : '' ?> faq-question-list-item" data-category="<?php echo $category->id; ?>">
                                    <a href="#" rel="<?php echo $category->id ?>">
                                        <?php echo $category->name ?> <span class="icon"></span>
                                    </a>
                                </li>
                            <?php
                                $first = false;
                            }
                            ?>
                        </ul>
                    </div>

                    <div id="faq-right">
                        <div class="faq-search">
                            Don't find what you're looking for? Mail us at <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN; ?>">support@<?php echo SITE_EMAIL_DOMAIN; ?></a>
                            <div>
                                <p>
                                    <i class="fa fa-fw fa-search" style="font-size: 20px;"></i> <input type="text" id="faqSearch" class="text" placeholder="Search for answers" style="width: 80%"/>
                                </p>
                            </div>
                        </div>
                        <h3 class="text-center">All Questions</h3>
                        <?php
                        foreach ($questions as $categoryId => $question_array) {
                            foreach ($question_array as $question) {
                                ?>
                                <div class="faq_question category_<?php echo $categoryId ?>" data-category="<?php echo $categoryId; ?>">
                                    <a class="question" href="#" rel="<?php echo $question->id ?>">
                                        <?php echo trim($question->question) ?>
                                        <span class="icon-plus">+</span>
                                        <span class="icon-minus">-</span>
                                    </a>

                                    <div class="answer answer-<?php echo $question->id ?>"><?php echo $question->answer ?></div>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<script type="text/javascript">
    $(document).ready(function () {
        //init
        var categories = [];
        categories[0] = 'All Questions';
        <?php
         $categories = $categories->result();

         foreach ($categories as $category) {
         ?>
        categories[<?php echo $category->id ?>] = '<?php echo $category->name ?>';
        <?php
         }
         ?>

        // Code to fix 'all questions' being removed
        var selectedCategory = <?php echo $categories[0]->id ?>;
        $("#faq-right h3").html(categories[selectedCategory]);
        if (selectedCategory > 0) {
            $(".faq_question").hide();
            $(".category_" + selectedCategory).show();
        } else {
            $(".faq_question").show();
        }

        $(".answer").hide();
        //category selector
        $(".faq-selector a").click(function () {
            if (!$(this).parent().hasClass('active')) {
                $(".answer").hide();
                $(".question").removeClass('active');
                var categoryId = $(this).attr('rel');
                $("#faq-right h3").html(categories[categoryId]);
                $(".faq-selector li.active").removeClass('active');
                $(this).parent().addClass('active');
                if (categoryId > 0) {
                    $(".faq_question").hide();
                    $(".category_" + categoryId).show();
                } else {
                    $(".faq_question").show();
                }
            }
            applysearchFilter();
        });
        //question expand/contract
        $(".question").click(function () {
            var questionId = $(this).attr('rel');
            if (!$(this).hasClass('active')) {
                $(".question.active").removeClass('active');
                $(".answer.open").removeClass('open').slideUp('fast');
                //open it up
                $(this).addClass('active');
                $('.answer-' + questionId).slideDown('fast').addClass('open');
            } else {
                //close it
                $(this).removeClass('active');
                $(".answer-" + questionId).slideUp('fast').removeClass('open');
            }
            return false;
        });
        //search
        $(".faq-search .clear").click(function () {
            $("#faq-search").val('');
        });

        $("#faqSearch").on('input', function() {
            applysearchFilter();
        });
    });

    function applysearchFilter() {
        var searchVal = $("#faqSearch").val();
        var searchCategories = [];
        var activeCategoryId = getActiveCategory();

        if (searchVal.length) {
            $(".faq_question").hide();
            var questionParents = $("a.question:icontains(" + searchVal + ")").parent('.faq_question');
            $(questionParents).each(function() {
                // Add the category to the array
                searchCategories.push($(this).data('category'));
                // Show the question from this category
                if ($(this).data('category') == activeCategoryId) {
                    $(this).show();
                }
            });

            // Collapse all answers
            $(".answer.open").removeClass('open');

            // Show no results
            if (questionParents.length < 1) {
                $("#faq-right h3").html('No Results');
            }
            else {
                // We have results, do some cool stuff

                // Get the unique categories of search results
                var uniqueCats = [...new Set(searchCategories)];

                // Hide all questions
                $(".faq-question-list-item").hide();

                // Show the questions in the selected category
                $.each(uniqueCats, function(index, value) {
                    $(".faq-question-list-item[data-category='" + value + "']").show();
                });

                // Switch active category to the first one with results if no results in active category
                if ($('.faq-question-list-item[data-category="' + getActiveCategory() + '"]').is(':hidden')) {
                    // Trigger a click on first result
                    $('.faq-question-list-item[data-category="' + uniqueCats[0] + '"] a').trigger('click');
                }
            }
        }
        else {
            resetResults();
            $(".answer.open").removeClass('open');
        }
    }

    function resetResults() {
        // Show categories
        $('.faq-question-list-item').show();
        // Show questions
        $(".faq_question").each(function() {
            if ($(this).data('category') == getActiveCategory()) {
                $(this).show();
            }
        });

        $("#faq-right h3").html($('.faq-question-list-item[data-category="' + getActiveCategory() + '"]').text());

    }

    function getActiveCategory() {
        return $('.faq-question-list-item.active').data('category');
    }
</script>
<?php $this->load->view('global/footer'); ?>
