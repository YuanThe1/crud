<?php
include("dbconfig.php");

session_start(); // Start the session to handle user login state
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"> <!-- Separate CSS file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <h2 style="flex-grow: 1; text-align: center; margin: 1;">User List</h2>
        <a type="button" class="btn btn-primary" href='add.php'>Add a user</a>
    </div>

    <!-- Search Form -->
    <form class="mb-3">
    <div class="input-group">
        <div class="row">
            <div class="col-auto">
                <select class="form-select square-dropdown" id="userLimit" aria-label="Number of users per page">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class="col">
                <input type="text" class="form-control search-input" id="search" placeholder="Search by name or email" aria-label="Search">
            </div>
        </div>
    </div>
</form>


    <div id="user-table" class="table-responsive">
        <!-- User table will be loaded here via AJAX -->
    </div>
    
    <a href="logout.php">Log out</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    let currentPage = 1;
    let userLimit = $('#userLimit').val(); // Default to selected limit

    function fetchUsers(query, page, limit) {
        $.ajax({
            url: 'fetch_users.php',
            method: 'POST',
            data: { search: query, page: page, limit: limit },
            success: function(data) {
                $('#user-table').html(data);
            }
        });
    }

    // Initial fetch
    fetchUsers('', currentPage, userLimit);

    // On keyup in search input, fetch users
    $('#search').on('keyup', function() {
        const query = $(this).val();
        fetchUsers(query, currentPage, userLimit);
    });

    // Handle pagination clicks
    $(document).on('click', '.pagination .page-link', function(e) {
        e.preventDefault();
        currentPage = $(this).data('page');
        const query = $('#search').val();
        fetchUsers(query, currentPage, userLimit);
    });

    // Handle user limit change
    $('#userLimit').on('change', function() {
        userLimit = $(this).val();
        currentPage = 1; // Reset to first page
        fetchUsers($('#search').val(), currentPage, userLimit);
    });
});
</script>
</body>
</html>
