# -*- coding: utf-8 -*-
#
# Copyright (c) 2023,
# Tous droits réservés.
#

#
#Consultez le fichier README pour les détails de l'utilisation.
#
# Le code ci-dessous est le contenu principal du fichier convertisseur.py.

import subprocess, os, re
from unzip import unzip
from time import time



try:
    
    time_code_begin = time()

    path_script = input("Veuillez saisir le chemin d'accès au script : ")


    if not os.path.exists(path_script) :
        raise FileNotFoundError(f"'{path_script}' ce fichier n'existe pas.")
    
    else:

        if "recup_n.sh" in path_script :
            nb_lignes = input("Veuillez saisir le nombre de ligne : ")
            if not  re.match(r'^[+-]?[0-9]+$', nb_lignes):
                
                raise TypeError(f"'{nb_lignes}' n'est pas un entier.")
                
            else :
                gz = input("Veuillez saisir le chemin d'accès des ou du fichier gz : ")
                fichiers_gz = gz.strip().split()
                fichiers_tsv = []
                for fichier_gz in fichiers_gz :
                    if not os.path.exists(fichier_gz) :
                        raise FileNotFoundError(f"'{fichier_gz}' n'existe pas.")
                    elif not fichier_gz.endswith(".gz") :
                        raise ValueError(f"'{fichier_gz}' n'est pas un fichier gz.")
                    
                    else :
                        fichier_tsv = unzip(fichier_gz)
                        if not fichier_tsv.endswith(".tsv"):
                            raise ValueError(f"'{fichier_tsv}' n'est pas un fichier tsv.")
                        
                        elif os.path.getsize(fichier_tsv) == 0:

                            raise ValueError(f"'{fichier_tsv}' est vide.")
                        
                        else :

                            fichiers_tsv.append(fichier_tsv)


                for fichier_tsv in fichiers_tsv :
                    tic = time()
                    fichier_sql = f"{fichier_tsv.split('.tsv')[0].replace(".","_")}.sql"

                    # Exécution du script shell avec les arguments
                    subprocess.run(["sh", path_script, fichier_tsv, fichier_sql, nb_lignes], stdout=subprocess.PIPE, text=True)

                    # Mesure du temps de fin
                    tac = time()
                    time_value = tac - tic

    
        elif "recup_all.sh" in path_script :
            gz = input("Veuillez saisir le chemin d'accès des ou du fichier gz : ")
            fichiers_gz = gz.strip().split()
            fichiers_tsv = []
            for fichier_gz in fichiers_gz :
                if not os.path.exists(fichier_gz) :

                    raise FileNotFoundError(f"'{fichiers_gz}' n'existe pas.")
                elif not fichier_gz.endswith(".gz") :
                    raise ValueError(f"'{fichier_gz}' n'est pas un fichier gz.")
                
                else :
                    fichier_tsv = unzip(fichier_gz)
                    if not fichier_tsv.endswith(".tsv"):
                        raise ValueError(f"'{fichier_tsv}' n'est pas un fichier tsv.")
                    
                    elif os.path.getsize(fichier_tsv) == 0:

                        raise ValueError(f"'{fichier_tsv}' est vide.")
                    
                    else :

                        fichiers_tsv.append(fichier_tsv)


            for fichier_tsv in fichiers_tsv :
                tic = time()
                fichier_sql = f"{fichier_tsv.split('.tsv')[0].replace(".","_")}.sql"

                # Exécution du script shell avec les arguments
                subprocess.run(["sh", path_script, fichier_tsv, fichier_sql], stdout=subprocess.PIPE, text=True)

                # Mesure du temps de fin
                tac = time()
                time_value = tac - tic
        else :
            raise ValueError(f"'{path_script}' n'est pas un fichier de convertion.")
    
    


   
except FileNotFoundError as e :
    print(f"KO: FileNotFoundError\nDescription: {e}")
    
except ValueError as e :
    print(f"KO: ValueError\nDescription: {e}")
    
except TypeError as e :
    print(f"KO: TypeError\nDescription: {e}")
    
except Exception as e:
    print(f"KO: Exception\nDescription: {e}")
    

else :
    if time_value < 60 :
        s = ""
        if len(fichiers_tsv) > 1 :
            s="s"
        print(f"OK convert in {round(time_value, 2)}s  ({len(fichiers_tsv)} file{s}).")

    elif time_value >= 60 and time_value < 3600 :
        minute = time_value/60
        s = ""
        if len(fichiers_tsv) > 1 :
            s="s"
        print(f"OK convert in {round(minute, 2)}m  ({len(fichiers_tsv)} file{s}).")

    else :
        heure = time_value/3600
        s = ""
        if len(fichiers_tsv) > 1 :
            s="s"
        print(f"OK convert in {round(heure, 2)}h  ({len(fichiers_tsv)} file{s}).")

    
finally:
    time_code_end = time()
    time_code = time_code_end - time_code_begin
    
    if time_code < 60 :
        print(f"Finish in {round(time_code, 2)}s.")

    elif time_code >= 60 and time_code < 3600 :
        minute = time_code/60
        print(f"Finish in {round(minute, 2)}m.")

    else :
        heure = time_code/3600
        print(f"Finish in {round(heure, 2)}h.")

