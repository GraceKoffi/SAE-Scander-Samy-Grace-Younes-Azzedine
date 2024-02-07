import psycopg2
import threading
import queue
import time
import requests


try :

    con = psycopg2.connect(
        host="localhost",
        database="test",
        user="postgres",
        password="root"
    )
    
except Exception as e:
    print(f"Une erreur {e}")

dic_debut = {0: {'tt1': ['nm1']}, 
             1: {'tt2': ['nm1', 'nm2', 'nm5']}, 
             2: {'tt3': ['nm2', 'nm3'], 'tt4': ['nm3', 'nm5']}, 
             3: {}
}

dic_fin = {0: {'tt2': ['nm1', 'nm5'], 'tt3': ['nm3']}, 
           1: {'tt1': ['nm1', 'nm4'], 'tt4': []}, 
           2: {}, 
           3: {}
}


dic1 = {
    0 : {'t01' : ['n01'], 't02' : ['n03']},
    1 : {'t07' : ['n08','n01'], 't09' : ['n10']},
    2 : {'t12' : ['n21','n08']},
    3 : {'t30' : ['n21','n00','n22']}

}

dic2 = {
    0 : {'t03' : ['n04']},
    1 : {'t10' : ['n20','n04']},
    2 : {'t20' : ['n22','n20']},
    3 : {'t30' : ['n21','n00','n22']}
}


dic_debut_test = {
    0 : {'t20': ['n2','n1']},
    1 : { 't4' : ['n2', 'n9', 'n10']}
}

dic_fin_test = {
    0: {'t24' : ['n5', 'n7']},
    1: {'t3' : ['n12', 'n5', 'n9']}    
}


resultat_queue = queue.Queue()
condition = threading.Condition()
nconst_debut = 'nm5'
nconst_fin = 'nm2'
traitement_accepter = None
Chemin_f = None
i = 0





def clee_commun(dic_1, dic_2, i):
    return list(set(dic_1[len(dic_1)-1]) & set(dic_2[len(dic_2)-1]))

def acteur_commun(dic1, dic2):
    result = {}
    dic_debut = {}
    dic_fin = {}
    keys_1 = dic1[len(dic1) - 1].keys()
    keys_2 = dic2[len(dic2) - 1].keys()
    for k in keys_1:
        for key in keys_2:
            commun = list(set(dic1[len(dic1)-1][k]) & set(dic2[len(dic2)-1][key]))
            if commun :
                dic_debut[k]=commun
                dic_fin[key]=commun
                result["debut"]=dic_debut
                result["fin"]=dic_fin
                result["commun"]=commun
    return result




def chemin_test(dic_debut, dic_fin, result={}, clee=[]):
    global nconst_debut, nconst_fin
    j = len(dic_debut)-1
    stock = len(dic_fin)-1
    chemin_fin = []
    chemin_debut = []
    if clee :
        valeurs = dic_debut[j][clee[0]]
        test = dic_fin[stock][clee[0]]
        chemin_debut.append(clee[0])
    elif result :
        key_debut = list(result['debut'].keys())
        key_fin = list(result['fin'].keys())
        valeurs = dic_debut[j][key_debut[0]]
        test = dic_fin[stock][key_fin[0]]
        chemin_fin.append(result['commun'][0])
        chemin_fin.append(key_fin[0])
        chemin_debut.append(key_debut[0])
        chemin_debut.append(result['commun'][0])
    #S'attaque sur le dic d'en dessous
    j-=1
    while j >= 0 :
        tab = []
        keys = list(dic_debut[j].keys())
        for key in keys :
            for valeur in valeurs:
                if(valeur in dic_debut[j][key]):
                    tab.append(key)
                    chemin_debut.append(key)
                    chemin_debut.append(valeur)
        valeurs = []
        for e in tab:
            for v in dic_debut[j][e] :
                valeurs.append(v)
        j-=1
    
    stock-= 1
    while stock >= 0:
        tab = []
        keys = list(dic_fin[stock].keys())
        for key in keys :
            for valeur in test:
                if(valeur in dic_fin[stock][key]):
                    tab.append(key)
                    chemin_fin.append(valeur)
                    chemin_fin.append(key)
        test = []
        for e in tab:
            for v in dic_fin[stock][e] :
                test.append(v)
        stock-=1
    chemin_debut = chemin_debut[::-1]

    for element in chemin_debut :
        # check if the count of sweet is > 1 (repeating item)
        if chemin_debut.count(element) > 1:
        # if True, remove the first occurrence of sweet
            chemin_debut.remove(element)
    for element in chemin_fin:
        if chemin_fin.count(element) > 1:
        # if True, remove the first occurrence of sweet
            chemin_fin.remove(element)
    return chemin_debut, chemin_fin


def thread_debut(nconst_debut, con):
    global traitement_accepter
    cur = con.cursor()
    dic = {"type": "debut"}
    #Initialisation
    tab_noeud_traite = []
    tab_branch_traite = []
    sql = "SELECT tconst FROM title_principals WHERE nconst = %(nconst_debut)s;"
    value = {"nconst_debut": nconst_debut}
    cur.execute(sql, value)
    tabs_tconst_noeud = [noeud[0] for noeud in cur.fetchall()]
    while True:
        tab_nconst_branche = []
        for noeud in tabs_tconst_noeud:
            tab_noeud_traite.append(noeud)
            sql = "SELECT nconst FROM title_principals WHERE tconst = %(tconst)s;"
            value = {"tconst": noeud}
            cur.execute(sql, value)
            for e in cur.fetchall() :
                if e[0] != nconst_debut and tab_branch_traite.count(e[0]) < 2:
                    tab_nconst_branche.append(e[0])
                    tab_branch_traite.append(e[0])
            dic[noeud] = tab_nconst_branche
            tab_nconst_branche = []
            #{"type": "debut", noeud1 : ['Acteur1'], noeud2 : ['Acteur']}
      
        #envoie du résultat 
        with condition:
            #envoie de la réponce au thread traitement
            resultat_queue.put(dic)
            #mise en attente 
            condition.wait()

            if traitement_accepter == True:
                break
            else :
               dic = {"type": "debut"}


        #recup noeud (tconst) pour l'étape i+1
        tabs_tconst_noeud = []
        for nconst in tab_branch_traite :
            sql = "SELECT tconst FROM title_principals WHERE nconst = %(nconst)s"
            value = {"nconst": nconst}
            cur.execute(sql, value)
            for e in cur.fetchall():
                if e [0] not in tab_noeud_traite:
                    tabs_tconst_noeud.append(e[0])
            


def thread_fin(nconst_fin, con):
    global traitement_accepter
    cur = con.cursor()
    #initialisation
    tab_noeud_traite = []
    tab_branch_traite = []
    dic = {"type": "fin"}
    sql = "SELECT tconst FROM title_principals WHERE nconst = %(nconst_fin)s;"
    value = {"nconst_fin": nconst_fin}
    cur.execute(sql, value)
    tabs_tconst_noeud = [noeud[0] for noeud in cur.fetchall()]
    while True :
        tab_nconst_branch = []
        for noeud in tabs_tconst_noeud :
            
            tab_noeud_traite.append(noeud)
            
            sql = "SELECT nconst FROM title_principals WHERE tconst = %(tconst)s;"
            value = {"tconst": noeud}
            cur.execute(sql, value)
            
            for e in cur.fetchall():
                if e[0] != nconst_fin and tab_branch_traite.count(e[0]) < 2:
                    tab_nconst_branch.append(e[0])
                    tab_branch_traite.append(e[0])
            dic[noeud] = tab_nconst_branch
            tab_nconst_branch = []
           
            #{"type": "fin", noeud1 : ['Acteur1','Acteur2], noeud2 : ['Acteur']}
       
        
        #envoie du résultat
        with condition:
            resultat_queue.put(dic)
            #attente de résultat
            condition.wait()

            if traitement_accepter == True:
                break
            else :
               dic = {"type": "fin"}
 
        
        tabs_tconst_noeud = []
        for nconst in tab_branch_traite :
            sql = "SELECT tconst FROM title_principals WHERE nconst = %(nconst)s"
            value = {"nconst": nconst}
            cur.execute(sql, value)
            for e in cur.fetchall():
                if e[0] not in tab_noeud_traite :
                    tabs_tconst_noeud.append(e[0])
        



def thread_passerelle():
    global traitement_accepter, nconst_debut, nconst_fin, i, Chemin_f
    dic_debut = {}
    dic_fin = {}
    while i < 50 :

        #queue = [resultP1, resultP2]
        resultat1 = resultat_queue.get()
        resultat2 = resultat_queue.get()
        #queue = []

        
        if resultat1.get("type") == "debut" and resultat2.get("type") == "fin":
            del resultat1["type"]
            dic_debut[i] = resultat1

            del resultat2["type"]
            dic_fin[i] = resultat2
        else :
            del resultat1["type"]
            dic_fin[i] = resultat1

            del resultat2["type"]
            dic_debut[i] = resultat2
        
        with condition:
            clee = clee_commun(dic_debut, dic_fin, i)
            result = acteur_commun(dic_debut, dic_fin, i)
            if clee:
                Chemin_f = chemin_test(dic_debut, dic_fin, {}, clee)
                traitement_accepter = True
                condition.notify_all()
                break
            elif result:
                Chemin_f = chemin_test(dic_debut, dic_fin, result, [])
                traitement_accepter = True
                condition.notify_all()
                break
            else :
                traitement_accepter = False
                condition.notify_all()
        i+=1
    with condition:
        traitement_accepter = True
        condition.notify_all()

# Création des threads
thread_de_recherche_debut = threading.Thread(target=thread_debut,daemon=True, args=[nconst_debut, con])
thread_de_recherche_fin = threading.Thread(target=thread_fin,daemon=True, args=[nconst_fin, con])
thread_de_validation = threading.Thread(target=thread_passerelle)

tic = time.time()
# Démarrage des threads
thread_de_recherche_debut.start()
thread_de_recherche_fin.start()
thread_de_validation.start()

# Attente de la fin des threads de création
thread_de_recherche_debut.join()
thread_de_recherche_fin.join()

# Attente de la fin du thread de traitement
thread_de_validation.join()
tac = time.time()

if Chemin_f:
    print(f"Le chemin le plus court est {Chemin_f} en {round(tac-tic, 3)}")

    print(f"Dict_debut {dic_debut}")
    print()
    print(f"Dict_fin {dic_fin}")
else :
    print("Aucun chemin")


print()    
print("Fin du programme")

 