<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Renamer extends Controller_Page {
    
    public function action_index() {
        $view = View::factory('renamer/index');
        $view->set('title', 'Rename Series');
        if (is_dir(@$_GET['path'])) {
            $file = new ListFile($_GET['path']);
            $dirs = array();
            foreach ($file as $name => $obj) {
                if ($obj->isDir()) {
                    $dirs[] = $obj->getPath().DIRECTORY_SEPARATOR.$obj->getFilename();
                }
            }

            $view->set('directorys', $dirs);
        }
        $this->template->content = $view;
    }

    public function action_folder() {
        $this->auto_render = false;
        if (!is_dir($_GET['path'])) {
            throw new RuntimeException('No directory', 404);
        }

        ignore_user_abort(true);
        set_time_limit(0);

        $config = Kohana::config('series.renamer');
        
        $r = new Renamer($config);
        $r->rename($_GET['path']);

        $this->request->redirect('renamer/index');
    }
}
?>
