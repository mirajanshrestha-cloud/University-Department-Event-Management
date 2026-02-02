<?php
require '../config/db.php';
require '../includes/functions.php';
auth_required();
require '../includes/header.php';
?>

<main>
    <div class="page-container">

        <!-- Page Title -->
        <div class="topic">
            <h2>Event Schedule</h2>
        </div>

        <!-- Search Filter -->
        <div class="search-filter">
            <input type="text" id="searchKeyword" placeholder="Search events">
            <select id="filterCategory">
                <option value="">All Categories</option>
                <?php
                $categories = $pdo->query("SELECT DISTINCT category FROM events")->fetchAll(PDO::FETCH_COLUMN);
                foreach ($categories as $cat) {
                    echo "<option value='" . htmlspecialchars($cat) . "'>" . htmlspecialchars($cat) . "</option>";
                }
                ?>
            </select>
            <button id="searchBtn">Search</button>
        </div>

        <!-- Event Grid -->
        <div id="eventGrid" class="event-grid">
            <!-- Initial events will load here -->
        </div>

    </div>
</main>

<?php require '../includes/footer.php'; ?>
<style>
    .page-container {
        padding-bottom: 225px; 
        margin-bottom: 200px;
    }
</style>
<!-- AJAX & JS -->
<script>
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
</script>
