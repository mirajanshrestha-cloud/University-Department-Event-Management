function loadCount(eventId) {
    fetch("ajax_count.php?event_id=" + eventId)
        .then(res => res.text())
        .then(data => {
            document.getElementById("count-" + eventId).innerText = data;
        });
}
