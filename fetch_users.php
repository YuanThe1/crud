<?php
include("dbconfig.php");

// Initialize search variable
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($connection, $_POST['search']);
}

// Pagination setup
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10; // Default to 10 if not set
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch data from the database with search functionality
$sql = "SELECT id, name, email, pass FROM users";
if ($search) {
    $sql .= " WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
}

// Count total users for pagination
$countQuery = "SELECT COUNT(*) as total FROM users" . ($search ? " WHERE name LIKE '%$search%' OR email LIKE '%$search%'" : '');
$countResult = mysqli_query($connection, $countQuery);
$totalCount = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalCount / $limit);

// Apply limit and offset to the main query
$sql .= " LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table class='table table-striped'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th class='text-center'>Actions</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row["id"]}</td>
                <td>{$row["name"]}</td>
                <td>{$row["email"]}</td>
                <td>{$row["pass"]}</td>
                <td class='text-center'>
                    <a class='btn btn-success' href='edit.php?id={$row["id"]}'>Edit</a>
                    <a class='btn btn-danger' href='delete.php?id={$row["id"]}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                </td>
            </tr>";
    }
    echo "</tbody>
          </table>";

    // Pagination controls with arrows and current page display
    echo '<nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">';

    // Previous button
    if ($page > 1) {
        echo "<li class='page-item'><a class='page-link' href='#' data-page='" . ($page - 1) . "'>&laquo; Previous</a></li>";
    } else {
        echo "<li class='page-item disabled'><span class='page-link'>&laquo; Previous</span></li>";
    }

    // Current page display
    echo "<li class='page-item disabled'><span class='page-link'>Page $page of $totalPages</span></li>";

    // Next button
    if ($page < $totalPages) {
        echo "<li class='page-item'><a class='page-link' href='#' data-page='" . ($page + 1) . "'>Next &raquo;</a></li>";
    } else {
        echo "<li class='page-item disabled'><span class='page-link'>Next &raquo;</span></li>";
    }

    echo '</ul>
          </nav>';
} else {
    echo "<p>No results found.</p>";
}
?>
