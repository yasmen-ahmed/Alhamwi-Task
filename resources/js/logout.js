window.addEventListener('beforeunload', function (event) {
    event.preventDefault();

    // Perform an AJAX request to log out the user
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/logout', false);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.send();
});

// Make sure to also log the user out on the server when the page is unloaded
window.addEventListener('unload', function () {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/logout', false);
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.send();
});
