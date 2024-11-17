<?php


require_once __DIR__ . "/../Interfaces/IMiddleware.php";
require_once __DIR__ . "/CountryCheck/CountryCheckDriverBase.php";
require_once __DIR__ . "/CountryCheck/Drivers/Cloudflare.php";
require_once __DIR__ . "/CountryCheck/Drivers/GeoPlugin.php";
require_once __DIR__ . "/CountryCheck/Drivers/CountryIs.php";

use CountryCheck\CountryCheckDriverBase;
use CountryCheck\Drivers\Cloudflare;
use CountryCheck\Drivers\CountryIs;
use CountryCheck\Drivers\GeoPlugin;
use Interfaces\IMiddleware;
use JetBrains\PhpStorm\NoReturn;

class CountryMiddleware implements IMiddleware
{
    public const COUNTRY_COOKIE_KEY = "country";
    public const COUNTRY_COOKIE_TTL = 60 * 60 * 24 * 10; // TEN DAYS

    protected CI_Controller $CI;
    protected CI_Input $input;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('cookie');
        $this->CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $this->input = $this->CI->input;
    }


    public function handle(array $parameters): void
    {

        $country = $this->getTheUsersCountry();
        $accepted = $parameters['acceptedCountries'];

        if (empty($country)) {
            $this->showErrorPage([
                'title' => 'We Have Some Issues',
                'content' => "sorry we couldn't run some necessary checks , please try again later",
                'image' => base_url("assets/images/maintenance.png")
            ]);
        }

        $isValidCountry = in_array($country, $accepted);
        if ($isValidCountry) return;

        $this->showErrorPage([
            'title' => 'Unsupported Country',
            'content' => "Apologies, but we do not provide support for the country you are currently visiting from (" . $country . ")",
            'image' => base_url("assets/images/icons/world.svg")
        ]);
    }

    public function getTheUsersCountry(): string
    {
        return get_cookie(self::COUNTRY_COOKIE_KEY, TRUE) ?? $this->getTheFreshUsersCountry();

    }

    public function getTheFreshUsersCountry(): ?string
    {
        $ip = config_item("env")['DEFAULT_IP'] ?? $this->input->ip_address();

        $drivers = [new Cloudflare($ip), new GeoPlugin($ip), new CountryIs($ip)];

        $country = null;
        foreach ($drivers as $driver) {
            $country = $this->tryDriver($driver);
            if (!empty($country)) break;
        }

        return $country;
    }

    public function tryDriver(CountryCheckDriverBase $driver): ?string
    {
        $country = $driver->get();
        if (empty($country)) return null;

        set_cookie(self::COUNTRY_COOKIE_KEY, $country, self::COUNTRY_COOKIE_TTL);
        return $country;
    }

    #[NoReturn]
    public function showErrorPage(array $config): void
    {
        $settings = $this->CI->db->get('l0_global_settings', 1)->result_array();
        $data = [
            'logo' => $settings[0]['logo_url']
        ];
        $content = $this->CI->load->view("errors/country_error", array_merge($data, $config), true);
        $this->CI->output->_display($content);
        die();
    }

}
