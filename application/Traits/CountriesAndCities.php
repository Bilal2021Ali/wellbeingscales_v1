<?php

namespace Traits;

trait CountriesAndCities
{
    private function countries()
    {
        // TODO : implement countries list
    }

    public function cities()
    {
        $searchQuery = $this->input->get('q');
        $countryId = $this->uri->segment(4);
        $this->response->abort_if(404, !empty($countryId) && !is_numeric($countryId));

        $this->db->select("Name_EN as name, r_cities.Id as id");
        if (!empty($countryId)) {
            $this->db->where('Country_Id', $countryId);
        }

        if (!empty($searchQuery)) {
            $this->db->like('Name_EN', $searchQuery);
        }

        if ($this->input->get('withSchools') && self::TYPE === "ministry") {
            $this->db->join('l1_school', 'l1_school.Citys = r_cities.id')
                ->where("l1_school.Added_By", $this->sessionData['admin_id'])
                ->group_by('r_cities.id');
        }

        $cities = $this->db->get('r_cities')->result_array();
        $this->response->json($cities);
    }
}