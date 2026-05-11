<?php 


// Création des joueurs
$j1 = new Joueur("Kylian", "Mbappé", new DateTime("2000-12-20"), "mbappe.jpg");
$j2 = new Joueur("Lionel", "Messi", new DateTime("1987-06-24"), "messi.jpg");
$j3 = new Joueur("Neymar", "Jr", new DateTime("1992-02-05"), "neymar.jpg");
$j4 = new Joueur("Sergio", "Ramos", new DateTime("1986-03-30"), "ramos.jpg");
$j5 = new Joueur("Luka", "Modric", new DateTime("1985-09-09"), "modric.jpg");
$j6 = new Joueur("Karim", "Benzema", new DateTime("1987-12-19"), "benzema.jpg");

// Création des équipes
$equipe1 = new Equipe("PSG");   
$equipe2 = new Equipe("Real Madrid");
$equipe3 = new Equipe("FC Barcelone");
$equipe4 = new Equipe("Manchester City");

// Ajout des joueurs aux équipes avec leurs rôles
$equipe1->ajouterJoueur($j1, "Attaquant");
$equipe1->ajouterJoueur($j2, "Attaquant");
$equipe1->ajouterJoueur($j3, "Ailier");
$equipe2->ajouterJoueur($j4, "Défenseur");
$equipe2->ajouterJoueur($j5, "Milieu");
$equipe2->ajouterJoueur($j6, "Attaquant");

// Création des clubs opposés
$clubOppose1 = new ClubOppose("Santiago Bernabeu", "Madrid");
$clubOppose2 = new ClubOppose("Camp Nou", "Barcelone");
$clubOppose3 = new ClubOppose("Etihad Stadium", "Manchester");

// Création des matchs
$match1 = new MatchFoot("3", "1", new DateTime("2025-10-15"), "Paris");
$match2 = new MatchFoot("2", "2", new DateTime("2025-11-20"), "Madrid");
$match3 = new MatchFoot("1", "0", new DateTime("2025-12-05"), "Barcelone");
$match4 = new MatchFoot("0", "3", new DateTime("2026-01-10"), "Manchester");

// Ajout des matchs aux équipes
$equipe1->ajouterMatch($match1);
$equipe2->ajouterMatch($match2);
$equipe3->ajouterMatch($match3);
$equipe4->ajouterMatch($match4);

// Affichage des informations
function afficherInformationsEquipe(Equipe $equipe) {
    echo "Équipe: " . $equipe->getNom() . "\n";
    echo "Joueurs:\n";
    foreach ($equipe->getJoueurs() as $entry) {
        $joueur = $entry['joueur'];
        $role = $entry['role'];
        echo "- " . $joueur->getPrenom() . " " . $joueur->getNom() . " (" . $role . ")\n";
    }
    echo "\n";
}

afficherInformationsEquipe($equipe1);
afficherInformationsEquipe($equipe2);
afficherInformationsEquipe($equipe3);
afficherInformationsEquipe($equipe4);

/*
$equipe1 = new Equipe("PSG");
$equipe1->ajouterJoueur($j1, "Attaquant");
$equipe1->ajouterJoueur($j2, "Milieu");
$equipe1->ajouterJoueur($j3, "Ailier");
*/

?>

