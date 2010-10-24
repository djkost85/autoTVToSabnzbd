<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Movie_List extends Controller_Movie_Page {

    public function action_index() {
//        $filename = APPPATH . 'cache/' . md5('download_list') . '.list';
//        $data = unserialize(file_get_contents($filename));
//        var_dump($data);

        try {
            $movie = ORM::factory('movie');
        } catch (Database_Exception $e) {
            try {
                Helper_Path::mkdir_recursive('images/movies');
                Model_Movie::installTable();
                $this->request->redirect('movie/list');
            } catch (Database_Exception $e) {
                Kohana::exception_handler($e);
                return;
            }
        }

        $pagination = Pagination::factory( array (
            'base_url' => "movie/list",
            'total_items' => $movie->count_all(),
            'items_per_page' => 12 // default 10
        ));

        if (isset($_GET['orderby_rating'])) {
            $movie = $movie->order_by('rating', $_GET['orderby_rating']);
        }
        if (isset($_GET['orderby_name'])) {
            $movie = $movie->order_by('name', $_GET['orderby_name']);
        }
        if (isset($_GET['orderby_released'])) {
            $movie = $movie->order_by('released', $_GET['orderby_released']);
        }

        $view = View::factory('movie/list/index');
        $this->template->title = __('Show all movies');
        $view->set('title', __('Show all movies'))
                ->set('edit', __('Edit'))
                ->set('download', __('Download'))
                ->set('rating', __('Rating/Votes'))
                ->set('released', __('Released'))
                ->set('pagination', $pagination->render())
                ->set('movies', $movie->limit($pagination->items_per_page)->offset($pagination->offset)->find_all());

        $this->template->content = $view;
    }

    public function action_test() {
        $this->auto_render = FALSE;
        $tmdb = new TmdbApi(Kohana::config('movie.tmdb'));
//        var_dump($tmdb->search('Angelina Jolie: Salt'));
//        $test = $tmdb->getLatest();
//        var_dump($test);
        var_dump($tmdb->getGenresList());
    }

    public function action_delete($id) {
        $movie = ORM::factory('movie');
        $movie = $movie->find($id);
        
        $view = View::factory('movie/list/delete');
        $this->template->title = $movie->name;
        $view->set('title', $movie->name)
                ->set('movie', $movie);

        $this->template->content = $view;
    }
    public function action_doDelete($id) {
        $this->auto_render = FALSE;
        $movie = ORM::factory('movie');
        $movie = $movie->find($id);

        $name = $movie->name;

        $path = "images/movies/" . $name;
        Helper_Path::delete_dir_recursive($path);

        $filename = APPPATH . 'cache/' . md5('download_list') . '.list';
        if (is_readable($filename)) {
            $data = unserialize(file_get_contents($filename));
            if (isset($data[$movie->id])) {
                unset ($data[$movie->id]);
                file_put_contents($filename, serialize($data));
            }
        }

        $movie->delete();

        MsgFlash::set($name . ' ' . __('is deleted'));
        $this->request->redirect('movie/list');
    }

    
    public function action_rmDlList($id) {
        $this->auto_render = FALSE;
        $movie = ORM::factory('movie', $id);

        if (!$movie->loaded()) {
            throw new RuntimeException('No movie with that id', 404);
        }

        Request::factory('movie/download/rmFromList/' . $id)->execute()->response;
        MsgFlash::set("$movie->name is removed from list");
        $this->request->redirect("movie/list/info/$id");

    }
    public function action_addDlList($id) {
        $this->auto_render = FALSE;
        $movie = ORM::factory('movie', $id);

        if (!$movie->loaded()) {
            throw new RuntimeException('No movie with that id', 404);
        }

        Request::factory('movie/download/setToList/' . $id)->execute()->response;
//        Helper::backgroundExec(URL::site('movie/download/movie/' . $id, true));
        MsgFlash::set("$movie->name added to list");
        $this->request->redirect("movie/list/info/$id");
    }

    public function action_info($id) {
        $movie = ORM::factory('movie');
        $movie = $movie->find($id);

        $view = View::factory('movie/list/info');

        if ($movie->name === null) {
            $movie->name = __('No movie');
            $movie->id = 0;
            $movie->posters = serialize(array());
            $movie->overview = "";
        }
//        else {
//            $tmdb = new TmdbApi(Kohana::config('movie.tmdb'));
//            $view->set('movieInfo', $tmdb->getMovieInfo($movie->tmdb_id));
//        }

        $this->template->scripts['jquery.swfobject.1-1-1.min'] = 'js/jquery.swfobject.1-1-1.min.js';
        $this->template->scripts['youTubeEmbed'] = 'js/youTubeEmbed.js';
        $this->template->styles['css/youTubeEmbed.css'] = 'screen';


        $filename = APPPATH . 'cache/' . md5('download_list') . '.list';
        $inList = false;
        if (is_readable($filename)) {
            $newList = unserialize(file_get_contents($filename));
            foreach($newList as $id => $time) {
                if ($movie->id == $id) {
                    $inList = true;
                }
            }
        }

        $this->template->title = $movie->name;
        $view->set('title', $movie->name)
                ->set('inDlList', $inList)
                ->set('movie', $movie);

        $this->template->content = $view;
    }
}

?>
