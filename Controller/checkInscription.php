<?php
session_start();
$conn = new PDO ("pgsql:host=localhost;dbname=postgres",'postgres','v1c70I83');
$name = $_POST['name'];
$FirstName = $_POST['firstname'];
$email = $_POST['email'];
$Birth = $_POST['birth'];
$User = $_POST['user'];
$Password = $_POST['password'];

$req = $conn->prepare("Select open from Inscription");
$req->execute();
$result = $req->fetchAll();

if ($result[0][0] == 1) {//à modifier
    if ($name == null ||
    $FirstName == null ||
    $email == null ||
    $Birth == null ||
    $User == null ||
    $Password == null) {
        header("../View/Unregistering/DeclinedRegisteringWebsite");
        exit;
    } else {
    $stmt = $conn->prepare("select username, mail from Guests where username = :User or mail = :email;");
    $stmt->bindValue(':User',$User);
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $stmt = $stmt->fetchAll();
    if ($stmt == null) {
        $stmt = $conn->prepare("INSERT INTO Guests VALUES (:User, :email, :name, :FirstName, :Birth, :Password, true, false, true, null, null)");
        $stmt->bindValue(':User',$User);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':name',$name);
        $stmt->bindValue(':FirstName', $FirstName);
        $stmt->bindValue(':Birth',$Birth);
        $stmt->bindValue(':Password',$Password);
        $stmt->execute();
        }
    }
}
