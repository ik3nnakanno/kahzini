let internetCheckTimer; // define a variable to store the timer ID

function checkInternetConnection() {
    return fetch('https://www.google.com', { mode: 'no-cors' })
        .then(() => true)
        .catch(() => false);
}

function handleInternetConnectivity() {
    if (navigator.onLine) {
        console.log("Browser is online");
        clearTimeout(internetCheckTimer); // clear the timer if the browser is online
    } else {
        console.log("Browser is offline");
        internetCheckTimer = setTimeout(() => {
            alert("You are disconnected from the internet!");
        }, 5000); // set a timer for 5 seconds
    }
}

// call the handleInternetConnectivity function whenever the browser connectivity changes
window.addEventListener('online', handleInternetConnectivity);
window.addEventListener('offline', handleInternetConnectivity);