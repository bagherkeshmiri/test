import Echo from 'laravel-echo';
import './bootstrap';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

export function subscribeUser(userId, onMessage) {
    window.Echo.private(`App.Models.User.${userId}`)
        .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated',
            (e) => {
                if (onMessage) onMessage(e);
                console.log('Notification:', e);
            });
}
