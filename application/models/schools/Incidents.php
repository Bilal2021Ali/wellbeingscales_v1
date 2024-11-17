<?php

use DTOs\FileDTO;
use DTOs\Incidents\IncidentCategoryDTO;
use DTOs\Incidents\IncidentPriorityDTO;
use DTOs\IncidentsDTO;
use DTOs\StudentDTO;
use Enums\Incidents\IncidentStatus;
use Enums\TargetUploadFolderEnum;
use Illuminate\Support\Collection;

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class Incidents extends CI_Model
{

    public const TABLE = "incidents";
    public const CATEGORIES_TABLE = "r_incident_category";
    public const PRIORITIES_TABLE = "r_incident_priority";
    public const PHOTOS_TABLE = "incidents_photos";
    public const STUDENTS_TABLE = "incidents_students";

    private const UN_REQUIRED_FIELDS = [
        'witnesses_names',
        'description',
        'injuries',
        'medical_attention',
        'incident_notes',
        'disciplinary_actions',
        'potential_consequences',
        'preventive_measures',
        'should_take_followup_actions'
    ];


    /**
     * @var array<int> $accounts
     */
    public array $accounts;
    public string $activeLanguage;
    public array $defaultColumns;

    public function init(array $accounts, string $activeLanguage): self
    {
        $this->accounts = $accounts;
        $this->activeLanguage = $activeLanguage;

        $siteName = $this->getCompatibleSiteName();
        $this->defaultColumns = [
            (self::TABLE . " .*"),
            $siteName . " as site_name ",
            " l1_school.School_Name_" . $this->activeLanguage . " as school_name ",
            "r_incident_category." . strtolower($this->activeLanguage) . "_incident_category_title as category_name",
            "r_incident_category.incident_category_id",
            "r_incident_priority.incident_priority_id",
            "r_incident_category.font_color as category_font_color",
            "r_incident_category.back_color as category_back_color",
            "r_incident_priority." . strtolower($this->activeLanguage) . "_incident_priority_title as priority_name",
            "r_incident_priority.font_color as priority_font_color",
            "r_incident_priority.back_color as priority_back_color",
        ];

        return $this;
    }

    private function getCompatibleSiteName(): string
    {
        $languageCode = ((strtolower($this->activeLanguage) === "en") ? '' : ('_' . strtolower($this->activeLanguage)));
        return "Site_Code" . $languageCode;
    }

    public function students(array $filters = []): array
    {
        $students = $this->getStudents();
        if (!empty($filters['class'])) {
            $students->where("l2_student.Class", $filters['class']);
        }

        return $students->get('l2_student')->result_array();
    }

    public function getStudents(): CI_DB_query_builder
    {
        $class = $this->activeLanguage === "AR" ? 'Class_ar' : 'Class';
        return $this->db->select("CONCAT(l2_student.`F_name_" . $this->activeLanguage . "`, ' ', l2_student.`L_name_" . $this->activeLanguage . "`) as name, l2_avatars.Link as avatar, l2_student.Id as id , l1_school.Id as schoolId , l1_school.School_Name_" . $this->activeLanguage . " as schoolName , r_levels.$class as class , l2_student.Grades as grade ,DOP as dop,l2_student.Email as email")
            ->join("l2_avatars", " `l2_avatars`.`For_User` = `l2_student`.`Id` and `l2_avatars`.`Type_Of_User` = 'Student'", "LEFT")
            ->join("l1_school", "l1_school.Id = l2_student.Added_By")
            ->join("r_levels", "r_levels.Id = l2_student.Class")
            ->where_in("l2_student.Added_By", $this->accounts);
    }

    public function student(int $id): ?StudentDTO
    {
        $student = $this->getStudents()->select("l2_student.*")->where("l2_student.Id", $id)->limit(1)->get('l2_student')->row_array();
        return empty($student) ? null : new StudentDTO($student);
    }

    public function sites(): array
    {
        return $this->db->select("* , " . $this->getCompatibleSiteName() . " as name")
            ->where_in("Added_By", $this->accounts)
            ->get("l2_site")->result_array();
    }

    public function lastIncidents(int $count = 10): array
    {
        $results = $this->getIncidents()->order_by("id", "DESC")->limit($count)->get(self::TABLE)->result_array();
        return $this->withStudents($results);
    }

    public function getIncidents(array $columns = []): CI_DB_query_builder
    {
        $columns = empty($columns) ? $this->defaultColumns : $columns;

        return $this->db->select(implode(",", $columns))
            ->join("l2_site", " `l2_site`.`Id` = `incidents`.`incident_location`")
            ->join("l1_school", "l1_school.Id = incidents.Added_By")
            ->join("r_incident_priority", "r_incident_priority.incident_priority_id = incidents.priority", "LEFT")
            ->join("r_incident_category", "r_incident_category.incident_category_id = incidents.category", "LEFT")
            ->where_in("incidents.Added_By", $this->accounts)
            ->where_in("l2_site.Added_By", $this->accounts)
            ->order_by("incidents.Id", "DESC");
    }

    /**
     * @param array $incidents
     * @return array
     */
    public function withStudents(array $incidents): array
    {
        $incidentsIds = array_column($incidents, "id");
        if (empty($incidentsIds)) return [];

        $incidentsStudents = collect($this->getIncidentStudents($incidentsIds));
        $studentsIds = $incidentsStudents->keyBy('student_id')->keys()->toArray();

        $students = $this->getStudents()->where_in("l2_student.id", $studentsIds)->get("l2_student")->result_array();
        $students = collect($students)->keyBy('id');
        $incidentsStudentsByIncidentId = $incidentsStudents->groupBy('incident_id');

        return collect($incidents)->map(function (array $incident) use ($students, $incidentsStudentsByIncidentId) {
            $incidentStudents = [];
            $incidentStudentsData = $incidentsStudentsByIncidentId->get($incident['id'], []);

            foreach ($incidentStudentsData as $student) {
                $incidentStudents[] = $students[$student['student_id']];
            }

            $incident['students'] = $incidentStudents;
            return $incident;
        })->toArray();
    }

    public function getIncidentStudents(array $incidentsIds): array
    {
        if (empty($incidentsIds)) return [];
        return $this->db->where_in("incident_id", $incidentsIds)->get(self::STUDENTS_TABLE)->result_array();
    }

    /**
     * @return Collection<IncidentCategoryDTO>
     */
    public function categories(): Collection
    {
        $language = strtolower($this->activeLanguage);
        $results = $this->db->select('* , ' . $language . '_incident_category_title as name')->get(self::CATEGORIES_TABLE)->result_array();
        return collect($results)->mapInto(IncidentCategoryDTO::class);
    }

    /**
     * @return Collection<IncidentPriorityDTO>
     */
    public function priorities(): Collection
    {
        $language = strtolower($this->activeLanguage);
        $results = $this->db->select('* , ' . $language . '_incident_priority_title as name')->get(self::PRIORITIES_TABLE)->result_array();
        return collect($results)->mapInto(IncidentPriorityDTO::class);
    }


    /**
     * @param array $filters
     * @return Collection<IncidentsDTO>
     */
    public function list(array $filters = []): Collection
    {
        if (!empty($filters['schools'])) {
            $this->accounts = $filters['schools'];
        }

        $results = $this->getIncidents()->order_by("id", "DESC");

        if (!empty($filters['status'])) {
            $results = $results->where_in("incidents.status", $filters['status']);
        }

        if (!empty($filters['category'])) {
            $results = $results->where_in("incidents.category", $filters['category']);
        }

        if (!empty($filters['site'])) {
            $results = $results->where_in("incidents.incident_location", $filters['site']);
        }

        if (!empty($filters['student'])) {
            $results = $results->join(self::STUDENTS_TABLE, "incidents.id = " . self::STUDENTS_TABLE . ".incident_id")->where_in(self::STUDENTS_TABLE . ".student_id", $filters['student']);
        }

        $results = $results->get(self::TABLE)->result_array();
        return collect($this->withStudents($results))->mapInto(IncidentsDTO::class);
    }

    public function find(int $id): ?IncidentsDTO
    {
        $incident = $this->getIncidents()->where("incidents.Id", $id)->limit(1)->get(self::TABLE)->row_array();
        if (empty($incident)) return null;


        return new IncidentsDTO($this->withStudents([$incident])[0]);
    }

    public function getCountByStatus(IncidentStatus $status, $schools = []): int
    {
        if (!empty($schools)) {
            $this->accounts = $schools;
        }

        $subQuery = $this->getIncidents(['COUNT(*)'])->where("incidents.status", $status->value)->from(self::TABLE)->get_compiled_select();
        $result = $this->db->select("(" . $subQuery . ") as count")->get("incidents")->result_array();

        return $result[0]['count'] ?? 0;
    }

    public function saveIncident(int $AddedBy, array $data, ?int $id = null): array
    {
        $incident = [
            'incident_location' => $data['location_of_incident'],
            'date_of_incident' => $data['date_of_incident'],
            'description' => $data['description'] ?? "",
            'reported_by' => $data['reported_by'] ?? "",
            'injuries' => $data['injuries'] ?? "",
            'medical_attention' => $data['medical'] ?? "",
            'parents_contacted' => $data['parents'] ?? "",
            'Added_By' => $AddedBy
        ];

        foreach (self::UN_REQUIRED_FIELDS as $key) {
            $incident[$key] = $data[$key] ?? "";
        }


        $updatesWhenItExists = ['priority', 'category', 'status'];
        foreach ($updatesWhenItExists as $key) {
            if (isset($data[$key])) {
                $incident[$key] = $data[$key];
            }
        }

        $this->db->trans_begin();

        if (!empty($id)) {
            $this->db->where('id', $id)->update(self::TABLE, $incident);
            $insertId = $id;
        } else {
            $this->db->insert(self::TABLE, $incident);
            $insertId = $this->db->insert_id();
        }

        if (!empty($data['files'])) {
            $incident['photos'] = $this->savePhotos($data['files'], $insertId);
        }
        $this->saveStudents($data['students'], $insertId);

        $this->db->trans_complete();

        return [
            'id' => $insertId,
            ...$incident
        ];
    }

    /**
     * @param Collection<FileDTO> $files
     * @param int $incidentId
     * @return array
     */
    public function savePhotos(Collection $files, int $incidentId): array
    {
        $photos = $files->map(fn(FileDTO $file) => [
            'incident_photo' => $file->getFullUrl(TargetUploadFolderEnum::INCIDENTS),
            'incident_id' => $incidentId
        ]);

        $this->db->insert_batch(self::PHOTOS_TABLE, $photos->toArray());

        return $photos->toArray();
    }

    public function saveStudents(array $students, int $incidentId): void
    {
        $data = collect($students)->map(fn($studentId) => [
            'student_id' => $studentId,
            'incident_id' => $incidentId
        ]);

        $this->db->where("incident_id", $incidentId)->delete(self::STUDENTS_TABLE);
        $this->db->insert_batch(self::STUDENTS_TABLE, $data->toArray());
    }

    public function studentsInvolvedInIncidentsCounter(): int
    {
        $subQuery = $this->getIncidents(['COUNT(DISTINCT incidents_students.student_id)'])
            ->join(self::STUDENTS_TABLE, self::TABLE . ".id = " . self::STUDENTS_TABLE . ".incident_id")
            ->from(self::TABLE)
            ->get_compiled_select();
        $result = $this->db->select("(" . $subQuery . ") as count")->get(self::TABLE)->result_array();

        return $result[0]['count'] ?? 0;
    }

    public function classesInvolvedInIncidentsCounter(): int
    {
        $subQuery = $this->getIncidents(['COUNT(DISTINCT l2_student.Class)'])
            ->join(self::STUDENTS_TABLE, self::TABLE . ".id = " . self::STUDENTS_TABLE . ".incident_id")
            ->join("l2_student", "l2_student.id = " . self::STUDENTS_TABLE . ".student_id")
            ->from(self::TABLE)
            ->get_compiled_select();
        $result = $this->db->select("(" . $subQuery . ") as count")->get(self::TABLE)->result_array();

        return $result[0]['count'] ?? 0;
    }

    public function locationsInvolvedInIncidentsCounter(): int
    {
        $subQuery = $this->getIncidents(['COUNT(DISTINCT ' . self::TABLE . '.incident_location)'])->from(self::TABLE)->get_compiled_select();
        $result = $this->db->select("(" . $subQuery . ") as count")->get(self::TABLE)->result_array();

        return $result[0]['count'] ?? 0;
    }

    public function IncidentsPrioritiesCounter(): Collection
    {
        $results = $this->getIncidents(['COUNT(*) as counter', 'priority'])->group_by("priority")->get(self::TABLE)->result_array();

        return collect($results)->keyBy("priority")->map(fn($item) => $item['counter']);
    }

    public function IncidentsStatusesCounter(): Collection
    {
        $results = $this->getIncidents(['COUNT(*) as counter', 'incidents.status'])->group_by("incidents.status")->get(self::TABLE)->result_array();

        return collect($results)->keyBy("status")->map(fn($item) => $item['counter']);
    }

    public function IncidentsLocationsCounter(): array
    {
        $siteName = $this->getCompatibleSiteName();
        return $this->getIncidents(['COUNT(*) as counter', $siteName . " as name"])
            ->group_by("incidents.incident_location")
            ->get(self::TABLE)
            ->result_array();
    }

    public function IncidentsCounterByMonth(): array
    {
        $results = $this->getIncidents(['COUNT(*) as counter', "MONTH(created_at) as month"])
            ->group_by("MONTH(incidents.created_at)")
            ->get(self::TABLE)
            ->result_array();
        return collect($results)->keyBy("month")->map(fn($item) => $item['counter'])->toArray();
    }
}