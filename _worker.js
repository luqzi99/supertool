export default {
    async fetch(request, env) {
        const url = new URL(request.url);

        if (url.pathname === '/functions/ping') {
            return handlePing(url);
        }

        return env.ASSETS.fetch(request);
    },
};

async function handlePing(url) {
    const target = url.searchParams.get('url');
    const headers = {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*',
    };

    if (!target) {
        return new Response(JSON.stringify({ ok: false, error: 'Missing url parameter' }), { status: 400, headers });
    }

    let parsed;
    try {
        parsed = new URL(target);
    } catch {
        return new Response(JSON.stringify({ ok: false, error: 'Invalid URL format' }), { status: 400, headers });
    }

    if (!['http:', 'https:'].includes(parsed.protocol)) {
        return new Response(JSON.stringify({ ok: false, error: 'Only http and https URLs are supported' }), { status: 400, headers });
    }

    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 10000);
    const start = Date.now();

    try {
        const response = await fetch(target, {
            method: 'HEAD',
            redirect: 'follow',
            signal: controller.signal,
        });
        clearTimeout(timeoutId);

        return new Response(JSON.stringify({
            ok: true,
            status: response.status,
            statusText: response.statusText,
            duration_ms: Date.now() - start,
            url: target,
        }), { headers });
    } catch (e) {
        clearTimeout(timeoutId);
        return new Response(JSON.stringify({
            ok: false,
            error: e.name === 'AbortError' ? 'Request timed out after 10 seconds' : e.message,
            url: target,
        }), { headers });
    }
}
