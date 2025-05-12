
import pusherJs from 'pusher-js'
import Cookies from "js-cookie";
import Echo from 'laravel-echo';

window.Pusher = pusherJs;
// window.Pusher.logToConsole = true;

let host = location.origin;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    auth:{
    headers:{
        Authorization: `Bearer ${Cookies.get("token")}`
    }
    },
    authorizer: (channel, options) => {
            return {
                authorize: (socketId, callback) => {
                    axios
                        .post(
                            host+'/broadcasting/auth',
                            {
                                socket_id: socketId,
                                channel_name: channel.name,
                            },
                            {
                                headers:{
                                    'Content-Type': 'application/json',
                                    Authorization: `Bearer ${Cookies.get("token")}` ,
                                    'Access-Control-Allow-Credentials': true,
                                }
                                , withCredentials: true
                            }
                        )
                        .then((response) => {
                            callback(false, response.data);
                        })
                        .catch((error) => {
                            callback(true, error);
                        });
                },
            };
        },
});


