<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Movie_Rss extends Controller {

    public function action_index() {
        $config = Kohana::config('movie.rss');
        $info = array(
            'title' => 'AutoTvToSab Movie RSS Feed',
            'link' => URL::base(true, true),
            'description' => sprintf('AutoTvToSab shows the %d last aired episodes', $config['numberOfResults']),
        );

        $items = array();
//        foreach (ORM::factory('rss')->find_all() as $rss) {
//            $item = array();
//            $item['title'] = $rss->title;
//            $item['link'] = htmlspecialchars($rss->link);
//            $item['guid'] = htmlspecialchars($rss->guid);
//            $item['description'] = $rss->description;
//            $item['pubDate'] = $rss->pubDate;
//            $item['category'] = $rss->category;
//            $item['enclosure'] = unserialize($rss->enclosure);
//
//            $items[] = $item;
//        }

        $this->request->headers['Content-Type'] = 'application/xml; charset=UTF-8';
        $this->request->response = Rss::create($info, $items)->__toString();
    }
}
?>
