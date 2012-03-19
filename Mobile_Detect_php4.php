<?php

/**
 * Mobile Detect for php4
 *
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version    SVN: $Id: Mobile_Detect.php 4 2011-05-26 08:04:20Z vic.stanciu@gmail.com $
 */

class Mobile_Detect {
    
    var $accept;
    var $userAgent;
    
    var $isMobile     = false;
    var $isApple      = null;
    var $isAndroid    = null;
    var $isBlackberry = null;
    var $isOpera      = null;
    var $isPalm       = null;
    var $isWindows    = null;
    var $isGeneric    = null;

    var $devices = array(
        "android"       => "android",
        "blackberry"    => "blackberry",
        "apple"         => "(iphone|ipod)",
        "opera"         => "opera mini",
        "palm"          => "(avantgo|blazer|elaine|hiptop|palm|plucker|xiino)",
        "windows"       => "windows ce; (iemobile|ppc|smartphone)",
        "generic"       => "(kindle|mobile|mmp|midp|o2|pda|pocket|psp|symbian|smartphone|treo|up.browser|up.link|vodafone|wap)"
    );


    function Mobile_Detect() {
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->accept    = $_SERVER['HTTP_ACCEPT'];

        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])|| isset($_SERVER['HTTP_PROFILE'])) {
            $this->isMobile = true;
        } elseif (strpos($this->accept,'text/vnd.wap.wml') > 0 || strpos($this->accept,'application/vnd.wap.xhtml+xml') > 0) {
            $this->isMobile = true;
        } else {
            foreach ($this->devices as $device => $regexp) {
                if ($this->isDevice($device)) {
                    $this->isMobile = true;
                }
            }
        }
    }

    /**
     * Returns true if any type of mobile device detected, including special ones
     * @return bool
     */
    function isMobile() {
        return $this->isMobile;
    }


    function isDevice($device) {
        $var    = "is" . ucfirst($device);
        $return = $this->$var === null ? (bool) preg_match("/" . $this->devices[$device] . "/i", $this->userAgent) : $this->$var;

        if ($device != 'generic' && $return == true) {
            $this->isGeneric = false;
        }

        return $return;
    }
}
