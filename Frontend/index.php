<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoFlow | Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-950 flex items-center justify-center min-h-screen">
    <div class="bg-slate-900 border border-white/10 p-8 rounded-3xl w-full max-w-md shadow-2xl mx-4">
        <div class="text-center mb-8">
            <div class="bg-emerald-500/20 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/30">
                <i data-lucide="zap" class="text-emerald-500 w-8 h-8"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">AutoFlow</h1>
            <p class="text-slate-400 mt-2">Sign in to your account</p>
        </div>

        <form id="loginForm" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                <div class="relative">
                    <i data-lucide="mail" class="absolute left-3 top-3 text-slate-500 w-5 h-5"></i>
                    <input type="email" name="email" required
                        class="w-full bg-slate-800 border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-white focus:outline-none focus:border-emerald-500 transition-all"
                        placeholder="name@company.com">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-3 top-3 text-slate-500 w-5 h-5"></i>
                    <input type="password" name="password" required
                        class="w-full bg-slate-800 border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-white focus:outline-none focus:border-emerald-500 transition-all"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-emerald-900/20 mt-4">
                Sign In
            </button>
        </form>
    </div>

    <script>
        lucide.createIcons();

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            fetch('http://localhost:8080/api/users/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
            .then(res => {
                if(res.ok) {
                    // Login සාර්ථකයි නම් Dashboard එකට යන්න
                    window.location.href = 'dashboard.php';
                } else {
                    alert('Invalid email or password!');
                }
            })
            .catch(err => alert('Server not responding!'));
        });
    </script>
</body>
</html>