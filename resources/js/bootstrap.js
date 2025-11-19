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

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'd4daed8661bd01be9205',
    cluster: 'eu',
    forceTLS: true,

});




window.Echo.connector.pusher.connection.bind('error', (error) => {
    console.error('Pusher connection error:', error);
});

window.Echo.channel('real-time-notifications')
    .listen('.RealTimeNotificationEvent', (event) => {
        console.log('Received event:', event);
        const notificationCount = event.content.notificationCount;
        console.log("Case:", notificationCount);
        updateNotificationCount(notificationCount);
    })
    .listen('pusher:subscription_succeeded', (event) => {
        console.log('Pusher subscription succeeded:', event);
    })
    .listen('pusher:subscription_error', (event) => {
        console.error('Pusher subscription error:', event);
    });

   function updateNotificationCount(count) {
        // Mettez à jour le compteur de notifications dans votre UI
        console.log(count);
        const notificationCounter = document.getElementById('notification-counter');
        if (notificationCounter) {
            notificationCounter.innerText = count;
        }
    }
