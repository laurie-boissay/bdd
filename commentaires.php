<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="feuille_style.css" />
		<title>Vos commentaires</title>
	</head>


	<body>

		<h1>Vos Réactions sur ce billet :</h1>

		<p>
			<!-- Bouton retour index.php -->
			<a href="index.php">Retour à la liste des billets</a>
		</p>

		<?php
			// Affiche 1 billet ainsi que ses commentaires.

			// Connexion à la base de données + erreurs.
			$bdd = new PDO('mysql:host=localhost;dbname=essai', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

			// Preparer selection des champs(titre, contenu) de l'ID selectionnée de billets.
			$requete = $bdd -> prepare('SELECT titre, contenu, DATE_FORMAT(date_creation, \' Le %d/%m/%Y à %Hh%imin%ss\') AS moment FROM billets WHERE ID=?');

			// Executer requete.
			$requete->execute(array($_GET['billet']));

			// Boucle affiche donnees. ! sécurité !
			while ($donnees = $requete -> fetch())
			{
				?>
					<article class=news>
						<h3>

							<?php echo htmlspecialchars($donnees['titre']); ?>
							<em><?php echo htmlspecialchars($donnees['moment']); ?></em>

						</h3>

						<p>
							<?php echo nl2br(htmlspecialchars($donnees['contenu']));?>
						</p>

					</article>

					<h2>Commentaires :</h2>
				<?php
			}

			// Deconnecter la bdd.
			$requete -> closeCursor();

			// Preparer selection des champs(auteur, commentaire, date_commentaire) de l'ID_billet selectionnée.
			$requete = $bdd -> prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \' Le %d/%m/%Y à %Hh%imin%ss\') AS moment FROM commentaires WHERE ID_billet=? ORDER BY date_commentaire');

			// Executer requete.
			$requete -> execute(array($_GET['billet']));

			// Boucle affiche donnees. ! sécurité !
			while ($donnees = $requete -> fetch())
			{
				?>
				
				<p><u><?php echo htmlspecialchars($donnees['auteur']); ?></u>
				<?php echo htmlspecialchars($donnees['moment']); ?></p>

				<p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>
				
				<?php
			}

			// Deconnecter la bdd.
			$requete -> closeCursor();
		?>

	</body>
</html>


