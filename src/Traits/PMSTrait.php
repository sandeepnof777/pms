<?php
namespace Pms\Traits;


trait PMSTrait
{

    public function set_success_message($message, $redirect = null)
    {
        $this->set_message('success', $message, $redirect);
    }

    public function set_error_message($message, $redirect = null)
    {
        $this->set_message('error', $message, $redirect);
    }

    public function set_message($type, $message, $redirect = null)
    {
        $this->session->set_flashdata($type, $message);
        if ($redirect) {
            // Home slash redirects again and message is lost so go to dashboard directly
            if ($redirect == '/') {
                $redirect = 'dashboard';
            }
            redirect($redirect);
        }
    }
}