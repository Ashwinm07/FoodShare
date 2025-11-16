#  FoodShare: Community Food Sharing System

##  Project Overview

**FoodShare** is a full-stack, database-driven web application designed to combat **food waste** and enhance **community support** by creating an efficient platform for sharing surplus food. The system manages the entire lifecycle of a donation, from listing and securing requests to volunteer assignment and final delivery confirmation.

##  Tech Stack & Architecture

This project is built using a classic, robust LAMP-like stack (Linux/Windows, Apache, MySQL, PHP) for simplicity and reliability.

| Category | Technology | Role & Details |
| :--- | :--- | :--- |
| **Frontend** | HTML, CSS, JavaScript | Provides a modern, responsive user interface. Utilizes custom CSS (`style.css`) for consistent theming. |
| **Backend** | PHP | Handles all session management, business logic, and database interaction. Focuses on simple, direct execution. |
| **Database** | MySQL | Stores user data, food donations, requests, and administrative logs. |
| **Server** | **XAMPP** | Provides the necessary local development environment, including **Apache** (web server) and **MySQL** (database). |

##  Key Security & Integrity Features

After hardening the application, the following security and data integrity measures are implemented:

1.  **SQL Injection Prevention:** All critical database operations (Login, Registration, Data Insertion, Updates, Deletions) utilize **MySQLi Prepared Statements** and **parameter binding** to treat user input as data, not executable code.

2.  **Transactional Integrity:** The **Request Module** uses database **transactions** (`BEGIN TRANSACTION`, `COMMIT`, `ROLLBACK`) to ensure that quantity subtraction and request insertion either both succeed or both fail, preventing phantom inventory or data corruption.

3.  **Cross-Site Scripting (XSS) Mitigation:** All user-supplied data displayed on the dashboard is passed through `htmlspecialchars()` for output escaping.

##  Detailed Feature Modules

### 1. Multi-Role User Authentication

* **Roles:** Supports Donor, Receiver, Volunteer, and Admin roles, each routed to a dedicated dashboard upon successful login.
* **Navigation:** Includes **Home** links on the login/registration pages for easy navigation.

### 2. Donor Dashboard (Inventory Management & Feedback)

* **Control:** Donors can **Edit** or **Delete** their listed donations, but **only if the item status is 'Available'** (preventing disruption of active deliveries).
* **Feedback/Notifications:** Displays **"Thank You" notifications** for all past donations that have been successfully marked as **Delivered**.

### 3. Receiver Dashboard (Quantity-Based Requesting)

* **Real-Time View:** Displays only **Available** items with remaining quantity.
* **Quantity Input:** Receivers submit requests using a **number input box** that validates against the maximum available stock.
* **Request Logic:** The system uses a **transaction** to securely **subtract the requested quantity** from the total stock. If the quantity reaches zero, the item status is set to **'Unavailable'**.

### 4. Admin Dashboard (Workflow Control & Logging)

* **Workflow Tabs:** The dashboard is structured into three dedicated views for clear status management: **Pending**, **In Progress**, and **Delivered**.
* **Automatic Logging:** All Admin actions (Accept, Decline, Assign) are **automatically logged** into the `admin_logs` table.

### 5. Volunteer Dashboard (Delivery Management)

* **Task View:** Displays only requests that have been explicitly **Assigned** to the logged-in volunteer.
* **Status Update:** Volunteers manage the delivery progress by updating the status from **Assigned $\rightarrow$ Picked Up $\rightarrow$ Delivered**.
* **Seamless Operation:** Uses **iframe target fixes** to ensure action buttons execute and refresh the main dashboard without nesting.

##  Setup & Installation

1.  **Clone or Download** this repository.
2.  **Install XAMPP** (or equivalent WAMP/MAMP stack).
3.  **Place Files:** Move the project folder into your XAMPP's `htdocs` directory.
4.  **Database Setup:**
    * Open phpMyAdmin (via XAMPP Control Panel).
    * Create a new database named **`community_food_sharing_login`**.
    * Import the provided **`community_food_sharing_login.sql`** file.
5.  **Access:** Open your browser and navigate to `http://localhost/FoodShare/index.html` (assuming "FoodShare" is your project folder name).

##  Developed By

* **Ashwin Joseph Monteiro** 
