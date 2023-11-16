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

# Exécuter le script Python pour générer la commande CREATE TABLE
python3 -c "
import re

def sql_type_primary(value):
    if re.match(r'^[+-]?[0-9]+$', value):
        return 'INTEGER'
    elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value):
        return 'FLOAT'
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
            return 'INTEGER[]'
        elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value_first_word):
            return 'DATE[]'
        
        elif re.match(r'^\d{4}-\d{2}-\d{2}$', value_first_word):
            return 'DATE'
        elif re.match(r'^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', value_first_word):
            return 'TIMESTAMP[]'
        else:
            return 'VARCHAR(255)[]'
    else:
        
        if re.match(r'^[+-]?[0-9]+$', value):
            return 'INTEGER'
        elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value):
            return 'FLOAT'
        elif re.match(r'^\d{4}-\d{2}-\d{2}$', value):
            return 'DATE'
        elif re.match(r'^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', value):
            return 'TIMESTAMP'
        else:
            return 'VARCHAR(255)'

 with open('$fichier_tsv', 'r', encoding='utf8') as tsv_file:
        
        column_names = tsv_file.readline().strip().split('\t')
        
        types_line = tsv_file.readline().strip().split('\t')
        column_types = []
        
       

        create_table_command ='DROP TABLE IF EXISTS ' + '$nom_table' + ';'
        create_table_command +='\n'

        
        create_table_command += 'CREATE TABLE IF NOT EXISTS ' + '$nom_table' + ' (\n'
        
        if '$nom_table' == 'title_akas' or '$nom_table' == 'title_principals':
            for i in range(0, len(types_line)):
                
                column_types.append(sql_type(types_line[i]))
            
            for i in range(len(column_names)):
            
                
                if i < len(column_names) - 1 :
                    create_table_command += '  ' + column_names[i] + ' ' + column_types[i]
                    create_table_command += ','
                else :
                    create_table_command += '  ' + column_names[i] + ' ' + column_types[i]+','

                create_table_command += '\n'

            create_table_command += '  PRIMARY KEY('+column_names[0]+','+' '+column_names[1]+')\n'
            create_table_command += ');'

            
        else :
            primary_key = column_names[0].split()[0]
            
            column_types.append(sql_type_primary(types_line[0]))
            for i in range(1, len(types_line)):

                column_types.append(sql_type(types_line[i]))
            
            create_table_command += '  ' + column_names[0]+' '+ column_types[0] +' PRIMARY KEY,\n'
            for i in range(1, len(column_names)):

                create_table_command += '  ' + column_names[i] + ' ' + column_types[i]
                if i < len(column_names) - 1 :
                    create_table_command += ','
                create_table_command += '\n'
            create_table_command += ');'
            
        with open('$fichier_sql', 'w', encoding='utf8') as sql_file:
            sql_file.write(create_table_command)
            sql_file.write('\n')
except Exception as e:
    print('Une erreur s\'est produite lors de la génération de la commande CREATE TABLE : ' + str(e))
"
# Écrire les requêtes SQL à la fin du fichier SQL
awk -F'\t' -v nom_table="$nom_table" '
  NR == 1 {
    formatted_line = "(";
    for (i = 1; i <= NF; i++) {
      formatted_line = formatted_line $i;
      if (i < NF) {
        formatted_line = formatted_line ", ";
      }
    }
    formatted_line = formatted_line ")";
  }

  NR > 1 {
    printf "INSERT INTO %s %s VALUES (", nom_table, formatted_line;

    for (i = 1; i <= NF; i++) {
      if ($i == "\\N") {
        printf "NULL";
      } else {
        # Ajout de la condition pour détecter les tableaux
        if (split($i, array_values, ",") > 1) {
          printf "ARRAY[";
          for (j = 1; j <= length(array_values); j++) {
            printf "\047%s\047", array_values[j];
            if (j < length(array_values)) {
              printf ",";
            }
          }
          printf "]";
        } else {
          printf "\047%s\047", $i;
        }
      }

      if (i < NF) {
        printf ",";
      }
    }
    printf ");\n";
  }
' "$fichier_tsv" >> "$fichier_sql"

