<?php

namespace DTOs\Incidents;
require_once __DIR__ . "/../../Traits/Reusable/isSelected.php";

use PHPExperts\SimpleDTO\SimpleDTO;
use Traits\Reusable\isSelected;

/**
 * @property int $value
 * @property string $en_incident_status_title
 * @property string $ar_incident_status_title
 * @property string $font_color
 * @property string $back_color
 * @property string $date_time
 */
class IncidentStatusDTO extends SimpleDTO
{
    use isSelected;

    /**
     * @var int $value
     */
    protected int $value;
    /**
     * @var string $ar_incident_status_title
     */
    protected string $ar_incident_status_title;
    /**
     * @var string $en_incident_status_title
     */
    protected string $en_incident_status_title;
    /**
     * @var string $font_color
     */
    protected string $font_color;
    /**
     * @var string $back_color
     */
    protected string $back_color;
    /**
     * @var string $date_time
     */
    protected string $date_time;

    public function __construct(array $input)
    {
        $input['value'] = (int)$input['incident_status_id'];
        parent::__construct($input, [SimpleDTO::PERMISSIVE]);
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
    }
}