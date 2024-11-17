<?php

namespace App\Traits\schools;

use App\Enums\UserTypeEnum;

/**
 * @property \TaskReports $taskReports
 */
trait TasksReport
{
    abstract private function getAccountSupportedIds(): array;

    protected function prepareTaskReport(): void
    {
        $this->load->vars(['language' => self::LANGUAGE]);
        $this->lang->load('TasksReport', get_full_language_name(self::LANGUAGE));
        $this->load->model('schools/taskReports');
    }

    public function task_report(): void
    {
        $this->prepareTaskReport();

        $id = $this->uri->segment(4);
        $this->response->abort_if(404, empty($id) || !is_numeric($id) || $id < 1);
        $ids = $this->getAccountSupportedIds();

        $student = $this->db
            ->where('id', $id)
            ->where_in('Added_By', $ids)
            ->get('l2_student')
            ->row_array();
        $this->response->abort_if(404, empty($student));

        $data['all'] = $this->taskReports->get_all_tasks();
        $data['passed'] = $this->taskReports->get_passed_tasks($id, UserTypeEnum::STUDENT);
        $this->show('Shared/TaskReport/report', $data);
    }

}