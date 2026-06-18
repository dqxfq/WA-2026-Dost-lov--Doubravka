<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Knihovna - seznam knih</title>
</head>
<body class="bg-pink-50 text-gray-800 font-sans antialiased">
    
    <header class="bg-white shadow-sm border-b border-pink-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">🌸 Aplikace Knihovna</h1>
            <nav>
                <ul class="flex space-x-6 items-center">
                    <li><a href="<?= BASE_URL ?>/index.php" class="text-gray-500 hover:text-pink-500 font-medium transition">Seznam knih</a></li>
                    <li><a href="<?= BASE_URL ?>/index.php?url=book/create" class="bg-pink-400 text-white px-5 py-2 rounded-full hover:bg-pink-500 transition font-medium shadow-sm">➕ Přidat knihu</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="mb-6 space-y-3">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php
                        $bgClass = 'bg-white';
                        $textClass = 'text-gray-800';
                        $borderClass = 'border-pink-200';

                        if ($type === 'success') {
                            $bgClass = 'bg-green-50';
                            $textClass = 'text-green-600';
                            $borderClass = 'border-green-200';
                        } elseif ($type === 'error') {
                            $bgClass = 'bg-rose-50';
                            $textClass = 'text-rose-600';
                            $borderClass = 'border-rose-200';
                        } elseif ($type === 'notice') {
                            $bgClass = 'bg-amber-50';
                            $textClass = 'text-amber-600';
                            $borderClass = 'border-amber-200';
                        }
                    ?>
                    
                    <?php foreach ($messages as $message): ?>
                        <div class="p-4 rounded-2xl border <?= $bgClass ?> <?= $textClass ?> <?= $borderClass ?> shadow-sm flex items-center">
                            <strong><?= htmlspecialchars($message) ?></strong>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <?php unset($_SESSION['messages']); ?>
        <?php endif; ?>
        <div class="mb-8">
            <h2 class="text-3xl font-extrabold text-gray-800">Dostupné knihy</h2>
            <p class="text-pink-400 mt-2 font-medium">Tvoje osobní sbírka příběhů 📖</p>
        </div>
        
        <?php if (!empty($books)): ?>
            <div class="bg-white rounded-3xl shadow-sm border border-pink-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-pink-50 text-sm text-left">
                        <thead class="bg-pink-50/50 text-pink-400 font-semibold">
                            <tr>
                                <th class="px-6 py-4 uppercase tracking-wider">Název</th>
                                <th class="px-6 py-4 uppercase tracking-wider">Autor</th>
                                <th class="px-6 py-4 uppercase tracking-wider">ISBN</th>
                                <th class="px-6 py-4 uppercase tracking-wider">Rok</th>
                                <th class="px-6 py-4 uppercase tracking-wider text-right">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-pink-50 bg-white">
                            <?php foreach ($books as $book): ?>
                            <tr class="hover:bg-pink-50/30 transition duration-150">
                                <td class="px-6 py-4 font-semibold text-gray-800"><?php echo htmlspecialchars($book['title']); ?></td>
                                <td class="px-6 py-4 text-gray-500"><?php echo htmlspecialchars($book['author']); ?></td>
                                <td class="px-6 py-4 text-gray-400"><?php echo htmlspecialchars($book['isbn']); ?></td>
                                <td class="px-6 py-4 text-gray-400"><?php echo htmlspecialchars($book['year']); ?></td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>" class="text-pink-500 hover:text-pink-600 font-medium">Detail</a>
                                    <span class="text-pink-200">|</span>
                                    <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-amber-400 hover:text-amber-500 font-medium">Upravit</a>
                                    <span class="text-pink-200">|</span>
                                    <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chceš tuto knihu smazat? 🥺')" class="text-rose-400 hover:text-rose-500 font-medium">Smazat</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-3xl shadow-sm border border-pink-100 p-12 text-center">
                <span class="text-5xl">🎀</span>
                <p class="mt-4 text-lg text-gray-500 font-medium">Zatím tu nejsou žádné knihy.</p>
                <a href="<?= BASE_URL ?>/index.php?url=book/create" class="inline-block mt-4 text-pink-500 hover:text-pink-600 font-bold">Běž nějakou přidat &rarr;</a>
            </div>
        <?php endif; ?>
    </main>

    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-pink-300 text-sm mt-10">
        <p>&copy; WA 2026 - Tvoje krásná knihovna ✨</p>
    </footer>
</body>
</html>