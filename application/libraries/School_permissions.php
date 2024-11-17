<?php

use Illuminate\Support\Collection;

class School_permissions
{
    public Collection $schoolPermissions;
    public Collection $ministryPermissions;

    public function __construct()
    {
        $CI = &get_instance();
        $CI->load->library('session');
        $user = $CI->session->userdata('admin_details');


        $CI = &get_instance();
        $schoolPermissions = $CI->db->select('v1_permissions.*')
            ->join("v1_permissions", "`v1_permissions`.`user_id` = `l1_school`.`Id` AND `v1_permissions`.`user_type` = 'school'")
            ->join("v0_permissions", "`v0_permissions`.`user_id` = `l1_school`.`Added_By` AND `v0_permissions`.`user_type` = 'Ministry'")
            ->where('`l1_school`.`Id`', $user['admin_id'])
            ->limit(1)
            ->get('l1_school')->result_array();
        $this->schoolPermissions = collect($schoolPermissions);

        $ministryPermissions = $CI->db->select('v0_permissions.*')
            ->join("v0_permissions", "`v0_permissions`.`user_id` = `l1_school`.`Added_By` AND `v0_permissions`.`user_type` = 'Ministry'")
            ->where('`l1_school`.`Id`', $user['admin_id'])
            ->limit(1)
            ->get('l1_school')->result_array();
        $this->ministryPermissions = collect($ministryPermissions);
    }

    public function has(string $key, bool $school = false): bool
    {
        if ($school) {
            return $this->getPermission($this->schoolPermissions, $key);
        }

        return $this->getPermission($this->ministryPermissions, $key);
    }

    private function getPermission(Collection $permissions, string $key): bool
    {
        $permissions = $permissions->first();

        if (empty($permissions)) return false;

        $value = $permissions[$key] ?? null;
        // developer error, won't be handled by the application
        throw_if($value === null, "The Key : " . $key . " is Not a Valid Permission Key");

        return intval($value) === 1;
    }

}