
<?php

class Sequrity {

    function xss_filter($val) {
        $val = htmlentities($val);
        $val = strip_tags($val);
        $val = filter_var($val, FILTER_SANITIZE_STRING);
        return $val;
    }

}

?>
