<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold text-gray-700">Recent Sessions</h2>
    @foreach ($recentSessions as $session)
        <div>
            <hr class="my-2">
            <p>Game: {{ $session->game->title }}</p>
            <p>Score: {{ $session->score }}</p>
            <p>Accuracy: {{ $session->accuracy }}%</p>
        </div>
    @endforeach
</div>
