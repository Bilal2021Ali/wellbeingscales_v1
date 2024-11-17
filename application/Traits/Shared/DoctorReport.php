<?php

namespace Traits\Shared;

require_once __DIR__ . "/../../DTOs/Filters/DoctorReportsFilterDTO.php";

use DTOs\Filters\DoctorReportsFilterDTO;

/**
 * @property \CI_Input $input
 * @property \DoctorReports $DoctorReports
 * @property \CI_Loader $load
 * @property \CI_DB_query_builder $db
 * @property \CI_Config $config
 * @property \Basic_functions $schoolHelper
 * @property \DoctorSingleReport $DoctorSingleReport
 * @property \DoctorProfileReport $DoctorProfileReport
 */
trait DoctorReport
{
    abstract function getAccountSupportedIds(): array;

	
	
    public function patient_single_report(): void
    {
        $this->lang->load('DoctorReport', get_full_language_name(self::LANGUAGE));
        $method = $this->input->method();

        if ($method === "get") {
            $this->showPatientReportPage();
            return;
        }

        $this->getPatientReport();
    }

    public function patient_profile_report(): void
    {
        $this->lang->load('DoctorReport', get_full_language_name(self::LANGUAGE));
        $method = $this->input->method();

        if ($method === "get") {
            $this->showPatientProfileReportPage();
            return;
        }

        $this->getProfilePatientReport();
    }

    private function showPatientProfileReportPage(): void
    {
        $this->load->model('DoctorProfileReport');
        $data = $this->getReportPageData();
        $data['tests'] = $this->DoctorProfileReport->getAvailableTests();
        $data['profiles'] = $this->DoctorProfileReport->getAvailableProfiles();
        $data['filtersSource'] = "Shared/DoctorReports/ProfileReportFilters";
        $this->show('Shared/DoctorReports/Show', $data);
    }

    private function getProfilePatientReport(): void
    {
        $this->load->model('DoctorProfileReport');

        $filters = $this->buildFilters();
        $profiles = $this->input->post('profiles');
        if (!empty($profiles)) {
            $filters->setProfiles($profiles);
        }

        $ids = $this->getFilterAccountsIds();
        $this->DoctorProfileReport->setAccountsIds($ids);

        $data['results'] = $this->DoctorProfileReport->getResults($filters, self::LANGUAGE);
        $data['isMinistry'] = $this->isMinistry();
        $this->load->view('Shared/DoctorReports/ProfileReport', $data);
    }

    private function getReportPageData(): array
    {
        $data['classes'] = $this->schoolHelper->getActiveSchoolClassesByStudents(false, $this->getAccountSupportedIds());
        $data['grades'] = $this->config->item('av_grades');
        $data['isMinistry'] = $this->isMinistry();
        if ($this->isMinistry()) {
            $data['schools'] = $this->db->select('Id , School_Name_' . self::LANGUAGE . ' as name')
                ->where('Added_By', $this->sessionData['admin_id'])
                ->get('l1_school')
                ->result_array();
        }
        return $data;
    }

    private function showPatientReportPage(): void
    {
        $this->load->model('DoctorSingleReport');
        $data = $this->getReportPageData();
        $data['tests'] = $this->DoctorSingleReport->getAvailableTests();
        $data['filtersSource'] = "Shared/DoctorReports/SingleReportFilters";
        $this->show('Shared/DoctorReports/Show', $data);
    }

    private function buildFilters(): DoctorReportsFilterDTO
    {
        $get = fn($key) => $this->input->post($key);
        $filter = new DoctorReportsFilterDTO();

        if ($get('start')) {
            $filter->setFrom($get('start'));
        }

        if ($get('end')) {
            $filter->setTo($get('end'));
        }

        if ($get('classes')) {
            $filter->setClasses($get('classes'));
        }

        if ($get('grades')) {
            $filter->setGrades($get('grades'));
        }

        if ($get('genders')) {
            $filter->setGenders($get('genders'));
        }

        if ($get('test')) {
            $test = $get('test') === "all" ? null : $get('test');
            $filter->setTest($test);
        }

        return $filter;
    }

    private function getFilterAccountsIds(): array
    {
        $accountIds = $this->getAccountSupportedIds();

        if ($this->isMinistry()) {
            $filterSchools = collect($this->input->post('schools') ?? [])->filter(fn($id) => in_array($id, $accountIds));
            return $filterSchools->isEmpty() ? $accountIds : $filterSchools->toArray();
        }

        return $accountIds;
    }

    private function getPatientReport(): void
    {
        $this->load->model('DoctorSingleReport');

        $filters = $this->buildFilters();
        $ids = $this->getFilterAccountsIds();
        $this->DoctorSingleReport->setAccountsIds($ids);

        $data['results'] = $this->DoctorSingleReport->getResults($filters, self::LANGUAGE);
        $data['isMinistry'] = $this->isMinistry();
        $this->load->view('Shared/DoctorReports/SingleReport', $data);
    }

}