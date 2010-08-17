<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <link rel="alternate" type="application/rss+xml" title="AutoTvToSab RSS Feed for SABnzbd" href="<?php echo URL::site('rss/index', true)?>" />
            <?php
            foreach ($styles as $file => $type) {
                echo HTML::style($file, array('media' => $type)), "\n" ;
            }
            
            foreach ($scripts as $file) {
                echo HTML::script($file), "\n" ;
            }

            foreach ($codes as $code) {
		echo '<script '.Html::attributes(array('type' => 'text/javascript')).'>//<![CDATA['."\n".$code."\n".'//]]></script>';
            }
            ?>

    </head>
    <body id="<?php echo $bodyPage?>">
        <?php
        echo $menu;
        echo $content; 
        echo $footer; 
        if (Kohana::$environment == Kohana::DEVELOPMENT) {
            echo '<div id="kohana-profiler">'.View::factory('profiler/stats').'</div>';
        }
        ?>
    </body>
</html>