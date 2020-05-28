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

    public function __construct()
    {
        $this->trade_direction = "";
        $this->commodity_code = "";
        $this->country = "";
        $this->excluded_measure_types = array(103, 105, 115, 117, 119, 122, 123, 130, 131, 132, 133, 142, 143, 145, 146, 551, 552, 553, 554, 555, 556, 557, 558, 559, 560, 561, 562, 563);
        //$this->excluded_measure_types = [];

        if (session_id() == "") {
            session_start();
        }

        $this->commodity_object = null;
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

        $this->trade_direction = $_SESSION["trade_direction"];

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

    public function get_trade_direction_message()
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

        $this->manage_message = str_replace("{{comm_code}}", $this->commodity_object->commodity_code, $this->manage_message);
        $this->manage_message = str_replace("{{comm_code_description}}", $this->commodity_object->description, $this->manage_message);
        $this->manage_message = str_replace("{{country}}", $this->get_geographical_area(), $this->manage_message);
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
