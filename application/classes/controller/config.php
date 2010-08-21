<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Config extends Controller_Page {

    public function action_index() {
        $this->template->title = __('Config');
        $view = View::factory('config/index');

        $default = Kohana::config('default');

//        file_put_contents('application/config/default.data', serialize($default->as_array()));
//        var_dump(unserialize(file_get_contents('application/config/default.data')));

        $view->set('title', __('Config'));

        if (isset($default->rss)) {
            $view->set('TheTvDB_api_key', $default->default['TheTvDB_api_key'])
                ->set('NzbMatrix_api_key', $default->default['NzbMatrix_api_key'])
                ->set('NzbMatrix_api_user', $default->default['NzbMatrix_api_user'])
                ->set('use_nzb_site', $default->default['useNzbSite'])
                ->set('sab_api_key', $default->Sabnzbd['api_key'])
                ->set('sab_url', $default->Sabnzbd['url'])
                ->set('rss_number_of_results', $default->rss['numberOfResults'])
                ->set('rss_how_old', $default->rss['howOld'])
                ->set('nzbs_query_string', $default->nzbs['queryString'])
                ->set('series_update_every', $default->update['seriesUpdateEvery']);
        } else if (isset($default->default) && !isset($default->default['useNzbSite'])) {
            $view->set('use_nzb_site', 'nzbMatrix');
        }
    
        $this->template->content = $view;
    }

    public function action_save() {
        $this->auto_render = false;
//        $default = Kohana::config('default');
//        $default = $default->as_array();

        $default = array();
        if (empty($_GET['use_nzb_site'])) {
            $_GET['use_nzb_site'] = "nzbMatrix";
        }

        $default['default']['TheTvDB_api_key'] = $_GET['thetvdb_api_key'];
        $default['default']['NzbMatrix_api_key'] = $_GET['matrix_api_key'];
        $default['default']['NzbMatrix_api_user'] = $_GET['matrix_api_user'];
        $default['default']['useNzbSite'] = $_GET['use_nzb_site'];
        $default['Sabnzbd']['api_key'] = $_GET['sab_api_key'];
        $default['Sabnzbd']['url'] = $_GET['sab_url'];
        $default['nzbs']['queryString'] = $_GET['nzbs_query_string'];
        $default['rss']['numberOfResults'] = $_GET['rss_num_results'];
        $default['rss']['howOld'] = $_GET['rss_how_old'];
        $default['update']['seriesUpdateEvery'] = $_GET['series_update_every'];

        file_put_contents('application/config/default.data', serialize($default));

        MsgFlash::set(__('Configuration saved'));
        $this->request->redirect('config/index');
    }

    public function action_database() {
        $this->template->title = __('Config');
        $view = View::factory('config/database');

        $view->set('title', __('Config'));
        $this->template->content = $view;
    }

    public function action_saveDb() {
        $this->auto_render = false;
        $_GET['pass'] = (empty($_GET['pass'])) ? "FALSE": "'{$_GET['pass']}'";
        $config = "<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
	'default' => array
	(
		'type'       => 'mysql',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname
			 * string   username
			 * string   password
			 * boolean  persistent
			 * string   database
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'hostname'   => '{$_GET['host']}',
			'username'   => '{$_GET['user']}',
			'password'   => {$_GET['pass']},
			'persistent' => FALSE,
			'database'   => '{$_GET['database']}',
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
	'alternate' => array(
		'type'       => 'pdo',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn
			 * string   username
			 * string   password
			 * boolean  persistent
			 * string   identifier
			 */
			'dsn'        => 'mysql:host=localhost;dbname=kohana',
			'username'   => 'root',
			'password'   => 'r00tdb',
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);";

        file_put_contents('application/config/database.php', $config);

        try {
            $db  = Database::instance('default');
        } catch (ErrorException $e) {
            MsgFlash::set($e->getMessage());
            $this->request->redirect('config/database');
        }

        MsgFlash::set(__('Configuration saved'));
        $this->request->redirect('config/database');
    }

}



?>
