from time import time
import subprocess
import os


try:
 
    path_script = input("Veuillez saisir le chemin d'accès au script :\n ")


    if not os.path.exists(path_script) :
        raise FileNotFoundError(f"Le fichier spécifié n'existe pas : {path_script}\n")
    
    if "recup_n.sh" in path_script :
        nb = input("Veuillez saisir le nombre de ligne :\n")
        fichier_tsv = input("Veuillez saisir le chemin d'accès au fichier tsv à convertir :\n ")
    
        if not os.path.exists(fichier_tsv) :
            raise FileNotFoundError(f"Le fichier spécifié n'existe pas : {fichier_tsv}\n")
    
        fichier_sql = input("Veuillez saisir le nom du fichier sql :\n ")
        tic = time()

        # Exécution du script shell avec les arguments
        subprocess.run(["sh", path_script, fichier_tsv, fichier_sql, nb], stdout=subprocess.PIPE, text=True)

        # Mesure du temps de fin
        tac = time()
        seconde = tac - tic
        if seconde < 60 :
            print(f"Opération terminée avec succès en {round(seconde, 2)}s.\n")
            

        elif seconde >= 60 and seconde < 3600 :
            minute = (tac - tic)/60
            print(f"Opération terminée avec succès en {round(minute, 2)}m.\n")
            
        else :
            heure = (tac - tic)/3600
            print(f"Opération terminée avec succès en {round(heure, 2)}h.\n")
            
    
    
    else :

        fichier_tsv = input("Veuillez saisir le chemin d'accès au fichier tsv à convertir :\n ")
    
        if not os.path.exists(fichier_tsv) :
            raise FileNotFoundError(f"Le fichier spécifié n'existe pas : {fichier_tsv}\n")
    
        fichier_sql = input("Veuillez saisir le nom du fichier sql :\n ")
    

        # Mesure du temps de début
        tic = time()

        # Exécution du script shell avec les arguments
        subprocess.run(["sh", path_script, fichier_tsv, fichier_sql], stdout=subprocess.PIPE, text=True)

        # Mesure du temps de fin
        tac = time()
        seconde = tac - tic
        if seconde < 60 :
        
            print(f"Opération terminée avec succès en {round(seconde, 2)}s.\n")

        elif seconde >= 60 and seconde < 3600 :
            minute = (tac - tic)/60
            print(f"Opération terminée avec succès en {round(minute, 2)}m.\n")

        else :
            heure = (tac - tic)/3600
            print(f"Opération terminée avec succès en {round(heure, 2)}h.\n")

   

except Exception as e:
    print(f"Erreur : {e}")
