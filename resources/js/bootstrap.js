import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// Realtime messaging is currently disabled.
// Keep this Echo/Pusher setup commented out so it can be restored later without
// crashing pages when VITE_PUSHER_* keys are not configured in the deployed app.
//
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';
//
// window.Pusher = Pusher;
//
// window.Echo = new Echo({
// 	broadcaster: 'pusher',
// 	key: import.meta.env.VITE_PUSHER_APP_KEY,
// 	cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
// 	wsHost: import.meta.env.VITE_PUSHER_HOST || window.location.hostname,
// 	wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
// 	wssPort: import.meta.env.VITE_PUSHER_PORT || 6001,
// 	forceTLS: import.meta.env.VITE_PUSHER_SCHEME === 'https',
// 	encrypted: import.meta.env.VITE_PUSHER_SCHEME === 'https',
// 	disableStats: true,
// 	enabledTransports: ['ws', 'wss'],
// });
