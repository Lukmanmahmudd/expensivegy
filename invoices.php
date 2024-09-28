<?php
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
        $invoice_number = $_POST['invoice_number'];
        $date = $_POST['date'];
        $amount = $_POST['amount'];
        $description = $_POST['description'];
        $related_to = isset($_POST['related_to']) ? $_POST['related_to'] : NULL;
        $related_id = isset($_POST['related_id']) ? $_POST['related_id'] : NULL;

        $stmt = $conn->prepare("INSERT INTO invoices (invoice_number, date, amount, description, related_to, related_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisii", $invoice_number, $date, $amount, $description, $related_to, $related_id);

        if ($stmt->execute()) {
            echo "<script>alert('Invoice added successfully');</script>";
        } else {
            echo "<script>alert('Error adding invoice');</script>";
        }
        $stmt->close();
    }

    // Fetch invoices data
    $invoices_query = "SELECT * FROM invoices";
    $invoices_result = $conn->query($invoices_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Invoices</title>
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

        .form-section form .btn {
            width: 100%;
            display: block;
        }

        .form-section form .form-group input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            border: none;
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
        <h1>Manage Invoices</h1>
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
                <h2>Add New Invoice</h2>
                <form action="invoices.php" method="post">
                    <div class="form-group">
                        <label for="invoice_number">Invoice Number</label>
                        <input type="text" id="invoice_number" name="invoice_number" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" required>
                    </div>
                    <div class="form-group">
                        <label for="related_to">Related To</label>
                        <select id="related_to" name="related_to">
                            <option value="" selected>None</option>
                            <option value="driver">Driver</option>
                            <option value="vehicle">Vehicle</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="related_id">Related ID</label>
                        <input type="number" id="related_id" name="related_id">
                    </div>
                    <div class="form-group btn">
                        <input type="submit" value="Add Invoice">
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-section">
                <h2>Existing Invoices</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Related To</th>
                            <th>Related ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($invoices_result->num_rows > 0) {
                                while($row = $invoices_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['invoice_number'] . "</td>";
                                    echo "<td>" . $row['date'] . "</td>";
                                    echo "<td>" . $row['amount'] . "</td>";
                                    echo "<td>" . $row['description'] . "</td>";
                                    echo "<td>" . ($row['related_to'] ?: 'None') . "</td>";
                                    echo "<td>" . ($row['related_id'] ?: 'None') . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No invoices found</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
