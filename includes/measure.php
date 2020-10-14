<?php
require("includes/measure_condition.php");
require("includes/document_code.php");

class measure
{
    public $measure_sid;
    public $measure_type_id;
    public $measure_type_description;
    public $measure_type_overlay;
    public $measure_type_series_id;
    public $geographical_area_id;
    public $geographical_area_description;
    public $effective_start_date;
    public $effective_end_date;
    public $excluded_countries = [];
    public $exclusions = "";
    public $measure_conditions = [];
    public $members = [];
    public $relevant;

    public function __construct($json, $included)
    {
        global $app;

        $this->json = $json;
        $this->included = $included;
        $this->measure_sid = $this->json["id"];
        $this->effective_start_date = $this->json["attributes"]["effective_start_date"];
        $this->effective_end_date = $this->json["attributes"]["effective_end_date"];

        $this->get_measure_type();
        $this->get_geographical_area();
        $this->get_excluded_countries();
        $this->relevant = $this->applies_to_country($app->country);

        if ($this->relevant) {
            $this->get_measure_conditions();
        }
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
                $this->measure_type_series_id = $included_item["attributes"]["measure_type_series_id"];
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
                $measure_condition = new measure_condition($this->measure_sid, $measure_condition, $this->included);
                array_push($this->measure_conditions, $measure_condition);
            }
        }
    }

    public function valid_measure_type()
    {
        $valid_array = array("A", "B");
        if (in_array($this->measure_type_series_id, $valid_array)) {
            return (true);
        } else {
            return (false);
        }
    }

    public function applies_to_country($country)
    {
        $the_eu = array("FR", "DE", "NL", "BE");
        if (in_array($country, $the_eu)) {
            $country = "EU";
        }
        if (strlen($this->geographical_area_id) == 4) {
            // This is a country group
            $applies = false;
            if (in_array($country, $this->members)) {
                if (!in_array($country, $this->excluded_countries)) {
                    $applies = true;
                }
            }
        } else {
            // This is a country
            if ($this->geographical_area_id == $country) {
                $applies = true;
            } else {
                $applies = false;
            }
        }
        return ($applies);
    }

    public function get_phrase()
    {
        global $app;

        // Start of dummy code
        //pre($this->measure_sid . ", " . $this->measure_type_description . ", " . $this->measure_type_series_id);
        
        # Base the output on the measure template
        $output = $app->template_measure;
        # check to see if there is any copy to overlay the title of the measure type
        # if so, then use it, otherwu=ise use the measure type description itslg
        $this->get_measure_type_overlay();
        $output = str_replace("{{ measure_type }}", $this->measure_type_overlay, $output);

        $this->condition_code_groups = array();
        $this->document_codes = array();

        # For this measure (and all mesaures), loop through each of the measure conditions
        foreach ($this->measure_conditions as $mc) {
            if ($mc->positive) {
                
                # If the measure condition is positive, then continue ...
                array_push($this->condition_code_groups, $mc->condition_code);
                $dc = new document_code();

                # Where the condition is positive and there is no document code, this is a threshold condition
                # These threshold data have already been retrieved from the measure condition look
                if ($mc->document_code == "") {
                    //h1 ("Threshold");
                    $dc->is_threshold = true;
                    $dc->threshold_quantity = $mc->threshold_quantity;
                    $dc->threshold_unit = $mc->threshold_unit;
                    $dc->code = "<= " . $mc->threshold_quantity . " " . $mc->threshold_unit;
                } else {
                    //h1 ("Standard");
                    $dc->code = $mc->document_code;
                    $dc->requirement = $mc->requirement;
                }

                # We need an atomic list of the individual condition codes
                # to see if this a complex measure with multiple measure condition groups
                # List of document_codes should list unique codes only, and for each of these, list the condition groups
                # to which they belong
                $found = false;
                foreach ($this->document_codes as $existing) {
                    if ($existing->code == $dc->code) {
                        $found = true;
                        $existing->instance_count += 1;
                        array_push($existing->condition_codes, $mc->condition_code);
                        break;
                    }
                }

                if ($found == false) {
                    $dc->instance_count = 1;
                    array_push($dc->condition_codes, $mc->condition_code);
                    array_push($this->document_codes, $dc);
                }
            }
        }
        //pre ($this->document_codes);

        $this->condition_code_groups = set($this->condition_code_groups);
        $this->condition_code_group_count = count($this->condition_code_groups);
        //pre ($this->condition_code_groups);

        # Sort the mesaure condition groups into alphabetical order
        # This does not seem to work at the moment, but the items do tend to be in the right order anyway
        if ($this->condition_code_group_count > 1) {
            usort($this->document_codes, 'document_code_sorter');
        }
        //pre ($this->condition_code_groups);


        #############################################
        # Get explainer text
        #############################################
        $explainer_text = "You must fulfil one of the following conditions:";
        $output = str_replace("{{ explainer }}", $explainer_text, $output);

        #############################################
        # Get conditions
        #############################################
        $conditions_text = "";

        # In this block, display the content associated with document codes
        # that are common to each of the condition group blocks
        # Where there are non-common pairs, these are echoed below
        foreach ($this->document_codes as $dc) {
            if ($dc->instance_count == $this->condition_code_group_count) {
                $conditions_text .= $dc->get_certificate_json();
            }
        }

        if ($this->condition_code_group_count > 1) {
            # need a matrix of all non-shared conditions against each other
            $dcs = array();

            foreach ($this->document_codes as $dc) {
                if ($dc->instance_count != $this->condition_code_group_count) {
                    array_push($dcs, $dc);
                }
            }

            $dc_count = count($dcs);
            $pairs = array();

            for ($i = 0; $i < $dc_count - 1; $i++) {
                for ($j = $i + 1; $j < $dc_count; $j++) {
                    $pair = new dc_pair();
                    array_push($pair->codes, $dcs[$i]);
                    array_push($pair->codes, $dcs[$j]);
                    array_push($pairs, $pair);
                }
            }


            /*
            # Your goods weigh no more than 2.00 kg and are exempted from the regulation by being
            # intended for personal use and are a part of your personal luggage.
            # Enter Y058 on your import declaration
            */

            foreach ($pairs as $p) {
                foreach ($p->codes as $dc) {
                    $conditions_text .= $dc->get_certificate_json();
                }
            }

            $output = str_replace("{{ conditions }}", $conditions_text, $output);
        }

        if ($this->measure_sid == 3717676) {
            echo ($output);
        }
        //pre ($this->measure_conditions);
    }

    public function get_measure_type_overlay()
    {
        global $app;
        $overlay = $app::get_file($app->measure_type_content_folder, $this->measure_type_id);
        if ($overlay == "") {
            $this->measure_type_overlay = $this->measure_type_description;
        } else {
            $this->measure_type_overlay = $overlay;
        }
    }
}
