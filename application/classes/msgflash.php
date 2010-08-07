<?php

class MsgFlash {
    
    protected static $_name = 'msgFlash';

    public static function set($value) {
        Session::instance()->set(self::$_name, $value);
    }

    public static function has() {
        return !is_null(Session::instance()->get(self::$_name, null));
    }

    public static function get() {
        $sess = Session::instance();
        $falsh =  $sess->get(self::$_name);
        $sess->delete(self::$_name);
        return $falsh;
    }
}

?>
