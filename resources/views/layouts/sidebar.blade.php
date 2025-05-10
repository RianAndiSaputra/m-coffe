<!-- layouts/sidebar.blade.php -->
<div class="sidebar bg-white text-gray-800 flex flex-col transition-all duration-300 ease-in-out" id="sidebar">
    <!-- Logo dan Toggle Button -->
    <div class="p-4 flex items-center justify-between border-b">
        <div class="flex items-center min-w-[32px]">
            <!-- Logo Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FF6B00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-croissant">
                <path d="m4.6 13.11 5.79-3.21c1.89-1.05 4.79 1.78 3.71 3.71l-3.22 5.81C8.8 23.16.79 15.23 4.6 13.11Z"/>
                <path d="m10.5 9.5-1-2.29C9.2 6.48 8.8 6 8 6H4.5C2.79 6 2 6.5 2 8.5a7.71 7.71 0 0 0 2 4.83"/>
                <path d="M8 6c0-1.55.24-4-2-4-2 0-2.5 2.17-2.5 4"/>
                <path d="m14.5 13.5 2.29 1c.73.3 1.21.7 1.21 1.5v3.5c0 1.71-.5 2.5-2.5 2.5a7.71 7.71 0 0 1-4.83-2"/>
                <path d="M18 16c1.55 0 4-.24 4 2 0 2-2.17 2.5-4 2.5"/>
            </svg>
            <!-- Logo Text -->
            <span class="ml-2 font-bold text-xl whitespace-nowrap transition-opacity duration-300 sidebar-text">Kifa Bakery</span>
        </div>
        <!-- Desktop Toggle Button -->
        <button id="toggleSidebarBtn" class="text-gray-500 hover:text-orange-500 hidden md:block">
            <i data-lucide="chevron-left" class="w-5 h-5 transition-transform duration-300" id="toggleIcon"></i>
        </button>
    </div>

    <!-- Outlet Dropdown -->
    <div class="px-4 py-3">
        <div class="relative">
            <button id="outletDropdownButton" class="w-full flex items-center justify-between px-3 py-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                <div class="flex items-center">
                    <i data-lucide="store" class="w-4 h-4 text-orange-500 mr-2"></i>
                    <span class="font-medium truncate sidebar-text">Kifa Bakery Pusat</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform sidebar-text" id="outletDropdownArrow"></i>
            </button>
            
            <!-- Outlet Dropdown Menu -->
            <div id="outletDropdown" class="hidden absolute left-0 right-0 mt-1 bg-white rounded-lg shadow-lg z-30 border border-gray-200 max-h-60 overflow-y-auto">
                <!-- Search Box -->
                <div class="p-2 border-b">
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" placeholder="Cari outlet..." class="w-full pl-9 pr-3 py-2 text-sm border rounded-lg focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>
                
                <!-- Outlet List -->
                <ul class="py-1">
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <span class="truncate">Kifa Bakery Pusat</span>
                            <i data-lucide="check" class="w-4 h-4 ml-2 text-orange-500"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <span class="truncate">Kifa Bakery Cabang A</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <span class="truncate">Kifa Bakery Cabang B</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Menu Navigation -->
    <nav class="flex-1 overflow-y-auto py-4 border-t">
        <!-- Dashboard -->
        <div class="px-4 py-2 active-menu">
            <a href="{{ route('dashboard') }}" class="flex items-center whitespace-nowrap">
                <i data-lucide="layout-dashboard" class="w-5 h-5 min-w-[20px]"></i>
                <span class="ml-3 sidebar-text">Dashboard</span>
            </a>
        </div>
        
        <!-- Penjualan -->
        <div class="px-4 py-2 hover:bg-gray-100">
            <a href="#" class="flex items-center">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                <span class="ml-3 sidebar-text">Penjualan</span>
            </a>
        </div>

        <!-- Produk Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 dropdown-container">
            <button id="productDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">Produk</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform sidebar-text" id="productDropdownArrow"></i>
            </button>
            <div id="productDropdown" class="hidden pl-8 mt-2 dropdown-content">
                <a href="#" class="flex items-center py-2 hover:text-orange-500">
                    <i data-lucide="list" class="w-4 h-4 mr-2"></i>
                    <span class="sidebar-text">Daftar Produk</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-500">
                    <i data-lucide="tag" class="w-4 h-4 mr-2"></i>
                    <span class="sidebar-text">Kategori</span>
                </a>
            </div>
        </div>

        <!-- Stok Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 dropdown-container">
            <button id="stockDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="package-open" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">Stok</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform sidebar-text" id="stockDropdownArrow"></i>
            </button>
            <div id="stockDropdown" class="hidden pl-8 mt-2 dropdown-content">
                <a href="#" class="flex items-center py-2 hover:text-orange-500">
                    <i data-lucide="history" class="w-4 h-4 mr-2"></i>
                    <span class="sidebar-text">Riwayat Stok</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-500">
                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                    <span class="sidebar-text">Stok Pertanggal</span>
                </a>
            </div>
        </div>

        <!-- User Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 dropdown-container">
            <button id="userDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">User</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform sidebar-text" id="userDropdownArrow"></i>
            </button>
            <div id="userDropdown" class="hidden pl-8 mt-2 dropdown-content">
                <a href="#" class="flex items-center py-2 hover:text-orange-500">
                    <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                    <span class="sidebar-text">Member</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-500">
                    <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                    <span class="sidebar-text">Staff</span>
                </a>
            </div>
        </div>

        <!-- Laporan Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 dropdown-container">
            <button id="reportDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span class="ml-3 sidebar-text">Laporan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform sidebar-text" id="reportDropdownArrow"></i>
            </button>
            <div id="reportDropdown" class="hidden pl-8 mt-2 dropdown-content">
                <a href="#" class="flex items-center py-2 hover:text-orange-500">
                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                    <span class="sidebar-text">Perhari</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-500">
                    <i data-lucide="box" class="w-4 h-4 mr-2"></i>
                    <span class="sidebar-text">Per Item</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Collapse Button Bottom -->
    <div class="p-4 border-t flex justify-center">
        <button id="toggleSidebar" class="text-gray-500 hover:text-orange-500">
            <i data-lucide="chevron-left" class="w-5 h-5 transition-transform duration-300" id="bottomToggleIcon"></i>
        </button>
    </div>
</div>

<style>
    /* Sidebar Base Styles */
    .sidebar {
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 40;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        overflow-y: auto;
    }

    /* Collapsed State */
    .sidebar.collapsed {
        width: 70px;
    }

    /* Rotate Toggle Icons */
    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Active Menu Styling */
    .active-menu {
        background-color: #FFF7ED;
        color: #FF6B00;
        border-radius: 0.375rem;
    }

    /* Sidebar Text Transition */
    .sidebar-text {
        transition: opacity 0.2s ease, width 0.2s ease;
        display: inline-block;
        overflow: hidden;
    }

    /* Hide Text When Collapsed */
    .sidebar.collapsed .sidebar-text {
        opacity: 0;
        width: 0;
        margin-left: 0;
        margin-right: 0;
    }

    /* Dropdown Arrows */
    .sidebar.collapsed [id$="DropdownArrow"] {
        display: none;
    }

    /* Dropdown Content When Collapsed */
    .sidebar.collapsed .dropdown-content {
        position: absolute;
        left: 70px;
        background: white;
        min-width: 200px;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        z-index: 50;
        padding-left: 0;
    }

    /* Center Icons When Collapsed */
    .sidebar.collapsed .px-4 {
        padding-left: 1rem;
        padding-right: 1rem;
        justify-content: center;
    }

    /* Mobile Responsive */
    @media (max-width: 767px) {
        /* Default Mobile State - Collapsed */
        .sidebar {
            width: 70px;
            transform: translateX(0);
        }
        
        /* Expanded State on Mobile */
        .sidebar:not(.collapsed) {
            width: 280px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 50;
        }
        
        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Sidebar Elements
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const toggleIcon = document.getElementById('toggleIcon');
        const bottomToggleIcon = document.getElementById('bottomToggleIcon');
        const sidebarTextElements = document.querySelectorAll('.sidebar-text');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        // Check localStorage for sidebar state
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            toggleSidebarState();
        }
        
        // Toggle Sidebar State
        function toggleSidebarState() {
            sidebar.classList.toggle('collapsed');
            const isCollapsedNow = sidebar.classList.contains('collapsed');
            
            // Save state to localStorage
            localStorage.setItem('sidebarCollapsed', isCollapsedNow);
            
            // Toggle text elements
            sidebarTextElements.forEach(el => {
                el.classList.toggle('hidden');
            });
            
            // Rotate toggle icons
            toggleIcon.classList.toggle('rotate-180');
            bottomToggleIcon.classList.toggle('rotate-180');
            
            // Close all dropdowns when sidebar is collapsed
            closeAllDropdowns();
        }
        
        // Event Listeners for Toggle Buttons
        if (toggleSidebarBtn) {
            toggleSidebarBtn.addEventListener('click', toggleSidebarState);
        }
        
        if (toggleSidebar) {
            toggleSidebar.addEventListener('click', toggleSidebarState);
        }
        
        // Mobile Menu Button
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-show');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.toggle('active');
                }
            });
        }
        
        // Close Sidebar When Clicking Overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-show');
                sidebarOverlay.classList.remove('active');
            });
        }
        
        // Outlet Dropdown Functionality
        const outletDropdownButton = document.getElementById('outletDropdownButton');
        const outletDropdown = document.getElementById('outletDropdown');
        const outletDropdownArrow = document.getElementById('outletDropdownArrow');
        
        if (outletDropdownButton && outletDropdown) {
            outletDropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                
                // If sidebar is collapsed, expand it first
                if (sidebar.classList.contains('collapsed')) {
                    toggleSidebarState();
                    return;
                }
                
                outletDropdown.classList.toggle('hidden');
                outletDropdownArrow.classList.toggle('rotate-180');
            });
            
            // Close when clicking outside
            document.addEventListener('click', function() {
                outletDropdown.classList.add('hidden');
                outletDropdownArrow.classList.remove('rotate-180');
            });
            
            // Prevent dropdown from closing when clicking inside
            outletDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Setup All Dropdown Menus
        const dropdownButtons = [
            'productDropdownButton',
            'stockDropdownButton',
            'userDropdownButton',
            'reportDropdownButton'
        ];
        
        // Close All Dropdowns
        function closeAllDropdowns() {
            document.querySelectorAll('.dropdown-content').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
            
            document.querySelectorAll('[id$="DropdownArrow"]').forEach(arrow => {
                arrow.classList.remove('rotate-180');
            });
        }
        
        // Initialize Dropdown Buttons
        dropdownButtons.forEach(buttonId => {
            const button = document.getElementById(buttonId);
            const dropdown = document.getElementById(buttonId.replace('Button', ''));
            const arrow = document.getElementById(buttonId.replace('Button', 'Arrow'));
            
            if (button && dropdown) {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    // If sidebar is collapsed, expand it first
                    if (sidebar.classList.contains('collapsed')) {
                        toggleSidebarState();
                        return;
                    }
                    
                    // Toggle current dropdown
                    const isHidden = dropdown.classList.contains('hidden');
                    closeAllDropdowns();
                    
                    if (isHidden) {
                        dropdown.classList.remove('hidden');
                        if (arrow) arrow.classList.add('rotate-180');
                    }
                });
            }
        });
        
        // Close Dropdowns When Clicking Outside
        document.addEventListener('click', closeAllDropdowns);
        
        // Handle Window Resize
        function handleResize() {
            if (window.innerWidth > 768) {
                // On desktop, ensure sidebar is visible
                sidebar.classList.remove('mobile-show');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.remove('active');
                }
            }
        }
        
        window.addEventListener('resize', handleResize);
    });
</script>