<?php
require("includes/application.php");
global $app;
$app->page_title = "Select commodity";
$app->set_trade_direction();
$app->get_trade_direction_message();
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
                <a href="/" class="govuk-back-link"><?= $app->get_phrase("back") ?></a>
                <main class="govuk-main-wrapper">

                    <div class="govuk-grid-row">
                        <div class="govuk-grid-column-two-thirds">
                            <form action="choose_country.html" method="get">
                                <fieldset class="govuk-fieldset">
                                    <legend class="govuk-fieldset__legend govuk-fieldset__legend--xl">
                                        <h1 class="govuk-fieldset__heading">
                                            <?= $app->commodity_message ?>
                                        </h1>
                                    </legend>
                                    <div class="govuk-form-group ">
                                        <!--
                                        <details class="govuk-details" data-module="govuk-details">
                                            <summary class="govuk-details__summary">
                                                <span class="govuk-details__summary-text">
                                                    Find a commodity code
                                                </span>
                                            </summary>
                                            <div class="govuk-details__text">
                                                You can find the commodity code for your goods using our <a target="_blank" href='https://www.gov.uk/trade-tariff'>Trade Tariff tool</a>
                                            </div>
                                        </details>
                                        //-->
                                        <details class="govuk-details" data-module="govuk-details">
                                            <summary class="govuk-details__summary">
                                                <span class="govuk-details__summary-text">
                                                    Find a commodity code
                                                </span>
                                            </summary>
                                            <div class="govuk-details__text">
                                                You can find the commodity code for your goods using our <a target="_blank" href='https://www.gov.uk/trade-tariff'>Trade Tariff tool</a>
                                            </div>
                                        </details>
                                        <input class="govuk-input" id="commodity_code" name="commodity_code" type="text" value="">
                                    </div>
                                    <button class="govuk-button">Continue</button>
                                </fieldset>
                                <input type="hidden" value="<?= $app->trade_direction ?>" name="trade_direction" />
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