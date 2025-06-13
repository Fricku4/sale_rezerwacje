Instrukcja uruchomienia aplikacji systemu
rezerwacji sal konferencyjnych
 System operacyjny: Windows 10 / 11
 Zainstalowany XAMPP (np. xampp-windows-x64-8.2.12-0-VS16-installer.exe)
 Przeglądarka internetowa (np. Chrome, Firefox)
Krok 1: Uruchom XAMPP
1. Otwórz XAMPP Control Panel.
2. Włącz usługi:
o Apache (serwer WWW)
o MySQL (serwer bazy danych)
Krok 2: Skopiuj projekt do XAMPP
1. Rozpakuj paczkę .zip z projektem.
2. Skopiuj cały folder projektu (sale_rezerwacje) do:
C:\xampp\htdocs\
Krok 3: Import bazy danych
1. W przeglądarce otwórz:
http://localhost/phpmyadmin
Kliknij Nowa, aby utworzyć nową bazę danych o nazwie:
rezerwacje_sali
 Przejdź do zakładki Import.
Wybierz plik baza.sql z folderu projektu i kliknij Wykonaj.
Krok 4: Uruchomienie aplikacji
1. W przeglądarce przejdź do:
http://localhost/sale_rezerwacje
2. Zobaczysz stronę główną z opcją Zarezerwuj salę oraz Przeglądaj rezerwacje.
Logowanie jako administrator
1. Na stronie głównej kliknij: Panel administratora.
2. Wprowadź hasło:
admin
