<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Page {

    public function action_index() {
        $series = Cache::instance('default')->get('series');
        
        if (is_null($series)) {
            $series = Model_SortFirstAired::getSeries();
            Cache::instance('default')->set('series', $series);
        }

        $seriesNum = $series->count();
        $pagination = Pagination::factory( array (
            'base_url' => "",
            'total_items' => $seriesNum,
            'items_per_page' => 12 // default 10
        ));

        

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
            ->set('series', ($seriesNum > 0) ? new LimitIterator($series, $pagination->offset, $pagination->items_per_page) : array());

        $this->template->content = $xhtml;
        
    }

} // End Welcome
