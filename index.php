<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="feuille_style.css" />
		<title>Le blog de Jaenne</title>
	</head>


	<body>
		<h1>Le Blog de Jaenne !</h1>
		<h2>Derniers billets du blog :</h2>

		<?php

			// Cette page doit afficher les 5 derniers billets.

			// Connexion à la base de données essai + erreurs.
			$bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

			// Sélectionner les champs(ID, contenu, titre) de billets classer en ordre decroissant, limiter à 5.
			$requete = $bdd -> query('SELECT ID, contenu, titre, DATE_FORMAT(date_creation, \' Le %d/%m/%Y à %Hh%imin%ss\') AS moment FROM billets ORDER BY date_creation DESC LIMIT 0, 5');

			// Boucle affiche données et bouton pour voir commentaires (get:id_commentaires). ! sécurité !
			while ($donnees = $requete -> fetch())
			{
				?>
					<article class=news>
						<h3>

							<?php echo htmlspecialchars($donnees['titre']); ?>
							<em><?php echo htmlspecialchars($donnees['moment']); ?></em>

						</h3>

						<p>
					
							<?php echo nl2br(htmlspecialchars($donnees['contenu']));?><br/>

							<em><a href="commentaires.php?billet=<?php echo $donnees['ID']; ?>">Commentaires</a></em>

						</p>

					</article>
				<?php
			}

			// Fermer la requete.
			$requete -> closeCursor();
		?>

	</body>
</html>