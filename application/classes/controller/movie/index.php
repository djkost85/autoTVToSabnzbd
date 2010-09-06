<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Movie_Index extends Controller_Movie_Page {

    public function action_index() {
        $view = View::factory('movie/index/index');
        $this->template->title = __('Show all movies');
        $view->set('title', __('Show all movies'))
                ->set('movies', array());

        $this->template->content = $view;
    }
}

?>
