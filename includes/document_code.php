<?php
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

    public function get_certificate_json()
    {
        global $app;

        # Get the step text associated with the document code
        $s = "<li>";
        if (!$this->is_threshold) {
            $overlay = $app::get_file($app->certificate_content_folder, $this->code, ".json");
            if ($overlay != "") {
                $json_obj = json_decode($overlay, true);
                $step_description = $json_obj["step_description"];
                $step_howto_description = $json_obj["step_howto_description"];
                $step_url = $json_obj["step_url"];
                $s .= "<p class='govuk-body' style='margin-bottom:0.5em'>";
                if ($step_url != "") {
                    $s .= '<a target="_blank" href="' . $step_url . '">';
                }

                $s .= $step_description;

                if ($step_url != "") {
                    $s .= '</a>';
                }
                $s .= "</p>";
                $s .= "<p class='govuk-body govuk-hint'>" . $step_howto_description;
                $s .= " <br>Enter <strong>" . $this->code . "</strong> on your import declaration.";
                $s .= "</p>";
            } else {
                $s = strtoupper($this->code) . " text would go here.";
            }

            $s = str_replace("  ", " ", $s);
            $s = rtrim($s);
            
        } else {
            //pre($app->threshold_units);
            /*
            $template = "Your goods {{verb}} no more than {{qty}} {{unit}}";
            index = units_to_verb[$this->threshold_unit]
            s = template.replace("{{verb}}", index)
            s = s.replace("{{qty}}", $this->threshold_quantity)

            p = inflect.engine()

            s = s.replace("{{unit}}", p.plural($this->threshold_unit))
            return s
            */
        }
        $s .= "</li>";
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
