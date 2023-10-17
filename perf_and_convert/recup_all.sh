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

# Appeler le script Python pour obtenir la commande CREATE TABLE
python head_sql.py generate_sql_header "$fichier_tsv" "$nom_table" > "$fichier_sql"

# Écrire les requêtes SQL à la fin du fichier SQL
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
