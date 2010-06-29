<?php
/**
 *
 * A class to create RSS feeds using DOM
 *
 * @Author Kevin Waterson
 *
 * @copyright 2009
 *
 * @author Kevin Waterson
 *
 * @license BSD
 *
 */
class Rss extends DomDocument {

    /**
     * @ the RSS channel
     */
    private $channel;

    /**
     *
     * @Constructor, duh! Set up the DOM environment
     *
     * @access public
     *
     * @param string $title The site title
     *
     * @param string $link The link to the site
     *
     * @param string $description The site description
     *
     */
    public function __construct($title, $link, $description, $encoding = 'UTF-8') {
        /*         * * call the parent constructor ** */
        parent::__construct('1.0', $encoding);

        /*         * * format the created XML ** */
        $this->formatOutput = true;

        /*         * * craete the root element ** */
        $root = $this->appendChild($this->createElement('rss'));

        /*         * * set to rss2 ** */
        $root->setAttribute('version', '2.0');
        $root->setAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');

        /*         * * set the channel node * */
        $this->channel = $root->appendChild($this->createElement('channel'));

        /*         * * set the title link and description elements ** */
        $this->channel->appendChild($this->createElement('title', $title));
        $this->channel->appendChild($this->createElement('link', $link));

        $descriptionElement = $this->createElement('description');
        $descriptionElement->appendChild($this->createCDATASection($description));
        $this->channel->appendChild($descriptionElement);
        
        $this->channel->appendChild($this->createElement('generator', get_class($this)));
        $this->channel->appendChild($this->createElement('language', 'en'));
        $this->channel->appendChild($this->createElement('copyright', 'Copyright 2010 ' . get_class($this)));
        $this->channel->appendChild($this->createElement('pubDate', date(DATE_RSS)));

        $atom = $this->createElement('atom:link');
        $atom->setAttribute('href', 'http://dev/autoTvToSab/rss/index');
        $atom->setAttribute('rel', 'self');
        $atom->setAttribute('type', 'application/rss+xml');
        $this->channel->appendChild($atom);
    }

    public static function create($info, $items, $encoding = 'UTF-8') {
        $c = __CLASS__;
        $intance = new $c($info['title'], $info['link'], $info['description'], $encoding);

        foreach ($items as $item) {
            $intance->addItem($item);
        }
        return $intance;
    }

    /**
     *
     * @Add Items to the RSS Feed
     *
     * @access public
     *
     * @param array $items
     *
     * @return object Instance of self for method chaining
     *
     */
    public function addItem($items) {
        /*         * * create an item ** */
        $item = $this->createElement('item');
        foreach ($items as $element => $value) {
            switch ($element) {
                case 'title':
                case 'pubDate':
                case 'link':
                case 'guid':
                case 'category':
                    $new = $item->appendChild($this->createElement($element, $value));
                    break;

                case 'enclosure':
                    if (!is_array($value)) {
                        throw new RuntimeException('Rss enclosure attribute is not array');
                    }
                    $enc = $this->createElement($element);
                    foreach ($value as $attr => $attrVal) {
                        $enc->setAttribute($attr, $attrVal);
                    }
                    $new = $item->appendChild($enc);
                    break;

                case 'description':
                    $description = $this->createElement($element);
                    $description->appendChild($this->createCDATASection($value));
                    $new = $item->appendChild($description);
                    break;
            }
        }
        /*         * * append the item to the channel ** */
        $this->channel->appendChild($item);

        /*         * * allow chaining ** */
        return $this;
    }

    /*     * *
     *
     * @create the XML
     *
     * @access public
     *
     * @return string The XML string
     *
     */

    public function __toString() {
        return $this->saveXML();
    }

}
?>
