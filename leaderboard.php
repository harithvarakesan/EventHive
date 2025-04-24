<?php
include './header.php';
include './operations/db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get leaderboard: participants with positive scores, ordered by score desc
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

<?php $pageTitle = "Event Leaderboard"; include 'header.php'; ?>
  <div class="flex-1 min-h-screen py-8 pr-6">
    <div class="w-full max-w-[200%] bg-neutral-50 rounded-2xl shadow-2xl p-12 dashboard-widget text-lg" style="max-width:200%;">
  <div class="flex items-center gap-4 mb-8">
    <h2 class="text-4xl font-extrabold text-gray-900 flex items-center gap-2">
      <i data-lucide="trophy" class="w-8 h-8 text-orange-500"></i>
      Leaderboard
    </h2>
  </div>
  <hr class="border-orange-100 mb-8">
  <div class="w-full flex flex-col md:flex-row md:items-center gap-4 mb-8">
    <div class="flex-1 flex items-center gap-3 bg-orange-50 border border-orange-200 rounded-xl px-4 py-3">
      <i data-lucide="search" class="w-5 h-5 text-orange-400"></i>
      <input id="filter-input" type="text" placeholder="Search participants..." class="flex-1 bg-transparent outline-none text-base text-gray-700 placeholder:text-orange-300" oninput="filterLeaderboard()" />
      <button type="button" onclick="document.getElementById('filter-input').value=''; filterLeaderboard();" class="text-orange-400 hover:text-orange-600 focus:outline-none" title="Clear search"><i data-lucide="x-circle" class="w-5 h-5"></i></button>
      <select id="filter-name" onchange="filterLeaderboard()" class="ml-2 bg-white border border-orange-200 rounded px-2 py-1 text-base text-orange-600">
        <option value="">Select</option>
        <option value="name">Name</option>
        <option value="college">College</option>
        <option value="score">Score</option>
      </select>
    </div>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full text-base rounded-xl" aria-label="Leaderboard">
      <thead>
        <tr class="bg-orange-100 text-orange-600">
          <th class="py-4 px-6 font-semibold text-left rounded-tl-xl" aria-label="Rank">Rank <i data-lucide="chevrons-up-down" class="inline w-5 h-5 align-middle"></i></th>
          <th class="py-4 px-6 font-semibold text-left" aria-label="Participant">Participant</th>
          <th class="py-4 px-6 font-semibold text-left" aria-label="College">College</th>
          <th class="py-4 px-6 font-semibold text-left" aria-label="Score">Score</th>
        </tr>
      </thead>
      <tbody id="table-body"></tbody>
    </table>
  </div>
  <div id="pagination" class="flex gap-2 justify-center items-center mt-6">
    <button id="prev-page" onclick="changePage(-1)" class="px-4 py-2 rounded bg-orange-100 text-orange-600 font-semibold hover:bg-orange-200">Previous</button>
    <div id="page-numbers" class="flex gap-1"></div>
    <button id="next-page" onclick="changePage(1)" class="px-4 py-2 rounded bg-orange-100 text-orange-600 font-semibold hover:bg-orange-200">Next</button>
  </div>

    <script>
      // Leaderboard data from PHP
      const students = <?php echo json_encode(array_map(function($s) {
        return [
          'id' => $s['id'],
          'name' => htmlspecialchars($s['name'], ENT_QUOTES),
          'college' => htmlspecialchars($s['college'], ENT_QUOTES),
          'score' => (int)$s['score']
        ];
      }, $students)); ?>;
      const loggedInUser = <?php echo isset($_SESSION['user_name']) ? json_encode(htmlspecialchars($_SESSION['user_name'], ENT_QUOTES)) : 'null'; ?>;
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
            <div class="overflow-x-auto">
              <table id="leaderboard" class="min-w-full text-base rounded-xl">
                <thead>
                  <tr class="bg-orange-100 text-orange-600">
                    <th class="py-4 px-6 font-semibold text-left rounded-tl-xl">Rank</th>
                    <th class="py-4 px-6 font-semibold text-left">Name</th>
                    <th class="py-4 px-6 font-semibold text-left">College</th>
                    <th class="py-4 px-6 font-semibold text-left rounded-tr-xl">Score</th>
                  </tr>
                </thead>
                <tbody id="table-body">
                  <!-- Dynamic rows will go here -->
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
            <div id="pagination" class="flex gap-2 justify-center items-center mt-6">
              <button id="prev-page" onclick="changePage(-1)" class="px-4 py-2 rounded bg-orange-100 text-orange-600 font-semibold hover:bg-orange-200">Previous</button>
              <div id="page-numbers" class="flex gap-1"></div>
              <button id="next-page" onclick="changePage(1)" class="px-4 py-2 rounded bg-orange-100 text-orange-600 font-semibold hover:bg-orange-200">Next</button>
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
                // Highlight the logged-in user's row
                <?php if (isset($_SESSION['user_name'])): ?>
                if (student.name === <?php echo json_encode($_SESSION['user_name']); ?>) {
                  row.classList.add('highlight-row');
                }
                <?php endif; ?>
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
</div>
</body>
</html>
