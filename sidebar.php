<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
?>
<aside class="fixed top-0 left-0 h-full w-60 bg-white border-r border-orange-100 flex flex-col justify-between z-40 shadow-lg">
    <div>
        <div class="flex items-center justify-center h-20 border-b border-orange-100">
            <span class="text-2xl font-bold text-orange-500">EventHive</span>
        </div>
        <nav class="mt-6">
            <ul class="flex flex-col gap-2 px-4">
                <li><a href="index.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 font-medium text-gray-700"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="events.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 font-medium text-gray-700"><i class="fa fa-calendar"></i> Events</a></li>

                <?php if ($userType === 'admin'): ?>
                    <li><a href="admin-your-events.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 font-medium text-gray-700"><i class="fa fa-tasks"></i> Manage Events</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <div class="px-4 py-6 border-t border-orange-100">
        <?php if ($userType && $userName): ?>
            <div class="mb-3 text-sm text-gray-700">
                <div class="font-semibold">Logged in as:</div>
                <div class="flex items-center gap-2 mt-1">
                    <span class="inline-block bg-orange-100 text-orange-600 px-2 py-1 rounded text-xs font-medium">
                        <?= htmlspecialchars($userName) ?>
                    </span>
                    <span class="inline-block bg-gray-100 text-gray-500 px-2 py-1 rounded text-xs font-medium">
                        <?= htmlspecialchars(ucfirst($userType)) ?>
                    </span>
                </div>
            </div>
            <a href="logout.php" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition">Sign Out</a>
        <?php else: ?>
            <div class="mb-3 text-sm text-gray-700">
                <div class="font-semibold">Not signed in</div>
            </div>
            <a href="login.php" class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition mb-2">Sign In</a>
            <a href="register.php" class="block w-full text-center bg-orange-100 hover:bg-orange-200 text-orange-600 font-semibold py-2 rounded-lg transition">Sign Up</a>
        <?php endif; ?>
    </div>
</aside>
