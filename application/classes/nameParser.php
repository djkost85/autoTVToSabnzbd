<?php defined('SYSPATH') or die('No direct script access.');

class NameParser {

    protected $patterns = array(
        # foo.s0101, foo.0201
        '/^(?P<name>.+?)[ \._\-][Ss](?P<season>[0-9]{2})[\.\- ]?(?P<episode>[0-9]{2})[^0-9]*$/',
        # foo.1x09*
        '/^((?P<name>.+?)[ \._\-])?\[?(?P<season>[0-9]+)[xX](?P<episode>[0-9]+) \]?[^\\/]*$/',
        # foo.s01.e01, foo.s01_e01
        '/^((?P<name>.+?)[ \._\-])?[Ss](?P<season>[0-9]+)[\._\- ]?[Ee]?(?P<episode>[0-9]+)[^\\/]*$/',
        # Foo - S2 E 02 - etc
        '/^(?P<name>.+?)[ ]?[ \._\-][ ]?[Ss](?P<season>[0-9]+)[\._\- ]?[Ee]?[ ]?(?P<episode>[0-9]+)[^\\/]*$/',
        # foo.103*
        '/^(?P<name>.+)[ \._\-](?P<season>[0-9]{1})(?P<episode>[0-9]{2})[\._ -][^\\/]*$/',
        # foo.0103*
        '/^(?P<name>.+)[ \._\-](?P<season>[0-9]{2})(?P<episode>[0-9]{2})[\._ -][^\\/]*$/',
    );

    protected $name = "";

    public function  __construct($name) {
        $this->name = trim($name);
    }

    public function parse() {
        foreach ($this->patterns as $key => $pattern) {
            if (preg_match($pattern, $this->name, $matches)) {
                return $matches;
            }
        }

        return null;
    }


}

?>
