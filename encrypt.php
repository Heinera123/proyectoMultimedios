<?php
class encrypt {
    public function __construct(){}
    public static function encryptar($text){
        return hash('ripemd160', $text);
    }
}
?>