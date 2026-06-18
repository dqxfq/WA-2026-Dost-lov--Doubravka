<?php require_once '../app/views/layout/header.php'; ?>

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
                            
<?php if (isset($_SESSION['user_id']) && isset($book['created_by']) && $_SESSION['user_id'] === $book['created_by']): ?>                                <span class="text-pink-200">|</span>
                                <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="text-amber-400 hover:text-amber-500 font-medium">Upravit</a>
                                <span class="text-pink-200">|</span>
                                <a href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chceš tuto knihu smazat? 🥺')" class="text-rose-400 hover:text-rose-500 font-medium">Smazat</a>
                            <?php endif; ?>

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

<?php require_once '../app/views/layout/footer.php'; ?>