<?php

use DTOs\Filters\DoctorReportsFilterDTO;

require_once __DIR__ . "/./DoctorReports.php";

class DoctorProfileReport extends \DoctorReports
{
    protected const TABLE_NAME = "School_Patient_Detail_Doctor_Profile_Result";

    public function getAvailableProfiles(): array
    {
        $result = $this->db->distinct('profile_title')->select('profile_title')->get(self::TABLE_NAME)->result_array();
        return collect($result)->pluck('profile_title')->toArray();
    }

    protected function applyFilters(CI_DB_query_builder $query, DoctorReportsFilterDTO $filters): CI_DB_query_builder
    {
        $query = parent::applyFilters($query, $filters);

        if ($filters->hasProfiles()) {
            $query->where_in('profile_title', $filters->getProfiles()->toArray());
        }

        return $query;
    }

    protected function getRequiredColumns(string $language): array
    {
        return [
            ...parent::getRequiredColumns($language),
            'profile_title',
            'Flag as flag'
        ];
    }
}