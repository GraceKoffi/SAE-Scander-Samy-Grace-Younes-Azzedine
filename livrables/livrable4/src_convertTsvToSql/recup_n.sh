#!/bin/bash

# Vérifier le nombre d'arguments
if [ "$#" -lt 3 ]; then
  echo "Usage: $0 <fichier_tsv> <fichier_sql> <nombre_de_lignes>"
  exit 1
fi

# Assigner les arguments à des variables
fichier_tsv="$1"
fichier_sql="$2"
max_lignes="$3"  
((max_lignes++)) # Ajout de 1 à nombre_lignes
# Extraire le nom du fichier (enlever l'extension .sql)
nom_table=$(basename "$fichier_sql" .sql)

# Appeler le script Python pour obtenir la commande CREATE TABLE
python -c "
import re

def sql_type_primary(value):
    if re.match(r'^[+-]?[0-9]+$', value):
        return 'INTEGER'
    elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value):
        return 'FLOAT'
    elif re.match(r'^[0-1]$', value):
        return 'BOOLEAN'
    elif re.match(r'^\d{4}-\d{2}-\d{2}$', value):
        return 'DATE'
    elif re.match(r'^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', value):
        return 'DATETIME'
    else:
        return 'VARCHAR(' + str(len(value)) + ')'

def sql_type(value):
    if ',' in value:
        value_first_word = value.split(',')[0]
        if re.match(r'^[+-]?[0-9]+$', value_first_word):
            return 'INTEGER'
        elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value_first_word):
            return 'FLOAT'
        elif re.match(r'^[0-1]$', value_first_word):
            return 'BOOLEAN'
        elif re.match(r'^\d{4}-\d{2}-\d{2}$', value_first_word):
            return 'DATE'
        elif re.match(r'^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', value_first_word):
            return 'DATETIME'
        else:
            return 'VARCHAR(255)'
    else:
        if re.match(r'^[+-]?[0-9]+$', value):
            return 'INTEGER'
        elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value):
            return 'FLOAT'
        elif re.match(r'^[0-1]$', value):
            return 'BOOLEAN'
        elif re.match(r'^\d{4}-\d{2}-\d{2}$', value):
            return 'DATE'
        elif re.match(r'^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', value):
            return 'DATETIME'
        else:
            return 'VARCHAR(255)'

try:
    with open('$fichier_tsv', 'r', encoding='utf8') as tsv_file:
        print('Test')
        column_names = tsv_file.readline().strip().split('\t')
        primary_key = column_names[0].split()[0]
        types_line = tsv_file.readline().strip().split('\t')
        column_types = []
        column_types.append(sql_type_primary(types_line[0]))
        for i in range(1, len(types_line)):
            column_types.append(sql_type(types_line[i]))

        create_table_command = 'CREATE TABLE IF NOT EXISTS ' + '$nom_table' + ' (\n'
        for i in range(len(column_names)):
            create_table_command += '  ' + column_names[i] + ' ' + column_types[i]
            if i < len(column_names) - 1:
                create_table_command += ','
            create_table_command += '\n'

        create_table_command += '  PRIMARY KEY (' + primary_key + ')\n);'

        with open('$fichier_sql', 'w', encoding='utf8') as sql_file:
            sql_file.write(create_table_command)
            sql_file.write('\n')
except Exception as e:
    print('Une erreur s\'est produite lors de la génération de la commande CREATE TABLE : ' + str(e))
"
# Générer les INSERT INTO à partir du fichier TSV
awk -F'\t' -v nom_table="$nom_table" -v max_lignes="$max_lignes" '
  NR > 1 && NR <= max_lignes {
     printf "INSERT INTO %s VALUES (", nom_table; 
     for (i = 1; i <= NF; i++) { 
       if ($i == "\\N")  # Si la valeur est "\N", mettre NULL
         printf "NULL";
       else
         printf "\047%s\047", $i;  # Autres valeurs
       
       if (i < NF)  # Ajouter la virgule sauf pour la dernière colonne
         printf ",";
     } 
     printf ");\n";
  }
' "$fichier_tsv" >> "$fichier_sql"
