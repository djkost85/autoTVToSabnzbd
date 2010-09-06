<?php defined('SYSPATH') or die('No direct script access.');

//-- Environment setup --------------------------------------------------------


/**
 * Set the default time zone.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/Stockholm');

/**
 * Set the default locale.
 *
 * @see  http://docs.kohanaphp.com/about.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://docs.kohanaphp.com/about.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------


$baseUrl = str_replace('//', '/', '/' . trim(str_replace('index.php', '', str_replace(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF'])), '/') . '/');

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
    'base_url' => $baseUrl,
    //'index_file' => FALSE,
    ));

//Kohana::$environment = Kohana::DEVELOPMENT;
Kohana::$environment = Kohana::PRODUCTION;

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);



//I18n::lang('se-se');
// Define the approved languages
$languages = array('en', 'se', 'no', 'da', 'fi', 'fr', 'ge');
$session = Session::instance();

// Look for a requested change in language
if(isset($_GET['lang']) && in_array($_GET['lang'], $languages)) {
    $session->set('lang', $_GET['lang']);
}

I18n::lang($session->get('lang', 'en'));


/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	 'pagination' => MODPATH.'pagination', // Paging of results
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	 'cache'      => MODPATH.'cache',
	));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('search', 'search', array()
)->defaults(array(
    'controller' => 'search',
    'action' => 'index',
));

Route::set('episode', 'episodes/<id>',
array(
    'id' => '\d+'
))->defaults(array(
    'controller' => 'episodes',
    'action' => 'listAll',
));

Route::set('theTvDbImages', 'images/thetvdb/<size>', array(
    'size' => '[\d]+'
))
->defaults(array(
    'controller' => 'images',
    'action' => 'thetvdb',
));

Route::set('ordinaryImages', 'image/<file>', array(
    'file' => '.+\.(?:jpe?g|png|gif)'
))
->defaults(array(
    'controller' => 'images',
    'action' => 'ordImage',
));


Route::set('images', 'images/<dir>/<file>(/<size>)', array(
    'file' => '.+\.(?:jpe?g|png|gif)'
))
->defaults(array(
    'controller' => 'images',
    'action' => 'show',
));

Route::set('download', 'download/episode/<id>',
array(
    'id' => '\d+'
))
->defaults(array(
    'controller' => 'download',
    'action' => 'episode',
));


Route::set('delete_ep', 'episodes/delete/<series_id>/<episode_id>',
array(
    'series_id' => '\d+',
    'episode_id' => '\d+'
))
->defaults(array(
    'controller' => 'episodes',
    'action' => 'delete',
));



// Error
Route::set('error', 'error(/<action>(/<id>))', array('id' => '.+'))
->defaults(array(
    'controller' => 'error',
    'action'     => '404',
    'id'	 => FALSE,
));


Route::set('movie_default', 'movie/<controller>(/<action>(/<id>))')
->defaults(array(
    'directory'  => 'movie',
    'controller' => 'index',
    'action'     => 'index',
));


Route::set('default', '(<controller>(/<action>(/<id>)))')
->defaults(array(
    'controller' => 'welcome',
    'action'     => 'index',
));

/* The URI to test */
//$uri = 'movie/index';
///**
// * This will loop trough all the defined routes and
// * tries to match them with the URI defined above
// */
//foreach (Route::all() as $key => $r) {
//    echo Kohana::debug($key, $r->matches($uri));
//}
//exit;

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
/*echo Request::instance()
	->execute()
	->send_headers()
	->response;*/

$request = Request::instance();
try {
    $request->execute();
} catch (ReflectionException $e) {
    // URL for new route
    $new_request = Request::factory('error/404/' . $request->uri());
    $new_request->execute();
    $new_request->status = 404;
    if ($new_request->send_headers()) {
        die($new_request->response);
    }
}

if ($request->send_headers()->response) {
    echo $request->response;
}


