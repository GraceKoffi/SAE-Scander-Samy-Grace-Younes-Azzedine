#!/bin/bash

# Supprimer les fichiers .sql et .tsv
deleted_files=$(rm -f *.sql *.tsv 2>&1)

# Vérifier s'il y a eu des erreurs lors de la suppression
if [ $? -eq 0 ]; then
    # Si aucune erreur, ajouter les noms des fichiers supprimés et la date dans le fichier log.log
    echo "Suppression réussie le $(date):" >> log.log
    echo "ok" >> log.log
else
    # En cas d'erreur, ajouter un message d'erreur dans le fichier log.log
    echo "Erreur lors de la suppression le $(date):" >> log.log
    echo "Messages d'erreur :" >> log.log
fi
