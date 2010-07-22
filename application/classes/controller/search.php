<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 *
 * @author morre95
 */
class Controller_Search extends Controller_Xhtml {

    public function action_index() {
        Head::instance()->set_title(__('Search'));

        $xhtml = Xhtml::instance('search/index');
        $xhtml->body->set('title', __('Search'));

        $this->request->response = $xhtml;
    }

    public function action_result() {
        if ($_GET['where'] == 'matrix') {
            $this->request->redirect("http://nzbmatrix.com/nzb-search.php?" . http_build_query(array('search' => $_GET['q'], 'cat' => $_GET['cat'])));
        }

        $series = ORM::factory('series');
        $result = $series->search($_GET['q']);

        if ($result->count() > 1) {
            Head::instance()->set_title(__('Search'));

            $xhtml = Xhtml::instance('search/index');
            $xhtml->body->set('title', __('Search'))
                        ->set('results', $result->as_array());

            $this->request->response = $xhtml;
        } else if ($result->count() == 1) {
            $this->request->redirect("episodes/" . $result->get('id'));
        } else {
            $this->request->redirect('search' . URL::query(array('msg' => sprintf(__('no results'), $_GET['q']))));
        }
    }
}
?>
