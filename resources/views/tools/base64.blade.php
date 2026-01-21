<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base64 Encoder/Decoder - Supertool</title>
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
        h1 {
            margin-bottom: 10px;
            color: #333;
        }
        .description {
            color: #666;
            margin-bottom: 30px;
        }
        textarea, button { width: 100%; padding: 10px; margin: 10px 0; font-size: 16px; }
        button { background: #667eea; color: white; border: none; cursor: pointer; border-radius: 5px; }
        button:hover { background: #5568d3; }
        .result { background: #f0f0f0; padding: 15px; margin: 20px 0; border-radius: 5px; word-break: break-all; }
        .error { color: red; margin: 10px 0; background: #fee; padding: 10px; border-radius: 5px; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        .mode-selector {
            margin: 20px 0;
            display: flex;
            gap: 30px;
        }
        .mode-selector label {
            display: inline-flex;
            align-items: center;
            font-weight: normal;
            cursor: pointer;
        }
        .mode-selector input[type="radio"] {
            width: auto;
            margin-right: 8px;
        }
        .copy-btn {
            margin-top: 10px;
            background: #10b981;
        }
        .copy-btn:hover {
            background: #059669;
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
            <h1>Base64 Encoder/Decoder</h1>
            <p class="description">Encode plain text to Base64 or decode Base64 strings back to plain text</p>

            <form method="POST" action="{{ route('tools.base64.process') }}">
                @csrf

                <div class="mode-selector">
                    <label>
                        <input
                            type="radio"
                            name="mode"
                            value="encode"
                            {{ old('mode', $mode ?? 'encode') === 'encode' ? 'checked' : '' }}
                        >
                        Encode
                    </label>
                    <label>
                        <input
                            type="radio"
                            name="mode"
                            value="decode"
                            {{ old('mode', $mode ?? 'encode') === 'decode' ? 'checked' : '' }}
                        >
                        Decode
                    </label>
                </div>

                <label for="text">Input Text:</label>
                <textarea
                    id="text"
                    name="text"
                    rows="6"
                    placeholder="Enter text to encode or Base64 string to decode..."
                    required
                >{{ old('text', $text ?? '') }}</textarea>

                @if(isset($error))
                    <div class="error">{{ $error }}</div>
                @endif

                @error('text')
                    <div class="error">{{ $message }}</div>
                @enderror

                @error('mode')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit">Convert</button>
            </form>

            @if(isset($result))
                <div class="result">
                    <strong>Result:</strong><br><br>
                    <div id="resultText">{{ $result }}</div>
                    <button class="copy-btn" onclick="copyToClipboard()">Copy to Clipboard</button>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const text = document.getElementById('resultText').textContent;
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard!');
            });
        }
    </script>
</body>
</html>
