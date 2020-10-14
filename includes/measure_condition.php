<?php
class measure_condition
{
    public $measure_condition_sid;
    public $measure_sid;
    public $condition_code;
    public $condition;
    public $document_code;
    public $requirement;
    public $action;
    public $duty_expression;
    public $positive;
    //public $measures = [];

    public function __construct($measure_sid, $json, $included)
    {
        $this->measure_sid = $measure_sid;
        $this->json = $json;
        $this->included = $included;
        $this->measure_condition_sid = $this->json["id"];
        $this->get_measure_condition_detail();
        $this->json = null;
        $this->included = null;
    }

    public function get_measure_condition_detail()
    {
        foreach ($this->included as $included_item) {
            if (($included_item["id"] == $this->measure_condition_sid) && ($included_item["type"] == "measure_condition")) {
                $this->condition_code = $included_item["attributes"]["condition_code"];
                $this->condition = $included_item["attributes"]["condition"];
                $this->document_code = $included_item["attributes"]["document_code"];
                $this->requirement = $included_item["attributes"]["requirement"];
                $this->action = $included_item["attributes"]["action"];
                $this->duty_expression = $included_item["attributes"]["duty_expression"];
                $this->lookup_action_code();
                $this->get_type();

            break;
            }
        }
    }

    public function lookup_action_code()
    {
        global $app;
        if (($this->action == null) || ($this->action == "")) {
            $this->positive = true;
        } else {
            foreach ($app->measure_action_codes as $item) {
                if ($item["description"] == $this->action) {
                    $this->action_code = $item["action_code"];
                    $this->positive = $item["positive"];
                    break;
                }
            }
        }

        //pre($this->measure_sid . " : " . $this->measure_condition_sid . " : " . $this->action . " : " . $this->positive);
    }

    public function get_type()
    {
        $this->condition_type = "document";
        $potential_threshold_conditions = array('E', 'I');
        if (in_array($this->condition_code, $potential_threshold_conditions)) {
            if ($this->positive) {
                if ($this->document_code == "") {
                    $this->condition_type = "threshold";
                    $this->get_threshold();
                }
            }
        }
    }

    public function get_threshold()
    {
        $this->threshold_quantity = null;
        $this->threshold_unit = null;
        if ($this->requirement == "") {
            pre($this);
        }
        $this->requirement = str_replace("\u003c", "<", $this->requirement);
        $this->requirement = str_replace("\u003e", ">", $this->requirement);
        //pre ("A" . $this->requirement. "B");

        // <span title='2.0 '>2.00</span> <abbr title='Kilogram'>kg</abbr>

        $pattern = "~span title='(.+) '>.+</span> <abbr title='(.+)'>.+</abbr>~";
        preg_match($pattern, $this->requirement, $matches);
        //pre ($matches);

        if (count($matches) > 1) {
            $this->threshold_quantity = $matches[1];
        }
        if (count($matches) > 2) {
            $this->threshold_unit = $matches[2];
        }
        //pre("Debug get_threshold : " . $this->requirement . " : " . $this->threshold_quantity . " : " . $this->threshold_unit);
    }
}
