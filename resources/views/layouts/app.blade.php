<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kifa Bakery - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --sidebar-expanded-width: 280px;
            --sidebar-collapsed-width: 70px;
            --transition-speed: 0.3s;
        }

        body {
            overflow-x: hidden;
        }

        /* Sidebar styles */
        .sidebar {
            width: var(--sidebar-expanded-width);
            transition: all var(--transition-speed) ease;
            position: fixed;
            height: 100vh;
            z-index: 30;
            left: 0;
            top: 0;
            border-right: 1px solid #e5e7eb;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            background-color: white;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* Main content area */
        .main-content {
            transition: all var(--transition-speed) ease;
            margin-left: var(--sidebar-expanded-width);
            width: calc(100% - var(--sidebar-expanded-width));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
            width: calc(100% - var(--sidebar-collapsed-width));
        }

        /* Navbar styles */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: all var(--transition-speed) ease;
        }

        /* Content area */
        .content-area {
            flex: 1;
            overflow-y: auto;
            background-color: #f9fafb;
        }

        /* Mobile overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 20;
            display: none;
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* Active menu styling */
        .active-menu {
            background-color: #FFF6F0;
            border-left: 4px solid #FF6B00;
            color: #FF6B00;
        }

        /* Card shadow */
        .card-shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        }

        /* Responsive breakpoints */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-show {
                transform: translateX(0);
                box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            }
        }

        /* Sidebar specific styles */
        .rotate-180 {
            transform: rotate(180deg);
        }

        /* When sidebar is collapsed, center the icons */
        .sidebar.collapsed .px-4 {
            display: flex;
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        /* Hide dropdown arrows when sidebar is collapsed */
        .sidebar.collapsed [id$="DropdownArrow"] {
            display: none;
        }

        /* Only show icons in submenu when collapsed */
        .sidebar.collapsed .pl-8 {
            padding-left: 0;
        }

        /* Center the icons in collapsed state */
        .sidebar.collapsed .flex.items-center {
            justify-content: center;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay"></div>
    
    <!-- Layout Container -->
    <div class="flex h-screen overflow-hidden relative">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div id="mainContent" class="main-content flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <div class="navbar" id="main-header">
                @include('layouts.navbar')
            </div>

            <!-- Content with proper spacing -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-100">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
            const toggleSidebar = document.getElementById('toggleSidebar');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const toggleIcon = document.getElementById('toggleIcon');
            const bottomToggleIcon = document.getElementById('bottomToggleIcon');
            
            // Function to toggle sidebar state
            function toggleSidebarState() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
                
                // Rotate toggle icons
                if (toggleIcon) toggleIcon.classList.toggle('rotate-180');
                if (bottomToggleIcon) bottomToggleIcon.classList.toggle('rotate-180');
                
                // Store state in localStorage
                const isCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
            }
            
            // Initialize sidebar state from localStorage
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('collapsed');
                if (toggleIcon) toggleIcon.classList.add('rotate-180');
                if (bottomToggleIcon) bottomToggleIcon.classList.add('rotate-180');
            }
            
            // Desktop toggle buttons
            if (toggleSidebarBtn) {
                toggleSidebarBtn.addEventListener('click', toggleSidebarState);
            }
            
            if (toggleSidebar) {
                toggleSidebar.addEventListener('click', toggleSidebarState);
            }
            
            // Mobile menu button
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('mobile-show');
                    sidebarOverlay.classList.toggle('active');
                });
            }
            
            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-show');
                    sidebarOverlay.classList.remove('active');
                });
            }
            
            // Handle window resize
            function handleResize() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('mobile-show');
                    sidebarOverlay.classList.remove('active');
                }
            }
            
            window.addEventListener('resize', handleResize);
        });
    </script>
</body>
</html>