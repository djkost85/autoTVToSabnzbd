<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of update
 *
 * @author morre95
 */
class Controller_Update extends Controller_Xhtml {

    public function action_downloadable() {
        $ep = ORM::factory('episode')->where('downloadable', 'is', DB::expr('NULL'))->and_where('season', '>', 0)->find();
        $series = $ep->getSeriesInfo();

        $matrix = new NzbMatrix_Rss(Kohana::config('default.default.NzbMatrix_api_key'));
        
        $search = sprintf('%s S%02dE%02d', $series->series_name, $ep->season, $ep->episode);
        $result = $matrix->search($search, $series->matrix_cat);

        foreach ($result->item as $res) {
            $parse = new NameParser((string)$res->title);
            $parsed = $parse->parse();
            if (sprintf('%02d', $parsed['season']) == sprintf('%02d', $ep->season) &&
                sprintf('%02d', $parsed['episode']) == sprintf('%02d', $ep->episode) &&
                strtolower($parsed['name']) == strtolower($series->series_name)) {
                var_dump($res->title);
                $params = Helper::gerParams((string)$res->link);
                $url = $matrix->buildDownloadUrl($params['id']);
                $ep->downloadable = $url;
                $ep->save();
                break;
            }

        }

    }
    
    

    public function action_all() {
        Head::instance()->set_title(__('Update all series'));
        $menu = new View('menu');

        $xhtml = Xhtml::instance('update/all');
        $xhtml->body->set('title', __('Update all series'))
                ->set('menu', $menu);

        $this->request->response = $xhtml;
    }

    public function action_doAll() {
        //ini_set('max_execution_time', 1000);
        set_time_limit(0);
        $series = ORM::factory('series');
        foreach ($series->find_all() as $s) {
            Request::factory('series/doUpdate/' . $s->id)->execute()->response;
        }

        $this->request->response = __('Finished');
    }

    public function action_ajax_doAll() {
        $this->action_doAll();
    }

}
?>
