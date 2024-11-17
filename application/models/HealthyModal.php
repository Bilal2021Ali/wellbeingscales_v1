<?php

class HealthyModal extends CI_Model
{

    public $language = '';
    const SUPPORTED_LANGUAGES = [
        'en' => [
            'code' => 'en',
            'name' => 'english'
        ],
//        'dk' => [
//            'code' => 'dk',
//            'name' => 'danish'
//        ],
//        'fin' => [
//            'code' => 'fin',
//            'name' => 'finnish'
//        ],
//        'gre' => [
//            'code' => 'gre',
//            'name' => 'greek'
//        ],
//        'pol' => [
//            'code' => 'pol',
//            'name' => 'polish'
//        ],
//        'pt' => [
//            'code' => 'pt',
//            'name' => 'portuguese'
//        ],
//        'rus' => [
//            'code' => 'rus',
//            'name' => 'russian'
//        ],
//        'sl' => [
//            'code' => 'sl',
//            'name' => 'slovenian'
//        ],
//        'es' => [
//            'code' => 'es',
//            'name' => 'spanish'
//        ],
        'ar' => [
            'code' => 'ar',
            'name' => 'arabic'
        ],
    ];
    public $sessionData = null;

    public function __construct()
    {
        parent::__construct();
        $sessionData = $this->session->userdata('admin_details');
        $this->sessionData = $sessionData;
    }


    public function langauge($key, $code = false)
    {
        $this->language = self::SUPPORTED_LANGUAGES[$key][$code ? 'name' : 'code'];
        $this->load->library('session');
        return $this;
    }

    public function get()
    {
        return [
            'categories' => self::categories(),
            'choices' => $this->db->order_by('indexKey', 'acs')->get("healthy_choices")->result_array(),
            'priorities' => $this->db->order_by('indexKey', 'acs')->get("healthy_priority")->result_array(),
        ];
    }

    public function categories(): array
    {
        $categories = $this->db
            ->select("healthy_categories.*,healthy_categories.id as CID,healthy_questions.id as Qid, healthy_questions.orientation_" . (self::SUPPORTED_LANGUAGES[$this->language]['name'] ?? 'english') . " as QTitle")
            ->join("healthy_questions", "healthy_questions.healthy_category_id = healthy_categories.id")
            ->get("healthy_categories")->result_array();

        return self::groupByCategory("CID", $categories);
    }

    public function ValidateLanguage($key)
    {
        $key = strtolower($key);
        return in_array($key, array_keys(self::SUPPORTED_LANGUAGES));
    }

    private static function groupByCategory($key, $data): array
    {
        $result = array();
        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                if (isset($result[$val[$key]])) {
                    $result[$val[$key]]['questions'][] = [
                        'Qid' => $val['Qid'],
                        'QTitle' => $val['QTitle'],
                    ];
                } else {
                    $result[$val[$key]] = [
                        'title' => $val['ar_title'],
                        'description' => $val['description'],
                        'created_at' => $val['created_at'],
                        'questions' => [
                            [
                                'Qid' => $val['Qid'],
                                'QTitle' => $val['QTitle'],
                            ]
                        ]
                    ];
                }
            } else {
                $result[""][] = $val;
            }
        }
        return $result;
    }

    public function groupBy($key, $data)
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

    public function save($mergedData)
    {
        $language = $this->uri->segment(3) ? $this->uri->segment(3) : "en";

        $this->db->trans_start();

        $data = [
            'owner' => $this->sessionData['admin_id'],
            'language' => $language
        ];

        $this->db->insert('healthy_sessions', $data);
        $sessionKey = $this->db->insert_id();

        $data = [];
        foreach ($mergedData as $value) {
            $data[] = [
                'sessionKey' => $sessionKey,
                'answerValue' => $value['value'],
                'answerId' => $value['id'],
                'priority' => $value['priority'],
                'priorityValue' => $value['priorityValue'],
                'questionId' => $value['question'],
            ];
        }
        $this->db->insert_batch('healthy_results', $data);

        $this->db->trans_complete();

        return $sessionKey;
    }

    private function calculateAvgResult($data, $type)
    {
        $data = is_array($data) ? array_values($data) : null;
        if (empty($data)) {
            return 0;
        }
        $sum = array_sum(array_column($data, $type));
        return round($sum, -1);
    }

    private function toResults($data)
    {
        $results = [];
        foreach ($data['categories'] as $category) {
            $values = array_filter(($data['results']), function ($item) use ($category) {
                return $item['QCID'] == $category['id'];
            });
            $results[] = [
                'en_title' => $category['en_title'],
                'ar_title' => $category['ar_title'],
                'id' => $category['id'],
                'priority' => $this->calculateAvgResult($values, 'priorityValue'),
                'answers' => $this->calculateAvgResult($values, 'answerValue')
            ];
        }

        return $results;
    }

    public function getResults($id, $schools = null)
    {
        $this->db->select('healthy_sessions.* , healthy_sessions.id as SID , healthy_results.* , healthy_results.id AS RID ,
         healthy_choices.' . $this->language . '_title as choiceName , healthy_priority.' . $this->language . '_title as priorityName , healthy_questions.id as QID , healthy_questions.healthy_category_id as QCID')
            ->join("healthy_questions", "healthy_questions.id = healthy_results.questionId")
            ->join("healthy_sessions", "healthy_results.sessionKey = healthy_sessions.id")
            ->join("healthy_choices", "healthy_results.answerId = healthy_choices.id")
            ->join("healthy_priority", "healthy_results.priority = healthy_priority.id")
            ->where("healthy_sessions.id", $id);
        if ($schools !== null) {
            $this->db->where_in("healthy_sessions.owner", $schools);
        } else {
            $this->db->where("healthy_sessions.owner", $this->sessionData['admin_id']);
        }
        $data['results'] = $this->db->get("healthy_results")->result_array();
        $data['categories'] = $this->db->get("healthy_categories")->result_array();
        $data['questions'] = $this->groupBy('healthy_category_id', $this->db->get("healthy_questions")->result_array());
        $data['choices'] = $this->db->order_by('indexKey', 'acs')->get("healthy_choices")->result_array();
        $data['priorities'] = $this->db->order_by('indexKey', 'acs')->get("healthy_priority")->result_array();
        $data['statistics'] = $this->toResults($data);
        return $data;
    }

}