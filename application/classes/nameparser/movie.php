<?php

class NameParser_Movie extends NameParser {

    protected $_movieRegexp = "#^(?P<name>.+)[\.\s]+(?P<year>\d{4})[\.\s]+(?P<additionalText>.*)#";


    public function parse() {
        if (preg_match($this->_movieRegexp, $this->name, $matches)) {
            return $matches;
        }

        return null;
    }
}

?>
