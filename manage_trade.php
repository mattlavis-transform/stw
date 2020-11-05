<?php
require("includes/application.php");
global $app;
$app->page_title = "Manage trade";
$app->set_country();
$app->get_trade_direction_message(1);
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
        <main class="govuk-main-wrapper govuk-main-wrapper--auto-spacing" id="main-content" role="main">
            <div class="govuk-width-container">
                <a href="choose_country.html" class="govuk-back-link"><?= $app->get_phrase("back") ?></a>
                <main class="govuk-main-wrapper">

                    <div class="govuk-grid-row">
                        <!--<div class="govuk-grid-column-two-thirds">//-->
                        <div class="govuk-grid-column-full">
                            <h1 class="govuk-heading-xl">
                                Manage this trade
                            </h1>
                            <p class="govuk-body-l"><?= $app->manage_message ?></p>
                            <ul class="app-task-list app-task-list__shortened">
                                <?php
                                foreach ($app->commodity_object->unique_conditions as $measure_condition) {
                                ?>
                                    <li class="app-task-list__item">
                                        <span class="app-task-list__task-name app-task-list__task-name-break">
                                            <p>
                                                <strong><a href="#" aria-describedby="xyz-licence-completed">
                                                        <?= $measure_condition->document_code ?>
                                                    </a></strong>
                                            </p>
                                            <p class="govuk-hint"><?= $measure_condition->requirement ?></p>
                                            <p class="govuk-hint">Name of department goes here</p>
                                            <details class="govuk-details" data-module="govuk-details" style="width:100% !important" open>
                                                <summary class="govuk-details__summary">
                                                    <span class="govuk-details__summary-text">
                                                        More details on this document code
                                                    </span>
                                                </summary>
                                                <div class="govuk-details__text" style="width:100% !important">
                                                    This document code is used in the following measures:
                                                    <table class="govuk-table" style="width:100% !important">
                                                        <caption class="govuk-table__caption" style="display:none">Measures</caption>
                                                        <thead class="govuk-table__head">
                                                            <tr class="govuk-table__row">
                                                                <th scope="col" class="govuk-table__header">ID</th>
                                                                <th scope="col" class="govuk-table__header">Measure type</th>
                                                                <th scope="col" class="govuk-table__header">Geography</th>
                                                                <th scope="col" class="govuk-table__header">Exclusions</th>
                                                            </tr>
                                                        </thead>
                                                        <?php
                                                        foreach ($measure_condition->measures as $measure) {
                                                        ?>
                                                            <tr class="govuk-table__row">
                                                                <td class="govuk-table__cell"><?= $measure->id ?></td>
                                                                <td class="govuk-table__cell"><strong><?= $measure->measure_type_id ?></strong> <?= $measure->measure_type_description ?></td>
                                                                <td class="govuk-table__cell"><strong><?= $measure->geographical_area_id ?></strong> <?= $measure->geographical_area_description ?></td>
                                                                <td nowrap class="govuk-table__cell"><?= $measure->exclusions ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </details>
                                        </span>
                                        <p class="app-task-list__task-completed" id="xyz-licence-completed">
                                            <!--Not started//-->&nbsp;</p>
                                    </li>
                                <?php
                                }
                                ?>
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