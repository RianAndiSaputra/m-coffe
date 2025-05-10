<div class="sidebar bg-white text-gray-800 flex flex-col" id="sidebar">
    <!-- Logo -->
    <div class="p-4 flex items-center justify-between">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-croissant text-black sidebar-icon">
                <path d="m4.6 13.11 5.79-3.21c1.89-1.05 4.79 1.78 3.71 3.71l-3.22 5.81C8.8 23.16.79 15.23 4.6 13.11Z"/>
                <path d="m10.5 9.5-1-2.29C9.2 6.48 8.8 6 8 6H4.5C2.79 6 2 6.5 2 8.5a7.71 7.71 0 0 0 2 4.83"/>
                <path d="M8 6c0-1.55.24-4-2-4-2 0-2.5 2.17-2.5 4"/>
                <path d="m14.5 13.5 2.29 1c.73.3 1.21.7 1.21 1.5v3.5c0 1.71-.5 2.5-2.5 2.5a7.71 7.71 0 0 1-4.83-2"/>
                <path d="M18 16c1.55 0 4-.24 4 2 0 2-2.17 2.5-4 2.5"/>
            </svg>
            <span class="ml-2 font-bold text-xl whitespace-nowrap sidebar-text">Kifa Bakery</span>
        </div>
        <button id="toggleSidebarBtn" class="text-gray-500 hover:text-black hidden md:block transition-all">
            <i data-lucide="chevrons-left" class="w-5 h-5 sidebar-toggle-icon text-black" id="toggleIcon"></i>
        </button>
    </div>

    <!-- Outlet Dropdown -->
    <div class="px-4 py-3">
        <div class="relative">
            <button id="outletDropdownButton" class="w-full flex items-center justify-between px-3 py-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                <div class="flex items-center">
                    <i data-lucide="store" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 font-medium truncate sidebar-text">Kifa Bakery Pusat</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform sidebar-text sidebar-dropdown-arrow text-black" id="outletDropdownArrow"></i>
            </button>
            
            <!-- Outlet Dropdown Menu -->
            <div id="outletDropdown" class="hidden absolute left-0 right-0 mt-1 bg-white rounded-lg shadow-lg z-50 border border-gray-200 max-h-60 overflow-y-auto sidebar-dropdown">
                <!-- Search Box -->
                <div class="p-2 border-b">
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                        <input type="text" placeholder="Cari outlet..." class="w-full pl-9 pr-3 py-2 text-sm border rounded-lg focus:ring-1 focus:ring-orange-700 focus:border-orange-700">
                    </div>
                </div>
                
                <!-- Outlet List -->
                <ul class="py-1">
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <span class="truncate">Kifa Bakery Pusat</span>
                            <i data-lucide="check" class="w-4 h-4 ml-2 text-black"></i>
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
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <span class="truncate">Kifa Bakery Cabang C</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <span class="truncate">Kifa Bakery Cabang D</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto py-4 border-t">
        <div class="px-4 py-2 active-menu">
            <a href="{{ route('dashboard') }}" class="flex items-center whitespace-nowrap">
                <i data-lucide="layout-dashboard" class="w-5 h-5 min-w-[20px] text-black sidebar-icon"></i>
                <span class="ml-3 sidebar-text">Dashboard</span>
            </a>
        </div>
        
        <!-- Product Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all">
            <button id="productDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="package" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Produk</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="productDropdownArrow"></i>
            </button>
            <div id="productDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="list" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Daftar Produk</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="tag" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Kategori</span>
                </a>
            </div>
        </div>

        <!-- Outlet Management Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all">
            <button id="outletManagementDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="building-2" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Outlet</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="outletManagementDropdownArrow"></i>
            </button>
            <div id="outletManagementDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="list" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Daftar Outlet</span>
                </a>
            </div>
        </div>
        
        <!-- Stock Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all">
            <button id="stockDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="package-open" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Stok</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="stockDropdownArrow"></i>
            </button>
            <div id="stockDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="history" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Riwayat Stok</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="calendar" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Stok Pertanggal</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="edit" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Penyesuaian Stok</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="truck" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Transfer Stok</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Approve Stok</span>
                </a>
            </div>
        </div>

        <!-- User Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all">
            <button id="userDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="users" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">User</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="userDropdownArrow"></i>
            </button>
            <div id="userDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="user" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Member</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="users" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Staff</span>
                </a>
            </div>
        </div>

        <!-- Closing Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all">
            <button id="closingDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="clock" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Closing</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="closingDropdownArrow"></i>
            </button>
            <div id="closingDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="wallet" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Riwayat Kas</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="receipt" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Riwayat Transaksi</span>
                </a>
            </div>
        </div>

        <!-- Report Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all">
            <button id="reportDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Laporan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="reportDropdownArrow"></i>
            </button>
            <div id="reportDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="calendar" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Perhari</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="box" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Per Item</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="tag" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Per Kategori</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="user" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Per Member</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="package" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Stock</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="history" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Riwayat Stok</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Approve</span>
                </a>
            </div>
        </div>

        <!-- Settings Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all">
            <button id="settingsDropdownButton" class="w-full flex items-center justify-between">
                <div class="flex items-center">
                    <i data-lucide="settings" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Pengaturan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="settingsDropdownArrow"></i>
            </button>
            <div id="settingsDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all">
                    <i data-lucide="printer" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Template Print</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Collapse Button -->
    <div class="p-4 border-t flex justify-center">
        <button id="toggleSidebar" class="text-gray-500 hover:text-black transition-all">
            <i data-lucide="chevrons-left" class="w-5 h-5 sidebar-toggle-icon text-black" id="bottomToggleIcon"></i>
        </button>
    </div>
</div>

<style>
    /* Sidebar collapsed state styles */
    .sidebar.collapsed {
        width: 80px;
    }
    
    .sidebar.collapsed .sidebar-text {
        display: none;
    }
    
    .sidebar.collapsed .sidebar-dropdown-arrow {
        display: none;
    }
    
    .sidebar.collapsed .sidebar-dropdown {
        display: none !important;
    }
    
    .sidebar.collapsed .sidebar-icon {
        margin-left: auto;
        margin-right: auto;
    }
    
    .sidebar.collapsed .px-4 {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .sidebar.collapsed .flex.items-center {
        justify-content: center;
    }
    
    .sidebar.collapsed .pl-8 {
        padding-left: 0;
    }
    
    /* Active menu in collapsed state */
    .sidebar.collapsed .active-menu {
        border-left: none;
        background-color: #f3f4f6;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Outlet dropdown functionality
        const outletDropdownButton = document.getElementById('outletDropdownButton');
        const outletDropdown = document.getElementById('outletDropdown');
        const outletDropdownArrow = document.getElementById('outletDropdownArrow');
        
        if (outletDropdownButton && outletDropdown) {
            outletDropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                // Don't open dropdown if sidebar is collapsed
                if (document.getElementById('sidebar').classList.contains('collapsed')) return;
                
                outletDropdown.classList.toggle('hidden');
                outletDropdownArrow.classList.toggle('rotate-180');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                outletDropdown.classList.add('hidden');
                outletDropdownArrow.classList.remove('rotate-180');
            });
            
            // Prevent dropdown from closing when clicking inside
            outletDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // Search functionality
            const searchInput = outletDropdown.querySelector('input');
            const outletItems = outletDropdown.querySelectorAll('li');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                outletItems.forEach(item => {
                    const outletName = item.querySelector('span').textContent.toLowerCase();
                    if (outletName.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Setup all dropdown menus
        const dropdownButtons = [
            'productDropdownButton',
            'outletManagementDropdownButton',
            'stockDropdownButton',
            'userDropdownButton',
            'closingDropdownButton',
            'reportDropdownButton',
            'settingsDropdownButton'
        ];
        
        function closeAllDropdowns() {
            dropdownButtons.forEach(buttonId => {
                const dropdown = document.getElementById(buttonId.replace('Button', ''));
                const arrow = document.getElementById(buttonId.replace('Button', 'Arrow'));
                
                if (dropdown) {
                    dropdown.classList.add('hidden');
                }
                
                if (arrow) {
                    arrow.classList.remove('rotate-180');
                }
            });
            
            // Also close outlet dropdown
            if (outletDropdown) {
                outletDropdown.classList.add('hidden');
                if (outletDropdownArrow) {
                    outletDropdownArrow.classList.remove('rotate-180');
                }
            }
        }
        
        dropdownButtons.forEach(buttonId => {
            const button = document.getElementById(buttonId);
            const dropdown = document.getElementById(buttonId.replace('Button', ''));
            const arrow = document.getElementById(buttonId.replace('Button', 'Arrow'));
            
            if (button && dropdown) {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Don't open dropdown if sidebar is collapsed
                    if (document.getElementById('sidebar').classList.contains('collapsed')) return;
                    
                    // Close all other dropdowns first
                    closeAllDropdowns();
                    
                    // Open current dropdown
                    dropdown.classList.remove('hidden');
                    if (arrow) {
                        arrow.classList.add('rotate-180');
                    }
                });
            }
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            closeAllDropdowns();
        });
    });
</script>