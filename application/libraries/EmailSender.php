<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class EmailSender
{
    public function send($settings = [
        "subject" => "",
        "message" => "",
        "to"      => "",
    ])
    {
        // الحصول على مثيل CodeIgniter
        $CI = &get_instance();
        
        // تحميل مكتبة البريد
        $CI->load->library('email');
        
        // تحميل إعدادات البريد من ملف التكوين
        $CI->config->load('email');  // تحميل إعدادات البريد
        $config = $CI->config->item('email');  // الحصول على الإعدادات من ملف التكوين

        // التحقق من وجود قيم في إعدادات البريد
        if (empty($settings['subject']) || empty($settings['message']) || empty($settings['to'])) {
            return ['status' => "error", 'debug' => 'البريد الإلكتروني غير مكتمل (الموضوع، الرسالة، أو المستلم مفقود)'];
        }

        // استخدام الإعدادات من التكوين إذا كانت موجودة
        $config['protocol'] = $config['protocol'] ?? 'smtp';  // التحقق من وجود البروتوكول
        $config['smtp_host'] = $config['smtp_host'] ?? 'mail.qlicksystems.com';  // التحقق من وجود الخادم
        $config['smtp_port'] = $config['smtp_port'] ?? 465;  // التحقق من وجود المنفذ
        $config['smtp_user'] = $config['smtp_user'] ?? 'jobs@qlicksystems.com';  // التحقق من وجود اسم المستخدم
        $config['smtp_pass'] = $config['smtp_pass'] ?? 'O?#f:Kc19#z';  // التحقق من وجود كلمة المرور
        $config['smtp_crypto'] = $config['smtp_crypto'] ?? 'ssl';  // التحقق من وجود تشفير SSL
        $config['mailtype']  = $config['mailtype'] ?? 'html';  // التحقق من وجود نوع البريد
        $config['charset']   = $config['charset'] ?? 'iso-8859-1';  // التحقق من وجود الترميز
        $config['smtp_timeout'] = $config['smtp_timeout'] ?? 30;  // التحقق من وجود المهلة
        $config['newline']   = $config['newline'] ?? "\r\n"; // التحقق من وجود نهاية الأسطر
        $config['crlf']      = $config['crlf'] ?? "\r\n";  // التحقق من وجود نهاية السطر

        // تهيئة المكتبة بالإعدادات
        $CI->email->initialize($config);

        // إعدادات البريد
        $CI->email->from('no_reply@qlicksystems.com', 'Wellbeing Scales'); // من البريد
        $CI->email->to($settings['to']); // المرسل إليه
        $CI->email->subject($settings['subject']); // الموضوع
        $CI->email->message($settings['message']); // الرسالة

        // التحقق من إرسال البريد
        if ($CI->email->send()) {
            return ['status' => "ok"];
        } else {
            // طباعة الأخطاء في حالة الفشل
            return ['status' => "error", "debug" => $CI->email->print_debugger()];
        }
    }
}
