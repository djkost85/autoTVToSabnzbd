<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Movie_Update extends Controller {
    public function action_index() {

    }

    public function action_all() {
        $config = Kohana::config('movie.list');
        
        $top10g = $config['top10']['genre'];
        $top10 = 'top10';
        if ($top10g > 0) {
            $top10 = 'top10_' . $top10g;
        }
//        var_dump($top10);
        $updates = TmdbApi::factoryBrowser($top10);
        if (is_array($updates)) {
            $filename = APPPATH . 'cache/' . md5('top10') . '.movie';
            file_put_contents($filename, serialize($updates));
        }


        $new10g = $config['new10']['genre'];
        $new10 = 'new10';
        if ($new10g > 0) {
            $new10 = 'new10_' . $new10g;
        }
//        var_dump($new10);
        $updates = TmdbApi::factoryBrowser($new10);
        if (is_array($updates)) {
            $filename = APPPATH . 'cache/' . md5('new10') . '.movie';
            file_put_contents($filename, serialize($updates));
        }

        $this->request->response = __('Updated');
    }
}

?>
