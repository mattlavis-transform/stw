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
        $this->suppress = "";

       
    }

    public function get_data() {
        global $app;
        $overlay = $app->get_file($app->certificate_content_folder, $this->code, "json");
        $json_obj = json_decode($overlay, true);
        $this->question_option_text = $app->get_fallback($json_obj, "question_option_text");
        $this->question_option_hint_text = $app->get_fallback($json_obj, "question_option_hint_text");
        $this->document_code_type_override = $app->get_fallback($json_obj, "document_code_type_override");
        $this->suppress = $app->get_fallback($json_obj, "suppress");
    }

    public function classify()
    {
        $this->get_data();
        global $app;
        if ($this->is_threshold) {
            $this->classification = "00. Threshold";
            $this->get_threshold_verb();
        } else {
            if ($this->document_code_type_override != "") {
                $this->classification = $this->document_code_type_override;
            } else {
                if (substr($this->code, 0, 1) == "Y") {
                    $this->classification = "02. Exception";
                } else {
                    $this->classification = "01. Certificate";
                }
            }
        }
    }

    public function get_threshold_verb() {
        global $app;
        $find = array_search($this->threshold_unit, array_column($app->threshold_units, 'unit'));
        $this->verb = $app->threshold_units[$find]["verb"];
        $this->unit_display = $app->threshold_units[$find]["unit_display"];
        $this->question_option_text = "Your goods " . $this->verb . " " . $this->threshold_quantity . " " . $this->unit_display . " or less";
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
                $s .= "<span class='boilerplate'>Enter </span><strong>" . $this->code . "</strong> <span class='boilerplate'>in Box 44 of your import declaration.</span>"; // . $this->classification;
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
                    $template = "<span class='boilerplate'>or, if your goods </span>{{verb}} {{qty}} {{unit}} <span class='boilerplate'>or less</span><span class='info'>" . $this->code . "</span><br><br>";
                } else {
                    $template = "<span class='boilerplate'>Unless your goods </span>{{verb}} {{qty}} {{unit}} <span class='boilerplate'>or less</span><span class='info'>" . $this->code . "</span><br><br>";
                    $app->has_shown_unless = true;
                }
            } else {
                $template = "<span class='boilerplate'>If your goods </span>{{verb}} {{qty}} {{unit}} <span class='boilerplate'>or less</span><span class='info'>" . $this->code . "</span><br><br>";
            }
            $find = array_search($this->threshold_unit, array_column($app->threshold_units, 'unit'));
            $verb = $app->threshold_units[$find]["verb"];
            $template = str_replace("{{verb}}", $verb, $template);
            $template = str_replace("{{qty}}", $this->threshold_quantity, $template);

            $inflector = InflectorFactory::create()->build();
            //$units = $inflector->pluralize($this->threshold_unit);
            $units = $this->threshold_unit;

            $template = str_replace("{{unit}}", $units, $template);

            $s .= '<p class="govuk-body step_description">';
            $s .= $template;
            $s .= '</p>';
            if ($is_pair) {
                $app->conjunction = "";
            } else {
                $s .= '<div class="govuk-inset-text"><span class="boilerplate">No action is required.</span></div>';
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
