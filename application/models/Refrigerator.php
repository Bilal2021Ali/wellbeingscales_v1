<?php

use App\DTOs\RefrigeratorResultDTO;
use Illuminate\Support\Collection;

/**
 * @property \CI_DB_query_builder $db
 */
class Refrigerator extends CI_Model
{

    protected const COLUMNS = [
        'refrigerator_result_daily.`TimeStamp` AS result_date',
        "refrigerator_result_daily.`Result` AS temp",
        "refrigerator_result_daily.`Humidity` AS humidity",
        "refrigerator_result_daily.`user_type` AS user_type",
        "refrigerator_result_daily.`sensor_alive` AS sensor_alive",
        "refrigerator_area.`mac_adress` AS device_mac",
        "refrigerator_area.`Description` AS device_description",
        "refrigerator_levels.`device_name` AS device_name",
        "refrigerator_levels.`min_temp` AS min",
        "refrigerator_levels.`max_temp` AS max",
        "refrigerator_result_daily.`battery_life` AS battery_life",
    ];

    public function getResults(int $schoolId): Collection
    {
        $results = $this->db
            ->select(self::COLUMNS)
            ->from('refrigerator_result_daily')
            ->join('refrigerator_area', 'refrigerator_result_daily.Machine_Id = refrigerator_area.Id')
            ->join('refrigerator_levels', 'refrigerator_levels.Id = refrigerator_area.type')
            ->where('refrigerator_area.source_id', $schoolId)
            ->where('refrigerator_area.user_type', 'school')
            ->group_by('refrigerator_area.mac_adress')
            ->group_by('refrigerator_result_daily.Machine_Id')
            ->having('refrigerator_result_daily.TimeStamp = MAX(refrigerator_result_daily.TimeStamp)', null, false)
            ->get()
            ->result_array();

        return collect($results)->mapInto(RefrigeratorResultDTO::class);
    }

    public function getSchools(int $ministryId, string $language): Collection
    {
        $columns = [
            "Id as id",
            sprintf("School_Name_%s as name", $language),
            "(SELECT COUNT(*) FROM refrigerator_area WHERE refrigerator_area.source_id = l1_school.Id) as refrigerator_count"
        ];

        $schools = $this->db
            ->select($columns)
            ->where("Added_By", $ministryId)
            ->get("l1_school")
            ->result_array();

        return collect($schools);
    }

}