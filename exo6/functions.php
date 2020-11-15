<?php
require "Medoo.php";
use Medoo\Medoo;
/* SOMMAIRE
 * 0/ fonction de connexion à la bdd
 * 1/ Vérification du format de l'adresse mail (booléen)
 * 2/ Vérification de l'existence d'un utilisateur (booléen)
 * 3/ Récupération du mdp de l'utilisateur
 * 4/ Récuperation de toutes les données de l'utilisateur
 * 5/ Récupération de toutes les données d'une table
 * 6/ On supprime un utilisateur en fonction de son id
 * 7/ Mise à jour d'un utilisateur sans mdp
 * 8/ Mise à jour d'un utilisateur avec mdp
 * 9/ Création d'un nouvel utilisateur dans table utilisateurs
 * 10/ Création d'un nouvel utilisateur dans table connexions
 * 11/ Comptabiliser le nombre de connexions en 15 mn (table connexions)
 * 12/ Création d'une nouvelle entrée dans table ban
 * 13/ Vérification utilisateur banni (Booléen)
 * 14/ Création d'une nouvelle entrée dans table token
 * 15/ Vérification de la validité d'un hash (dans le temps) pour un reset de password
 * 16/ Récupération du nom d'un utilisateur dans la table utilisateurs
 * 17/ Modification mdp dans la table utilisateurs
 * 18/ Récupération d'un email lié au token de l'utilisateur dans la table token
 * */
    /* 0/ fonction de connexion à la bdd */
    function connexMedoo()
    {
        $database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'nbdd',
            'server' => 'localhost',
            'username' => 'root',
            'password' => 'root'
        ]);
        return $database;
    }
    /* 1/ Vérification du format de l'adresse mail */
    function verifPass($var)
    {
        $upper = preg_match('@[A-Z]@', $var);
        $lower = preg_match('@[a-z]@', $var);
        $number = preg_match('@[0-9]@', $var);
        if (strlen($var) >= 8 && $upper && $lower && $number) {
            return true;
        } else {
            return false;
        }
    }
    /* 2/ Vérification de l'existence d'un utilisateur (booléen) */
     function verifUser($var)
    {
        $bdd = connexMedoo();
        $user = $bdd->count('utilisateurs', [
            'email' => $var
        ]);
        if($user > 0){
            return true;
        } else {
            return false;
        }
    }
    /*  3/ Récupération du mdp de l'utilisateur */
     function getUserPass($var)
    {
        $bdd = connexMedoo();
        $pass = $bdd->get('utilisateurs', 'mdp',[
           'email' => $var
        ]);
        if(!empty($pass)) {
            return $pass;
        } else {
            return false;
        }
    }
    /* 4/ Récuperation de toutes les données de l'utilisateur */
    function getUserInfos($var)
    {
        $bdd = connexMedoo();
        $userInfos = $bdd->get('utilisateurs',[
            'nom', 'prenom', 'email', 'pro_or_not'
        ],[
            'id' => $var
        ]);
        return $userInfos;
    }
    /* 5/ Récupération de toutes les données d'une table */
    function getAllInfos()
    {
        $bdd = connexMedoo();
        $table = $bdd->select('utilisateurs', '*');
        if(!empty($table)) {
            return $table;
        } else {
            return false;
        }
    }
    /* 6/ On supprime un utilisateur en fonction de son id */
    function eraseUserById($var)
    {
        $bdd = connexMedoo();
        $bdd->delete("utilisateurs", [
            'id' => $var
        ]);
    }
    /* 7/ Mise à jour d'un utilisateur  */
    function updateUser($id, $nom, $prenom, $email, $pro_or_not, $date)
    {
        $bdd = connexMedoo();
        $bdd->update('utilisateurs',[
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'pro_or_not' => $pro_or_not,
            'date' => $date
        ],[
            'id' => $id
        ]);
    }
    /* 8/ Mise à jour d'un utilisateur avec mdp */
    function updateUserPass($id, $nom, $prenom, $email, $pro_or_not, $mdp, $date)
    {
        $bdd = connexMedoo();
        $bdd->update('utilisateurs',[
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'pro_or_not' => $pro_or_not,
            'mdp' => $mdp,
            'date' => $date
        ],[
            'id' => $id
        ]);
    }

    /* 9/ Création d'un nouvel utilisateur dans table utilisateurs */
    function createUserUtil($nom, $prenom, $email, $pro_or_not, $mdp, $date)
    {
        $bdd = connexMedoo();
        $bdd->insert('utilisateurs', [
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'pro_or_not' => $pro_or_not,
            'mdp' => $mdp,
            'date' => $date
        ]);
    }
    /* 10/ Création d'un nouvel utilisateur dans table connexions */
    function createUserConn($email, $date)
    {
        $bdd = connexMedoo();
        $bdd->insert('connexions', [
            'login' => $email,
            'date' => $date
        ]);
    }
    /* 11/ Comptabiliser le nombre de connexions en 15 mn (table connexions)*/
    function howManyTries($email, $passDate)
    {
        $bdd = connexMedoo();
        $total = $bdd->count('connexions', '*', [
            'login' => $email,
            'date[>]' => $passDate
        ]);
        if(!empty($total)) {
            return $total;
        } else {
            return false;
        }
    }
    /* Création d'une nouvelle entrée dans table bans */
    function insertInBan($email, $date)
    {
        $bdd = connexMedoo();
        $bdd->insert('ban',[
            'email' => $email,
            'date' => $date
        ]);
    }
    /* 13/ Vérification utilisateur banni */
    function verifUserBan($email, $date)
    {
        $bdd = connexMedoo();
        $isUserBan = $bdd->get('ban', '*',[
            'email' => $email,
            'date[>]' => $date
        ]);
        if(!empty($isUserBan)) {
            return true;
        } else {
            return false;
        }
    }
    /* 14/ Création d'une nouvelle entrée dans table token */
    function insertInToken($token, $email, $date)
    {
        $bdd = connexMedoo();
        $bdd->insert('token', [
            "token" => $token,
            "email" => $email,
            "date" => $date
        ]);
    }
    /* 15 Vérification de la validité d'un hash (dans le temps) pour un reset de password */
    function verifHashTime($user, $hashDate)
    {
        $bdd = connexMedoo();
        $result = $bdd->count('token', [
            'email' => $user,
            'date[>]' => $hashDate
        ]);
        return $result;
    }
    /* 16/ Récupération du nom d'un utilisateur dans la table utilisateurs */
    function getNameUtilisateurs($user)
    {
        $bdd = connexMedoo();
        $result = $bdd->select('utilisateurs', 'nom', [
            'email' => $user
        ]);
        return $result;
    }
    /* 17/ Modification mdp dans la table utilisateurs */
    function mofidPassUtilisateurs($user, $password)
    {
        $bdd = connexMedoo();
        $bdd->update('utilisateurs', [
            'mdp' => $password ], [
            'email' => $user
        ]);
    }
    /* 18/ Récupération d'un email lié au token de l'utilisateur dans la table token */
    function getUserMailToken($token)
    {
        $bdd = connexMedoo();
        $result = $bdd->select("token", "email", [
            "token" => $token
        ]);
        return $result;
    }