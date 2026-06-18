<?php
// Načtení potřebných souborů
require_once '../app/models/Database.php';
require_once '../app/models/Book.php';

class BookController {

    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $books = [];
        if ($db) {
            $bookModel = new Book($db);
            $books = $bookModel->getAll(); 
        }
        require_once '../app/views/books/books_list.php';
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro přidání knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        require_once '../app/views/books/Book_Create.php';
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro uložení knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            
            if (!$db) {
                $this->addErrorMessage('Nepodařilo se připojit k databázi.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            $bookModel = new Book($db);
            
            $title = htmlspecialchars($_POST['title'] ?? "");
            $author = htmlspecialchars($_POST['author'] ?? "");
            $isbn = htmlspecialchars($_POST['isbn'] ?? "");
            $category = htmlspecialchars($_POST['category'] ?? "");
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? "");
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? "");
            $description = htmlspecialchars($_POST['description'] ?? "");
            
            $uploadedImages = $this->processImageUploads();

if ($bookModel->create($title, $author, $year, $category, $subcategory, $price, $isbn, $description)) {                $this->addSuccessMessage('Kniha byla úspěšně přidána do knihovny! 🎀');
            } else {
                $this->addErrorMessage('Došlo k chybě při ukládání do databáze.');
            }
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    public function delete($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro smazání knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if (!is_numeric($id) && isset($_GET['url'])) {
            $urlParts = explode('/', rtrim($_GET['url'], '/'));
            $id = end($urlParts);
        }

        if (!$id || !is_numeric($id)) {
            $this->addErrorMessage('Nebylo zadáno platné ID knihy ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();

        if ($db) {
            $bookModel = new Book($db);
            $book = $bookModel->getById($id);

            if (!$book) {
                $this->addErrorMessage('Kniha nebyla nalezena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            // 🛡️ KONTROLA VLASTNICTVÍ PRO MAZÁNÍ
            if ($book['created_by'] !== $_SESSION['user_id']) {
                $this->addErrorMessage('Nemáte oprávnění smazat tuto knihu, protože nejste jejím autorem.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            if ($bookModel->delete($id)) {
                $this->addSuccessMessage('Kniha byla trvale smazána. 🗑️');
            } else {
                $this->addErrorMessage('Knihu se nepodařilo smazat.');
            }
        }
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    public function edit($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if (!is_numeric($id) && isset($_GET['url'])) {
            $urlParts = explode('/', rtrim($_GET['url'], '/'));
            $id = end($urlParts);
        }

        if (!$id || !is_numeric($id)) {
            $this->addErrorMessage('Nebylo zadáno platné ID knihy k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $bookModel = new Book($db);
        $book = $bookModel->getById($id);

        if (!$book) {
            $this->addErrorMessage('Kniha nebyla v databázi nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // 🛡️ KONTROLA VLASTNICTVÍ PRO FORMULÁŘ ÚPRAV (Z tvého návodu)
        if ($book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění upravovat tuto knihu, protože nejste jejím autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/books/book_edit.php';
    }

    public function update($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro uložení úprav se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if (!is_numeric($id) && isset($_GET['url'])) {
            $urlParts = explode('/', rtrim($_GET['url'], '/'));
            $id = end($urlParts);
        }

        if (!$id || !is_numeric($id)) {
            $this->addErrorMessage('Nebylo zadáno platné ID knihy k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = htmlspecialchars($_POST['title'] ?? "");
            $author = htmlspecialchars($_POST['author'] ?? "");
            $isbn = htmlspecialchars($_POST['isbn'] ?? "");
            $category = htmlspecialchars($_POST['category'] ?? "");
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? "");
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? "");
            $description = htmlspecialchars($_POST['description'] ?? "");
            
            $database = new Database();
            $db = $database->getConnection();

            if ($db) {
                $bookModel = new Book($db);
                $existingBook = $bookModel->getById($id);

                if (!$existingBook) {
                    $this->addErrorMessage('Kniha k úpravě nebyla nalezena.');
                    header('Location: ' . BASE_URL . '/index.php');
                    exit;
                }

                // 🛡️ KONTROLA VLASTNICTVÍ PRO ULOŽENÍ ZMĚN
                if ($existingBook['created_by'] !== $_SESSION['user_id']) {
                    $this->addErrorMessage('Nemáte oprávnění ukládat změny u této knihy.');
                    header('Location: ' . BASE_URL . '/index.php');
                    exit;
                }

                $currentImages = [];
                if ($existingBook && !empty($existingBook['images'])) {
                    $currentImages = is_string($existingBook['images']) ? json_decode($existingBook['images'], true) : $existingBook['images'];
                    if (!is_array($currentImages)) $currentImages = [];
                }

                $uploadedImages = $this->processImageUploads();

                if (empty($uploadedImages)) {
                    $uploadedImages = $currentImages;
                }

                if ($bookModel->update($id, $title, $author, $category, $subcategory, $year, $price, $isbn, $description, $link, $uploadedImages)) {
                    $this->addSuccessMessage('Údaje o knize byly úspěšně upraveny. ✨');
                } else {
                    $this->addErrorMessage('Změny se nepodařilo uložit.');
                }
            }
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    public function show($id = null) {
        if (!is_numeric($id) && isset($_GET['url'])) {
            $urlParts = explode('/', rtrim($_GET['url'], '/'));
            $id = end($urlParts);
        }

        if (!$id || !is_numeric($id)) {
            $this->addErrorMessage('Nebylo zadáno platné ID knihy k zobrazení.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();

        if ($db) {
            $bookModel = new Book($db);
            $book = $bookModel->getById($id);

            if (!$book) {
                $this->addErrorMessage('Kniha nebyla v databázi nalezena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }
            require_once '../app/views/books/book_show.php';
        }
    }

    protected function addSuccessMessage($message) {
        $_SESSION['messages']['success'][] = $message;
    }
    protected function addNoticeMessage($message) {
        $_SESSION['messages']['notice'][] = $message;
    }
    protected function addErrorMessage($message) {
        $_SESSION['messages']['error'][] = $message;
    }

    protected function processImageUploads() {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $tmpName);
                    finfo_close($finfo);

                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    
                    if (!in_array($mime, $allowedMimeTypes)) {
                        $this->addErrorMessage('Soubor není platný obrázek! ❌');
                        continue; 
                    }

                    $originalName = basename($_FILES['images']['name'][$i]);
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    $newName = 'book_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 4) . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        $uploadedFiles[] = $newName;
                    }
                }
            }
        }
        return $uploadedFiles;
    }
}