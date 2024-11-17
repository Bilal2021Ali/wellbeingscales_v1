<?php

use App\Enums\UserTypeEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;

require_once __DIR__ . '/../../Enums/UserTypeEnum.php';

/**
 * @property CI_DB_query_builder $db
 */
class TaskReports extends CI_Model
{
    public const  R_TABLE = "r_tasks";
    public const  TABLE = "stu_student_tasks_answers";

    public function get_all_tasks(): Collection
    {
        $query = $this->db->get(self::R_TABLE);
        return collect($query->result_array());
    }

    public function get_passed_tasks(int $student_id, UserTypeEnum $type, ?Carbon $date = null): Collection
    {
        $date = ($date ?? Carbon::now())->format('Y-m-d');

        $query = $this->db->where('User_Id', $student_id)
            ->where('Created', $date)
            ->where('User_Type', $type->value)
            ->get(self::TABLE);

        return collect($query->result_array());
    }

}