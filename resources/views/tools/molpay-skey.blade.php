<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOLPay Skey Generator - Supertool</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }
        header {
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
            text-decoration: none;
        }
        nav a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }
        .tool-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 { margin-bottom: 10px; color: #333; }
        .description { color: #666; margin-bottom: 30px; }
        label { font-weight: bold; display: block; margin-top: 15px; margin-bottom: 4px; }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            font-size: 16px;
            background: #667eea;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover { background: #5568d3; }
        .result {
            background: #f0f0f0;
            padding: 15px;
            margin-top: 25px;
            border-radius: 5px;
            word-break: break-all;
        }
        .result strong { display: block; margin-bottom: 8px; }
        .skey-value {
            font-family: monospace;
            font-size: 1rem;
            color: #1a1a1a;
        }
        .copy-btn {
            margin-top: 10px;
            background: #10b981;
        }
        .copy-btn:hover { background: #059669; }
        .error { color: red; margin: 8px 0; background: #fee; padding: 10px; border-radius: 5px; }
        .formula-box {
            background: #f8f8ff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px 15px;
            margin-bottom: 25px;
            font-family: monospace;
            font-size: 0.85rem;
            color: #444;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="{{ url('/') }}" class="logo">Supertool</a>
            <nav>
                <a href="{{ route('tools.index') }}">Tools</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="tool-card">
            <h1>MOLPay Skey Generator</h1>
            <p class="description">Generate the MOLPay security key (skey) used for payout verification.</p>

            <div class="formula-box">
                skey = md5(operator + Bank_Code + Bank_AccNumber + currency + sha1(priv_vkey))
            </div>

            <form method="POST" action="{{ route('tools.molpay-skey.generate') }}">
                @csrf

                <label for="operator">Operator</label>
                <input
                    type="text"
                    id="operator"
                    name="operator"
                    value="{{ old('operator', $inputs['operator'] ?? '') }}"
                    placeholder="e.g. merchant_id"
                    required
                >
                @error('operator') <div class="error">{{ $message }}</div> @enderror

                <label for="bank_code">Bank Code</label>
                <input
                    type="text"
                    id="bank_code"
                    name="bank_code"
                    value="{{ old('bank_code', $inputs['bank_code'] ?? '') }}"
                    placeholder="e.g. MBBEMYKL"
                    required
                >
                @error('bank_code') <div class="error">{{ $message }}</div> @enderror

                <label for="bank_acc_number">Bank Account Number</label>
                <input
                    type="text"
                    id="bank_acc_number"
                    name="bank_acc_number"
                    value="{{ old('bank_acc_number', $inputs['bank_acc_number'] ?? '') }}"
                    placeholder="e.g. 1234567890"
                    required
                >
                @error('bank_acc_number') <div class="error">{{ $message }}</div> @enderror

                <label for="currency">Currency</label>
                <input
                    type="text"
                    id="currency"
                    name="currency"
                    value="{{ old('currency', $inputs['currency'] ?? '') }}"
                    placeholder="e.g. MYR"
                    maxlength="3"
                    required
                >
                @error('currency') <div class="error">{{ $message }}</div> @enderror

                <label for="priv_vkey">Private Verification Key (priv_vkey)</label>
                <input
                    type="password"
                    id="priv_vkey"
                    name="priv_vkey"
                    value="{{ old('priv_vkey', $inputs['priv_vkey'] ?? '') }}"
                    placeholder="Your MOLPay private verification key"
                    required
                >
                @error('priv_vkey') <div class="error">{{ $message }}</div> @enderror

                <button type="submit">Generate Skey</button>
            </form>

            @if(isset($skey))
                <div class="result">
                    <strong>Generated Skey:</strong>
                    <div id="skeyValue" class="skey-value">{{ $skey }}</div>
                    <button class="copy-btn" onclick="copyToClipboard()">Copy to Clipboard</button>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const text = document.getElementById('skeyValue').textContent;
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard!');
            });
        }
    </script>
</body>
</html>
