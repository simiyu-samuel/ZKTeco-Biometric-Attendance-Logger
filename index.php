<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Biometrics Control Panel</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        text-align: center;
        margin: 0;
        padding: 0;
      }

      .container {
        width: 60%;
        margin: 50px auto;
        background: white;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
      }

      h2 {
        color: #333;
      }

      .buttons {
        margin: 20px 0;
      }

      button {
        padding: 12px 20px;
        margin: 10px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
      }

      .start-btn {
        background-color: #28a745;
        color: white;
      }

      .stop-btn {
        background-color: #dc3545;
        color: white;
      }

      .retrieve-btn {
        background-color: #007bff;
        color: white;
      }

      .start-btn:hover {
        background-color: #218838;
      }
      .stop-btn:hover {
        background-color: #c82333;
      }
      .retrieve-btn:hover {
        background-color: #0056b3;
      }

      .logs-container {
        margin-top: 20px;
        text-align: left;
      }

      .log-box {
        width: 90%;
        margin: 10px auto;
        border: 2px solid #ddd;
        padding: 15px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        height: 400px;
        overflow-y: auto;
        text-align: left;
      }

      .pagination {
        display: flex;
        justify-content: center;
        margin-top: 10px;
      }

      .pagination button {
        padding: 8px 15px;
        margin: 5px;
        font-size: 14px;
        background-color: #333;
        color: white;
        border-radius: 5px;
        cursor: pointer;
      }

      .pagination button:hover {
        background-color: #555;
      }
    </style>
    <script>
      function fetchLogs(type, page = 1) {
        let url = type === "sms" ? "get_sms_logs.php?page=" + page : "get_daily_actions.php?page=" + page;
        let logBox = type === "sms" ? "sms-logs" : "daily-actions";
        let paginationBox = type === "sms" ? "sms-pagination" : "pagination-controls";

        fetch(url)
          .then(response => response.json())
          .then(data => {
            document.getElementById(logBox).innerHTML = data.logs;
            document.getElementById(paginationBox).innerHTML = data.pagination;
          })
          .catch(error => console.error("Error fetching logs:", error));
      }

      function stopScript() {
        fetch("stop_script.php", { method: "POST" })
          .then(response => response.text())
          .then(data => alert(data))
          .catch(error => console.error("Error stopping script:", error));
      }

      document.addEventListener("DOMContentLoaded", () => {
        fetchLogs("daily_actions", 1);
      });
    </script>
  </head>
  <body>
    <div class="container">
      <h2>Biometrics Attendance Control Panel</h2>

      <div class="buttons">
        <form action="run_batch.php" method="POST">
          <button class="start-btn" type="submit">Start Script</button>
        </form>
        <!-- <button class="stop-btn" onclick="stopScript()">Stop Script</button> -->
      </div>

      <h3>Daily Actions Log</h3>
      <button class="retrieve-btn" onclick="fetchLogs('daily_actions', 1)">Retrieve Actions</button>
      <div id="daily-actions" class="log-box">Loading...</div>
      <div class="pagination" id="pagination-controls"></div>

      <h3>SMS Logs</h3>
      <button class="retrieve-btn" onclick="fetchLogs('sms', 1)">Retrieve SMS Logs</button>
      <div id="sms-logs" class="log-box">No logs found.</div>
      <div class="pagination" id="sms-pagination"></div>
    </div>
  </body>
</html>
