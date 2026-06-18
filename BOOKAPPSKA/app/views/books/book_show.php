<?php require_once '../app/views/layout/header.php'; ?>

<div class="max-w-3xl mx-auto">
    <p class="mb-6">
        <a href="<?= BASE_URL ?>/index.php" class="inline-flex items-center text-pink-400 hover:text-pink-600 font-medium transition">&larr; Zpět na seznam knih</a>
    </p>

    <div class="bg-white rounded-3xl shadow-sm border border-pink-100 overflow-hidden">
        <div class="bg-pink-300 px-8 py-8">
            <h2 class="text-3xl font-bold text-white drop-shadow-sm"><?= htmlspecialchars($book['title'] ?? '') ?></h2>
            <p class="text-pink-50 mt-1 text-lg font-medium">Autor: <?= htmlspecialchars($book['author'] ?? '') ?></p>
        </div>

        <div class="p-8">
            <h3 class="text-xl font-bold text-gray-700 border-b border-pink-100 pb-2 mb-6">Informace o knize 📖</h3>
            
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-pink-400">ISBN</dt>
                    <dd class="mt-1 text-gray-700 font-medium"><?= htmlspecialchars($book['isbn'] ?? '-') ?></dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-pink-400">Rok vydání</dt>
                    <dd class="mt-1 text-gray-700 font-medium"><?= htmlspecialchars($book['year'] ?? '-') ?></dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-pink-400">Kategorie</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-pink-100 text-pink-600">
                            <?= htmlspecialchars($book['category'] ?? 'Nezařazeno') ?>
                        </span>
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-pink-400">Podkategorie</dt>
                    <dd class="mt-1 text-gray-700 font-medium"><?= htmlspecialchars($book['subcategory'] ?? '-') ?></dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-pink-400">Cena</dt>
                    <dd class="mt-1 text-pink-500 font-bold text-lg">
                        <?= htmlspecialchars($book['price'] ?? '0') ?> Kč
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-pink-400">Odkaz</dt>
                    <dd class="mt-1">
                        <?php if(!empty($book['link'])): ?>
                            <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank" class="text-pink-500 hover:text-pink-600 font-medium underline decoration-pink-300">Koupit / Více info &nearr;</a>
                        <?php else: ?>
                            <span class="text-gray-400">-</span>
                        <?php endif; ?>
                    </dd>
                </div>
                
                <div class="sm:col-span-2 mt-2">
                    <dt class="text-sm font-medium text-pink-400 mb-2">Popis</dt>
                    <dd class="text-gray-700 bg-pink-50/50 p-5 rounded-2xl border border-pink-100 leading-relaxed">
                        <?= nl2br(htmlspecialchars($book['description'] ?? 'Bez popisu.')) ?>
                    </dd>
                </div>
            </dl>

            <div class="mt-8 pt-6 border-t border-pink-100 flex space-x-3">
                <a href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>" class="bg-amber-300 hover:bg-amber-400 text-amber-900 font-bold py-2 px-6 rounded-xl shadow-sm transition">
                    ✏️ Upravit knihu
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>