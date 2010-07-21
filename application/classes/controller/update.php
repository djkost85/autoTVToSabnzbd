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

        $matrix = new NzbMatrix_Rss(Kohana::config('default.default'));
        
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

        $phpPath = (isset($_GET['path_to_php'])) ? $_GET['path_to_php'] : 'C:\wamp\bin\php\php5.3.0\php.exe';

        $urlRss = "http://dev/autoTvToSab/rss/update";
        $urlSeries = "http://dev/autoTvToSab/update/doAll";
        $data = "<?php
set_time_limit(0);

\$filename = \"%s\";

file_get_contents(\$filename);
?>";
        $cmdData = "%s -f %s";
        $urlPhpRss = DOCROOT.'updateRss.php';
        $urlPhpSeries = DOCROOT.'updateSeries.php';
        if (isset($_GET['rss'])) {
            file_put_contents(DOCROOT.'updateRss.php', sprintf($data, $urlRss));
            file_put_contents(DOCROOT.'cmd/rssUpdate.cmd', sprintf($cmdData, $_GET['path_to_php'], $urlPhpRss));
            forceDownload(DOCROOT.'cmd/rssUpdate.cmd');
        }
        if (isset($_GET['series'])) {
            file_put_contents(DOCROOT.'updateSeries.php', sprintf($data, $urlSeries));
            file_put_contents(DOCROOT.'cmd/seriesUpdate.cmd', sprintf($cmdData, $_GET['path_to_php'], $urlPhpSeries));
            forceDownload(DOCROOT.'cmd/seriesUpdate.cmd');
        }

        $xhtml = Xhtml::instance('update/i18n/' . I18n::lang());
        $xhtml->body->set('title', __('Update all series'))
                ->set('menu', $menu)
                ->set('phpPath', $phpPath);

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

    public function action_prepareFile() {
        
    }

}

function forceDownload($file) {
    $file = realpath($file);
    if (file_exists($file)) {
        header("Content-type: application/force-download");
        header('Content-Disposition: inline; filename="' . basename($file) . '"');
        header("Content-length: " . filesize($file));
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Transfer-Encoding: Binary");
        readfile($file);
    } else {
        echo "No file selected";
    }
}
?>
