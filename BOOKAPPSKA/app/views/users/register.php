<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-light tracking-widest text-pink-500 uppercase">Nová registrace</h2>
            <p class="text-pink-300 italic mt-2 text-sm">Vytvořte si účet pro správu vašeho knižního katalogu.</p>
        </div>

        <div class="bg-white border border-pink-200 rounded-xl shadow-2xl p-6 md:p-8">
            <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <h3 class="text-pink-600 text-xs font-bold uppercase tracking-widest border-b border-pink-100 pb-2 mb-2">Přihlašovací údaje</h3>
                    </div>

                    <div>
                        <label for="username" class="block text-xs font-semibold text-pink-400 mb-1 uppercase tracking-wider">Uživatelské jméno *</label>
                        <input type="text" id="username" name="username" required
                               class="w-full bg-pink-50 border border-pink-200 rounded-md px-4 py-2 text-pink-800 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-pink-400 mb-1 uppercase tracking-wider">E-mailová adresa *</label>
                        <input type="email" id="email" name="email" required
                               class="w-full bg-pink-50 border border-pink-200 rounded-md px-4 py-2 text-pink-800 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-pink-400 mb-1 uppercase tracking-wider">Heslo *</label>
                        <input type="password" id="password" name="password" required
                               minlength="8" 
                               pattern=".*[0-9].*" 
                               title="Heslo musí mít alespoň 8 znaků a obsahovat minimálně jedno číslo."
                               class="w-full bg-pink-50 border border-pink-200 rounded-md px-4 py-2 text-pink-800 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
                    </div>

                    <div>
                        <label for="password_confirm" class="block text-xs font-semibold text-pink-400 mb-1 uppercase tracking-wider">Potvrzení hesla *</label>
                        <input type="password" id="password_confirm" name="password_confirm" required
                               minlength="8" 
                               pattern=".*[0-9].*" 
                               title="Heslo musí mít alespoň 8 znaků a obsahovat minimálně jedno číslo."
                               class="w-full bg-pink-50 border border-pink-200 rounded-md px-4 py-2 text-pink-800 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
                    </div>

                    <div class="md:col-span-2 mt-4">
                        <h3 class="text-pink-600 text-xs font-bold uppercase tracking-widest border-b border-pink-100 pb-2 mb-2">Osobní údaje (nepovinné)</h3>
                    </div>

                    <div>
                        <label for="first_name" class="block text-xs font-semibold text-pink-400 mb-1 uppercase tracking-wider">Jméno</label>
                        <input type="text" id="first_name" name="first_name"
                               class="w-full bg-pink-50 border border-pink-200 rounded-md px-4 py-2 text-pink-800 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
                    </div>

                    <div>
                        <label for="last_name" class="block text-xs font-semibold text-pink-400 mb-1 uppercase tracking-wider">Příjmení</label>
                        <input type="text" id="last_name" name="last_name"
                               class="w-full bg-pink-50 border border-pink-200 rounded-md px-4 py-2 text-pink-800 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
                    </div>

                    <div class="md:col-span-2 mt-6">
                        <button type="submit"
                                 class="w-full bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-4 rounded-md shadow-lg transition-all transform hover:scale-[1.01] active:scale-[0.99]">
                            Vytvořit účet
                        </button>
                        <p class="text-center text-pink-400 text-sm mt-4">
                            Už máte účet? <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-pink-600 hover:underline underline-offset-4 transition-colors">Přihlaste se</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>