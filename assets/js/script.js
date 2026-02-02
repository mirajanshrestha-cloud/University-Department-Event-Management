document.addEventListener("DOMContentLoaded", () => {
    const searchBtn = document.getElementById("searchBtn");
    const searchKeyword = document.getElementById("searchKeyword");
    const filterCategory = document.getElementById("filterCategory");
    const eventGrid = document.getElementById("eventGrid");

    // Toggle event card actions
    function toggleActions(id) {
        const el = document.getElementById('actions-' + id);
        if(el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }

    // Fetch events via AJAX
    function loadEvents(keyword = '', category = '') {
        const formData = new FormData();
        formData.append('keyword', keyword);
        formData.append('category', category);

        fetch('ajax_count.php', { method: 'POST', body: formData })
            .then(res => res.text())
            .then(html => {
                eventGrid.innerHTML = html;

                // Attach toggle click handlers after content loads
                document.querySelectorAll(".event-card").forEach(card => {
                    const id = card.dataset.eventId;
                    card.onclick = () => toggleActions(id);
                });
            })
            .catch(err => console.error("Error loading events:", err));
    }

    // Initial load of all events
    loadEvents();

    // Search button click
    searchBtn.addEventListener("click", () => {
        const keyword = searchKeyword.value.trim();
        const category = filterCategory.value;
        loadEvents(keyword, category);
    });

    // Live search while typing
    searchKeyword.addEventListener("input", () => {
        const keyword = searchKeyword.value.trim();
        const category = filterCategory.value;
        loadEvents(keyword, category);
    });

    // Category filter change
    filterCategory.addEventListener("change", () => {
        const keyword = searchKeyword.value.trim();
        const category = filterCategory.value;
        loadEvents(keyword, category);
    });
});

function toggleActions(id) {
    const el = document.getElementById('actions-' + id);
    if(el) el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

// Load events from server
function loadEvents(keyword = '', category = '') {
    const formData = new FormData();
    formData.append('keyword', keyword);
    formData.append('category', category);

    fetch('ajax_count.php', { method: 'POST', body: formData })
        .then(res => res.text())
        .then(html => {
            document.getElementById('eventGrid').innerHTML = html;
        });
}

// Initial load
loadEvents();

// Search button click
document.getElementById('searchBtn').addEventListener('click', () => {
    const keyword = document.getElementById('searchKeyword').value.trim();
    const category = document.getElementById('filterCategory').value;
    loadEvents(keyword, category);
});

// Live search while typing
document.getElementById('searchKeyword').addEventListener('input', () => {
    const keyword = document.getElementById('searchKeyword').value.trim();
    const category = document.getElementById('filterCategory').value;
    loadEvents(keyword, category);
});