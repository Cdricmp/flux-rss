<?php

class ArticleAgregator
{
   
}

$a = new ArticleAgregator();

/**
 * Récupère les articles de la base de données, avec leur source.
 * host, username, password, database name
 */

// J'ai utilisé la classe PDO afin de me connecter a la base donnée, et de pouvoir effectuer des requêtes sql car c'est la méthode qui
// m'a été apprise au cour de ma formation.
$bdd = new \PDO("mysql:host=localhost;dbname=alltricks_test",'root','',
array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

/* Ci-dessous, la ligne de code représente la requête SQL me permettant de récupérer les articles
 dans la base de données comprenant leur source titre et contenu. */

$articles = $bdd->query("SELECT source_id, name ,content FROM article "); 

/*
fetchAll() retourne un tableau multidimentionnel avec chaque tableau ARRAY de chaque article indexé numeriquement
            $result représente le tableau multidimentionnel qui contient tout les articles.
*/
$result = $articles->fetchAll(PDO::FETCH_ASSOC);


// Boucle foreach permetant de générer l'affichage des articles en base de donnés.
    echo "<h1>Récuperation dans la base de données des articles avec leur source</h1> <br><br>";
            foreach($result as $key => $tab)
            {
                echo '<div>';
                foreach($tab as $key2 => $value)
                {
                    echo "$key2 : <strong> $value </strong> <br>";
                }
                echo '</div> <hr>';
            }

           


/**
 * Récupère les articles d'un flux rss donné
 * source name, feed url
 */

// ->appendRss me génère l'erreur : Uncaught Error: Call to undefined method ArticleAgregator::appendRss(),
// et je n'ai pas trouver la solution j'ai donc procédé autrement.

// $a->appendRss('Le Monde',    'http://www.lemonde.fr/rss/une.xml');
// echo sprintf('<h2>%s</h2><em>%s</em><p>%s</p>'
        // $article->name,
        // $article->sourceName,
        // $article->content.
/* ---------------------------------------------------------------------------------------------------------*/

// $lienRss contient l'URL du feed rss
$lienRss = "http://www.lemonde.fr/rss/une.xml";
// $loadRss permet de "charger" le contenu de $lienRss "simplexml_load_file" me permet de convertit un fichier XML en objet.
$loadRss = simplexml_load_file($lienRss);


echo "<h1>Récuperation des articles via flux rss donné depuis le site 'Le Monde'</h1> <br><br>";

/*
La boucle foreach génère l'affichage des articles en 'piochant' dans le flux rss. 
Chaque détail d'un article étant contenu entre des balise la boucle nous permet 
d'aller piocher le contenu désiré, j'ai mis le titre de l'article sous forme de lien redirigeant vers la source.
*/
foreach ($loadRss->channel->item as $item) {
      ?>

       <a href="<?= $item->link ?>"><span class="title"><h4><?= $item->title ?></h4></span></a><br>
       <span class="description"><?= $item->description ?></span><br><br>
        <span class="pubDate">Date de Publication : <?= $item->pubDate ?></span><br>

    <?php
}
    