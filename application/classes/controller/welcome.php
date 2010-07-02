<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Xhtml {

    public function action_index() {
//        $series = ORM::factory('series');
//        var_dump($series->getByFirtAired()->as_array());
        $series = Model_SortFirstAired::getSeries();
        $seriesNum = $series->count();
        $pagination = Pagination::factory( array (
                'base_url' => "",
//                'total_items' => $series->count_all(),
                'total_items' => $seriesNum,
                'items_per_page' => 15 // default 10
        ));

//        var_dump(round((20/100)*100));
//
//        $sab = new Sabnzbd(Kohana::config('default.Sabnzbd'));
//        var_dump($sab->get('queue'));

//        $tv = new TheTvDB(Kohana::config('default.default.TheTvDB_api_key'), "huck");
//
//        var_dump($tv->getSeries());

        /**
        $tv = new TheTvDB(Kohana::config('default.default.TheTvDB_api_key'), "Chuck");
        //var_dump($tv->getLanguagesFromTvDb());
//CREATE TABLE IF NOT EXISTS `languages` (
//  `id` int(11) NOT NULL,
//  `name` varchar(20) NOT NULL,
//  `abbreviation` varchar(3) NOT NULL
//) ENGINE=MyISAM DEFAULT CHARSET=latin1;
         

        $ORMLang = ORM::factory('language');
        foreach ($tv->getLanguagesFromTvDb()->Language as $lang) {
            $ORMLang->id = $lang->id;
            $ORMLang->name = $lang->name;
            $ORMLang->abbreviation = $lang->abbreviation;
            $ORMLang->save();
        }
         * 
         */
 

//        var_dump(Feed::create(array('foo', 'bar'), array('greens' => array('foo' => 'val', 'bar' => 'vat'))));

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
                ->set('banner', ORM::factory('series')->getRandBanner())
                ->set('rss', ORM::factory('rss'))
                ->set('series', ($seriesNum > 0) ? new LimitIterator($series, $pagination->offset, $pagination->items_per_page) : array());
//                ->set('series', $series->getByFirtAired($pagination->items_per_page, $pagination->offset));

        $this->request->response = $xhtml;

    }

    public function action_test() {
        $series = ORM::factory('series');

        $pagination = Pagination::factory(array(
                    'base_url' => "",
                    'total_items' => $series->count_all(),
                    'items_per_page' => 15 // default 10
                ));

        Head::instance()->set_title('Visa alla serier');
        $menu = new View('menu');

        $xhtml = Xhtml::instance('welcome/test');
        $xhtml->body->set('title', 'Visa alla tv serier')
                ->set('noSeries', __('No series'))
                ->set('menu', $menu)
                ->set('imdb', Kohana::config('default.imdb'))
                ->set('pagination', $pagination->render())
                ->set('update', __('Update all'))
                ->set('edit', __('Edit'))
                ->set('delete', __('Delete'))
                ->set('listAllSpecials', __('List all specials'))
                ->set('banner', ORM::factory('series')->getRandBanner())
                        ->set('items_per_page', $pagination->items_per_page)
                        ->set('offset', $pagination->offset)
//                ->set('series', $series->getByFirtAired($pagination->items_per_page, $pagination->offset));
                ->set('series', $series);

        $this->request->response = $xhtml;
    }

} // End Welcome
