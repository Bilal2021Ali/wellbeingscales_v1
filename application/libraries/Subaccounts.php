<?php

class Subaccounts
{
    public const SCHOOL = 0;
    public const DEFAULT_PASSWORD = '123456789';
    public const TYPES = [
        self::SCHOOL => 'l1_school'
    ];

    public const PERMISSIONS = [
        "dashboard" => "Dashboard",
        "profile" => "Profile",
        "add-device" => "Add Device",
        "add-members" => "Add Members",
        "lists" => [
            'name' => "Lists",
            'subLinks' => [
                "listofstaff" => "list of staff",
                "listofteachers" => "List of Teachers",
                "listofstudents" => "List of students",
                "listofsites" => "List of sites",
                "listofdevices" => "list of devices",
                "memberslist" => "Members List",
            ]
        ],
        "tests" => "Temperature Tests",
        "lab-tests" => "Lab Tests",
        "incidents" => [
            'name' => "School Incidents",
            'subLinks' => [
                'add' => "Incidents - Add",
                'actions' => "Incidents - Actions",
                'reports' => "Incidents - Reports",
                'charts' => "Incidents - Charts",
            ]
        ],
        "wellness" => "Wellbeing",
        "categories-reports" => "Wellbeing Report",
        "courses" => "Courses",
        "monitors-routes" => [
            'name' => "Monitors Routes",
            'subLinks' => [
                "machenerp" => "Monitor - Environment Refrigerator",
				"refrigerator-cards" => "Monitor - Refrigerator Cards",
                "quarantine_monitor" => "Monitor - Quarantine Monitor",
                "stayhome_monitor" => "Monitor - Stay Home Monitor",
                "monitor" => "Monitor - Daily Monitor",
                "attendees_reports" => "Monitor - Attendees by Vehicle",
                "attendees_by_class_reports" => "Monitor - Attendees by Class Reports",
                "studentscards" => "Monitor - Students Cards",
                "visitors" => "Monitor - Visitors by Device",
                //  "public_visitors" => "Public Visitors",
            ]
        ],
        "attendance" => [
            'name' => "School Attendance",
            'subLinks' => [
                'vehicle-attendance' => "Attendance - Attendance By Vehicle",
                'class-attendance' => "Attendance - Attendance By Class",
            ]
        ],
        "air-quality-dashboard" => "Air Quality",

        "reports" => [
            'name' => "Reports Routes",
            'subLinks' => [
                "sites_reports" => "sites reports",
                "disease_report" => "disease report",
                "labs_report" => "labs Report",
                "Lab_Reports" => "Lab Reports",
                "monthResults" => "Month Results",
                "refrigerators_trips" => "Refrigerators Trips",
                "attendance_result" => "Attendance Result",
                "Attendance_Report" => "Attendance Report",
                "attendance_result_for_all" => "Attendance Result For All",
                "Vehicles_Attendees" => "Vehicles Attendees",
                "Attendance_for_vichal" => "Attendance For Victual",
            ]
        ],
        "vehicles-list" => "Vehicles",
        //"load-from-csv" => "Load From Csv",
        "smart-qr-code" => "Smart Qr Code",
        "speak-out" => [
            "name" => "Speak Out",
            'subLinks' => [
                "speak-out" => "Speak Out Report",
                "speak-out-dashboard" => "Speak Out Dashboard",
            ]
        ],
        "l3-config" => "News & Updates",

        "climate" => [
            'name' => "Climate",
            'subLinks' => [
                "claimatesurveys" => "School Climate Library",
                "climate-details" => "School Climate Details",
                "climate-report" => "School Climate Reports",
            ]
        ],
        "qm-healthy" => "QM Healthy",
        //   "message" => "Message",
        "consultant" => [
            'name' => "Consultant",
            'subLinks' => [
                "reports" => "Consultant - Research Articles",
                "gallery" => "Consultant - Media Gallery",
                // "education" => "Consultant Education",
                "plans" => "Consultant - Action Plans",
                "educationreports" => "Consultant - Action Plans"
            ]
        ],

        // "visitor_report" => "Visitor Report",
    ];

    public static function getPermissions($permissions)
    {
        if (is_string($permissions)) {
            $decodedPermissions = json_decode($permissions);
            if (json_last_error() === JSON_ERROR_NONE && is_object($decodedPermissions)) {
                return get_object_vars($decodedPermissions);
            } else {
                // Handle JSON decoding error
                return [];
            }
        } elseif (is_object($permissions)) {
            return get_object_vars($permissions);
        } else {
            // Handle other data types
            return [];
        }
    }

    public function getPermissionsList()
    {
        $urls = [];
        foreach (self::PERMISSIONS as $key => $PERMISSION) {
            if (is_array($PERMISSION)) {
                $urls += $PERMISSION['subLinks'];
            } else {
                $urls[$key] = $PERMISSION;
            }
        }

        return $urls;
    }

    public function assistanceAccount($data, $id = null)
    {

        $CI = &get_instance();
        $values = [
            'name' => $data['name'] ?? '',
            'role' => $data['role'] ?? '',
            'parentAccount' => $data['parentAccount'],
            'parentAccountType' => $data['parentAccountType'],
            'avatar' => $data['avatar'] ?? null,
        ];

        if (empty($id)) {
            $CI->db->trans_start();

            $CI->db->insert('v_login', [
                'username' => $data['username'],
                'password' => password_hash(self::DEFAULT_PASSWORD, PASSWORD_DEFAULT),
                'Type' => "assistance",
            ]);

            $loginKey = $CI->db->insert_id();

            $CI->db->insert('v_sub_accounts', array_merge($values, ['loginKey' => $loginKey]));

            $key = $CI->db->insert_id();
            $CI->db->trans_complete();

            return $key;
        } else {
            if (isset($data['username'])) {
                $CI->db->set('username', $data['username'])->where('id', $id)->update('v_login');
            }
            $CI->db->set($values)->where('loginKey', $id)->update('v_sub_accounts');

            return null;
        }

    }

    public function can($key): bool
    {
        $CI = &get_instance();
        $CI->load->library('session');
        $sessionData = $CI->session->userdata('admin_details');

        return !isset($sessionData['assistanceAccount']) || in_array($key, $sessionData['assistanceAccount']);
    }

    public function hasAny($key): bool
    {
        $CI = &get_instance();
        $CI->load->library('session');
        $sessionData = $CI->session->userdata('admin_details');

        if (!isset($sessionData['assistanceAccount'])) {
            return true;
        }

        $found = [];

        foreach (self::PERMISSIONS[$key]['subLinks'] as $k => $permission) {
            if (in_array($k, $sessionData['assistanceAccount'])) {
                $found[] = $key;
            }
        }

        return !empty($found);
    }

}