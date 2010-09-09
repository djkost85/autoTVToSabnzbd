<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Movie_Config extends Controller_Movie_Page {

    public function action_index() {
        $tmdb = new TmdbApi(Kohana::config('movie.tmdb'));
        
        $view = View::factory('movie/config/index');
        $this->template->title = __('Config movies');
        $view->set('title', __('Config movies'))
                ->set('top10listGenre', Kohana::config('movie.list.top10.genre'))
                ->set('new10listGenre', Kohana::config('movie.list.new10.genre'))
                ->set('sabCat', Kohana::config('movie.sabnzbd.category'))
                ->set('genres', $tmdb->getGenresList());

        $this->template->content = $view;
    }

    public function action_save() {
        $config = array(
            'list' => $_GET['list'],
            'sabnzbd' => $_GET['sabnzbd'],
        );

        file_put_contents('application/config/movie.data', serialize($config));
        Helper::backgroundExec(URL::site('movie/update/all', true));
        MsgFlash::set(__('Configuration saved'));
        $this->request->redirect('movie/config/index');
    }
}

?>
