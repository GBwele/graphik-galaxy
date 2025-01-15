<?php

namespace App\Service;

class Randomize
{
    private array $taglines = [
        "- Pour ceux qui aiment les dragons, les robots et tout entre les deux. -",
        "- Soyez prêts à level up ! -",
        "- Le multivers à portée de main. -",
        "- Des goodies dignes des 7 boules de cristal. -",
        "- N’ayez pas peur du côté obscur... des promos ! -",
        "-Là où chaque commande est une aventure.-",
        "-Parce qu’un geek mérite toujours ce qu’il y a de meilleur.-",
        "De Gotham à Konoha, tout est ici.",
        "- Vos rêves geek en un seul endroit.-",
        "-Attrapez-les tous !-",
        "- Plus rapide que la lumière, pour vous livrer.-",
        "- C’est dangereux d’y aller seul ! Prenez ça !-",
        "- Un anneau pour tous les réunir… dans votre panier.-",
        "-Votre inventaire geek commence ici.-",
        "- La boutique qui a plus d’une vie.-",
        "- Pour les fans qui ne disent jamais game over.-",
        "-Les trésors d’un autre monde, livrés chez vous.-",
        "- De la culture geek en mode ultra !",
        "Des univers entiers à portée de clic.-",
        "-Le pouvoir est dans vos mains… enfin, dans votre panier.-",
        "-Des produits épiques pour des fans épiques.-",
        "- L’adresse ultime des collectionneurs.-",
        "-Un loot légendaire vous attend.-",
        "- Des objets plus rares que les Dragon Balls.-",
        "- Des goodies qui font crit -!",
        "-Des super-héros dans votre panier, pas besoin de cape pour commander-",
        "-Collectionnez les mangas comme Goku collectionne les boules de cristal-",
        "-Ici, même Batman fait ses achats en pyjama-",
        "-Votre collection grandit plus vite que Luffy peut s'étirer-",
        "-Les seules explosions ici sont nos prix, Bakugo approuve-",
        "-Transformez votre chambre en Batcave, sans le majordome-",
        "-Plus addictif qu'un symbiote, moins dangereux que Venom-",
        "-Nos prix sont plus légers que la toile de Spider-Man-",
        "-Le seul endroit où dépenser n'est pas un pouvoir mutant-",
        "-Même Saitama ne peut pas résister à nos One Punch Promos-",
        "-Notre service client est plus rapide que Flash, presque-",
        "-Des goodies plus rares que les sourcils de Krillin-",
        "-Pas besoin du Sharingan pour repérer nos bonnes affaires-",
        "-Livraison plus fiable que le service postal de Gotham City-",
        "-Notre stock est plus grand que la bibliothèque d'Oracle-",
        "-Chez nous, même Thanos ne snappe pas les prix-",
        "-Plus de choix qu'il n'y a de variants dans le multivers-",
        "-Votre portefeuille survivra mieux qu'Uncle Ben-",
        "-Notre sélection est plus vaste que la garde-robe d'Iron Man-",
        "-Commandez en un clic, pas besoin du gant de l'infini-"
    ];
    public function getRandomTagline()
    {
        return $this->taglines[array_rand($this->taglines)];
    }
}
