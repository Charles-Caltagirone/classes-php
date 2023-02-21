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

        $this->bdd = mysqli_connect("localhost", "root", "", "classes");

        if (!$this->bdd) {
            die("connexion lost");
        } else {
            echo "connexion bdd établie<br>";
        }
    }

    // les méthodes

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $this->bdd->query("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES('$login', '$password', '$email', '$firstname', '$lastname')");

        $this->sqlRequest = ("SELECT * FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_array(MYSQLI_ASSOC);

        echo 'bien enregistré<br>';
        return $utilisateurs;

    }

    public function connect($login, $password)
    {
        $this->sqlRequest = ("SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_all(MYSQLI_ASSOC);
        $rowcount = mysqli_num_rows($utilisateursStatement);

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
        $this->bdd->query("DELETE FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        session_destroy();
        echo 'destruction <br>';
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {
        $this->bdd->query("UPDATE utilisateurs SET login ='$login', password ='$password', email ='$email', firstname ='$firstname', lastname ='$lastname' WHERE login='" . $_SESSION['login'] . "'");
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
        $this->sqlRequest = ("SELECT * FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_array(MYSQLI_ASSOC);
        // var_dump($utilisateurs);
        
        return $utilisateurs;
    }

    public function getLogin()
    {
        $this->sqlRequest = ("SELECT login FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_array(MYSQLI_ASSOC);
        
        return $utilisateurs;
    }

    public function getEmail()
    {
        $this->sqlRequest = ("SELECT email FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_all(MYSQLI_ASSOC);
        
        return $utilisateurs[0];
    }

    public function getFirstname()
    {
        $this->sqlRequest = ("SELECT firstname FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_all(MYSQLI_ASSOC);
        
        return $utilisateurs[0];
    }

    public function getLastname()
    {
        $this->sqlRequest = ("SELECT lastname FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_all(MYSQLI_ASSOC);
        
        return $utilisateurs[0];
    }
}

$newUser = new User();

// $newUser-> register ('test', 'test', 'test@test.fr', 'test', 'test');

$newUser->connect('test', 'test');

// $newUser-> disconnect();

// $newUser-> delete();

// $newUser-> update ('test', 'test', 'test@test.fr', 'test', 'test');

// $newUser-> isConnected();

// $newUser->getAllInfos();

$newUser->getLogin();

// test de message de confirmation Isconnected connecté ou déco
if ($newUser->isConnected()) {
    echo 'bien connecté<br>';
} else {
    echo 'vous êtes déco<br>';
}
// 
var_dump($newUser->register('login', 'password', 'email', 'firstname', 'lastname'));