<?php

defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Error extends Controller_Page {

    public function action_404() {
        // Grab the Main Request URI
        $page = $this->request->param('id', $this->request->uri());

        // If your template has a title, you can set it here.
        $this->template->title = '404 Page Not Found';

        // Set the Request's Status to 404 (Page Not Found)
        $this->request->status = 404;

        // Here we need to strip our error page's text from the request URI if it is there.
        $pos = strpos($page, 'error/404/');
        if ($pos === 0) {
            $page = substr($page, 10);
        }

        $this->template->content = View::factory('error/i18n/404_' . I18n::lang())
                        ->set('page', $page);
    }

}

