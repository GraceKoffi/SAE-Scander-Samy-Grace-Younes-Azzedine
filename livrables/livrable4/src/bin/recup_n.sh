#!/bin/bash

# Vérifier le nombre d'arguments
if [ "$#" -lt 4 ]; then
  echo "Usage: $0 <fichier_tsv> <fichier_sql> <nombre_de_lignes>"
  exit 1
fi

# Assigner les arguments à des variables
fichier_tsv="$1"
fichier_sql="$2"
max_lignes="$3"  
max_lignes=$(($max_lignes+1)) # Ajout de 1 à nombre_lignes
python_cmd="$4"
# Extraire le nom du fichier (enlever l'extension .sql)
nom_table=$(basename "$fichier_sql" .sql)




# Appeler le script Python pour obtenir la commande CREATE TABLE
$python_cmd -c "
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
            return 'FLOAT[]'
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

try:
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
            
            if '$nom_table' == 'title_akas' :
                for i in range(len(column_names)) :
                    if column_names[i] == 'isOriginalTitle' :
                        create_table_command += '  ' + column_names[i] + ' ' + 'BOOLEAN'+','
                        create_table_command += '\n' 
                    else :
                        if i < len(column_names) - 1 :
                            create_table_command += '  ' + column_names[i] + ' ' + column_types[i]
                            create_table_command += ','
                            create_table_command += '\n' 
                        else :
                            create_table_command += '  ' + column_names[i] + ' ' + column_types[i]+','
            
            else :

            
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
            
            
            if '$nom_table' == 'title_basics' :
                for i in range(len(column_names)) :
                    if column_names[i] == 'isAdult' :
                        create_table_command += '  ' + column_names[i] + ' ' + 'BOOLEAN'+','
                        create_table_command += '\n'
                    else :
                        if i < len(column_names) - 1 :
                            create_table_command += '  ' + column_names[i] + ' ' + column_types[i]
                            create_table_command += ','
                            create_table_command += '\n'
                        else :
                            create_table_command += '  ' + column_names[i] + ' ' + column_types[i]+','
                            create_table_command += '\n'

            elif '$nom_table' == 'title_crew' :
                for i in range(len(column_names)) :

                    if column_names[i] == 'directors' :
                        create_table_command += '  ' + column_names[i] + ' ' + column_types[i]+'[]'+','
                        create_table_command += '\n'

                    elif column_names[i] == 'writers' : 
                        create_table_command += '  ' + column_names[i] + ' ' + column_types[i]+'[]'
                        create_table_command += '\n'

            
            
            else :
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
# Générer les INSERT INTO à partir du fichier TSV
# Utiliser head pour extraire la première ligne du fichier TSV
awk -F'\t' -v nom_table="$nom_table" -v max_lignes="$max_lignes" '
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

  NR > 1 && NR <= max_lignes {
    printf "INSERT INTO %s %s VALUES (", nom_table, formatted_line;

    for (i = 1; i <= NF; i++) {
      if ($i == "\\N") {
        printf "NULL";
      } else {
        # Ajout de conditions pour détecter les colonnes spécifiques
        if ((nom_table == "title_akas" || nom_table == "title_basics") && (i == 3 || i == 4)) {
          gsub(/'\''/, "''", $i); # Échapper les apostrophes simples
          printf "\047%s\047", $i;
        }else if (nom_table == "title_basics" && i == NF) {
          printf "ARRAY['%s']", $i;
        } 
        else if (nom_table == "title_crew" && i > 1) {
          printf "ARRAY[";
          split($i, array_values, ",");
          for (j = 1; j <= length(array_values); j++) {
            gsub(/'\''/, "''", array_values[j]); # Échapper les apostrophes simples
            printf "\047%s\047", array_values[j];
            if (j < length(array_values)) {
              printf ",";
            }
          }
          printf "]";
        }else if (nom_table == "name_basics" && i == NF - 1) {
          printf "ARRAY[";
          split($i, array_values, ",");
          for (j = 1; j <= length(array_values); j++) {
            gsub(/'\''/, "''", array_values[j]); # Échapper les apostrophes simples
            printf "\047%s\047", array_values[j];
            if (j < length(array_values)) {
              printf ",";
            }
          }
          printf "]";
        }else if (nom_table != "title_akas" && nom_table != "title_crew" && substr($i, 1, 1) == "[" && substr($i, length($i), 1) == "]") {
          gsub(/'\''/, "''", $i); # Échapper les apostrophes simples
          printf "\047%s\047", $i;
        } else if (nom_table != "title_akas" && nom_table != "title_crew" && split($i, array_values, ",") > 1) {
          printf "ARRAY[";
          for (j = 1; j <= length(array_values); j++) {
            gsub(/'\''/, "''", array_values[j]); # Échapper les apostrophes simples
            printf "\047%s\047", array_values[j];
            if (j < length(array_values)) {
              printf ",";
            }
          }
          printf "]";
        } else {
          gsub(/'\''/, "''", $i); # Échapper les apostrophes simples
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
