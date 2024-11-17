<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_Output $output
 */
class Response
{

    public function json($response = array())
    {
        header('Content-Type: application/json'); //set the data header to return json
        echo json_encode($response);
        exit();
    }

    public function dd($array = array())
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        exit();
    }

    public function abort($status = 404)
    {
        $status = (string)$status;

        $CI = &get_instance();
        $CI->output->set_status_header($status);
        die();
    }

    public function abort_if($status = 404, bool $condition = false): void
    {
        if ($condition) {
            $this->abort($status);
        }
    }

    public function formatClassToRouteName(CI_Controller $controller)
    {
        $name = strtolower(get_class($controller));
        return str_replace("_", "-", $name);
    }

    public function permission_gate(bool $hasPermission = false, CI_Controller $controller = null)
    {
        if ($hasPermission) return true;
        $CI = &get_instance();

        $dataDes['to'] = $controller::LANGUAGE . "/" . $this->formatClassToRouteName($controller);
        $CI->load->view('EN/Global/disabledPerm', $dataDes);
        die();
    }
}