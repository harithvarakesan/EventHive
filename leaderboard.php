<?php include './header.php'; ?>
<?php
include './operations/db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

// SQL query to fetch participant details and sum of positive scores
$sql = "
    SELECT p.participant_id, u.name AS participant_name, u.college, 
           SUM(CASE WHEN p.mark > 0 THEN p.mark ELSE 0 END) AS total_score
    FROM participant p
    JOIN user u ON p.participant_id = u.id  -- Assuming participants are stored in 'users' table
    GROUP BY p.participant_id, u.name, u.college
    ORDER BY total_score DESC
";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = [
            'name' => $row['participant_name'],
            'college' => $row['college'],
            'score' => $row['total_score']
        ];
    }
} else {
    $students = [];
}

$conn->close();
?>

<?php $pageTitle = "Event Leaderboard"; include 'header.php'; ?>
        <div class="flex justify-between items-center mb-8 pt-10 px-8">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2"><i data-lucide='trophy'></i> Leaderboard</h2>
        </div>
        <div class="overflow-x-auto px-8">
            <!-- Podium Section for Top 3 Students -->
            <section class="podium mb-8">
                <?php
                // Display the top 3 students
                for ($i = 0; $i < 3 && $i < count($students); $i++) {
                    $rank = $i + 1;
                    $student = $students[$i];
                    $placeClass = ($rank === 1) ? 'first' : (($rank === 2) ? 'second' : 'third');
                    ?>
                    <div class='podium-position <?=$placeClass?> bg-white rounded-xl shadow-md border border-orange-100 p-4'>
                        <div class='position-title text-orange-600 uppercase tracking-wider'><?=$rank?>st Place</div>
                        <h2 class='student-name text-lg font-bold text-gray-900'><?=$student['name']?></h2>
                        <p class='college-name text-gray-600'><?=$student['college']?></p>
                        <p class='score text-orange-500 font-bold text-lg'>Score: <?=$student['score']?></p>
                    </div>
                <?php } ?>
            </section>
            <main class="leaderboard-container">
                <!-- Podium Section for Top 3 Students -->
                <section class="podium">
                    <?php
                    // Display the top 3 students
                    for ($i = 0; $i < 3 && $i < count($students); $i++) {
                        $rank = $i + 1;
                        $student = $students[$i];
                        $placeClass = ($rank === 1) ? 'first' : (($rank === 2) ? 'second' : 'third');
                        ?>
                        <div class='podium-position <?=$placeClass?>'>
                            <div class='position-title'><?=$rank?>st Place</div>
                            <h2 class='student-name'><?=$student['name']?></h2>
                            <p class='college-name'><?=$student['college']?></p>
                            <p class='score'>Score: <?=$student['score']?></p>
                        </div>
                    <?php } ?>
                </section>
                    <div class='podium-position {$placeClass}'>
                        <div class='position-title'>{$rank}st Place</div>
                        <h2 class='student-name'>{$student['name']}</h2>
                        <p class='college-name'>{$student['college']}</p>
                        <p class='score'>Score: {$student['score']}</p>
                    </div>
                ";
            }
            ?>
        </section>

        <!-- Filter Section -->
        <section class="filters">
            <label for="filter-name">Filter by:</label>
            <select id="filter-name" onchange="filterLeaderboard()">
                <option value="">Select</option>
                <option value="name">Name</option>
                <option value="college">College</option>
                <option value="score">Score</option>
            </select>

            <input type="text" id="filter-input" placeholder="Search..." oninput="filterLeaderboard()">
        </section>

        <!-- Leaderboard Table for Other Students -->
        <section class="leaderboard-table">
            <table id="leaderboard">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>College</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <!-- Dynamic rows will go here -->
                </tbody>
            </table>

            <!-- Pagination -->
            <div id="pagination">
                <button id="prev-page" onclick="changePage(-1)">Previous</button>
                <div id="page-numbers"></div> <!-- This will hold the page numbers -->
                <button id="next-page" onclick="changePage(1)">Next</button>
            </div>
        </section>
    </main>

    <script>
        // Fetch the data dynamically from PHP
        const students = <?php echo json_encode($students); ?>;
        let currentPage = 1;
        const recordsPerPage = 10;
        let filteredData = students;

        // Filter and Pagination Logic
        function filterLeaderboard() {
            const filterValue = document.getElementById('filter-name').value;
            const filterInput = document.getElementById('filter-input').value.toLowerCase();
            filteredData = students.filter(student => {
                if (filterValue === 'name' && student.name.toLowerCase().includes(filterInput)) {
                    return true;
                }
                if (filterValue === 'college' && student.college.toLowerCase().includes(filterInput)) {
                    return true;
                }
                if (filterValue === 'score' && student.score.toString().includes(filterInput)) {
                    return true;
                }
                if (!filterValue && student.name.toLowerCase().includes(filterInput)) {
                    return true;
                }
                return false;
            });

            currentPage = 1; // Reset to page 1 whenever filtering
            paginate(filteredData);
        }

        // Pagination function
        function paginate(data) {
            const startIndex = (currentPage - 1) * recordsPerPage;
            const endIndex = startIndex + recordsPerPage;
            const paginatedData = data.slice(startIndex, endIndex);

            // Clear table body
            const tableBody = document.getElementById('table-body');
            tableBody.innerHTML = '';

            // Add rows to table
            paginatedData.forEach((student, index) => {
                const row = document.createElement('tr');
                const rank = startIndex + index + 1;
                row.innerHTML = `
                    <td>${rank}</td>
                    <td>${student.name}</td>
                    <td>${student.college}</td>
                    <td>${student.score}</td>
                `;
                tableBody.appendChild(row);
            });

            // Update pagination buttons
            const pageCount = Math.ceil(data.length / recordsPerPage);
            const pageNumbersContainer = document.getElementById('page-numbers');
            pageNumbersContainer.innerHTML = '';

            for (let i = 1; i <= pageCount; i++) {
                const pageButton = document.createElement('button');
                pageButton.innerText = i;
                pageButton.onclick = function () {
                    currentPage = i;
                    paginate(data);
                };
                pageNumbersContainer.appendChild(pageButton);
            }

            document.getElementById('prev-page').disabled = currentPage === 1;
            document.getElementById('next-page').disabled = currentPage === pageCount;
        }

        // Change page logic
        function changePage(direction) {
            const totalPages = Math.ceil(filteredData.length / recordsPerPage);
            if (direction === -1 && currentPage > 1) {
                currentPage--;
            } else if (direction === 1 && currentPage < totalPages) {
                currentPage++;
            }
            paginate(filteredData);
        }

        // Initial pagination setup
        filterLeaderboard();
    </script>
</div>
</body>
</html>
