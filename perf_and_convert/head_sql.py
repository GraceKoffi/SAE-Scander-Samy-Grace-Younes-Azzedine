import re


def sql_type_primary(value):
    if re.match(r'^[+-]?[0-9]+$', value):
        return "INTEGER"
    elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value):
        return "FLOAT"
    elif re.match(r'^[0-1]$', value):
        return "BOOLEAN"
    elif re.match(r'^\d{4}-\d{2}-\d{2}$', value):
        return "DATE"
    elif re.match(r'^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', value):
        return "DATETIME"
    else:
        return f"VARCHAR({len(value)})"





def sql_type(value):
    if ',' in value :

        value_first_word = value.split(',')[0]
        if re.match(r'^[+-]?[0-9]+$', value_first_word):
            return "INTEGER"
        elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value_first_word):
            return "FLOAT"
        elif re.match(r'^[0-1]$', value_first_word):
            return "BOOLEAN"
        elif re.match(r'^\d{4}-\d{2}-\d{2}$', value_first_word):
            return "DATE"
        elif re.match(r'^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', value_first_word):
            return "DATETIME"
        else:
            return f"VARCHAR(255)"
    
    
    else :
        if re.match(r'^[+-]?[0-9]+$', value):
            return "INTEGER"
        elif re.match(r'^[+-]?([0-9]*[.])?[0-9]+$', value):
            return "FLOAT"
        elif re.match(r'^[0-1]$', value):
            return "BOOLEAN"
        elif re.match(r'^\d{4}-\d{2}-\d{2}$', value):
            return "DATE"
        elif re.match(r'^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$', value):
            return "DATETIME"
        else:
            return f"VARCHAR(255)"


def generate_sql_header(file, name_table):

    try:
        with open(file, "r", encoding="utf8") as tsv_file:
            column_names = tsv_file.readline().strip().split('\t')
            primary_key = column_names[0].split()[0]
            types_line = tsv_file.readline().strip().split('\t')
            column_types = []
            column_types.append(sql_type_primary(types_line[0]))
            for i in range(1,len(types_line)):
                column_types.append(sql_type(types_line[i]))
            
            print(column_types)

            # Créer la commande CREATE TABLE
            create_table_command = f"CREATE TABLE IF NOT EXISTS {name_table} (\n"
            for i in range(len(column_names)):
                create_table_command += f"  {column_names[i]} {column_types[i]}"
                if i < len(column_names) - 1:
                    create_table_command += ","
                create_table_command += "\n"

            # Ajouter la clé primaire
            create_table_command += f"  PRIMARY KEY ({primary_key})\n);"

            return create_table_command
    
    except FileNotFoundError as e:
        print(f"Le fichier TSV spécifié n'a pas été trouvé. : {str(e)}")
        return
    
    except Exception as e:
        print(f"Une erreur s'est produite lors de la génération de la commande CREATE TABLE : {str(e)}")
        return 


