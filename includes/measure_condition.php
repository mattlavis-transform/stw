<?php
class measure_condition
{
    public $measure_condition_sid;
    public $measure_sid;
    public $condition_code;
    public $condition;
    public $document_code;
    public $certificate_type_code = "";
    public $certificate_code = "";
    public $requirement;
    public $action;
    public $duty_expression;
    public $positive;

    public function __construct($measure_sid, $json, $included)
    {
        $this->measure_sid = $measure_sid;
        $this->json = $json;
        $this->included = $included;
        $this->measure_condition_sid = $this->json["id"];
        $this->get_measure_condition_detail();
        $this->json = null;
        $this->included = null;
        $this->code_split();
    }

    public function code_split()
    {
        if (strlen($this->document_code) == 4) {
            $this->certificate_type_code = substr($this->document_code, 0, 1);
            $this->certificate_code = substr($this->document_code, 1, 3);
        } else {
            $this->certificate_type_code = "";
            $this->certificate_code = "";
        }
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
        $this->requirement = str_replace("\u003c", "<", $this->requirement);
        $this->requirement = str_replace("\u003e", ">", $this->requirement);
        //$pattern = "~span title='(.+) '>.+</span> <abbr title='(.+)'>.+</abbr>~";
        $pattern = "~span>(.+)</span> <abbr title='(.+)'>.+</abbr>~";
        preg_match($pattern, $this->requirement, $matches);
        if (count($matches) > 1) {
            $this->threshold_quantity = $matches[1];
        }
        if (count($matches) > 2) {
            $this->threshold_unit = $matches[2];
        }
    }
}
