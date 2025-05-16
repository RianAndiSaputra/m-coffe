<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment Modal</title>
    <!-- Tailwind CSS and Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Payment Modal -->
    <div id="paymentModal" class="modal fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute w-full h-full bg-black opacity-50"></div>
        <div
            class="modal-container bg-white w-full max-w-md mx-auto rounded-xl shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2"
        >
            <div class="modal-content p-6 text-left">
                <div class="flex justify-between items-center pb-4">
                    <h3 class="text-xl font-bold">Pembayaran</h3>
                    <button onclick="closeModal('paymentModal')" class="text-gray-400 hover:text-red-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <p class="text-sm mb-4 text-gray-600">Selesaikan transaksi dengan memilih metode pembayaran</p>

                <div class="bg-orange-100 text-orange-600 p-4 rounded-lg mb-4">
                    <p class="text-sm">Total Pembayaran</p>
                    <p id="paymentTotal" class="text-lg font-semibold">Rp 0</p>
                    <p id="itemCount" class="text-xs text-gray-500">0 item dalam transaksi</p>
                </div>

                <!-- Metode Pembayaran dengan Border -->
                <div class="mb-4">
                    <label class="font-semibold mb-2 block">Metode Pembayaran</label>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2 border border-gray-300 p-2 rounded-lg">
                            <input
                                type="radio"
                                name="paymentMethod"
                                value="cash"
                                class="accent-black"
                                checked
                                onchange="toggleCashInput()"
                            />
                            <i class="fas fa-money-bill-wave text-orange-500"></i>
                            <span class="w-full">Tunai</span>
                        </label>
                        <label class="flex items-center space-x-2 border border-gray-300 p-2 rounded-lg">
                            <input
                                type="radio"
                                name="paymentMethod"
                                value="transfer"
                                class="accent-black"
                                onchange="toggleCashInput()"
                            />
                            <i class="fas fa-exchange-alt text-orange-500"></i>
                            <span class="w-full">Transfer</span>
                        </label>
                        <label class="flex items-center space-x-2 border border-gray-300 p-2 rounded-lg">
                            <input
                                type="radio"
                                name="paymentMethod"
                                value="qris"
                                class="accent-black"
                                onchange="toggleCashInput()"
                            />
                            <i class="fas fa-qrcode text-orange-500"></i>
                            <span class="w-full">QRIS</span>
                        </label>
                    </div>
                </div>

                <!-- Jumlah Uang (Hanya muncul saat metode tunai dipilih) -->
                <div id="cashInputSection" class="mb-4">
                    <label class="font-semibold block mb-2">Jumlah Uang Diterima</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">Rp</span>
                        <input
                            type="number"
                            id="cashReceived"
                            placeholder="0"
                            class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                            oninput="calculateChange()"
                        />
                    </div>

                    <!-- Tampilkan Kembalian -->
                    <div id="changeSection" class="mt-2 hidden">
                        <div class="flex justify-between items-center bg-green-100 text-green-700 p-2 rounded">
                            <span class="text-sm">Kembalian:</span>
                            <span id="changeAmount" class="font-semibold">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- Member with Search -->
                <div class="mb-4 relative">
                    <label class="font-semibold block mb-2">Member</label>
                    <div class="relative">
                        <button
                            id="memberDropdownButton"
                            onclick="toggleMemberDropdown()"
                            class="w-full px-3 py-2 border rounded-lg text-left flex justify-between items-center"
                        >
                            <span id="selectedMemberText">Pilih Member</span>
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </button>

                        <div
                            id="memberDropdown"
                            class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto"
                        >
                            <div class="p-2 border-b sticky top-0 bg-white">
                                <div class="relative">
                                    <input
                                        type="text"
                                        id="memberSearchInput"
                                        placeholder="Cari member..."
                                        class="w-full pl-8 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-400"
                                    />
                                    <i class="fas fa-search absolute left-2 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            <ul id="memberList" class="py-1">
                                <!-- Members will be loaded dynamically -->
                                <li onclick="selectMember(null, 'Tanpa Member')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                                    <p class="font-medium">Tanpa Member</p>
                                    <p class="text-xs text-gray-500">Tidak menggunakan member</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Notes field -->
                <div class="mb-4">
                    <label class="font-semibold block mb-2">Catatan</label>
                    <textarea
                        id="orderNotes"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                        rows="2"
                    ></textarea>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button onclick="closeModal('paymentModal')" class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-lg">
                        Batal
                    </button>
                    <button onclick="processPayment()" class="px-4 py-2 text-sm bg-orange-500 text-white hover:bg-orange-600 rounded-lg">
                        Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div
            class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded-lg shadow-lg z-50 overflow-y-auto relative top-1/2 transform -translate-y-1/2"
        >
            <div class="modal-content py-6 text-left px-6">
                <!-- Header -->
                <div class="flex justify-between items-center pb-2">
                    <p class="text-base font-semibold">Pembayaran</p>
                    <button onclick="closeModal('successModal')" class="modal-close cursor-pointer z-50">
                        <i class="fas fa-times text-gray-600"></i>
                    </button>
                </div>

                <!-- Description -->
                <p class="text-sm text-gray-500 mb-4">Detail transaksi yang berhasil</p>

                <!-- Success icon and message -->
                <div class="text-center my-6">
                    <div class="flex justify-center mb-3">
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                        </div>
                    </div>
                    <p class="text-green-600 text-lg font-semibold mb-1">Pembayaran Berhasil!</p>
                    <p class="text-sm text-gray-600">Transaksi telah berhasil diselesaikan</p>
                    <p id="invoiceNumber" class="text-sm font-medium text-gray-800 mt-2"></p>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-center pt-4 space-x-3">
                    <button
                        onclick="printReceipt()"
                        class="px-5 py-2 text-sm bg-orange-500 text-white rounded hover:bg-orange-600 transition"
                    >
                        Cetak Struk
                    </button>
                    <button
                        onclick="closeSuccessModal()"
                        class="px-5 py-2 text-sm bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let selectedMemberId = null;
        let outletId = null;
        let shiftId = null;
        let currentTotal = 0;

        // Initialize when document is ready
        document.addEventListener("DOMContentLoaded", () => {
            loadMembers();
        });

        // Function to show payment modal with order data
        function showPaymentModal(total) {
            currentTotal = total;

            // Get cart data directly from window.cart
            const cart = window.cart || [];
            
            // Calculate total items in cart
            const itemCount = cart.reduce((sum, item) => sum + item.quantity, 0);

            // Update UI
            document.getElementById("paymentTotal").textContent = formatRupiah(total);
            document.getElementById("itemCount").textContent = `${itemCount} item dalam transaksi`;

            // Reset form
            document.getElementById("cashReceived").value = "";
            document.getElementById("selectedMemberText").textContent = "Pilih Member";
            document.getElementById("orderNotes").value = "";
            selectedMemberId = null;

            // Show modal
            document.getElementById("paymentModal").classList.remove("hidden");

            // Initialize the cash input section
            toggleCashInput();
        }

        // Function to load members from API
        function loadMembers() {
            const token = localStorage.getItem("token");
            if (!token) {
                console.error("Token not found in localStorage");
                return;
            }

            fetch("/api/members", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Failed to load members");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success && data.data) {
                        const memberList = document.getElementById("memberList");
                        memberList.innerHTML = "";

                        // Add "No Member" option
                        const noMemberItem = document.createElement("li");
                        noMemberItem.className = "px-3 py-2 hover:bg-orange-50 cursor-pointer";
                        noMemberItem.onclick = () => selectMember(null, "Tanpa Member");
                        noMemberItem.innerHTML = `
                            <p class="font-medium">Tanpa Member</p>
                            <p class="text-xs text-gray-500">Tidak menggunakan member</p>
                        `;
                        memberList.appendChild(noMemberItem);

                        // Add all members from API
                        data.data.forEach((member) => {
                            const item = document.createElement("li");
                            item.className = "px-3 py-2 hover:bg-orange-50 cursor-pointer";
                            item.onclick = () => selectMember(member.id, member.name);
                            item.innerHTML = `
                                <p class="font-medium">${member.name}</p>
                                <p class="text-xs text-gray-500">${member.member_code || member.phone || ""}</p>
                            `;
                            memberList.appendChild(item);
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error loading members:", error);
                    // Fallback with sample data if API fails
                    const memberList = document.getElementById("memberList");
                    memberList.innerHTML = `
                        <li onclick="selectMember(null, 'Tanpa Member')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                            <p class="font-medium">Tanpa Member</p>
                            <p class="text-xs text-gray-500">Tidak menggunakan member</p>
                        </li>
                        <li onclick="selectMember(1, 'Andi Pratama')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                            <p class="font-medium">Andi Pratama</p>
                            <p class="text-xs text-gray-500">M001</p>
                        </li>
                        <li onclick="selectMember(2, 'Budi Santoso')" class="px-3 py-2 hover:bg-orange-50 cursor-pointer">
                            <p class="font-medium">Budi Santoso</p>
                            <p class="text-xs text-gray-500">M002</p>
                        </li>
                    `;
                });
        }

        // Calculate change when cash amount is entered
        function calculateChange() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            if (paymentMethod !== "cash") {
                document.getElementById("cashInputSection").classList.add("hidden");
                return;
            } else {
                document.getElementById("cashInputSection").classList.remove("hidden");
            }

            const cash = parseInt(document.getElementById("cashReceived").value) || 0;
            const change = cash - currentTotal;

            const changeSection = document.getElementById("changeSection");
            const changeAmount = document.getElementById("changeAmount");

            if (cash >= currentTotal) {
                changeAmount.textContent = formatRupiah(change);
                changeSection.classList.remove("hidden");
            } else {
                changeSection.classList.add("hidden");
            }
        }

        // Format number to Rupiah
        function formatRupiah(amount) {
            return "Rp " + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Toggle cash input section based on payment method
        function toggleCashInput() {
            const selected = document.querySelector('input[name="paymentMethod"]:checked').value;
            const cashSection = document.getElementById("cashInputSection");

            if (selected === "cash") {
                cashSection.classList.remove("hidden");
                calculateChange();
            } else {
                cashSection.classList.add("hidden");
            }
        }

        // Close any modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add("hidden");
        }

        // Close success modal and potentially reset the cart
        function closeSuccessModal() {
            closeModal("successModal");
            // Reset the cart
            if (typeof window.clearCart === "function") {
                window.clearCart();
            }
        }

        // Process payment
        function processPayment() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            let totalPaid = currentTotal; // Default for QRIS and transfer

            // Get current cart data directly from window.cart
            const currentCart = window.cart || [];
            
            // Validate cart items before proceeding
            if (!currentCart || currentCart.length === 0) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Keranjang belanja kosong",
                    text: "Silakan tambahkan produk sebelum melakukan pembayaran",
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true
                });
                return;
            }

            // Prepare cart items for API
            const cartItems = currentCart.map((item) => ({
                product_id: item.id,
                quantity: item.quantity,
                price: item.price,
                discount: item.discount || 0,
            }));

            // Validate cash payment
            if (paymentMethod === "cash") {
                const cashReceived = parseInt(document.getElementById("cashReceived").value) || 0;
                if (cashReceived < currentTotal) {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Jumlah uang tidak mencukupi",
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true
                    });
                    return;
                }
                totalPaid = cashReceived;
            }

            // Get outlet and shift ID (you may need to get these dynamically)
            outletId = 1;
            shiftId = 1;

            // Prepare order data
            const orderData = {
                outlet_id: outletId,
                shift_id: shiftId,
                items: cartItems,
                payment_method: paymentMethod,
                notes: document.getElementById("orderNotes").value,
                total_paid: totalPaid,
                total_amount: currentTotal,
                tax: 0,
                discount: 0,
                member_id: selectedMemberId,
            };

            console.log("Order data to be sent:", orderData);

            // Call API to create order
            const token = localStorage.getItem("token");
            if (!token) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Token tidak ditemukan",
                    text: "Silakan login kembali",
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true
                });
                return;
            }

            fetch("/api/orders", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
                body: JSON.stringify(orderData),
            })
                .then(async (response) => {
                    // First check if response is HTML (likely error page)
                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.indexOf("application/json") === -1) {
                        const text = await response.text();
                        if (text.startsWith("<!DOCTYPE html>")) {
                            throw new Error("Server returned HTML instead of JSON");
                        }
                        throw new Error("Invalid response format");
                    }

                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Hide payment modal
                        closeModal("paymentModal");

                        // Set invoice number in success modal
                        document.getElementById("invoiceNumber").textContent = `Invoice: ${
                            data.data.order_number || data.data.invoice_number || ""
                        }`;

                        // Show success modal
                        document.getElementById("successModal").classList.remove("hidden");

                        // Show success alert
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Pembayaran Berhasil",
                            showConfirmButton: false,
                            timer: 3000,
                            background: "#FFA500",
                            iconColor: "#fff",
                            toast: true,
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Gagal memproses pembayaran",
                            text: data.message || "Terjadi kesalahan saat memproses pembayaran",
                            showConfirmButton: false,
                            timer: 3000,
                            toast: true
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error processing payment:", error);
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Terjadi kesalahan",
                        text: "Gagal memproses pembayaran",
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true
                    });
                });
        }

        // Function to print receipt
        function printReceipt() {
            // Implement receipt printing logic here
            console.log("Printing receipt...");
        }

        // Toggle member dropdown
        function toggleMemberDropdown() {
            const dropdown = document.getElementById("memberDropdown");
            dropdown.classList.toggle("hidden");

            // Focus on search input when dropdown is shown
            if (!dropdown.classList.contains("hidden")) {
                document.getElementById("memberSearchInput").focus();
            }
        }

        // Select a member
        function selectMember(id, name) {
            selectedMemberId = id;
            document.getElementById("selectedMemberText").textContent = name;
            document.getElementById("memberDropdown").classList.add("hidden");
        }

        // Close dropdown when clicking outside
        document.addEventListener("click", function (event) {
            const dropdown = document.getElementById("memberDropdown");
            const button = document.getElementById("memberDropdownButton");

            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
            }
        });

        // Search functionality for members
        document.getElementById("memberSearchInput").addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const members = document.querySelectorAll("#memberList li");

            members.forEach((member) => {
                const name = member.querySelector("p.font-medium").textContent.toLowerCase();
                const id = member.querySelector("p.text-xs")?.textContent.toLowerCase() || "";

                if (name.includes(searchTerm) || id.includes(searchTerm)) {
                    member.style.display = "block";
                } else {
                    member.style.display = "none";
                }
            });
        });
    </script>

    <style>
        .modal {
            transition: opacity 0.25s ease;
        }

        /* SweetAlert toast styling */
        .swal2-toast {
            width: auto !important;
            padding: 1rem 1.5rem !important;
        }

        /* Custom scrollbar for dropdown */
        #memberDropdown::-webkit-scrollbar {
            width: 6px;
        }

        #memberDropdown::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 0 0 8px 8px;
        }

        #memberDropdown::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        #memberDropdown::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</body>
</html>