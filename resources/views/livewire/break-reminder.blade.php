
<div>
    @if ($showReminder)
        <div class="fixed inset-0 bg-blue-100 bg-opacity-90 flex items-center justify-center z-50">
            <div class="p-6 bg-white rounded shadow-lg text-center">
                <img src="/images/reminder.gif" alt="Break Time!" class="w-32 mx-auto mb-4" />
                <h2 class="text-2xl font-bold mb-4">⏰ Time for a Break!</h2>
                <p>Let's relax for a moment before continuing.</p>
                <button wire:click="dismissReminder" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Got it!</button>
            </div>
        </div>
    @endif
</div>
@script
<script>
    console.log('Break Timer Script Loaded');

    window.addEventListener('start-break-timer', () => {
        console.log('Break Timer Script Loaded');

        const breakInterval = 20 * 60 * 1000; // 20 minutes (use 15 * 1000 for testing)
        const startTimeKey = 'breakTimerStartTime';

        // Initialize Timer Start Time if not set
        if (!localStorage.getItem(startTimeKey)) {
            localStorage.setItem(startTimeKey, Date.now());
        }

        function startBreakTimer() {
            const startTime = parseInt(localStorage.getItem(startTimeKey));
            const now = Date.now();
            const elapsedTime = now - startTime;
            const timeLeft = breakInterval - elapsedTime;

            console.log('⏱️ Start Time:', startTime);
            console.log('⏳ Elapsed Time:', elapsedTime);
            console.log('⏳ Time Left:', timeLeft);

            if (timeLeft <= 0) {
                console.log('✅ Triggering Break Reminder!');
                triggerReminder();
                // Reset the timer after reminder is triggered
                localStorage.setItem(startTimeKey, Date.now());
                setTimeout(startBreakTimer, breakInterval); // Schedule the next reminder
            } else {
                // Check again when time left reaches zero
                setTimeout(startBreakTimer, timeLeft);
            }
        }

        // User interactions only logged, no timer reset unless timeLeft <= 0
        ['click', 'keydown'].forEach(eventType => {
            document.addEventListener(eventType, () => {
                console.log('User Interaction Detected. Timer Continues.');
            });
        });

        // Start the Timer
        startBreakTimer();
    });

    function triggerReminder() {
        console.log('Reminder Triggered!');
        $wire.set('showReminder', true);
        try {
            new Audio('/sounds/reminder.mp3').play();
        } catch (e) {
            console.warn('Audio play failed:', e);
        }
    }
</script>
@endscript

