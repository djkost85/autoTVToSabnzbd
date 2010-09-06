<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Page {

    public function action_index() {        
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
