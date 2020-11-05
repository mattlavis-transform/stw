<?php

use Inflect\Inflect;

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
    }

    public function get_certificate_json($is_pair = false)
    {
        global $app;

        # Get the step text associated with the document code
        $s = "<li>";
        if (!$this->is_threshold) {
            $overlay = $app->get_file($app->certificate_content_folder, $this->code, "json");
            if ($overlay != "") {
                $json_obj = json_decode($overlay, true);
                $step_description = $json_obj["step_description"];
                $step_howto_description = $json_obj["step_howto_description"];
                $step_url = $json_obj["step_url"];
                $s .= "<p class='govuk-body step_description'>";
                if ($step_url != "") {
                    $s .= '<a target="_blank" href="' . $step_url . '">';
                }

                $s .= $step_description;

                if ($step_url != "") {
                    $s .= "</a><span class='info'>Step / URL " . $this->code . "</span>";
                } else {
                    $s .= "<span class='info'>Step " . $this->code . "</span>";
                }
                $s .= "</p>";
                $s .= "<div class='govuk-inset-text'>" . $step_howto_description;
                $s .= " Enter <strong>" . $this->code . "</strong> on your import declaration.";
                $s .= "<span class='info'>Hint text " . $this->code . "</span></div>";
            } else {
                $s = strtoupper($this->code) . " text would go here.";
            }

            $s = str_replace("  ", " ", $s);
            $s = rtrim($s);
        } else {
            $template = "If your goods {{verb}} no more than {{qty}} {{unit}}<span class='info'>" . $this->code . "</span>";
            //$template = "Your goods {{verb}} no more than {{qty}} {{unit}}<span class='info'>" . $this->code . "</span>";
            $find = array_search($this->threshold_unit, array_column($app->threshold_units, 'unit'));
            $verb = $app->threshold_units[$find]["verb"];

            $s .= str_replace("{{verb}}", $verb, $template);
            $s = str_replace("{{qty}}", $this->threshold_quantity, $s);

            $s = str_replace("{{unit}}", $this->threshold_unit, $s);
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
