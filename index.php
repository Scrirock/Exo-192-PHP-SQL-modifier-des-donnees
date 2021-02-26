<?php
/**
 * 1. Le dossier SQL contient l'export de ma table user.
 * 2. Trouvez comment importer cette table dans une des bases de données que vous avez créées, si vous le souhaitez vous pouvez en créer une nouvelle pour cet exercice.
 * 3. Assurez vous que les données soient bien présentes dans la table.
 * 4. Créez votre objet de connexion à la base de données comme nous l'avons vu
 * 5. Insérez un nouvel utilisateur dans la base de données user
 * 6. Modifiez cet utilisateur directement après avoir envoyé les données ( on imagine que vous vous êtes trompé )
 */

// TODO Votre code ici.

$server = "localhost";
$db = "exo_192";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nom = "Bidule";
    $prenom = "Truc";
    $rue = "Sellekébelle";
    $numero = 8;
    $codePostal = 4587;
    $ville = "laplussemieux";
    $pays = "letrobo";
    $mail = "mail@gmail.com";

    $sql = $conn->prepare("
        INSERT INTO exo_192.user (nom, prenom, rue, numero, code_postal, ville, pays, mail)
        VALUES (:nom, :prenom, :rue, :numero, :codePostal, :ville, :pays, :mail)
    ");

    $sql->bindParam(":nom", $nom);
    $sql->bindParam(":prenom", $prenom);
    $sql->bindParam(":rue", $rue);
    $sql->bindParam(":numero", $numero);
    $sql->bindParam(":codePostal", $codePostal);
    $sql->bindParam(":ville", $ville);
    $sql->bindParam(":pays", $pays);
    $sql->bindParam(":mail", $mail);

    $sql->execute();

    $prenom = "Jean-Eude-Christian-Jojo";
    $last = $conn->lastInsertId();
    $sql = $conn->prepare("
        UPDATE exo_192.user SET prenom = :prenom WHERE id = :last
    ");

    $sql->bindParam(":prenom", $prenom);
    $sql->bindParam(":last", $last);
    $sql->execute();

    if ($sql->rowCount() > 0){
        echo "utilisateur modifié";
    }
    else{
        echo "utilisateur pas modifié";
    }
}

catch (PDOException $e){
    echo $e->getMessage();
}

/**
 * Théorie
 * --------
 * Pour obtenir l'ID du dernier élément inséré en base de données, vous pouvez utiliser la méthode: $bdd->lastInsertId()
 *
 * $result = $bdd->execute();
 * if($result) {
 *     $id = $bdd->lastInsertId();
 * }
 */