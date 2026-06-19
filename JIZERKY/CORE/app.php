<?php
// Hlavní třída aplikace, která podle URL rozhoduje, jaký controller a metoda se spustí


class App { //návod na fungování hlavní apikace - podle URL rozhoduje, jaký controller a metoda se spustí

    protected $controller = 'Místacontroller'; // Jestli není zvoleno jinak je tento controller výchozí
    protected $method = 'index'; // Jestli není zvoleno jinak je tato metoda výchozí (metoda = fce uvnitř třídy)
    protected $params = []; // Pole pro parametry, které se předávají metodě (např. id místa)

    public function __construct() { //konstruktor se spustí hned po vytvoření instance třídy App, tedy hned po spuštění aplikace

        $url = $this->parseUrl(); // Načtení a rozdělení URL adresy na jednotlivé části = mista | detail | 5

        if (isset($url[0])) { //$url[0] první část url, tedy mista nebo auth nebo komenty

            if ($url[0] === 'auth') { // === porovnává hodnotu i typ, takže musí být přesně 'auth'
                $this->controller = 'AuthController';
                require_once '../APP/Controller/authcontroller.php';
                unset($url[0]);

            } elseif ($url[0] === 'mista' || $url[0] === 'místa') {
                $this->controller = 'Místacontroller';
                require_once '../APP/Controller/místacontroller.php';
                unset($url[0]);

            } elseif ($url[0] === 'komenty') {
                $this->controller = 'KomentyController';
                require_once '../APP/Controller/komentycontroller.php';
                unset($url[0]);

            } else { // není li naplněna žádná z předchozích možností, spust prostě místacontroller, aby se zobrazila hlavní stránka s místy
                require_once '../APP/Controller/místacontroller.php';
                unset($url[0]); // odstraň položku číslo 0 z pole $url, aby zůstaly jen parametry pro metodu (např. id místa)
            }

        } else { // pokud není v URL žádná část, tedy jen localhost/Jizerky/PUBLIC, spust místacontroller, aby se zobrazila hlavní stránka s místy
            require_once '../APP/Controller/místacontroller.php';
        }

        $this->controller = new $this->controller; // -> podívej se do proměnné $this->controller, která obsahuje název controlleru, a vytvoř novou instanci této třídy (např. new Místacontroller)
    // na začátku mám definnovaný controller jako  ísta contr. ted ho nahradím jiným
        
        if (isset($url[1])) { // jsme v controller a je tam metoda, která se má spustit (např. detail nebo edit nebo delete)
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        // vem všechno co v url zbylo, a ulož to do pole $this->params, aby se to předalo metodě (např. id místa)
        $this->params = $url ? array_values($url) : []; // pokud je v url něco, parametr místa, tak se to uloží do pole $this->params, jinak se uloží prázdné pole

        call_user_func_array([$this->controller, $this->method], $this->params);
        // smuštění konkrétní metody controlleru s parametry, které se předávají metodě (např. id místa)
        }


    public function parseUrl() { // Načtení a rozdělení URL adresy na jednotlivé části = mista | detail | 5
        if (isset($_GET['url'])) {
            return explode('/', trim($_GET['url'], '/'));
        }

        return []; // vrať prázdné pole, pokud není v URL nic
    }
}