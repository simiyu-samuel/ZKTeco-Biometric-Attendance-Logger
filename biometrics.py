"""
Biometrics module for handling attendance tracking and SMS notifications.
"""

import http.client
import json
import time
from openpyxl import load_workbook
from zk import ZK

# Constants
ZK_IP = '192.168.1.201'
ZK_PORT = 4370
EXCEL_FILE = 'attendance.xlsx'
SMS_API_HOST = 'sms-api.example.com'
SMS_API_ENDPOINT = '/send'


def get_user_details(user_id):
    """Fetch user details (name and phone) from the ZKTeco device."""
    users = {
        1: {"name": "Alice", "phone": "1234567890"},
        2: {"name": "Bob", "phone": "0987654321"},
    }
    return users.get(user_id, None)


def fetch_attendance():
    """Fetch attendance logs from the biometric device."""
    try:
        zk = ZK(ZK_IP, port=ZK_PORT, timeout=5)
        conn = zk.connect()
        attendance = conn.get_attendance()
        conn.disconnect()
        return attendance
    except ConnectionError as error:
        print(f"Connection error: {error}")
    except Exception as error:
        print(f"An error occurred: {error}")
    return []


def store_to_excel(attendance_data):
    """Store attendance data to an Excel file without duplicates."""
    try:
        workbook = load_workbook(EXCEL_FILE)
        sheet = workbook.active
    except FileNotFoundError:
        from openpyxl import Workbook
        workbook = Workbook()
        sheet = workbook.active
        sheet.append(["User ID", "Name", "Time"])

    existing_entries = {(row[0].value, row[2].value) for row in sheet.iter_rows(min_row=2)}

    for record in attendance_data:
        user_id, timestamp = record.user_id, record.timestamp
        user = get_user_details(user_id)
        if user and (user_id, timestamp) not in existing_entries:
            sheet.append([user_id, user['name'], timestamp])

    workbook.save(EXCEL_FILE)


def send_sms(phone, message):
    """Send an SMS notification to the given phone number."""
    try:
        conn = http.client.HTTPSConnection(SMS_API_HOST)
        payload = json.dumps({"phone": phone, "message": message})
        headers = {'Content-Type': 'application/json'}
        conn.request("POST", SMS_API_ENDPOINT, body=payload, headers=headers)
        response = conn.getresponse()
        if response.status != 200:
            print(f"Failed to send SMS: {response.status} {response.reason}")
    except ConnectionError as error:
        print(f"SMS API connection error: {error}")


def process_attendance():
    """Process attendance logs by storing and sending notifications."""
    attendance_data = fetch_attendance()
    if attendance_data:
        store_to_excel(attendance_data)
        for record in attendance_data:
            user = get_user_details(record.user_id)
            if user:
                message = f"Hello {user['name']}, your entry was recorded at {record.timestamp}."
                send_sms(user['phone'], message)


if __name__ == "__main__":
    process_attendance()
