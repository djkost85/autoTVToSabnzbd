<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Movie_Add extends Controller_Movie_Page {
    
    public function action_index() {
        $tmdb = new TmdbApi(Kohana::config('default.tmdb'));
//        var_dump($tmdb->search('tt0137523'));
        var_dump($tmdb->search('Angelina Jolie: Salt'));
//        var_dump($tmdb->search('salt'));
//        var_dump($tmdb->getInfo(550));

        $view = View::factory('movie/add/add');
        $this->template->title = __('Add movie');
        $view->set('title', __('Add movie'))
                ->set('languages', ORM::factory('language')->find_all())
                ->set('movies', array());

        $this->template->content = $view;
    }

    public function doAdd() {
        $this->auto_render = false;
    }
}

?>
