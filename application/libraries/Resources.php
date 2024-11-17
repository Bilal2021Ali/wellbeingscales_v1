<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Resources
{
    public $tables = [
		
		'Position' => [
            "table" => "r_positions",
            "inputs" => [
                [
                    "input" => "AR_Position",
                    "validation" =>  ['AR Position', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "Position",
                    "validation" =>  ['EN Position', 'trim|required|min_length[3]|max_length[200]'],
                ]
            ],"icon" => "positions.png",
        ],
		
		'Directors-Positions' => [
            "table" => "r_positions_gm",
            "inputs" => [
                [
                    "input" => "AR_Position",
                    "validation" =>  ['AR Position', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "Position",
                    "validation" =>  ['EN Position', 'trim|required|min_length[3]|max_length[200]'],
                ]
            ],"icon" => "positions_gm.png",
        ],
		
		'Staff-Position' => [
            "table" => "r_positions_sch",
            "inputs" => [
                [
                    "input" => "AR_Position",
                    "validation" =>  ['AR Position', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "Position",
                    "validation" =>  ['EN Position', 'trim|required|min_length[3]|max_length[200]'],
                ]
            ],"icon" => "r_positions_sch.png",
        ],
		
		'Teacher-Position' => [
            "table" => "r_positions_tech",
            "inputs" => [
                [
                    "input" => "AR_Position",
                    "validation" =>  ['AR Position', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "Position",
                    "validation" =>  ['EN Position', 'trim|required|min_length[3]|max_length[200]'],
                ]
            ],"icon" => "r_positions_tech.png",
        ],
		
		'Classes' => [
            "table" => "r_levels",
            "inputs" => [
                [
                    "input" => "Class_ar",
                    "validation" =>  ['AR Position', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "Class",
                    "validation" =>  ['EN Position', 'trim|required|min_length[3]|max_length[200]'],
                ]
            ],"icon" => "class.png",
        ],
		
        'Cars-Levels' => [
            "table" => "r_cars_levels",
            "inputs" => [
                [
                    "input" => "Class",
                    "validation" =>  ['Class', 'trim|required|min_length[3]|max_length[200]'],
                ]
            ],"icon" => "car.png",
        ],
		
        'Company-Type' => [
            "table" => "r_company_type",
            "inputs" => [
                [
                    "input" => "Company_Type",
                    "validation" =>  ['Company Type', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "comments",
                    "validation" =>  ['comments', 'trim|required|min_length[3]|max_length[200]'],
                ]
            ],"icon" => "r_company_type.png",
        ],
        'dental-conditions' => [
            "table" => "r_dental_conditions",
            "inputs" => [
                [
                    "input" => "Dental_Conditions_AR",
                    "validation" =>  ['Dental Conditions AR', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "Dental_Conditions_EN",
                    "validation" =>  ['Dental Conditions EN', 'trim|required|min_length[3]|max_length[200]'],
                ]
            ],"icon" => "r_dental_conditions.png",
        ],
        'device-type' => [
            "table" => "r_device_type",
            "inputs" => [
                [
                    "input" => "user_type",
                    "validation" => ['user type', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "device_type_en",
                    "validation" => ['Device Type EN', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "device_type_ar",
                    "validation" => ['Device Type AR', 'trim|required|min_length[3]|max_length[200]'],
                ],
                [
                    "input" => "message_code_in",
                    "validation" => ['Message Code In', 'trim|required|integer'],
                ],
                [
                    "input" => "message_code_out",
                    "validation" => ['Message Code Out', 'trim|required|integer'],
                ],
            ],"icon" => "r_device_type.png",
        ],
        'examination-code' => [
            "table" => "r_examination_code",
            "inputs" => [
                [
                    "input" => "Code",
                    "validation" => ['Code', 'trim|required|min_length[3]|max_length[10]'],
                ],
                [
                    "input" => "Description_AR",
                    "validation" => ["Description AR", "trim|required|min_length[3]|max_length[230]"],
                ],
                [
                    "input" => "Description_EN",
                    "validation" => ["Description EN", "trim|required|min_length[3]|max_length[230]"],
                ],
            ],"icon" => "r_examination_code.png",
        ],
        
        'lookup' => [
            "table" => "r_lookup",
            "inputs" => [
                [
                    "input" => "Lookup_Name",
                    "validation" => ["Lookup Name", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Description_AR",
                    "validation" => ["Description AR", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Description_EN",
                    "validation" => ["Description EN", 'trim|required|min_length[3]|max_length[230]'],
                ],
            ],"icon" => "lookup.png",
        ],
        'prefix' => [
            "table" => "r_prefix",
            "inputs" => [
                [
                    "input" => "Prefix",
                    "validation" => ["Prefix EN", "trim|required|min_length[3]|max_length[20]"],
                ],
                [
                    "input" => "Prefix_ar",
                    "validation" => ["Prefix AR", "trim|required|min_length[3]|max_length[20]"],
                ],
            ],"icon" => "r_prefix.png",
        ],
        'sites' => [
            "table" => "r_sites",
            "inputs" => [
                [
                    "input" => "Site_Name",
                    "validation" => ["Site Name EN", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Site_Name_ar",
                    "validation" => ["Site Name AR", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Site_Code",
                    "validation" => ["Site Code", 'trim|required|min_length[3]|max_length[230]'],
                ],
            ],"icon" => "r_sites.png",
        ],
        'standards' => [
            "table" => "r_standards",
            "inputs" => [
                [
                    "input" => "Name_en",
                    "validation" => ["Name EN", 'trim|required|min_length[3]|max_length[150]'],
                ],
                [
                    "input" => "Name_ar",
                    "validation" => ["Name AR", 'trim|required|min_length[3]|max_length[150]'],
                ]
            ],"icon" => "r_standards.png",
        ],
        'style' => [
            "table" => "r_style",
            "inputs" => [
                [
                    "input" => "ar_co_type",
                    "validation" => ["Company Type AR", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "en_co_type",
                    "validation" => ["Company Type EN", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "ar_co_type_sub",
                    "validation" => ["Sub Company Type AR", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "en_co_type_sub",
                    "validation" => ["Sub Company Type EN", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "style_name",
                    "validation" => ["Style Name", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input"      => "type",
                    "validation" => ["system Type", 'trim|required|in_list[M,C]'],
                    "choices"    => [
                        [
                            "name" => "Ministry",
                            "value" => "M",
                        ],
                        [
                            "name" => "Company",
                            "value" => "C",
                        ]
                    ],
                    "formatter" => [
                        "M" => "Ministry",
                        "C" => "Company",
                    ]
                ],
            ],"icon" => "r_style.png",
        ],
        'symptoms' => [
            "table" => "r_symptoms",
            "inputs" => [
                [
                    "input" => "symptoms_EN",
                    "validation" => ["symptoms EN", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "symptoms_AR",
                    "validation" => ["symptoms AR", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "code",
                    "validation" => ["Code", 'trim|required|min_length[3]|max_length[10]'],
                ],
            ],"icon" => "r_symptoms.png",
        ],
        'Temperature-Levels' => [
            "table" => "r_temp_levels",
            "inputs" => [
                [
                    "input" => "status",
                    "validation" => ["status", 'trim|required|min_length[3]|max_length[150]'],
                ],
                [
                    "input" => "from",
                    "validation" => ["From", 'trim|required|decimal'],
                ],
                [
                    "input" => "to",
                    "validation" => ["To", 'trim|required|decimal'],
                ],
            ],"icon" => "r_temp_levels.png",
        ],
        'Lab-Tests' => [
            "table" => "r_testcode",
            "inputs" => [
                [
                    "input" => "CPT_Code",
                    "validation" => ["CPT Code", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Test_Desc",
                    "validation" => ["Test Desc", 'trim|required|min_length[3]|max_length[230]'],
                ],
            ],"icon" => "r_testcode.png",
        ],
        'Company-User-Types' => [
            "table" => "r_usertype",
            "inputs" => [
                [
                    "input" => "UserType",
                    "validation" => ["EN UserType", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "AR_UserType",
                    "validation" => ["AR UserType", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Code",
                    "validation" => ["Code", 'trim|required|min_length[3]|max_length[230]'],
                ],
            ],"icon" => "r_usertype.png",
        ],
        'School-User-Types' => [
            "table" => "r_usertype_school",
            "inputs" => [
                [
                    "input" => "UserType",
                    "validation" => ["EN UserType", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "AR_UserType",
                    "validation" => ["AR UserType", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Code",
                    "validation" => ["Code", 'trim|required|min_length[3]|max_length[230]'],
                ],
            ],"icon" => "r_usertype_school.png",
        ],
        'Vaccines' => [
            "table" => "r_vaccines",
            "inputs" => [
                [
                    "input" => "Vaccines_AR",
                    "validation" => ["Vaccines AR", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Vaccines_EN",
                    "validation" => ["Vaccines EN", 'trim|required|min_length[3]|max_length[230]'],
                ]
            ],"icon" => "r_vaccines.png",
        ],
        'Scores' => [
            "table" => "r_z_scores",
            "inputs" => [
                [
                    "input" => "accept_from",
                    "validation" => ["Accept From", 'trim|required|decimal'],
                ],
                [
                    "input" => "accept_to",
                    "validation" => ["Accept To", 'trim|required|decimal'],
                ],
                [
                    "input" => "color",
                    "validation" => ["color", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "font_color",
                    "validation" => ["Font Color", 'trim|required|min_length[3]|max_length[230]'],
                ],
            ],"icon" => "r_z_scores.png",
        ],
		
		'Branch-Types' => [
            "table" => "r_branch_type",
            "inputs" => [
                [
                    "input" => "branch_type_title_en",
                    "validation" => ["English Titles for Types of Branches", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "branch_type_title_ar",
                    "validation" => ["Arabic Titles for Types of Branches", 'trim|required|min_length[3]|max_length[230]'],
                ],
                
                
            ],"icon" => "branch.png",
        ],
		
		'File-Types' => [
            "table" => "r_file_URL_type",
            "inputs" => [
                [
                    "input" => "File_URL_Type",
                    "validation" => ["File Type", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "Comments",
                    "validation" => ["Format File Type", 'trim|required|min_length[3]|max_length[230]'],
                ],
                
                
            ],"icon" => "format.png",
        ],
		
		'Messages' => [
            "table" => "r_messages",
            "inputs" => [
                [
                    "input" => "message_en",
                    "validation" => ["English Message", 'trim|required|min_length[3]|max_length[230]'],
                ],
                [
                    "input" => "message_ar",
                    "validation" => ["Arabic Message", 'trim|required|min_length[3]|max_length[230]'],
                ],
                
                
            ],"icon" => "messagesw.png",
        ],
		
    ];


    public function links()
{
    $links = array();
    foreach ($this->tables as $key => $link) {
        $icon = isset($link["icon"]) ? $link["icon"] : "coneducationr.png";
        $links[] = [
            "name" => str_replace('-', ' ', $key),
            "link" => base_url('EN/Dashboard/Resources-Managment/' . $key),
            "desc" => "",
            "icon" => $icon,
        ];
    }
    return $links;
}


    public function valid($type)
    {
        $status = false;
        if (in_array($type, array_keys($this->tables))) {
            $status = true;
        }
        return $status;
    }

    public function get($type)
    {
        // returns an object
        return json_decode(json_encode($this->tables[$type]), FALSE);
    }
}
