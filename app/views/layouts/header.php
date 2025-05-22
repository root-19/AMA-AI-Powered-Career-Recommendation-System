<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="bg-gradient-to-r from-indigo-600 to-purple-600 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <span class="text-xl font-semibold text-white">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                </span>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/dashboard" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md transition duration-150 ease-in-out transform hover:scale-105">
                        Dashboard
                    </a>
                    <!-- <a href="/profile" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md transition duration-150 ease-in-out transform hover:scale-105">
                        Profile
                    </a> -->
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="/admin/dashboard" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md transition duration-150 ease-in-out transform hover:scale-105">
                        Admin Panel
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <a href="" class="flex items-center group">
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center ring-2 ring-white/30 transition duration-150 ease-in-out group-hover:ring-white/50">
                        <span class="text-white text-sm font-medium">
                            <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                        </span>
                    </div>
                </a>
                <form action="/logout" method="POST">
                    <button type="submit" 
                            class="bg-white/10 backdrop-blur-sm text-white px-4 py-2 rounded-lg hover:bg-white/20 transition duration-150 ease-in-out transform hover:scale-105 border border-white/20">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Mobile menu button -->
    <div class="md:hidden">
        <button type="button" class="mobile-menu-button p-2 rounded-md text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-indigo-600 focus:ring-white transition duration-150 ease-in-out">
            <span class="sr-only">Open menu</span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</nav>

<!-- Mobile menu -->
<div class="md:hidden hidden mobile-menu bg-gradient-to-b from-indigo-600 to-purple-600">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
        <a href="/dashboard" class="text-white hover:bg-white/10 block px-3 py-2 rounded-md transition duration-150 ease-in-out">
            Dashboard
        </a>
        <a href="/profile" class="text-white hover:bg-white/10 block px-3 py-2 rounded-md transition duration-150 ease-in-out">
            Profile
        </a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="/admin/dashboard" class="text-white hover:bg-white/10 block px-3 py-2 rounded-md transition duration-150 ease-in-out">
            Admin Panel
        </a>
        <?php endif; ?>
    </div>
</div>

<script>
// Mobile menu toggle with smooth animation
document.querySelector('.mobile-menu-button').addEventListener('click', function() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.classList.toggle('hidden');
    if (!mobileMenu.classList.contains('hidden')) {
        mobileMenu.style.opacity = '0';
        mobileMenu.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            mobileMenu.style.opacity = '1';
            mobileMenu.style.transform = 'translateY(0)';
        }, 10);
    }
});
</script> 