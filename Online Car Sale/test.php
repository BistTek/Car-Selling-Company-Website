<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Car</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 0;
        background-color: #f7f7f7;
        color: #333;
      }
      label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }
      table,
      th,
      td {
        border: 1px solid #ddd;
      }
      th,
      td {
        padding: 8px;
        text-align: left;
      }
      th {
        background-color: #4caf50;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
      }
      form {
        margin-bottom: 20px;
      }
      input {
        margin-bottom: 10px;
        padding: 10px;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
      }
      button {
        padding: 10px 15px;
        background-color: #4caf50;
        color: white;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }
      button:hover {
        background-color: #45a049;
      }
      
      

    </style>
  </head>
  <body>
  <a href="logout.php" style="padding:10px 20px; background-color:#e53935; color:white; text-decoration:none; font-weight:bold; border-radius:8px; border:none; transition:background-color 0.3s ease, transform 0.2s ease; box-shadow:0 4px 6px rgba(0, 0, 0, 0.1); float:right; margin:10px 0;">Logout</a>
    <h1>Add a Car</h1>
    <form id="carForm" action="add-car.php" method="POST">
      <label for="make">Make:</label>
      <input type="text" id="make" name="make" required />

      <label for="model">Model:</label>
      <input type="text" id="model" name="model" required />

      <label for="year">Year:</label>
      <input type="number" id="year" name="year" required />

      <label for="location">Location:</label>
      <input type="text" id="location" name="location" required />

      <label for="price">Price:</label>
      <input type="number" id="price" name="price" required />

      <button type="submit">Add Car</button>
    </form>

    <h2>Car List</h2>
    <table id="carTable">
      <thead>
        <tr>
          <th>Make</th>
          <th>Model</th>
          <th>Year</th>
          <th>Location</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        <!-- Optional: You can later populate this via PHP or AJAX -->
      </tbody>
    </table>
  </body>
</html>


<?php
require_once 'config.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $seller_id = $_SESSION['seller_id'];

    try {
        $stmt = $conn->prepare("INSERT INTO cars (seller_id, make, model, year, location, price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$seller_id, $make, $model, $year, $location, $price]);

        echo "<script>alert('Car added successfully!'); window.location.href='add-car.html';</script>";
    } catch(PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='add-car.html';</script>";
    }
} else {
    header("Location: add-car.html");
    exit();
}
?>


