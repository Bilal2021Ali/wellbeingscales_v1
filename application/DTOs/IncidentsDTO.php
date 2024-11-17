<?php

namespace DTOs;

use Carbon\Carbon;
use DTOs\Incidents\IncidentCategoryDTO;
use DTOs\Incidents\IncidentPriorityDTO;
use Enums\Incidents\IncidentStatus;
use Enums\Incidents\IncidentsTypes;
use PHPExperts\SimpleDTO\SimpleDTO;
use Traits\Reusable\CanInitWithEmptyData;

/**
 * @property int $id
 * @property string $incident_location
 * @property string $date_of_incident
 * @property string $reported_by
 * @property string $incident_description
 * @property string $incident_photo
 * @property string $staff_involved
 * @property string $staff_name_and_role
 * @property string $equipment_involved
 * @property string $injuries
 * @property string $witnesses_names
 * @property string $medical_attention
 * @property string $supervisor_attention
 * @property string $factors_identified
 * @property string $potential_consequences
 * @property string $preventive_measures
 * @property string $should_take_followup_actions
 * @property string $incident_history
 * @property string $incident_notes
 * @property string $avatar
 * @property string $student_name
 * @property string $school_name
 * @property Carbon $created_at
 * @property string $followup_actions
 * @property string $asset
 * @property string $description
 * @property string $site_name
 * @property string $parents_contacted
 * @property string $disciplinary_actions
 * @property array $students
 */
class IncidentsDTO extends SimpleDTO
{
    use CanInitWithEmptyData;

    private const DATE_FORMAT = 'd/m/Y';

    /**
     * @var int $id
     */
    protected int $id;
    /**
     * @var string $incident_location
     */
    protected string $incident_location;
    /**
     * @var string $date_of_incident
     */
    protected string $date_of_incident;
    /**
     * @var string $reported_by
     */
    protected string $reported_by;
    /**
     * @var string $incident_description
     */
    protected string $incident_description;
    /**
     * @var ?string $incident_photo
     */
    protected ?string $incident_photo;
    /**
     * @var ?string $staff_involved
     */
    protected ?string $staff_involved;
    /**
     * @var ?string $staff_name_and_role
     */
    protected ?string $staff_name_and_role;
    /**
     * @var ?string $equipment_involved
     */
    protected ?string $equipment_involved;
    /**
     * @var ?string $witnesses_names
     */
    protected ?string $witnesses_names;
    /**
     * @var ?string $should_take_followup_actions
     */
    protected ?string $should_take_followup_actions;
    /**
     * @var ?string $injuries
     */
    protected ?string $injuries;
    /**
     * @var ?string $medical_attention
     */
    protected ?string $medical_attention;
    /**
     * @var ?string $supervisor_attention
     */
    protected ?string $supervisor_attention;
    /**
     * @var ?string $factors_identified
     */
    protected ?string $factors_identified;
    /**
     * @var ?string $preventive_measures
     */
    protected ?string $preventive_measures;
    /**
     * @var ?string $incident_history
     */
    protected ?string $incident_history;
    /**
     * @var ?string $incident_notes
     */
    protected ?string $incident_notes;
    /**
     * @var ?string $parents_contacted
     */
    protected ?string $parents_contacted;
    /**
     * @var ?string $disciplinary_actions
     */
    protected ?string $disciplinary_actions;
    /**
     * @var ?string $description
     */
    protected ?string $description;
    /**
     * @var ?string $potential_consequences
     */
    protected ?string $potential_consequences;
    /**
     * @var ?string $followup_actions
     */
    protected ?string $followup_actions;
    /**
     * @var ?string $asset
     */
    protected ?string $asset;
    /**
     * @var int $priority
     */
    protected int $priority;
    /**
     * @var ?int $category
     */
    protected ?int $category;
    /**
     * @var ?int $status
     */
    protected ?int $status;
    /**
     * @var ?string $student_name
     */
    protected ?string $student_name;
    /**
     * @var ?string $school_name
     */
    protected ?string $school_name;
    /**
     * @var null|string $avatar
     */
    protected null|string $avatar;
    /**
     * @var Carbon $created_at
     */
    protected Carbon $created_at;
    /**
     * @var string $site_name
     */
    protected string $site_name;
    /**
     * @var array $students
     */
    protected array $students;

    public function __construct(array $input)
    {
        $input['id'] = (int)($input['id'] ?? 0);
        $input['category'] = (int)($input['category'] ?? 0);
        $input['status'] = (int)($input['status'] ?? 0);
        $input['priority'] = (int)($input['priority'] ?? 0);

        parent::__construct($input, [SimpleDTO::PERMISSIVE]);
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
    }

    public function should_take_followup_actions(): ?IncidentsTypes
    {
        return IncidentsTypes::tryFrom($this->should_take_followup_actions);
    }

    public function category(): IncidentCategoryDTO
    {
        $data = $this->getData();
        return new IncidentCategoryDTO([
            'name' => $data['category_name'],
            'incident_category_id' => $data['incident_category_id'],
            'font_color' => $data['category_font_color'],
            'back_color' => $data['category_back_color']
        ]);
    }

    public function status(): IncidentStatus
    {
        return IncidentStatus::from($this->status);
    }

    public function priority(): IncidentPriorityDTO
    {
        $data = $this->getData();
        return new IncidentPriorityDTO([
            'name' => $data['priority_name'],
            'incident_priority_id' => $data['incident_priority_id'],
            'font_color' => $data['priority_font_color'],
            'back_color' => $data['priority_back_color']
        ]);
    }

    public function studentsIds(): array
    {
        if (empty($this->students)) return [];

        return array_column($this->students, "id");
    }

    public function createdDay(): string
    {
        return $this->created_at->format(self::DATE_FORMAT);
    }

    public function incidentHistory(): string
    {
        return empty($this->incident_history)
            ? "--"
            : Carbon::parse($this->incident_history)->format(self::DATE_FORMAT);
    }
}