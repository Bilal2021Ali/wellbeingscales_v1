<?php

namespace Traits\schools;

require_once __DIR__ . '/../../Enums/SpeakOutStatuses.php';
require_once __DIR__ . '/../../Enums/SpeakOutPriority.php';

use Enums\SpeakOutPriority;
use Enums\SpeakOutStatuses;

trait SpeakOut
{
    private function loadSpeakOutLang(): self
    {
        $this->load->vars(['language' => self::LANGUAGE]);
        $this->lang->load('SpeakOut', self::LANGUAGE === "EN" ? "english" : "arabic");
        return $this;
    }

    private function speakOutReportByCategory(): void
    {
        $speakOut = $this->getSpeakOutModel();
        $categoriesIds = $this->input->post("categories");
        $year = $this->input->post("year") ?? null;

        $data['months'] = array_map(function ($month) {
            return "'" . $month . "'";
        }, months_three_letters_names(self::LANGUAGE));
        $data['categories'] = $speakOut->categories($categoriesIds);
        $data['speakOut'] = $speakOut;
        $data['colors'] = self::COLORS;
        $data['filters'] = ['year' => $year];
        $data['isLine'] = intval($this->input->post("isLine")) === 1;

        $this->load->view("Shared/Schools/speak-out/inc/by-category", $data);
    }

    private function speakOutReportByChoice(): void
    {
        $speakOut = $this->getSpeakOutModel();

        $month = $this->input->post("month");

        $data['months'] = array_map(function ($month) {
            return "'" . $month . "'";
        }, months_three_letters_names(self::LANGUAGE));
        $data['choices'] = $speakOut->choices();
        $data['speakOut'] = $speakOut;
        $data['colors'] = self::COLORS;
        $data['filters'] = ['month' => $month];
        $data['results'] = array_map(function ($choice) use ($data, $speakOut) {
            return $speakOut->getResultsBasedOnChoice($choice['id'], $data['filters']);
        }, $data['choices']);

        $this->load->view("Shared/Schools/speak-out/inc/by-choice", $data);
    }

    private function speakOutReportByGender(): void
    {
        $speakOut = $this->getSpeakOutModel();

        $month = $this->input->post("month");
        $data['results']['m'] = intval($speakOut->getResultsBasedOnStudentGender("M", $month)[0]['results'] ?? 0);
        $data['results']['f'] = intval($speakOut->getResultsBasedOnStudentGender("F", $month)[0]['results'] ?? 0);

        $this->load->view("Shared/Schools/speak-out/inc/by-gender", $data);
    }

    private function speakOutReportByIdentity(): void
    {
        $speakOut = $this->getSpeakOutModel();

        $month = $this->input->post("month");
        $data['results']['known'] = $speakOut->getResultsBasedOnAnonymity(false, $month);
        $data['results']['hidden'] = $speakOut->getResultsBasedOnAnonymity(true, $month);

        $this->load->view("Shared/Schools/speak-out/inc/by-identity", $data);
    }

    private function speakOutReportByClass(): void
    {
        $speakOut = $this->getSpeakOutModel();

        $categoriesIds = $this->input->post("categories");
        $year = $this->input->post("year") ?? null;

        $data['classes'] = $this->isMinistry()
            ? $this->getAllMinistryClasses()
            : $this->schoolHelper->school_classes($this->sessionData['admin_id']);

        $data['speakOut'] = $speakOut;
        $data['colors'] = self::COLORS;
        $data['filters'] = [
            'year' => $year,
            'categoriesIds' => $categoriesIds
        ];
        $data['classesNames'] = array_map(function ($class) {
            return "'" . $class['Class'] . "'";
        }, $data['classes']);

        $this->load->view("Shared/Schools/speak-out/inc/by-class", $data);
    }

    private function speakOutStatusesCounters(): void
    {
        $speakOut = $this->getSpeakOutModel();

        $month = $this->input->post("month") ?? 1;
        $data['total'] = $speakOut->getResultsForStatus($month);
        $data['results']['closed'] = $speakOut->getResultsByClosingStatus($month, true);
        $data['results']['pending'] = $data['total'] - $data['results']['closed'];

        $this->load->view("Shared/Schools/speak-out/inc/by-status", $data);
    }

    private function speakOutReportByStatus(): void
    {
        $speakOut = $this->getSpeakOutModel();

        $month = $this->input->post("month") ?? 1;
        $data['results']['closed'] = $speakOut->getResultsByClosingStatus($month, true);
        $data['results']['open'] = $speakOut->getResultsByClosingStatus($month, false);

        $this->load->view("Shared/Schools/speak-out/inc/by-open-status", $data);
    }

    private function speakOutCountersByPriority(): void
    {
        $speakOut = $this->getSpeakOutModel();

        $month = $this->input->post("month") ?? 1;
        $data['total'] = $speakOut->getResultsForStatus($month);
        $data['results']['low'] = $speakOut->getCounterForPriority($month, SpeakOutPriority::LOW);
        $data['results']['average'] = $speakOut->getCounterForPriority($month, SpeakOutPriority::AVERAGE);
        $data['results']['high'] = $speakOut->getCounterForPriority($month, SpeakOutPriority::HIGH);

        $this->load->view("Shared/Schools/speak-out/inc/by-priority", $data);
    }

    public function speak_out_links(): void
    {
        $this->loadSpeakOutLang();
        $type = self::TYPE === "school" ? "schools" : "DashboardSystem";
        $data['page_title'] = 'Speak Out';
        $data['links'] = [];
        if (!$this->isMinistry()) {
            $data['links'][] = [
                'name' => __("speak-out-reports"),
                "link" => base_url(self::LANGUAGE . '/' . $type . '/speak-out'),
                "desc" => "",
                "icon" => "library.png"
            ];
        }
        $data['links'][] = [
            'name' => __("speak-out-dashboard"),
            "link" => base_url(self::LANGUAGE . '/' . $type . '/speak-out-dashboard'),
            "desc" => "",
            "icon" => "library.png"
        ];
        $data['isMinistry'] = $this->isMinistry();
        $data['months'] = months_names(self::LANGUAGE);
        $this->show('Shared/Schools/speak-out/links-list', $data);
    }

    public function speak_out_dashboard(): void
    {
        $speakOut = $this->loadSpeakOutLang()->getSpeakOutModel();
        $data['page_title'] = 'Speak Out';

        if ($this->input->method() === "post") {
            $type = $this->input->post("type");
            switch ($type) {
                case "category":
                    $this->speakOutReportByCategory();
                    break;
                case "gender":
                    $this->speakOutReportByGender();
                    break;
                case "class":
                    $this->speakOutReportByClass();
                    break;
                case "status":
                    $this->speakOutStatusesCounters();
                    break;
                case "priority":
                    $this->speakOutCountersByPriority();
                    break;
                case "openingStatus":
                    $this->speakOutReportByStatus();
                    break;
                case "choice":
                    $this->speakOutReportByChoice();
                    break;
                case "identity":
                    $this->speakOutReportByIdentity();
                    break;
            }
            return;
        }
        $data['categories'] = $speakOut->categories();

        $years = array();
        for ($i = 0; $i < 20; $i++) {
            $years[] = date("Y", strtotime("-$i year"));
        }
        $data['isMinistry'] = $this->isMinistry();
        $data['years'] = $years;
        $data['months'] = months_names(self::LANGUAGE);
        if ($data['isMinistry']) {
            $data += $this->getFiltersValues();
        } else {
            $data['classes'] = $this->schoolHelper->school_classes($this->sessionData['admin_id']);
        }
        $this->show("Shared/Schools/speak-out/dashboard", $data);
    }

    private function getAllMinistrySchools()
    {
        $this->load->model('ministry/sv_ministry_reports');
        $schools = $this->sv_ministry_reports->our_schools();
        $this->response->abort_if(404, empty($schools));

        return $schools;
    }

    private function getAllMinistryClasses($schools = null)
    {
        $lang = self::LANGUAGE === "EN" ? "" : "_ar";
        $schools = $schools === null ? $this->getAllMinistrySchools() : $schools;

        return $this->db->query("SELECT * , `r_levels`.`Class" . $lang . "` AS Class , `r_levels`.`Id` AS Id  FROM l2_school_classes
            JOIN `r_levels` ON `r_levels`.`Id` = `l2_school_classes`.`class_key`
            WHERE `l2_school_classes`.`school_id` IN (" . implode(",", array_column($schools, "Id")) . ") ORDER BY `r_levels`.`Id` ASC ")->result_array();
    }

    private function getCitiesBasedOnSchools(): array
    {
        return $this->db->order_by("name", "ASC")
            ->join("l1_school", "l1_school.Country = r_countries.Id")
            ->where("l1_school.Added_By", $this->sessionData['admin_id'])
            ->group_by("r_countries.Id")
            ->get('r_countries')
            ->result_array();
    }

    private function getFiltersValues(): array
    {
        $this->load->model('ministry/sv_ministry_reports');
        $data['schools'] = $this->getAllMinistrySchools();

        $data['language'] = self::LANGUAGE;
        $data['cities'] = $this->db->order_by("Name_EN", "ASC")->get('r_cities')->result_array();
        $data['countries'] = $this->isMinistry()
            ? $this->getCitiesBasedOnSchools()
            : $this->db->order_by("name", "ASC")->get('r_countries')->result_array();
        $data['classes'] = $this->getAllMinistryClasses($data['schools']);

        return $data;
    }

    public function getSpeakOutReport($id)
    {
        return $this->db->select("*")
            ->join("l2_student", "l2_student.id = `l3_mylifereports`.`user_id`")
            ->where("l3_mylifereports.Id", $id)
            ->where("l2_student.Added_By", $this->sessionData['admin_id'])
            ->limit(1)
            ->get("l3_mylifereports")
            ->row();
    }

    public function showSpeakOutComments(): void
    {
        $data['report'] = $this->getSpeakOutReport($this->uri->segment(4));
        if (!empty($data['report'])) {
            $data['page_title'] = 'Qlick Health | speak out action';
            $data['staffs'] = $this->db->get_where("l2_staff", ["Added_By" => $this->sessionData['admin_id']])->result_array();
            $data['teachers'] = $this->db->get_where("l2_teacher", ["Added_By" => $this->sessionData['admin_id']])->result_array();
            $data['actions'] = $this->db->query("SELECT l3_mylifereports_actions.* , 
                    CASE 
                        WHEN `l3_mylifereports_actions`.`usertype` = 'staff' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_staff` WHERE `l2_staff`.`Id` = `l3_mylifereports_actions`.`userid` )
                        WHEN `l3_mylifereports_actions`.`usertype` = 'teacher' THEN (SELECT CONCAT(`F_name_EN`,' ',`L_name_EN`) FROM `l2_teacher` WHERE `l2_teacher`.`Id` = `l3_mylifereports_actions`.`userid` )
                        ELSE 'We cant find this user !'
                    END AS action_by 
                    FROM l3_mylifereports_actions WHERE report_id = '" . $this->uri->segment(4) . "' ")->result_array();
            if (self::TYPE === "schools" && $data['report']->status == 0) {
                $this->db->set('status', '1');
                $this->db->where('Id', $this->uri->segment(4));
                $this->db->update('l3_mylifereports');
            }
            $this->load->helper("speak_out");
            $this->show(self::LANGUAGE . '/schools/speak_out_action', $data);
        } else {
            redirect('EN/schools/speak_out');
        }
    }

    public function showSpeakOutReports($country = null, $city = null): void
    {
        $ids = $this->getSpeakOutUsersIds();
        $isMinistry = $this->isMinistry();
        $this->response->abort_if(404, empty($ids));

        $this->loadSpeakOutLang();
        $classes = $this->isMinistry() ? ($this->input->post("classes") ?? null) : null;
        $languageCode = strtolower(self::LANGUAGE);

        $this->db->select("l3_mylifereports.Id AS id , l3_mylifereports.show_user_name, l3_mylifereports.status , l3_mylifereports.priority , l3_mylifereports.closed ,
            l3_mylifereports.description_" . $languageCode . " as description , l3_mylifereports.TimeStamp AS reportDateAndTime , sv_set_template_lifereports.title_" . $languageCode . " AS groupName ,  
            sv_set_template_lifereports_choices.title_" . $languageCode . " AS reportType , 
            l2_student.Id as userid ,CONCAT(`l2_student`.`F_name_" . self::LANGUAGE . "` , ' ' , `l2_student`.`L_name_" . self::LANGUAGE . "`) AS username  , `l2_avatars`.`Link` AS userAvatar,
            (SELECT COUNT(Id) FROM `l3_mylifereportsmedia` WHERE `l3_mylifereportsmedia`.`report_id` = `l3_mylifereports`.`Id` ) AS Media");
        $this->db->select('(SELECT COUNT(Id) FROM `l3_mylifereportsmedia` WHERE `l3_mylifereportsmedia`.`report_id` = `l3_mylifereports`.`Id` ) AS Media');
        $this->db->select("CONCAT(`l2_student`.`F_name_EN` , ' ' , `l2_student`.`L_name_EN`) AS username", FALSE);
        $this->db->select("`l2_avatars`.`Link` AS useravatar", FALSE);

        $this->db->from('l3_mylifereports');
        $this->db->join('sv_set_template_lifereports', 'sv_set_template_lifereports.Id = l3_mylifereports.group_id');
        $this->db->join('sv_set_template_lifereports_choices', 'sv_set_template_lifereports_choices.Id = l3_mylifereports.type_id');
        $this->db->join('l2_student', 'l2_student.Id = l3_mylifereports.user_id');
        $this->db->join('l2_avatars', "`l2_avatars`.`For_User` = `l2_student`.`Id` AND `l2_avatars`.`Type_Of_User` = 'Student'", "LEFT");
        $this->db->join('l1_school', "`l1_school`.`Id` = `l2_student`.`Added_By`");

        if ($isMinistry) {
            $this->db->where('l1_school.Added_By', $this->sessionData['admin_id']);
            if (!empty($country)) {
                $this->db->where('l1_school.Country', $country);
            }
            if (!empty($city)) {
                $this->db->where('l1_school.Citys', $city);
            }
        } else {
            $this->db->where('l1_school.Id', $this->sessionData['admin_id']);
        }

        if (!empty($classes) && is_array($classes)) {
            $this->db->where_in('l2_student.Class', $classes);
        }

        $this->db->order_by('l3_mylifereports.TimeStamp', 'DESC');
        $data['reports'] = $this->db->get()->result_array();

        $data['isMinistry'] = $isMinistry;
        $this->load->helper("speak_out");
        if ($data['isMinistry']) {
            $this->load->view("Shared/Education/speak-out-list", $data);
        } else {
            $this->show("EN/schools/speak_out", $data);
        }
    }
}
