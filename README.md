# TEST

Ceci est le repository pour le test technique de Farmitoo.
Celui-ci est en 3 étapes consécutives.

## 1/ Faire fonctionner les Tests  
Implémenter les méthodes pour que les tests fonctionnent.

## 2/ Afficher la page panier
Afficher le panier en twig tel que vous l'imagineriez pour une commande.
Seule l'UX sera regardée, des compétences développées en front n'étant pas requises pour le poste (donc une mise en tableau, une utilisation d'un bootstrap, etc suffiront).

## 3/ Ajouter une gestion de Promotion
Simulation de cas concret : L'équipe business veut pouvoir gérer des promotions, voici l'US à traiter: 

"En tant qu'utilisateur,
Si j'ajoute un produit dans ma commande et si une promotion est applicable, alors sa réduction s'applique sur ma commande. Je peux retrouver la réduction appliquée sur ma page panier.

Seule la première promotion applicable sur ma commande (par ordre de création) sera appliquée.

Les conditions d'application possibles sont :
- des dates de validités de la promotion
- un montant minimum de commande 
- un nombre de produit minimum dans la commande.

Une promotion pourra posséder 1 ou plusieurs de ces conditions. Si plusieurs conditions sont configurées sur la promotion, alors la condition d'application de la promotion nécessite la validation de l'ensemble de ses conditions.
"

*NB: Ajouter sur la page panier là où ça vous semble pertinent. Vous trouverez 2 promotions "en cours" dans le Controller à appliquer (ou non)*


# L'évaluation
Au niveau global, sera évalué :
- la qualité du code
- la rigueur
- les choix de conception pour la Promotion
- l'UX

## Guide de réflexion
Prenez ce projet comme si c'était le **votre** projet: si une évolution du code déjà écrit vous semble nécessaire, vous pouvez le modifier à votre guise
(et on ne dit pas par là que c'est nécessaire)

N'hésitez pas à ajouter des commentaires dans le README pour expliquer ces choix

## Gestion de la promotion

Pour ajouter une promotion à une commande, il existe le PromotionBuilder. 
Cette classe a un rôle simple, créer une promotion orienté POO, un peu comme le QueryBuilder de Doctrine,
on spécifie nos conditions et montant de la réduction liés a la promotion. 
Ce PromotionBuilder retourne ensuite une entité Promotion avec les conditions.

```php
 $promotion1 = (new PromotionBuilder())
            ->setDuration($startPromotion, $endPromotion)
            ->setMinimumPrice(20000)
            ->setDiscount(1200)
            ->buildPromotion();
```

Il faut par la suite passer par le OrderUpdater

```php
$orderUpdater->addPromotion($order, $promotion1);
```

### Les conditions de la promotion

Une promotion est applicable uniquement en fonction de certaines conditions. 
Par exemple la date de la commande, la quantité de produit de la commande ou le montant de la commande. 
Afin d'être assez souple sur la gestion des Condition d'une promotion, l'interface PromotionConditionInterface permet de
gérer simplement si la condition est valide pour la promotion. 

On peut donc créer facilement une nouvelle condition de promotion en implémentant l'interface directement, il faudra par la suite
l'ajouter dans le PromotionBuilder pour y accéder directement depuis le builder.

Si une condition a besoin d'accéder a la commande en cours, on peut lui ajouter l'interface PromotionConditionOrderInterface 
avec le trait PromotionOrderTrait.

### Calcul de la promotion

La classe PromotionCalculator permet de définir la Promotion qui est applicable ou non. Dès qu'une promotion est applicable,
les autres sont ignorées.

# Annexe


#### Info TVA
Le business modèle de Farmitoo implique des règles de calculs de la TVA complexes.
Dans notre cas, il est simplifié et le taux de TVA dépend seulement de la marque du produit :
- Farmitoo => 20%
- Gallagher => 10%

#### Info frais de port
Les partenaires de Farmitoo ont des règles de calculs de frais de port très différentes. 
Voici celles de notre cas :
- Farmitoo : 12€ quelque soit le nombre de produits
- Gallagher : 14€ par tranche de 2 produits (ex: 14€ pour 1 ou 2 produits et 28€ pour 3 produits)
