<?php

namespace App\Util;

class Upload {

    private $arrFormatImages = [];

    public function __construct() {
        $this->arrFormatImages = array(
            "image/jpeg",
            "image/jpeg",
            "image/png"
        );
    }

    /*
     * Types: 
     * img  - Is image files, all array formats 'arrFormatImages' images are accepted
     * file - Is compressed files, all array formats 'arrFormatFiles' are accepted.
     */

    public
            function LoadFile($path, $type, $file, $renameFile = true) {
        $fl = $file['type'];
        $validFormat = false;
        if ($type == "img") {
            for ($i = 0; $i < count($this->arrFormatImages); $i++) {
                if ($fl == $this->arrFormatImages[$i]) {
                    $validFormat = true;
                }
            }
        }

        if ($validFormat) {
            $finalName = "";

            if ($renameFile) {
                $explode = explode(".", $file['name']);
                $finalName = md5(time()) . "." . $explode[(count($explode) - 1)];
            } else {
                $finalName = $file['name'];
            }

            if (move_uploaded_file($file['tmp_name'], $path . "/" . $finalName)) {
                return $finalName;
            } else {
                return "";
            }
        } else {
            echo "Format Invalid";
        }
    }

}

?>
