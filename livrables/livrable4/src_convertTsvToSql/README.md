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
- Programme `unzip.py`

Avant d'utiliser ce programme sous Windows, assurez-vous d'avoir installé un interpréteur de commandes Bash compatible avec Windows, tel que Git Bash ou Windows Subsystem for Linux (WSL). Vous aurez besoin de ces interprètes de commandes pour exécuter les scripts shell inclus dans ce projet.
Pour installer Git Bash, vous pouvez télécharger l'installeur à partir du site officiel de Git (https://git-scm.com/downloads) et suivre les étapes d'installation.
Pour activer WSL sur Windows 10 ou une version ultérieure, suivez les instructions de Microsoft pour installer une distribution Linux de votre choix (par exemple, Ubuntu) via Microsoft Store. Une fois installée, vous pourrez exécuter des commandes Bash via WSL.
Assurez-vous d'avoir correctement configuré votre interpréteur de commandes Bash pour qu'il puisse exécuter les scripts shell inclus dans ce projet.


## Utilisation

Pour utiliser le programme, suivez ces étapes :

1. Exécutez le programme Python en spécifiant le chemin d'accès au script shell approprié (par exemple, `recup_n.sh` ou `recup_all.sh`).

2. Suivez les instructions à l'écran pour fournir les informations nécessaires, telles que le nombre de lignes, les fichiers Gzip (`.gz`) à traiter, etc.

3. Le programme effectuera la conversion en utilisant les scripts shell et affichera un message de réussite avec le temps écoulé de la conversion des fichiers Tsv en Sql ainsi que le temps d'exécution du programme `convertisseur.py`.

## Exemples

Voici quelques exemples d'utilisation du programme :

### Conversion avec `recup_n.sh`

```bash
python3 convertisseur.py
Veuillez saisir le chemin d'accès au script : recup_n.sh
Veuillez saisir le nombre de ligne : 100
Veuillez saisir le chemin d'accès des ou du fichier gz : fichier1.gz fichier2.gz fichier3.gz
OK converti en 12.34s (3 fichiers).
Finish in 30.4s.
```

### Conversion avec `recup_all.sh`

```bash
python3 convertisseur.py
Veuillez saisir le chemin d'accès au script : recup_all.sh
Veuillez saisir le chemin d'accès des ou du fichier gz : fichier1.gz fichier2.gz 
OK converti en 48.2s (2 fichiers).
Finish in 1.4m.

