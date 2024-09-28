<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'kanawa_taxi_db';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from the database
    $drivers_count = $conn->query("SELECT COUNT(*) AS count FROM drivers")->fetch_assoc()['count'];
    $vehicles_count = $conn->query("SELECT COUNT(*) AS count FROM vehicles")->fetch_assoc()['count'];
    $trips_count = $conn->query("SELECT COUNT(*) AS count FROM trips")->fetch_assoc()['count'];
    $total_invoices = $conn->query("SELECT SUM(amount) AS total FROM invoices")->fetch_assoc()['total'];

    $recent_trips = $conn->query("SELECT * FROM trips ORDER BY trip_date DESC LIMIT 5");
    $recent_invoices = $conn->query("SELECT * FROM invoices ORDER BY date DESC LIMIT 5");
    $recent_drivers = $conn->query("SELECT * FROM drivers ORDER BY id DESC LIMIT 5");
    $recent_vehicles = $conn->query("SELECT * FROM vehicles ORDER BY id DESC LIMIT 5");

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanawa Taxi Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            height: 100%;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1em;
            display: block;
            padding: 10px;
            border-radius: 4px;
        }

        .sidebar ul li a:hover {
            background-color: #495057;
        }

        .container {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
            overflow-y: auto;
        }

        .header {
            background-color: #343a40;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 2em;
            margin: 0;
        }

        .dashboard {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 2rem;
        }

        .dashboard-section {
            width: 100%;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dashboard-section h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #343a40;
        }

        .overview-cards {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card .icon {
            font-size: 2.5em;
            color: #343a40;
        }

        .card .info {
            text-align: right;
        }

        .card .info h3 {
            font-size: 1.2em;
            margin-bottom: 5px;
            color: #343a40;
        }

        .card .info p {
            font-size: 1.5em;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #dddddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard {
                grid-template-columns: 1fr;
            }

            .overview-cards {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="dashboard.php">Overview</a></li>
            <li><a href="trips.php">Trips</a></li>
            <li><a href="drivers.php">Drivers</a></li>
            <li><a href="vehicles.php">Vehicles</a></li>
            <li><a href="invoices.php">Invoices</a></li>
            <li><a href="manage-admin.php">Admin Management</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="header">
            <h1>Kanawa Taxi Admin Dashboard</h1>
        </div>

        <div class="dashboard">
            <div class="dashboard-section">
                <h2>Overview</h2>
                <div class="overview-cards">
                    <div class="card">
                        <div class="icon"><i class="fas fa-user-tie"></i></div>
                        <div class="info">
                            <h3>Total Drivers</h3>
                            <p><?php echo $drivers_count; ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="icon"><i class="fas fa-car"></i></div>
                        <div class="info">
                            <h3>Total Vehicles</h3>
                            <p><?php echo $vehicles_count; ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="icon"><i class="fas fa-road"></i></div>
                        <div class="info">
                            <h3>Total Trips</h3>
                            <p><?php echo $trips_count; ?></p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                        <div class="info">
                            <h3>Total Invoices</h3>
                            <p><?php echo number_format($total_invoices, 2); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-section">
                <h2>Recent Trips</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Driver Name</th>
                            <th>Vehicle ID</th>
                            <th>Start Location</th>
                            <th>End Location</th>
                            <th>Trip Date</th>
                            <th>Fare</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($trip = $recent_trips->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $trip['id']; ?></td>
                                <td><?php echo $trip['driver_name']; ?></td>
                                <td><?php echo $trip['vehicle_id']; ?></td>
                                <td><?php echo $trip['start_location']; ?></td>
                                <td><?php echo $trip['end_location']; ?></td>
                                <td><?php echo $trip['trip_date']; ?></td>
                                <td><?php echo number_format($trip['fare'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="dashboard-section">
                <h2>Recent Invoices</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice Number</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($invoice = $recent_invoices->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $invoice['id']; ?></td>
                                <td><?php echo $invoice['invoice_number']; ?></td>
                                <td><?php echo number_format($invoice['amount'], 2); ?></td>
                                <td><?php echo $invoice['date']; ?></td>
                                <td><?php echo $invoice['description']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="dashboard-section">
                <h2>Recent Drivers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Driver Name</th>
                            <th>License Number</th>
                            <th>Contact Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($driver = $recent_drivers->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $driver['id']; ?></td>
                                <td><?php echo $driver['driver_name']; ?></td>
                                <td><?php echo $driver['license_number']; ?></td>
                                <td><?php echo $driver['contact_number']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="dashboard-section">
                <h2>Recent Vehicles</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vehicle Model</th>
                            <th>License Plate</th>
                            <th>Capacity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($vehicle = $recent_vehicles->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $vehicle['id']; ?></td>
                                <td><?php echo $vehicle['vehicle_model']; ?></td>
                                <td><?php echo $vehicle['license_plate']; ?></td>
                                <td><?php echo $vehicle['capacity']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
