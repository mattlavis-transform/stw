<?php
require("includes/application.php");
global $app;
$app->set_commodity_code();
?>
<!DOCTYPE html>
<html lang="en" class="govuk-template ">

<head>
    <meta charset="utf-8" />
    <title>
        STW - Data demo - choose country
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
                <a href="/choose_commodity.html" class="govuk-back-link">Back</a>
                <main class="govuk-main-wrapper">

                    <div class="govuk-grid-row">
                        <div class="govuk-grid-column-two-thirds">
                            <form action="manage_trade.html" method="get">
                                <fieldset class="govuk-fieldset">
                                    <legend class="govuk-fieldset__legend govuk-fieldset__legend--xl">
                                        <h1 class="govuk-fieldset__heading">
                                            Which country are the imported goods from?
                                        </h1>
                                    </legend>

                                    <div class="govuk-form-group ">
                                        <select id="location-autocomplete" class="autocomplete__input autocomplete__input--default" name="country">
                                            <option value="" disabled="" selected="">Pick an option</option>
                                            <option value="territory:AE-AZ">Abu Dhabi</option>
                                            <option value="country:AF">Afghanistan</option>
                                            <option value="territory:AE-AJ">Ajman</option>
                                            <option value="territory:XQZ">Akrotiri</option>
                                            <option value="country:AL">Albania</option>
                                            <option value="country:DZ">Algeria</option>
                                            <option value="territory:AS">American Samoa</option>
                                            <option value="country:AD">Andorra</option>
                                            <option value="country:AO">Angola</option>
                                            <option value="territory:AI">Anguilla</option>
                                            <option value="territory:AQ">Antarctica</option>
                                            <option value="country:AG">Antigua and Barbuda</option>
                                            <option value="country:AR">Argentina</option>
                                            <option value="country:AM">Armenia</option>
                                            <option value="territory:AW">Aruba</option>
                                            <option value="territory:SH-AC">Ascension</option>
                                            <option value="country:AU">Australia</option>
                                            <option value="country:AT">Austria</option>
                                            <option value="country:AZ">Azerbaijan</option>
                                            <option value="country:BH">Bahrain</option>
                                            <option value="territory:UM-81">Baker Island</option>
                                            <option value="country:BD">Bangladesh</option>
                                            <option value="country:BB">Barbados</option>
                                            <option value="country:BY">Belarus</option>
                                            <option value="country:BE">Belgium</option>
                                            <option value="country:BZ">Belize</option>
                                            <option value="country:BJ">Benin</option>
                                            <option value="territory:BM">Bermuda</option>
                                            <option value="country:BT">Bhutan</option>
                                            <option value="country:BO">Bolivia</option>
                                            <option value="territory:BQ-BO">Bonaire</option>
                                            <option value="country:BA">Bosnia and Herzegovina</option>
                                            <option value="country:BW">Botswana</option>
                                            <option value="territory:BV">Bouvet Island</option>
                                            <option value="country:BR">Brazil</option>
                                            <option value="territory:BAT">British Antarctic Territory</option>
                                            <option value="territory:IO">British Indian Ocean Territory</option>
                                            <option value="territory:VG">British Virgin Islands</option>
                                            <option value="country:BN">Brunei</option>
                                            <option value="country:BG">Bulgaria</option>
                                            <option value="country:BF">Burkina Faso</option>
                                            <option value="country:MM">Myanmar (Burma)</option>
                                            <option value="country:BI">Burundi</option>
                                            <option value="country:KH">Cambodia</option>
                                            <option value="country:CM">Cameroon</option>
                                            <option value="country:CA">Canada</option>
                                            <option value="country:CV">Cape Verde</option>
                                            <option value="territory:KY">Cayman Islands</option>
                                            <option value="country:CF">Central African Republic</option>
                                            <option value="territory:ES-CE">Ceuta</option>
                                            <option value="country:TD">Chad</option>
                                            <option value="country:CL">Chile</option>
                                            <option value="country:CN">China</option>
                                            <option value="territory:CX">Christmas Island</option>
                                            <option value="territory:CC">Cocos (Keeling) Islands</option>
                                            <option value="country:CO">Colombia</option>
                                            <option value="country:KM">Comoros</option>
                                            <option value="country:CG">Congo</option>
                                            <option value="country:CD">Congo (Democratic Republic)</option>
                                            <option value="territory:CK">Cook Islands</option>
                                            <option value="country:CR">Costa Rica</option>
                                            <option value="country:HR">Croatia</option>
                                            <option value="country:CU">Cuba</option>
                                            <option value="territory:CW">Curaçao</option>
                                            <option value="country:CY">Cyprus</option>
                                            <option value="country:CZ">Czechia</option>
                                            <option value="country:DK">Denmark</option>
                                            <option value="territory:XXD">Dhekelia</option>
                                            <option value="country:DJ">Djibouti</option>
                                            <option value="country:DM">Dominica</option>
                                            <option value="country:DO">Dominican Republic</option>
                                            <option value="territory:AE-DU">Dubai</option>
                                            <option value="country:TL">East Timor</option>
                                            <option value="country:EC">Ecuador</option>
                                            <option value="country:EG">Egypt</option>
                                            <option value="country:SV">El Salvador</option>
                                            <option value="country:GQ">Equatorial Guinea</option>
                                            <option value="country:ER">Eritrea</option>
                                            <option value="country:EE">Estonia</option>
                                            <option value="country:SZ">Eswatini</option>
                                            <option value="country:ET">Ethiopia</option>
                                            <option value="territory:FK">Falkland Islands</option>
                                            <option value="territory:FO">Faroe Islands</option>
                                            <option value="country:FJ">Fiji</option>
                                            <option value="country:FI">Finland</option>
                                            <option value="country:FR">France</option>
                                            <option value="territory:GF">French Guiana</option>
                                            <option value="territory:PF">French Polynesia</option>
                                            <option value="territory:TF">French Southern Territories</option>
                                            <option value="territory:AE-FU">Fujairah</option>
                                            <option value="country:GA">Gabon</option>
                                            <option value="country:GE">Georgia</option>
                                            <option value="country:DE">Germany</option>
                                            <option value="country:GH">Ghana</option>
                                            <option value="territory:GI">Gibraltar</option>
                                            <option value="country:GR">Greece</option>
                                            <option value="territory:GL">Greenland</option>
                                            <option value="country:GD">Grenada</option>
                                            <option value="territory:GP">Guadeloupe</option>
                                            <option value="territory:GU">Guam</option>
                                            <option value="country:GT">Guatemala</option>
                                            <option value="territory:GG">Guernsey</option>
                                            <option value="country:GN">Guinea</option>
                                            <option value="country:GW">Guinea-Bissau</option>
                                            <option value="country:GY">Guyana</option>
                                            <option value="country:HT">Haiti</option>
                                            <option value="territory:HM">Heard Island and McDonald Islands</option>
                                            <option value="country:HN">Honduras</option>
                                            <option value="territory:HK">Hong Kong</option>
                                            <option value="territory:UM-84">Howland Island</option>
                                            <option value="country:HU">Hungary</option>
                                            <option value="country:IS">Iceland</option>
                                            <option value="country:IN">India</option>
                                            <option value="country:ID">Indonesia</option>
                                            <option value="country:IR">Iran</option>
                                            <option value="country:IQ">Iraq</option>
                                            <option value="country:IE">Ireland</option>
                                            <option value="territory:IM">Isle of Man</option>
                                            <option value="country:IL">Israel</option>
                                            <option value="country:IT">Italy</option>
                                            <option value="country:CI">Ivory Coast</option>
                                            <option value="country:JM">Jamaica</option>
                                            <option value="country:JP">Japan</option>
                                            <option value="territory:UM-86">Jarvis Island</option>
                                            <option value="territory:JE">Jersey</option>
                                            <option value="territory:UM-67">Johnston Atoll</option>
                                            <option value="country:JO">Jordan</option>
                                            <option value="country:KZ">Kazakhstan</option>
                                            <option value="country:KE">Kenya</option>
                                            <option value="territory:UM-89">Kingman Reef</option>
                                            <option value="country:KI">Kiribati</option>
                                            <option value="country:XK">Kosovo</option>
                                            <option value="country:KW">Kuwait</option>
                                            <option value="country:KG">Kyrgyzstan</option>
                                            <option value="country:LA">Laos</option>
                                            <option value="country:LV">Latvia</option>
                                            <option value="country:LB">Lebanon</option>
                                            <option value="country:LS">Lesotho</option>
                                            <option value="country:LR">Liberia</option>
                                            <option value="country:LY">Libya</option>
                                            <option value="country:LI">Liechtenstein</option>
                                            <option value="country:LT">Lithuania</option>
                                            <option value="country:LU">Luxembourg</option>
                                            <option value="territory:MO">Macao</option>
                                            <option value="country:MG">Madagascar</option>
                                            <option value="country:MW">Malawi</option>
                                            <option value="country:MY">Malaysia</option>
                                            <option value="country:MV">Maldives</option>
                                            <option value="country:ML">Mali</option>
                                            <option value="country:MT">Malta</option>
                                            <option value="country:MH">Marshall Islands</option>
                                            <option value="territory:MQ">Martinique</option>
                                            <option value="country:MR">Mauritania</option>
                                            <option value="country:MU">Mauritius</option>
                                            <option value="territory:YT">Mayotte</option>
                                            <option value="territory:ES-ML">Melilla</option>
                                            <option value="country:MX">Mexico</option>
                                            <option value="country:FM">Micronesia</option>
                                            <option value="territory:UM-71">Midway Islands</option>
                                            <option value="country:MD">Moldova</option>
                                            <option value="country:MC">Monaco</option>
                                            <option value="country:MN">Mongolia</option>
                                            <option value="country:ME">Montenegro</option>
                                            <option value="territory:MS">Montserrat</option>
                                            <option value="country:MA">Morocco</option>
                                            <option value="country:MZ">Mozambique</option>
                                            <option value="country:NA">Namibia</option>
                                            <option value="country:NR">Nauru</option>
                                            <option value="territory:UM-76">Navassa Island</option>
                                            <option value="country:NP">Nepal</option>
                                            <option value="country:NL">Netherlands</option>
                                            <option value="territory:NC">New Caledonia</option>
                                            <option value="country:NZ">New Zealand</option>
                                            <option value="country:NI">Nicaragua</option>
                                            <option value="country:NE">Niger</option>
                                            <option value="country:NG">Nigeria</option>
                                            <option value="territory:NU">Niue</option>
                                            <option value="territory:NF">Norfolk Island</option>
                                            <option value="country:KP">North Korea</option>
                                            <option value="country:MK">North Macedonia</option>
                                            <option value="territory:MP">Northern Mariana Islands</option>
                                            <option value="country:NO">Norway</option>
                                            <option value="territory:PS">Occupied Palestinian Territories</option>
                                            <option value="country:OM">Oman</option>
                                            <option value="country:PK">Pakistan</option>
                                            <option value="country:PW">Palau</option>
                                            <option value="territory:UM-95">Palmyra Atoll</option>
                                            <option value="country:PA">Panama</option>
                                            <option value="country:PG">Papua New Guinea</option>
                                            <option value="country:PY">Paraguay</option>
                                            <option value="country:PE">Peru</option>
                                            <option value="country:PH">Philippines</option>
                                            <option value="territory:PN">Pitcairn, Henderson, Ducie and Oeno Islands</option>
                                            <option value="country:PL">Poland</option>
                                            <option value="country:PT">Portugal</option>
                                            <option value="territory:PR">Puerto Rico</option>
                                            <option value="country:QA">Qatar</option>
                                            <option value="territory:AE-RK">Ras al-Khaimah</option>
                                            <option value="country:RO">Romania</option>
                                            <option value="country:RU">Russia</option>
                                            <option value="country:RW">Rwanda</option>
                                            <option value="territory:RE">Réunion</option>
                                            <option value="territory:BQ-SA">Saba</option>
                                            <option value="territory:BL">Saint Barthélemy</option>
                                            <option value="territory:SH-HL">Saint Helena</option>
                                            <option value="territory:PM">Saint Pierre and Miquelon</option>
                                            <option value="territory:MF">Saint-Martin (French part)</option>
                                            <option value="country:WS">Samoa</option>
                                            <option value="country:SM">San Marino</option>
                                            <option value="country:ST">Sao Tome and Principe</option>
                                            <option value="country:SA">Saudi Arabia</option>
                                            <option value="country:SN">Senegal</option>
                                            <option value="country:RS">Serbia</option>
                                            <option value="country:SC">Seychelles</option>
                                            <option value="territory:AE-SH">Sharjah</option>
                                            <option value="country:SL">Sierra Leone</option>
                                            <option value="country:SG">Singapore</option>
                                            <option value="territory:BQ-SE">Sint Eustatius</option>
                                            <option value="territory:SX">Sint Maarten (Dutch part)</option>
                                            <option value="country:SK">Slovakia</option>
                                            <option value="country:SI">Slovenia</option>
                                            <option value="country:SB">Solomon Islands</option>
                                            <option value="country:SO">Somalia</option>
                                            <option value="country:ZA">South Africa</option>
                                            <option value="territory:GS">South Georgia and South Sandwich Islands</option>
                                            <option value="country:KR">South Korea</option>
                                            <option value="country:SS">South Sudan</option>
                                            <option value="country:ES">Spain</option>
                                            <option value="country:LK">Sri Lanka</option>
                                            <option value="country:KN">St Kitts and Nevis</option>
                                            <option value="country:LC">St Lucia</option>
                                            <option value="country:VC">St Vincent</option>
                                            <option value="country:SD">Sudan</option>
                                            <option value="country:SR">Suriname</option>
                                            <option value="territory:SJ">Svalbard and Jan Mayen</option>
                                            <option value="country:SE">Sweden</option>
                                            <option value="country:CH">Switzerland</option>
                                            <option value="country:SY">Syria</option>
                                            <option value="territory:TW">Taiwan</option>
                                            <option value="country:TJ">Tajikistan</option>
                                            <option value="country:TZ">Tanzania</option>
                                            <option value="country:TH">Thailand</option>
                                            <option value="country:BS">The Bahamas</option>
                                            <option value="country:GM">The Gambia</option>
                                            <option value="country:TG">Togo</option>
                                            <option value="territory:TK">Tokelau</option>
                                            <option value="country:TO">Tonga</option>
                                            <option value="country:TT">Trinidad and Tobago</option>
                                            <option value="territory:SH-TA">Tristan da Cunha</option>
                                            <option value="country:TN">Tunisia</option>
                                            <option value="country:TR">Turkey</option>
                                            <option value="country:TM">Turkmenistan</option>
                                            <option value="territory:TC">Turks and Caicos Islands</option>
                                            <option value="country:TV">Tuvalu</option>
                                            <option value="country:UG">Uganda</option>
                                            <option value="country:UA">Ukraine</option>
                                            <option value="territory:AE-UQ">Umm al-Quwain</option>
                                            <option value="country:AE">United Arab Emirates</option>
                                            <option value="country:GB">United Kingdom</option>
                                            <option value="country:US">United States</option>
                                            <option value="territory:VI">United States Virgin Islands</option>
                                            <option value="country:UY">Uruguay</option>
                                            <option value="country:UZ">Uzbekistan</option>
                                            <option value="country:VU">Vanuatu</option>
                                            <option value="country:VA">Vatican City</option>
                                            <option value="country:VE">Venezuela</option>
                                            <option value="country:VN">Vietnam</option>
                                            <option value="territory:UM-79">Wake Island</option>
                                            <option value="territory:WF">Wallis and Futuna</option>
                                            <option value="territory:EH">Western Sahara</option>
                                            <option value="country:YE">Yemen</option>
                                            <option value="country:ZM">Zambia</option>
                                            <option value="country:ZW">Zimbabwe</option>
                                            <option value="territory:AX">Åland Islands</option>
                                        </select>
                                    </div>

                                    <button class="govuk-button">Continue</button>

                                </fieldset>
                                <input type="hidden" value="<?=$app->trade_direction?>" name="trade_direction" />
                                <input type="hidden" value="<?=$app->commodity_code?>" name="commodity_code" />
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