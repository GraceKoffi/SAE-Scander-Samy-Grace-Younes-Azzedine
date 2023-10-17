#!/bin/bash

# Vérifier le nombre d'arguments
if [ "$#" -lt 2 ]; then
  echo "Usage: $0 <fichier_tsv> <fichier_sql> [nombre_de_lignes]"
  exit 1
fi

# Assigner les arguments à des variables
fichier_tsv="$1"
fichier_sql="$2"
nombre_lignes=${3:-999999}  # Prend 999999 lignes par défaut si aucun argument n'est fourni 
max_lignes=$((nombre_lignes + 1))  # Ajout de 1 à nombre_lignes
# Extraire le nom du fichier (enlever l'extension .sql)
nom_table=$(basename "$fichier_sql" .sql)

# Appeler le script Python pour obtenir la commande CREATE TABLE
python head_sql.py generate_sql_header "$fichier_tsv" "$nom_table" > "$fichier_sql"

# Générer les INSERT INTO à partir du fichier TSV
awk -F'\t' -v nom_table="$nom_table" -v max_lignes="$max_lignes" '
  NR > 1 && NR <= max_lignes {
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
