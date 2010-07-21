<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Xhtml {

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
                'items_per_page' => 15 // default 10
        ));

//
//
//        $matrix = new NzbMatrix(Kohana::config('default.default'));
//        var_dump($matrix->search('Top Gear 15x04', 41));

        
        Head::instance()->set_title('Visa alla serier');
        $menu = new View('menu');

        $xhtml = Xhtml::instance('welcome/index');
        $xhtml->body->set('title', 'Visa alla tv serier')
                ->set('noSeries', __('No series'))
                ->set('menu', $menu)
                ->set('imdb', Kohana::config('default.imdb'))
                ->set('pagination', $pagination->render())
                ->set('update', __('Update all'))
                ->set('edit', __('Edit'))
                ->set('delete', __('Delete'))
                ->set('listAllSpecials', __('List all specials'))
                ->set('banner', Model_Series::getRandBanner())
                ->set('rss', ORM::factory('rss'))
                ->set('series', ($seriesNum > 0) ? new LimitIterator($series, $pagination->offset, $pagination->items_per_page) : array());

        $this->request->response = $xhtml;

    }

} // End Welcome
