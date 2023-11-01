# Convertisseur de fichiers TSV en SQL

Ce programme Python permet de convertir des fichiers TSV en fichiers SQL à l'aide de scripts shell spécifiques.

## Table des matières

1. [Introduction](#introduction)
2. [Configuration requise](#configuration-requise)
3. [Utilisation](#utilisation)
4. [Exemples](#exemples)

## Introduction

Le programme Python prend en charge la conversion de fichiers TSV en fichiers SQL à l'aide de scripts shell spécifiques. Il peut gérer deux types de scripts shell : `recup_n.sh` et `recup_all.sh`.

## Configuration requise

Avant d'utiliser ce programme, assurez-vous d'avoir installé les dépendances suivantes :
- Python 3.x
- Les scripts shell `recup_n.sh` et `recup_all.sh`

## Dépendances

Ce projet ne dépend que des bibliothèques standard de Python, ce qui signifie que vous n'avez pas besoin d'installer des bibliothèques tierces pour l'exécuter. Les principales bibliothèques standard utilisées dans ce code sont les suivantes :

- `subprocess` : Pour l'exécution de commandes externes et la gestion des processus.
- `os` : Pour effectuer des opérations liées au système de fichiers et au système d'exploitation.
- `re` : Pour la manipulation de chaînes à l'aide d'expressions régulières.

Vous n'avez pas besoin d'installer ces bibliothèques séparément, car elles sont incluses dans l'installation standard de Python.

 
## Utilisation

Pour utiliser le programme, suivez ces étapes :

1. Exécutez le programme Python en spécifiant le chemin d'accès au script shell approprié (par exemple, `recup_n.sh` ou `recup_all.sh`).

2. Suivez les instructions à l'écran pour fournir les informations nécessaires, telles que le nombre de lignes, les fichiers Gzip (`.gz`) à traiter, etc.

3. Le programme effectuera la conversion en utilisant les scripts shell et affichera un message de réussite avec le temps écoulé.

## Exemples

Voici quelques exemples d'utilisation du programme :

### Conversion avec `recup_n.sh`

```bash
python convertisseur.py
Veuillez saisir le chemin d'accès au script : recup_n.sh
Veuillez saisir le nombre de ligne : 100
Veuillez saisir le chemin d'accès des ou du fichier gz : fichier1.gz fichier2.gz fichier3.gz
OK converti en 12.34s (3 fichiers).
Finish in 30.4s.
```

### Conversion avec `recup_all.sh`

```bash
python convertisseur.py
Veuillez saisir le chemin d'accès au script : recup_all.sh
Veuillez saisir le chemin d'accès des ou du fichier gz : fichier1.gz fichier2.gz 
OK converti en 40.2s (2 fichiers).
Finish in 1.4m.

