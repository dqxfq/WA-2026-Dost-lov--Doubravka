<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>FairyLib - Aplikace Knihovna 🌿</title>
</head>

<body class="bg-[#EEF3E2] text-[#2F3E2F] font-serif antialiased">
    
    <header class="bg-[#F8F5E8] shadow-sm border-b-4 border-[#5E7C45]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            
            <a href="<?= BASE_URL ?>/index.php" class="flex items-center gap-3 group">
                <<img src="<?= BASE_URL ?>/images/logo.png" alt="FairyLib Logo" class="h-10 w-auto transition-transform group-hover:scale-110">
                <span class="text-2xl font-bold text-[#2F4F2F]">FairyLib</span>
            </a>

            <nav>
                <ul class="flex space-x-6 items-center">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="text-[#6B5E3A] hover:text-[#2F4F2F] font-medium transition">
                            Seznam knih
                        </a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=book/create" 
                               class="bg-[#5E7C45] text-[#F8F5E8] px-5 py-2 rounded-full hover:bg-[#3F5F2F] transition font-medium shadow-sm flex items-center gap-2">
                               📖 <span class="hidden sm:inline">Přidat knihu</span>
                            </a>
                        </li>

                        <li class="text-sm text-[#6B5E3A]">
                            Ahoj, 
                            <span class="font-bold text-[#2F4F2F]">
                                <?= htmlspecialchars($_SESSION['user_name']) ?>
                            </span>
                        </li>

                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/logout" 
                               class="text-[#5E7C45] hover:text-[#2F4F2F] text-sm font-medium transition">
                                Odhlásit
                            </a>
                        </li>

                    <?php else: ?>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/login" 
                               class="text-[#6B5E3A] hover:text-[#2F4F2F] font-medium transition">
                                Přihlásit
                            </a>
                        </li>

                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/register" 
                               class="border-2 border-[#5E7C45] text-[#5E7C45] px-5 py-2 rounded-full hover:bg-[#5E7C45] hover:text-[#F8F5E8] transition font-medium shadow-sm">
                                Registrace
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="mb-6 space-y-3">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php
                        $bgClass = 'bg-[#F8F5E8]';
                        $textClass = 'text-[#2F3E2F]';
                        $borderClass = 'border-[#C9D8A9]';

                        if ($type === 'success') {
                            $bgClass = 'bg-green-50';
                            $textClass = 'text-green-700';
                            $borderClass = 'border-green-300';
                        } elseif ($type === 'error') {
                            $bgClass = 'bg-red-50';
                            $textClass = 'text-red-700';
                            $borderClass = 'border-red-300';
                        } elseif ($type === 'notice') {
                            $bgClass = 'bg-yellow-50';
                            $textClass = 'text-yellow-700';
                            $borderClass = 'border-yellow-300';
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