<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comfort Index Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between gap-4">
        <h1 class="text-2xl sm:text-3xl font-bold">Comfort Index Dashboard</h1>
        <button id="refreshBtn"
                class="px-4 py-2 rounded-lg bg-black text-white text-sm hover:opacity-90">
            Refresh
        </button>
    </div>

    <p class="mt-2 text-sm text-gray-600">
        Ranked from <span class="font-semibold">Most Comfortable</span> to <span class="font-semibold">Least Comfortable</span>.
    </p>

    <div id="meta" class="mt-4 text-sm text-gray-600"></div>

    <!-- Mobile cards -->
    <div id="cards" class="mt-6 grid grid-cols-1 gap-4 sm:hidden"></div>

    <!-- Desktop table -->
    <div class="mt-6 hidden sm:block overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="text-left px-4 py-3">Rank</th>
                <th class="text-left px-4 py-3">City</th>
                <th class="text-left px-4 py-3">Weather</th>
                <th class="text-left px-4 py-3">Temp (°C)</th>
                <th class="text-left px-4 py-3">Comfort</th>
            </tr>
            </thead>
            <tbody id="tableBody" class="divide-y"></tbody>
        </table>
    </div>

    <div id="error" class="mt-6 hidden p-4 rounded-lg bg-red-50 text-red-700 text-sm"></div>
</div>

<script>
    async function loadDashboard() {
        const errorEl = document.getElementById('error');
        const metaEl = document.getElementById('meta');
        const cardsEl = document.getElementById('cards');
        const tbody = document.getElementById('tableBody');

        errorEl.classList.add('hidden');
        errorEl.textContent = '';
        metaEl.textContent = 'Loading...';
        cardsEl.innerHTML = '';
        tbody.innerHTML = '';

        try {
            const res = await fetch('/api/dashboard');
            if (!res.ok) throw new Error('Failed to fetch dashboard data');

            const payload = await res.json();
            metaEl.textContent = `Cities: ${payload.count} • Generated at: ${payload.generated_at}`;

            payload.data.forEach(row => {
                // Mobile card
                const card = document.createElement('div');
                card.className = 'bg-white rounded-xl shadow p-4';
                card.innerHTML = `
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm text-gray-500">Rank</div>
                            <div class="text-xl font-bold">#${row.rank}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Comfort</div>
                            <div class="text-xl font-bold">${row.comfort_index}</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="text-lg font-semibold">${row.city_name ?? row.city_id}</div>
                        <div class="text-sm text-gray-600 capitalize">${row.weather_description ?? '-'}</div>
                        <div class="mt-2 text-sm">
                            <span class="text-gray-500">Temp:</span>
                            <span class="font-medium">${row.temp_c ?? '-'} °C</span>
                        </div>
                    </div>
                `;
                cardsEl.appendChild(card);

                // Desktop row
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-3 font-semibold">#${row.rank}</td>
                    <td class="px-4 py-3">${row.city_name ?? row.city_id}</td>
                    <td class="px-4 py-3 capitalize">${row.weather_description ?? '-'}</td>
                    <td class="px-4 py-3">${row.temp_c ?? '-'}</td>
                    <td class="px-4 py-3 font-semibold">${row.comfort_index}</td>
                `;
                tbody.appendChild(tr);
            });
        } catch (e) {
            metaEl.textContent = '';
            errorEl.textContent = e.message || 'Unknown error';
            errorEl.classList.remove('hidden');
        }
    }

    document.getElementById('refreshBtn').addEventListener('click', loadDashboard);
    loadDashboard();
</script>
</body>
</html>
