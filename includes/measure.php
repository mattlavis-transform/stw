<?php
require 'vendor/autoload.php';

require("includes/measure_condition.php");
require("includes/question_option.php");
require("includes/document_code.php");

use Doctrine\Inflector\InflectorFactory;

class measure
{
    public $measure_sid;
    public $measure_type_id;
    public $measure_type_description;
    public $measure_type_overlay = "";
    public $measure_type_desc = "";
    public $measure_type_sub_text = "";
    public $order_number = null;
    public $additional_code = null;
    public $additional_code_code = null;
    public $additional_code_description = null;
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

    public $caption_text = "";
    public $question_text = "";

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
        $this->get_order_number();
        $this->get_additional_code();
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

    function get_order_number()
    {
        //error_reporting(0);
        $this->order_number = Null; // $this->json["relationships"]["order_number"]["data"]["id"];
        error_reporting(E_ALL);
    }

    function get_additional_code()
    {
        //error_reporting(0);
        $this->additional_code = Null; // $this->json["relationships"]["additional_code"]["data"]["id"];
        error_reporting(E_ALL);
        if ($this->additional_code != null) {
            $this->get_additional_code_detail();
        }
    }

    function get_additional_code_detail()
    {
        foreach ($this->included as $included_item) {
            if ($included_item["id"] == $this->additional_code) {
                if ($included_item["type"] == "additional_code") {
                    $this->additional_code_code = $included_item["attributes"]["code"];
                    $this->additional_code_description = $included_item["attributes"]["formatted_description"];
                    break;
                }
            }
        }
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
                break;
            }
        }
    }

    function get_geographical_area_description()
    {
        foreach ($this->included as $included_item) {
            if ($included_item["id"] == $this->geographical_area_id) {
                $this->geographical_area_description = $included_item["attributes"]["description"];
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

    public function valid_measure_type($include, $measure_types)
    {
        $excluded = array("481", "482", "483", "485");
        if (in_array($this->measure_type_id, $excluded)) {
            return (false);
        }
        if ($measure_types == "") {
            $measure_type_series_ids = str_split($include, 1);
            if (in_array($this->measure_type_series_id, $measure_type_series_ids)) {
                return (true);
            } else {
                return (false);
            }
        } else {
            $measure_types = explode(",", $measure_types);
            if (in_array($this->measure_type_id, $measure_types)) {
                return (true);
            } else {
                return (false);
            }
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

    public function order_number_formatted()
    {
        if ($this->order_number == null) {
            return "";
        } else {
            return substr($this->order_number, 0, 2) . "." . substr($this->order_number, 2, 4);
        }
    }

    public function count_exemptions_and_documents()
    {
        global $app;
        $tmp = array();
        // First, go through and deduplicate
        foreach ($this->measure_conditions as $mc) {
            $mc->code_split();
            if ($mc->document_code . "" != "") {
                if (!in_array($mc->document_code, $tmp)) {
                    array_push($tmp, $mc->document_code);
                }
            }
        }

        // Counts the instances where there is a condition with code type Y
        $this->exemption_count = 0;
        $this->document_count = 0;

        foreach ($tmp as $dc) {
            // Any document code that has a "Y" at the start is an exemption
            if (substr($dc, 0, 1) == "Y") {
            // if ((substr($dc, 0, 1) == "Y") || (in_array($dc, $app->codes_that_are_really_exemptions))) {
                $this->exemption_count += 1;
            } else {
                $this->document_count += 1;
            }
        }
    }

    public function check_multiple_positive_conditions()
    {
        $positive_count = 0;
        foreach ($this->measure_conditions as $mc) {
            if ($mc->positive == 1) {
                $positive_count += 1;
            }
        }

        h1("Found " . $positive_count . " positives on measure " . $this->measure_sid);
        if ($positive_count > 1) {
            return (true);
        } else {
            return (false);
        }
    }

    public function get_question_overlay()
    {
        global $app;
        $overlay = $app->get_file($app->measure_type_content_folder, $this->measure_type_id, "json");
        $json_obj = json_decode($overlay, true);
        $this->caption_text = $app->get_fallback($json_obj, "caption");
        $this->caption_text = str_replace("{{ country }}", $app->country_description, $this->caption_text);
        $this->question_text = $app->get_fallback($json_obj, "question");
    }

    public function display_measure_question()
    {
        global $app;
        if (count($this->question_options) < 2) {
            return;
        }

        # Get the question, question option and question option hint template
        $output = $app->template_question;
        $template_qo = $app->template_question_option;
        $template_qoh = $app->template_question_option_hint;

        $output = str_replace("{{ caption }}", $this->caption_text, $output);
        $output = str_replace("{{ question }}", $this->question_text, $output);
        $this->question_options_text = "";
        foreach ($this->question_options as $question_option) {
            $option = str_replace("{{ value }}", $question_option->value, $template_qo);
            $option = str_replace("{{ text }}", $question_option->text, $option);
            $option = str_replace("{{ classification }}", $question_option->classification, $option);
            if ($question_option->hint_text != null) {
                $option = str_replace("{{ hint }}", $template_qoh, $option);
                $option = str_replace("{{ hint }}", $question_option->hint_text, $option);
            } else {
                $option = str_replace("{{ hint }}", "", $option);
            }
            $this->question_options_text .= $option;
        }
        $output = str_replace("{{ question_options }}", $this->question_options_text, $output);
        $output = str_replace("{{ measure_type }}", $this->measure_type_id, $output);

        echo ($output);
    }

    public function get_measure_question()
    {
        $this->get_question_overlay();
        error_reporting(-1);
        global $app;

        if (count($this->measure_conditions) == 0) {
            return;
        }

        $this->condition_code_groups = array();
        $this->document_codes = array();

        # Loop through each of this measure's measure conditions
        $this->threshold_count = 0;
        foreach ($this->measure_conditions as $mc) {
            if ($mc->positive) {

                # If the measure condition is "positive", then continue ...
                array_push($this->condition_code_groups, $mc->condition_code);
                $dc = new document_code();

                # Where the condition is positive and there is no document code, this is a threshold condition
                # These threshold data have already been retrieved from the measure condition look
                if ($mc->document_code == "") {
                    $this->threshold_count += 1;
                    $dc->is_threshold = true;
                    $dc->threshold_quantity = $mc->threshold_quantity;
                    $dc->threshold_unit = $mc->threshold_unit;
                    $dc->code = "<= " . $mc->threshold_quantity . " " . $mc->threshold_unit;
                } else {
                    $dc->code = $mc->document_code;
                    $dc->certificate_code = $mc->certificate_code;
                    $dc->certificate_type_code = $mc->certificate_type_code;
                    $dc->requirement = $mc->requirement;
                }
                $dc->classify();

                if ($dc->suppress == "") {
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
        }

        $this->condition_code_groups = set($this->condition_code_groups);
        $this->condition_code_group_count = count($this->condition_code_groups);

        # Sort the measure condition groups into alphabetical order
        if ($this->condition_code_group_count > 1) {
            usort($this->document_codes, 'document_code_sorter_multi_block');
        } else {
            usort($this->document_codes, 'document_code_sorter_single_block');
        }

        $this->question_options = [];
        if ($this->condition_code_group_count > 1) {

            //pre($this);
            // Get the paired items, which will be an exemption, paired with a threshold probably
            $pairs = [];
            foreach ($this->document_codes as $dc) {
                if ($dc->instance_count == 1) {
                    array_push($pairs, $dc);
                }
            }
            if (count($pairs) > 0) {
                $q = new question_option();
                $q->text = "";
                $q->value = "";
                $q->hint_text = "";
                $count = 0;
                foreach ($pairs as $pair) {
                    if ($count == 0) {
                        $add_string = $pair->question_option_text . " and ";
                    } else {
                        $add_string = lcfirst($pair->question_option_text);
                    }
                    $q->text .= $add_string;
                    $count += 1;
                }
                array_push($this->question_options, $q);
            }
            foreach ($this->document_codes as $dc) {
                if ($dc->instance_count > 1) {
                    $q = new question_option();
                    if ($dc->classification == "00. Threshold") {
                        $q->value = "threshold";
                        $q->text = "Your goods " . $dc->verb . " " . $dc->threshold_quantity . " " . $dc->unit_display . " or less";
                    } else {
                        $q->value = $dc->code;
                        $q->text = $dc->question_option_text;
                        $q->hint_text = $dc->question_option_hint_text;
                        $q->classification = $dc->classification;
                    }
                    array_push($this->question_options, $q);
                }
            }
        } else {
            foreach ($this->document_codes as $dc) {
                $q = new question_option();
                if ($dc->classification == "00. Threshold") {
                    $q->value = "threshold";
                    $q->text = "Your goods " . $dc->verb . " " . $dc->threshold_quantity . " " . $dc->unit_display . " or less";
                } else {
                    $q->value = $dc->code;
                    $q->text = $dc->question_option_text;
                    $q->hint_text = $dc->question_option_hint_text;
                    $q->classification = $dc->classification;
                }
                array_push($this->question_options, $q);
            }
        }
    }

    public function get_measure_phrase()
    {
        error_reporting(-1);
        global $app;

        if (count($this->measure_conditions) == 0) {
            return;
        }
        $this->count_exemptions_and_documents();

        # Base the output on the measure template
        $output = $app->template_measure;
        # check to see if there is any copy to overlay the title of the measure type
        # if so, then use it, otherwise use the measure type description itslg
        $this->get_measure_type_overlay();
        $output = str_replace("{{ measure_type }}", $this->measure_type_overlay . " " . $this->additional_code_description, $output);
        $output = str_replace("{{ measure_type_desc }}", $this->measure_type_desc, $output);
        $output = str_replace("{{ measure_type_id }}", $this->measure_type_id, $output);
        $output = str_replace("{{ order_number }}", $this->order_number_formatted(), $output);

        // Get additional code
        if ($this->additional_code_description == "") {
            $pattern = "~{% block additional_code_text %}.+{% endblock additional_code_text %}~simu";
            $output = preg_replace($pattern, "", $output);
        } else {
            $template = $app->template_additional_code;
            $template = str_replace("{{ additional_code }}", $this->additional_code_code, $template);
            $template = str_replace("{{ additional_code_description }}", $this->additional_code_description, $template);
            $pattern = "~{% block additional_code_text %}.+{% endblock additional_code_text %}~simu";
            $output = preg_replace($pattern, $template, $output);
        }

        // Get measure type
        if ($this->measure_type_sub_text == "") {
            $pattern = "~{% block measure_type_sub_text %}.+{% endblock %}~simu";
            $output = preg_replace($pattern, "", $output);
        } else {
            $output = str_replace("{{ measure_type_sub_text }}", $this->measure_type_sub_text, $output);
            $output = str_replace("{% block measure_type_sub_text %}", "", $output);
            $output = str_replace("{% endblock %}", "", $output);
        }

        $this->condition_code_groups = array();
        $this->document_codes = array();

        # For this measure (and all measures), loop through each of the measure conditions
        foreach ($this->measure_conditions as $mc) {
            if ($mc->positive) {

                # If the measure condition is "positive", then continue ...
                array_push($this->condition_code_groups, $mc->condition_code);
                $dc = new document_code();

                # Where the condition is positive and there is no document code, this is a threshold condition
                # These threshold data have already been retrieved from the measure condition look
                if ($mc->document_code == "") {
                    $dc->is_threshold = true;
                    $dc->threshold_quantity = $mc->threshold_quantity;
                    $dc->threshold_unit = $mc->threshold_unit;
                    $dc->code = "<= " . $mc->threshold_quantity . " " . $mc->threshold_unit;
                } else {
                    $dc->code = $mc->document_code;
                    $dc->certificate_code = $mc->certificate_code;
                    $dc->certificate_type_code = $mc->certificate_type_code;
                    $dc->requirement = $mc->requirement;
                }
                $dc->classify();

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

        $this->condition_code_groups = set($this->condition_code_groups);
        $this->condition_code_group_count = count($this->condition_code_groups);

        # Sort the measure condition groups into alphabetical order
        if ($this->condition_code_group_count > 1) {
            usort($this->document_codes, 'document_code_sorter_multi_block');
        } else {
            usort($this->document_codes, 'document_code_sorter_single_block');
        }

        #############################################
        # Get conditions
        #############################################
        $conditions_text = "";

        # In this block, display the content associated with document codes
        # that are common to each of the condition group blocks
        # Where there are non-common pairs, these are echoed below


        // Options are 00. Threshold; 01. Certificate; 02. Exception

        $app->has_shown_unless = False;
        $app->has_shown_you_need = False;
        $app->has_shown_threshold = False;

        // For all conditions / document codes that are in all of the blocks (if there is more than a single condition code block)
        // Follow this code, with all the insertions of conjunctions, as required.
        $document_code_count = count($this->document_codes);
        foreach ($this->document_codes as $dc) {
            if ($dc->instance_count == $this->condition_code_group_count) {
                if ($document_code_count > 1) {
                    switch ($dc->classification) {
                        case "01. Certificate":
                            if ($app->has_shown_you_need == False) {
                                if ($app->has_shown_threshold) {
                                    $app->conjunction = "<span class='boilerplate'>" . $app->get_phrase("otherwise_you_need") . "</span> "; // "Otherwise, you need ";
                                } else {
                                    $app->conjunction = "<span class='boilerplate'>" . $app->get_phrase("you_need") . "</span> "; // "You need ";
                                }
                            } else {
                                $app->conjunction = "or ";
                            }
                            $app->has_shown_you_need = True;
                            break;
                        case "02. Exception":
                            if ($app->has_shown_unless == False) {
                                $app->conjunction = "<span class='boilerplate'>" . $app->get_phrase("unless") . "</span> "; // "Unless ";
                            } else {
                                $app->conjunction = "<span class='boilerplate'>" . $app->get_phrase("or") . "</span> "; // "or ";
                            }
                            $app->has_shown_unless = True;
                            break;
                        case "00. Threshold":
                            $app->has_shown_threshold = true;
                            break;
                    }
                } else {
                    if ($dc->classification == "01. Certificate") {
                        $app->conjunction = "<span class='boilerplate'>You need </span>";
                    } else {
                        $app->conjunction = "";
                    }
                }

                $conditions_text .= $dc->get_certificate_json();
            }
        }

        if ($this->condition_code_group_count > 1) {
            /* Start of code that deals with multiple condition code blocks */
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

            foreach ($pairs as $p) {
                $conditions_text .= "<li class='boolean_block'>";
                $count = count($p->codes);
                $index = -1;
                foreach ($p->codes as $dc) {
                    $index += 1;
                    if ($index == 0) {
                        $app->conjunction = $app->get_phrase("or_you_provide") . " "; // "or ";
                    } else {
                        $app->conjunction = "";
                    }
                    //$conditions_text .= $dc->classification . $dc->get_certificate_json(true);
                    $conditions_text .= $dc->get_certificate_json(true);
                    if ($index < $count - 1) {
                        $conditions_text .= "<strong><em>{{ and }}</em></strong><br><br>";
                    }
                }
                $conditions_text .= "</li>";
            }
            /* End of code that deals with multiple condition code blocks */
        }

        // Common to single and multiple blocks, final amends and write to the screen.
        $output = str_replace("{{ conditions }}", $conditions_text, $output);
        $output = $this->get_translation_of_and($output);


        echo ($output);
    }

    public function get_translation_of_and($s)
    {
        global $app;
        if ($app->language == "cy") {
            //$s = str_replace("{{ and }}", "a/ac - it is a before a consonant and ac before a vowel (y and w are vowels)", $s);
            $s = str_replace("{{ and }}", "a", $s);
        } else {
            $s = str_replace("{{ and }}", "and", $s);
        }
        return ($s);
    }

    public function get_measure_type_overlay()
    {
        global $app;
        $overlay = $app->get_file($app->measure_type_content_folder, $this->measure_type_id, "json");
        if ($overlay == "") {
            $this->measure_type_overlay = $this->measure_type_description;
            $this->measure_type_sub_text = "";
        } else {
            $json_obj = json_decode($overlay, true);
            $this->measure_type_overlay = $json_obj["measure_type"][$app->language];
            $this->measure_type_sub_text = $json_obj["sub_text"][$app->language];
        }
    }

    public function get_measure_type_question_overlay()
    {
        global $app;
        $overlay = $app->get_file($app->measure_type_content_folder, $this->measure_type_id, "json");
        if ($overlay == "") {
            $this->measure_type_overlay = $this->measure_type_description;
            $this->measure_type_sub_text = "";
        } else {
            $json_obj = json_decode($overlay, true);
            $this->measure_type_overlay = $json_obj["measure_type"][$app->language];
            $this->measure_type_sub_text = $json_obj["sub_text"][$app->language];
        }
    }
}
