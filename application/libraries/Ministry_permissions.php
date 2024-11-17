<?php

class Ministry_permissions
{
    public const TABLE = "v0_permissions";
    public const TYPE = "Ministry";
    public $permissions = [];

    /**
     * @param int $ministry_id
     * @type CI_Controller $CI
     */
    public function __construct()
    {
        $CI = &get_instance();
        $CI->load->library('session');
        $sessionData = $CI->session->userdata('admin_details');
        $ministry_id = $sessionData['admin_id'] ?? null;

        if (!is_null($ministry_id)) {
            $result = $CI->db->where("user_type", self::TYPE)
                ->where("user_id", $ministry_id)
                ->get(self::TABLE)
                ->result_array();
            if (!empty($result)) {
                $this->permissions = $result[0];
            }
        }
    }

    public function has(string $permission): bool
    {
        return !empty($this->permissions) && isset($this->permissions[$permission]) && intval($this->permissions[$permission]) === 1;
    }
}
