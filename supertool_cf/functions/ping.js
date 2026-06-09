export async function onRequest(context) {
    const url = new URL(context.request.url);
    const target = url.searchParams.get('url');

    const headers = {
        'Content-Type': 'application/json',
        'Access-Control-Allow-Origin': '*',
    };

    if (!target) {
        return new Response(JSON.stringify({ ok: false, error: 'Missing url parameter' }), { status: 400, headers });
    }

    let parsedUrl;
    try {
        parsedUrl = new URL(target);
    } catch {
        return new Response(JSON.stringify({ ok: false, error: 'Invalid URL format' }), { status: 400, headers });
    }

    if (!['http:', 'https:'].includes(parsedUrl.protocol)) {
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
        const duration_ms = Date.now() - start;

        return new Response(JSON.stringify({
            ok: true,
            status: response.status,
            statusText: response.statusText,
            duration_ms,
            url: target,
        }), { headers });
    } catch (e) {
        clearTimeout(timeoutId);
        const reason = e.name === 'AbortError' ? 'Request timed out after 10 seconds' : e.message;
        return new Response(JSON.stringify({
            ok: false,
            error: reason,
            url: target,
        }), { headers });
    }
}
