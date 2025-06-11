<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'attendance_system');
if ($conn->connect_error) {
    die(json_encode(["logs" => "Database connection failed", "pagination" => ""]));
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM attendance_logs ORDER BY timestamp DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$dailyLogs = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dailyLogs .= "<p><strong> User Id: </strong> {$row['user_id']} <strong>Username: </strong> {$row['user_name']}
         <strong>Action: </strong> {$row['action']} <strong> Timestamp: </strong> {$row['timestamp']}.</p>
        ";
    }
} else {
    $dailyLogs = "No logs found.";
}

$countResult = $conn->query("SELECT COUNT(*) AS total FROM attendance_logs");
$totalLogs = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalLogs / $limit);

$pagination = "<div class='pagination'>";
for ($i = 1; $i <= $totalPages; $i++) {
    $pagination .= "<button onclick='fetchLogs(\"daily_actions\", $i)'>$i</button> ";
}
$pagination .= "</div>";

echo json_encode(["logs" => $dailyLogs, "pagination" => $pagination]);
?>
