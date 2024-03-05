from configparser import ConfigParser

def get_db_config():
    config = ConfigParser()
    config.read('config.ini') 

    db_config = {
        'host': config.get('Database', 'host'),
        'user': config.get('Database', 'user'),
        'password': config.get('Database', 'password'),
        'database': config.get('Database', 'database')
    }

    return db_config