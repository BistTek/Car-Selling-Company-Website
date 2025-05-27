<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['seller_id'])) {
    header("Location: login.html");
    exit();
}
?>
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
      background-color: #f7f7f7;
      color: #333;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
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
    }
    button:hover {
      background-color: #45a049;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th {
      background-color: #4caf50;
      color: white;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    .logout-btn {
      float: right;
      padding: 8px 12px;
      background-color: #d9534f;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .logout-btn:hover {
      background-color: #c9302c;
    }
  </style>
</head>
<body>
  <a href="logout.php" class="logout-btn">Logout</a>
  <h1>Add a Car</h1>
  <form method="POST" action="add-car.php">
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

  <?php
  // Handle form submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $seller_id = $_SESSION['seller_id'];

    try {
      $stmt = $conn->prepare("INSERT INTO cars (seller_id, make, model, year, location, price) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->execute([$seller_id, $make, $model, $year, $location, $price]);
      echo "<script>alert('Car added successfully!'); window.location.href='add-car.php';</script>";
    } catch (PDOException $e) {
      echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
  }
  ?>

  <h2>Car List</h2>
  <table>
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
      <?php
      $seller_id = $_SESSION['seller_id'];
      $stmt = $conn->prepare("SELECT make, model, year, location, price FROM cars WHERE seller_id = ?");
      $stmt->execute([$seller_id]);
      $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($cars) {
        foreach ($cars as $car) {
          echo '<tr>';
          echo '<td>' . htmlspecialchars($car['make']) . '</td>';
          echo '<td>' . htmlspecialchars($car['model']) . '</td>';
          echo '<td>' . htmlspecialchars($car['year']) . '</td>';
          echo '<td>' . htmlspecialchars($car['location']) . '</td>';
          echo '<td>$' . htmlspecialchars($car['price']) . '</td>';
          echo '</tr>';
        }
      } else {
        echo '<tr><td colspan="5">No cars added yet.</td></tr>';
      }
      ?>
    </tbody>
  </table>
</body>
</html>
