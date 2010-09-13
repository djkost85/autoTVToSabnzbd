<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Movie_Page extends Controller_Template {

    public $template = 'movie/template';

    protected $_auto_update = true;
    protected $_no_db = true;

    /**
     * The before() method is called before your controller action.
     * In our template controller we override this method so that we can
     * set up default values. These variables are then available to our
     * controllers if they need to be modified.
     */
    public function before() {
        if (Request::$is_ajax) {
            $this->request->action = 'ajax_'.$this->request->action;
        }
        parent::before();

        if ($this->auto_render) {
            // Initialize empty values
            $this->template->title = '';
            $this->template->content = '';

            $this->template->styles = array();
            $this->template->scripts = array();
            $this->template->codes = array();
        }

        $this->template->bodyPage = get_class($this);
    }

    /**
     * The after() method is called after your controller action.
     * In our template controller we override this method so that we can
     * make any last minute modifications to the template before anything
     * is rendered.
     */
    public function after() {
        if ($this->auto_render) {
            $styles = array(
//                'screen' => 'css/style.css',
                'css/black.css?bar=' . time() => 'screen',
                'css/movie.css?foo=' . time() => 'screen',
            );

            $scripts = array(
                'jQuery' => 'js/jQuery.js',
                'functions' => 'js/functions.js',
                'tooltip' => 'js/tooltip.js',
            );

            $codes = array(
                'home path' => 'var baseUrl = "' . URL::base() . '"',
                'ajax path' => 'var ajaxUrl = "' . URL::site() . '"',
                'timer' => '$.timer(2, function (timer) {
    var url = ajaxUrl + "movie/download/checkList";
    $.get(url);
    timer.reset(100);
});',
            );
            

            $this->template->styles = array_merge($styles, $this->template->styles);
            $this->template->scripts = array_merge($scripts, $this->template->scripts);
            $this->template->codes = array_merge($codes, $this->template->codes);


            $this->template->menu = View::factory('movie/menu')->__toString();
            $footer = View::factory('movie/footer');

            $denySidbar = array(
                );



            $showSidebar = !in_array(get_class($this), $denySidbar);
            $footer->set('showSidebar', $showSidebar);

            if ($showSidebar) {
                $top10Arr = array();
                $filename = APPPATH . 'cache/' . md5('top10') . '.movie';
                if (is_readable($filename)) {
                    $top10Arr = unserialize(file_get_contents($filename));
                }
                $new10Arr = array();
                $filename = APPPATH . 'cache/' . md5('new10') . '.movie';
                if (is_readable($filename)) {
                    $new10Arr = unserialize(file_get_contents($filename));
                }

                $footer->set('top10Arr', $top10Arr);
                $footer->set('new10Arr', $new10Arr);
            }

            $filename = APPPATH . 'cache/' . md5('download_list') . '.list';
            $downloadList = array();
            if (is_readable($filename)) {
                $newList = unserialize(file_get_contents($filename));
                foreach($newList as $id => $time) {
                    $downloadList[] = ORM::factory('movie')->find($id);
                }
            }

            $footer->set('downloadList', $downloadList);


            $this->template->footer = $footer->__toString();
        }

        parent::after();


        if ($this->_auto_update) {
            $session = Session::instance();

            $movieUpdate = $session->get('movie_update', null);

            if (time() >= strtotime('2 hours', $movieUpdate)) {
                $session->set('movie_update', time());
                Helper::backgroundExec(URL::site('movie/update/all', true));
            }

        }

    }

}