<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kifa Bakery - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .btn-orange {
            background-color: #FF6B00;
        }
        .btn-orange:hover {
            background-color: #E05E00;
        }
        body {
            font-family: 'Arial', sans-serif;
        }
        
        /* Notification styles */
        .notification {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            transform: translateX(150%);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 1000;
            max-width: 350px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            background-color: rgba(255, 107, 0, 0.9); /* Orange with transparency */
            color: white;
        }
        
        .notification.error {
            background-color: rgba(239, 68, 68, 0.9); /* Red with transparency */
            color: white;
        }
        
        .notification-icon {
            margin-right: 0.75rem;
            flex-shrink: 0;
        }
        
        .notification-close {
            margin-left: 1rem;
            cursor: pointer;
            flex-shrink: 0;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        
        .notification-close:hover {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center p-4">
    <!-- Notification container -->
    <div id="notification-container"></div>

    <!-- Logo and Title above the card -->
    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#FF6B00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-croissant">
                <path d="m4.6 13.11 5.79-3.21c1.89-1.05 4.79 1.78 3.71 3.71l-3.22 5.81C8.8 23.16.79 15.23 4.6 13.11Z"/>
                <path d="m10.5 9.5-1-2.29C9.2 6.48 8.8 6 8 6H4.5C2.79 6 2 6.5 2 8.5a7.71 7.71 0 0 0 2 4.83"/>
                <path d="M8 6c0-1.55.24-4-2-4-2 0-2.5 2.17-2.5 4"/>
                <path d="m14.5 13.5 2.29 1c.73.3 1.21.7 1.21 1.5v3.5c0 1.71-.5 2.5-2.5 2.5a7.71 7.71 0 0 1-4.83-2"/>
                <path d="M18 16c1.55 0 4-.24 4 2 0 2-2.17 2.5-4 2.5"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">Kifa Bakery</h1>
        <p class="text-gray-600 mt-2">Sistem Manajemen Bisnis Terintegrasi</p>
    </div>

    <!-- Login Card -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 text-center">Login</h2>
            <p class="text-gray-500 text-center mt-2">Masukkan kredensial Anda untuk mengakses sistem</p>
        </div>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <div class="relative">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Masukkan email"
                        class="w-full px-4 py-3 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                        required
                    >
                    <i data-lucide="user" class="absolute left-3 top-3 text-gray-400 w-5 h-5"></i>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Masukkan password"
                        class="w-full px-4 py-3 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                        required
                    >
                    <i data-lucide="lock" class="absolute left-3 top-3 text-gray-400 w-5 h-5"></i>
                    <i data-lucide="eye" class="absolute right-3 top-3 text-gray-400 w-5 h-5 cursor-pointer" id="togglePassword"></i>
                </div>
            </div>

            <div class="mb-6 flex items-center">
                <input 
                    type="checkbox" 
                    id="remember" 
                    name="remember"
                    class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded"
                >
                <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
            </div>

            <button 
                type="submit" 
                class="w-full btn-orange text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 hover:shadow-md"
            >
                Login
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-gray-500">
            © Copyright <span class="font-medium">IT SOLUTION</span>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Toggle between eye and eye-off icons
            const icon = this;
            if (icon.getAttribute('data-lucide') === 'eye') {
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        });

        // Notification system
        function showNotification(type, message) {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            const iconName = type === 'success' ? 'check-circle' : 'alert-circle';
            
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-icon">
                    <i data-lucide="${iconName}" class="w-5 h-5"></i>
                </div>
                <div class="notification-message flex-1 text-sm font-medium">${message}</div>
                <div class="notification-close">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </div>
            `;
            
            container.appendChild(notification);
            lucide.createIcons();
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 10);
            
            // Auto-remove after 5 seconds
            const autoRemove = setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    container.removeChild(notification);
                }, 300);
            }, 5000);
            
            // Manual close
            notification.querySelector('.notification-close').addEventListener('click', () => {
                clearTimeout(autoRemove);
                notification.classList.remove('show');
                setTimeout(() => {
                    container.removeChild(notification);
                }, 300);
            });
        }

        // Example notification functions
        function showError(message) {
            showNotification('error', message);
        }

        function showSuccess(message) {
            showNotification('success', message);
        }

        // Form submission (for demo purposes)
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                showError('Semua field harus diisi!');
                return;
            }
            
            // Simulate login validation
            if (email === "admin@kifa.com" && password === "kifa123") {
                showSuccess('Login berhasil! Mengarahkan ke dashboard...');
                // Redirect after 1.5 seconds
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 1500);
            } else {
                showError('Email atau password salah!');
            }
        });

        // Demo notifications (can be removed in production)
        document.addEventListener('DOMContentLoaded', function() {
        });
    </script>
</body>
</html>