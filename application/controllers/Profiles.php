<?php

require_once 'vendor/autoload.php';

/**
 * @property CI_URI $uri
 * @property Response $response
 */
class Profiles extends CI_Controller
{
    public bool|CI_DB_query_builder $db;
    public const TABLE = "users_profile";

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function index()
    {
        $data['profiles'] = $this->db->get(self::TABLE)->result();
        $this->load->view("qr-profiles/list", $data);
    }

    public function view(): void
    {
        $id = $this->uri->segment(3);
        $this->response->abort_if(404, empty($id) || !is_numeric($id));

        $data['profile'] = $this->db->where("id", $id)->limit(1)->get(self::TABLE)->row();
        $this->response->abort_if(404, empty($data['profile']));

        $data['showComponent'] = function (string $icon, string $title, ?string $value) {
            if (empty($value)) return "";

            $options = [
                'icon' => $icon,
                'title' => $title,
                'value' => $value
            ];
            return $this->load->view("qr-profiles/component", $options, true);
        };
        $this->load->view("qr-profiles/view", $data);
    }
}