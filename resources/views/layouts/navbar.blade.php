<header class="bg-white shadow-sm z-10">
    <div class="flex items-center justify-between px-4 py-3 sm:px-6 sm:py-4">
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button id="mobileMenuBtn" class="mr-4 md:hidden">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
        </div>
        <div class="flex items-center space-x-3 sm:space-x-4">
            <!-- Notification button -->
            <div class="relative">
                <button class="p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i data-lucide="bell" class="w-5 h-5 text-gray-500"></i>
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                </button>
            </div>
            
            <!-- Profile dropdown -->
            <div class="relative ml-3">
                <div>
                    <button type="button" class="flex items-center focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center">
                            <i data-lucide="user" class="w-4 h-4 text-orange-500"></i>
                        </div>
                        <span class="ml-2 text-sm font-medium hidden sm:inline">Admin</span>
                        <i data-lucide="chevron-down" class="ml-1 w-4 h-4 text-gray-500 hidden sm:inline"></i>
                    </button>
                </div>
                
                <!-- Dropdown menu -->
                <div class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 z-50" id="user-dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>
                    <form method="POST" action="/logout" id="logout-form">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle dropdown menu
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdownMenu = document.getElementById('user-dropdown-menu');
        
        if (userMenuButton && userDropdownMenu) {
            userMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();
                userDropdownMenu.classList.toggle('hidden');
                
                // Close when clicking outside
                document.addEventListener('click', function closeMenu(e) {
                    if (!userDropdownMenu.contains(e.target) {
                        userDropdownMenu.classList.add('hidden');
                        document.removeEventListener('click', closeMenu);
                    }
                });
            });
        }
    });
</script>