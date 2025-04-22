<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    if ($nom && $email && $message) {
        // 1. Envoie du mail
        $to = "germaindjeff@gmail.com";
        $sujet = "Nouveau message de $nom";
        $contenu = "Nom: $nom\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email";

        mail($to, $sujet, $contenu, $headers); // Envoi de l'email

        // 2. Sauvegarde dans le fichier messages.txt
        $log = "-----\nDate: " . date("Y-m-d H:i:s") . "\nNom: $nom\nEmail: $email\nMessage:\n$message\n";
        file_put_contents("messages.txt", $log, FILE_APPEND);

        // 3. Redirection vers la page de remerciement
        header("Location: merci.html");
        exit();
    } else {
        echo "Tous les champs doivent être remplis correctement.";
    }
} else {
    echo "Tu ne devrais pas accéder à cette page directement.";
}
?>
