<?php

require_once '../APP/Modely/database.php';
require_once '../APP/Modely/místa.php';
require_once '../APP/Modely/koment.php';

class Místacontroller {

    public function index() {

        $db = (new Database())->getConnection();
        $mistaModel = new Mista($db);

        $mista = $mistaModel->getAll();

        require_once '../APP/Views/Místa/list_místa.php';
    }

    public function detail($id) {

        $db = (new Database())->getConnection();

        $mistaModel = new Mista($db);
        $komentModel = new Koment($db);

        $misto = $mistaModel->getById($id);
        $komentare = $komentModel->getByMistoId($id);

        require_once '../APP/Views/Místa/detail_mista.php';
    }

    public function pridani() {

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        require_once '../APP/Views/Místa/pridani_mista.php';
    }

    public function ulozit() {

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nazev = htmlspecialchars($_POST['nazev'] ?? '');
            $lokalita = htmlspecialchars($_POST['lokalita'] ?? '');
            $kategorie = htmlspecialchars($_POST['kategorie'] ?? '');
            $popis = htmlspecialchars($_POST['popis'] ?? '');

            $obrazek = null;

            if (
                isset($_FILES['obrazek']) &&
                $_FILES['obrazek']['error'] === 0
            ) {

                $nazevSouboru =
                    time() . '_' . basename($_FILES['obrazek']['name']);

                move_uploaded_file(
                    $_FILES['obrazek']['tmp_name'],
                    '../PUBLIC/images/' . $nazevSouboru
                );

                $obrazek = $nazevSouboru;
            }

            $db = (new Database())->getConnection();
            $mistaModel = new Mista($db);

            $mistaModel->create(
                $nazev,
                $lokalita,
                $kategorie,
                $popis,
                $obrazek,
                $_SESSION['user_id']
            );

            $_SESSION['success'] = 'Místo bylo přidáno.';

            header('Location: ' . BASE_URL . '/index.php');
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

        $misto = $mistaModel->getById($id);

        if (!$misto || $misto['created_by'] != $_SESSION['user_id']) {

            $_SESSION['error'] = 'Toto místo nemůžete upravit.';

            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../APP/Views/Místa/upravit_misto.php';
    }

    public function update($id) {

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        $db = (new Database())->getConnection();
        $mistaModel = new Mista($db);

        $misto = $mistaModel->getById($id);

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

        $mistaModel->delete($id);

        $_SESSION['success'] = 'Místo bylo smazáno.';

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}