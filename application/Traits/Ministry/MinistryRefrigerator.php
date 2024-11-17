<?php

namespace App\Traits\Ministry;

use App\Traits\Shared\RefrigeratorCards;

require_once __DIR__ . "/../../Traits/Shared/RefrigeratorCards.php";

/**
 * @property array $sessionData
 * @property \CI_DB_query_builder $db
 * @property \Response $response
 */
trait MinistryRefrigerator
{
    use RefrigeratorCards;

    public function schools_refrigerators(): void
    {
        $this->lang->load('Refrigerator', get_full_language_name(self::LANGUAGE));
        $this->load->model('Refrigerator');

        $this->show('Shared/Ministry/refrigerators/schools-list', [
            "schools" => $this->Refrigerator->getSchools($this->sessionData['admin_id'] , self::LANGUAGE),
            "language" => self::LANGUAGE
        ]);
    }

    public function school_refrigerator_results(): void
    {
        $schoolId = $this->uri->segment(4);
        $this->response->abort_if(401 , !is_numeric($schoolId) || $schoolId < 1);

        $school = $this->db
            ->where("Id", $schoolId)
            ->where("Added_By", $this->sessionData["admin_id"])
            ->get("l1_school")
            ->row_array();
        $this->response->abort_if(404, !$school);

        $this->showRefrigeratorCards($schoolId);
    }

}