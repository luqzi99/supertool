<?php

namespace App\Tools\MolpaySkey;

class MolpaySkeyService
{
    public function generate(
        string $operator,
        string $bankCode,
        string $bankAccNumber,
        string $currency,
        string $privVkey
    ): string {
        return md5($operator . $bankCode . $bankAccNumber . $currency . sha1($privVkey));
    }
}
