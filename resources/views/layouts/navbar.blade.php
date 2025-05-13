<header class="bg-white shadow-sm z-40">
    <div class="flex items-center justify-between px-4 py-3 sm:px-6 sm:py-4">
        <div class="flex items-center">
            <!-- Mobile menu button -->
            <button id="mobileMenuBtn" class="mr-4 md:hidden text-gray-500 hover:text-orange-700 transition-all">
                <i data-lucide="menu" class="w-5 h-5"></i>
            </button>
            <!-- Logo for mobile -->
            <div class="md:hidden flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#E65100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-croissant">
                    <path d="m4.6 13.11 5.79-3.21c1.89-1.05 4.79 1.78 3.71 3.71l-3.22 5.81C8.8 23.16.79 15.23 4.6 13.11Z"/>
                    <path d="m10.5 9.5-1-2.29C9.2 6.48 8.8 6 8 6H4.5C2.79 6 2 6.5 2 8.5a7.71 7.71 0 0 0 2 4.83"/>
                    <path d="M8 6c0-1.55.24-4-2-4-2 0-2.5 2.17-2.5 4"/>
                    <path d="m14.5 13.5 2.29 1c.73.3 1.21.7 1.21 1.5v3.5c0 1.71-.5 2.5-2.5 2.5a7.71 7.71 0 0 1-4.83-2"/>
                    <path d="M18 16c1.55 0 4-.24 4 2 0 2-2.17 2.5-4 2.5"/>
                </svg>
                <span class="ml-2 font-bold text-lg">Kifa</span>
            </div>
        </div>
        <div class="flex items-center space-x-3 sm:space-x-4">
            <!-- Notification button -->
            <div class="relative">
                <button class="p-1 rounded-full hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-700 transition-all">
                    <i data-lucide="bell" class="w-5 h-5 text-gray-500"></i>
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                </button>
            </div>
            
            <!-- Profile dropdown -->
            <div class="relative ml-3">
                <div>
                    <button type="button" class="flex items-center focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center">
                            <i data-lucide="user" class="w-4 h-4 text-orange-700"></i>
                        </div>
                        {{-- <span class="ml-2 text-sm font-medium hidden sm:inline">{{auth()->users()->name}}</span> --}}
                        <i data-lucide="chevron-down" class="ml-1 w-4 h-4 text-gray-500 hidden sm:inline transition-transform" id="userDropdownArrow"></i>
                    </button>
                </div>
                
                <!-- Dropdown menu -->
                <div class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 z-50" id="user-dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all" role="menuitem">Profil Anda</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all" role="menuitem">Pengaturan</a>
                    <form id="logout-form">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-all" role="menuitem">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Profile dropdown functionality
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdownMenu = document.getElementById('user-dropdown-menu');
        const userDropdownArrow = document.getElementById('userDropdownArrow');
        
        if (userMenuButton && userDropdownMenu) {
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdownMenu.classList.toggle('hidden');
                if (userDropdownArrow) {
                    userDropdownArrow.classList.toggle('rotate-180');
                }
            });
            
            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!userMenuButton.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.classList.add('hidden');
                    if (userDropdownArrow) {
                        userDropdownArrow.classList.remove('rotate-180');
                    }
                }
            });
        }
    });

    document.getElementById('logout-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        await fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });

        window.location.href = '/'; // Redirect after logout
    });

</script>