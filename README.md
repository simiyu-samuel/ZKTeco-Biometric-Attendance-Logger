# ZKTeco Biometric Attendance Logger

This is a Python-based attendance monitoring system that connects to a ZKTeco biometric device, logs user attendance data into an Excel file, and sends SMS notifications via the **Mspace SMS API**. The system includes a UI to view logs and a batch script for automated startup.

## ✨ Features

- 🔌 Connects to a ZKTeco biometric device via IP.
- 📋 Logs attendance events (sign-in/sign-out) to an Excel file.
- 📲 Sends SMS notifications to users upon successful attendance capture using **Mspace API**.
- 🔁 Avoids duplicate log entries.
- ⚠️ Handles errors such as device disconnection and file permission issues.
- 🖥️ Includes a **UI** to view:
  - Attendance logs
  - SMS logs
- ⚙️ Comes with a **batch script** to automatically run the main app and start monitoring biometric events.

## 🛠 Prerequisites

Ensure you have the following installed:

- Python 3.x
- A working ZKTeco biometric device
- Required Python packages (see below)

## 📦 Requirements

Install dependencies using `pip`:

```bash
pip install -r requirements.txt


## Requirements

-openpyxl==3.1.2
-zk==0.9.1
-requests==2.31.0
