<?php
$serveur="localhost";
$user="root";
$pwd="";
$dbname="brazil_burger";
$connexion=mysqli_connect($serveur,$user,$pwd,$dbname);

if(!$connexion){
    echo "Erreur de connexion";
}else{
    echo "";
}

?>