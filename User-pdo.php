<?php


class User
{

    // Attributs

    private $id;
    public $login;
    private $password;
    public $email;
    public $firstname;
    public $lastname;
    protected $bdd;
    public $sqlRequest;

    // le constructeur

    public function __construct()
    {
        session_start();

        $servername = 'localhost';
        $username = 'root';
        $password = '';
        
        try {
            $this->bdd = new PDO("mysql:host=$servername;dbname=classes", $username, $password);
        
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'Connexion réussie <br>';
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

    }

    // les méthodes

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $insertUser = $this->bdd->prepare("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES(?, ?, ?, ?, ?)");
        $insertUser->execute([$login, $password, $email, $firstname, $lastname]);

        $recupUser = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $utilisateurs=$recupUser->fetch(PDO::FETCH_ASSOC);

        echo 'bien enregistré<br>';
        return $utilisateurs;

    }

    public function connect($login, $password)
    {
        $recupUser = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? AND password = ?");
        $recupUser->execute([$login, $password]);
        $utilisateurs=$recupUser->fetch(PDO::FETCH_ASSOC);
        $rowcount = $recupUser->rowCount();
        
        if ($rowcount > 0) {
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            echo 'bienvenue ' . $_SESSION['login'] . "<br>";
            //   } else {
            //     echo "Mot de passe incorrect ! <br>";
            //   }
        } else {
            echo "Login inconnu ! <br>";
        }
    }

    public function disconnect()
    {
        session_destroy();
        echo 'déco<br>';
    }

    public function delete()
    {
        $delete_user = $this->bdd->prepare("DELETE FROM utilisateurs WHERE login = ?");
        $delete_user->execute([$_SESSION['login']]);
    
        session_destroy();
        echo 'destruction <br>';
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {
        $updateRequest = $this->bdd->prepare("UPDATE utilisateurs SET login=?, password=?, email=?, firstname=?, lastname=? WHERE login = '" . $_SESSION['login'] . "'");
        $updateRequest->execute([$login, $password, $email, $firstname, $lastname]);
    }

    public function isConnected()
    {
        if (isset($_SESSION['login'])) {
            return true;
            // var_dump($_SESSION);
        } else {
            return false;
        }
    }

    public function getAllInfos()
    {
        $recupUser = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $utilisateurs=$recupUser->fetch(PDO::FETCH_ASSOC);

        return $utilisateurs;
    }

    public function getLogin()
    {
        $recupUser = $this->bdd->prepare("SELECT login FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $utilisateurs=$recupUser->fetch(PDO::FETCH_ASSOC);
        
        return $utilisateurs;
    }

    public function getEmail()
    {
        $recupUser = $this->bdd->prepare("SELECT email FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $utilisateurs=$recupUser->fetch(PDO::FETCH_ASSOC);
        
        return $utilisateurs;
    }

    public function getFirstname()
    {
        $recupUser = $this->bdd->prepare("SELECT firstname FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $utilisateurs=$recupUser->fetch(PDO::FETCH_ASSOC);

        return $utilisateurs;
    }

    public function getLastname()
    {
        $recupUser = $this->bdd->prepare("SELECT lastname FROM utilisateurs WHERE login = ?");
        $recupUser->execute([$_SESSION['login']]);
        $utilisateurs=$recupUser->fetch(PDO::FETCH_ASSOC);

        return $utilisateurs;
    }
}

$newUser = new User();

// $newUser-> register ('testPDO', 'testPDO', 'PDO@test.fr', 'PDO', 'PDO');

$newUser->connect('PDOtest', 'PDOtest');

// $newUser-> disconnect();

// $newUser->delete();

// $newUser-> update ('PDOtest', 'PDOtest', 'test@test.fr', 'test', 'test');

// $newUser-> isConnected();

// $newUser->getAllInfos();

var_dump($newUser->getEmail());

// $newUser->getLogin();

// test de message de confirmation Isconnected connecté ou déco
// if ($newUser->isConnected()) {
//     echo 'bien connecté<br>';
// } else {
//     echo 'vous êtes déco<br>';
// }
// 
// var_dump($newUser->register('login', 'password', 'email', 'firstname', 'lastname'));