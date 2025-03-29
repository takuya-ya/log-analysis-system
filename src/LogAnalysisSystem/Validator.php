<?php

namespace LogAnalysisSystem;

class Validator
{
    // numberだと文字列を含まないため、Numericを使用
    public function validateNumeric(string $input): bool
    {
        if (!ctype_digit($input)) {
            echo '数字で入力して下さい。' . PHP_EOL;
            return true;
        }
        return false;
    }


}
