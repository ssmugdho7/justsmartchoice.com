<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>India - Tampa Time Tracker</title>
<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  color: #333;
  text-align: center;
  margin-top: 100px;
}
.clock-box {
  background: #fff;
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
  width: 400px;
  margin: auto;
  padding: 20px;
}
h2 { color: #ff7b00; }
.status {
  font-weight: bold;
  font-size: 20px;
  padding: 10px;
  border-radius: 8px;
  display: inline-block;
}
.working { background-color: #4CAF50; color: #fff; }
.off { background-color: #f44336; color: #fff; }
</style>
</head>
<body>
<div class="clock-box">
  <h2>India - Tampa Time Tracker</h2>
  <?php
  // Set timezones
  $india = new DateTime("now", new DateTimeZone("Asia/Kolkata"));
  $tampa = new DateTime("now", new DateTimeZone("America/New_York"));

  // Employee shift in India
  $startIndia = new DateTime("08:00", new DateTimeZone("Asia/Kolkata"));
  $endIndia = new DateTime("16:00", new DateTimeZone("Asia/Kolkata"));

  // Convert start and end to Tampa time
  $startTampa = clone $startIndia;
  $endTampa = clone $endIndia;
  $startTampa->setTimezone(new DateTimeZone("America/New_York"));
  $endTampa->setTimezone(new DateTimeZone("America/New_York"));

  // Determine if employee is working now
  $nowIndia = clone $india;
  $isWorking = ($nowIndia >= $startIndia && $nowIndia <= $endIndia);

  echo "<p><strong>Current Time in India:</strong> " . $india->format("h:i A") . "</p>";
  echo "<p><strong>Current Time in Tampa:</strong> " . $tampa->format("h:i A") . "</p>";
  echo "<hr>";
  echo "<p><strong>Employee Work Hours (India):</strong> 8:00 AM - 4:00 PM</p>";
  echo "<p><strong>Equivalent in Tampa:</strong> " . $startTampa->format("h:i A") . " - " . $endTampa->format("h:i A") . "</p>";
  echo "<hr>";

  if ($isWorking) {
      echo "<div class='status working'>Employee is working now</div>";
  } else {
      echo "<div class='status off'>Employee is off duty</div>";
  }
  ?>
</div>
</body>
</html>
