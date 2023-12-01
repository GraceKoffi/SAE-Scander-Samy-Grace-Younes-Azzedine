#!/bin/bash

# Vérifier le nombre d'arguments
if [ "$#" -ne 2 ]; then
  echo "Usage: $0 <direction> <répertoire_source>"
  echo "Direction: 'get' ou 'push'"
  exit 1
fi

direction="$1"
repertoire_source="$2"


# Vérifier si le répertoire source existe
if [ ! -d "$repertoire_source" ]; then
  echo "Le répertoire source n'existe pas."
  exit 1
fi

# Fonction pour afficher un message d'erreur et quitter
erreur() {
  echo "Erreur lors du déplacement."
  exit 1
}

# Déplacer les fichiers .gz en fonction de la direction
case "$direction" in
  "get")
    mv "$repertoire_source"/*.gz .
    ;;
  "push")
    mv *.gz "$repertoire_source"
    ;;
  *)
    echo "Direction non reconnue. Utilisez 'get' ou 'push'."
    exit 1
    ;;
esac

# Vérifier si la commande mv a réussi
if [ $? -eq 0 ]; then
  echo "Déplacement réussi."
else
  erreur
fi
