<!--
<footer class="govuk-footer " role="contentinfo">
        <div class="govuk-width-container ">

            <div class="govuk-footer__meta">
                <div class="govuk-footer__meta-item govuk-footer__meta-item--grow">

                    <h2 class="govuk-visually-hidden">Support links</h2>

                    <ul class="govuk-footer__inline-list">

                        <li class="govuk-footer__inline-list-item">
                            <a class="govuk-footer__link" href="https://govuk-prototype-kit.herokuapp.com/">
                                GOV.UK Prototype Kit v9.4.0
                            </a>
                        </li>

                        <li class="govuk-footer__inline-list-item">
                            <a class="govuk-footer__link" href="/prototype-admin/clear-data">
                                Clear data
                            </a>
                        </li>

                    </ul>



                    <svg role="presentation" focusable="false" class="govuk-footer__licence-logo" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 483.2 195.7" height="17" width="41">
                        <path fill="currentColor" d="M421.5 142.8V.1l-50.7 32.3v161.1h112.4v-50.7zm-122.3-9.6A47.12 47.12 0 0 1 221 97.8c0-26 21.1-47.1 47.1-47.1 16.7 0 31.4 8.7 39.7 21.8l42.7-27.2A97.63 97.63 0 0 0 268.1 0c-36.5 0-68.3 20.1-85.1 49.7A98 98 0 0 0 97.8 0C43.9 0 0 43.9 0 97.8s43.9 97.8 97.8 97.8c36.5 0 68.3-20.1 85.1-49.7a97.76 97.76 0 0 0 149.6 25.4l19.4 22.2h3v-87.8h-80l24.3 27.5zM97.8 145c-26 0-47.1-21.1-47.1-47.1s21.1-47.1 47.1-47.1 47.2 21 47.2 47S123.8 145 97.8 145" />
                    </svg>
                    <span class="govuk-footer__licence-description">
                        All content is available under the
                        <a class="govuk-footer__link" href="https://www.nationalarchives.gov.uk/doc/open-government-licence/version/3/" rel="license">Open Government Licence v3.0</a>, except where otherwise stated
                    </span>
                </div>
                <div class="govuk-footer__meta-item">
                    <a class="govuk-footer__link govuk-footer__copyright-logo" href="https://www.nationalarchives.gov.uk/information-management/re-using-public-sector-information/uk-government-licensing-framework/crown-copyright/">© Crown copyright</a>
                </div>
            </div>
        </div>
    </footer>
//-->




    <!-- Javascript -->
    <script src="/public/javascripts/jquery-1.11.3.js"></script>


    <script src="/extension-assets/govuk-frontend/govuk/all.js"></script>


    <script src="/public/javascripts/application.js"></script>


    <script src="/public/javascripts/auto-store-data.js"></script>
    <script type="text/javascript" src="/public/location-autocomplete.min.js"></script>
    <script type="text/javascript">
/*accessibleAutocomplete.enhanceSelectElement({
  selectElement: document.querySelector('#location-autocomplete'),
  defaultValue: '',
  showAllValues: true,
  url: '/public/location-autocomplete-graph.json'
})*/
const selectElement = document.getElementById('location-autocomplete');
let countryValue = '';
if (document.getElementById('hidden-country')) {
  countryValue = document.getElementById('hidden-country').innerText;
};
  openregisterLocationPicker({
    selectElement: document.getElementById('location-autocomplete'),
    defaultValue: '',
    url: '/public/location-autocomplete-graph.json'
  })
</script>



    <!-- GOV.UK Prototype Kit v9.4.0 -->