<?php

namespace Traits\schools;

require_once __DIR__ . "/../../Enums/Incidents/IncidentsTypes.php";
require_once __DIR__ . "/../../Enums/Incidents/IncidentStatus.php";
require_once __DIR__ . "/../../Enums/TargetUploadFolderEnum.php";
require_once __DIR__ . "/../Reusable/CanInitWithEmptyData.php";

require_once __DIR__ . "/../../DTOs/Incidents/IncidentCategoryDTO.php";
require_once __DIR__ . "/../../DTOs/Incidents/IncidentStatusDTO.php";
require_once __DIR__ . "/../../DTOs/Incidents/IncidentPriorityDTO.php";

require_once __DIR__ . "/../../Types/Label.php";
require_once __DIR__ . "/../../DTOs/IncidentsDTO.php";
require_once __DIR__ . "/../../DTOs/StudentDTO.php";
require_once __DIR__ . "/../../Exceptions/FileUploadException.php";
require_once __DIR__ . "/../Reusable/FileUpload.php";

use CI_Form_validation;
use CI_Upload;
use DTOs\Incidents\IncidentCategoryDTO;
use DTOs\Incidents\IncidentPriorityDTO;
use DTOs\IncidentsDTO;
use Enums\Incidents\IncidentStatus;
use Enums\Incidents\IncidentsTypes;
use Enums\TargetUploadFolderEnum;
use Exception;
use Exceptions\FileUploadException;
use Illuminate\Support\Collection;
use Traits\Reusable\FileUpload;

/**
 * @property \Incidents $incidents
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
trait Incidents
{
    use FileUpload;

    public function incidents(): void
    {
        $this->response->abort_if(401, !$this->permissions->incidents() || !$this->subaccounts->hasAny("incidents"));

        $page = $this->uri->segment(4);
        $fullLanguage = get_full_language_name(self::LANGUAGE);

        $this->lang->load('Incidents', $fullLanguage);
        $this->lang->load('general', $fullLanguage);

        $this->load->model('schools/Incidents', 'incidents');
        $this->load->library('form_validation');
        $this->incidents->init($this->getAccountSupportedIds(), self::LANGUAGE);

        $this->load->vars([
            'incidentsAction' => function (string $action = "") {
                return base_url(self::LANGUAGE . "/" . $this->controllerName() . "/incidents/" . $action);
            },
            'activeLanguage' => self::LANGUAGE,
            'page_title' => "Incidents",
            'isMinistry' => $this->isMinistry()
        ]);

        if (empty($page)) {
            $this->incidentsLinksList();
            return;
        }

        match ($page) {
            "add" => $this->incidentsAdd(),
            "save" => $this->incidentSave(),
            "actions" => $this->incidentsActions(),
            "reports" => $this->incidentsReports(),
            "charts" => $this->incidentsCharts(),
            "action" => $this->incidentActionModal(),
            "view" => $this->incidentViewModal(),
            default => $this->response->abort()
        };
    }

    abstract private function getAccountSupportedIds(): array;

    private function incidentsLinksList(): void
    {
        $data = [];
        foreach ($this->speakOutLinksKeys() as $key) {
            $data['links'][] = [
                "name" => __("links." . $key),
                "link" => base_url(self::LANGUAGE . '/' . $this->controllerName() . '/incidents/' . $key),
                "desc" => "",
                "icon" => "incidents-" . $key . ".png"
            ];
        }
        $this->show(self::LANGUAGE . '/Global/Links/Lists', $data);
    }

    private function speakOutLinksKeys(): array
    {
        $keys = [];

        if ($this->isSchool()) {
            $keys = array_merge($keys, ['add', 'actions']);
        }

        return array_merge($keys, ['reports', 'charts']);
    }

    public function incidentsAdd(): void
    {
        $this->showForSchoolsOnly();

        $this->show('Shared/Schools/Incidents/add', [
            'students' => $this->incidents->students(),
            'incidents' => $this->incidents->lastIncidents(),
            'sites' => $this->incidents->sites(),
            'incident' => IncidentsDTO::initWithEmptyData()
        ]);
    }

    private function incidentSave(): void
    {
        $this->showForSchoolsOnly();
        $this->response->abort_if(403, $this->input->method() !== "post");

        $id = $this->uri->segment(5);
        $isForUpdate = !empty($id);
        $this->response->abort_if(403, $isForUpdate && !is_numeric($id));

        $data = $this->validateIncident($isForUpdate);
        try {
            $hasFiles = isset($_FILES['images']['size'][0]) && $_FILES['images']['size'][0] !== 0;
            $data['files'] = !$hasFiles ? [] : $this->uploadIncidentImages();
        } catch (Exception $e) {
            $this->response->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

        $incident = $this->incidents->saveIncident($this->sessionData['admin_id'], $data, $id);
        $this->response->json([
            'status' => 'success',
            'message' => __('incident_saved'),
            'incident' => $incident,
        ]);
    }

    private function validateIncident(bool $isUpdating = false): array
    {
        $typesKeys = implode(",", array_map(function (IncidentsTypes $type) {
            return $type->value;
        }, IncidentsTypes::cases()));
        $couldBeEmpty = 'min_length[3]|max_length[200]';

        $this->form_validation
            ->set_rules('location_of_incident', __('location_of_incident'), 'required|numeric')
            ->set_rules('date_of_incident', __('date_of_incident'), 'required|min_length[3]|max_length[200]')
            ->set_rules('reported_by', __('reported_by'), 'required|min_length[3]|max_length[200]')
            ->set_rules('students[]', __('students'), 'required|numeric')
            ->set_rules('witnesses_names', __('witnesses_names'), $couldBeEmpty)
            ->set_rules('description', __('description'), $couldBeEmpty)
            ->set_rules('injuries', __('describe_type_of_injury'), $couldBeEmpty)
            ->set_rules('medical_attention', __('medical_attention_given'), $couldBeEmpty)
            ->set_rules('incident_notes', __('other_comments'), $couldBeEmpty)
            // enums
            ->set_rules('parents', __('parents_contacted'), 'required|in_list[' . $typesKeys . ']');

        if ($isUpdating) {
            $prioritiesKeys = $this->incidents->priorities()->map(fn(IncidentPriorityDTO $incidentPriority) => $incidentPriority->value)->implode(",");
            $categoriesKeys = $this->incidents->categories()->map(fn(IncidentCategoryDTO $incidentCategory) => $incidentCategory->value)->implode(",");
            $statusesKeys = collect(IncidentStatus::cases())->map(fn(IncidentStatus $incidentCategory) => $incidentCategory->value)->implode(",");

            $this->form_validation
                ->set_rules('disciplinary_actions', __("disciplinary_actions"), $couldBeEmpty)
                ->set_rules('potential_consequences', __("identify_potential_consequences"), $couldBeEmpty)
                ->set_rules("priority", __("priority"), "in_list[" . $prioritiesKeys . "]")
                ->set_rules("category", __("category"), "in_list[" . $categoriesKeys . "]")
                ->set_rules("status", __("status"), "in_list[" . $statusesKeys . "]");

            if (!empty($this->input->post('should_take_followup_actions'))) {
                $this->form_validation->set_rules("should_take_followup_actions", __("is_there_a_need_for_followup_actions"), "in_list[" . $typesKeys . "]");
            }
        }

        if (!$this->form_validation->run()) {
            $this->response->json(['status' => 'error', 'message' => validation_errors()]);
            return [];
        }

        return $this->input->post();
    }

    /**
     * @throws FileUploadException
     * @throws Exception
     */
    private function uploadIncidentImages(): Collection
    {
        $name = 'images';
        $files = $_FILES[$name];
        throw_if(empty($files['name']), new FileUploadException(__('no_file_selected')));

        $config['upload_path'] = $this->getTargetedFolder(TargetUploadFolderEnum::INCIDENTS);
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        return $this->uploadFiles($name, $config);
    }

    public function incidentsActions(): void
    {
        $this->showForSchoolsOnly();

        $this->show('Shared/Schools/Incidents/actions', [
            'incidents' => $this->incidents->list(),
        ]);
    }

    public function incidentsReports(): void
    {
        $type = $this->uri->segment(5);
        match ($type) {
            "summary" => $this->incidentsReportsSummary(),
            "students" => $this->incidentsReportsStudents(),
            "completed" => $this->incidentsReportsCompleted(),
            "students-list" => $this->incidentsStudentsList(),
            default => $this->show('Shared/Schools/Incidents/reports-types')
        };
    }

    public function incidentsReportsSummary(): void
    {
        if ($this->input->method() !== "post") {
            $data['locations'] = $this->incidents->sites();
            $data['categories'] = $this->incidents->categories();
            $data['priorities'] = $this->incidents->priorities();
            $this->show("Shared/Schools/Incidents/reports/summary-container", $data);
            return;
        }

        $statuses = $this->input->post('statuses') ?? [];
        $categories = $this->input->post('categories') ?? [];
        $locations = $this->input->post('locations') ?? [];
        $schools = $this->input->post('school') ?? [];

        $supportedStatuses = collect(IncidentStatus::cases())
            ->filter(fn(IncidentStatus $status) => empty($statuses) || in_array($status->value, $statuses))
            ->map(fn(IncidentStatus $status) => $status->value)
            ->values()
            ->toArray();

        $data['counters'] = [];
        foreach (IncidentStatus::cases() as $incidentStatus) {
            if (!in_array($incidentStatus->value, $supportedStatuses)) {
                $data['counters'][$incidentStatus->value] = 0;
            } else {
                $data['counters'][$incidentStatus->value] = $this->incidents->getCountByStatus($incidentStatus, $schools);
            }
        }

        $filters = [
            'status' => $statuses,
            'category' => $categories,
            'site' => $locations,
            'schools' => $schools
        ];
        $data['incidents'] = $this->incidents->list($filters);
        $this->load->view("Shared/Schools/Incidents/reports/inc/summary", $data);
    }

    public function incidentsReportsStudents(): void
    {
        if ($this->input->method() === "post") {
            $student = $this->input->post('student');
            $filter = [
                'student' => $student,
            ];
            $data['incidents'] = $this->incidents->list($filter);
            $data['disableActions'] = true;
            $this->load->view("Shared/Schools/Incidents/inc/list", $data);
            return;
        }

        $data['classes'] = $this->schoolHelper->school_classes();
        $this->show("Shared/Schools/Incidents/reports/students-container", $data);
    }

    public function incidentsReportsCompleted(): void
    {
        $filter = [
            'status' => IncidentStatus::COMPLETED->value
        ];
        $data['incidents'] = $this->incidents->list($filter);
        $this->show("Shared/Schools/Incidents/reports/completed", $data);
    }

    public function incidentsStudentsList(): void
    {
        $filters = [
            'class' => $this->input->post('class'),
        ];

        $students = $this->incidents->students($filters);
        if ($this->isMinistry()) {
            $data['schools'] = collect($students)->groupBy("schoolId")->map(function ($items) {
                return [
                    'schoolName' => $items[0]['schoolName'],
                    'students' => $items
                ];
            });
        } else {
            $data['students'] = $students;
        }
        $type = $this->isMinistry() ? "Ministry" : "School";

        $this->load->view("Shared/Schools/Incidents/reports/inc/" . $type . "/students-list", $data);
    }

    public function incidentsCharts(): void
    {
        $data['students'] = $this->incidents->studentsInvolvedInIncidentsCounter();
        $data['classes'] = $this->incidents->classesInvolvedInIncidentsCounter();
        $data['locationsCounter'] = $this->incidents->locationsInvolvedInIncidentsCounter();
        $data['priorities'] = $this->incidents->IncidentsPrioritiesCounter();
        $data['statuses'] = $this->incidents->IncidentsStatusesCounter();
        $data['locations'] = $this->incidents->IncidentsLocationsCounter();
        $data['months'] = $this->incidents->IncidentsCounterByMonth();

        $data['sites'] = $this->incidents->sites();
        $data['chart'] = function ($chart) {
            $this->load->view("Shared/Schools/Incidents/charts/" . $chart);
        };
        $data['prioritiesList'] = $this->incidents->priorities();
        $this->show("Shared/Schools/Incidents/charts/index", $data);
    }

    public function incidentActionModal(): void
    {
        $data = $this->getIncidentData();

        $data['sites'] = $this->incidents->sites();
        $data['priorities'] = $this->incidents->priorities();
        $data['categories'] = $this->incidents->categories();
        $this->load->view('Shared/Schools/Incidents/inc/action', $data);
    }

    private function getIncidentData(): array
    {
        $id = $this->uri->segment(5);
        $this->response->abort_if(404, empty($id) || !is_numeric($id));

        $data['incident'] = $this->incidents->find($id);
        $this->response->abort_if(404, empty($data['incident']));

        return $data;
    }

    public function incidentViewModal(): void
    {
        $data = $this->getIncidentData();
        $data['section'] = function (string $label, string $key = null, string $value = null) use ($data) {
            return '<h5 class="card-title">' . __($label) . '</h5>
                    <p>' . ($value ?? $data['incident']->{$key ?? $label} ?? "--") . '</p><hr>';
        };
        $this->load->view('Shared/Schools/Incidents/inc/view', $data);
    }
}