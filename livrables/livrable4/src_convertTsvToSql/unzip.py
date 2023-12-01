import gzip
import shutil

def unzip(input_gzip_file, nb_lignes=None):
    output_tsv_file = input_gzip_file.split('.tsv.gz')[0] + ".tsv"

    # Ouvrez le fichier Gzip d'entrée en mode binaire (rb) et le fichier TSV de sortie en mode binaire (wb)
    with gzip.open(input_gzip_file, 'rb') as gz_file, open(output_tsv_file, 'wb') as tsv_file:
        if nb_lignes:
            # Si nb_lignes est spécifié, copiez uniquement le nombre spécifié de lignes du fichier Gzip dans le fichier TSV
            for _ in range(nb_lignes):
                line = gz_file.readline()
                if not line:
                    break
                tsv_file.write(line)
        else:
            # Copiez le contenu complet du fichier Gzip dans le fichier TSV
            shutil.copyfileobj(gz_file, tsv_file)

    return output_tsv_file


