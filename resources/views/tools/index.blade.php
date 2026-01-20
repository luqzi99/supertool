<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tools - Supertool</title>
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        h1 {
            margin-bottom: 30px;
            color: #333;
        }
        .tools-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .tool-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .tool-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .tool-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .tool-name {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #667eea;
        }
        .tool-description {
            color: #666;
            font-size: 0.95rem;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="{{ url('/') }}" class="logo">Supertool</a>
            <nav>
                <a href="{{ route('tools.index') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">Tools</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <h1>Available Tools</h1>

        @if(count($tools) > 0)
            <div class="tools-grid">
                @foreach($tools as $tool)
                    <a href="{{ route($tool['route']) }}" class="tool-card">
                        <div class="tool-icon">{{ $tool['icon'] }}</div>
                        <div class="tool-name">{{ $tool['name'] }}</div>
                        <div class="tool-description">{{ $tool['description'] }}</div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <p>No tools available yet.</p>
            </div>
        @endif
    </div>
</body>
</html>
