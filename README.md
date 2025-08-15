**BusBuddy**

**BusBuddy** is a simple and efficient web-based bus reservation system that allows users to search routes, select seats, and book tickets online, while enabling operators to manage schedules, fares, and seat availability. It ensures fast, paperless, and hassle-free travel.

---

## **Features**

* **Route Search** – Find buses by source, destination, and travel date.
* **Seat Selection** – Interactive seat layout for easy booking.
* **Instant Ticketing** – Get a unique booking ID after confirmation.
* **Admin Panel** – Manage routes, fares, and bookings.
* **Secure Login** – User and admin authentication.
* **Responsive Design** – Works on both mobile and desktop devices.

---

## **Technology Stack**

* **Frontend:** HTML, CSS, JavaScript
* **Backend:** PHP
* **Database:** MySQL

---

## **Installation**

1. **Clone the repository:**

   ```bash
   git clone https://github.com/Harshal2152007/BusBuddy.git
   ```

2. **Move to the project folder:**

   ```bash
   cd BusBuddy
   ```

3. **Import the database:**

   * Open `phpMyAdmin`
   * Create a new database (e.g., `bus_management `)
   * Import the SQL file from the `database` folder

4. **Configure database connection:**

   * Open `config.php`
   * Update host, username, password, and database name

5. **Run the project:**

   * Place the project folder in your server's root directory (`htdocs` for XAMPP)
   * Start Apache and MySQL from XAMPP
   * Visit `http://localhost/BusBuddy` in your browser

---

## **Usage**

* **User:** Search buses, select seats, and confirm booking.
* **Admin:** Manage buses, routes, fares, and passenger records.

---

## **License**

This project is open-source and available under the [MIT License](LICENSE).

BusBuddy
├── User Functions
│   ├── Search Bus
│   │   ├── Enter Source
│   │   ├── Enter Destination
│   │   └── Select Travel Date
│   ├── View Available Buses
│   │   ├── Bus Name
│   │   ├── Departure & Arrival Time
│   │   ├── Fare
│   │   └── Seat Availability
│   ├── Select Seat
│   │   ├── View Seat Layout
│   │   ├── Choose Preferred Seat(s)
│   │   └── Check Availability in Real Time
│   ├── Enter Passenger Details
│   │   ├── Name
│   │   ├── Age
│   │   ├── Gender
│   │   └── Contact Information
│   ├── Confirm Booking
│   │   ├── Review Trip Details
│   │   ├── Apply Coupon (if any)
│   │   └── Proceed to Payment
│   └── Get Ticket
│       ├── Booking ID
│       ├── Bus & Route Details
│       ├── Passenger Details
│       └── Download / Print Ticket
└── Admin Functions
    ├── Manage Routes
    │   ├── Add New Routes
    │   ├── Edit Routes
    │   └── Delete Routes
    ├── Manage Fares
    │   ├── Set Fare per Route
    │   ├── Offer Discounts
    │   └── Update Fare Details
    ├── Manage Seats
    │   ├── Set Seat Layout
    │   ├── Block/Unblock Seats
    │   └── Update Seat Status
    └── View Bookings
        ├── All Passenger Bookings
        ├── Cancellations
        └── Daily / Weekly / Monthly Reports

