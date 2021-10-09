<?php


try{
  $bdd = new PDO('mysql:host=localhost;dbname=gerersesdepenses', 'root', 'root') or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
  }
  
  catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
  }

?>