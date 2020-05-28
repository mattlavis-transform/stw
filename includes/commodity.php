<?php
require("includes/measure.php");

class commodity
{
    public $commodity_code;
    public $description;
    public $number_indents;
    public $productline_suffix;
    public $declarable;
    public $measures = [];
    public $unique_document_codes = [];
    public $unique_conditions = [];

    public function __construct($commodity_code, $json)
    {
        $this->json = $json;
        $this->commodity_code = $commodity_code;
        $this->productline_suffix = $this->json["data"]["attributes"]["producline_suffix"];
        $this->number_indents = $this->json["data"]["attributes"]["number_indents"];
        $this->description = $this->json["data"]["attributes"]["formatted_description"];
        $this->declarable = $this->json["data"]["attributes"]["declarable"];

        $this->get_ancestors();
        $this->get_measures();
    }

    public function get_ancestors()
    {
    }

    public function get_measures()
    {
        global $app;
        try {
            if ($app->trade_direction == "importing") {
                $measures = $this->json["data"]["relationships"]["import_measures"]["data"];
            } else {
                $measures = $this->json["data"]["relationships"]["export_measures"]["data"];
            }
            
        } catch (exception $e) {
            $measures = [];
        }

        $included = $this->json["included"];

        foreach ($measures as $measure) {
            foreach ($included as $included_item) {
                if ($included_item["id"] == $measure["id"]) {
                    $measure = new measure($included_item, $included);
                    //pre ($measure->id);
                    array_push($this->measures, $measure);
                    break;
                }
            }
        }

        $this->rationalise_document_codes();
    }

    function rationalise_document_codes()
    {
        global $app;

        foreach ($this->measures as $measure) {
            foreach ($measure->measure_conditions as $measure_condition) {
                $document_code = $measure_condition->document_code;
                if (!in_array($measure->measure_type_id, $app->excluded_measure_types )) {
                    if ($measure->applies_to_country($app->country)) {
                        if ($document_code != "") {
                            if (!in_array($document_code, $this->unique_document_codes)) {
                                array_push($this->unique_document_codes, $document_code);
                                array_push($this->unique_conditions, $measure_condition);
                                array_push($measure_condition->measures, $measure);
                            }
                        }
                    }
                }
            }
        }
    }
}
