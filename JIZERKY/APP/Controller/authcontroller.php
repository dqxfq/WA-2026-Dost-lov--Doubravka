<?php

require_once '../APP/Modely/database.php';
require_once '../APP/Modely/uzivatel.php';

class AuthController {

    public function registrace() {
        require_once '../APP/Views/Users/registrace.php';
    }

    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = htmlspecialchars($_POST['username'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $firstName = htmlspecialchars($_POST['first_name'] ?? '');
            $lastName = htmlspecialchars($_POST['last_name'] ?? '');
            $nickname = htmlspecialchars($_POST['nickname'] ?? '');

            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vyplňte povinná pole.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/registrace');
                exit;
            }

            if ($password !== $passwordConfirm) {
                $_SESSION['error'] = 'Hesla se neshodují.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/registrace');
                exit;
            }

            if (strlen($password) < 8 || !preg_match('/[0-9]/', $password)) {
                $_SESSION['error'] = 'Heslo musí mít alespoň 8 znaků a obsahovat číslo.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/registrace');
                exit;
            }

            $db = (new Database())->getConnection();
            $uzivatelModel = new Uzivatel($db);

            if ($uzivatelModel->register($username, $email, $password, $firstName, $lastName, $nickname)) {
                $_SESSION['success'] = 'Registrace proběhla úspěšně. Teď se přihlaste.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
                exit;
            }

            $_SESSION['error'] = 'Uživatel s tímto e-mailem už existuje.';
            header('Location: ' . BASE_URL . '/index.php?url=auth/registrace');
            exit;
        }
    }

    public function prihlaseni() {
        require_once '../APP/Views/Users/prihlaseni.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $db = (new Database())->getConnection();
            $uzivatelModel = new Uzivatel($db);

            $user = $uzivatelModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = !empty($user['nickname']) ? $user['nickname'] : $user['username'];

                $_SESSION['success'] = 'Jste přihlášen/a.';
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            $_SESSION['error'] = 'Nesprávný e-mail nebo heslo.';
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }
    }

    public function profil() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Nejdříve se přihlaste.';
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        $db = (new Database())->getConnection();
        $uzivatelModel = new Uzivatel($db);

        $uzivatel = $uzivatelModel->findById($_SESSION['user_id']);

        require_once '../APP/Views/Users/profil.php';
    }

    public function updateProfil() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Nejdříve se přihlaste.';
            header('Location: ' . BASE_URL . '/index.php?url=auth/prihlaseni');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nickname = htmlspecialchars(trim($_POST['nickname'] ?? ''));
            $email = htmlspecialchars(trim($_POST['email'] ?? ''));

            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if (empty($email)) {
                $_SESSION['error'] = 'E-mail nesmí být prázdný.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/profil');
                exit;
            }

            if (!empty($password)) {
                if ($password !== $passwordConfirm) {
                    $_SESSION['error'] = 'Hesla se neshodují.';
                    header('Location: ' . BASE_URL . '/index.php?url=auth/profil');
                    exit;
                }

                if (strlen($password) < 8 || !preg_match('/[0-9]/', $password)) {
                    $_SESSION['error'] = 'Heslo musí mít alespoň 8 znaků a obsahovat číslo.';
                    header('Location: ' . BASE_URL . '/index.php?url=auth/profil');
                    exit;
                }
            }

            $db = (new Database())->getConnection();
            $uzivatelModel = new Uzivatel($db);

            if ($uzivatelModel->emailExistsForOtherUser($email, $_SESSION['user_id'])) {
                $_SESSION['error'] = 'Tento e-mail už používá jiný uživatel.';
                header('Location: ' . BASE_URL . '/index.php?url=auth/profil');
                exit;
            }

            $upraveno = $uzivatelModel->updateProfile(
                $_SESSION['user_id'],
                $nickname,
                $email,
                $password
            );

            if ($upraveno) {
                $_SESSION['user_name'] = !empty($nickname) ? $nickname : $email;

                $_SESSION['success'] = 'Profil byl upraven.';
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            $_SESSION['error'] = 'Profil se nepodařilo upravit.';
            header('Location: ' . BASE_URL . '/index.php?url=auth/profil');
            exit;
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);

        $_SESSION['success'] = 'Byli jste odhlášeni.';
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}