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
    public $result;

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
        // $query = "UPDATE utilisateurs SET login ='" . $login . "', prenom ='" . $prenom . "', nom ='" . $nom . "', password ='" . $password . "' WHERE id='" . $id . "'";
        // mysqli_query($conn, $query);
    }

    // les méthodes

    public function register($login, $password, $email, $firstname, $lastname)
    {
        $this->bdd->query("INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES('$login', '$password', '$email', '$firstname', '$lastname')");

        // $this->sqlRequest=('SELECT * FROM utilisateurs');
        // $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        // $utilisateurs = $utilisateursStatement->fetch_all(MYSQLI_ASSOC);
        // var_dump($utilisateurs[0]);

        echo 'bien enregistré<br>';
        // return $utilisateurs[0];

        // -- $this->login;
        // -- $this->password;
        // -- $this->email;
        // -- $this->firstname;
        // -- $this->lastname;
    }

    public function connect($login, $password)
    {
        $this->sqlRequest = ("SELECT * FROM utilisateurs WHERE login = '$login'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_all(MYSQLI_ASSOC);
        $rowcount = mysqli_num_rows($utilisateursStatement);

        if ($rowcount > 0) {
            //   if ($utilisateurs['password'] == $password) {
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
        $utilisateurs = $utilisateursStatement->fetch_all(MYSQLI_ASSOC);
        var_dump($utilisateurs);
?>
        <table>
            <h2>Informations des users</h2>

            <thead>
                <tr>
                    <th>login</th>
                    <th>password</th>
                    <th>email</th>
                    <th>firstname</th>
                    <th>lastname</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($utilisateurs as $utilisateur) {
                ?>
                    <tr>
                        <?php echo "<td>" . $utilisateur['login'] . "</td>" ?>
                        <?php echo "<td>" . $utilisateur['password'] . "</td>" ?>
                        <?php echo "<td>" . $utilisateur['email'] . "</td>" ?>
                        <?php echo "<td>" . $utilisateur['firstname'] . "</td>" ?>
                        <?php echo "<td>" . $utilisateur['lastname'] . "</td>" ?>
                    <?php
                }
                    ?>
                    </tr>
            </tbody>
        </table>
<?php
        return $utilisateurs;
    }

    public function getLogin()
    {
        $this->sqlRequest = ("SELECT * FROM utilisateurs WHERE login = '" . $_SESSION['login'] . "'");
        $utilisateursStatement = $this->bdd->query($this->sqlRequest);
        $utilisateurs = $utilisateursStatement->fetch_all(MYSQLI_ASSOC);

        echo $utilisateurs[0]['email'];
    }
}

$newUser = new User;

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
    echo 'bien connecté';
} else {
    echo 'vous êtes déco';
}
// 