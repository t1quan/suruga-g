<?php

namespace App\Models\FEnt;

abstract class FEntAbstract {

    public function __set($name, $value) {
        $fieldNm = strtolower($name[0]).substr($name, 1);
        for ($i = 0; $i < strlen($fieldNm); $i++) {
            if ($fieldNm[$i] == '_') {
                $fieldNm = substr($fieldNm, 0, $i).strtoupper($fieldNm[$i + 1]).substr($fieldNm, $i + 2);
            }
        }
        $this->$fieldNm = $value;
    }
}
