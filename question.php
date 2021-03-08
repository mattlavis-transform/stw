<?php
require("includes/application.php");
global $app;
$app->set_country();
$app->get_trade_direction_message(1);
$app->get_templates();
$app->get_folders();
$app->set_question();
$app->page_title = $app->get_phrase("manage_trade") . " - " . $app->get_phrase("application_title");
?>
<!DOCTYPE html>
<html lang="en" class="govuk-template ">

<head>
    <?php
    require("includes/meta.php");
    ?>
</head>

<body class="govuk-template__body ">
    <?php
    require("includes/header.php");
    ?>
    <div class="govuk-width-container ">
        <?php
        require("includes/banner.php");
        ?>
        <main class="govuk-main-wrapper govuk-main-wrapper--auto-spacing" id="main-content" role="main">
            <div class="govuk-width-container">

                <a href="choose_country.html?commodity_code=<?= $app->commodity_code ?>&trade_direction=importing" class="govuk-back-link"><?= $app->get_phrase("back") ?></a>

                <main class="govuk-main-wrapper">
                    <div class="govuk-grid-row">
                        <div class="govuk-grid-column-three-quarters">
                            <?php
                            $app->commodity_object->get_questions("certificates", 0, "AB");
                            ?>
                            
                        </div>
                    </div>
                </main>
            </div>
        </main>
    </div>
    <?php
    require("includes/footer.php");
    ?>
    <script>
        var info_hidden = true;
        $("body").keydown(function(event) {
            if ((event.which == 83) || (event.which == 115)) {
                console.log("s pressed");
                event.preventDefault();
                if (info_hidden == true) {
                    info_hidden = false;
                    $(".info").show();
                    $(".boilerplate").addClass("boilerplate_highlight");
                } else {
                    info_hidden = true;
                    $(".info").hide();
                    $(".boilerplate").removeClass("boilerplate_highlight");
                }
            }
        });
    </script>

</body>

</html>