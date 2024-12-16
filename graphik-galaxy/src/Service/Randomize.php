<?php

namespace App\Service;

class Randomize
{
    private array $taglines = [
        "Pour ceux qui aiment les dragons, les robots et tout entre les deux.",
        "Soyez prêts à level up !",
        "- Le multivers à portée de main.",
        "Des goodies dignes des 7 boules de cristal.",
        "N’ayez pas peur du côté obscur... des promos !",
        "Là où chaque commande est une aventure.",
        "Parce qu’un geek mérite toujours ce qu’il y a de meilleur.",
        "De Gotham à Konoha, tout est ici.",
        " Vos rêves geek en un seul endroit.",
        "Attrapez-les tous !",
        " Plus rapide que la lumière, pour vous livrer.",
        " C’est dangereux d’y aller seul ! Prenez ça !",
        " Un anneau pour tous les réunir… dans votre panier.",
        "Votre inventaire geek commence ici.",
        " La boutique qui a plus d’une vie.",
        " Pour les fans qui ne disent jamais game over.",
        " Les trésors d’un autre monde, livrés chez vous.",
        " De la culture geek en mode ultra !",
        "Des univers entiers à portée de clic.",
        "Le pouvoir est dans vos mains… enfin, dans votre panier.",
        "Des produits épiques pour des fans épiques.",
        " L’adresse ultime des collectionneurs.",
        "Un loot légendaire vous attend.",
        " Des objets plus rares que les Dragon Balls.",
        " Des goodies qui font crit !"
    ];
    public function getRandomTagline()
    {
        return $this->taglines[array_rand($this->taglines)];
    }
}
