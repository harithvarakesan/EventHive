<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include '../operations/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "
    SELECT u.id AS user_id, u.name, u.college, SUM(GREATEST(p.mark,0)) AS score
    FROM participant p
    JOIN user u ON p.participant_id = u.id
    GROUP BY u.id, u.name, u.college
    HAVING score > 0
    ORDER BY score DESC, u.name ASC
";
$result = $conn->query($sql);
$students = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = [
            'id' => $row['user_id'],
            'name' => $row['name'],
            'college' => $row['college'],
            'score' => (int)$row['score']
        ];
    }
}
$conn->close();
?>

<?php $pageTitle = "Leaderboard - EventHive"; include '../header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $pageTitle; ?></title>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <main class="container mx-auto py-10 px-4">
        <div class="bg-white shadow-xl rounded-2xl p-8">
            <h1 class="text-4xl font-bold mb-6 flex items-center gap-3">
                <i data-lucide="trophy" class="text-orange-500 w-8 h-8"></i>
                Leaderboard
            </h1>

            <!-- Filter Controls -->
            <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
                <input type="text" id="filter-input" placeholder="Search participants..." class="flex-1 border border-orange-300 px-4 py-2 rounded-md" oninput="filterLeaderboard()" />
                <select id="filter-name" onchange="filterLeaderboard()" class="border border-orange-300 px-4 py-2 rounded-md">
                    <option value="">Filter by</option>
                    <option value="name">Name</option>
                    <option value="college">College</option>
                    <option value="score">Score</option>
                </select>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border border-orange-200 rounded-xl overflow-hidden">
                    <thead class="bg-orange-100 text-orange-600">
                        <tr>
                            <th class="px-6 py-4">Rank</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">College</th>
                            <th class="px-6 py-4">Score</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="bg-white">
                        <!-- JS will populate -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center items-center gap-4 mt-6">
                <button id="prev-page" onclick="changePage(-1)" class="bg-orange-100 px-4 py-2 rounded-md text-orange-600 hover:bg-orange-200">Previous</button>
                <div id="page-numbers" class="flex gap-2"></div>
                <button id="next-page" onclick="changePage(1)" class="bg-orange-100 px-4 py-2 rounded-md text-orange-600 hover:bg-orange-200">Next</button>
            </div>
        </div>
    </main>

    <script>
        const students = <?php echo json_encode($students); ?>;
        const loggedInUser = <?php echo isset($_SESSION['user_name']) ? json_encode($_SESSION['user_name']) : 'null'; ?>;
        let currentPage = 1;
        const recordsPerPage = 10;
        let filteredData = students;

        function filterLeaderboard() {
            const filterValue = document.getElementById('filter-name').value;
            const filterInput = document.getElementById('filter-input').value.toLowerCase();
            filteredData = students.filter(student => {
                if (filterValue === 'name' && student.name.toLowerCase().includes(filterInput)) return true;
                if (filterValue === 'college' && student.college.toLowerCase().includes(filterInput)) return true;
                if (filterValue === 'score' && student.score.toString().includes(filterInput)) return true;
                if (!filterValue && student.name.toLowerCase().includes(filterInput)) return true;
                return false;
            });
            currentPage = 1;
            paginate(filteredData);
        }

        function paginate(data) {
            const start = (currentPage - 1) * recordsPerPage;
            const end = start + recordsPerPage;
            const paginatedData = data.slice(start, end);
            const tableBody = document.getElementById('table-body');
            tableBody.innerHTML = '';

            paginatedData.forEach((student, index) => {
                const row = document.createElement('tr');
                const rank = start + index + 1;
                row.className = (student.name === loggedInUser) ? 'bg-yellow-100 font-semibold' : '';
                row.innerHTML = `
                    <td class="px-6 py-4">${rank}</td>
                    <td class="px-6 py-4">${student.name}</td>
                    <td class="px-6 py-4">${student.college}</td>
                    <td class="px-6 py-4">${student.score}</td>
                `;
                tableBody.appendChild(row);
            });

            // Pagination
            const pageCount = Math.ceil(data.length / recordsPerPage);
            const pageNumbers = document.getElementById('page-numbers');
            pageNumbers.innerHTML = '';
            for (let i = 1; i <= pageCount; i++) {
                const btn = document.createElement('button');
                btn.textContent = i;
                btn.className = `px-3 py-1 rounded ${i === currentPage ? 'bg-orange-400 text-white' : 'bg-orange-100 text-orange-600'} hover:bg-orange-200`;
                btn.onclick = () => { currentPage = i; paginate(filteredData); };
                pageNumbers.appendChild(btn);
            }

            document.getElementById('prev-page').disabled = currentPage === 1;
            document.getElementById('next-page').disabled = currentPage === pageCount;
        }

        function changePage(dir) {
            const totalPages = Math.ceil(filteredData.length / recordsPerPage);
            if ((dir === -1 && currentPage > 1) || (dir === 1 && currentPage < totalPages)) {
                currentPage += dir;
                paginate(filteredData);
            }
        }

        filterLeaderboard();
    </script>
    <script>lucide.createIcons();</script>
</body>
</html>
