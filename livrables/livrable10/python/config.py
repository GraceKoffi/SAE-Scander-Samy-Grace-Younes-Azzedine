from configparser import ConfigParser

def get_db_config():
    config = ConfigParser()
    config.read('/Applications/XAMPP/xamppfiles/htdocs/Sae/SAE-Scander-Samy-Grace-Younes-Azzedine/livrables/livrable10/R/config.ini') 

    db_config = {
        'host': config.get('Database', 'host'),
        'user': config.get('Database', 'user'),
        'password': config.get('Database', 'password'),
        'database': config.get('Database', 'database')
    }
    print(config.sections())
    print("test")
    return db_config