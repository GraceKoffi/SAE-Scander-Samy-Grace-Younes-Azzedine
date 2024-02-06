import psycopg2

def Con():
    con = psycopg2.connect(
        host="localhost",
        database="connect",
        user="postgres",
        password="root"
    )
    return con

def getUserId(username: str):
    cur = Con().cursor()
    sql = "SELECT UserId FROM user WHERE UserName = %(username)s;"
    value = {"username" : username}
    cur.execute(sql, value)
    return cur.fetchone()[0]



def userExist(username: str):
    cur = Con().cursor()
    sql = "SELECT EXISTS(SELECT 1 FROM User WHERE UserName = %(username)s) as 'Exists';"
    value = {"UserName" : username}
    cur.execute(sql, value)
    row = cur.fetchone()
    if row[0] == "1":
        return True
    else :
        return False

def getUserData(username: str):
    if userExist(username):
        cur = Con().cursor()
        sql = "SELECT * FROM user WHERE UserName = %(username)s;"
        value = {"username" : username}
        cur.execute(sql, value)
        result = {"dataUser" : [userData[0] for userData in cur.fetchall()], "status" : "OK"}
        sql = "SELECT * FROM User JOIN Recherche ON User.userId = Recherche.UserId WHERE User.userId = %(userId)s;"
        value = {"userId" : getUserId(username)}
        cur.execute(sql, value)
        result["dataRecherche"] = [userRecherche[0] for userRecherche in cur.fetchall()]
        return result
    else :
        return {"dataUser" : [], "status" : "KO", "dataRecherche" : [], "message" : "This user does not exist"}
    
def addUser(data: dict):
    if not userExist(data["username"]):
        cur = Con().cursor()

        insert_sql = "INSERT INTO User (username, password) VALUES (%(username)s, crypt(%(password)s, gen_salt('bf')));"

        value = {"username" : data["username"], 
                "password" : data["password"]
                }
                
        cur.execute(insert_sql, value)

        Con().commit()

        cur.close()
        Con().close()
        return {"status" : "OK", "message" : "Add Successfully"}
    else :
        return {"status" : "KO", "message" : "This user already exists"}
    

def addUserRecherche(data: dict):
    cur = Con().cursor()

    sql = "INSERT INTO recherche (UserId, TypeRecherche, MotsCles, DateConnection) VALUES (%(userId)s, %(TypeRecherche)s, %(MotsCles)s, CURRENT_TIMESTAMP);"
    #SELECT CURRENT_TIMESTAMP;
    #2017-08-15 21:05:15.723336+07
    value = {
        "userId" : getUserId(data["UserName"]),
        "TypeRecherche" : data["TypeRecherche"],
        "MotsCles" : data["MotsCles"]
    }
    cur.execute(sql, value)
    Con().commit()
    cur.close()
    Con().close()
    return {"status" : "OK", "message" : "Add Successfully"}


def LoginUser(data: dict):
    if not userExist(data["username"]):
        return {"status" : "KO", "message" : "This user does not exist"}
    else :
        cur = Con().cursor()
        cur.execute("SELECT (password = crypt(%(password)s, password)) AS pwd_match FROM User WHERE username = %(username)s;",
                {'password': data['password'], 'username': data['username']})
    pwd_match = cur.fetchone()[0]
    cur.close()
    if pwd_match:
        getUserData(data["username"])
    else:
        return {"status" : "KO", "message" : "Password doesn't match"}

