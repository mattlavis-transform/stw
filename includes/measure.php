<?php
require("includes/measure_condition.php");

class measure
{
    public $id;
    public $measure_type_id;
    public $measure_type_description;
    public $geographical_area_id;
    public $geographical_area_description;
    public $effective_start_date;
    public $effective_end_date;
    public $excluded_countries = [];
    public $exclusions = "";
    public $measure_conditions = [];
    public $members = [];

    public function __construct($json, $included)
    {
        $this->json = $json;
        $this->included = $included;
        $this->id = $this->json["id"];
        $this->effective_start_date = $this->json["attributes"]["effective_start_date"];
        $this->effective_end_date = $this->json["attributes"]["effective_end_date"];

        $this->get_measure_type();
        $this->get_geographical_area();
        $this->get_excluded_countries();
        $this->get_measure_conditions();
        $this->json = null;
        $this->included = null;
    }

    function get_measure_type()
    {
        $this->measure_type_id = $this->json["relationships"]["measure_type"]["data"]["id"];
        $this->get_measure_type_description();
    }

    function get_geographical_area()
    {
        $this->geographical_area_id = $this->json["relationships"]["geographical_area"]["data"]["id"];
        if (strlen($this->geographical_area_id) == 4) {
            $this->get_geographical_area_members();
        }
        $this->get_geographical_area_description();
    }

    function get_geographical_area_members()
    {
        foreach ($this->included as $included_item) {
            if ($included_item["id"] == $this->geographical_area_id) {
                if ($included_item["type"] == "geographical_area") {
                    $members = $included_item["relationships"]["children_geographical_areas"]["data"];
                    foreach ($members as $member) {
                        array_push($this->members, $member["id"]);
                    }
                    //pre ($this->members);
                    break;
                }
            }
        }
    }

    function get_excluded_countries()
    {
        $excluded_countries = $this->json["relationships"]["excluded_countries"]["data"];
        foreach ($excluded_countries as $exclusion) {
            array_push($this->excluded_countries, $exclusion["id"]);
        }

        $this->exclusions = "";
        foreach ($this->excluded_countries as $exclusion) {
            //pre ($exclusion);
            $this->exclusions .= $exclusion . ", ";
        }
        $this->exclusions = rtrim($this->exclusions);
        $this->exclusions = rtrim($this->exclusions, ",");
    }

    function get_measure_type_description()
    {
        foreach ($this->included as $included_item) {
            if ($included_item["id"] == $this->measure_type_id) {
                $this->measure_type_description = $included_item["attributes"]["description"];
                //h1("found measure type " . $this->measure_type_description);
                break;
            }
        }
    }

    function get_geographical_area_description()
    {
        foreach ($this->included as $included_item) {
            if ($included_item["id"] == $this->geographical_area_id) {
                $this->geographical_area_description = $included_item["attributes"]["description"];
                //h1("found geo desc " . $this->geographical_area_description);
                break;
            }
        }
    }

    function get_measure_conditions()
    {
        $measure_conditions = $this->json["relationships"]["measure_conditions"]["data"];
        if (count($measure_conditions) > 0) {
            foreach ($measure_conditions as $measure_condition) {
                $measure_condition = new measure_condition($measure_condition, $this->included);
                array_push($this->measure_conditions, $measure_condition);
            }
        }
    }

    public function applies_to_country($country)
    {
        if (strlen($this->geographical_area_id) == 4) {
            // This is a country group
            $applies = false;
            if (in_array($country, $this->members)) {
                if (!in_array($country, $this->excluded_countries)) {
                    $applies = true;
                }
            }
            return ($applies);
        } else {
            // This is a country
            if ($this->geographical_area_id == $country) {
                return (true);
            } else {
                return (false);
            }
        }
    }
}
