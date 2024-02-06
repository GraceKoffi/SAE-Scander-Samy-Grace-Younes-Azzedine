from flask import Flask, request, jsonify
from rapoActeur import rapoActeur
from rapoFilm import rapoFilm
#import connect

app = Flask(__name__)

@app.route('/test', methods=['GET'])
def test():
    result = {'Message': 'ALL GOOD'}
    return jsonify(result)

@app.route('/result', methods=['POST'])
def result():
    data = request.get_json()
    if 'nconst1' in data and 'nconst2' in data:
        rapprochement = rapoActeur(nconstDebut=data['nconst1'], nconstFin=data['nconst2'])
        result = rapprochement.Start()
        return jsonify(result)
    
    elif 'tconst1' in data and 'tconst2' in data:
        rapprochement = rapoFilm(tconstDebut=data['tconst1'], tconstFin=data['tconst2'])
        result = rapprochement.Start()
        return jsonify(result)
    else:
        result = {'status': 'Erreur', 'message': 'Données manquantes ou erronées'}
        return jsonify(result), 400  
"""
@app.route('/login', methods=['POST'])
def login():
    data = request.get_json()
    if 'username' in data and 'password' in data:
        return jsonify(connect.LoginUser(data))
    else :
        return jsonify({'message' : 'Données manquantes ou erronées'})

@app.route('/userAdd', methods=['PUT'])
def putUser():
    data = request.get_json()
    if 'username' in data and 'password' in data:
        return jsonify(connect.addUser(data))
    else :
        return jsonify({'message' : 'Données manquantes ou erronées'})
    

@app.route('/rechercheAdd', methods=['PUT'])
def putRecherche():
    data = request.get_json()
    if 'UserName' in data and 'TypeRecherche' in data and 'MotsCles' in data:
        return jsonify(connect.addUserRecherche(data))
    else : 
        return jsonify({'message' : 'Données manquantes ou erronées'})
"""

if __name__ == "__main__":
    app.run(debug=True, port=5001)
