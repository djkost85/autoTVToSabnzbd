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
        '/^(?P<name>.+)[ \._\-](?P<season>[0-9]{2})(?P<episode>[0-9]{2})[\._ -][^\\/]*$/'
    );

    protected $name = "";

    function  __construct($name = "") {
        $this->name = trim($name);
    }

    function parse() {
        foreach ($this->patterns as $key => $pattern) {
            if (preg_match($pattern, $this->name, $matches)) {
//                echo $key . "\n";
//                echo $this->name . "\n";
//                var_dump($matches);
                return $matches;
            }
        }
    }


}

//$name = "Breaking Bad S03E06 HDTV XviD LOL";
//$name = "Breaking Bad S03E05 HDTV XviD FEVER";
//$name = "Breaking Bad S03E04 Green Light HDTV XviD FQM";
//$name = "Breaking Bad S0303 HDTV XviD FQM";
$name = "Breaking Bad 3x07 HDTV XviD FQM";
//$name = "Breaking Bad 0307 HDTV XviD FQM";
//$name = "Breaking Bad S03E02 Caballo Sin Nombre HDTV XviD FQM";

//$ren = new NameParser($name);
//$ren->parse();


function parseSeriesInfo($name) {
    $filenamePatterns = array(
            # [group] Show - 01-02 [Etc]
            '1: [group] Show - 01-02 [Etc]' => '/^\[.+?\][ ]?(?P<seriesname>.*?)[ ]?[-_][ ]?(?P<episodenumberstart>\d+)([-_]\d+)*[-_](?P<episodenumberend>\d+)[^\/]*$/',
            # [group] Show - 01 [Etc]
            '2: [group] Show - 01 [Etc]' => '/^\[.+?\][ ]?(?P<seriesname>.*)[ ]?[-_][ ]?(?P<episodenumber>\d+)[^\/]*$/',
            # foo s01e23 s01e24 s01e25 *
            '3: foo s01e23 s01e24 s01e25 *' => '/^((?P<seriesname>.+?)[ \._\-])?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee](?P<episodenumberstart>[0-9]+)([\.\- ]+[Ss](?P=seasonnumber)[\.\- ]?[Ee][0-9]+)*([\.\- ]+[Ss](?P=seasonnumber)[\.\- ]?[Ee](?P<episodenumberend>[0-9]+))[^\/]*$/',
            # foo.s01e23e24*
            '4: foo.s01e23e24*' => '/^((?P<seriesname>.+?)[ \._\-])?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee](?P<episodenumberstart>[0-9]+)([\.\- ]?[Ee][0-9]+)*[\.\- ]?[Ee](?P<episodenumberend>[0-9]+)[^\/]*$/',
            # foo.1x23 1x24 1x25
            '5: foo.1x23 1x24 1x25' => '/^((?P<seriesname>.+?)[ \._\-])?(?P<seasonnumber>[0-9]+)[xX](?P<episodenumberstart>[0-9]+)([ \._\-]+(?P=seasonnumber)[xX][0-9]+)*([ \._\-]+(?P=seasonnumber)[xX](?P<episodenumberend>[0-9]+))[^\/]*$/',
            # foo.1x23x24*
            '6: foo.1x23x24*' => '/^((?P<seriesname>.+?)[ \._\-])?(?P<seasonnumber>[0-9]+)[xX](?P<episodenumberstart>[0-9]+)([xX][0-9]+)*[xX](?P<episodenumberend>[0-9]+)[^\/]*$/',
            # foo.s01e23-24*
            '7: foo.s01e23-24*' => '/^((?P<seriesname>.+?)[ \._\-])?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee](?P<episodenumberstart>[0-9]+)([\-][Ee]?[0-9]+ )*[\-](?P<episodenumberend>[0-9]+)[\.\- ][^\/]*$/',
            # foo.1x23-24*
            '8: foo.1x23-24*' => '/^((?P<seriesname>.+?)[ \._\-])?(?P<seasonnumber>[0-9]+)[xX](?P<episodenumberstart>[0-9]+)([\-][0-9]+)*[\-](?P<episodenumberend>[0-9]+)([\.\- ].*|$)/',
            # foo.[1x09-11]*
            '9: foo.[1x09-11]*' => '/^(?P<seriesname>.+?)[ \._\-]\[?(?P<seasonnumber>[0-9]+)[xX](?P<episodenumberstart>[0-9]+)(- [0-9]+)*-(?P<episodenumberend>[0-9]+)\][^\\/]*$/',
            # foo.s0101, foo.0201
            '10: foo.s0101, foo.0201' => '/^(?P<seriesname>.+?)[ \._\-][Ss](?P<seasonnumber>[0-9]{2})[\.\- ]?(?P<episodenumber>[0-9]{2})[^0-9]*$/',
            //'10.1: [group] foo.s0101, foo.0201' => '/^[\[.+?1-9\]][\s]?(?P<seriesname>.+?)[ \._\-][Ss](?P<seasonnumber>[0-9]{2})[\.\- Ee]?(?P<episodenumber>[0-9]{2})/',
            '10.1: [group] foo.s0101, foo.0201' => '/^[\[a-zA-Z1-9\-\#<>\.\@\]]+[\s]?(?P<seriesname>.+?)[ \._\-][Ss](?P<seasonnumber>[0-9]{2})[\.\- Ee]?(?P<episodenumber>[0-9]{2})/',
            # foo.1x09*
            '11: foo.1x09*' => '/^((?P<seriesname>.+?)[ \._\-])?\[?(?P<seasonnumber>[0-9]+)[xX](?P<episodenumber>[0-9]+) \]?[^\\/]*$/',
            # foo.s01.e01, foo.s01_e01
            //'12: foo.s01.e01, foo.s01_e01' => '/^((?P<seriesname>.+?)[ \._\-])?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee]?(?P<episodenumber>[0-9]+)[^\\/]*$/',
            '12.1: [group] foo.s01.e01, foo.s01_e01' => '/^[\[.+?<>\]]+[\s]?((?P<seriesname>.+?)[ \._\-])?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee]?(?P<episodenumber>[0-9]+)[^\\/]*$/',
            # foo.2010.01.02.etc
            '13: foo.2010.01.02.etc' => '/^((?P<seriesname>.+?)[ \._\-])?(?P<year>\d{4})[ \._\-](?P<month>\d{2})[ \._\-](?P<day>\d{2})[^\/]*$/',
            # Foo - S2 E 02 - etc
            '14: Foo - S2 E 02 - etc' => '/^(?P<seriesname>.+?)[ ]?[ \._\-][ ]?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee]?[ ]?(?P<episodenumber>[0-9]+)[^\\/]*$/',
            # Show - Episode 9999 [S 12 - Ep 131] - etc
            '15: Show - Episode 9999 [S 12 - Ep 131] - etc' => '/(?P<seriesname>.+)[ ]-[ ][Ee]pisode[ ]\d+[ ]\[[sS][ ]?(?P<seasonnumber>\d+)([ ]|[ ]-[ ]|-)([eE]|[eE]p)[ ]?(?P<episodenumber>\d+)\].*$/',
            # foo.103*
            '16: foo.103*' => '/^(?P<seriesname>.+)[ \._\-](?P<seasonnumber>[0-9]{1})(?P<episodenumber>[0-9]{2})[\._ -][^\\/]*$/',
            # foo.0103*
            '17: foo.0103*' => '/^(?P<seriesname>.+)[ \._\-](?P<seasonnumber>[0-9]{2})(?P<episodenumber>[0-9]{2,3})[\._ -][^\\/]*$/',
            # show.name.e123.abc
            '18: show.name.e123.abc' => '/^(?P<seriesname>.+?)[ \._\-][Ee](?P<episodenumber>[0-9]+)[\._ -][^\\/]*$/',
        '19: <UHQ>< foo.s01e01' => '/<[A-Za-z]+><\s*((?P<seriesname>.+?)[ \._\-])?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee]?(?P<episodenumber>[0-9]+)[^\\/]*\s(.+?)/',
        //'19: <UHQ>< foo.s01e01' => '/[A-Za-z\<\>\-\[\]]+[^\s]((?P<seriesname>.+?)[ \._\-])?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee]?(?P<episodenumber>[0-9]+)[^\\/]*\s(.+?)/',
        //'20: <UHQ>< foo.s01e01' => '/[^\]>]\s*((?P<seriesname>.+?)[ \._\-])?[Ss](?P<seasonnumber>[0-9]+)[\.\- ]?[Ee]?(?P<episodenumber>[0-9]+)[^\\/]*\s(.+?)/'
    );

//    $filenamePatterns = array_reverse($filenamePatterns);
    foreach ($filenamePatterns as $key => $pattern) {
        if (preg_match($pattern, trim($name), $matches)) {
//            echo $key . "\n";
//            var_dump($matches);
            return $matches;
        }
    }

//    if (preg_match('/^((?P<seriesname>.+?)[ \._\-])?
//        [Ss](?P<seasonnumber>[0-9]+)[\.\- ]?
//        [Ee]?(?P<episodenumber>[0-9]+)
//        [^\\/]*$/', $name, $matches))
//            var_dump($matches);
}

?>
