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
    }

    function rationalise_document_codes()
    {
        global $app;

        foreach ($this->measures as $measure) {
            foreach ($measure->measure_conditions as $measure_condition) {
                $document_code = $measure_condition->document_code;
                if (!in_array($measure->measure_type_id, $app->excluded_measure_types)) {
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

    function get_certificates($template, $include = "AB", $measure_types = "")
    {
        global $app;
        $app->certificate_count = 0;

        switch ($template) {
            case "quotas":
                $output = $app->template_quotas_intro;
                break;
            case "certificates":
                $output = $app->template_certificates_intro;
                break;
            case "prohibitions":
                $output = $app->template_prohibitions_intro;
                break;
        }
        $output = str_replace("{{ commodity }}", $app->commodity_code_formatted(), $output);
        $output = str_replace("{{ country_description }}", $app->country_description, $output);

        echo ($output);

        if ($template == "prohibitions") {
            foreach ($this->measures as $measure) {
                if ($measure->relevant) {
                    if ($measure->valid_measure_type($include, $measure_types)) {
                        if (count($measure->measure_conditions) == 0) {
                            $app->certificate_count += 1;
                        }
                    }
                }
            }
            if ($app->certificate_count > 1) {
                require("content/static/prohibitions.html");
            }
        } else {
            foreach ($this->measures as $measure) {
                if ($measure->relevant) {
                    if ($measure->valid_measure_type($include, $measure_types)) {
                        $app->certificate_count++;
                        $measure->get_measure_phrase();
                    }
                }
            }
        }
    }
}
