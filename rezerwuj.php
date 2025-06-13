<?php
// Połączenie z bazą
$conn = new mysqli("localhost", "root", "", "rezerwacje_sali");
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Odczyt danych z formularza
$room_name = $_POST['room_name'];
$reserver_name = $_POST['reserver_name'];
$reservation_date = $_POST['reservation_date'];
$time_from = $_POST['time_from'];
$time_to = $_POST['time_to'];
$description = $_POST['description'];

// Sprawdzenie kolizji (czy sala jest już zajęta)
$sql = "SELECT * FROM reservations 
        WHERE room_name = ? AND reservation_date = ? 
        AND ((time_from < ? AND time_to > ?) OR (time_from < ? AND time_to > ?) OR (time_from >= ? AND time_to <= ?))";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $room_name, $reservation_date, $time_to, $time_to, $time_from, $time_from, $time_from, $time_to);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Potwierdzenie rezerwacji</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if ($result->num_rows > 0) {
    echo "<div class='message' style='max-width:600px; margin: 50px auto;'>
            <h2>Ta sala jest już zajęta w tym czasie.</h2>
            <p>Wybierz inny termin lub salę.</p>
            <div style='text-align:center; margin-top: 20px;'>
                <a href='index.php' class='btn'>Wróć do formularza</a>
            </div>
          </div>";
} else {
    // Zapisz rezerwację
    $stmt = $conn->prepare("INSERT INTO reservations (room_name, reserver_name, reservation_date, time_from, time_to, description) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $room_name, $reserver_name, $reservation_date, $time_from, $time_to, $description);

    if ($stmt->execute()) {
        echo "<div class='message' style='max-width:600px; margin: 50px auto; text-align:center;'>
                <h2>Rezerwacja została dodana pomyślnie!</h2>
                <div style='margin-top: 30px;'>
                    <a href='przegladaj_rezerwacje.php' class='btn' style='margin-right:10px;'>Zobacz wszystkie rezerwacje</a>
                    <a href='index.php' class='btn'>Powrót do strony głównej</a>
                </div>
              </div>";
    } else {
        echo "<div class='message' style='max-width:600px; margin: 50px auto; text-align:center;'>
                <h2>Błąd przy zapisie rezerwacji:</h2>
                <p>" . htmlspecialchars($stmt->error) . "</p>
                <a href='index.php' class='btn'>Powrót do formularza</a>
              </div>";
    }
}
$conn->close();
?>

</body>
</html>
