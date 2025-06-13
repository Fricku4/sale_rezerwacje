<?php
// Połączenie z bazą
$conn = new mysqli("localhost", "root", "", "rezerwacje_sali");
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Pobranie wszystkich rezerwacji posortowanych po dacie i czasie
$sql = "SELECT * FROM reservations ORDER BY reservation_date ASC, time_from ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Przegląd rezerwacji sal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fffbe6;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #d2a500;
            margin-bottom: 30px;
            background-color: #fff3b3;
            padding: 15px;
            border-radius: 10px;
        }
        table {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto 40px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 14px 20px;
            border-bottom: 1px solid #f0d800;
            text-align: left;
            color: #333;
        }
        th {
            background-color: #fff3b3;
            color: #d2a500;
            font-weight: bold;
        }
        tr:hover {
            background-color: #fff7d1;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            color: #777;
            padding: 20px;
        }
        .btn-back {
            display: block;
            width: 160px;
            margin: 0 auto;
            padding: 12px 0;
            text-align: center;
            background-color: #ffd700;
            color: #000;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }
        .btn-back:hover {
            background-color: #ffcc00;
        }
    </style>
</head>
<body>

<h1>Przegląd rezerwacji sal konferencyjnych</h1>

<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Sala</th>
                <th>Rezerwujący</th>
                <th>Data</th>
                <th>Godzina od</th>
                <th>Godzina do</th>
                <th>Opis</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['room_name']) ?></td>
                <td><?= htmlspecialchars($row['reserver_name']) ?></td>
                <td><?= htmlspecialchars($row['reservation_date']) ?></td>
                <td><?= htmlspecialchars($row['time_from']) ?></td>
                <td><?= htmlspecialchars($row['time_to']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="no-data">Brak aktualnych rezerwacji.</p>
<?php endif; ?>

<a href="index.php" class="btn-back">Powrót do strony głównej</a>

</body>
</html>

<?php
$conn->close();
?>
