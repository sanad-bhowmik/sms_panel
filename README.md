# AdminApi - SMSPanel

## Overview

**SMSPanel** is an administrative API designed for managing SMS communications efficiently. It provides a centralized panel for sending, receiving, and tracking SMS messages, making it ideal for businesses and developers who need a reliable SMS solution.

## Features

- Send SMS messages to single or multiple recipients.
- Receive incoming SMS messages.
- Track the status of sent messages.
- User authentication and authorization.
- Detailed logging and reporting.

## Installation

To set up the SMSPanel on your local machine, follow these steps:

1. **Clone the repository:**

    ```bash
    git clone https://github.com/sanad-bhowmik/sms_panel.git
    ```

2. **Navigate to the project directory:**

    ```bash
    cd sms_panel
    ```

3. **Set up your web server:**

    - If you are using Apache, ensure the document root points to the project directory.
    - Enable `mod_rewrite` if you plan to use URL rewriting.
    - For Nginx, configure the server block to point to the project directory.
    - Ensure PHP is properly installed and configured to work with your web server.

4. **Database Configuration:**

    - Import the SQL file located in the `database` directory to set up the necessary tables:

    ```bash
    mysql -u your_username -p your_database_name < database/schema.sql
    ```

    - Update the database connection settings in the configuration file (e.g., `config.php`):

    ```php
    // config.php
    define('DB_HOST', 'your_database_host');
    define('DB_USER', 'your_database_user');
    define('DB_PASS', 'your_database_password');
    define('DB_NAME', 'your_database_name');
    ```

5. **Configure MSMQ:**

    - Ensure that Microsoft Message Queuing (MSMQ) is installed on your Windows server.
    - Set up the necessary message queues for your application.
    - Make sure PHP has access to the MSMQ through COM objects or another appropriate extension.

    Example code for interacting with MSMQ in PHP:

    ```php
    $queue = new COM("MSMQ.MSMQQueueInfo");
    $queue->FormatName = "direct=os:your_computer_name\\private$\\your_queue_name";
    $queue->Open(MQ_RECEIVE_ACCESS, MQ_DENY_NONE);

    $msg = $queue->Receive();
    if ($msg) {
        $messageBody = $msg->Body;
        // Process the message
    }
    $queue->Close();
    ```

## Configuration

Configure the application by editing the `config.php` file with your database, API keys, and MSMQ settings.

## Usage

To use the SMSPanel API, follow these examples:

### Sending an SMS

```bash
curl -X POST https://yourdomain.com/api/send_sms \
-H "Authorization: Bearer your_token" \
-d "to=+1234567890&message=Hello World"
