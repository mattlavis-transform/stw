<?php
require("includes/application.php");
global $app;
$app->set_trade_direction();
$app->get_trade_direction_message();
?>
<!DOCTYPE html>
<html lang="en" class="govuk-template ">

<head>
    <meta charset="utf-8" />
    <title>
        STW - Data demo - choose commodity
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0b0c0c" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" sizes="16x16 32x32 48x48" href="/govuk/assets/images/favicon.ico" type="image/x-icon" />
    <link rel="mask-icon" href="/govuk/assets/images/govuk-mask-icon.svg" color="#0b0c0c">
    <link rel="apple-touch-icon" sizes="180x180" href="/govuk/assets/images/govuk-apple-touch-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/govuk/assets/images/govuk-apple-touch-icon-167x167.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/govuk/assets/images/govuk-apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" href="/govuk/assets/images/govuk-apple-touch-icon.png">
    <!--[if lte IE 8]><link href="/public/stylesheets/application-ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
    <!--[if gt IE 8]><!-->
    <link href="/public/stylesheets/application.css" media="all" rel="stylesheet" type="text/css" />
    <!--<![endif]-->
    <link rel="stylesheet" href="/public/location-autocomplete.min.css" />
    <!--<link rel="stylesheet" href="/public/accessible-autocomplete.min.css" />-->
    <meta property="og:image" content="/govuk/assets/images/govuk-opengraph-image.png">
</head>

<body class="govuk-template__body ">
    <?php
    require("includes/header.php");
    ?>
    <div class="govuk-width-container ">
        <main class="govuk-main-wrapper govuk-main-wrapper--auto-spacing" id="main-content" role="main">
            <div class="govuk-width-container">
                <a href="/" class="govuk-back-link">Back</a>
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