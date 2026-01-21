<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Formatter & Validator - Supertool</title>
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
            max-width: 800px;
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
        textarea, button { width: 100%; padding: 10px; margin: 10px 0; font-size: 14px; }
        textarea {
            font-family: Consolas, Monaco, 'Courier New', monospace;
            resize: vertical;
            min-height: 200px;
        }
        button {
            background: #667eea;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
        }
        button:hover { background: #5568d3; }
        .result {
            background: #f8f9fa;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }
        .result pre {
            font-family: Consolas, Monaco, 'Courier New', monospace;
            font-size: 14px;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 10px 0;
            color: #333;
        }
        .error {
            color: #dc3545;
            margin: 10px 0;
            background: #fee;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #fcc;
        }
        label { font-weight: bold; display: block; margin-top: 10px; }
        .copy-btn {
            margin-top: 10px;
            background: #10b981;
        }
        .copy-btn:hover {
            background: #059669;
        }
        .success-icon {
            color: #10b981;
            font-size: 20px;
            margin-right: 5px;
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
            <h1>JSON Formatter & Validator</h1>
            <p class="description">Format messy JSON and validate JSON syntax with clear error messages</p>

            <form method="POST" action="{{ route('tools.json-formatter.process') }}">
                @csrf

                <label for="json_text">JSON Input:</label>
                <textarea
                    id="json_text"
                    name="json_text"
                    rows="12"
                    placeholder='Enter your JSON here... e.g. {"name":"John","age":30}'
                    required
                >{{ old('json_text', $json_text ?? '') }}</textarea>

                @if(isset($error))
                    <div class="error">
                        <strong>❌ Validation Error:</strong><br>
                        {{ $error }}
                    </div>
                @endif

                @error('json_text')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit">Format & Validate</button>
            </form>

            @if(isset($formatted))
                <div class="result">
                    <strong><span class="success-icon">✓</span>Valid JSON - Formatted:</strong>
                    <pre id="formattedJson">{{ $formatted }}</pre>
                    <button class="copy-btn" onclick="copyToClipboard()">Copy Formatted JSON</button>
                </div>
            @endif
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const text = document.getElementById('formattedJson').textContent;
            navigator.clipboard.writeText(text).then(() => {
                alert('Formatted JSON copied to clipboard!');
            });
        }
    </script>
</body>
</html>
