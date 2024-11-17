<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class EmailSender
{

    public function send($settings = [
        "subject" => "",
        "message" => "",
        "to"      => "",
    ])
    {
        $CI = &get_instance();
        $CI->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.qlicksystems.com',
            'smtp_port' => 465,
            'smtp_user' => 'no_reply@track.qlickhealth.com',
            'smtp_pass' => 'Bd}{kKW]eTfH',
            'smtp_crypto' => 'ssl',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
        if ($this->email->from('no_reply@qlicksystems.com')
            ->to($settings['to'])
            ->subject($settings['subject'])
            ->message($settings['message'])
            ->send()
        ) {
            return ['status' => "ok"];
        }else{
            return ['status' => "error" , "debug" => $this->email->print_debugger()];
        }
    }
}
