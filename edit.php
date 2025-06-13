<?php
session_start();

// Sprawdzenie, czy admin jest zalogowany
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "rezerwacje_sali");
if ($conn->connect_error) {
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    echo "Nie podano ID rezerwacji. <a href='admin.php'>Wróć</a>";
    exit;
}

$id = (int)$_GET['id'];

// Obsługa formularza - aktualizacja
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name = $_POST['room_name'];
    $reserver_name = $_POST['reserver_name'];
    $reservation_date = $_POST['reservation_date'];
    $time_from = $_POST['time_from'];
    $time_to = $_POST['time_to'];
    $description = $_POST['description'];

    // Prosta walidacja (można rozbudować)
    if (empty($room_name) || empty($reserver_name) || empty($reservation_date) || empty($time_from) || empty($time_to)) {
        $error = "Wszystkie pola poza opisem są wymagane.";
    } else {
        // Aktualizacja w bazie
        $stmt = $conn->prepare("UPDATE reservations SET room_name=?, reserver_name=?, reservation_date=?, time_from=?, time_to=?, description=? WHERE id=?");
        $stmt->bind_param("ssssssi", $room_name, $reserver_name, $reservation_date, $time_from, $time_to, $description, $id);

        if ($stmt->execute()) {
            header("Location: admin.php?message=updated");
            exit;
        } else {
            $error = "Błąd podczas aktualizacji: " . $stmt->error;
        }
    }
}

// Pobierz dane rezerwacji do formularza
$stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Nie znaleziono rezerwacji o podanym ID. <a href='admin.php'>Wróć</a>";
    exit;
}

$reservation = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Edytuj rezerwację</title>
</head>
<body>

<h1>Edytuj rezerwację</h1>

<p><a href="admin.php">← Powrót do panelu administratora</a></p>

<?php
if (!empty($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="post">
    <label for="room_name">Sala:</label><br>
    <input type="text" name="room_name" id="room_name" value="<?php echo htmlspecialchars($reservation['room_name']); ?>" required><br><br>

    <label for="reserver_name">Rezerwujący:</label><br>
    <input type="text" name="reserver_name" id="reserver_name" value="<?php echo htmlspecialchars($reservation['reserver_name']); ?>" required><br><br>

    <label for="reservation_date">Data (YYYY-MM-DD):</label><br>
    <input type="date" name="reservation_date" id="reservation_date" value="<?php echo $reservation['reservation_date']; ?>" required><br><br>

    <label for="time_from">Godzina rozpoczęcia (HH:MM):</label><br>
    <input type="time" name="time_from" id="time_from" value="<?php echo $reservation['time_from']; ?>" required><br><br>

    <label for="time_to">Godzina zakończenia (HH:MM):</label><br>
    <input type="time" name="time_to" id="time_to" value="<?php echo $reservation['time_to']; ?>" required><br><br>

    <label for="description">Opis (opcjonalnie):</label><br>
    <textarea name="description" id="description" rows="4" cols="50"><?php echo htmlspecialchars($reservation['description']); ?></textarea><br><br>

    <button type="submit">Zapisz zmiany</button>
</form>

</body>
</html>
