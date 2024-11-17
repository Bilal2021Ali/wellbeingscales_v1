<?php

namespace DTOs\Incidents;
require_once __DIR__ . "/../../Traits/Reusable/isSelected.php";

use PHPExperts\SimpleDTO\SimpleDTO;
use Traits\Reusable\isSelected;
use Types\Label;

/**
 * @property int $value
 * @property string $ar_incident_priority_title
 * @property string $en_incident_priority_title
 * @property string $font_color
 * @property string $back_color
 * @property string $date_time
 */
class IncidentPriorityDTO extends SimpleDTO
{
    use isSelected;

    /**
     * @var int $value
     */
    protected int $value;
    /**
     * @var string $en_incident_priority_title
     */
    protected string $en_incident_priority_title;
    /**
     * @var string $ar_incident_priority_title
     */
    protected string $ar_incident_priority_title;
    /**
     * @var string|null $font_color
     */
    protected ?string $font_color;
    /**
     * @var string|null $back_color
     */
    protected string|null $back_color;
    /**
     * @var string $date_time
     */
    protected string $date_time;

    public function __construct(array $input)
    {
        $input['value'] = (int)$input['incident_priority_id'];
        parent::__construct($input, [SimpleDTO::PERMISSIVE]);
    }

    public function text(): string
    {
        return $this->name ?? $this->en_incident_priority_title ?? __("unknown");
    }

    public function label(): Label
    {
        return new Label(
            background: $this->back_color ?? "#343a40",
            color: $this->font_color ?? "#fff"
        );
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
    }
}