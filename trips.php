<?php
    // MySQL database connection
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'kanawa_taxi_db';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $driver_name = $_POST['driver_name'];
        $vehicle_id = $_POST['vehicle_id'];
        $start_location = $_POST['start_location'];
        $end_location = $_POST['end_location'];
        $trip_date = $_POST['trip_date'];
        $fare = $_POST['fare'];

        $stmt = $conn->prepare("INSERT INTO trips (driver_name, vehicle_id, start_location, end_location, trip_date, fare) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssd", $driver_name, $vehicle_id, $start_location, $end_location, $trip_date, $fare);

        if ($stmt->execute()) {
            echo "<script>alert('Trip added successfully');</script>";
        } else {
            echo "<script>alert('Error adding trip');</script>";
        }
        $stmt->close();
    }

    // Fetch trips data
    $trips_query = "SELECT * FROM trips";
    $trips_result = $conn->query($trips_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trips</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        .header .buttons .sign-out {
            background-color: #d9534f;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            color: white;
            text-decoration: none;
        }

        .container {
            display: flex;
            flex: 1;
            height: 100%;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: #ddd;
        }

        .sidebar a {
            color: white;
            padding: 10px 0;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #495057;
            padding-left: 10px;
            border-left: 3px solid #fff;
        }

        .content {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
            overflow-y: scroll;
            height: 100%;
            padding-bottom: 6rem;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .form-section, .table-section {
            margin-bottom: 2rem;
        }

        h2 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: #333;
        }

        .form-section form {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .form-section form .form-group {
            flex: 1 1 calc(50% - 1.5rem);
            display: flex;
            flex-direction: column;
        }

        .form-section form .form-group label {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-section form .form-group input,
        .form-section form .form-group select {
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        .form-section form .form-group input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            border: none;
            flex: 1 1 100%;
        }

        .form-section form .form-group input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .table-section {
            padding-top: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8rem;
        }

        table th, table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f5f5f5;
            font-size: 1rem;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        @media (max-width: 768px) {
            .form-section form .form-group {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Manage Trips</h1>
        <div class="buttons">
            <a href="logout.php" class="sign-out">Sign Out</a>
        </div>
    </div>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <a href="dashboard.php">Overview</a>
            <a href="trips.php">Trips</a>
            <a href="drivers.php">Drivers</a>
            <a href="vehicles.php">Vehicles</a>
            <a href="invoices.php">Invoices</a>
            <a href="manage-admin.php">Admin Management</a>
        </div>

        <!-- Content Section -->
        <div class="content">
            <!-- Form Section -->
            <div class="form-section">
                <h2>Add New Trip</h2>
                <form action="trips.php" method="post">
                    <div class="form-group">
                        <label for="driver_name">Driver Name</label>
                        <input type="text" id="driver_name" name="driver_name" required>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_id">Vehicle ID</label>
                        <input type="number" id="vehicle_id" name="vehicle_id" required>
                    </div>
                    <div class="form-group">
                        <label for="start_location">Start Location</label>
                        <input type="text" id="start_location" name="start_location" required>
                    </div>
                    <div class="form-group">
                        <label for="end_location">End Location</label>
                        <input type="text" id="end_location" name="end_location" required>
                    </div>
                    <div class="form-group">
                        <label for="trip_date">Trip Date</label>
                        <input type="date" id="trip_date" name="trip_date" required>
                    </div>
                    <div class="form-group">
                        <label for="fare">Fare (₦)</label>
                        <input type="number" id="fare" name="fare" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Add Trip">
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <h2>Existing Trips</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Driver Name</th>
                            <th>Vehicle ID</th>
                            <th>Start Location</th>
                            <th>End Location</th>
                            <th>Trip Date</th>
                            <th>Fare (₦)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($trips_result->num_rows > 0) {
                                while ($row = $trips_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['driver_name'] . "</td>";
                                    echo "<td>" . $row['vehicle_id'] . "</td>";
                                    echo "<td>" . $row['start_location'] . "</td>";
                                    echo "<td>" . $row['end_location'] . "</td>";
                                    echo "<td>" . $row['trip_date'] . "</td>";
                                    echo "<td>" . number_format($row['fare'], 2) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No trips found</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
