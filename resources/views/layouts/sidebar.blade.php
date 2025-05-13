<div class="sidebar bg-white text-gray-800 flex flex-col" id="sidebar">
    <!-- Logo -->
            <div class="p-4 flex items-center justify-between">
        <div class="flex items-center">
            <img src="/images/logo.png" alt="Kifa Bakery Logo" class="w-14 h-14 object-contain sidebar-icon" />
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
         <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all menu-item">
           <a href="/dashboard" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </div>

        <!-- Product Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all menu-item" data-dropdown="productDropdown">
            <div class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="package" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Produk</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="productDropdownArrow"></i>
            </div>
            <div id="productDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="/list-produk" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="list" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Daftar Produk</span>
                </a>
                <a href="/kategori" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="tag" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Kategori</span>
                </a>
            </div>
        </div>

        <!-- Outlet Management Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all menu-item" data-dropdown="outletManagementDropdown">
            <div class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="building-2" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Outlet</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="outletManagementDropdownArrow"></i>
            </div>
            <div id="outletManagementDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="/outlet" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="list" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Daftar Outlet</span>
                </a>
            </div>
        </div>
        
        <!-- Stock Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all menu-item" data-dropdown="stockDropdown">
            <div class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="package-open" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Stok</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="stockDropdownArrow"></i>
            </div>
            <div id="stockDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="/riwayat-stok" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="history" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Riwayat Stok</span>
                </a>
                <a href="/stok-per-tanggal" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="calendar" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Stok Pertanggal</span>
                </a>
                <a href="penyesuaian-stok" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="edit" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Penyesuaian Stok</span>
                </a>
                <a href="/transfer-stok" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="truck" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Transfer Stok</span>
                </a>
                <a href="/approve-stok" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Approve Stok</span>
                </a>
            </div>
        </div>

        <!-- User Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all menu-item" data-dropdown="userDropdown">
            <div class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="users" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">User</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="userDropdownArrow"></i>
            </div>
            <div id="userDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="/member" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="user" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Member</span>
                </a>
                <a href="#" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="users" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Staff</span>
                </a>
            </div>
        </div>

        <!-- Closing Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all menu-item" data-dropdown="closingDropdown">
            <div class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="clock" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Closing</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="closingDropdownArrow"></i>
            </div>
            <div id="closingDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="/riwayat-kas" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="wallet" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Riwayat Kas</span>
                </a>
                <a href="/riwayat-transaksi" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="receipt" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Riwayat Transaksi</span>
                </a>
            </div>
        </div>

        <!-- Report Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all menu-item" data-dropdown="reportDropdown">
            <div class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Laporan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="reportDropdownArrow"></i>
            </div>
            <div id="reportDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="/perhari" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="calendar" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Perhari</span>
                </a>
                <a href="/per-item" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="box" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Per Item</span>
                </a>
                <a href="/per-kategori" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="tag" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Per Kategori</span>
                </a>
                <a href="/per-member" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="user" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Per Member</span>
                </a>
                <a href="/stok" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="package" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Stock</span>
                </a>
                <a href="/laporan-riwayat-stok" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="history" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Riwayat Stok</span>
                </a>
                <a href="/laporan-approve" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                    <span class="sidebar-text">Approve</span>
                </a>
            </div>
        </div>

        <!-- Settings Dropdown -->
        <div class="px-4 py-2 hover:bg-gray-100 group rounded-lg transition-all menu-item" data-dropdown="settingsDropdown">
            <div class="flex items-center justify-between cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="settings" class="w-5 h-5 text-black sidebar-icon"></i>
                    <span class="ml-3 sidebar-text">Pengaturan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-black transition-transform sidebar-text sidebar-dropdown-arrow group-hover:text-black" id="settingsDropdownArrow"></i>
            </div>
            <div id="settingsDropdown" class="hidden pl-8 mt-2 sidebar-dropdown">
                <a href="/template-print" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
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
    
    /* Active menu styles */
    .active-menu {
        background-color: #ffedd5;
        border-left: 4px solid #ea580c;
    }
    
    .active-menu a {
        color: #ea580c;
    }
    
    .active-menu .sidebar-icon {
        color: #ea580c;
    }
    
    /* Hover styles */
    .menu-item:hover {
        background-color: #f3f4f6;
    }
    
    .menu-subitem:hover {
        color: #ea580c;
    }
    
    /* Dropdown arrow rotation */
    .rotate-180 {
        transform: rotate(180deg);
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

        // Menu dropdown functionality
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            const dropdownId = item.getAttribute('data-dropdown');
            const dropdown = document.getElementById(dropdownId);
            const arrow = item.querySelector('.sidebar-dropdown-arrow');
            
            item.addEventListener('click', function(e) {
                // Don't do anything if sidebar is collapsed
                if (document.getElementById('sidebar').classList.contains('collapsed')) return;
                
                // Check if click was on a link inside dropdown
                if (e.target.closest('.menu-subitem')) {
                    // Set active state for submenu item
                    document.querySelectorAll('.menu-subitem').forEach(subitem => {
                        subitem.classList.remove('text-orange-700', 'font-medium');
                    });
                    e.target.closest('.menu-subitem').classList.add('text-orange-700', 'font-medium');
                    return;
                }
                
                // Check if click was on the menu item itself (not a child element)
                if (e.currentTarget === e.target || 
                    e.target.classList.contains('sidebar-icon') || 
                    e.target.classList.contains('sidebar-text') ||
                    e.target.classList.contains('sidebar-dropdown-arrow')) {
                    
                    e.stopPropagation();
                    
                    // Close all other dropdowns first
                    document.querySelectorAll('.sidebar-dropdown').forEach(d => {
                        if (d.id !== dropdownId) {
                            d.classList.add('hidden');
                        }
                    });
                    
                    // Toggle current dropdown
                    if (dropdown) {
                        dropdown.classList.toggle('hidden');
                    }
                    
                    // Toggle arrow
                    if (arrow) {
                        arrow.classList.toggle('rotate-180');
                    }
                }
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.sidebar-dropdown').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
            
            document.querySelectorAll('.sidebar-dropdown-arrow').forEach(arrow => {
                arrow.classList.remove('rotate-180');
            });
        });
        
        // Set active menu based on current URL
        function setActiveMenu() {
            const currentPath = window.location.pathname;
            
            // Reset all active states
            document.querySelectorAll('.menu-item, .menu-subitem').forEach(item => {
                item.classList.remove('active-menu', 'text-orange-700', 'font-medium');
            });
            
            // Check each menu item
            document.querySelectorAll('.menu-item').forEach(item => {
                const dropdownId = item.getAttribute('data-dropdown');
                const dropdown = document.getElementById(dropdownId);
                
                if (dropdown) {
                    const links = dropdown.querySelectorAll('a');
                    
                    links.forEach(link => {
                        if (link.getAttribute('href') === currentPath) {
                            // Mark subitem as active
                            link.classList.add('text-orange-700', 'font-medium');
                            
                            // Open parent dropdown
                            dropdown.classList.remove('hidden');
                            item.querySelector('.sidebar-dropdown-arrow').classList.add('rotate-180');
                            
                            // Mark parent as active
                            item.classList.add('active-menu');
                        }
                    });
                }
            });
            
            // Special case for dashboard
            if (currentPath === "/dashboard") {
                // Add active-menu class to dashboard menu item div
                const dashboardMenuItem = document.querySelector('a[href="/dashboard"]').closest('.menu-item');
                if (dashboardMenuItem) {
                    dashboardMenuItem.classList.add('active-menu');
                }
                // Add active classes to dashboard link
                const dashboardLink = document.querySelector('a[href="/dashboard"]');
                if (dashboardLink) {
                    dashboardLink.classList.add('text-orange-700', 'font-medium');
                }
            }
        }
        
        // Call the function when page loads
        setActiveMenu();
    });
</script>