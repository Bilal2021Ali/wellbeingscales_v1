<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Routes
{
    public function schools()
    {
        return [
            [
                'name' => ' DASHBOARD ',
                'url' => 'schools',
                'icon' => 'assets/images/icons/png_icons/dashboard.png',
                'protected' => null,
            ],
            [
                'name' => ' MY PROFILE ',
                'url' => 'schools/Profile',
                'icon' => 'assets/images/icons/png_icons/customer-service.png',
                'protected' => null,
            ],
            [
                'name' => ' ADD DEVICE ',
                'url' => 'schools/AddDevice',
                'icon' => 'assets/images/icons/png_icons/device.png',
                'protected' => null,
            ],
            [
                'name' => ' ADD MEMBERS ',
                'url' => 'schools/AddMembers',
                'icon' => 'assets/images/icons/png_icons/team.png',
                'protected' => null,
            ],
            [
                'name' => 'LIST ALL',
                'url' => 'schools/List-all',
                'icon' => 'assets/images/icons/png_icons/menu.png',
                'protected' => null,
            ],
            [
                'name' => ' TEMP TESTS ',
                'url' => 'schools/Tests',
                'icon' => 'assets/images/icons/png_icons/temperature.png',
                'protected' => null,
            ],
            [
                'name' => ' LAB TESTS ',
                'url' => 'schools/Lab-Tests',
                'icon' => 'assets/images/icons/png_icons/chemistry.png',
                'protected' => null,
            ],
            [
                'name' => 'CATEGORIES',
                'url' => 'schools/categorys-reports',
                'icon' => 'assets/images/icons/png_icons/CATEGORIES.png',
                'protected' => null,
            ],
            [
                'name' => 'REPORTS',
                'url' => 'schools/reports-routes',
                'icon' => 'assets/images/icons/png_icons/REPORTS.png',
                'protected' => null,
            ],
            [
                'name' => 'MONITOR',
                'url' => 'schools/Monitors_routes',
                'icon' => 'assets/images/icons/png_icons/Monitor.png',
                'protected' => null,
            ],
            [
                'name' => ' AIR QUALITY ',
                'url' => 'schools/Air-Quality-Dashboard',
                'icon' => 'assets/images/icons/png_icons/airquality.png',
                'protected' => null,
            ],
			[
                'name' => ' REFRIGERATOR',
                'url' => 'schools/refrigerator-cards',
                'icon' => 'assets/images/icons/png_icons/airquality.png',
                'protected' => null,
            ],
            [
                'name' => ' VEHICLES ',
                'url' => 'schools/Vehicles-list',
                'icon' => 'assets/images/icons/png_icons/Vehicle.png',
                'protected' => null,
            ],
            [
                'name' => ' UPLOAD ',
                'url' => 'schools/LoadFromCsv',
                'icon' => 'assets/images/icons/png_icons/upload.png',
                'protected' => null,
            ],
            [
                'name' => ' SMART QR ',
                'url' => 'schools/smartqrcode',
                'icon' => 'assets/images/icons/png_icons/QR.png',
                'protected' => null,
            ],
            [
                'name' => ' SPEAK OUT ',
                'url' => 'schools/speak-out',
                'icon' => 'assets/images/icons/png_icons/speak_out.png',
                'protected' => null,
            ],
            [
                'name' => ' USER PAGES ',
                'url' => 'schools/L3-config',
                'icon' => 'assets/images/icons/png_icons/device.png',
                'protected' => null,
            ],
            [
                'name' => 'WELLBEING',
                'url' => 'schools/wellness',
                'icon' => 'assets/images/icons/png_icons/WELLBEING.png',
                'protected' => null,
            ],
            [
                'name' => ' CLIMATE ',
                'url' => 'schools/Climate',
                'icon' => 'assets/images/icons/png_icons/REPORTS.png',
                'protected' => null,
            ],
            [
                'name' => 'MESSAGE',
                'url' => 'schools/Message',
                "icon" => "uil-plus",
                'protected' => null,
            ],
            [
                'name' => ' CONSULTANT ',
                'url' => 'schools/Consultant',
                'icon' => 'assets/images/icons/png_icons/REPORTS.png',
                'protected' => null,
            ],
            [
                'name' => 'Staff List',
                'url' => 'schools/listOfStaff',
                'icon' => 'assets/images/linksicons/Staff.png',
                'protected' => null
            ],
            [
                'name' => 'Teachers List',
                'url' => 'schools/listOfTeachers',
                'icon' => 'assets/images/linksicons/Teachers.png',
                'protected' => null
            ],
            [
                'name' => 'Students List',
                'url' => 'schools/listOfStudents',
                'icon' => 'assets/images/linksicons/Students.png',
                'protected' => null
            ],
            [
                'name' => 'Sites List',
                'url' => 'schools/listOfSites',
                'icon' => 'assets/images/linksicons/Sites.png',
                'protected' => null
            ],
            [
                'name' => 'Devices List',
                'url' => 'schools/ListofDevices',
                'icon' => 'assets/images/linksicons/Devices.png',
                'protected' => null
            ],
            [
                'name' => 'Avatars List',
                'url' => 'schools/MembersList',
                'icon' => 'assets/images/linksicons/Avatars.png',
                'protected' => null
            ],
            [
                'name' => 'Sites’ Reports',
                'url' => 'schools/sites_reports',
                'icon' => 'assets/images/linksicons/report/sitesreports.png',
                'protected' => null
            ],
            [
                'name' => 'Disease Report',
                'url' => 'schools/disease_report',
                'icon' => 'assets/images/linksicons/DiseasesReport.png',
                'protected' => null
            ],
            [
                'name' => 'Disease Prevalence',
                'url' => 'schools/labs_report',
                'icon' => 'assets/images/linksicons/DiseasePrevalence.png',
                'protected' => null
            ],
            [
                'name' => 'LAB REPORTS',
                'url' => 'schools/Lab_Reports',
                'icon' => 'assets/images/linksicons/LabReports.png',
                'protected' => null
            ],
            [
                'name' => 'Daily Temperature & other Tests’ Report',
                'url' => 'schools/All_Tests_Today',
                'icon' => 'assets/images/linksicons/DailyTemperature.png',
                'protected' => null
            ],
            [
                'name' => 'Category PDF',
                'url' => 'schools/Category_pdf',
                'icon' => 'assets/images/linksicons/CategoryPDF.png',
                'protected' => null
            ],
            [
                'name' => 'Climate Dashboard',
                'url' => 'schools/climate-dashboard',
                'icon' => 'assets/images/linksicons/ClimateDashboard.png',
                'protected' => null
            ],
            [
                'name' => 'Monthly Temperature & Tests’ Report',
                'url' => 'schools/monthResults',
                'icon' => 'assets/images/linksicons/DailyMonitor.png',
                'protected' => null
            ],
            [
                'name' => 'Refrigerator Data Log Report',
                'url' => 'schools/refrigerators_trips',
                'icon' => 'assets/images/linksicons/Refrigerator_Trip.png',
                'protected' => null
            ],
            [
                'name' => 'Attendance by Date per User',
                'url' => 'schools/attendance_result',
                'icon' => 'assets/images/linksicons/AttendenceByDataPerUser.png',
                'protected' => null
            ],
            [
                'name' => 'Daily Attendance By Device & User',
                'url' => 'schools/Attendance_Report',
                'icon' => 'assets/images/linksicons/DailyAttendanceByDeviceByUser.png',
                'protected' => null
            ],
            [
                'name' => 'Attendance by Date for All Users',
                'url' => 'schools/attendance_result_for_all',
                'icon' => 'assets/images/linksicons/ListofAttendance.png',
                'protected' => null
            ],
            [
                'name' => 'Interview Guide Report',
                'url' => 'schools/Private_surveys',
                'icon' => 'assets/images/linksicons/InterviewGuideRepor.png',
                'protected' => null
            ],
            [
                'name' => 'Student Attendance by Vehicle',
                'url' => 'schools/Vehicles_Attendees',
                'icon' => 'assets/images/linksicons/Vehicles1.png',
                'protected' => null
            ],
            [
                'name' => 'Student Attendance by Class',
                'url' => 'schools/Attendance_for_vichal',
                'icon' => 'assets/images/linksicons/Vehicles2.png',
                'protected' => null
            ],
            [
                'name' => 'Environment (Refrigerator)',
                'url' => 'schools/MacheneRP',
                'icon' => 'assets/images/linksicons/Environment.png',
                'protected' => null,
            ],
			[
                'name' => 'Refrigerators',
                'url' => 'schools/refrigeratorcards',
                'icon' => 'assets/images/linksicons/Refrigeratorcards.png',
                'protected' => null,
            ],
            [
                'name' => 'Quarantined (Staff, Teachers, and Students)',
                'url' => 'schools/Quarantine_monitor',
                'icon' => 'assets/images/linksicons/Quarantine.png',
                'protected' => null,
            ],
            [
                'name' => 'Stay Home (Staff, Teachers, and Students)',
                'url' => 'schools/StayHome_monitor',
                'icon' => 'assets/images/linksicons/StayHomeR.png',
                'protected' => null,
            ],
            [
                'name' => 'Daily Monitor (Staff, Teachers, and Students)',
                'url' => 'schools/monitor',
                'icon' => 'assets/images/linksicons/DailyMonitorSTS.png',
                'protected' => null,
            ],
            [
                'name' => 'Attendees by Vehicle',
                'url' => 'schools/attendees_reports',
                'icon' => 'assets/images/linksicons/AttendenceByvehaicle.png',
                'protected' => null,
            ],
            [
                'name' => 'Attendees by Class',
                'url' => 'schools/Attendees_By_class_reports',
                'icon' => 'assets/images/linksicons/AttendenceByClass.png',
                'protected' => null,
            ],
            [
                'name' => 'Student Cards',
                'url' => 'schools/studentscards',
                'icon' => 'assets/images/linksicons/StudentCards.png',
                'protected' => null,
            ],
            [
                'name' => 'Visitors by Device',
                'url' => 'schools/Visitors',
                'icon' => 'assets/images/linksicons/VisitorByDevice.png',
                'protected' => null,
            ],
            [
                'name' => 'Visitor Monitor',
                'url' => 'schools/visitor_report',
                'icon' => 'assets/images/linksicons/VisitorByDevice.png',
                'protected' => null,
            ],
            [
                'name' => 'Public Visitor Monitor',
                'url' => 'schools/Public_Visitors',
                'icon' => 'assets/images/linksicons/VisitorByDevice.png',
                'protected' => null,
            ],
            [
                'name' => 'CLIMATE LIBRARY',
                'url' => 'schools/ClaimateSurveys',
                'icon' => 'assets/images/linksicons/Daily.png',
                'protected' => null,
            ],
            [
                'name' => 'Reports',
                'url' => 'schools/Consultant/Reports',
                'icon' => 'assets/images/linksicons/con_reports.png',
                'protected' => null,
            ],
            [
                'name' => 'Media Gallery',
                'url' => 'schools/Consultant/Gallery',
                'icon' => 'assets/images/linksicons/con_media.png',
                'protected' => null,
            ],
            [
                'name' => 'Education Resources',
                'url' => 'schools/Consultant/Education',
                'icon' => 'assets/images/linksicons/con_edu.png',
                'protected' => null,
            ],
            [
                'name' => 'Action Plans',
                'url' => 'schools/Consultant/Plans',
                'icon' => 'assets/images/linksicons/con_action.png',
                'protected' => null,
            ],
            [
                'name' => 'Education Reports',
                'url' => 'schools/Consultant/EducationReports',
                'icon' => 'assets/images/linksicons/coneducationr.png',
                'protected' => null,
            ],
        ];
    }

    public function company_departments()
    {
        return [
            [
                'name' => ' DASHBOARD ',
                'url' => 'Company-Departments',
                'icon' => 'assets/images/DepartmentCompany/DASHBOARD.png',
                'protected' => null,
            ],
            [
                'name' => 'PROFILE ',
                'url' => 'Company-Departments/Profile',
                'icon' => 'assets/images/DepartmentCompany/Profile.png',
                'protected' => null,
            ],
            [
                'name' => 'ADD',
                'url' => 'Company-Departments/Adding-routes',
                'icon' => 'assets/images/DepartmentCompany/Add.png',
                'protected' => null,
            ],
            [
                'name' => 'LISTS',
                'url' => 'Company-Departments/lists-routes',
                'icon' => 'assets/images/DepartmentCompany/List.png',
                'protected' => null,
            ],
            [
                'name' => ' TEMPERATURE',
                'url' => 'Company-Departments/Tests',
                'icon' => 'assets/images/DepartmentCompany/Temperature.png',
                'protected' => null,
            ],
            [
                'name' => ' LAB TESTS ',
                'url' => 'Company-Departments/Lab_Tests',
                'icon' => 'assets/images/DepartmentCompany/Labe.png',
                'protected' => null,
            ],
            [
                'name' => ' REPORTS ',
                'url' => 'Company-Departments/reports_routes',
                'icon' => 'assets/images/DepartmentCompany/REPORTS99.png',
                'protected' => null,
            ],
            [
                'name' => ' MONITOR ',
                'url' => 'Company-Departments/monitors_routes',
                'icon' => 'assets/images/DepartmentCompany/Monitor99.png',
                'protected' => null,
            ],
            [
                'name' => ' VISITOR SYSTEM ',
                'url' => 'Company-Departments/visitors_routes',
                'icon' => 'assets/images/DepartmentCompany/Monitor99.png',
                'protected' => null,
            ],
            [
                'name' => ' SMART QR CODE ',
                'url' => 'Company-Departments/smartqrcode',
                'icon' => 'assets/images/DepartmentCompany/Monitor99.png',
                'protected' => null,
            ],
            [
                'name' => 'AIR QUALITY',
                'url' => 'Company-Departments/Air-Quality-Dashboard',
                'icon' => 'assets/images/DepartmentCompany/Air Quality99.png',
                'protected' => null,
            ],
            [
                'name' => 'CATEGORIES',
                'url' => 'Company-Departments/categorys-reports',
                'icon' => 'assets/images/icons/png_icons/CATEGORIES.png',
                'protected' => null,
            ],
            [
                'name' => 'CLIMATE ',
                'url' => 'Company_Departments/Climate',
                'icon' => 'assets/images/icons/png_icons/REPORTS.png',
                'protected' => null,
            ],
            [
                'name' => 'WELLBEING',
                'url' => 'Company_Departments/wellness',
                'icon' => 'assets/images/icons/png_icons/REPORTS.png',
                'protected' => null,
            ],
            [
                'name' => ' CONSULTANT ',
                'url' => 'Company_Departments/Consultant',
                'icon' => 'assets/images/icons/png_icons/REPORTS.png',
                'protected' => null,
            ],
            [
                "name" => "LIST OF USERS ",
                "url" => "Company-Departments/ListOfPatients",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "LIST OF SITES",
                "url" => "Company-Departments/listOfSites",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "LIST OF MEMBER TYPES",
                "url" => "Company-Departments/MembersList",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "LIST OF AVATARS",
                "url" => "Company-Departments/MembersList",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "ATTENDANCE REPORT",
                "url" => "Company-Departments/Attendance_Report",
                "icon" => "assets/images/linksicons/DailyAttendanceByDeviceByUser.png",
                "protected" => null
            ],
            [
                "name" => "REPORT BY DATE",
                "url" => "Company-Departments/monthResults",
                "icon" => "assets/images/linksicons/Vehicles2.png",
                "protected" => null
            ],
            [
                "name" => "ATTENDANCE REPORT BY DATE ",
                "url" => "Company-Departments/attendance_result",
                "icon" => "assets/images/linksicons/ListofAttendance.png",
                "protected" => null
            ],
            [
                "name" => "ATTENDANCE REPORT BY DATE FOR ALL",
                "url" => "Company-Departments/attendance_result_for_all",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "SITES REPORT",
                "url" => "Company-Departments/sites_reports",
                "icon" => "assets/images/linksicons/report/sitesreports.png",
                "protected" => null
            ],
            [
                "name" => "LAB REPORTS",
                "url" => "Company-Departments/Lab_Reports",
                "icon" => "assets/images/linksicons/LabReports.png",
                "protected" => null
            ],
            [
                "name" => "REFRIGERATOR TRIP​",
                "url" => "Company-Departments/refrigerators",
                "icon" => "assets/images/linksicons/Refrigerator_Trip.png",
                "protected" => null
            ],
            [
                "name" => "SCHOOLS LAB REPORTS",
                "url" => "Company-Departments/schools_Lab_Reports",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "ENVIRONMENT",
                "url" => "Company-Departments/MacheneRP",
                "icon" => "assets/images/linksicons/Environment.png",
                "protected" => null
            ],
            [
                "name" => "QUARANTINE",
                "url" => "Company-Departments/Quarantine_monitor",
                "icon" => "assets/images/linksicons/Quarantine.png",
                "protected" => null
            ],
            [
                "name" => "STAY HOME",
                "url" => "Company-Departments/StayHome_monitor",
                "icon" => "assets/images/linksicons/StayHomeR.png",
                "protected" => null
            ],
            [
                "name" => "DAILY MONITOR",
                "url" => "Company-Departments/Daily_monitor",
                "icon" => "assets/images/linksicons/DailyMonitorSTS.png",
                "protected" => null
            ],
            [
                "name" => "EMPLOYEE CARDS",
                "url" => "Company-Departments/employeescards",
                "icon" => "assets/images/linksicons/StudentCards.png",
                "protected" => null
            ],
            [
                "name" => "FACE RECOGNITION",
                "url" => "Company-Departments/new_smart_pass",
                "icon" => "assets/images/linksicons/face1.png",
                "protected" => null
            ],
            [
                "name" => "TEMPERATURE & VISITOR MONITORING",
                "url" => "Company-Departments/smart_pass_monitor",
                "icon" => "assets/images/linksicons/face2.png",
                "protected" => null
            ],
            [
                "name" => "ADD VISITORS BY DEVICE",
                "url" => "Company-Departments/Visitors",
                "icon" => "assets/images/linksicons/face3.png",
                "protected" => null
            ],
            [
                "name" => "CLIMATE LIBRARY",
                "url" => "Company-Departments/ClimateSurveys",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "CLIMATE DASHBOARD",
                "url" => "Company-Departments/climate-dashboard",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "DASHBOARD",
                "url" => "Company-Departments/ClaimateDashboard",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "INDIVIDUAL REPORT",
                "url" => "Company-Departments/ClimateIndividualReport",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "GROUP REPORT",
                "url" => "Company-Departments/ClaimateGroupReport",
                "icon" => "assets/images/linksicons/AttendenceByDataPerUser.png",
                "protected" => null
            ],
            [
                "name" => "Reports",
                "url" => "Company-Departments/Consultant/Reports",
                "icon" => "assets/images/linksicons/con_reports.png",
                "protected" => null
            ],
            [
                "name" => "Media Gallery",
                "url" => "Company-Departments/Consultant/Gallery",
                "icon" => "assets/images/linksicons/con_media.png",
                "protected" => null
            ],
            [
                "name" => "Education Resources",
                "url" => "Company-Departments/Consultant/Education",
                "icon" => "assets/images/linksicons/con_edu.png",
                "protected" => null
            ],
            [
                "name" => "Action Plans",
                "url" => "Company-Departments/Consultant/Plans",
                "icon" => "assets/images/linksicons/con_action.png",
                "protected" => null
            ],
            [
                "name" => "Education Reports",
                "url" => "Company-Departments/Consultant/EducationReports",
                "icon" => "assets/images/linksicons/con_reports.png",
                "protected" => null
            ]
        ];
    }

    public function company()
    {
        return [
            [
                "name" => " DASHBOARD ",
                "url" => "Company",
                "icon" => "assets/images/DepartmentCompany/DASHBOARD.png",
                "protected" => null
            ],
            [
                "name" => " PROFILE ",
                "url" => "Company/Profile",
                "icon" => "assets/images/DepartmentCompany/Profile.png",
                "protected" => null
            ],
            [
                "name" => "REPORTS",
                "url" => "Company/Monitors_routes_company",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => "ADD DEPARTMENT ",
                "url" => "Company/addDepartment",
                "icon" => "assets/images/DepartmentCompany/Add.png",
                "protected" => null
            ],
            [
                "name" => "DEPARTMENT LIST",
                "url" => "Company/DepartmentsList",
                "icon" => "assets/images/ministryicons/DM_list.png",
                "protected" => null
            ],
            [
                "name" => "MESSAGE",
                "url" => "Company/Message",
                "icon" => "",
                "protected" => null
            ],
            [
                "name" => "CLIMATE",
                "url" => "Company/ClimatesLinks",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => " CATEGORIES ",
                "url" => "Company/categorys-reports",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => " WELLBEING ",
                "url" => "Company/Wellness",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => " CONSULTANTS ",
                "url" => "Company/Consultants",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => " DAILY REPORT ",
                "url" => "Company/All_Tests_Today",
                "icon" => "assets/images/linksicons/DTemperature.png",
                "protected" => null
            ],
            [
                "name" => " ATTENDANCE REPORT ",
                "url" => "Company/Attendance_Report",
                "icon" => "assets/images/linksicons/AttendancebyDatser.png",
                "protected" => null
            ],
            [
                "name" => " REFRIGERATORS REPORT ",
                "url" => "Company/Refrigerator_access",
                "icon" => "assets/images/linksicons/Refrigerator_Trip.png",
                "protected" => null
            ],
            [
                "name" => " LAB REPORT ",
                "url" => "Company/Lab_Reports",
                "icon" => "assets/images/linksicons/LabReport.png",
                "protected" => null
            ],
            [
                "name" => " REFRIGERATORS TRIP REPORT ",
                "url" => "Company/refrigerators",
                "icon" => "assets/images/linksicons/Refrigerator_Trip.png",
                "protected" => null
            ],
            [
                "name" => "CLIMATE LIBRARY",
                "url" => "Company/ClimateSurveys",
                "icon" => "assets/images/linksicons/aaaclimate.png",
                "protected" => null
            ],
            [
                "name" => "CLIMATE DASHBOARD",
                "url" => "Company/Climate-Dashboard",
                "icon" => "assets/images/linksicons/aaaclimate.png",
                "protected" => null
            ],
            [
                "name" => "CONSULTANT MANAGEMENT",
                "url" => "Company/Consultants/Managment",
                "icon" => "assets/images/linksicons/DTemperature.png",
                "protected" => null
            ],
            [
                "name" => "CONSULTANT REPORT",
                "url" => "Company/Consultants/Reports",
                "icon" => "assets/images/linksicons/DTemperature.png",
                "protected" => null
            ]
        ];
    }

    public function super()
    {
        return [
            [
                "name" => "DASHBOARD",
                "url" => "Dashboard",
                "icon" => "uil-home-alt",
                "protected" => null
            ],
            [
                "name" => "ADD ORGS",
                "url" => "Dashboard/addSystem",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => "16LIST ORGS",
                "url" => "Dashboard/UpdateSystem",
                "icon" => "uil-list-ul",
                "protected" => null
            ],
            [
                "name" => " POSITIONS ",
                "url" => "Dashboard/positions",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => "REFRIGERATORS",
                "url" => "Dashboard/Refrigerator_management",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => "PERMISSIONS",
                "url" => "Dashboard/permissions_routes",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => "SPEAK OUT",
                "url" => "Dashboard/lifereports",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " CREAT CL ",
                "url" => "Dashboard/CreatClimateSurvey",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " MANAGE CLs ",
                "url" => "Dashboard/ClimateSurveys",
                "icon" => "uil-database",
                "protected" => null
            ],
            [
                "name" => " CREATE SV ",
                "url" => "Dashboard/Addsurveys",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " MANAGE SVs ",
                "url" => "Dashboard/Manage_surveys",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " CATEGORYS ",
                "url" => "Dashboard/Category",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " RESOURCES ",
                "url" => "Dashboard/Resources",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " SURVEY TITLES ",
                "url" => "Dashboard/ManageSets",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " QUESTIONS ",
                "url" => "Dashboard/Managequestions",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " CHOICES ",
                "url" => "Dashboard/manage-answers",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " CATEGORIES ",
                "url" => "Dashboard/categorys-reports",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => " MOBILE LIBRARY",
                "url" => "Dashboard/Resports-Routes",
                "icon" => "uil-list-ul",
                "protected" => null
            ],
            [
                "name" => "MESSAGE",
                "url" => "Dashboard/Message",
                "icon" => "uil-plus",
                "protected" => null
            ],
            [
                "name" => "RESOURCES",
                "url" => "Dashboard/Resources-Managment",
                "icon" => "uil-dropbox",
                "protected" => null
            ],
            [
                "name" => "Add Position",
                "url" => "Dashboard/positions/all",
                "icon" => "assets/images/linksicons/addposition.png",
                "protected" => null
            ],
            [
                "name" => "Add Position GM",
                "url" => "Dashboard/positions/gm",
                "icon" => "assets/images/linksicons/gmposition.png",
                "protected" => null
            ],
            [
                "name" => "Add Position Staff",
                "url" => "Dashboard/positions/staff",
                "icon" => "assets/images/linksicons/addstaff.png",
                "protected" => null
            ],
            [
                "name" => "Add Position Teacher",
                "url" => "Dashboard/positions/teacher",
                "icon" => "assets/images/linksicons/addteachers.png",
                "protected" => null
            ],
            [
                "name" => "Schools Classes",
                "url" => "Dashboard/classes",
                "icon" => "assets/images/linksicons/classroom.png",
                "protected" => null
            ],
            [
                "name" => "Schools Permissions",
                "url" => "Dashboard/schools_tests_permission",
                "icon" => "assets/images/linksicons/permission.png",
                "protected" => null
            ],
            [
                "name" => "Departments Permissions",
                "url" => "Dashboard/Departments_tests_permission",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "CATEGORIES PDF",
                "url" => "Dashboard/Categories",
                "icon" => "assets/images/linksicons/formobilecontrol.png",
                "protected" => null
            ],
            [
                "name" => "Cars Levels",
                "url" => "Dashboard/Resources-Managment/Cars-Levels",
                "icon" => "assets/images/linksicons/formobilecontrol.png",
                "protected" => null
            ],
            [
                "name" => "Company Type",
                "url" => "Dashboard/Resources-Managment/Company-Type",
                "icon" => "assets/images/ministryicons/M_add.png",
                "protected" => null
            ],
            [
                "name" => "Dental Conditions",
                "url" => "Dashboard/Resources-Managment/dental-conditions",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Device Type",
                "url" => "Dashboard/Resources-Managment/device-type",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Examination Code",
                "url" => "Dashboard/Resources-Managment/examination-code",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Levels",
                "url" => "Dashboard/Resources-Managment/levels",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Lookup",
                "url" => "Dashboard/Resources-Managment/lookup",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Prefix",
                "url" => "Dashboard/Resources-Managment/prefix",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Sites",
                "url" => "Dashboard/Resources-Managment/sites",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Standards",
                "url" => "Dashboard/Resources-Managment/standards",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Style",
                "url" => "Dashboard/Resources-Managment/style",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "Symptoms",
                "url" => "Dashboard/Resources-Managment/symptoms",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "temp levels",
                "url" => "Dashboard/Resources-Managment/temp-levels",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "testcode",
                "url" => "Dashboard/Resources-Managment/testcode",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "usertype",
                "url" => "Dashboard/Resources-Managment/usertype",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "usertype school",
                "url" => "Dashboard/Resources-Managment/usertype-school",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "vaccines",
                "url" => "Dashboard/Resources-Managment/vaccines",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ],
            [
                "name" => "z scores",
                "url" => "Dashboard/Resources-Managment/z-scores",
                "icon" => "assets/images/linksicons/fav_icon.png",
                "protected" => null
            ]
        ];
    }

    public function ministry()
    {
        return [
            [
                "name" => " DASHBOARD ",
                "url" => "DashboardSystem",
                "icon" => "assets/images/ministryicons/M_Dashboard.png",
                "protected" => null
            ],
            [
                "name" => " PROFILE ",
                "url" => "DashboardSystem/Profile",
                "icon" => "assets/images/ministryicons/M_Profile.png",
                "protected" => null
            ],
            [
                "name" => " ADD SCHOOL ",
                "url" => "DashboardSystem/addSchool",
                "icon" => "assets/images/ministryicons/M_add.png",
                "protected" => null
            ],
            [
                "name" => "SCHOOL LIST",
                "url" => "DashboardSystem/UpdateSchool",
                "icon" => "assets/images/ministryicons/M_list.png",
                "protected" => null
            ],
            [
                "name" => " DEPTS LIST ",
                "url" => "DashboardSystem/DepartmentsList",
                "icon" => "assets/images/ministryicons/DM_list.png",
                "protected" => null
            ],
            [
                "name" => " CATEGORIES ",
                "url" => "DashboardSystem/categorys-reports",
                "icon" => "assets/images/ministryicons/M_Wellbeing.png",
                "protected" => null
            ],
            [
                "name" => " SITE REPORTS ",
                "url" => "DashboardSystem/sites-reports",
                "icon" => "assets/images/ministryicons/M_sites.png",
                "protected" => null
            ],
            [
                "name" => " AI REPORTS ",
                "url" => "DashboardSystem/reports-routes",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => " Lab Reports ",
                "url" => "DashboardSystem/Lab-Reports",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => " WELLBEING ",
                "url" => "DashboardSystem/wellness",
                "icon" => "assets/images/ministryicons/M_Wellbeing.png",
                "protected" => null
            ],
            [
                "name" => " CLIMATE ",
                "url" => "DashboardSystem/ClimatesLinks",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => "MESSAGE",
                "url" => "DashboardSystem/Message",
                "icon" => "",
                "protected" => null
            ],
            [
                "name" => " CONSULTANT ",
                "url" => "DashboardSystem/Consultants",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => "AI: LAB REPORTS",
                "url" => "DashboardSystem/labs_report",
                "icon" => "assets/images/icons/png_icons/REPORTS.png",
                "protected" => null
            ],
            [
                "name" => "AI: TOTAL OF DISEASES",
                "url" => "DashboardSystem/ai_report",
                "icon" => "",
                "protected" => null
            ],
            [
                "name" => "AI: PERCENTAGE OF DISEASE",
                "url" => "DashboardSystem/ai_report_2",
                "icon" => "",
                "protected" => null
            ],
            [
                "name" => "REFRIGERATOR TRIP​",
                "url" => "DashboardSystem/refrigerators_trips",
                "icon" => "",
                "protected" => null
            ],
            [
                "name" => "PREVALENCE MAPS",
                "url" => "DashboardSystem/resultsmap",
                "icon" => "",
                "protected" => null
            ],
            [
                "name" => "CLIMATE LIBRARY",
                "url" => "DashboardSystem/ClimateSurveys",
                "icon" => "",
                "protected" => null
            ],
            [
                "name" => "CONSULTANT MANAGEMENT",
                "url" => "DashboardSystem/Consultants/Managment",
                "icon" => "assets/images/linksicons/DTemperature.png",
                "protected" => null
            ],
            [
                "name" => "CONSULTANT REPORTS",
                "url" => "DashboardSystem/Consultants/Reports",
                "icon" => "assets/images/linksicons/DTemperature.png",
                "protected" => null
            ]
        ];
    }

    public function get()
    {
        $result = [];
        $result['school'] = $this->schools();
        $result['department_Company'] = $this->company_departments();
        $result['Company'] = $this->company();
        $result['super'] = $this->super();
        $result['Ministry'] = $this->ministry();
        return $result;
    }
}
