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

    public function __construct($json, $included)
    {
        //pre($json);
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
                //pre ($included_item);

                $this->condition_code = $included_item["attributes"]["condition_code"];
                $this->condition = $included_item["attributes"]["condition"];
                $this->document_code = $included_item["attributes"]["document_code"];
                $this->requirement = $included_item["attributes"]["requirement"];
                $this->action = $included_item["attributes"]["action"];
                $this->duty_expression = $included_item["attributes"]["duty_expression"];

                //h1("found measure condition " . $included_item["id"]);
                break;
            }
        }
    }
}
