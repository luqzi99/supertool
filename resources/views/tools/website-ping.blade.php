<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Ping Checker - Supertool</title>
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
        input, button { width: 100%; padding: 10px; margin: 10px 0; font-size: 16px; }
        button { background: #667eea; color: white; border: none; cursor: pointer; border-radius: 5px; }
        button:hover { background: #5568d3; }
        .result { background: #f0fdf4; padding: 20px; margin: 20px 0; border-radius: 5px; border-left: 4px solid #22c55e; }
        .result-title { font-weight: bold; color: #166534; margin-bottom: 15px; display: flex; align-items: center; }
        .result-title svg { margin-right: 8px; }
        .result-row { display: flex; justify-content: space-between; margin: 8px 0; color: #166534; }
        .result-label { font-weight: 500; }
        .error { background: #fef2f2; padding: 15px; margin: 20px 0; border-radius: 5px; border-left: 4px solid #ef4444; color: #991b1b; }
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
            <h1>Website Ping Checker</h1>
            <p class="description">Check if a website is reachable and responding</p>

            <form method="POST" action="{{ route('tools.website-ping.check') }}">
                @csrf

                <label for="url">Website URL:</label>
                <input
                    type="url"
                    id="url"
                    name="url"
                    placeholder="https://example.com"
                    value="{{ old('url', $url ?? '') }}"
                    required
                    autofocus
                >

                @error('url')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit">Check Status</button>
            </form>

            @if(isset($result))
                <div class="result">
                    <div class="result-title">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Website is Online
                    </div>
                    <div class="result-row">
                        <span class="result-label">Status:</span>
                        <span style="text-transform: uppercase;">{{ $result['status'] }}</span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">HTTP Code:</span>
                        <span>{{ $result['http_code'] }}</span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">Response Time:</span>
                        <span>{{ $result['response_time_ms'] }} ms</span>
                    </div>
                </div>
            @endif

            @if(isset($error))
                <div class="error">{{ $error }}</div>
            @endif
        </div>
    </div>
</body>
</html>
