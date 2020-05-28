<?php
class measure_condition
{
    public $id;
    public $measure_id;
    public $condition_code;
    public $condition;
    public $document_code;
    public $requirement;
    public $action;
    public $duty_expression;
    public $measures = [];
    //public $measure_type_id = "";
    //public $measure_type_description = "";

    public function __construct($json, $included)
    {
        $this->json = $json;
        $this->included = $included;
        $this->id = $this->json["id"];
        $this->get_measure_condition();
        $this->json = null;
        $this->included = null;
    }

    public function get_measure_condition()
    {
        foreach ($this->included as $included_item) {
            if (($included_item["id"] == $this->id) && ($included_item["type"] == "measure_condition")) {

                $this->condition_code = $included_item["attributes"]["condition_code"];
                $this->condition = $included_item["attributes"]["condition"];
                $this->document_code = $included_item["attributes"]["document_code"];
                $this->requirement = $included_item["attributes"]["requirement"];
                $this->action = $included_item["attributes"]["action"];
                $this->duty_expression = $included_item["attributes"]["duty_expression"];

                break;
            }
        }
    }
}
