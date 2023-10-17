#!/bin/bash

# Vérifier le nombre d'arguments
if [ "$#" -ne 2 ]; then
  echo "Usage: $0 <fichier_tsv> <fichier_sql>"
  exit 1
fi

# Assigner les arguments à des variables
fichier_tsv="$1"
fichier_sql="$2"

# Extraire le nom du fichier (enlever l'extension .sql)
nom_table=$(basename "$fichier_sql" .sql)

# Générer la requête CREATE TABLE avec awk
awk -F'\t' -v nom_table="$nom_table" '
  NR == 1 {
    printf "CREATE TABLE IF NOT EXISTS %s (\n", nom_table;
    for (i = 1; i <= NF; i++) {
        printf "\n  %s VARCHAR(255)", $i;
    }
    printf "\n);\n";
  }
' "$fichier_tsv" > "$fichier_sql"

# Générer les requêtes INSERT avec awk
awk -F'\t' -v nom_table="$nom_table" '
  NR > 1 {
    printf "INSERT INTO %s VALUES (", nom_table;
    for (i = 1; i <= NF; i++) {
      
      if (i == 1)
        printf "\047%s\047", $i;  # Première colonne
      else
        printf ",\047%s\047", $i;  # Colonnes suivantes
    }
    printf ");\n";
  }
' "$fichier_tsv" >> "$fichier_sql"