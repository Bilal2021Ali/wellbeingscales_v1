<?php

namespace Traits\schools;

use Throwable;

trait ClimatesNewReport
{
    private function loadLanguage()
    {
        $language = self::LANGUAGE === "EN" ? "english" : "arabic";
        $this->lang->load('Climates', $language);
        $this->load->vars(['language' => self::LANGUAGE]);
    }

    public function new_climate_report()
    {
        $this->response->abort(); // mark as 404 for now

        $this->loadLanguage();
        $id = $this->uri->segment(4) ?? null;
        $this->load->model('schools/sv_school_reports');
        $data['page_title'] = "Qlick Health | Climates Reports ";
        if (!empty($id) && is_numeric($id)) {
            $this->showReport($id, $this->input->get("by-category") !== null, $data);
        } else {
            $this->showList($data);
        }
    }

    private function getCategories($list)
    {
        $results = [];

        foreach ($list as $item) {
            $counter = $results[$item['Cat_id']]['surveys'] ?? 0;
            $results[$item['Cat_id']] = [
                'id' => $item['Cat_id'],
                'category' => $item['Cat_en'],
                'surveys' => $counter + 1
            ];
        }

        return array_values($results);
    }


    private function showList($data)
    {
        $data['publishedSurveys'] = $this->sv_school_reports->GetClimatesurveys([], null, true);
        $data['categories'] = $this->getCategories($data['publishedSurveys']);
        $data['today'] = date("Y-m-d");
        $data['language'] = self::LANGUAGE;
        $this->show("Shared/Schools/climates/list", $data);
    }

    private function getGenders($genders): string
    {
        return implode(", ", array_map(function ($code) {
            return self::GENDERS[$code] ?? "";
        }, explode(",", $genders)));
    }

    private function getUsersTypes($types): string
    {
        return implode(", ", array_map(function ($code) {
            return self::USERS_TYPES[$code] ?? "";
        }, explode(",", $types)));
    }

    private function showReport($id, $isCategory, $data)
    {
        $filters = [];
        if ($isCategory) {
            $filters['categoryId'] = $id;
        } else {
            $filters['surveyid'] = $id;
        }
        $data['surveys'] = array_map(function ($item) use ($filters) {
            $item['genders'] = $this->getGenders($item['genderslist']);
            $item['usersTypes'] = $this->getUsersTypes($item['typeslist']);
            return $item;
        }, $this->sv_school_reports->GetClimatesurveys($filters, null, true));
        $data['id'] = $id;
        $this->response->abort_if(404, empty($data['surveys']));

        $this->show("Shared/Schools/climates/report", $data);
    }

    private function controlFilters(array &$data)
    {
        $data["filterssource"]['classes'] = $this->schoolHelper->school_classes($this->sessionData['admin_id']);
        $data["filterssource"]['genders'] = [
            [
                "name" => "M",
                "display" => "Male"
            ],
            [
                "name" => "F",
                "display" => "Female"
            ]
        ];
        $data["filterssource"]['category'] = $this->sv_school_reports->getclimatesurveyslibrary(true);
        $data["filterssource"]['userstypes'] = $this->helper->get();
        // showing old filters values
        $data['filters'] = [
            'class' => ($this->input->post("class[]") == null || in_array("all", $this->input->post("class[]"))) ? [] : $this->input->post("class[]"),
            'gender' => [],
            'category' => ($this->input->post("category[]") == null || in_array("all", $this->input->post("category[]"))) ? [] : $this->input->post("category[]"),
            'usertype' => ($this->input->post("usertype[]") == null || in_array("all", $this->input->post("usertype[]"))) ? [] : $this->input->post("usertype[]"),
            "from" => $this->input->post("start") ?? date("Y-m-d"),
            "to" => $this->input->post("end") ?? date("Y-m-d"),
        ];
        // values transforming
        if (!empty($this->input->post("gender"))) {
            foreach ($this->input->post("gender") as $filter) {
                $data["filters"]["gender"][] = "'" . $filter . "'";
            }
        }
    }

    private function addValuesToChoices(array $choices)
    {
        $arrayLength = sizeof($choices);
        $avg = (($arrayLength - 1) < 1) ? 0 : (100 / ($arrayLength - 1));

        $result = [];
        foreach ($choices as $key => $choice) {
            $result[] = array_merge($choice, ['value' => $key * $avg]);
        }

        return $result;
    }

    private function groupBy($key, $data): array
    {
        $result = array();
        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }
        return $result;
    }

    private function calculateAvgResult(array $choices, array $results)
    {
        $groupedChoices = array_map(function ($item) {
            return $item[0]['value'] ?? 0;
        }, $this->groupBy("id", $choices));
        $result = 0;

        foreach ($results as $key => $item) {
            $result += $groupedChoices[$item['choiceId']] ?? 0;
        }

        $resultsSize = sizeof($results);
        try {
            return $resultsSize < 1 ? 0 : ($result / $resultsSize);
        } catch (Throwable $th) {
            return 0;
        }
    }

    private function getResults($id = null, array $filters = [])
    {
        $filter = empty($filters) ? "" : $this->ClimateConditionsBuilder($filters);
        $byId = empty($id) ? "" : "AND spc.Id = " . $id;

        return $this->db->query("SELECT sscc.`Climate_id`,
        setd.title_en as title,
        sca.Id as answerId,
        sca.user_id as userId,
        ssc.Id as choiceId
        FROM `scl_climate_answers` AS sca ,
            `scl_published_claimate` spc,
            `scl_st_climate` AS sscc ,
            `scl_st_choices` AS ssc,
            `scl_st0_climate` AS ss0c,
            `sv_questions_library` AS sq,
            `sv_sets` AS setd
        WHERE sca.`climate_id` =spc.`Id`
            AND spc.`climate_id` =sscc.`id`  
            AND sscc.`Climate_id` =ssc.`servey_id`
            AND sca.`answer_id` =ssc.id
            AND ss0c.`Id` = sscc.`Climate_id`
            AND sq.`Id` = ss0c.`question_id`
            AND setd.`Id` = ss0c.`set_id`
            AND spc.By_school = " . $this->sessionData['admin_id'] . "
            AND sca.school_id = " . $this->sessionData['admin_id'] . "
          $filter
          $byId
        GROUP BY sca.`Id`")->result_array();
    }

    private function getChoices($surveyId, $id, array $filters = [])
    {
        return $this->db
            ->select('scl_st_choices.* , sv_questions_library.en_title AS questionName_en , sv_questions_library.ar_title AS questionName_ar,
                    sv_st_category.Cat_en, sv_st_category.Cat_ar,sv_sets.title_en AS set_name_en, sv_sets.title_ar AS set_name_ar ')
            ->select("(SELECT COUNT(DISTINCT sca.Id) FROM scl_climate_answers AS sca WHERE sca.climate_id = " . $id . " AND sca.school_id = " . $this->sessionData['admin_id'] . " AND  sca.answer_id = scl_st_choices.id " . $this->ClimateConditionsBuilder(array_merge($filters, ['disableTime' => true])) . ") AS selects")
            ->select('sv_set_template_answers_choices.title_en , sv_set_template_answers_choices.title_ar')
            ->from('scl_st_choices')
            ->join('sv_set_template_answers_choices', 'sv_set_template_answers_choices.Id = scl_st_choices.choice_id')
            ->join('scl_st0_climate', 'scl_st0_climate.Id = scl_st_choices.servey_id')
            ->join('sv_st_category', 'sv_st_category.Id = scl_st0_climate.category')
            ->join('sv_questions_library', 'sv_questions_library.Id = scl_st0_climate.question_id')
            ->join('sv_sets', 'sv_sets.Id = scl_st0_climate.set_id')
            ->where('scl_st0_climate.Id', $surveyId)
            ->order_by('position', 'ASC')
            ->get()->result_array();
    }

    private function getBarColor($value): string
    {
        $value = intval($value);

        switch ($value) {
            case $value >= 75 && $value <= 100:
                $color = "primary";
                break;
            case $value >= 50 && $value <= 74:
                $color = "success";
                break;
            case $value >= 25 && $value <= 49:
                $color = "info";
                break;
            case $value >= 1 && $value <= 24:
                $color = "warning";
                break;
            default :
                $color = "danger";
        }

        return $color;
    }

    public function climate_results_charts()
    {
        $data['page_title'] = "Qlick Health | Climates Results ";

        $this->load->model('schools/sv_school_reports');
        $this->load->model('helper');
        $this->loadLanguage();

        $id = $this->uri->segment(4) ?? null;
        $this->response->abort_if(404, empty($id));

        $data['survey'] = $this->sv_school_reports->GetClimatesurveys([], $id, true);
        $data['id'] = $id;
        $data['showFilters'] = $this->input->get("withFilters") !== null;
        $this->response->abort_if(404, empty($data['survey']));

        $this->controlFilters($data);
        $filters = $data['showFilters'] ? $data['filters'] : [];
        $data['results'] = $this->getResults($id, $filters);

        $choices = $this->getChoices($data['survey']->main_survey_id, $id, $data['filters']);
        $data['choices'] = $this->addValuesToChoices($choices);

        $data['colors'] = self::COLORS;
        $data['value'] = $this->calculateAvgResult($data['choices'], $data['results']);

        $this->show("Shared/Schools/climates/results", $data);
    }

    public function climate_users_results()
    {
        $this->loadLanguage();
        $data['page_title'] = "Qlick Health | Climates Results ";
        $this->load->model('helper');
        $this->load->model('schools/sv_school_reports');
        $data['bars'] = [
            '75-100' => 'primary',
            '50-74' => 'success',
            '25-49' => 'info',
            '1-24' => 'warning',
            '0' => 'danger',
        ];
        $data['usersTypes'] = self::USERS_TYPES;
        array_pop($data['usersTypes']);

        $id = $this->uri->segment(4) ?? null;
        $this->response->abort_if(404, empty($id));

        $data['survey'] = $this->sv_school_reports->GetClimatesurveys([], $id, true);
        $data['id'] = $id;
        $this->response->abort_if(404, empty($data['survey']));

        $type = $this->input->get("type");
        if ($this->input->method() === "post") {
            $this->showReportForUserType($type, $data['survey']->main_survey_id, $id);
            return;
        }

        $this->show("Shared/Schools/climates/users", $data);
    }


    private function getUsersList(string $type): array
    {
        $users = [];
        switch ($type) {
            case "staff":
                $users = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS name , l2_staff.Id as id , l2_avatars.Link as avatar, r_positions_sch.Position as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_staff` . `Id` and `l2_avatars` . `Type_Of_User` = 'Staff'", "LEFT")
                    ->join("r_positions_sch", "`r_positions_sch`.`Id` = `l2_staff`.`Position`", "LEFT")
                    ->group_by("l2_staff.Id")
                    ->get("l2_staff")
                    ->result_array();
                break;
            case "students":
                $users = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS name, l2_student.Id as id , l2_avatars.Link as avatar, r_levels.Class as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_student` . `Id` and `l2_avatars` . `Type_Of_User` = 'Student'", "LEFT")
                    ->join('r_levels', 'r_levels.Id = l2_student.Class')
                    ->group_by("l2_student.Id")
                    ->get("l2_student")
                    ->result_array();
                break;
            case "teachers":
                $users = $this->db->select("CONCAT(`F_name_EN`,' ',`L_name_EN`) AS name, l2_teacher.Id as id , l2_avatars.Link as avatar")
                    ->select("(SELECT GROUP_CONCAT(r_levels.Class) 
                FROM `l2_teachers_classes` 
                JOIN `r_levels` ON `r_levels`.`Id` = `l2_teachers_classes`.`class_id`
                WHERE `l2_teachers_classes`.`teacher_id` = `l2_teacher`.`Id` ) as extraData")
                    ->join("l2_avatars", " `l2_avatars` . `For_User` = `l2_teacher` . `Id` and `l2_avatars` . `Type_Of_User` = 'Teacher'", "LEFT")
                    ->group_by("l2_teacher.Id")
                    ->get("l2_teacher")
                    ->result_array();
                break;
        }

        return $users;
    }

    public function showReportForUserType(string $type, string $mainSurveyId, $id)
    {
        $choices = $this->addValuesToChoices($this->getChoices($mainSurveyId, $id, ['disableTime' => true]));

        $keyMapper = [
            'staff' => 1,
            'students' => 2,
            'teachers' => 3,
        ];
        $labels = [
            'staff' => "Position",
            'students' => "Class",
            'teachers' => "Classes",
        ];
        $key = $keyMapper[$type];
        $label = $labels[$type];

        $filter = [
            'usertype' => [$key],
            'disableTime' => true
        ];

        $results = $this->groupBy("userId", $this->getResults($id, $filter));
        $users = $this->getUsersList($type);


        foreach ($users as $key => $user) {
            $result = $this->calculateAvgResult($choices, $results[$user['id']] ?? []);
            $users[$key]['result'] = $result;
            $users[$key]['barColor'] = $this->getBarColor($result);
        }

        $this->load->view("Shared/Schools/climates/results-by-users-type", ['users' => $users, 'type' => $type, 'label' => $label]);
    }
}