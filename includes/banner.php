<div class="govuk-width-container">
    <div class="govuk-phase-banner">
        <p class="govuk-phase-banner__content">
            <strong class="govuk-tag govuk-phase-banner__content__tag">
                <?= $app->phase ?>
            </strong>
            <span class="govuk-phase-banner__text">
                <?= $app->get_phrase("feedback1") ?> <a class="govuk-link" href="#"><?= $app->get_phrase("feedback2") ?></a> <?= $app->get_phrase("feedback3") ?>.
            </span>
        </p>
    </div>
</div>
