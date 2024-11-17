<?php

class CoursesModel extends CI_Model
{
    public $account = [];

    public function __construct()
    {
        $this->load->library('session');
        $session = $this->session->userdata('admin_details');
        $this->account = $session;
    }

    public function topics($courseId)
    {
        return $this->db
            ->query("SELECT 
                scou_st0_main_courses.Courses_Title AS courseTitle,
                scou_st0_main_courses.Id AS courseId,
                ssct.Courses_Topic_Title AS topicTitle,
                ssct.Description AS topicDescription,
                r_file_URL_type.File_URL_Type AS topicFileUrlType,
                r_file_URL_type.Comments AS topicComments,
                ssct.Id AS topicId,
                ssct.Status,
                sv_st_category.Cat_en AS categoryTitle,
                (SELECT COUNT(*) 
                 FROM scou_st0_courses_resource , scou_st0_courses_topics , scou_st0_main_courses 
                 WHERE scou_st0_main_courses.Id = $courseId
                   AND  scou_st0_courses_topics.Id = scou_st0_courses_resource.Courses_Topic_Id
                   AND scou_st0_main_courses.Id = scou_st0_courses_topics.Main_Courses_Id
                   AND scou_st0_courses_resource.Courses_Topic_Id =ssct.`Id`) AS resourcesCount
                FROM scou_st0_courses_topics AS ssct
                JOIN scou_st0_main_courses ON scou_st0_main_courses.Id = ssct.Main_Courses_Id
                JOIN sv_st_category ON sv_st_category.Id = scou_st0_main_courses.Category_Id
                JOIN r_file_URL_type ON r_file_URL_type.Id = ssct.File_URL_Type_Id
                WHERE ssct.Main_Courses_Id = $courseId ;")
            ->result_array();
    }

    public function resourses($id, $isCourse = false)
    {
        if ($isCourse) {
            $condition = "scou_st0_main_courses.Id = " . $id;
        } else {
            $condition = "scou_st0_courses_topics.Id = " . $id;
        }
        return $this->db
            ->query("SELECT 
                scou_st0_main_courses.Courses_Title as courseTitle,
                scou_st0_main_courses.Id as courseId,
                scou_st0_courses_topics.Courses_Topic_Title as topicTitle,
                scou_st0_courses_topics.Description as topicDescription,
                r_file_URL_type.File_URL_Type as fileUrlType,
                r_file_URL_type.Comments as comments,
                scou_st0_courses_topics.Id as topicId,
                scou_st0_courses_resource.Courses_Resource_Tile as coursesResourceTitle,
                scou_st0_courses_topics.Status,
                sv_st_category.Cat_en as categoryTitle,
                scou_st0_courses_resource.*
                FROM scou_st0_courses_resource 
                JOIN scou_st0_courses_topics ON scou_st0_courses_topics.Id = scou_st0_courses_resource.Courses_Topic_Id
                JOIN r_file_URL_type ON r_file_URL_type.Id = scou_st0_courses_topics.File_URL_Type_Id
                JOIN scou_st0_main_courses ON scou_st0_main_courses.Id = scou_st0_courses_topics.Main_Courses_Id
                JOIN sv_st_category ON sv_st_category.Id = scou_st0_main_courses.Category_Id
                WHERE " . $condition)
            ->result_array();
    }

    public function ministryCoursesList($schools, $category, $language, $getPublishedCourses = false)
    {
        $this->db->select("scou_st0_main_courses.Courses_Title AS courseTitle, scou_st0_main_courses.TimeStamp AS createdAt, scou_st_courses.Status as publishStatus, 
                   scou_st_courses.Id as publishId, sv_st_category.Cat_$language as category_title,
                   scou_st0_main_courses.Id AS courseId,
                   scou_st_courses.Startting_date,
                   scou_st_courses.End_date,
                   COUNT(scou_st0_courses_topics.Id) AS topicsCount,
                   (SELECT COUNT(scou_st0_courses_resource.Id) FROM scou_st0_courses_resource WHERE scou_st0_courses_resource.Courses_Topic_Id = scou_st0_courses_topics.Id) AS resourcesCount");

        if (empty($schools)) {
            $this->db->select("0 AS publishedCount , 0 AS reviews , 0 AS averageRate");
        } else {
            $this->db->select("(SELECT COUNT(DISTINCT scou_published_courses.By_school) FROM scou_published_courses WHERE By_school IN (" . implode(',', $schools) . ") AND scou_published_courses.Courses_Id = scou_st0_main_courses.Id) AS publishedCount");
            $this->db->select("(SELECT COUNT(*) FROM scou_published_courses JOIN scou_user_rate_published_course ON scou_user_rate_published_course.Published_Courses_Id = scou_published_courses.Id WHERE By_school IN (" . implode(',', $schools) . ") AND scou_published_courses.Courses_Id = scou_st_courses.Id) AS reviews");
            $this->db->select("(SELECT SUM(scou_user_rate_published_course.Rate)/COUNT(*) FROM scou_published_courses  JOIN scou_user_rate_published_course ON scou_user_rate_published_course.Published_Courses_Id = scou_published_courses.Id WHERE By_school IN (" . implode(',', $schools) . ") AND scou_published_courses.Courses_Id = scou_st_courses.Id) AS averageRate");
        }

        if ($getPublishedCourses) {
            $this->db->select("scou_st_courses.Startting_date AS startAt , scou_st_courses.End_date AS endDate");
            $this->db->where("scou_st_courses.Published_by", $this->account['admin_id']);
        }

        return $this->db->from("scou_st0_main_courses")
            ->join('scou_st_courses', 'scou_st_courses.Main_Courses_Id = scou_st0_main_courses.Id', $getPublishedCourses ? '' : 'left')
            ->join('sv_st_category', 'scou_st0_main_courses.Category_Id = sv_st_category.Id')
            ->join('scou_st0_courses_topics', 'scou_st0_courses_topics.Main_Courses_Id = scou_st0_main_courses.Id', 'left')
            ->join('scou_st0__main_courses_targeted_accounts', 'scou_st0__main_courses_targeted_accounts.Main_Courses_Id = scou_st0_main_courses.Id')
            ->where('scou_st0__main_courses_targeted_accounts.Organization_Id', $this->account['admin_id'])
            ->where('scou_st0__main_courses_targeted_accounts.Status', 1)
            ->where('scou_st0_main_courses.Status', 1)
            ->where('sv_st_category.Id', $category)
            ->group_by($getPublishedCourses ? 'scou_st_courses.Id' : 'scou_st0_main_courses.Id')
            ->get()->result_array();
    }
}