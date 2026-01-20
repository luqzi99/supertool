<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Link Generator - Supertool</title>
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
        input, textarea, button { width: 100%; padding: 10px; margin: 10px 0; font-size: 16px; }
        button { background: #25D366; color: white; border: none; cursor: pointer; border-radius: 5px; }
        button:hover { background: #128C7E; }
        .result { background: #f0f0f0; padding: 15px; margin: 20px 0; border-radius: 5px; }
        .result a { color: #25D366; word-break: break-all; }
        .error { color: red; margin: 10px 0; }
        label { font-weight: bold; display: block; margin-top: 10px; }
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
            <h1>WhatsApp Link Generator</h1>
            <p class="description">Generate a WhatsApp chat link without saving phone numbers</p>

    <form method="POST" action="{{ route('whatsapp-link.generate') }}">
        @csrf

        <label for="phone">Phone Number (with country code):</label>
        <input
            type="text"
            id="phone"
            name="phone"
            placeholder="e.g. 601234567890"
            value="{{ old('phone', $phone ?? '') }}"
            required
        >

        @error('phone')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="message">Message (optional):</label>
        <textarea
            id="message"
            name="message"
            rows="4"
            placeholder="Pre-filled message (optional)"
            maxlength="500"
        >{{ old('message', $message ?? '') }}</textarea>

        <button type="submit">Generate Link</button>
    </form>

            @if(isset($link))
                <div class="result">
                    <strong>Your WhatsApp Link:</strong><br>
                    <a href="{{ $link }}" target="_blank">{{ $link }}</a>
                    <br><br>
                    <button onclick="copyToClipboard('{{ $link }}')">Copy Link</button>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link copied to clipboard!');
            });
        }
    </script>
</body>
</html>
