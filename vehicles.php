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
        $vehicle_model = $_POST['vehicle_model'];
        $license_plate = $_POST['license_plate'];
        $capacity = $_POST['capacity'];

        $stmt = $conn->prepare("INSERT INTO vehicles (vehicle_model, license_plate, capacity) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $vehicle_model, $license_plate, $capacity);

        if ($stmt->execute()) {
            echo "<script>alert('Vehicle added successfully');</script>";
        } else {
            echo "<script>alert('Error adding vehicle');</script>";
        }
        $stmt->close();
    }

    // Fetch vehicles data
    $vehicles_query = "SELECT * FROM vehicles";
    $vehicles_result = $conn->query($vehicles_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vehicles</title>
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
            display: flex;
            flex-direction: column;
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
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-section form .form-group {
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
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 5px;
            width: 100%;
            display: block;
            margin-top: 1.5rem;
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
        <h1>Manage Vehicles</h1>
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
                <h2>Add New Vehicle</h2>
                <form action="vehicles.php" method="post">
                    <div class="form-group">
                        <label for="vehicle_model">Vehicle Model</label>
                        <input type="text" id="vehicle_model" name="vehicle_model" required>
                    </div>
                    <div class="form-group">
                        <label for="license_plate">License Plate</label>
                        <input type="text" id="license_plate" name="license_plate" required>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" id="capacity" name="capacity" required>
                    </div>
                    <!-- Submit Button on its own row -->
                    <div class="form-group">
                        <input type="submit" value="Add Vehicle">
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <h2>Existing Vehicles</h2>
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
                        <?php
                            if ($vehicles_result->num_rows > 0) {
                                while ($row = $vehicles_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['vehicle_model'] . "</td>";
                                    echo "<td>" . $row['license_plate'] . "</td>";
                                    echo "<td>" . $row['capacity'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No vehicles found</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
