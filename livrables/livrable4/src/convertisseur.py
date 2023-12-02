# -*- coding: utf-8 -*-
#
# Copyright (c) 2023,
# Tous droits réservés.
#

#
#Consultez le fichier README pour les détails de l'utilisation.
#
# Le code ci-dessous est le contenu principal du fichier convertisseur.py.

import subprocess
import os
import re
from unzip import unzip
from time import time
import platform  

class Converter:
    def __init__(self):
        self.cmd_python = None
        self.fichiers_gz = []
        self.conversion_times = []
        self.path_script = None
        self.nb_lignes = None

    def create_tsv(self, fichier_gz):
        fichier_tsv = unzip(fichier_gz, self.nb_lignes)
        if not fichier_tsv.endswith(".tsv"):
            raise ValueError(f"'{fichier_tsv}' n'est pas un fichier tsv.")
        elif os.path.getsize(fichier_tsv) == 0:
            raise ValueError(f"'{fichier_tsv}' est vide.")
        else:
            return fichier_tsv

    def convert(self, fichiers_gz):
        for fichier_gz in fichiers_gz:
            fichier_tsv = self.create_tsv(fichier_gz)
            
            fichier_sql = fichier_tsv.split('.tsv')[0].replace(".", "_") + ".sql"
               
            shell_command = f'sh {self.path_script} "{fichier_tsv}" "{fichier_sql}"'
            if self.nb_lignes is not None:
                shell_command += f' {self.nb_lignes}'
            
            shell_command += f' {self.cmd_python}'

        
            tic = time()
            
            subprocess.run(shell_command, shell=True, stdout=subprocess.PIPE, text=True)
            
            tac = time()
            
            self.conversion_times.append(tac - tic)

    def time_convert(self):
        time_convert = sum(self.conversion_times)
        if time_convert < 60:
            s = "s" if len(self.fichiers_gz) > 1 else ""
            print(f"OK convert in {round(time_convert, 2)}s  ({len(self.fichiers_gz)} file{s}).")
        elif 60 <= time_convert < 3600:
            minute = time_convert / 60
            s = "s" if len(self.fichiers_gz) > 1 else ""
            print(f"OK convert in {round(minute, 2)}m  ({len(self.fichiers_gz)} file{s}).")
        else:
            heure = time_convert / 3600
            s = "s" if len(self.fichiers_gz) > 1 else ""
            print(f"OK convert in {round(heure, 2)}h  ({len(self.fichiers_gz)} file{s}).")

    def run_conversion(self):
        try:
            time_code_begin = time()
            choice = input("all for recup_all or n for recup_n : ").lower()

            if choice != "all" and choice != "n":
                raise ValueError(f"'{choice}' Value error.")

            if platform .system() == "Windows":
                
                self.path_script = ".\\bin\\recup_n.sh" if choice == "n" else ".\\bin\\recup_all.sh"
                self.cmd_python = "python"

            else :
                
                self.path_script = "./bin/recup_n.sh" if choice == "n" else "./bin/recup_all.sh"
                self.cmd_python = "python3"
                
            
            if choice == "n":
                self.nb_lignes = input("Veuillez saisir le nombre de ligne : ")
                if not re.match(r'^[0-9]+$', self.nb_lignes):
                    raise TypeError(f"'{self.nb_lignes}' n'est pas un entier.")
                self.nb_lignes = int(self.nb_lignes)

            self.fichiers_gz = [f for f in os.listdir() if f.endswith('.gz')]
            print(self.fichiers_gz)
            
            if len(self.fichiers_gz) == 0:
                raise FileNotFoundError("Aucun gz dans votre répertoire utiliser le script mouv.sh")
                
            self.convert(self.fichiers_gz)

        except FileNotFoundError as e:
            print(f"KO: FileNotFoundError\nDescription: {e}")

        except ValueError as e:
            print(f"KO: ValueError\nDescription: {e}")

        except TypeError as e:
            print(f"KO: TypeError\nDescription: {e}")

        except Exception as e:
            print(f"KO: Exception\nDescription: {e}")

        else:
            # Mesure du temps de fin
            self.time_convert()

        finally:
            time_code_end = time()
            time_code = time_code_end - time_code_begin

            if time_code < 60:
                print(f"Finish in {round(time_code, 2)}s.")
            elif 60 <= time_code < 3600:
                minute = time_code / 60
                print(f"Finish in {round(minute, 2)}m.")
            else:
                heure = time_code / 3600
                print(f"Finish in {round(heure, 2)}h.")

# Utilisation de la classe
converter = Converter()
converter.run_conversion()

