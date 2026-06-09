<?php

namespace App\Tools\MolpaySkey;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MolpaySkeyController
{
    public function __construct(
        private MolpaySkeyService $service
    ) {}

    public function show(): View
    {
        return view('tools.molpay-skey');
    }

    public function generate(Request $request): View
    {
        $validated = $request->validate([
            'operator'        => ['required', 'string', 'max:255'],
            'bank_code'       => ['required', 'string', 'max:50'],
            'bank_acc_number' => ['required', 'string', 'max:50'],
            'currency'        => ['required', 'string', 'size:3'],
            'priv_vkey'       => ['required', 'string', 'max:255'],
        ]);

        $skey = $this->service->generate(
            $validated['operator'],
            $validated['bank_code'],
            $validated['bank_acc_number'],
            $validated['currency'],
            $validated['priv_vkey'],
        );

        return view('tools.molpay-skey', [
            'skey'   => $skey,
            'inputs' => $validated,
        ]);
    }
}
