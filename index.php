<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rezerwacja sali</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Rezerwacja sali konferencyjnej</h1>

    <form action="rezerwuj.php" method="post">
        <label for="room">Wybierz salę:</label>
        <select name="room_name" id="room" required>
            <option value="Sala A">Sala A</option>
            <option value="Sala B">Sala B</option>
            <option value="Sala C">Sala C</option>
            <option value="Sala D">Sala D</option>
        </select>
        <br><br>

        <label for="name">Twoje imię i nazwisko:</label>
        <input type="text" name="reserver_name" id="name" required>
        <br><br>

        <label for="date">Data rezerwacji:</label>
        <input type="date" name="reservation_date" id="date" required>
        <br><br>

        <label for="from">Godzina rozpoczęcia:</label>
        <input type="time" name="time_from" id="from" required>
        <br><br>

        <label for="to">Godzina zakończenia:</label>
        <input type="time" name="time_to" id="to" required>
        <br><br>

        <label for="desc">Opis (opcjonalnie):</label>
        <input type="text" name="description" id="desc">
        <br><br>

        <button type="submit">Zarezerwuj</button>
    </form>

    <br>

    <a href="admin.php">Przejdź do panelu administratora</a>
    <br><br>

    <a href="przegladaj_rezerwacje.php" style="display:inline-block; padding:10px 20px; background:#ffc107; color:#000; font-weight:bold; border-radius:5px; text-decoration:none;">
        Zobacz wszystkie rezerwacje
    </a>

</body>
</html>
