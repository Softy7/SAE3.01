<?php
class Connexion {

    protected $db;

    function __construct() {
        $this->db = new PDO('pgsql:host=localhost;dbname=postgres','postgres','ThomasMathieu1810');
    }

    function getUser($username) {
        $req = $this->db->prepare("Select * from guests where username = :username");
        $req->bindValue(':username', $username);
        $req->execute();
        return $req->fetchAll();
    }

    function checkPassword($password, $user): bool
    {
        $User = $this->getUser($user);
        return password_verify($password, $User[0][5]);
    }

    function insertNewGuest($name, $FirstName, $email, $Birth, $User, $Password, $PasswordC): int {

        if ($Password != $PasswordC) {
            return 2;
        }

        if (strlen($Password) < 6) {
            return 3;
        } else {

            $stmt = $this->db->prepare("select username, mail from Guests where username = :user or mail = :email;");
            $stmt->bindValue(':user', $User);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $stmt = $stmt->fetchAll();
            if ($stmt == null) {
                $Password=password_hash($Password, PASSWORD_DEFAULT);

                $stmt = $this->db->prepare("INSERT INTO Guests VALUES (:User, :email, :name, :FirstName, :Birth, :Password, false, false, false, false, null)");
                $stmt->bindValue(':User', $User);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':name', $name);
                $stmt->bindValue(':FirstName', $FirstName);
                $stmt->bindValue(':Birth', $Birth);
                $stmt->bindValue(':Password', $Password);
                $stmt->execute();
                return 0;
            } else {
                return 1;
            }
        }
    }

    function checkCapitain($username) {
        $request = $this->db->prepare("SELECT count(*)
                                FROM capitain 
                                WHERE username = :user ");//recherche le pseudo et mots de passe dans la base de donné et regarde si l'administrateur a accepter sa demande pour devenir membre et regarde si l'utilisateur ne s'est pas désinscrit au préalable
        $request->bindValue(':user',$username);
        $request->execute();
        $result = $request->fetchAll();
        return $result[0][0];
    }

    function enoughtPlayer() {
        $request = $this->db->prepare("SELECT count(*)
                                FROM guests 
                                WHERE isPlayer = true and team is null");//recherche le pseudo et mots de passe dans la base de donné et regarde si l'administrateur a accepter sa demande pour devenir membre et regarde si l'utilisateur ne s'est pas désinscrit au préalable
        $request->execute();
        return $request->fetchAll()[0][0] >= 3;
    }
}