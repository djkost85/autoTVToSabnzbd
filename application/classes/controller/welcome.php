<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Page {

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

        $this->template->content = $xhtml;
        
    }

} // End Welcome
