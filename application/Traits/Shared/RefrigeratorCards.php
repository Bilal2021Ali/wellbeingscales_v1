<?php

namespace App\Traits\Shared;

require_once __DIR__ . '/../../DTOs/RefrigeratorResultDTO.php';

/**
 * @property \CI_Input $input
 * @property \Refrigerator $Refrigerator
 * @property \Response $response
 */
trait RefrigeratorCards
{

    protected function showRefrigeratorCards(int $schoolId): void
    {
        $this->lang->load('Refrigerator', get_full_language_name(self::LANGUAGE));

        if ($this->input->method() === "post") {
            $this->loadRefrigeratorResults($schoolId);
            return;
        }


        $school = $this->db
            ->select(sprintf("Id as id, School_Name_%s as name", self::LANGUAGE))
            ->where("Id", $schoolId)
            ->where("Added_By", $this->sessionData["admin_id"])
            ->get("l1_school")
            ->row_array();
     //   $this->response->abort_if(404, blank($school));

        $this->show('Shared/Schools/RefrigeratorCards/refrigerator-cards', 
		[
            'school' => $school
        ]);
    }

    protected function loadRefrigeratorResults(int $schoolId): void
    {
        $this->load->model('Refrigerator');
        $this->load->view('Shared/Schools/RefrigeratorCards/refrigerator-results', [
            'results' => $this->Refrigerator->getResults($schoolId)
        ]);
    }

}