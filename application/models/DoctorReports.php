<?php

use Carbon\Carbon;
use DTOs\DoctorReportDTO;
use DTOs\Filters\DoctorReportsFilterDTO;
use Illuminate\Support\Collection;

require_once __DIR__ . '/../DTOs/DoctorReportDTO.php';

/**
 * this class cannot be used directly
 * @property CI_DB_query_builder $db
 */
class DoctorReports extends CI_Model
{
    private array $accountsIds;
    protected const TABLE_NAME = 'School_Patient_Detail_Doctor_Single_Result';
    private const DATE_FORMAT = 'Y-m-d H:m:s';

    public function setAccountsIds(array $accountsIds): void
    {
        $this->accountsIds = $accountsIds;
    }

    private function getFilterDate(Carbon $date, bool $isStart = false): string
    {
        $settings = $isStart ? [00, 00, 00] : [23, 59, 59];
        [$hour, $minute, $second] = $settings;

        return $date->hour($hour)->minute($minute)->second($second)->format(self::DATE_FORMAT);
    }

    protected function applyFilters(CI_DB_query_builder $query, DoctorReportsFilterDTO $filters): CI_DB_query_builder
    {
        if ($filters->hasClasses()) {
            $query->where_in('r_levels.Id', $filters->getClasses()->toArray());
        }

        if ($filters->hasGenders()) {
            $query->where_in('LOWER(' . static::TABLE_NAME . '.patientgender)', $filters->getGenders()->toArray());
        }

        if ($filters->hasGrades()) {
            $query->where_in('l2_student.Grades', $filters->getGrades()->toArray());
        }

        if ($filters->hasTest()) {
            $query->where(static::TABLE_NAME . '.title', $filters->getTest());
        }

        if ($filters->hasFrom()) {
            $query->where(static::TABLE_NAME . '.created >=', $this->getFilterDate($filters->getFrom(), true));
        }

        if ($filters->hasTo()) {
            $query->where(static::TABLE_NAME . '.created <=', $this->getFilterDate($filters->getTo()));
        }

        return $query;
    }

    protected function getRequiredColumns(string $language): array
    {
        $classColumn = strtolower($language) === 'ar' ? 'Class_ar' : 'Class';

        return [
            "l1_school.School_Name_" . strtoupper($language) . " as school_name",
            "CONCAT(l2_student.F_name_" . strtoupper($language) . ",' ',l2_student.L_name_" . strtoupper($language) . ") AS student_name",
            "l2_student.National_Id AS national_id",
            "l2_student.DOP AS birthday",
            static::TABLE_NAME . '.patientgender as gender',
            "r_levels.{$classColumn} as class_name",
            "l2_student.Grades as grade",
            "CONCAT(orderDate , ' ' , orderTime) as order_date",
            static::TABLE_NAME . ".title as test_title",
            static::TABLE_NAME . ".result"
        ];
    }

    public function getResults(DoctorReportsFilterDTO $filters, string $language): Collection
    {
        if (empty($this->accountsIds)) return collect();

        $query = clone $this->db;
        $query->select($this->getRequiredColumns($language))
            ->from(static::TABLE_NAME)
            ->join('l2_student', 'l2_student.id = ' . static::TABLE_NAME . '.tracksystem_id')
            ->join('l1_school', 'l1_school.Id = ' . static::TABLE_NAME . '.SchoolId')
            ->join('r_levels', 'r_levels.Id = l2_student.Class')
            ->where_in('l2_student.Added_By', $this->accountsIds);

        $result = $this->applyFilters($query, $filters)->get()->result_array();
        return collect($result)->mapInto(DoctorReportDTO::class);
    }

    public function getAvailableTests(): Collection
    {
        $results = $this->db->distinct('title')->select('title')->get(self::TABLE_NAME)->result_array();
        return collect($results)->pluck('title');
    }

}