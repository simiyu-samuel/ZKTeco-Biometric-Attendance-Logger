# ZKTeco Biometric Attendance Logger

This project is a Python-based system that connects to a ZKTeco biometric device to log user attendance into an Excel file and send SMS notifications using the Infobip API.

## Features

- Connects to a ZKTeco biometric device via IP.
- Logs attendance events (sign-in/sign-out) to an Excel file.
- Sends SMS notifications to users upon successful attendance capture.
- Ensures duplicate entries are not logged.
- Handles error scenarios for device connectivity and file permissions.

## Prerequisites

Ensure you have the following installed:

- Python 3.x
- Required Python packages (see installation steps)
- A working ZKTeco biometric device

## Requirements

-openpyxl==3.1.2
-zk==0.9.1
-requests==2.31.0
