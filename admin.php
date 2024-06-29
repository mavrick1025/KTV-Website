<?php
session_start();

// Check if user is an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';

// Fetch all reservations
$sql = "SELECT r.id, u.username, r.event_date, r.time_slot 
        FROM events r 
        JOIN users u ON r.user_id = u.id 
        ORDER BY r.event_date, r.time_slot";
$result = $conn->query($sql);

// Fetch all users
$user_sql = "SELECT id, username FROM users";
$user_result = $conn->query($user_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin_styles.css">
    <style>
        /* Styles for the pop-up form */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        
        .control-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .text {
            position: absolute; 
            left: 50%; 
            right: 50%;
        }
    </style>
</head>
<body>
    <nav>
        <h1>Admin Panel</h1>
        <button class="button" onclick="location.href='logout.php'">Logout</button>
    </nav>

    <h2>All Reservations</h2>
    <div class="control-container">
        <button onclick="showAddReservationForm()">Add Reservation</button>
        <input type="text" id="searchBar" onkeyup="searchReservations()" placeholder="Search for reservations...">
    </div>
    <table border="1" id="reservationTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Reservation Date</th>
                <th>Time Slot</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['event_date']; ?></td>
                    <td><?php echo $row['time_slot']; ?></td>
                    <td>
                        <button onclick="showEditReservationForm(<?php echo $row['id']; ?>, '<?php echo $row['event_date']; ?>', '<?php echo $row['time_slot']; ?>')">Edit</button>
                        <button onclick="deleteReservation(<?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Add Reservation Modal -->
    <div id="addReservationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddReservationForm()">&times;</span>
            <h3>Add Reservation</h3>
            <form id="addForm">
                <label for="user_id">Username:</label>
                <select id="user_id" name="user_id">
                    <?php while ($user_row = $user_result->fetch_assoc()) { ?>
                        <option value="<?php echo $user_row['id']; ?>"><?php echo $user_row['username']; ?></option>
                    <?php } ?>
                </select>
                <label for="event_date">Reservation Date:</label>
                <input type="date" id="event_date" name="event_date" required>
                <label for="time_slot">Time Slot:</label>
                <input type="time" id="time_slot" name="time_slot" required>
                <button type="submit">Add</button>
            </form>
        </div>
    </div>

    <!-- Edit Reservation Modal -->
    <div id="editReservationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditReservationForm()">&times;</span>
            <h3>Edit Reservation</h3>
            <form id="editForm">
                <input type="hidden" id="edit_reservation_id" name="reservation_id">
                <label for="edit_event_date">Reservation Date:</label>
                <input type="date" id="edit_event_date" name="event_date" required>
                <label for="edit_time_slot">Time Slot:</label>
                <input type="time" id="edit_time_slot" name="time_slot" required>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <script>
        function showAddReservationForm() {
            document.getElementById('addReservationModal').style.display = 'block';
            document.getElementById('editReservationModal').style.display = 'none';
        }

        function closeAddReservationForm() {
            document.getElementById('addReservationModal').style.display = 'none';
        }

        function showEditReservationForm(id, date, time) {
            document.getElementById('editReservationModal').style.display = 'block';
            document.getElementById('addReservationModal').style.display = 'none';
            document.getElementById('edit_reservation_id').value = id;
            document.getElementById('edit_event_date').value = date;
            document.getElementById('edit_time_slot').value = time;
        }

        function closeEditReservationForm() {
            document.getElementById('editReservationModal').style.display = 'none';
        }

        document.getElementById('addForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            fetch('add_reservation.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("Reservation added successfully");
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error(error));
        });

        document.getElementById('editForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            fetch('edit_reservation.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert("Reservation updated successfully");
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error(error));
        });

        function deleteReservation(id) {
            if (confirm("Are you sure you want to delete this reservation?")) {
                fetch(`delete_reservation.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert("Reservation deleted successfully");
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error(error));
            }
        }

        function searchReservations() {
            const input = document.getElementById("searchBar");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("reservationTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName("td");
                let showRow = false;
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                            showRow = true;
                        }
                    }
                }
                tr[i].style.display = showRow ? "" : "none";
            }
        }

        window.onclick = function(event) {
            const addModal = document.getElementById('addReservationModal');
            const editModal = document.getElementById('editReservationModal');
            if (event.target == addModal) {
                addModal.style.display = "none";
            } else if (event.target == editModal) {
                editModal.style.display = "none";
            }
        }
    </script>
</body>
</html>
