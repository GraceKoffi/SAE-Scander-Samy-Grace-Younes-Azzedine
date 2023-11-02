import gzip, shutil


def unzip(input_gzip_file):

    output_tsv_file = input_gzip_file.split('.tsv.gz')[0]+".tsv"

    # Ouvrez le fichier Gzip d'entrée en mode binaire (rb) et le fichier TSV de sortie en mode binaire (wb)
    with gzip.open(input_gzip_file, 'rb') as gz_file, open(output_tsv_file, 'wb') as tsv_file:
        # Copiez le contenu du fichier Gzip dans le fichier TSV
        shutil.copyfileobj(gz_file, tsv_file)
    return output_tsv_file


