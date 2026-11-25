<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Playbook — SiagaNusa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col">
    <header class="border-b border-slate-800 bg-slate-900/70 backdrop-blur">
        <div class="max-w-5xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-xl font-bold tracking-tight text-emerald-400">SiagaNusa</a>
            <nav class="flex gap-6 text-sm font-medium">
                <a href="/" class="text-slate-300 hover:text-emerald-400 transition">Beranda</a>
                <a href="/docs" class="text-slate-300 hover:text-emerald-400 transition">Docs API</a>
                <a href="/playbook" class="text-white">Playbook</a>
            </nav>
        </div>
    </header>

    <main class="flex-1 max-w-5xl mx-auto px-6 py-12 w-full space-y-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">API Playbook</h1>
            <p class="text-slate-400">Uji coba langsung endpoint SiagaNusa dari browser Anda.</p>
        </div>

        <div class="p-6 rounded-xl bg-slate-900 border border-slate-800 space-y-4">
            <label for="endpointSelect" class="block text-sm font-medium text-slate-300">Pilih Endpoint</label>
            <div class="flex flex-col sm:flex-row gap-3">
                <select id="endpointSelect" class="flex-1 rounded-lg bg-slate-950 border border-slate-700 px-4 py-2.5 text-sm text-white font-mono focus:outline-none focus:border-emerald-500">
                    <optgroup label="Kategori">
                        <option value="/api/bmkg">GET /api/bmkg</option>
                        <option value="/api/bmkg/realtime">GET /api/bmkg/realtime</option>
                        <option value="/api/bmkg/catalog">GET /api/bmkg/catalog</option>
                        <option value="/api/bmkg/sensors">GET /api/bmkg/sensors</option>
                        <option value="/api/bmkg/spatial">GET /api/bmkg/spatial</option>
                        <option value="/api/bmkg/events/mmi">GET /api/bmkg/events/mmi</option>
                    </optgroup>
                    <optgroup label="BMKG Feed Spesifik">
                        @foreach($feeds as $key => $feed)
                            <option value="/api/bmkg/{{ $key }}">GET /api/bmkg/{{ $key }} ({{ $feed['category'] }})</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Sipongi (Kebakaran &amp; Hotspot)">
                        <option value="/api/sipongi">GET /api/sipongi</option>
                        @foreach($sipongiFeeds as $key => $feed)
                            <option value="/api/sipongi/{{ $key }}">GET /api/sipongi/{{ $key }} ({{ $feed['category'] }})</option>
                        @endforeach
                    </optgroup>
                </select>
                <button id="sendBtn" type="button" class="px-6 py-2.5 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-semibold text-sm transition cursor-pointer">
                    Kirim Request
                </button>
            </div>
        </div>

        <div class="rounded-xl bg-slate-900 border border-slate-800 overflow-hidden">
            <div class="px-4 py-3 bg-slate-800/60 border-b border-slate-800 flex items-center justify-between text-xs">
                <span class="font-mono text-slate-300" id="requestUrl">Belum ada request</span>
                <div class="flex gap-4">
                    <span id="statusBadge" class="font-mono text-slate-400">Status: -</span>
                    <span id="latencyBadge" class="font-mono text-slate-400">Latency: -</span>
                </div>
            </div>
            <pre id="responseOutput" class="p-4 text-xs font-mono text-emerald-300 overflow-x-auto max-h-[520px] overflow-y-auto whitespace-pre-wrap">Klik "Kirim Request" untuk melihat respons JSON...</pre>
        </div>
    </main>

    <script>
        const select = document.getElementById('endpointSelect');
        const sendBtn = document.getElementById('sendBtn');
        const requestUrl = document.getElementById('requestUrl');
        const statusBadge = document.getElementById('statusBadge');
        const latencyBadge = document.getElementById('latencyBadge');
        const responseOutput = document.getElementById('responseOutput');

        sendBtn.addEventListener('click', async () => {
            const url = select.value;
            requestUrl.textContent = 'GET ' + url;
            statusBadge.textContent = 'Status: Loading...';
            latencyBadge.textContent = 'Latency: -';
            responseOutput.textContent = 'Mengambil data...';

            const start = performance.now();
            try {
                const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const elapsed = Math.round(performance.now() - start);
                statusBadge.textContent = `Status: ${res.status} ${res.statusText}`;
                latencyBadge.textContent = `Latency: ${elapsed} ms`;

                const text = await res.text();
                try {
                    const json = JSON.parse(text);
                    responseOutput.textContent = JSON.stringify(json, null, 2);
                } catch {
                    responseOutput.textContent = text;
                }
            } catch (err) {
                statusBadge.textContent = 'Status: Network Error';
                responseOutput.textContent = String(err);
            }
        });
    </script>
</body>
</html>
