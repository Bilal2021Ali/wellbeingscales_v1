<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Speak_out extends CI_Model
{
    public $id;
    public $city = null;
    public $classes = null;
    public $gender = null;
    public $isMinistry = false;
    public $language = "en";

    /**
     * @param null $city
     */
    public function setCity($city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @param null $classes
     */
    public function setClasses($classes): self
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * @param string|null $gender
     * @return Speak_out
     */
    public function setGender(?string $gender = ""): self
    {
        if (!in_array(strtolower($gender), ['m', 'f'])) return $this;

        $this->gender = strtoupper($gender);
        return $this;
    }

    /**
     * @param null $isMinistry
     */
    public function setIsMinistry($isMinistry): self
    {
        $this->isMinistry = $isMinistry;
        return $this;
    }


    public function setId($id): self
    {
        $this->id = is_array($id) ? $id : [$id];
        return $this;
    }

    public function setLanguage(string $code): self
    {
        $this->language = strtolower($code);
        return $this;
    }


    public function categories($ids = []): array
    {
        $this->db->select('sv_set_template_lifereports.Id AS id, sv_set_template_lifereports.title_' . $this->language . ' AS name')
            ->from('sv_set_template_lifereports')
            ->join('l3_mylifereports', 'sv_set_template_lifereports.Id = l3_mylifereports.group_id', "LEFT")
            ->join('sv_set_template_lifereports_choices', 'sv_set_template_lifereports_choices.Id = l3_mylifereports.type_id');

        if (!empty($ids)) {
            $this->db->where_in('sv_set_template_lifereports.Id', $ids);
        }

        $this->db->group_by('sv_set_template_lifereports.Id')->order_by('sv_set_template_lifereports_choices.title_' . $this->language . '', 'ASC');
        return $this->db->get()->result_array();
    }

    public function choices($ids = []): array
    {
        $this->db->select('sv_set_template_lifereports_choices.Id AS id, sv_set_template_lifereports_choices.title_' . $this->language . ' AS name')
            ->from('sv_set_template_lifereports')
            ->join('l3_mylifereports', 'sv_set_template_lifereports.Id = l3_mylifereports.group_id', "LEFT")
            ->join('sv_set_template_lifereports_choices', 'sv_set_template_lifereports_choices.Id = l3_mylifereports.type_id');

        if (!empty($ids)) {
            $this->db->where_in('sv_set_template_lifereports.Id', $ids);
        }

        $this->db->group_by('sv_set_template_lifereports.Id')->order_by('sv_set_template_lifereports_choices.title_' . $this->language . '', 'ASC');
        return $this->db->get()->result_array();
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

    private function buildResultsQuery(array $filters, callable $builder): array
    {
        $data = $this->db->select("COUNT(DISTINCT l3_mylifereports.Id) as results , MONTH(l3_mylifereports.TimeStamp) AS month , sv_set_template_lifereports_choices.Id as choiceId")
            ->from('l3_mylifereports')
            ->join('sv_set_template_lifereports', 'sv_set_template_lifereports.Id = l3_mylifereports.group_id')
            ->join('sv_set_template_lifereports_choices', 'sv_set_template_lifereports_choices.Id = l3_mylifereports.type_id')
            ->join('l2_student', 'l2_student.Id = l3_mylifereports.user_id')
            ->join('l2_avatars', 'l2_avatars.For_User = l2_student.Id AND l2_avatars.Type_Of_User = "Student"', 'left')
            ->where_in('l2_student.Added_By', $this->id)
            ->where('YEAR(l3_mylifereports.TimeStamp)', $filters['year'] ?? date("Y"))
            ->order_by('l3_mylifereports.TimeStamp', 'DESC');

        $builder();

        $month = intval($filters['month'] ?? 0);
        if (!empty($filters['month']) && $month > 0 && $month <= 12) {
            $this->db->where('MONTH(l3_mylifereports.TimeStamp)', $filters['month']);
        }

        if (!empty($this->gender)) {
            $this->db->where_in('l2_student.Gender', $this->gender);
        }

        return $data->get()->result_array();
    }

    public function getResultsBasedOnCategory($category, $filters = []): array
    {
        $data = $this->buildResultsQuery($filters, function () use ($category) {
            $this->db
                ->where('l3_mylifereports.group_id', $category)
                ->group_by('MONTH(l3_mylifereports.TimeStamp)');
        });
        $data = $this->groupBy("month", $data);

        $results = [];
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($data[$i])) {
                $results[] = 0;
            } else {
                $results[] = intval($data[$i][0]['results']);
            }
        }

        return $results;
    }

    public function getResultsBasedOnClass($class, $classes, $filters = []): array
    {
        $data = $this->buildResultsQuery($filters, function () use ($class, $filters) {
            $this->db
                ->select("r_levels.Id as class_id")
                ->join("r_levels", "r_levels.Id = l2_student.Class")
                ->where('l2_student.Class', $class)
                ->group_by('l2_student.Class');
            if (!empty($filters['categoriesIds'])) {
                $this->db->where_in("l3_mylifereports.group_id", $filters['categoriesIds']);
            }
        });
        $data = $this->groupBy("class_id", $data);
        //echo $this->db->last_query();

        $results = [];
        $classesIds = array_column($classes, "Id");

        foreach ($classesIds as $classId) {
            if (!isset($data[$classId])) {
                $results[] = 0;
            } else {
                $results[] = intval($data[$classId][0]['results']);
            }
        }

        return $results;
    }


    public function getResultsBasedOnChoice($choice, $filters = []): int
    {
        $data = $this->buildResultsQuery($filters, function () use ($choice) {
            $this->db->where('l3_mylifereports.type_id', $choice)
                ->group_by('l3_mylifereports.type_id');
        });

        return sizeof($data);
    }

    public function getResultsBasedOnStudentGender($gender, $month)
    {
        $this->db->select("COUNT(DISTINCT l3_mylifereports.Id) as results")
            ->from('l3_mylifereports')
            ->join('sv_set_template_lifereports', 'sv_set_template_lifereports.Id = l3_mylifereports.group_id')
            ->join('sv_set_template_lifereports_choices', 'sv_set_template_lifereports_choices.Id = l3_mylifereports.type_id')
            ->join('l2_student', 'l2_student.Id = l3_mylifereports.user_id')
            ->where_in('l2_student.Added_By', $this->id)
            ->where('l2_student.Gender', $gender)
            ->where('YEAR(l3_mylifereports.TimeStamp)', date("Y"));

        if (!empty($month)) {
            $this->db->where('MONTH(l3_mylifereports.TimeStamp)', $month);
        }

        // disable the default gender filter
        // if (!empty($this->gender)) {
        //    $this->db->where_in('l2_student.Gender', $this->gender);
        // }

        return $this->db->group_by('l2_student.Gender')
            ->order_by('l3_mylifereports.TimeStamp', 'DESC')
            ->get()
            ->result_array();
    }

    public function getResultsBasedOnStudentClass($classes = [])
    {
        $this->db->select("COUNT(DISTINCT l3_mylifereports.Id) as results , l2_student.Class as class,r_levels.Class as className")
            ->from('l3_mylifereports')
            ->join('sv_set_template_lifereports', 'sv_set_template_lifereports.Id = l3_mylifereports.group_id')
            ->join('sv_set_template_lifereports_choices', 'sv_set_template_lifereports_choices.Id = l3_mylifereports.type_id')
            ->join('l2_student', 'l2_student.Id = l3_mylifereports.user_id')
            ->join('r_levels', 'r_levels.Id = l2_student.Class')
            ->where('YEAR(l3_mylifereports.TimeStamp)', date("Y"))
            ->where_in('l2_student.Added_By', $this->id);
        if (!empty($classes)) {
            $this->db->where_in('l2_student.Class', $classes);
        }
        return $this->db->group_by('l2_student.Class')->order_by('r_levels.Class', 'ASC')->get()->result_array();
    }

    private function buildCountersQuery($month = null)
    {
        $this->db->select("COUNT(DISTINCT l3_mylifereports.Id) as counter , l2_student.Class as class,r_levels.Class as className")
            ->from('l3_mylifereports')
            ->join('sv_set_template_lifereports', 'sv_set_template_lifereports.Id = l3_mylifereports.group_id')
            ->join('sv_set_template_lifereports_choices', 'sv_set_template_lifereports_choices.Id = l3_mylifereports.type_id')
            ->join('l2_student', 'l2_student.Id = l3_mylifereports.user_id')
            ->join('r_levels', 'r_levels.Id = l2_student.Class')
            ->where('YEAR(l3_mylifereports.TimeStamp)', date("Y"))
            ->where_in('l2_student.Added_By', $this->id);

        if (!empty($month)) {
            $this->db->where('MONTH(l3_mylifereports.TimeStamp)', $month);
        }
        if (!empty($this->gender)) {
            $this->db->where_in('l2_student.Gender', $this->gender);
        }

    }

    public function getResultsByClosingStatus($month = null, $isClosed = false): int
    {
        $this->buildCountersQuery($month);
        $this->db->where('l3_mylifereports.closed', $isClosed ? 1 : 0);

        $result = $this->db->order_by('r_levels.Class', 'ASC')->get()->result_array();
        return intval($result[0]['counter'] ?? 0);
    }

    public function getResultsBasedOnAnonymity($isAnonymous, $month): int
    {
        $this->buildCountersQuery($month);
        $this->db->where('l3_mylifereports.show_user_name', $isAnonymous ? 0 : 1);

        $result = $this->db->get()->result_array();
        return intval($result[0]['counter'] ?? 0);
    }

    public function getResultsForStatus($month = null, $status = null): int
    {
        $this->buildCountersQuery($month);

        if (is_numeric($status)) {
            $this->db->where('l3_mylifereports.status', $status);
        }
        $result = $this->db->order_by('r_levels.Class', 'ASC')->get()->result_array();

        return intval($result[0]['counter'] ?? 0);
    }

    public function getCounterForPriority($month = null, $priority = null): int
    {
        $this->buildCountersQuery($month);

        if ($priority !== null) {
            $this->db->where('l3_mylifereports.priority', $priority);
        }
        $result = $this->db->order_by('r_levels.Class', 'ASC')->get()->result_array();

        return intval($result[0]['counter'] ?? 0);
    }
}