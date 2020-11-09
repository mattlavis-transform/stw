<?php
require 'vendor/autoload.php';

use Doctrine\Inflector\InflectorFactory;

class document_code
{
    public $code;

    public function __construct()
    {
        $this->code = null;
        $this->certificate_code = null;
        $this->certificate_type_code = null;
        $this->description = null;
        $this->instance_count = 0;
        $this->threshold_quantity = null;
        $this->threshold_unit = null;
        $this->is_threshold = false;
        $this->condition_codes = array();
        $this->classification = ""; // Options are 00. Threshold; 01. Certificate; 02. Exception
    }

    public function classify()
    {
        global $app;
        if ($this->is_threshold) {
            $this->classification = "00. Threshold";
        } elseif ((substr($this->code, 0, 1) == "Y") || (in_array($this->code, $app->codes_that_are_really_exemptions))) {
            $this->classification = "02. Exception";
        } else {
            $this->classification = "01. Certificate";
        }
    }

    public function get_certificate_json($is_pair = false)
    {
        global $app;

        # Get the step text associated with the document code
        $s = "<li>";
        //$s = "<li>" . $app->conjunction . " / " . $this->classification;
        if (!$this->is_threshold) {
            $overlay = $app->get_file($app->certificate_content_folder, $this->code, "json");
            if ($overlay != "") {
                $json_obj = json_decode($overlay, true);
                $tmp = $app->get_fallback($json_obj, "step_description");
                if ($app->conjunction != "") {
                    $step_description = $app->conjunction . lcfirst($tmp);
                } else {
                    $step_description = $tmp;
                }
                $step_howto_description = $app->get_fallback($json_obj, "step_howto_description");
                $step_url = $app->get_fallback($json_obj, "step_url");
                $step_get_text = $app->get_fallback($json_obj, "step_get_text");

                $s .= "<p class='govuk-body step_description'>";

                $s .= $step_description;

                $s .= "<span class='info'>Condition " . $this->code . "</span></p>";
                $s .= "<div class='govuk-inset-text'>";
                if ($step_howto_description != "") {
                    $s .= $step_howto_description . "<br>";
                }
                $s .= "Enter <strong>" . $this->code . "</strong> in Box 44 of your import declaration."; // . $this->classification;
                $s .= "<span class='info'>Hint text " . $this->code . "</span>";
                if ($step_url != "") {
                    $s .= '<div class="step_url"><a target="_blank" href="' . $step_url . '">' . $step_get_text . '</a></div>';
                }
                $s .= "</div>";
                $app->conjunction = "";
            } else {
                $s = strtoupper($this->code) . " text would go here.";
            }

            $s = str_replace("  ", " ", $s);
            $s = rtrim($s);
        } else {
            // Threshold blocks
            if ($is_pair) {
                if ($app->has_shown_unless) {
                    $template = "or, if your goods {{verb}} {{qty}} {{unit}} or less<span class='info'>" . $this->code . "</span><br><br>";
                } else {
                    $template = "Unless your goods {{verb}} {{qty}} {{unit}} or less<span class='info'>" . $this->code . "</span><br><br>";
                    $app->has_shown_unless = true;
                }
            } else {
                $template = "If your goods {{verb}} {{qty}} {{unit}} or less<span class='info'>" . $this->code . "</span><br><br>";
            }
            $find = array_search($this->threshold_unit, array_column($app->threshold_units, 'unit'));
            $verb = $app->threshold_units[$find]["verb"];
            $template = str_replace("{{verb}}", $verb, $template);
            $template = str_replace("{{qty}}", $this->threshold_quantity, $template);

            $inflector = InflectorFactory::create()->build();
            $units = $inflector->pluralize($this->threshold_unit);

            $template = str_replace("{{unit}}", $units, $template);

            $s .= '<p class="govuk-body step_description">';
            $s .= $template;
            $s .= '</p>';
            if ($is_pair) {
                $app->conjunction = "";
            } else {
                $s .= '<div class="govuk-inset-text">No action is required.</div>';
                $app->conjunction = "Otherwise, ";
            }
        }
        $s .= "</li>";
        if ($is_pair) {
            $s = str_replace("<li>", "", $s);
            $s = str_replace("</li>", "", $s);
        }
        return ($s);
    }
}

class dc_pair
{
    public function __construct()
    {
        $this->codes = array();
    }
}
