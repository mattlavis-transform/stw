<?php
require("includes/application.php");
global $app;
$app->set_country();
$app->get_trade_direction_message(1);
$app->get_templates();
$app->get_folders();
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
                        <!-- <div class="govuk-grid-column-two-thirds"> -->
                        <div class="govuk-grid-column-three-quarters">
                            <h1 class="govuk-heading-xl">
                                <?= $app->get_phrase("application_title") ?><span class='govuk-visually-hidden'>.</span>
                            </h1>

                            <p class="govuk-body-l">
                                <?= $app->get_phrase("phrase_subtext1") ?> <strong><?= $app->commodity_code_formatted() ?></strong> <?= $app->get_phrase("phrase_subtext2") ?> <strong><?= $app->country_description ?></strong>.
                            </p>
                            <!-- <div class="govuk-inset-text">
                                Hit the 's' key to toggle hint text and to show boilerplate text in red.
                            </div> -->
                            <br />

                            <div class="govuk-accordion" data-module="govuk-accordion" id="accordion-with-summary-sections">
                                <div class="accordion-group">
                                    <!-- Begin prohibitions //-->
                                    <div id="section_prohibitions" class="govuk-accordion__section govuk-accordion__section--expanded">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading" aria-expanded="true">
                                                    Trade in this commodity is prohibited
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            $app->commodity_object->get_certificates("prohibitions", "AB");
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    //$app->certificate_count = 0;
                                    $app->prohibitions = $app->certificate_count;
                                    if ($app->certificate_count == 0) {
                                    ?>
                                        <script>
                                            $(document).ready(function() {
                                                $("#section_prohibitions").hide();
                                            });
                                        </script>
                                    <?php
                                    } else {
                                        $app->prohibitions = true;
                                    ?>
                                        <!-- <script>
                                            $(document).ready(function() {
                                                $(".govuk-accordion__section").hide();
                                                $("#section_prohibitions").show();
                                            });
                                        </script> -->
                                    <?php
                                    }
                                    ?>
                                    <!-- End prohibitions //-->
                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header" style="border-top: none">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    <?= $app->get_phrase("header_register") ?>
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            #require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <p class="govuk-body-m">
                                                        Before you start importing, you need to:
                                                        <br /><br />
                                                        <a href="https://www.gov.uk/eori?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5" target="_blank">Get an EORI number</a><br>
                                                        Lorem ipsum dolor sit amet<br><br />
                                                        <a href="https://www.gov.uk/vat-registration/when-to-register?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5" target="_blank">Check if you need to register for VAT</a>
                                                        <br /><br />
                                                        You can apply for simplified declaration procedures and for Authorised Economic Operator status. These are most suitable for businesses that import goods regularly.
                                                        <br /><br />
                                                        <a href="https://www.gov.uk/guidance/using-simplified-declarations-for-imports?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5" target="_blank">Find out about using simplified declaration procedures</a><br />
                                                        <br>
                                                        <a href="https://www.gov.uk/guidance/authorised-economic-operator-certification?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5" target="_blank">Check if Authorised Economic Operator status is right for you</a>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="goods-are-organic-heading">
                                                    Value your goods and calculate taxes
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="goods-are-organic-content" class="govuk-accordion__section-content" aria-labelledby="goods-are-organic-heading">
                                            <?php
                                            require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <p class="govuk-body-m">
                                                        How much VAT and duty you pay depends on the value of your goods and the rate of duty you need to pay.
                                                        <br /><br />
                                                        <a href="https://www.gov.uk/guidance/how-to-value-your-imports-for-customs-duty-and-trade-statistics?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5" target="_blank">Work out the value of your goods for customs</a>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    Delay or reduce duty payments
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <p class="govuk-body-m">
                                                        You may be able to delay or reduce the amount of duty you pay based on where the goods are from and what you plan to do with them.
                                                        <br /><br />
                                                        <a href="https://www.gov.uk/guidance/check-if-you-can-pay-a-reduced-rate-of-customs-duty?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5" target="_blank">Find out if you can pay a lower rate of duty or delay paying</a>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Begin certificates //-->
                                    <div class="govuk-accordion__section govuk-accordion__section--expanded">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading" aria-expanded="true">
                                                    <?= $app->get_phrase("header_certificates") ?>
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            $app->commodity_object->get_certificates("certificates", "AB");
                                            ?>
                                        </div>
                                    </div>
                                    <!-- End certificates //-->

                                    <!-- Begin quotas //-->
                                    <!--
                                    <div id="section_quotas" class="govuk-accordion__section govuk-accordion__section--expanded">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading" aria-expanded="true">
                                                    If you want to take advantage of quotas
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            $app->commodity_object->get_certificates("quotas", "C", "122,123,143,146");
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    if (($app->certificate_count == 0) || ($app->prohibitions == true)) {
                                    ?>
                                        <script>
                                            $(document).ready(function() {
                                                $("#section_quotas").hide();
                                            });
                                        </script>
                                    <?php
                                    }
                                    ?>
                                    //-->
                                    <!-- End quotas //-->

                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    Check which transportation documents you need
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <p class="govuk-body-m">Whether you’re importing or exporting, you need to know what paperwork is required. Even if you use a freight forwarder or an agent, it’s still up to you to make sure the right documentation is available.
                                                        <br /><br />
                                                        Missing or inaccurate documents can increase risks, lead to delays and extra costs, or even prevent a deal from being completed.
                                                        <br /><br />
                                                        <a href="https://www.gov.uk/guidance/international-trade-paperwork-the-basics" target="_blank">Find out which documents are needed for your goods to travel</a><br />
                                                        <br>
                                                        <a href="https://www.great.gov.uk/advice/prepare-for-export-procedures-and-logistics/international-trade-contracts-and-incoterms/" target="_blank">Read about trade contracts and incoterms</a>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    Submit declarations
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <h3 class="govuk-heading-s">You need to submit these declarations every time the goods enter the UK:</h3>
                                                    <p class="govuk-body-m">
                                                        <a href="https://www.gov.uk/guidance/register-to-make-an-entry-summary-declaration" target="_blank">An Entry Summary Declaration (ENS) submitted through the Import Control System (ICS).</a><br />
                                                        <br>
                                                        <a href="https://webgate.ec.europa.eu/tracesnt/login" target="_blank">A Common Health Entry Declaration (CHED-D) submitted through Trade Control and Expert System (TRACES-NT)</a><br />
                                                        <br>
                                                        <a href="https://www.gov.uk/guidance/customs-declarations-for-goods-brought-into-the-eu?step-by-step-nav=8a543f4b-afb7-4591-bbfc-2eec52ab96c2" target="_blank">A Customs Declaration through Customs Handling of Import and Export Freight system (CHIEF)</a><br />
                                                    </p>
                                                    <p class="govuk-body-m">You need to register to use each of these services if you have not submitted a declaration before.</p>
                                                    <p class="govuk-body-m">Declarations are documents that outline the details of goods that are being imported or exported. They are needed to get your goods through the UK border.</p>
                                                    <a href="https://www.gov.uk/import-customs-declaration" target="_blank">Get UK customs clearance when importing goods from outside the EU: step by step</a><br />
                                                    <a href="https://www.gov.uk/guidance/appoint-someone-to-deal-with-customs-on-your-behalf" target="_blank">Find out how to hire someone to deal with customs declarations for you</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    Submit notifications
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <h3 class="govuk-heading-s">You need to submit these notifications every time the goods leave the UK:</h3>
                                                    <a href="http://ehmipeach.defra.gov.uk/Default.aspx?Module=Register" target="_blank">A pre-arrival notification submitted through Procedure for Electronic Application for Certificates from the horticultural Inspectorate (PEACH)</a>
                                                    <br />
                                                    <h3 class="govuk-heading-s">If the goods are organic, these notifications also need to be submitted:</h3>
                                                    <a href="http://www.porthealthassociation.co.uk/port-directory/" target="_blank">A pre-arrival notification submitted through the Port Health Authority pre-notification system</a>
                                                    <br />
                                                    <p class="govuk-body-m">You need to register to use each of these services if you have not submitted a notification before.</p>
                                                    <p class="govuk-body-m">Notifications inform the right government departments that your goods are due to arrive. They are needed to get your goods through the UK border.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    Claim a VAT refund
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <p class="govuk-body-m">
                                                        If you're VAT registered, you can claim back any VAT you paid on the goods you've imported.
                                                        <br /><br />
                                                        You’ll also be sent an Import VAT Certificate (C79) in the post as proof you have paid. This will arrive after you have submitted your customs declarations.
                                                        <br /><br />
                                                        <a href="https://www.gov.uk/guidance/vat-imports-acquisitions-and-purchases-from-abroad?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5#goods-from-non-eu-countries" target="_blank">Find out how to claim a VAT refund</a>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    Reclaim duty if you’ve paid the wrong amount
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <p class="govuk-body-m">
                                                        You can claim duty back if you have paid the wrong amount or if your import was rejected.
                                                        <br /><br />
                                                        <a href="https://www.gov.uk/guidance/refunds-and-waivers-on-customs-debt?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5" target="_blank">Find out how to apply for a refund on import duties</a>
                                                        <br /><br />
                                                        <a href="https://www.gov.uk/guidance/refunds-and-waivers-on-customs-debt?step-by-step-nav=849f71d1-f290-4a8e-9458-add936efefc5#claims-for-rejected-imports" target="_blank">Find out what you can claim back if you reject an import</a>
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    Check which invoices and records you should keep
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <?php
                                            require("includes/dummy.php");
                                            ?>
                                            <ul class="govuk-list">
                                                <li>
                                                    <p class="govuk-body-m">You must keep records of commercial invoices and any customs paperwork, including your C79.</p>
                                                    <p class="govuk-body-m">If you imported controlled goods, for example firearms, keep the paperwork that shows who owns the goods.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>



                                    <div class="govuk-accordion__section toggle_hide">
                                        <div class="govuk-accordion__section-header">
                                            <h2 class="govuk-accordion__section-heading">
                                                <span class="govuk-accordion__section-button" id="before-you-import-heading">
                                                    Getting your goods into <?= $app->country_description ?>
                                                </span>
                                            </h2>
                                        </div>
                                        <div id="before-you-import-content" class="govuk-accordion__section-content" aria-labelledby="before-you-import-heading">
                                            <div class="govuk-inset-text">
                                                This is to show how we could deep-link into CHEG (to the 6-digit code)
                                            </div>
                                            <ul class="govuk-list">
                                                <li>
                                                    <p class="govuk-body-m">Because international trade hierarchies are not always the same, etc ...
                                                    </p>
                                                    <p class="govuk-body-m">
                                                        <a target="_blank" href="https://www.check-duties-customs-exporting-goods.service.gov.uk/summary?d=<?= $app->country ?>&pc=<?= substr($app->commodity_code, 0, 6) ?>">
                                                            Exporting <?= $app->commodity_code ?> to <?= $app->country ?>
                                                        </a>(Deep link - rarely works)
                                                    </p>
                                                    <p class="govuk-body-m">
                                                        <a target="_blank" href="https://www.check-duties-customs-exporting-goods.service.gov.uk/commdrilld?d=<?= $app->country ?>&pc=<?= substr($app->commodity_code, 0, 6) ?>">
                                                            Exporting <?= $app->commodity_code ?> to <?= $app->country ?>
                                                        </a>(Shallow link to hierarchy - seems to be better)
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>


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