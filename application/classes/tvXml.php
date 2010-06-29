<?php defined('SYSPATH') or die('No direct script access.');

class TvXml extends DomDocument
{
    /**
     * @ the Tv series
     */
    private $tvSeries;

    /**
     *
     * @Constructor, duh! Set up the DOM environment
     *
     * @access public
     *
     * @param string $user The site title
     * @param string $link The link to the site
     * @param string $description The site description
     *
     */
    public function __construct($user = "", $link = "", $description = "")
    {
        parent::__construct();

        /*** format the created XML ***/
        $this->formatOutput = true;

        /*** craete the root element ***/
        $root = $this->appendChild($this->createElement('root'));


        $this->tvSeries = $root->appendChild($this->createElement('tvseries'));

        $this->tvSeries->appendChild($this->createElement('user', $user));
        $this->tvSeries->appendChild($this->createElement('link', $link));
        $this->tvSeries->appendChild($this->createElement('description', $description));
    }


    /**
     *
     * @Add Items to the XML
     *
     * @access public
     *
     * @param array $items
     *
     * @return object Instance of self for method chaining
     *
     */
    public function addItem($items)
    {
        /*** create an item ***/
        $item = $this->createElement('item');
        foreach($items as $element => $value)
        {
            switch($element)
            {
                /*** create sub elements here ***/
                case 'Next Episode':
                case 'Latest Episode':
                    $element = str_replace(" ", '_', $element);
                    $im = $this->createElement($element);
                    //$this->tvSeries->appendChild($im);
                    $item->appendChild($im);
                    foreach( $value as $subElement => $subValue )
                    {
                        $sub = $this->createElement($subElement, $subValue);
                        $im->appendChild( $sub );
                    }
                    break;

                case 'episodelist':
                    //$new = $item->appendChild($this->createElement($element, serialize($value)));
                    $new = $item->appendChild($this->createElement($element));
                    $i = 1;
                    foreach ($value as $ep) {
                        $season = $new->appendChild($this->createElement('season'));
                        $attr = $season->appendChild($this->createAttribute('num'));
                        $attr->appendChild($this->createTextNode(($i < 10) ? "0$i" : $i));
                        foreach ($ep as $info) {
                            $episode = $season->appendChild($this->createElement('episode'));
                            
                            $epAttri = $episode->appendChild($this->createAttribute('num'));
                            $epAttri->appendChild($this->createTextNode($info['num']));

                            $episode->appendChild($this->createElement('aired', $info['aired']));
                            $episode->appendChild($this->createElement('title', $info['title']));
                        }
                        $i++;
                    }
                    break;
                default:
                    $new = $item->appendChild($this->createElement($element, $value));
                break;
            }
        }
        /*** append the item to the channel ***/
        $this->tvSeries->appendChild($item);

        /*** allow chaining ***/
        return $this;
    }

    /***
     *
     * @create the XML
     *
     * @access public
     *
     * @return string The XML string
     *
     */
    public function __toString()
    {
        return $this->saveXML();
    }
}
?>
