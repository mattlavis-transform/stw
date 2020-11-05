<?php
require("includes/application.php");
global $app;
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
                <!--<a href="sign-in" class="govuk-back-link"><?= $app->get_phrase("back") ?></a>//-->
                <main class="govuk-main-wrapper">
                    <div class="govuk-grid-row">
                        <div class="govuk-grid-column-two-thirds">
                            <form action="choose_commodity.html" method="get">
                                <div class="govuk-form-group ">
                                    <fieldset class="govuk-fieldset">
                                        <legend class="govuk-fieldset__legend govuk-fieldset__legend--xl">
                                            <h1 class="govuk-fieldset__heading">
                                                Do you want to import or export goods?
                                            </h1>
                                        </legend>
                                        <div class="govuk-radios">
                                            <div class="govuk-radios__item">
                                                <input class="govuk-radios__input" id="trade_direction-2" name="trade_direction" type="radio" value="importing">
                                                <label class="govuk-label govuk-radios__label" for="trade_direction-2">
                                                    Import goods into the UK
                                                </label>
                                            </div>
                                            <div class="govuk-radios__item">
                                                <input class="govuk-radios__input" id="trade_direction" name="trade_direction" type="radio" value="exporting">
                                                <label class="govuk-label govuk-radios__label" for="trade_direction">
                                                    Export goods from the UK
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <button class="govuk-button">Continue</button>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </main>
    </div>
    <?php
    require("includes/footer.php");
    ?>
    

</body>

</html>