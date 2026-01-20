<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supertool - Simple Utility Platform</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            text-align: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        header h1 {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        .content {
            padding: 40px 20px;
            text-align: center;
        }
        .content h2 {
            margin-bottom: 20px;
            color: #667eea;
        }
        .cta {
            display: inline-block;
            margin-top: 30px;
            padding: 15px 40px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background 0.3s;
        }
        .cta:hover {
            background: #764ba2;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }
        .feature {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .feature h3 {
            margin-bottom: 10px;
            color: #667eea;
        }
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            color: #666;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1>Supertool</h1>
        <p>A modular, lightweight utility platform</p>
    </header>

    <div class="container">
        <div class="content">
            <h2>Solve Small Problems with Simple Tools</h2>
            <p>No database. No tracking. Just clean, focused utilities that do one thing well.</p>

            <a href="{{ route('tools.index') }}" class="cta">Browse Tools</a>

            <div class="features">
                <div class="feature">
                    <h3>🚀 Simple</h3>
                    <p>Each tool solves one problem with minimal inputs and instant results.</p>
                </div>
                <div class="feature">
                    <h3>🔒 Private</h3>
                    <p>No data storage, no tracking, no analytics. Your data stays yours.</p>
                </div>
                <div class="feature">
                    <h3>⚡ Fast</h3>
                    <p>Stateless and lightweight. Get your result and move on.</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>Supertool - Built with Laravel</p>
    </footer>
</body>
</html>
