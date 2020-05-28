<!DOCTYPE html>
<html lang="en" class="govuk-template ">

<head>
    <meta charset="utf-8" />
    <title>
    Single Trade Window - choose trade direction
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
                <!--<a href="sign-in" class="govuk-back-link">Back</a>//-->
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
                                                <input class="govuk-radios__input" id="type-of-trade-2" name="type-of-trade" type="radio" value="importing">
                                                <label class="govuk-label govuk-radios__label" for="type-of-trade-2">
                                                    Import goods into the UK
                                                </label>
                                            </div>
                                            <div class="govuk-radios__item">
                                                <input class="govuk-radios__input" id="type-of-trade" name="type-of-trade" type="radio" value="exporting">
                                                <label class="govuk-label govuk-radios__label" for="type-of-trade">
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