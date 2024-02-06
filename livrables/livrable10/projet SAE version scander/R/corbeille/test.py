
#version sans les films mais film used
dic_debut = {
    0: {'tt1' : ['nm1', 'nm2']},
    1 : {'tt2' : ['nm1', 'nm3', 'nm4']},
    2 : {'tt3' : ['nm4', 'nm5', 'nm6']},
    3 : {'tt4' : ['nm6', 'nm7']},
    4 : {'tt5' : ['nm7', 'nm8', 'nm9', 'nm10', 'nm11']}
}

dic_fin = {
    0 : {'tt6' :['nm12'], 'tt7' :['nm13']},
    1 : {'tt8' : ['nm12', 'nm15'], 'tt9':['nm13', 'nm14']},
    2 : {'tt10' : ['nm14'], 'tt11':['nm15', 'nm16']},
    3 : {'tt12' : ['nm17', 'nm16']},
    4 : {'tt13 ': ['nm17', 'nm18']},
    5 : {'tt14' : ['nm18', 'nm8']}
}


nconst_debut = 'nm5'
nconst_fin = 'nm2'
traitement_accepter = None
Chemin_f = None
i = 5


 



def chemin_test(dic_debut, dic_fin, result={}, clee=[]):
    global nconst_debut, nconst_fin
    j = len(dic_debut)-1
    stock = len(dic_fin)-1
    chemin_fin = []
    chemin_debut = []
    #film_used = []
    if clee :
        valeurs = dic_debut[j][clee[0]]
        test = dic_fin[stock][clee[0]]
        chemin_fin.append(clee[0])
        chemin_debut.append(clee[0])
    elif result :
        key_debut = list(result['debut'].keys())
        key_fin = list(result['fin'].keys())
        valeurs = dic_debut[j][key_debut[0]]
        test = dic_fin[stock][key_fin[0]]
        chemin_fin.append(result['commun'][0])
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
                    #film_used.append(key)
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
                    #film_used.append(key)
                    chemin_fin.append(valeur)
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



def clee_commun(dic_1, dic_2, i):
    return list(set(dic_1[len(dic_1)-1]) & set(dic_2[len(dic_2)-1]))

def acteur_commun(dic1, dic2, i):
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



clee = clee_commun(dic_debut, dic_fin, i)
result = acteur_commun(dic_debut, dic_fin, i)
if clee:
    Chemin_f = chemin_test(dic_debut, dic_fin, {}, clee)

elif result:
    Chemin_f = chemin_test(dic_debut, dic_fin, result, [])

print(Chemin_f)
