<?php
require("includes/application.php");
global $app;
$app->set_country();
//pre($_SESSION);
?>
<!DOCTYPE html>
<html lang="en" class="govuk-template ">

<head>
    <meta charset="utf-8" />
    <title>
        Single Trade Window - manage trade
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
                <a href="choose_country" class="govuk-back-link">Back</a>
                <main class="govuk-main-wrapper">

                    <div class="govuk-grid-row">
                        <div class="govuk-grid-column-two-thirds">
                            <h1 class="govuk-heading-xl">
                                Manage this trade
                            </h1>
                            <p class="govuk-body-l">You need to complete these requirements to import commodity code
                                <?= $app->commodity_object->commodity_code ?> (<?= $app->commodity_object->description ?>) into the United Kingdom from <?= $app->country ?>.</p>
                            <ul class="app-task-list app-task-list__shortened">
                                <?php
                                foreach ($app->commodity_object->unique_conditions as $measure_condition) {
                                ?>
                                    <li class="app-task-list__item">
                                        <span class="app-task-list__task-name app-task-list__task-name-break">
                                            <p>
                                                <strong><a href="#" aria-describedby="xyz-licence-completed">
                                                        <?=$measure_condition->document_code?>
                                                    </a></strong>
                                            </p>
                                            <p class="govuk-hint"><?=$measure_condition->requirement?></p>
                                            <p class="govuk-hint">Name of department goes here</p>
                                        </span>
                                        <p class="app-task-list__task-completed" id="xyz-licence-completed">Not started</p>
                                    </li>
                                <?php
                                }
                                ?>
                                <!--
                                <li class="app-task-list__item">
                                    <span class="app-task-list__task-name app-task-list__task-name-break">
                                        <p>
                                            <strong><a href="xyz-service-start" aria-describedby="xyz-licence-completed">
                                                    Get an XYZ licence
                                                </a></strong>
                                        </p>
                                        <p class="govuk-hint">Department for International Trade</p>
                                    </span>
                                    <p class="app-task-list__task-completed" id="xyz-licence-completed">Not started</p>
                                </li>

                                <li class="app-task-list__item">
                                    <span class="app-task-list__task-name app-task-list__task-name-break">
                                        <p>
                                            <strong><a href="abc-service-start" aria-describedby="abc-declaration-completed">
                                                    Complete an ABC declaration
                                                </a></strong>
                                        </p>
                                        <p class="govuk-hint">HM Revenue and Customs</p>
                                    </span>
                                    <p class="app-task-list__task-completed" id="abc-declaration-completed">Not started</p>
                                </li>

                                <li class="app-task-list__item">
                                    <span class="app-task-list__task-name app-task-list__task-name-break">
                                        <p>
                                            <strong><a href="123-service" aria-describedby="123-certificate-completed">
                                                    Get a 123 certificate
                                                </a></strong>
                                        </p>
                                        <p class="govuk-hint">Environment Agency</p>
                                    </span>
                                    <p class="app-task-list__task-completed" id="123-certificate-completed">Not started</p>
                                </li>
                                //-->
                            </ul>
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