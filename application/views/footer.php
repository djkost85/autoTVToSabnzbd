<?php defined('SYSPATH') or die('No direct script access.'); ?>

<?php if ($showSidebar) { ?>
<!-- sidebar starts -->
                <div id="sidebar">
                    <div  class="new-episodes">
                        <div class="inner">
                            <h3><?php echo __('New Episodes')?></h3>
                            <ol>
                                <?php foreach ($episodes as $ep) { ?>
                                    <?php
                                    $series = $ep->getSeriesInfo();

                                    if (empty($series)) continue;
                                    ?>
                                    <li>
                                        <?php echo HTML::anchor('episodes/'.$series->id, $series->series_name)?>
                                        <div><?php echo sprintf("S%02dE%02d", $ep->season, $ep->episode)?> 
                                            <?php echo __('Airs') ?>
                                            <?php echo $ep->first_aired?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>




                    <div class="ended-series">
                        <div class="inner">
                            <h3><?php echo __('Ended Series')?></h3>
                            <ul class="sidemenu">
                                <?php foreach ($endedSeries as $ser) { ?>
                                <li><?php echo HTML::anchor("episodes/$ser->id", $ser->series_name)?></li>
                                <?php } ?>
                            </ul>
                            </div>
                    </div>
                </div>
                <!-- sidebar ends -->
            </div>
            <?php } ?>
            <!-- content-wrap ends-->
            <div class="clearer"></div>
        </div>
        <!-- footer starts here -->

<div id="footer-wrap">

<div id="footer-columns">
    <div class="col3">
        <h2>Languages</h2>
        <ul>
            <li><?php echo HTML::anchor(URL::query(array('lang' => 'se')), HTML::image('images/flags/se.png', array('alt' => 'Language icon')))?></li>
            <li><?php echo HTML::anchor(URL::query(array('lang' => 'en')), HTML::image('images/flags/en.png', array('alt' => 'Language icon')))?></li>
            <li><?php echo HTML::image('images/flags/no.png', array('alt' => 'Language icon'))?></li>
            <li><?php echo HTML::image('images/flags/da.png', array('alt' => 'Language icon'))?></li>
            <li><?php echo HTML::image('images/flags/fi.png', array('alt' => 'Language icon'))?></li>
            <li><?php echo HTML::image('images/flags/fr.png', array('alt' => 'Language icon'))?></li>
            <li><?php echo HTML::image('images/flags/ge.png', array('alt' => 'Language icon'))?></li>
        </ul>

    </div>
    <div class="col3-center">
        <!--<h2>Friends &amp; Sponsors</h2>
        <ul>
            <li><a href="#">CSS</a></li>
            
        </ul>-->
    </div>
    <div class="col3">
        <!--<h2>Something completely different</h2>
        <ul>
            <li><a href="#">Perfect Layout </a></li>
            <li><a href="#">Firstlight Studio </a></li>
            <li><a href="#">Freelance portfolio </a></li>
            <li><a href="#">sony ericsson vivaz review, sony ericsson vi </a></li>
            <li><a href="#">Think Unstuck </a></li>
            <li><a href="#">sony ericsson spiro review, sony ericsson sp </a></li>
            <li><a href="#">samsung e2550 monte, samsung e2550 review, s </a></li>
            <li><a href="#">samsung c3300, samsung c3300 review, samsung </a></li>
        </ul>-->
    </div>
    <!-- footer-columns ends -->
</div>	

<div id="footer-bottom">		
    <p>© <?php echo date('Y')?> AutoTvToSab.</p>
</div>	

<!-- footer ends-->
</div>

