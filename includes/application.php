<?php
/*
use Psr\Http\Message\RequestInterface;
use \PFlorek\BasicAuth\BasicAuth;

var_dump($credentials);
*/


require("includes/commodity.php");

$app = new application();

class application
{
    // Class properties and methods go here
    public $commodity_code;
    public $trade_direction;
    public $country;
    public $country_description;
    public $measure_action_codes;

    public function __construct()
    {
        //$this->commodity_object = new commodity("", null);
        $this->trade_direction = "";
        $this->commodity_code = "";
        $this->country = "";
        $this->excluded_measure_types = array(103, 105, 115, 117, 119, 122, 123, 130, 131, 132, 133, 142, 143, 145, 146, 551, 552, 553, 554, 555, 556, 557, 558, 559, 560, 561, 562, 563);
        //$this->excluded_measure_types = [];

        if (session_id() == "") {
            session_start();
        }

        $this->commodity_object = null;
        $this->get_measure_action_codes();
        $this->get_threshold_units();
    }

    public function get_measure_action_codes()
    {
        $url = __DIR__ . "/../data/measure_action_codes.json";
        $output = file_get_contents($url);
        $json = json_decode($output, true);
        $this->measure_action_codes = $json; //["data"];
    }

    public function get_threshold_units()
    {
        $url = __DIR__ . "/../data/threshold_units.json";
        $output = file_get_contents($url);
        $json = json_decode($output, true);
        $this->threshold_units = $json; //["data"];
    }

    public function get_json()
    {
        $root = "https://www.trade-tariff.service.gov.uk/api/v2/commodities/";
        $url = $root . $this->commodity_code;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        $json = json_decode($output, true);
        curl_close($curl);

        $this->commodity_object = new commodity($this->commodity_code, $json);

        //pre ($url);
    }

    public function set_trade_direction()
    {
        $var = get_querystring("trade_direction");
        $_SESSION["trade_direction"] = $var;
        $this->trade_direction = $var;

        $this->commodity_code = $var;
        unset($_SESSION["commodity_code"]);

        $this->country = $var;
        unset($_SESSION["country"]);
    }

    public function set_commodity_code()
    {
        $this->trade_direction = $_SESSION["trade_direction"];

        $var = get_querystring("commodity_code");
        $_SESSION["commodity_code"] = $var;
        $this->commodity_code = $var;

        $this->country = $var;
        unset($_SESSION["country"]);
    }

    public function set_country()
    {
        $var = get_querystring("country");
        $var = str_replace("country:", "", $var);
        $var = str_replace("territory:", "", $var);
        $_SESSION["country"] = $var;
        $this->country = $_SESSION["country"];

        $var = get_querystring("trade_direction");
        if ($var != "") {
            $this->trade_direction = $var;
        } else {
            $this->trade_direction = $_SESSION["trade_direction"];
        }

        $var = get_querystring("commodity_code");
        if ($var != "") {
            $this->commodity_code = $var;
        } else {
            $this->commodity_code = $_SESSION["commodity_code"];
        }

        $this->get_geographical_areas();
        $this->get_json();
    }

    public function get_geographical_areas()
    {
        $url = __DIR__ . "/../data/geographical_areas.json";
        $output = file_get_contents($url);
        $json = json_decode($output, true);
        $this->geographical_areas = $json["data"];
        $this->get_country_description();
    }

    public function get_country_description() {
        foreach ($this->geographical_areas as $ga) {
            if ($ga["id"] == $this->country) {
                $this->country_description = $ga["attributes"]["description"];
                break;
            }
        }

    }

    public function get_geographical_area()
    {
        $index = array_search($this->country, array_column($this->geographical_areas, "id"));
        if ($index !== false) {
            $description = $this->geographical_areas[$index]["attributes"]["description"];
            return ($description);
        } else {
            return ("");
        }
    }

    public function get_trade_direction_message($type = 0)
    {
        if ($this->trade_direction == "importing") {
            $this->trade_direction_message = "Which country are the imported goods from?";
            $this->commodity_message = "What is the commodity code for the goods you wish to import?";
            $this->manage_message = "You need to complete these requirements to import commodity code {{comm_code}} ({{comm_code_description}}) into the United Kingdom from {{country}}.";
        } else {
            $this->trade_direction_message = "To which country will the goods be exported?";
            $this->commodity_message = "What is the commodity code for the goods you wish to export?";
            $this->manage_message = "You need to complete these requirements to export commodity code {{comm_code}} ({{comm_code_description}}) from the United Kingdom into {{country}}.";
        }

        if ($type == 1) {
            $this->manage_message = str_replace("{{comm_code}}", $this->commodity_object->commodity_code, $this->manage_message);
            $this->manage_message = str_replace("{{comm_code_description}}", $this->commodity_object->description, $this->manage_message);
            $this->manage_message = str_replace("{{country}}", $this->get_geographical_area(), $this->manage_message);
        }
    }

    public function get_folders()
    {
        $this->content_folder = $_SERVER['DOCUMENT_ROOT'] . "/content/";
        $this->certificate_content_folder = $this->content_folder . "certificates/";
        $this->measure_type_content_folder = $this->content_folder . "measure_types/";
    }

    public function get_templates()
    {
        $this->template_folder = $_SERVER['DOCUMENT_ROOT'] . "/templates/";
        $this->template_measure = $this->get_file($this->template_folder, "measure");
        $this->template_condition = $this->get_file($this->template_folder, "condition");
        $this->template_certificates_intro = $this->get_file($this->template_folder, "certificates_intro");
        $this->template_quotas_intro = $this->get_file($this->template_folder, "quotas_intro");
    }

    public static function get_file($folder, $file, $extension = ".html")
    {
        error_reporting(0);
        $filename = $folder . $file . $extension;
        try {
            $myfile = fopen($filename, "r");
            $content = fread($myfile, filesize($filename));
            fclose($myfile);
        } catch (exception $e) {
            $content = "";
        }
        error_reporting(E_ALL);
        return ($content);
    }
}

function get_formvar($key, $prefix = "", $store_cookie = False)
{
    $s = "";
    $prefix = "";
    if (isset($_REQUEST[$key])) {
        if (!is_array($_REQUEST[$key])) {
            $s = trim($_REQUEST[$key]);
        } else {
            $s = $_REQUEST[$key];
        }
    }
    if ($s == "") {
        $s = Null;
    }

    if ($store_cookie) {
        setcookie($prefix . $key, $s, time() + (86400 * 30), "/");
    }

    return ($s);
}

function get_form_array($key)
{
    $s = array();
    if (isset($_REQUEST[$key])) {
        if (!is_array($_REQUEST[$key])) {
            $s = trim($_REQUEST[$key]);
        } else {
            $s = $_REQUEST[$key];
        }
    }
    if ($s == "") {
        $s = array();
    }

    return ($s);
}

function get_querystring($key)
{
    if (isset($_GET[$key])) {
        if (!is_array($_GET[$key])) {
            $s = trim($_GET[$key]);
        } else {
            $s = $_GET[$key];
        }
        return ($s);
    } else {
        return ("");
    }
}

function get_request($key)
{
    if (isset($_REQUEST[$key])) {
        if (!is_array($_REQUEST[$key])) {
            $s = trim($_REQUEST[$key]);
        } else {
            $s = $_REQUEST[$key];
        }
        return ($s);
    } else {
        return ("");
    }
}

function get_session_variable($key)
{
    if (isset($_SESSION[$key])) {
        if (!is_array($_SESSION[$key])) {
            $s = trim($_SESSION[$key]);
        } else {
            $s = $_SESSION[$key];
        }
        return ($s);
    } else {
        return ("");
    }
}

function pre($data)
{
    print '<pre>' . print_r($data, true) . '</pre>';
}

function prend($data)
{
    print '<pre>' . print_r($data, true) . '</pre>';
    die();
}

function p($s)
{
    echo ("<p class='govuk-body'>" . $s . "</p>");
}

function h1($s)
{
    echo ("<h1>" . $s . "</h1>");
}
function conjunto($dados)
{
    return array_map("unserialize", array_unique(array_map("serialize", $dados)));
}

function set($array)
{
    $out = array();
    foreach ($array as $item) {
        if (!in_array($item, $out)) {
            array_push($out, $item);
        }
    }
    return ($out);
}

function document_code_sorter($object1, $object2) { 
    return $object1->instance_count > $object2->instance_count; 
}

