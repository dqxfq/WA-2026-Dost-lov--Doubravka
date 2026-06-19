<?php
// Tento controller se stará o všechny akce týkající se míst, tedy zobrazení seznamu míst, detailu místa, přidání, úpravy a smazání místa

//načtení souborů co bude používat 
require_once '../APP/Modely/database.php';
require_once '../APP/Modely/místa.php';
require_once '../APP/Modely/koment.php';

class Místacontroller { // název třídy musí být stejný jako název controlleru, který je v app.php, ale bez "Controller" na konci, tedy Místacontroller
// zde jsou metody co mi umí místacontroller dělat

    public function index() { //metoda pro zobrazení seznamu míst, tedy hlavní stránka s místy

        $db = (new Database())->getConnection(); // propojení k databázi
        $mistaModel = new Mista($db); // vytvoření instance modelu Mista, který se stará o práci s tabulkou míst v databázi, a předání připojení k databázi do konstruktoru modelu

        $mista = $mistaModel->getAll(); 

        require_once '../APP/Views/Místa/list_místa.php'; // načtení pohledu pro zobrazení seznamu míst, který se nachází v APP/Views/Místa/list_místa.php
    }

    public function detail($id) { // id ej číslo místa, které se má zobrazit, a je to parametr, který se předává metodě z URL, tedy localhost/Jizerky/PUBLIC/index.php?url=mista/detail/5, kde 5 je id místa

        $db = (new Database())->getConnection();

        $mistaModel = new Mista($db);
        $komentModel = new Koment($db);

        $misto = $mistaModel->getById($id); // načtení konkr. místa
        $komentare = $komentModel->getByMistoId($id); // načtení komentářů pro konkr. místo, tedy všechny komentáře, které mají v tabulce komentů id místa stejné jako id místa, které se zobrazuje

        require_once '../APP/Views/Místa/detail_mista.php';
    }

    public function pridani() { // zobrazení formuláře pro přidání

        if (!isset($_SESSION['user_id'])) { // pokud není uživatel přihlášen, přesměruj ho na přihlašovací stránku, protože jen přihlášení uživatelé můžou přidávat místa
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        require_once '../APP/Views/Místa/pridani_mista.php'; //ukaž formulář
    }

    public function ulozit() {

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // kontrola byl li formulář opravdu odeslaný
        // htmlspecialchars je funkce, která převádí speciální znaky na HTML entity, aby se zabránilo XSS útokům, tedy aby uživatel nemohl vložit do formuláře škodlivý kód, který by se spustil v prohlížeči jiného uživatele

            $nazev = htmlspecialchars($_POST['nazev'] ?? '');
            $lokalita = htmlspecialchars($_POST['lokalita'] ?? '');
            $kategorie = htmlspecialchars($_POST['kategorie'] ?? '');
            $popis = htmlspecialchars($_POST['popis'] ?? '');

            $obrazek = null; // jetli nebyl obrázek uloží se null

            if ( // kontrola jestli byl obrázek nahrán a jestli nebyla chyba při nahrávání
                isset($_FILES['obrazek']) &&
                $_FILES['obrazek']['error'] === 0
            ) {

                $nazevSouboru = //nazev souboru se skládá z aktuálního času v sekundách od 1.1.1970 a původního názvu souboru, aby se zajistilo, že název souboru bude unikátní a nepřepíše existující soubor s tímto názvem
                    time() . '_' . basename($_FILES['obrazek']['name']); // time() je funkce, která vrací aktuální čas v sekundách od 1.1.1970, takže se tím zajistí unikátní název souboru, aby se nepřepsal existující soubor s tímto názvem

                move_uploaded_file( // přesune nahraný soubor z dočasného umístění na serveru do cílového umístění, tedy do složky ../PUBLIC/images/ s unikátním názvem souboru
                    $_FILES['obrazek']['tmp_name'],
                    '../PUBLIC/images/' . $nazevSouboru
                );

                $obrazek = $nazevSouboru;
            }

            $db = (new Database())->getConnection(); // propojení k databázi  
            $mistaModel = new Mista($db);

            $mistaModel->create( // vytvoření nového místa v databázi, tedy vložení nového záznamu do tabulky míst
                $nazev,
                $lokalita,
                $kategorie,
                $popis,
                $obrazek,
                $_SESSION['user_id']
            );

            $_SESSION['success'] = 'Místo bylo přidáno.'; //po uspěchus se zobarzí místo bylo..

            header('Location: ' . BASE_URL . '/index.php'); // přesměrování na hlavní stránku s místy po úspěšném přidání místa
            exit;
        }
    }

    public function upravit($id) {

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        $db = (new Database())->getConnection(); 
        $mistaModel = new Mista($db);

        $misto = $mistaModel->getById($id); //načtení konkrétního místa

        // jestli to není uživatel, co místo vytvořil, tak ho nesmí uravovat
        if (!$misto || $misto['created_by'] != $_SESSION['user_id']) { 

            $_SESSION['error'] = 'Toto místo nemůžete upravit.';

            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../APP/Views/Místa/upravit_misto.php';
    }

    public function update($id) { //uložení upraveného místa

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        $db = (new Database())->getConnection(); 
        $mistaModel = new Mista($db);

        $misto = $mistaModel->getById($id); //načtení místa

        // jestli to není uživatel, co místo vytvořil, tak ho nesmí uravovat
        if (!$misto || $misto['created_by'] != $_SESSION['user_id']) { 

            $_SESSION['error'] = 'Toto místo nemůžete upravit.';

            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nazev = htmlspecialchars($_POST['nazev'] ?? '');
            $lokalita = htmlspecialchars($_POST['lokalita'] ?? '');
            $kategorie = htmlspecialchars($_POST['kategorie'] ?? '');
            $popis = htmlspecialchars($_POST['popis'] ?? '');

            $mistaModel->update(
                $id,
                $nazev,
                $lokalita,
                $kategorie,
                $popis
            );

            $_SESSION['success'] = 'Místo bylo upraveno.';

            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    public function smazat($id) {

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        $db = (new Database())->getConnection();
        $mistaModel = new Mista($db);

        $misto = $mistaModel->getById($id);

        if (!$misto || $misto['created_by'] != $_SESSION['user_id']) {

            $_SESSION['error'] = 'Toto místo nemůžete smazat.';

            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $mistaModel->delete($id); // smazání místa z databáze

        $_SESSION['success'] = 'Místo bylo smazáno.';

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}