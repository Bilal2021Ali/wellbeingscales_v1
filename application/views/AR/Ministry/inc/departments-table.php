<!-- Your code before line 252 -->

<?php
// Retrieve the departments data or assign an empty array if not available
$departmentsData = []; // Replace this with your code to retrieve the departments data

// Check if the departments data is an array
if (is_array($departmentsData)) {
    // Retrieve the city IDs from the departments data
    $city_ids = array_column($departmentsData, 'Citys');

    // Query for all cities if city IDs are available
    if (!empty($city_ids)) {
        $city_ids = implode(',', $city_ids);
        $cities = $this->db->query("SELECT `id`, `Name_EN` FROM `r_cities` WHERE `id` IN ($city_ids)")->result_array();
        $city_names = array_column($cities, 'Name_EN', 'id');
    } else {
        $city_names = [];
    }

    // Load the departments table view
    $this->load->view('EN/Ministry/inc/departments-table', ['departments' => $departmentsData, 'city_names' => $city_names, 'disableStatusControl' => true]);
} else {
    // Handle the case when departments data is not available
    echo "No departments data found.";
}

// Rest of your code after line 252
?>
