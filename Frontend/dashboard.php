<?php
// .env file එක කියවා variables සකස් කිරීම
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

$apiBaseUrl = getenv('API_BASE_URL');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoFlow | Professional Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
    </style>
</head>

<body class="text-slate-200 p-4 md:p-8">

    <div class="max-w-7xl mx-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1
                    class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-emerald-400">
                    AutoFlow Pro
                </h1>
                <p class="text-slate-400 text-sm">Welcome back, Admin</p>
            </div>
            <div class="glass-card px-4 py-2 rounded-full flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <span class="text-sm font-medium">Administrator</span>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="glass-card p-6 rounded-2xl flex items-center gap-5">
                <div class="p-3 bg-blue-500/20 rounded-lg text-blue-400">
                    <i data-lucide="users" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-sm">Total Users</p>
                    <h3 class="text-2xl font-bold">1,284</h3>
                </div>
            </div>
            <div class="glass-card p-6 rounded-2xl flex items-center gap-5">
                <div class="p-3 bg-emerald-500/20 rounded-lg text-emerald-400">
                    <i data-lucide="car" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-sm">Active Vehicles</p>
                    <h3 class="text-2xl font-bold">856</h3>
                </div>
            </div>
            <div class="glass-card p-6 rounded-2xl flex items-center gap-5">
                <div class="p-3 bg-orange-500/20 rounded-lg text-orange-400">
                    <i data-lucide="settings" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-slate-400 text-sm">Pending Services</p>
                    <h3 class="text-2xl font-bold">12</h3>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-white/10 flex justify-between items-center">
                <h2 class="text-xl font-semibold">Registered Users</h2>
                <button onclick="toggleModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm transition-all">
                    + Add New User
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white/5 text-slate-400 text-sm uppercase">
                        <tr>
                            <th class="p-4">Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Mobile</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php
                        $url = "http://localhost:8080/api/users/all";
                        $response = @file_get_contents($url);

                        if ($response === FALSE) {
                            echo "<tr><td colspan='5' class='p-4 text-center text-red-400 font-medium'>Backend Server is not running!</td></tr>";
                        } else {
                            $users = json_decode($response, true);

                            if (empty($users)) {
                                echo "<tr><td colspan='5' class='p-4 text-center text-slate-400'>No users found in the system.</td></tr>";
                            } else {
                                foreach ($users as $user) {
                                    // Status Label logic
                                    $statusLabel = ($user['deletestatus'] == 0) ?
                                        '<span class="bg-emerald-500/20 text-emerald-400 text-[10px] px-2 py-1 rounded-full border border-emerald-500/30">ACTIVE</span>' :
                                        '<span class="bg-red-500/20 text-red-400 text-[10px] px-2 py-1 rounded-full border border-red-500/30">INACTIVE</span>';

                                    // Table Row
                                    echo "<tr class='hover:bg-white/5 transition-colors'>
                        <td class='p-4 font-medium text-white'>{$user['firstName']} {$user['lastName']}</td>
                        <td class='p-4 text-slate-400'>{$user['email']}</td>
                        <td class='p-4 text-slate-400'>{$user['mobileNumber']}</td>
                        <td class='p-4'>{$statusLabel}</td>
                        <td class='p-4 text-center'>
                            <button onclick='editUser({$user['id']})' class='text-slate-400 hover:text-white mx-2 transition-transform hover:scale-110'>
                                <i data-lucide='edit-2' class='w-4 h-4'></i>
                            </button>
                            <button onclick='deleteUser({$user['id']})' class='text-red-400 hover:text-red-300 mx-2 transition-transform hover:scale-110'>
                                <i data-lucide='trash-2' class='w-4 h-4'></i>
                            </button>
                        </td>
                      </tr>";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--  -->

    <div id="userModal"
        class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm hidden flex items-center justify-center z-50">
        <div class="glass-card w-full max-w-md p-8 rounded-3xl relative mx-4">
            <button onclick="toggleModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>

            <input type="hidden" id="userId" name="id">
            <h2 id="modalTitle" class="text-xl font-bold text-white mb-6">Add New User</h2>
            <!-- <h2 class="text-2xl font-bold mb-6 text-white">Add New User</h2> -->

            <form id="addUserForm" class="space-y-4">

                <div>
                    <label class="text-sm text-slate-400 block mb-1">First Name</label>
                    <input type="text" name="firstName"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition-all"
                        required>
                </div>
                <div>
                    <label class="text-sm text-slate-400 block mb-1">Last Name</label>
                    <input type="text" name="lastName"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition-all"
                        required>
                </div>
                <div>
                    <label class="text-sm text-slate-400 block mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition-all"
                        required>
                </div>
                <div>
                    <label class="text-sm text-slate-400 block mb-1">Mobile Number</label>
                    <input type="text" name="mobileNumber"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition-all"
                        required>
                </div>
                <div>
                    <label class="text-sm text-slate-400 block mb-1">Password</label>
                    <input type="password" name="password"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-blue-500 transition-all"
                        required>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl mt-4 shadow-lg shadow-blue-500/20 transition-all">
                    Register User
                </button>
            </form>
        </div>
    </div>

    <!--  -->
    <div id="toast"
        class="fixed top-5 right-5 z-[100] transform translate-x-full transition-all duration-300 pointer-events-none">
        <div class="glass-card px-6 py-4 rounded-2xl flex items-center gap-3 border-l-4 border-emerald-500">
            <div class="bg-emerald-500/20 text-emerald-400 p-1 rounded-full">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
            <div>
                <p class="text-white font-medium text-sm">Success!</p>
                <p class="text-slate-400 text-xs" id="toastMessage">User registered successfully.</p>
            </div>
        </div>
    </div>
    <div id="deleteConfirmModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-slate-900 border border-white/10 p-6 rounded-2xl max-w-sm w-full mx-4 shadow-2xl">
            <div class="text-center">
                <div
                    class="bg-red-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-500/30">
                    <i data-lucide="alert-triangle" class="text-red-500 w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Are you sure?</h3>
                <p class="text-slate-400 mb-6">This will mark the user as inactive. You can't undo this action easily.
                </p>

                <div class="flex gap-3 mt-6">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 py-3 px-4 rounded-xl bg-white/5 text-white font-medium hover:bg-white/10 transition-colors">
                        Cancel
                    </button>
                    <button id="confirmDeleteBtn"
                        class="flex-1 py-3 px-4 rounded-xl bg-red-600 text-white font-medium hover:bg-red-700 transition-shadow shadow-lg shadow-red-600/20">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--  -->

    <script>
        // 1. PHP හරහා එන API URL එක (dashboard.php උඩින්ම මේ PHP variable එක තියෙන්න ඕනේ)
        // උදා: $apiBaseUrl = "http://localhost:8080/api/users";
        const API_BASE = "<?php echo isset($apiBaseUrl) ? $apiBaseUrl : 'http://localhost:8080/api/users'; ?>";

        // Icons initialize කිරීම
        lucide.createIcons();

        // 2. Notification (Toast) Function
        function showToast(message, isError = false) {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMessage');

            toastMsg.innerText = message;

            // Error ද නැද්ද අනුව වර්ණය වෙනස් කිරීම
            if (isError) {
                toast.firstElementChild.classList.add('border-red-500');
                toast.firstElementChild.classList.remove('border-emerald-500');
            } else {
                toast.firstElementChild.classList.add('border-emerald-500');
                toast.firstElementChild.classList.remove('border-red-500');
            }

            // පෙන්වීම
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');

            // තත්පර 3කින් සැඟවීම
            setTimeout(() => {
                toast.classList.replace('translate-x-0', 'translate-x-full');
                toast.classList.replace('opacity-100', 'opacity-0');
            }, 3000);
        }

        // 3. Modal පාලනය
        function toggleModal() {
            const modal = document.getElementById('userModal');
            modal.classList.toggle('hidden');
            if (modal.classList.contains('hidden')) {
                document.getElementById('addUserForm').reset(); // Form එක reset කරනවා
            }
        }

        // 4. User Register (Create)
        document.getElementById('addUserForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            // hidden input එකේ ID එකක් තියෙනවා නම් ඒක Update එකක්
            const userId = document.getElementById('userId').value;

            let url = "http://localhost:8080/api/users/register";
            let method = "POST";

            if (userId) {
                url = `http://localhost:8080/api/users/update/${userId}`;
                method = "PUT";
            }

            fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (response.ok) {
                        showToast(userId ? 'User Updated!' : 'User Registered!');
                        toggleModal();
                        setTimeout(() => { location.reload(); }, 1000);
                    } else {
                        showToast('Something went wrong!', true);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
        // 5. Delete User (Soft Delete)
        let userToDelete = null;

        function deleteUser(id) {
            userToDelete = id; // මකන්න ඕන ID එක මතක තියාගන්නවා
            const modal = document.getElementById('deleteConfirmModal');
            modal.classList.remove('hidden'); // Modal එක පෙන්වනවා
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
            userToDelete = null;
        }

        // "Yes, Delete" button එක click කළාම වෙන දේ
        document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
            if (userToDelete) {
                // Modal එක වහලා Load වෙන එක පෙන්වන්න පුළුවන්
                this.innerHTML = '<span class="animate-spin inline-block mr-2">⏳</span> Deleting...';
                this.disabled = true;

                fetch(`${API_BASE}/delete/${userToDelete}`, {
                    method: 'PUT'
                })
                    .then(response => {
                        if (response.ok) {
                            closeDeleteModal();
                            showToast('User has been deactivated!');
                            setTimeout(() => { location.reload(); }, 1000);
                        } else {
                            showToast('Something went wrong!', true);
                            this.disabled = false;
                            this.innerText = 'Yes, Delete';
                        }
                    })
                    .catch(error => {
                        showToast('Server error!', true);
                        this.disabled = false;
                        this.innerText = 'Yes, Delete';
                    });
            }
        });

        // 6. Edit User (මීළඟ පියවර සඳහා සූදානම් කර ඇත)
        function editUser(id) {
            console.log("Editing user:", id);
            // මෙතනදී අපිට පුළුවන් ID එකට අදාළ දත්ත අරන් Modal එකට දාන්න
            showToast("Edit feature coming soon!");
        }

        //======edit==========

        function editUser(id) {
            // 1. Modal එකේ Title එක වෙනස් කරනවා
            document.getElementById('modalTitle').innerText = "Edit User";
            document.getElementById('userId').value = id;

            // 2. දැනට තියෙන Table row එකෙන් දත්ත ගන්නවා (නැත්නම් API එකෙන් ගන්නත් පුළුවන්)
            // ලේසිම ක්‍රමය Table එකෙන් ගන්න එක:
            fetch(`${API_BASE}/${id}`) // Single user කෙනෙක්ව ගන්න API එකක් තියෙනවා නම්
                .then(res => res.json())
                .then(user => {
                    document.getElementsByName('firstName')[0].value = user.firstName;
                    document.getElementsByName('lastName')[0].value = user.lastName;
                    document.getElementsByName('email')[0].value = user.email;
                    document.getElementsByName('mobileNumber')[0].value = user.mobileNumber;

                    toggleModal(); // Modal එක පෙන්වනවා
                });
        }

        //=====Form Submit Update =========

        document.getElementById('addUserForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            const id = document.getElementById('userId').value;

            // ID එකක් තියෙනවා නම් Update, නැත්නම් Register
            const url = id ? `${API_BASE}/update/${id}` : `${API_BASE}/register`;
            const method = id ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (response.ok) {
                        showToast(id ? 'User Updated!' : 'User Registered!');
                        toggleModal();
                        setTimeout(() => { location.reload(); }, 1000);
                    }
                })
                .catch(err => console.error(err));
        });
    </script>
</body>

</html>