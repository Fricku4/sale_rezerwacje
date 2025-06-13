<?php
session_start();

$admin_password = "admin";

// Logowanie
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "Nieprawidłowe hasło.";
    }
}

// Wylogowanie
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Jeśli nie zalogowany, pokaż formularz logowania
if (!isset($_SESSION['admin_logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Logowanie administratora</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Logowanie administratora</h1>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <form method="post">
            <label for="password">Hasło:</label>
            <input type="password" name="password" id="password" required><br><br>
            <button type="submit" class="btn">Zaloguj</button>
            <a href="index.php" class="btn" style="margin-left: 10px;">Anuluj</a>
        </form>
    </body>
    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administratora</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Pasek górny z przyciskami -->
<div class="admin-topbar">
    <a href="index.php" class="admin-btn">🏠 Strona główna</a>
    <a href="admin.php?logout=1" class="admin-btn">🚪 Wyloguj</a>
</div>

<h1 style="text-align:center; margin-top: 30px;">Panel administratora</h1>

<?php
$conn = new mysqli("localhost", "root", "", "rezerwacje_sali");
if ($conn->connect_error) {
    die("Błąd połączenia z bazą: " . $conn->connect_error);
}

// Usuwanie rezerwacji
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM reservations WHERE id = $id");
    echo "<p class='success-msg'>Rezerwacja została usunięta.</p>";
}

// Lista rezerwacji
$result = $conn->query("SELECT * FROM reservations ORDER BY reservation_date, time_from");

if ($result->num_rows > 0) {
    echo "<table class='admin-table'>";
    echo "<tr><th>Sala</th><th>Data</th><th>Od</th><th>Do</th><th>Rezerwujący</th><th>Opis</th><th>Akcje</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['room_name']) . "</td>";
        echo "<td>" . $row['reservation_date'] . "</td>";
        echo "<td>" . $row['time_from'] . "</td>";
        echo "<td>" . $row['time_to'] . "</td>";
        echo "<td>" . htmlspecialchars($row['reserver_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
        echo "<td>
                <a href='edit.php?id={$row['id']}'>Edytuj</a> | 
                <a href='admin.php?delete={$row['id']}' onclick='return confirm(\"Na pewno usunąć?\")'>Usuń</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center;'>Brak rezerwacji.</p>";
}

$conn->close();
?>

</body>
</html>
