<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Page {

    public function action_index() {
//        $series = Cache::instance('default')->get('series');
//
//        if (is_null($series)) {
//            $series = Model_SortFirstAired::getSeries();
//            Cache::instance('default')->set('series', $series);
//        }
//
//        $seriesNum = $series->count();
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
            'items_per_page' => 12 // default 10
        ));

//        $cacheName = (isset($_GET['page'])) ? "series_{$_GET['page']}" : "series";
//        $series = Cache::instance('default')->get($cacheName);
//
//        if (is_null($series)) {
//            $series = Model_SortFirstAired::getWelcomeSeries($pagination->items_per_page, $pagination->offset);
//            Cache::instance('default')->set($cacheName, $series);
//        }

        $series = Model_SortFirstAired::getWelcomeSeries($pagination->items_per_page, $pagination->offset);


//        if (MsgFlash::has()) {
//            echo MsgFlash::get();
//        }
//
//        MsgFlash::set('testter');

        //var_dump(Helper::backgroundExec(URL::site('rss/update', true)));

//        $matrix = new NzbMatrix(Kohana::config('default.default'));
//        var_dump($matrix->search('Top Gear s15e04', 41));
        
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
//            ->set('series', ($seriesNum > 0) ? new LimitIterator($series, $pagination->offset, $pagination->items_per_page) : array());
            ->set('series', $series);

        $this->template->content = $xhtml;
        
    }

} // End Welcome
