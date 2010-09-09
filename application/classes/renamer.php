<?php

class Renamer {

    protected $_movieExt = array('*.mkv', '*.wmv', '*.avi', '*.mpg', '*.mpeg', '*.mp4', '*.m2ts', '*.iso');
    protected $_nfoExt = array('*.nfo');
    protected $_videoCodecs = array('x264', 'DivX', 'XViD');
    protected $_subExt = array('*.sub', '*.srt', '*.idx', '*.ssa', '*.ass');

    protected $_minimalFileSize = 31457280; # 1024 * 1024 * 30 = 30MB

}

?>
