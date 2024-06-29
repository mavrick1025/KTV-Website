<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="icon" type="image/png" href="ktv_logo.png">
    <link rel="stylesheet" href="reservation_style.css">
</head>
<body>
    <nav>
        <h1><img src="ktvlogo_name.png" alt="logoname"></h1>
        <button class="button" onclick="location.href='index.php'">Home</button>
        <button class="button" onclick="location.href='aboutus.php'">About Us</button>
        <button class="button" onclick="location.href='reservation.php'">Reservation</button>
        <button class="button" onclick="location.href='logout.php'">Logout</button>
    </nav>

    <div class="container">
        <label for="month" style="margin-bottom: 8px; font-weight: bold;">Month:</label>
        <select id="month" name="month">
            <?php
            for ($i = 1; $i <= 12; $i++) {
                $monthName = date("F", mktime(0, 0, 0, $i, 10));
                echo "<option value=\"$i\">$monthName</option>";
            }
            ?>
        </select>

        <label for="year" style="margin-bottom: 8px; font-weight: bold;">Year:</label>
        <select id="year" name="year">
            <?php
            $currentYear = date("Y");
            for ($i = $currentYear; $i <= $currentYear + 10; $i++) {
                echo "<option value=\"$i\">$i</option>";
            }
            ?>
        </select>

        <button id="go">Go</button>
    </div>

    <div id="current-month-year" style="text-align: center; font-size: 20px; margin-top: 20px;"></div>

    <div id="calendar" style="margin-top: 20px;"></div>

    <div id="reservation-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Reservations for <span id="modal-date"></span></h2>
            <div id="reservation-form" style="text-align: center;">
                <form id="reservationForm" method="POST">
                    <label for="time">Time:</label>
                    <select name="time" id="time">
                        <?php
                        for ($i = 13; $i <= 21; $i++) {
                            $time = date("g:i A", mktime($i, 0));
                            $timeHalf = date("g:i A", mktime($i, 30));
                            echo "<option value=\"$time\">$time</option>";
                            echo "<option value=\"$timeHalf\">$timeHalf</option>";
                        }
                        ?>
                    </select><br><br>
                    <input type="hidden" name="date" id="date">
                    <button type="submit" name="submit" class="button">Submit</button>
                </form>
                <div id="successMessage"></div>
            </div>
            <div style="background: #333333; padding: 15px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); font-family: Arial, sans-serif; width: 400px; margin: auto; margin-top: 10px; color: white;">
                <p><b>NOT AVAILABLE TIME</b></p>
                <ul style="text-align: left;" id="reservation-list"></ul>
            </div>    
        </div>
    </div>

    <script>
        const monthSelect = document.getElementById("month");
        const yearSelect = document.getElementById("year");
        const goButton = document.getElementById("go");
        const calendarDiv = document.getElementById("calendar");
        const modal = document.getElementById("reservation-modal");
        const closeBtn = document.querySelector(".close");
        const modalDate = document.getElementById("modal-date");
        const reservationForm = document.getElementById("reservationForm");
        const dateInput = document.getElementById("date");
        const successMessage = document.getElementById("successMessage");
        const reservationList = document.getElementById("reservation-list");
        const currentMonthYearDiv = document.getElementById("current-month-year");

        goButton.addEventListener("click", () => {
            const month = monthSelect.value;
            const year = yearSelect.value;
            fetchCalendar(month, year);
        });

        function fetchCalendar(month, year) {
            fetch(`calendar.php?month=${month}&year=${year}`)
                .then(response => response.text())
                .then(data => {
                    calendarDiv.innerHTML = data;
                    updateCurrentMonthYear(month, year);
                })
                .then(() => {
                    document.querySelectorAll(".calendar-day").forEach((button) => {
                        button.addEventListener("click", (e) => {
                            e.preventDefault();
                            const day = button.getAttribute("data-day");
                            const month = button.getAttribute("data-month");
                            const year = button.getAttribute("data-year");
                            const date = `${year}-${month}-${day}`;
                            dateInput.value = date;

                            fetch(`get_reservations.php?date=${date}`)
                                .then(response => response.json())
                                .then(data => {
                                    modal.style.display = "block";
                                    modalDate.textContent = date;
                                    reservationList.innerHTML = "";
                                    if (data.length > 0) {
                                        data.forEach((reservation) => {
                                            const listItem = document.createElement("LI");
                                            listItem.textContent = reservation.time_slot;
                                            reservationList.appendChild(listItem);
                                        });
                                    } else {
                                        reservationList.innerHTML = "<li>No reservations</li>";
                                    }
                                })
                                .catch(error => console.error(error));
                        });
                    });
                });
        }

        function updateCurrentMonthYear(month, year) {
            const monthName = new Date(year, month - 1).toLocaleString('default', { month: 'long' });
            currentMonthYearDiv.textContent = `${monthName} ${year}`;
        }

        closeBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        window.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });

        reservationForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const formData = new FormData(reservationForm);

            fetch('submit_reservation.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        successMessage.textContent = "Reservation submitted successfully!";
                        successMessage.style.color = "green";
                        fetchCalendar(new Date().getMonth() + 1, new Date().getFullYear());
                    } else {
                        successMessage.textContent = "This time slot is not available.";
                        successMessage.style.color = "red";
                    }
                    setTimeout(() => {
                        successMessage.textContent = "";
                        modal.style.display = "none";
                    }, 3000);
                })
                .catch(error => console.error(error));
        });

        // Load the current month calendar by default
        const currentDate = new Date();
        const currentMonth = currentDate.getMonth() + 1;
        const currentYear = currentDate.getFullYear();
        fetchCalendar(currentMonth, currentYear);
    </script>
</body>
</html>