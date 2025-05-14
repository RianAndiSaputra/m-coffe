<div class="sidebar bg-white text-gray-800 flex flex-col fixed h-full z-50" id="sidebar">
    <!-- Logo -->
    <div class="p-4 flex items-center justify-between border-b">
        <div class="flex items-center">
            <img src="/images/logo.png" alt="Kifa Bakery Logo" class="w-10 h-10 object-contain" />
            <span class="ml-2 font-bold text-xl whitespace-nowrap">Kifa Bakery</span>
        </div>
        <button id="toggleSidebarBtn" class="text-gray-500 hover:text-black hidden md:block transition-all">
            <i data-lucide="chevrons-left" class="w-5 h-5 text-black" id="toggleIcon"></i>
        </button>
    </div>

    <!-- Outlet Dropdown -->
    <div class="px-4 py-3 border-b">
        <div class="relative">
            <button id="outletDropdownButton" class="w-full flex items-center justify-between px-3 py-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all">
                <div class="flex items-center">
                    <i data-lucide="store" class="w-5 h-5 text-black"></i>
                    <span class="ml-3 font-medium truncate">Kifa Bakery Pusat</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 transition-transform text-black" id="outletDropdownArrow"></i>
            </button>
            
            <!-- Outlet Dropdown Menu -->
            <div id="outletDropdown" class="hidden absolute left-0 right-0 mt-1 bg-white rounded-lg shadow-lg z-50 border border-gray-200 max-h-60 overflow-y-auto">
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
    <nav class="flex-1 overflow-y-auto py-4">
        <div class="px-4 py-2  group rounded-lg transition-all menu-item">
           <a href="/dashboard" class="flex items-center py-2 hover:text-orange-700 transition-all menu-subitem">
                <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2 text-black sidebar-icon"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </div>

        <!-- Product Dropdown -->
        <div class="menu-item px-4 py-2 group rounded-lg transition-all" data-dropdown="productDropdown">
            <div class="flex items-center justify-between w-full cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span class="ml-3">Produk</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="productDropdownArrow"></i>
            </div>
            <div id="productDropdown" class="hidden pl-12 mt-2 sidebar-dropdown">
                <a href="/list-produk" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="list" class="w-4 h-4 mr-3"></i>
                    <span>Daftar Produk</span>
                </a>
                <a href="/kategori" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="tag" class="w-4 h-4 mr-3"></i>
                    <span>Kategori</span>
                </a>
            </div>
        </div>

        <!-- Outlet Management Dropdown -->
        <div class="menu-item px-4 py-2 group rounded-lg transition-all" data-dropdown="outletManagementDropdown">
            <div class="flex items-center justify-between w-full cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="building-2" class="w-5 h-5"></i>
                    <span class="ml-3">Outlet</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="outletManagementDropdownArrow"></i>
            </div>
            <div id="outletManagementDropdown" class="hidden pl-12 mt-2 sidebar-dropdown">
                <a href="/outlet" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="list" class="w-4 h-4 mr-3"></i>
                    <span>Daftar Outlet</span>
                </a>
            </div>
        </div>
        
        <!-- Stock Dropdown -->
        <div class="menu-item px-4 py-2 group rounded-lg transition-all" data-dropdown="stockDropdown">
            <div class="flex items-center justify-between w-full cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="package-open" class="w-5 h-5"></i>
                    <span class="ml-3">Stok</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="stockDropdownArrow"></i>
            </div>
            <div id="stockDropdown" class="hidden pl-12 mt-2 sidebar-dropdown">
                <a href="/riwayat-stok" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="history" class="w-4 h-4 mr-3"></i>
                    <span>Riwayat Stok</span>
                </a>
                <a href="/stok-per-tanggal" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="calendar" class="w-4 h-4 mr-3"></i>
                    <span>Stok Pertanggal</span>
                </a>
                <a href="/penyesuaian-stok" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="edit" class="w-4 h-4 mr-3"></i>
                    <span>Penyesuaian Stok</span>
                </a>
                <a href="/transfer-stok" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="truck" class="w-4 h-4 mr-3"></i>
                    <span>Transfer Stok</span>
                </a>
                <a href="/approve-stok" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-3"></i>
                    <span>Approve Stok</span>
                </a>
            </div>
        </div>

        <!-- User Dropdown -->
        <div class="menu-item px-4 py-2 group rounded-lg transition-all" data-dropdown="userDropdown">
            <div class="flex items-center justify-between w-full cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                    <span class="ml-3">User</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="userDropdownArrow"></i>
            </div>
            <div id="userDropdown" class="hidden pl-12 mt-2 sidebar-dropdown">
                <a href="/member" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="user" class="w-4 h-4 mr-3"></i>
                    <span>Member</span>
                </a>
                <a href="/staff" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="users" class="w-4 h-4 mr-3"></i>
                    <span>Staff</span>
                </a>
            </div>
        </div>

        <!-- Closing Dropdown -->
        <div class="menu-item px-4 py-2 group rounded-lg transition-all" data-dropdown="closingDropdown">
            <div class="flex items-center justify-between w-full cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                    <span class="ml-3">Closing</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="closingDropdownArrow"></i>
            </div>
            <div id="closingDropdown" class="hidden pl-12 mt-2 sidebar-dropdown">
                <a href="/riwayat-kas" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="wallet" class="w-4 h-4 mr-3"></i>
                    <span>Riwayat Kas</span>
                </a>
                <a href="/riwayat-transaksi" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="receipt" class="w-4 h-4 mr-3"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </div>
        </div>

        <!-- Report Dropdown -->
        <div class="menu-item px-4 py-2 group rounded-lg transition-all" data-dropdown="reportDropdown">
            <div class="flex items-center justify-between w-full cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                    <span class="ml-3">Laporan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="reportDropdownArrow"></i>
            </div>
            <div id="reportDropdown" class="hidden pl-12 mt-2 sidebar-dropdown">
                <a href="/perhari" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="calendar" class="w-4 h-4 mr-3"></i>
                    <span>Perhari</span>
                </a>
                <a href="/per-item" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="box" class="w-4 h-4 mr-3"></i>
                    <span>Per Item</span>
                </a>
                <a href="/per-kategori" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="tag" class="w-4 h-4 mr-3"></i>
                    <span>Per Kategori</span>
                </a>
                <a href="/per-member" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="user" class="w-4 h-4 mr-3"></i>
                    <span>Per Member</span>
                </a>
                <a href="/stok" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="package" class="w-4 h-4 mr-3"></i>
                    <span>Stock</span>
                </a>
                <a href="/laporan-riwayat-stok" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="history" class="w-4 h-4 mr-3"></i>
                    <span>Riwayat Stok</span>
                </a>
                <a href="/laporan-approve" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-3"></i>
                    <span>Approve</span>
                </a>
            </div>
        </div>

        <!-- Settings Dropdown -->
        <div class="menu-item px-4 py-2 group rounded-lg transition-all" data-dropdown="settingsDropdown">
            <div class="flex items-center justify-between w-full cursor-pointer">
                <div class="flex items-center">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span class="ml-3">Pengaturan</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" id="settingsDropdownArrow"></i>
            </div>
            <div id="settingsDropdown" class="hidden pl-12 mt-2 sidebar-dropdown">
                <a href="/template-print" class="menu-subitem flex items-center py-2 transition-all w-full">
                    <i data-lucide="printer" class="w-4 h-4 mr-3"></i>
                    <span>Template Print</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Collapse Button -->
    <div class="p-4 border-t flex justify-center">
        <button id="toggleSidebar" class="text-gray-500 hover:text-black transition-all">
            <i data-lucide="chevrons-left" class="w-5 h-5 text-black" id="bottomToggleIcon"></i>
        </button>
    </div>
</div>

<style>
    /* Sidebar default (desktop) */
    .sidebar {
        position: fixed;
        width: 280px;
        transition: all 0.3s ease;
        left: 0;
        top: 0;
        bottom: 0;
        background-color: white;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
        overflow-y: auto;
        z-index: 50;
    }

    /* Sidebar collapsed (desktop) */
    .sidebar.collapsed {
        width: 0;
        overflow: hidden;
        padding: 0 !important;
        border: none;
    }

    /* Sidebar mobile awalnya tersembunyi */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            width: 280px;
            z-index: 60;
        }

        .sidebar.mobile-show {
            transform: translateX(0);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        /* Sembunyikan tombol toggle desktop di mobile */
        #toggleSidebarBtn,
        #toggleSidebar {
            display: none !important;
        }
    }

    /* Hover effect menu item dan subitem */
    .sidebar .menu-item:hover > .flex.items-center,
    .sidebar .menu-subitem:hover {
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }

    /* Aktif menu utama */
    .menu-item.active-parent > .flex.items-center.justify-between {
        background-color: #ffedd5;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }

    /* Aktif menu subitem */
    .menu-subitem.active {
        background-color: #ffedd5;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
    }

    /* Warna dan berat font item aktif */
    .menu-subitem.active i,
    .menu-subitem.active span,
    .menu-item.active-parent > .flex.items-center.justify-between i,
    .menu-item.active-parent > .flex.items-center.justify-between span {
        color: #ea580c;
        font-weight: 500;
    }

    /* Dropdown smooth show/hide */
    .sidebar-dropdown {
        transition: all 0.3s ease;
    }

    /* Rotasi icon toggle */
    .rotate-180 {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }

    /* Cursor pointer untuk elemen klik */
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Lucide icons
        lucide.createIcons();

        const sidebar = document.getElementById('sidebar');
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const toggleIcon = document.getElementById('toggleIcon');
        const bottomToggleIcon = document.getElementById('bottomToggleIcon');
        const mobileMenuButton = document.querySelector('[data-drawer-target="sidebar"]');
       
        // Check for stored sidebar state and apply it on page load
        const sidebarState = localStorage.getItem('sidebarCollapsed');
        if (sidebarState === 'true' && window.innerWidth > 768) {
            sidebar.classList.add('collapsed');
            toggleIcon?.classList.add('rotate-180');
            bottomToggleIcon?.classList.add('rotate-180');
        }

        // Fungsi toggle sidebar
        function toggleSidebarState() {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                // Mode Mobile
                sidebar.classList.toggle('mobile-show');
            } else {
                // Mode Desktop
                const isNowCollapsed = sidebar.classList.toggle('collapsed');
                
                // Rotate both toggle icons
                if (toggleIcon) toggleIcon.classList.toggle('rotate-180');
                if (bottomToggleIcon) bottomToggleIcon.classList.toggle('rotate-180');
                
                // Save sidebar state in localStorage
                localStorage.setItem('sidebarCollapsed', isNowCollapsed);
            }
        }

        // Tombol toggle sidebar (atas & bawah)
        if (toggleSidebarBtn) {
            toggleSidebarBtn.addEventListener('click', toggleSidebarState);
        }

        if (toggleSidebar) {
            toggleSidebar.addEventListener('click', toggleSidebarState);
        }

        // Tombol menu di mode mobile (hamburger menu)
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function () {
                sidebar.classList.toggle('mobile-show');
            });
        }

        // Tutup dropdown lain saat buka satu
        function closeOtherDropdowns(currentDropdown) {
            document.querySelectorAll('.sidebar-dropdown').forEach(dropdown => {
                if (dropdown !== currentDropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                    const arrow = dropdown.closest('.menu-item')?.querySelector('[data-lucide="chevron-down"]');
                    if (arrow) arrow.classList.remove('rotate-180');
                }
            });
        }

        // Dropdown Outlet
        const outletDropdownButton = document.getElementById('outletDropdownButton');
        const outletDropdown = document.getElementById('outletDropdown');
        const outletDropdownArrow = document.getElementById('outletDropdownArrow');

        if (outletDropdownButton && outletDropdown) {
            outletDropdownButton.addEventListener('click', function (e) {
                e.stopPropagation();
                outletDropdown.classList.toggle('hidden');
                outletDropdownArrow.classList.toggle('rotate-180');
                closeOtherDropdowns(outletDropdown);
            });

            document.addEventListener('click', function () {
                outletDropdown.classList.add('hidden');
                outletDropdownArrow.classList.remove('rotate-180');
            });

            outletDropdown.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            const searchInput = outletDropdown.querySelector('input');
            const outletItems = outletDropdown.querySelectorAll('li');

            searchInput?.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                outletItems.forEach(item => {
                    const name = item.querySelector('span').textContent.toLowerCase();
                    item.style.display = name.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }

        // Menu Dropdown Aktif & Interaksi
        const menuItems = document.querySelectorAll('.menu-item[data-dropdown]');

        menuItems.forEach(item => {
            const dropdownId = item.getAttribute('data-dropdown');
            const dropdown = document.getElementById(dropdownId);
            const arrow = item.querySelector('[data-lucide="chevron-down"]');
            const dropdownHeader = item.querySelector('.flex.items-center.justify-between');

            if (dropdownHeader && dropdown) {
                dropdownHeader.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                    arrow?.classList.toggle('rotate-180');
                    closeOtherDropdowns(dropdown);
                });
            }

            const menuSubitems = item.querySelectorAll('.menu-subitem');
            menuSubitems.forEach(subitem => {
                subitem.addEventListener('click', function (e) {
                    document.querySelectorAll('.menu-subitem').forEach(si => si.classList.remove('active'));
                    subitem.classList.add('active');
                    document.querySelectorAll('.menu-item').forEach(mi => mi.classList.remove('active-parent'));
                    item.classList.add('active-parent');
                    e.stopPropagation();
                });
            });
        });

        // Function to handle sidebar outside clicks
        function handleOutsideClick(e) {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !mobileMenuButton?.contains(e.target) &&
                sidebar.classList.contains('mobile-show')) {
                sidebar.classList.remove('mobile-show');
            }
        }

        // Add event listener for clicks outside the sidebar (on mobile)
        document.addEventListener('click', handleOutsideClick);

        // Menandai menu aktif berdasarkan URL
        function setActiveMenu() {
            const currentPath = window.location.pathname;

            document.querySelectorAll('.active-parent, .active').forEach(el => {
                el.classList.remove('active-parent', 'active');
            });

            const allLinks = [...document.querySelectorAll('.menu-link, .menu-subitem')];
            const activeLink = allLinks.find(link => {
                const href = link.getAttribute('href');
                return href && (currentPath === href || currentPath.startsWith(href));
            });

            if (activeLink) {
                activeLink.classList.add('active');
                const parentItem = activeLink.closest('.menu-item');
                if (parentItem && activeLink.classList.contains('menu-subitem')) {
                    parentItem.classList.add('active-parent');
                    const dropdownId = parentItem.getAttribute('data-dropdown');
                    const dropdown = document.getElementById(dropdownId);
                    if (dropdown) {
                        dropdown.classList.remove('hidden');
                        parentItem.querySelector('[data-lucide="chevron-down"]')?.classList.add('rotate-180');
                    }
                }
            }
        }

        // Pastikan sidebar sesuai setelah resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-show');
                
                // Apply collapsed state from localStorage when returning to desktop
                const sidebarState = localStorage.getItem('sidebarCollapsed');
                if (sidebarState === 'true') {
                    sidebar.classList.add('collapsed');
                    toggleIcon?.classList.add('rotate-180');
                    bottomToggleIcon?.classList.add('rotate-180');
                } else {
                    sidebar.classList.remove('collapsed');
                    toggleIcon?.classList.remove('rotate-180');
                    bottomToggleIcon?.classList.remove('rotate-180');
                }
            }
        });

        setActiveMenu();
    });
</script>