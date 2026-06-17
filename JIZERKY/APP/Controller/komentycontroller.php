<?php

require_once '../APP/Modely/database.php';
require_once '../APP/Modely/koment.php';

class KomentyController {

    public function ulozit() {

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $mistoId = $_POST['misto_id'] ?? null;
            $obsah = htmlspecialchars($_POST['obsah'] ?? '');

            if (!empty($mistoId) && !empty($obsah)) {

                $db = (new Database())->getConnection();
                $komentModel = new Koment($db);

                $komentModel->create(
                    (int)$mistoId,
                    (int)$_SESSION['user_id'],
                    $obsah
                );
            }

            header('Location: ' . BASE_URL . '/index.php?url=mista/detail/' . $mistoId);
            exit;
        }
    }

    public function smazat($id, $mistoId) {

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        $db = (new Database())->getConnection();
        $komentModel = new Koment($db);

        $komentModel->delete($id);

        header('Location: ' . BASE_URL . '/index.php?url=mista/detail/' . $mistoId);
        exit;
    }
}