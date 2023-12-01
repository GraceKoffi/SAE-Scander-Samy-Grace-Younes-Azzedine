# Convertisseur de fichiers TSV en SQL

Ce projet propose un ensemble de scripts en shell (`bash`) pour faciliter la conversion de fichiers TSV en fichiers SQL à l'aide du programme Python `convertisseur.py`. Les scripts inclus sont `mouv.sh` et `supp.sh`.

## Table des matières

1. [Introduction](#introduction)
2. [Configuration requise](#configuration-requise)
3. [Scripts Inclus](#scripts-inclus)
    - [Déplacement (`mouv.sh`)](#déplacement-mouvsh)
    - [Suppression (`supp.sh`)](#suppression-suppsh)
4. [Utilisation](#utilisation)
5. [Exemples](#exemples)

## Introduction

Le projet comprend des scripts shell (`bash`) qui sont utiles en conjonction avec le programme Python `convertisseur.py`. Les deux scripts inclus sont `mouv.sh` pour le déplacement de fichiers et `supp.sh` pour la suppression de fichiers.

## Configuration requise

Avant d'utiliser ces scripts, assurez-vous d'avoir les dépendances suivantes installées :
- Un interpréteur de commandes Bash compatible avec Windows, comme Git Bash ou Windows Subsystem for Linux (WSL).
- Les scripts `convertisseur.py`, `mouv.sh`, et `supp.sh`.

## Scripts Inclus

### Déplacement (`mouv.sh`)

```bash
# Script de Déplacement (`mouv.sh`)

Ce script en shell (`bash`) permet de déplacer des fichiers compressés (`.gz`) entre un répertoire source et le répertoire actuel (ou vice versa) en fonction de la direction spécifiée.
```

## Utilisation

Pour utiliser le script, exécutez la commande suivante :

```bash
bash mouv.sh <mode> <répertoire_source>
```
- '`mode`' -> 'get' pour obtenir du répertoire source ou 'push' pour pousser vers le répertoire source.
- '`répertoire_source`' -> Le chemin d'accès au répertoire source.


## Exemples

- Déplacer du Répertoire Source

```bash
bash mouv.sh get /chemin/vers/le/répertoire/source
```

Cette commande déplace tous les fichiers (`.gz`) du répertoire source vers le répertoire actuel.

- Pousser vers le Répertoire Source

```bash
bash mouv.sh push /chemin/vers/le/répertoire/source
```
Cette commande déplace tous les fichiers .gz du répertoire actuel vers le répertoire source.



### Suppression (`supp.sh`)

```bash
# Script de Suppression (`supp.sh`)

Ce script en shell (`bash`) permet de supprimer les fichiers avec les extensions `.sql` et `.tsv` dans le répertoire actuel. Il enregistre également les fichiers supprimés et la date dans un fichier journal `log.log`.

## Utilisation

Pour utiliser le script, exécutez la commande suivante :

bash supp.sh
```
Cette commande supprime tous les fichiers .sql et .tsv du répertoire actu


## Utilisation

Pour utiliser ces scripts, suivez les instructions spécifiques à chaque script mentionné ci-dessus. Assurez-vous d'avoir correctement configuré votre interpréteur de commandes Bash pour qu'il puisse exécuter ces scripts.

## Exemples

Des exemples détaillés sont fournis pour illustrer l'utilisation des scripts `mouv.sh` et `supp.sh`. Ces exemples vous guideront à travers les différentes commandes et options disponibles.

**Note :** Assurez-vous d'avoir correctement configuré votre environnement et d'avoir les permissions nécessaires pour effectuer les opérations de déplacement et de suppression.


