/**
 * Product Management Module
 * Handles all product-related operations including CRUD, filtering, and UI interactions
 */
const ProductManager = (() => {
    // Private variables
    let produkHapusId = null;
    let currentOutletId = 1;

    // DOM Elements
    const elements = {
        modals: [
            "modalTambahProduk",
            "modalEditProduk",
            "modalKonfirmasiHapus",
        ],
        forms: {
            add: "tambahProdukForm",
            edit: "editProdukForm",
        },
        buttons: {
            save: "btnSimpanProduk",
            saveEdit: "btnSimpanEdit",
            cancel: "btnBatalModal",
            cancelEdit: "btnBatalEdit",
            cancelDelete: "btnBatalHapus",
            confirmDelete: "btnKonfirmasiHapus",
        },
        inputs: {
            search: "searchProduk",
            image: "gambar",
            editImage: "editGambar",
        },
        containers: {
            alert: "alertContainer",
            tableBody: "produkTableBody",
            outletCheckboxes: "outletCheckboxes",
            editOutletList: "editOutletList",
        },
    };

    // Initialize the module
    const init = () => {
        setupModals();
        createAuthInterceptor();
        setupEventListeners();
        loadInitialData();
        initLucideIcons();
    };

    // Setup all modals
    const setupModals = () => {
        elements.modals.forEach((modalId) => {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            modal.addEventListener("click", (e) => {
                if (e.target === modal) closeModal(modalId);
            });

            const modalContent = modal.querySelector("div[onclick]");
            if (modalContent) {
                modalContent.addEventListener("click", (e) =>
                    e.stopPropagation()
                );
            }
        });
    };

    // Create fetch interceptor for authentication
    const createAuthInterceptor = () => {
        const originalFetch = window.fetch;

        window.fetch = async (resource, options = {}) => {
            const token = localStorage.getItem("token");
            if (token) {
                options.headers = options.headers || {};
                options.headers.Authorization = `Bearer ${token}`;
                options.headers.Accept = "application/json";

                if (
                    !options.headers["Content-Type"] &&
                    !(options.body instanceof FormData)
                ) {
                    options.headers["Content-Type"] = "application/json";
                }

                options.headers["X-CSRF-TOKEN"] = document.querySelector(
                    'meta[name="csrf-token"]'
                ).content;
            }

            const response = await originalFetch(resource, options);

            if (options.headers?.Accept === "application/json") {
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.includes("application/json")) {
                    return response;
                } else if (response.status !== 204) {
                    console.warn(
                        "Response is not JSON:",
                        await response.text()
                    );
                    return new Response(
                        JSON.stringify({
                            message:
                                "Server did not return valid JSON response",
                        }),
                        {
                            status: 500,
                            headers: { "Content-Type": "application/json" },
                        }
                    );
                }
            }

            return response;
        };
    };

    // Setup event listeners
    const setupEventListeners = () => {
        // Form submission
        document
            .getElementById(elements.buttons.save)
            ?.addEventListener("click", (e) => {
                e.preventDefault();
                tambahProduk();
            });

        document
            .getElementById(elements.buttons.saveEdit)
            ?.addEventListener("click", (e) => {
                e.preventDefault();
                simpanPerubahanProduk();
            });

        // Cancel buttons
        document
            .getElementById(elements.buttons.cancel)
            ?.addEventListener("click", () => closeModal("modalTambahProduk"));
        document
            .getElementById(elements.buttons.cancelEdit)
            ?.addEventListener("click", () => closeModal("modalEditProduk"));
        document
            .getElementById(elements.buttons.cancelDelete)
            ?.addEventListener("click", () => {
                closeModal("modalKonfirmasiHapus");
                produkHapusId = null;
            });

        // Confirm delete button
        document
            .getElementById(elements.buttons.confirmDelete)
            ?.addEventListener("click", konfirmasiHapusProduk);

        // Search input
        document
            .getElementById(elements.inputs.search)
            ?.addEventListener("input", (e) => {
                filterProducts(e.target.value.toLowerCase());
            });

        // Image preview handlers
        setupImagePreview(elements.inputs.image, "gambarPreview");
        setupImagePreview(elements.inputs.editImage, "editGambarPreview");
    };

    // Setup image preview for a given input
    const setupImagePreview = (inputId, previewId) => {
        document.getElementById(inputId)?.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const preview = document.getElementById(previewId);
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove("hidden");
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    };

    // Load initial data
    const loadInitialData = async () => {
        try {
            await Promise.all([
                loadProducts(),
                loadKategoriOptions(),
                loadOutletCheckboxes(),
            ]);
        } catch (error) {
            console.error("Error loading initial data:", error);
            showAlert("error", `Gagal memuat data awal: ${error.message}`);
        }
    };

    // Initialize Lucide icons
    const initLucideIcons = () => {
        if (window.lucide) window.lucide.createIcons();
    };

    // Show alert notification
    const showAlert = (type, message) => {
        const alertContainer = document.getElementById(
            elements.containers.alert
        );
        const alertId = `alert-${Date.now()}`;

        const alertConfig = {
            success: {
                bgColor: "bg-orange-50",
                borderColor: "border-orange-200",
                textColor: "text-orange-800",
                icon: "check-circle",
                iconColor: "text-orange-500",
            },
            error: {
                bgColor: "bg-red-50",
                borderColor: "border-red-200",
                textColor: "text-red-800",
                icon: "alert-circle",
                iconColor: "text-red-500",
            },
        };

        const config = alertConfig[type] || alertConfig.success;

        const alertElement = document.createElement("div");
        alertElement.id = alertId;
        alertElement.className = `p-4 border rounded-lg shadow-sm ${config.bgColor} ${config.borderColor} ${config.textColor} flex items-start gap-3 animate-fade-in-up`;
        alertElement.innerHTML = `
            <i data-lucide="${config.icon}" class="w-5 h-5 mt-0.5 ${config.iconColor}"></i>
            <div class="flex-1">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <button onclick="ProductManager.closeAlert('${alertId}')" class="p-1 rounded-full hover:bg-gray-100">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        `;

        alertContainer.prepend(alertElement);
        initLucideIcons();

        setTimeout(() => closeAlert(alertId), 5000);
    };

    // Close alert
    const closeAlert = (id) => {
        const alert = document.getElementById(id);
        if (alert) {
            alert.classList.add("animate-fade-out");
            setTimeout(() => alert.remove(), 300);
        }
    };

    // Modal functions
    const openModal = (modalId) => {
        document.querySelectorAll('[id^="modal"]').forEach((modal) => {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        });

        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove("hidden");
            modal.classList.add("flex");
            document.body.style.overflow = "hidden";
        }
    };

    const closeModal = (modalId) => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            document.body.style.overflow = "";
        }
    };

    // Toggle dropdown menu
    const toggleDropdown = (button) => {
        const menu = button.nextElementSibling;

        document.querySelectorAll(".dropdown-menu").forEach((m) => {
            if (m !== menu) {
                m.classList.add("hidden");
                m.classList.remove("dropdown-up", "dropdown-down");
            }
        });

        menu.classList.toggle("hidden");
        menu.classList.remove("dropdown-up", "dropdown-down");

        const menuRect = menu.getBoundingClientRect();
        const buttonRect = button.getBoundingClientRect();
        const spaceBelow = window.innerHeight - buttonRect.bottom;
        const spaceAbove = buttonRect.top;

        if (spaceBelow < menuRect.height && spaceAbove > menuRect.height) {
            menu.classList.add("dropdown-up");
            menu.style.bottom = "100%";
            menu.style.marginBottom = "0.25rem";
            menu.style.top = "auto";
            menu.style.marginTop = "0";
        } else {
            menu.classList.add("dropdown-down");
            menu.style.top = "100%";
            menu.style.marginTop = "0.25rem";
            menu.style.bottom = "auto";
            menu.style.marginBottom = "0";
        }
    };

    // Load products from API
    const loadProducts = async () => {
        try {
            const response = await fetch("/api/products");
            if (!response.ok) throw new Error(`Error: ${response.status}`);

            const responseData = await response.json();
            if (!responseData.data || !Array.isArray(responseData.data)) {
                throw new Error("Format data produk tidak valid");
            }

            renderProducts(responseData);
        } catch (error) {
            console.error("Error loading products:", error);
            showAlert("error", `Gagal memuat produk: ${error.message}`);

            if (
                error.message.includes("token") ||
                error.message.includes("401")
            ) {
                window.location.href = "/login";
            }
        }
    };

    // Render products to table
    const renderProducts = (responseData) => {
        const tbody = document.getElementById(elements.containers.tableBody);
        if (!tbody) return;

        tbody.innerHTML = "";

        const products = responseData?.data || [];

        if (products.length === 0) {
            tbody.innerHTML = `
                <tr class="border-b">
                    <td colspan="8" class="py-4 text-center text-gray-500">
                        Tidak ada data produk
                    </td>
                </tr>
            `;
            return;
        }

        products.forEach((product, index) => {
            const inventory = product.inventory || {};
            const outletName =
                product.inventory?.outlet?.name || "Tidak ada outlet";

            const row = document.createElement("tr");
            row.className = "border-b hover:bg-gray-50";
            row.innerHTML = `
                <td class="py-3 px-4">${index + 1}</td>
                <td class="py-3 px-4 flex items-center space-x-3">
                    <img src="${
                        product.image_url || "/images/default-product.png"
                    }" 
                         alt="${product.name}" 
                         class="w-10 h-10 bg-gray-100 rounded object-cover" />
                    <div>
                        <p class="font-medium">${product.name || "-"}</p>
                        <p class="text-xs text-gray-500">${
                            product.description || "-"
                        }</p>
                    </div>
                </td>
                <td class="py-3 px-4">${product.sku || "-"}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                        ${product.category?.name || "Tanpa Kategori"}
                    </span>
                </td>
                <td class="py-3 px-4">Rp ${formatNumber(
                    product.price || 0
                )}</td>
                <td class="py-3 px-4">
                    <div class="flex flex-col">
                        <span class="font-medium">${
                            inventory.quantity || 0
                        }</span>
                        <div class="text-xs text-gray-500">
                            <span>Min: ${inventory.min_stock || 0}</span><br>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-4">
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full ${
                        product.is_active
                            ? "bg-green-100 text-green-800"
                            : "bg-gray-100 text-gray-800"
                    }">
                        ${product.is_active ? "Aktif" : "Nonaktif"}
                    </span>
                </td>
                <td class="py-3 px-4 relative">
                    <div class="relative inline-block">
                        <button onclick="ProductManager.toggleDropdown(this)" 
                                class="p-2 hover:bg-gray-100 rounded-lg">
                            <i data-lucide="more-vertical" class="w-5 h-5 text-gray-500"></i>
                        </button>
                        <div class="dropdown-menu hidden absolute right-0 z-20 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-xl text-sm">
                            <button onclick="ProductManager.openEditModal(${
                                product.id
                            })" 
                                    class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left rounded-t-lg">
                                <i data-lucide="edit" class="w-4 h-4 mr-2 text-gray-500"></i> Edit
                            </button>
                            <button onclick="ProductManager.hapusProduk(${
                                product.id
                            })" 
                                    class="flex items-center w-full px-3 py-2 hover:bg-gray-100 text-left text-red-600 rounded-b-lg">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus
                            </button>
                        </div>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });

        if (window.lucide) window.lucide.createIcons();
    };

    // Format number for currency display
    const formatNumber = (num) => new Intl.NumberFormat("id-ID").format(num);

    // Filter products by search term
    const filterProducts = async (searchTerm) => {
        try {
            const response = await fetch("/api/products");
            if (!response.ok) throw new Error("Gagal memuat data produk");

            const { data: products } = await response.json();

            const filtered = products.filter(
                (product) =>
                    product.name.toLowerCase().includes(searchTerm) ||
                    product.description?.toLowerCase().includes(searchTerm) ||
                    product.sku?.toLowerCase().includes(searchTerm)
            );

            renderProducts({ data: filtered });
        } catch (error) {
            console.error("Error:", error);
            showAlert("error", error.message);
        }
    };

    // Add new product
    const tambahProduk = async () => {
        const btnSimpan = document.getElementById(elements.buttons.save);
        const originalText = btnSimpan.innerHTML;

        try {
            // Show loading state
            btnSimpan.disabled = true;
            btnSimpan.innerHTML =
                '<i data-lucide="loader-circle" class="animate-spin mr-2"></i> Menyimpan...';
            if (window.lucide) window.lucide.createIcons();

            const form = document.getElementById(elements.forms.add);

            // Validate form before submission
            const namaProduk = form.querySelector('[name="name"]').value.trim();
            const harga = form.querySelector('[name="price"]').value.trim();
            const kategori = form
                .querySelector('[name="category_id"]')
                .value.trim();
            const outletCheckboxes = form.querySelectorAll(
                'input[name="outlet_ids[]"]:checked'
            );

            // Client-side validation
            if (!namaProduk) throw new Error("Nama produk harus diisi");
            if (!harga) throw new Error("Harga harus diisi");
            if (!kategori) throw new Error("Kategori harus dipilih");
            if (outletCheckboxes.length === 0)
                throw new Error("Pilih minimal satu outlet");

            const formData = new FormData(form);

            // Generate SKU if not provided
            if (!formData.get("sku")) formData.set("sku", `SKU-${Date.now()}`);

            // Set default values
            if (!formData.get("quantity")) formData.set("quantity", "0");
            if (!formData.get("min_stock")) formData.set("min_stock", "0");
            formData.append("outlet_id", currentOutletId.toString());

            const response = await fetch("/api/products", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            });

            const responseData = await response.json();

            if (!response.ok) {
                if (response.status === 422 && responseData.errors) {
                    const errorMessages = Object.values(responseData.errors)
                        .flat()
                        .join(", ");
                    throw new Error(`Validasi gagal: ${errorMessages}`);
                }
                throw new Error(
                    responseData.message || "Gagal menambahkan produk"
                );
            }

            showAlert("success", "Produk berhasil ditambahkan");
            closeModal("modalTambahProduk");
            loadProducts();
            form.reset();

            // Reset image preview
            const preview = document.getElementById("gambarPreview");
            if (preview) {
                preview.src = "";
                preview.classList.add("hidden");
            }
        } catch (error) {
            console.error("Error:", error);
            showAlert("error", error.message);
        } finally {
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = originalText;
            if (window.lucide) window.lucide.createIcons();
        }
    };

    // Open edit modal with product data
    const openEditModal = async (productId) => {
        const btnEdit = document.querySelector(
            `[onclick="ProductManager.openEditModal(${productId})"]`
        );
        const originalText = btnEdit?.innerHTML;

        try {
            if (btnEdit) {
                btnEdit.disabled = true;
                btnEdit.innerHTML =
                    '<i data-lucide="loader-circle" class="animate-spin w-4 h-4"></i>';
                if (window.lucide) window.lucide.createIcons();
            }

            const token = localStorage.getItem("token");
            if (!token) throw new Error("Token tidak ditemukan");

            const response = await fetch(`/api/products/${productId}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(
                    errorData.message || `Error: ${response.status}`
                );
            }

            const responseData = await response.json();
            const product = responseData.data;

            if (!product) throw new Error("Data produk tidak valid");

            console.log("Product data for edit:", product); // Debug: Log full product data

            // Fill form fields
            document.getElementById("editProdukId").textContent = product.id;
            document.getElementById("editNamaProduk").value = product.name;
            document.getElementById("editSkuProduk").value = product.sku || "";
            document.getElementById("editDeskripsi").value =
                product.description || "";
            document.getElementById("editHarga").value = product.price;

            // FIX 1: Get inventory data correctly
            // Check for inventories array first (which contains the full inventory objects)
            let inventory = null;
            if (product.inventories && product.inventories.length > 0) {
                // Use the first inventory or find the one matching current outlet
                inventory =
                    product.inventories.find(
                        (inv) => inv.outlet_id === currentOutletId
                    ) || product.inventories[0];
            }
            // Fallback to inventory object if present
            else if (product.inventory) {
                inventory = product.inventory;
            }

            // Apply inventory data if found
            if (inventory) {
                document.getElementById("editStok").value =
                    inventory.quantity || 0;
                document.getElementById("editStokMinimum").value =
                    inventory.min_stock || 0;
            } else {
                // Default values if no inventory found
                document.getElementById("editStok").value = 0;
                document.getElementById("editStokMinimum").value = 0;
            }

            document.getElementById("editGambarCurrent").value =
                product.image || "";

            // FIX 2: Load categories first, then set the selected category
            await loadKategoriOptions();

            // Set category after categories are loaded
            if (product.category && product.category.id) {
                console.log("Setting category ID to:", product.category.id);

                // FIXED: Force a small delay to ensure DOM is updated
                await new Promise((resolve) => setTimeout(resolve, 100));

                const categorySelect = document.getElementById("editKategori");
                // Make sure options are loaded
                if (categorySelect && categorySelect.options.length > 0) {
                    categorySelect.value = product.category.id;
                    console.log(
                        "Category select value set to:",
                        categorySelect.value
                    );

                    // FIXED: Verify the category was set correctly
                    if (categorySelect.value != product.category.id) {
                        console.warn(
                            "Category not set correctly, trying direct approach"
                        );
                        // Try another approach - find the option directly
                        for (
                            let i = 0;
                            i < categorySelect.options.length;
                            i++
                        ) {
                            if (
                                categorySelect.options[i].value ==
                                product.category.id
                            ) {
                                categorySelect.selectedIndex = i;
                                console.log(
                                    "Set category using selectedIndex:",
                                    i
                                );
                                break;
                            }
                        }
                    }
                } else {
                    console.error(
                        "Category select not found or has no options"
                    );
                }
            } else {
                console.warn("No category data in product:", product);
            }

            // Set status
            document.getElementById("editStatus").value = product.is_active
                ? "active"
                : "inactive";

            // Set image preview
            const preview = document.getElementById("editGambarPreview");
            if (preview) {
                if (product.image_url) {
                    preview.src = product.image_url;
                    preview.classList.remove("hidden");
                } else {
                    preview.classList.add("hidden");
                }
            }

            // FIX 3: Handle outlet distribution correctly
            // Get outlet IDs from all possible sources
            let selectedOutletIds = [];

            // Check all potential sources of outlet data in order of preference
            if (
                product.outlets &&
                Array.isArray(product.outlets) &&
                product.outlets.length > 0
            ) {
                selectedOutletIds = product.outlets.map((outlet) => outlet.id);
            } else if (
                product.outlet_ids &&
                Array.isArray(product.outlet_ids) &&
                product.outlet_ids.length > 0
            ) {
                selectedOutletIds = product.outlet_ids;
            } else if (
                product.inventories &&
                Array.isArray(product.inventories) &&
                product.inventories.length > 0
            ) {
                // Extract unique outlet IDs from inventories
                selectedOutletIds = [
                    ...new Set(product.inventories.map((inv) => inv.outlet_id)),
                ];
            } else if (product.inventory && product.inventory.outlet_id) {
                selectedOutletIds = [product.inventory.outlet_id];
            }

            console.log("Selected outlet IDs:", selectedOutletIds); // Debug: Log selected outlet IDs

            // Load outlet checkboxes with the selected IDs
            await loadOutletCheckboxesForEdit(selectedOutletIds);

            openModal("modalEditProduk");
        } catch (error) {
            console.error("Error:", error);
            showAlert("error", `Gagal memuat produk: ${error.message}`);

            if (
                error.message.includes("token") ||
                error.message.includes("401")
            ) {
                window.location.href = "/login";
            }
        } finally {
            if (btnEdit) {
                btnEdit.disabled = false;
                btnEdit.innerHTML = originalText;
                if (window.lucide) window.lucide.createIcons();
            }
        }
    };

    // Load outlet checkboxes for edit modal
    const loadOutletCheckboxesForEdit = async (selectedOutletIds = []) => {
        try {
            const response = await fetch("/api/outlets");
            const { data: outlets } = await response.json();
            const container = document.getElementById(
                elements.containers.editOutletList
            );

            if (!container) return;

            container.innerHTML = "";

            // Convert all IDs to strings for consistent comparison
            const selectedIds = selectedOutletIds.map((id) => id.toString());

            console.log(
                "Creating outlet checkboxes with selected IDs:",
                selectedIds
            ); // Debug

            outlets.forEach((outlet) => {
                const outletIdStr = outlet.id.toString();
                const isChecked = selectedIds.includes(outletIdStr);

                console.log(
                    `Outlet ${outlet.id} (${outlet.name}): checked=${isChecked}`
                ); // Debug

                const div = document.createElement("div");
                div.className = "flex items-center gap-2 py-1";

                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "outlet_ids[]";
                checkbox.value = outletIdStr;
                checkbox.id = `edit-outlet-${outletIdStr}`;
                checkbox.className =
                    "w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500";
                checkbox.checked = isChecked;

                const label = document.createElement("label");
                label.htmlFor = `edit-outlet-${outletIdStr}`;
                label.className = "text-sm text-gray-700";
                label.textContent = outlet.name;

                div.appendChild(checkbox);
                div.appendChild(label);
                container.appendChild(div);
            });
        } catch (error) {
            console.error("Failed to load outlets:", error);
            const container = document.getElementById(
                elements.containers.editOutletList
            );
            if (container) {
                container.innerHTML = `
                    <div class="text-red-500 text-sm py-2">
                        Gagal memuat daftar outlet: ${error.message}
                    </div>
                `;
            }
        }
    };

    // Save product changes
    const simpanPerubahanProduk = async () => {
        const btnSimpan = document.getElementById("btnSimpanEdit");
        const originalText = btnSimpan.innerHTML;

        try {
            // Show loading state
            btnSimpan.disabled = true;
            btnSimpan.innerHTML =
                '<i data-lucide="loader-circle" class="animate-spin mr-2"></i> Menyimpan...';
            if (window.lucide) window.lucide.createIcons();

            const id = document.getElementById("editProdukId").textContent;
            const formData = new FormData();

            // Validate required fields
            const namaProduk = document
                .getElementById("editNamaProduk")
                .value.trim();
            const harga = document.getElementById("editHarga").value.trim();
            const kategori = document
                .getElementById("editKategori")
                .value.trim();
            const quantity = document.getElementById("editStok").value || 0;
            const minStock =
                document.getElementById("editStokMinimum").value || 0;

            if (!namaProduk) throw new Error("Nama produk harus diisi");
            if (!harga) throw new Error("Harga harus diisi");
            if (!kategori) throw new Error("Kategori harus dipilih");

            // Add all fields to formData
            formData.append("name", namaProduk);
            formData.append(
                "sku",
                document.getElementById("editSkuProduk").value.trim() ||
                    `SKU-${Date.now()}`
            );
            formData.append(
                "description",
                document.getElementById("editDeskripsi").value
            );
            formData.append("price", harga);
            formData.append("category_id", kategori);
            formData.append(
                "is_active",
                document.getElementById("editStatus").value === "active" ? 1 : 0
            );

            // Untuk inventory dari outlet saat ini
            formData.append("quantity", quantity);
            formData.append("min_stock", minStock);
            formData.append("outlet_id", currentOutletId.toString());

            // Collect selected outlets
            const selectedOutlets = [];
            const outletCheckboxes = document.querySelectorAll(
                '#editOutletList input[type="checkbox"]:checked'
            );

            if (outletCheckboxes && outletCheckboxes.length > 0) {
                outletCheckboxes.forEach((checkbox) => {
                    selectedOutlets.push(checkbox.value);
                });
            } else {
                const outletInputs = document.querySelectorAll(
                    '#editOutletList input[type="hidden"][name*="outlet"]'
                );
                outletInputs.forEach((input) => {
                    if (input.value) {
                        selectedOutlets.push(input.value);
                    }
                });
            }

            // Fallback: use outlet IDs from data attributes if no selections found
            if (selectedOutlets.length === 0) {
                const outletElements = document.querySelectorAll(
                    "#editOutletList [data-outlet-id]"
                );
                outletElements.forEach((el) => {
                    selectedOutlets.push(el.dataset.outletId);
                });

                // Final fallback: use default outlet ID 1
                if (selectedOutlets.length === 0) {
                    selectedOutlets.push("1"); // Use string to ensure consistent type
                }
            }

            console.log("Selected outlets:", selectedOutlets);

            // Fix: append each outlet ID as a separate array element
            selectedOutlets.forEach((outletId) => {
                formData.append("outlet_ids[]", outletId);
            });

            // Add image if changed
            const imageInput = document.getElementById("editGambar");
            if (imageInput.files[0]) {
                formData.append("image", imageInput.files[0]);
            }

            // Debug - log all fields being sent
            console.log("Mengirim data produk:");
            for (let pair of formData.entries()) {
                console.log(pair[0] + ": " + pair[1]);
            }

            // Add extended timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 30000); // 30 second timeout

            console.log(`Sending request to: /api/products/${id}`);

            const response = await fetch(`/api/products/${id}`, {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
                signal: controller.signal,
            });

            clearTimeout(timeoutId);

            const contentType = response.headers.get("content-type");
            let responseData;

            if (contentType && contentType.includes("application/json")) {
                responseData = await response.json();
                console.log("Response data:", responseData);
            } else {
                const textData = await response.text();
                console.log("Raw response:", textData);
                throw new Error(
                    `Server returned invalid response: ${textData.substring(
                        0,
                        100
                    )}`
                );
            }

            if (!response.ok) {
                if (response.status === 422 && responseData.errors) {
                    const errorMessages = Object.values(responseData.errors)
                        .flat()
                        .join(", ");
                    throw new Error(`Validasi gagal: ${errorMessages}`);
                }
                throw new Error(
                    responseData.message || "Gagal memperbarui produk"
                );
            }

            showAlert("success", "Produk berhasil diperbarui");
            closeModal("modalEditProduk");
            loadProducts();
        } catch (error) {
            console.error("Error detail:", error);
            showAlert("error", error.message || "Terjadi kesalahan");
        } finally {
            btnSimpan.disabled = false;
            btnSimpan.innerHTML = originalText;
            if (window.lucide) window.lucide.createIcons();
        }
    };

    // Load kategori options
    const loadKategoriOptions = async (callback) => {
        try {
            console.log("Loading category options...");
            const response = await fetch("/api/categories");
            if (!response.ok) throw new Error("Gagal memuat kategori");

            const { data: categories } = await response.json();
            console.log("Categories loaded:", categories);

            if (!Array.isArray(categories)) {
                throw new Error(
                    "Data kategori tidak valid. Harus berupa array."
                );
            }

            // Update dropdown kategori di modal tambah
            const selectTambah = document.getElementById("kategori");
            if (selectTambah) {
                selectTambah.innerHTML =
                    '<option value="">Pilih Kategori</option>';
                categories.forEach((category) => {
                    const option = document.createElement("option");
                    option.value = category.id;
                    option.textContent = category.name;
                    selectTambah.appendChild(option);
                });
            }

            // Update dropdown kategori di modal edit
            const selectEdit = document.getElementById("editKategori");
            if (selectEdit) {
                console.log("Updating edit category dropdown");
                selectEdit.innerHTML =
                    '<option value="">Pilih Kategori</option>';
                categories.forEach((category) => {
                    const option = document.createElement("option");
                    option.value = category.id.toString(); // FIXED: Convert to string for consistent comparison
                    option.textContent = category.name;
                    selectEdit.appendChild(option);
                    console.log(
                        `Added category option: ${category.id} - ${category.name}`
                    );
                });
                console.log(
                    "Edit category dropdown now has",
                    selectEdit.options.length,
                    "options"
                );
            } else {
                console.error("Edit category select element not found");
            }

            if (callback && typeof callback === "function") {
                console.log("Running category callback");
                callback();
            }
        } catch (error) {
            console.error("Error loading categories:", error);
            showAlert("error", "Gagal memuat daftar kategori");
        }
    };

    // Load outlet checkboxes
    const loadOutletCheckboxes = async () => {
        try {
            const response = await fetch("/api/outlets");
            const { data: outlets } = await response.json();
            const container = document.getElementById(
                elements.containers.outletCheckboxes
            );

            if (!container) return;

            container.innerHTML = "";

            outlets.forEach((outlet) => {
                const div = document.createElement("div");
                div.className = "flex items-center gap-2 mb-2";

                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "outlet_ids[]";
                checkbox.value = outlet.id;
                checkbox.id = `outlet-${outlet.id}`;
                checkbox.className =
                    "w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500";

                const label = document.createElement("label");
                label.htmlFor = `outlet-${outlet.id}`;
                label.className = "text-sm text-gray-700";
                label.textContent = outlet.name;

                div.appendChild(checkbox);
                div.appendChild(label);
                container.appendChild(div);
            });
        } catch (error) {
            console.error("Failed to load outlets:", error);
            showAlert("error", "Gagal memuat daftar outlet");
        }
    };

    // Prepare delete confirmation
    const hapusProduk = async (id) => {
        try {
            const token = localStorage.getItem("token");
            if (!token) throw new Error("Token tidak ditemukan");

            const response = await fetch(`/api/products/${id}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                },
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(
                    errorData.message || `Error: ${response.status}`
                );
            }

            const responseData = await response.json();
            const product = responseData.data;

            if (!product) throw new Error("Data produk tidak valid");

            produkHapusId = id;
            document.getElementById("hapusNamaProduk").textContent =
                product.name;
            openModal("modalKonfirmasiHapus");
        } catch (error) {
            console.error("Error:", error);
            showAlert("error", `Gagal memuat produk: ${error.message}`);

            if (
                error.message.includes("token") ||
                error.message.includes("401")
            ) {
                window.location.href = "/login";
            }
        }
    };

    // Confirm product deletion
    const konfirmasiHapusProduk = async () => {
        try {
            const token = localStorage.getItem("token");
            if (!token) throw new Error("Token tidak ditemukan");

            const response = await fetch(`/api/products/${produkHapusId}`, {
                method: "DELETE",
                headers: {
                    Authorization: `Bearer ${token}`,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
            });

            const data = await response.json();

            if (!response.ok)
                throw new Error(data.message || "Gagal menghapus produk");

            showAlert("success", "Produk berhasil dihapus");
            closeModal("modalKonfirmasiHapus");
            loadProducts();
            produkHapusId = null;
        } catch (error) {
            console.error("Error:", error);
            showAlert("error", `Gagal menghapus produk: ${error.message}`);
        }
    };

    // Public API
    return {
        init,
        showAlert,
        closeAlert,
        openModal,
        closeModal,
        toggleDropdown,
        openEditModal,
        hapusProduk,
        konfirmasiHapusProduk,
    };
})();

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", ProductManager.init);
