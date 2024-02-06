import psycopg2
import threading
import queue
import time
from dataclasses import dataclass, field


@dataclass
class rapoActeur:
    nconstDebut : str
    nconstFin : str
    resultQueue : queue.Queue = field(default_factory=queue.Queue)
    resultPath: queue.Queue = field(default_factory=queue.Queue)
    condition : threading.Condition = field(default_factory=threading.Condition)
    traitementAccepter: bool = field(default_factory=lambda: False)
    cheminF: tuple = field(default_factory=lambda: ())
    i: int = field(default_factory=lambda: 0)
    dic_debut: dict = field(default_factory=lambda: {})
    dic_fin: dict = field(default_factory=lambda: {})
    chemin_debut: list = field(default_factory=lambda: [])
    chemin_fin: list = field(default_factory=lambda: [])
    con: psycopg2.extensions.connection = field(init=False)  

    def __post_init__(self):
        """
        Instancie le con apres instanciation de l'objet
        """
        self.con = self.getCon()
    
    def getCon(self) -> psycopg2.connect:
        """
        Retourne une connexion psycopg2 à la base de données.

        :return: Objet de connexion psycopg2.
        :rtype: psycopg2.connect

        Exemple :
        ```
        con = rapoActeur.getCon()
        ```

        """
        con = psycopg2.connect(
            host="localhost",
            database="test",
            user="postgres",
            password="root"
        )
        return con


    def communNode(self) -> list:
        """
        Retourne les ou le noeud soit la clé des 2 dictionnaires.

        :return: Liste des nœuds communs.
        :rtype: list

        Exemple :
        ```
        common_nodes = rapoActeur.communNode()
        ```
        """
        return list(set(self.dic_debut[len(self.dic_debut)-1]) & set(self.dic_fin[len(self.dic_fin)-1]))
    
    def communBranch(self) -> dict:
        """
        Retourne un dictionnaire avec les clées debut, fin, et commun.

        :return: Dictionnaire avec les clés debut, fin et les nœuds communs.
        :rtype: dict

        Exemple :
        ```
        common_branches = rapoActeur.communBranch()
        ```

        """
        
        result = {}
        dic_debut = {}
        dic_fin = {}
        keys_1 = self.dic_debut[len(self.dic_debut) - 1].keys()
        keys_2 = self.dic_fin[len(self.dic_fin) - 1].keys()
        for k in keys_1:
            for key in keys_2:
                commun = list(set(self.dic_debut[len(self.dic_debut)-1][k]) & set(self.dic_fin[len(self.dic_fin)-1][key]))
                if commun :
                    dic_debut[k]=commun
                    dic_fin[key]=commun
                    result["debut"]=dic_debut
                    result["fin"]=dic_fin
                    result["commun"]=commun
        return result
    

    def threadPathBegin(self, n : int, nodeValeur: list) -> None:
        """
        Création du chemin à partir du début jusqu'au point de connection.

        :param n: Nombre d'étapes.
        :type n: int
        :param chemin_debut: Liste pour stocker le chemin.
        :type chemin_debut: list
        :param nodeValeur: Liste des nœuds.
        :type nodeValeur: list

        Exemple :
        ```
        rapoActeur.threadPathBegin(5, [], ["Node1", "Node2"])
        ```

        """
        dic = {"type" : "debut"}
        n-=1
        while n >=0:
            tab = []
            keys = list(self.dic_debut[n].keys())
            for key in keys :
                for valeur in nodeValeur:
                    if(valeur in self.dic_debut[n][key]):
                        tab.append(key)
                        #chemin_debut.append(key)
                        self.chemin_debut.append(valeur)
            nodeValeur = []
            for e in tab:
                for v in self.dic_debut[n][e] :
                    nodeValeur.append(v)
            n-=1
        dic["result"] = self.chemin_debut
        self.resultPath.put(dic)
    
    def threadPathEnd(self, j : int, nodeValeur: list) -> None:
        """
        Création du chemin à partir de la fin jusqu'au point de connection.

        :param j: Nombre d'étapes.
        :type j: int
        :param chemin_fin: Liste pour stocker le chemin.
        :type chemin_fin: list
        :param nodeValeur: Liste des nœuds.
        :type nodeValeur: list

        Exemple :
        ```
        rapoActeur.threadPathEnd(5, [], ["Node1", "Node2"])
        ```

        """
        
        dic = {"type" : "fin"}
        j-=1
        while j >= 0:
            tab = []
            keys = list(self.dic_fin[j].keys())
            for key in keys :
                for valeur in nodeValeur:
                    if(valeur in self.dic_fin[j][key]):
                        tab.append(key)
                        self.chemin_fin.append(valeur)
                        #chemin_fin.append(key)
            nodeValeur = []
            for e in tab:
                for v in self.dic_fin[j][e] :
                    nodeValeur.append(v)
            j-=1
        dic["result"] = self.chemin_fin
        self.resultPath.put(dic)




    def path(self, result={}, key=[]) -> tuple:
        """
        Retourne le chemin s'il existe une connection entre les deux nconst.

        :param result: Résultat de la méthode `communBranch`.
        :type result: dict
        :param key: Liste des nœuds communs.
        :type key: list
        :return: Tuple avec le chemin du début et de la fin.
        :rtype: tuple

        Exemple :
        ```
        result_path = rapoActeur.path( result={"debut": {"A": [1, 2]}, "fin": {"B": [2, 3]}, "commun": [2]}, key=[])
        result_path = rapoActeur.path( result={}, key=["A"])
        ```

        """
        
        j = len(self.dic_debut)-1
        stock = len(self.dic_fin)-1
        if key :
            valeurs = self.dic_debut[j][key[0]]
            test = self.dic_fin[stock][key[0]]
            self.chemin_debut.append(key[0])
        elif result :
            key_debut = list(result['debut'].keys())
            key_fin = list(result['fin'].keys())
            valeurs = self.dic_debut[j][key_debut[0]]
            test = self.dic_fin[stock][key_fin[0]]
            self.chemin_fin.append(result['commun'][0])
            self.chemin_fin.append(key_fin[0])
            self.chemin_debut.append(key_debut[0])
            self.chemin_debut.append(result['commun'][0])
        #S'attaque sur le dic d'en dessous, attention mets la relation X à participé à Y
        
        threadPathBegin = threading.Thread(target=self.threadPathBegin, daemon=True, args=[j, valeurs])
        threadPathEnd = threading.Thread(target=self.threadPathEnd, daemon=True, args=[stock, test])

        threadPathBegin.start()
        threadPathEnd.start()

        threadPathBegin.join()
        threadPathEnd.join()

        result1 = self.resultPath.get()
        result2 = self.resultPath.get()

        if result1.get("type") == "debut" and result2.get("type") == "fin":
            self.chemin_debut = result1["result"][::-1]
            self.chemin_fin = result2["result"]
        else :
            self.chemin_debut = result2["result"][::-1]
            self.chemin_fin = result1["result"]

        #chemin_debut = chemin_debut[::-1]

        for element in self.chemin_debut :
            if self.chemin_debut.count(element) > 1:
                self.chemin_debut.remove(element)
        for element in self.chemin_fin:
            if self.chemin_fin.count(element) > 1:
                self.chemin_fin.remove(element)
        return self.chemin_debut, self.chemin_fin


    def threadDebut(self) -> None:
        """
        Thread 1 soit P1 crée le graph à partir du nconstDebut et envoie le résultat à threadPasserelle (P3)

        Exemple : 
        ```
        resultat = {"type": "fin", noeud1 : ['Acteur1','Acteur2], noeud2 : ['Acteur']}
        ```
        """
        
        cur = self.con.cursor()
        dic = {"type": "debut"}
        #Initialisation
        tab_noeud_traite = []
        tab_branch_traite = []
        sql = "SELECT tconst FROM title_principals WHERE nconst = %(nconst_debut)s;"
        value = {"nconst_debut": self.nconstDebut}
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
                    if e[0] != self.nconstDebut and tab_branch_traite.count(e[0]) < 2:
                        tab_nconst_branche.append(e[0])
                        tab_branch_traite.append(e[0])
                dic[noeud] = tab_nconst_branche
                tab_nconst_branche = []
                #{"type": "debut", noeud1 : ['Acteur1'], noeud2 : ['Acteur']}
        
            #envoie du résultat 
            with self.condition:
                #envoie de la réponce au thread traitement
                self.resultQueue.put(dic)
                #mise en attente 
                self.condition.wait()

                if self.traitementAccepter == True:
                    break
                else :
                    dic = {"type": "debut"}


            #recup noeud (tconst) pour l'étape i+1
            tabs_tconst_noeud = []
            for nconst in tab_branch_traite :
                sql = "SELECT tconst FROM title_principals WHERE nconst = %(nconst)s;"
                value = {"nconst": nconst}
                cur.execute(sql, value)
                for e in cur.fetchall():
                    if e [0] not in tab_noeud_traite:
                        tabs_tconst_noeud.append(e[0])
        cur.close()
    
    def threadFin(self) -> None:
        """
        Thread 2 soit P2 crée le graph à partir du nconstFin et envoie le résultat à threadPasserelle (P3)

        Exemple : 
        ```
        resultat = {"type": "fin", noeud1 : ['Acteur1','Acteur2], noeud2 : ['Acteur']}
        ```

        
        """
        
        cur = self.con.cursor()
        #initialisation
        tab_noeud_traite = []
        tab_branch_traite = []
        dic = {"type": "fin"}
        sql = "SELECT tconst FROM title_principals WHERE nconst = %(nconst_fin)s;"
        value = {"nconst_fin": self.nconstFin}
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
                    if e[0] != self.nconstFin and tab_branch_traite.count(e[0]) < 2:
                        tab_nconst_branch.append(e[0])
                        tab_branch_traite.append(e[0])
                dic[noeud] = tab_nconst_branch
                tab_nconst_branch = []
            
                #{"type": "fin", noeud1 : ['Acteur1','Acteur2], noeud2 : ['Acteur']}
        
            
            #envoie du résultat
            with self.condition:
                self.resultQueue.put(dic)
                #attente de résultat
                self.condition.wait()

                if self.traitementAccepter == True:
                    break
                else :
                    dic = {"type": "fin"}
    
            
            tabs_tconst_noeud = []
            for nconst in tab_branch_traite :
                sql = "SELECT tconst FROM title_principals WHERE nconst = %(nconst)s;"
                value = {"nconst": nconst}
                cur.execute(sql, value)
                for e in cur.fetchall():
                    if e[0] not in tab_noeud_traite :
                        tabs_tconst_noeud.append(e[0])
        cur.close()

    def threadPasserelle(self) -> None:
        """
        Thread 3 P3 maitre d'oeuvre qui teste s'il existe une connection entre nconstDebut et nconstFin
        
        """
        
        while self.i < 50 :

            #queue = [resultP1, resultP2]
            resultat1 = self.resultQueue.get()
            resultat2 = self.resultQueue.get()
            #queue = []

            
            if resultat1.get("type") == "debut" and resultat2.get("type") == "fin":
                del resultat1["type"]
                self.dic_debut[self.i] = resultat1

                del resultat2["type"]
                self.dic_fin[self.i] = resultat2
            else :
                del resultat1["type"]
                self.dic_fin[self.i] = resultat1

                del resultat2["type"]
                self.dic_debut[self.i] = resultat2
            
            with self.condition:
                clee = self.communNode()
                result = self.communBranch()
                if clee:
                    self.cheminF = self.path({}, clee)
                    self.traitementAccepter = True
                    self.condition.notify_all()
                    break
                elif result:
                    self.cheminF = self.path(result, [])
                    self.traitementAccepter = True
                    self.condition.notify_all()
                    break
                else :
                    self.traitementAccepter = False
                    self.condition.notify_all()
            self.i+=1
        with self.condition:
            self.traitementAccepter = True
            self.condition.notify_all()
            self.con.close()

    def Start(self) -> dict:
        """
        Methode mere de la classe rapoActeur retourne le cheminF entre les 2 personnes.
    
        :return: Dictionnaire contenant le message et les données.

        Exemple :
        ```
        result = rapoActeur.Start()
        ```
        """
        dic_f = {}
        thread_de_recherche_debut = threading.Thread(target=self.threadDebut,daemon=True)
        thread_de_recherche_fin = threading.Thread(target=self.threadFin,daemon=True)
        thread_de_validation = threading.Thread(target=self.threadPasserelle)

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

        if self.cheminF :
            dic_f = {"Message" : "OK",
                     "data" : {
                         "path" : self.cheminF,
                         "time" : round(tac-tic, 3)
                        }
                     }
        else :
            dic_f = {"Message" : "KO"}
        return dic_f
