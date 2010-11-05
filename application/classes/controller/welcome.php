<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Page {

    protected function setRssSubFile() {
        $filename = APPPATH.'cache/' . md5('subtitles').'.sub';
        $rss = ORM::factory('rss');
        $series = ORM::factory('series');

        $lang = Kohana::config('subtitles.lang');
        $result = array();
        foreach ($rss->find_all() as $row) {
            var_dump($row->guid);
            $sub = Subtitles::facory($row->guid, $lang);
            var_dump($sub);
            if (count($sub) > 0) {
                if (is_array($sub)) {
                    $sub = $sub[0];
                }
                $parse = new NameParser($row->title);
                $parsed = $parse->parse();
                var_dump($parsed);
                $ser = $series->where('series_name', '=', $parsed['name'])->find()->episodes
                        ->where('episode', '=', $parsed['episode'])
                        ->and_where('season', '=', $parsed['season'])
                        ->find();

    //            $ser = $series->where('series_name', '=', str_replace('.', ' ', $parsed['name']))->find();
                $result[$ser->id] = array('guid' => $row->guid, 'file' => $sub, 'title' => $row->title);
            }
        }

        if (count($result) > 0) {
            $data = serialize($result);
            file_put_contents($filename, $data);
        }
    }

    public function action_index() {
//        $config = Kohana::config('default');
//        $matrix = new NzbMatrix_Rss($config->default);
//        $result = $matrix->search(Helper_Search::escapeSeriesName(sprintf('%s S%02dE%02d', ORM::factory('series')->where('id', '=', 29)->find()->series_name, 3, 3)), 6);
//
//        var_dump($result);


//        $search = Helper_Search::escapeSeriesName(sprintf('%s %dx%02d', preg_replace('/[0-9]/', '', ORM::factory('series')->where('id', '=', 29)->find()->series_name), 3, 3));
//        $search = str_replace('  ', ' ', $search);
//        var_dump($search);
//        $config = Kohana::config('default');
//        $matrix = new NzbMatrix_Rss($config->default);
//        $result = $matrix->search($search, 6);
//        var_dump($result);
//
//        $nzbs = new Nzbs($config->nzbs);
//        $xml = $nzbs->search($search, Nzbs::matrixNum2Nzbs(6));
//        var_dump($xml);



//        var_dump(Subtitles::facory('Lost.S06E17.HDTV.XviD-NoTV', 8));

//        $this->setRssSubFile();
   

//        $filename = APPPATH.'cache/' . md5('subtitles').'.sub';
//        $subs = unserialize(file_get_contents($filename));
//        var_dump($subs);


        try {
            $count = ORM::factory('series')->count_all();
        } catch (ErrorException $e) {
            MsgFlash::set($e->getMessage());
            $this->request->redirect('config/database');
        } catch (Database_Exception $e) {
            MsgFlash::set($e->getMessage());
            $this->request->redirect('config/database');
        }

        if (Kohana::config('default.rss') === null) {
            MsgFlash::set(__('Configure me'));
            $this->request->redirect('config/index');
        }
        
        $pagination = Pagination::factory( array (
            'base_url' => "",
            'total_items' => $count,
            'items_per_page' => Kohana::config('default.welcome.numrows'),
        ));


        $series = Model_SortFirstAired::getWelcomeSeries($pagination->items_per_page, $pagination->offset);
        
        $this->template->title = __('Show all series');

        $xhtml = View::factory('welcome/index');
        $xhtml->set('title', __('Show all series'))
            ->set('noSeries', __('No series'))
            ->set('imdb', Kohana::config('default.imdb'))
            ->set('pagination', $pagination->render())
            ->set('update', __('Update all'))
            ->set('edit', __('Edit'))
            ->set('delete', __('Delete'))
            ->set('listAllSpecials', __('List all specials'))
            ->set('banner', Model_Series::getRandBanner())
            ->set('rss', ORM::factory('rss'))
            ->set('series', $series);


        $filename = APPPATH.'cache/' . md5('subtitles').'.sub';
        if (Kohana::config('subtitles.download') && is_file($filename)) {
            $xhtml->set('subtitles', unserialize(file_get_contents($filename)));
        }

        $this->template->content = $xhtml;
        
    }

} // End Welcome
