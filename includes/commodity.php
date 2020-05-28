<?php
require("includes/measure.php");

class commodity
{
    public $commodity_code;
    public $description;
    public $number_indents;
    public $productline_suffix;
    public $declarable;
    public $import_measures = [];
    public $export_measures = [];
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
        $this->get_import_measures();
    }

    public function get_ancestors()
    {
    }

    public function get_import_measures()
    {
        try {
            $import_measures = $this->json["data"]["relationships"]["import_measures"]["data"];
        } catch (exception $e) {
            $import_measures = [];
        }

        $included = $this->json["included"];

        foreach ($import_measures as $import_measure) {
            foreach ($included as $included_item) {
                if ($included_item["id"] == $import_measure["id"]) {
                    $measure = new measure($included_item, $included);
                    //pre ($measure->id);
                    array_push($this->import_measures, $measure);
                    break;
                }
            }
        }

        $this->rationalise_document_codes();
    }

    function rationalise_document_codes()
    {
        global $app;

        foreach ($this->import_measures as $import_measure) {
            foreach ($import_measure->measure_conditions as $measure_condition) {
                //pre ($measure_condition);
                $document_code = $measure_condition->document_code;
                //h1 ($document_code . " : " . $import_measure->measure_type_id);
                if (!in_array($import_measure->measure_type_id, $app->excluded_measure_types )) {
                    if ($import_measure->applies_to_country($app->country)) {
                        if ($document_code != "") {
                            if (!in_array($document_code, $this->unique_document_codes)) {
                                array_push($this->unique_document_codes, $document_code);
                                array_push($this->unique_conditions, $measure_condition);
                                array_push($measure_condition->measures, $import_measure);
                            }
                        }
                    }
                }
            }
        }
        //pre($this->unique_document_codes);
    }
}
