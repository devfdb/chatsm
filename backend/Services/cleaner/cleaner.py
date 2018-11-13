import re
import csv

class Cleaner:
    
    def __init__(self, input_path:str, output_path:str, params:dict = None):
        text = self._load_csv(input_path)
        text = self._process(text)
        self._save(output_path, text)
        
    def _load_csv(self, path:str):
        print('Cargando Texto')
        text = []
        with open(path, 'r', encoding='utf8') as csvfile:
            reader = csv.reader(csvfile)
            for line in reader:
                text.append(line[0])
        return text
    
    def _is_question(self, string:str):
        if str(string).find('?') != -1:
            return string

    def _clean(self, string:str):
        string = re.sub('(# ([\w]+))', ' ', string)      # Elimina hashtags
        string = re.sub('(#([\w]+))', ' ', string)      # Elimina hashtags
        string = re.sub('(@ ([\w]+))', ' ', string)      # Elimina hashtags
        string = re.sub(r'([A-z])\1+', r'\1\1', string)  # elimina letras duplicadas
        string = re.sub('RT|{', '', string)
        string = re.sub('<.+>', '', string)  # elimina los emojis
        string = re.sub('(http)\S+(\s|)', '', string)  # elimina los links
        string = re.sub(r'(\s+|)([?!])(\2+|)', r'\2 ', string)  # elimina ? y ! repetidos
        string = re.sub(r'([¿¡])(\1+|)(\s+|)', r' \1', string)  # elimina ¿ y ¡ repetidos
        string = re.sub('(pic)\S+', '', string)  # elimina las fotos
        string = re.sub('//', '', string)
        string = re.sub('^@\w+', '', string)  # elimina los @algo al principio de la frase
        string = re.sub('(\s+|)(@\w+)$', '', string)  # elimina los @algo al final de la oracion
        string = re.sub('\s([Cc][Cc])(:|)', '', string)
        string = re.sub('(\.+|…|\s+\.+)', '. ', string)  # elimina . repetida
        string = re.sub(',+|\s+,', ', ', string)  # elimina , repetida
        string = re.sub(r'(\w+@\w+\.)\s+(\w+)', r'\1\2', string)
        string = re.sub('^[,\.]+', '', string)  # elimina puntucion al inicio de la oracion
        string = re.sub(r'(\s+|)([:;])', r'\1 ', string)  # agrega espacio despues de los :
        string = re.sub(r'(\d+)(\.|,) (\d+)', r'\1\2\3', string)  # elimina el espacio entre la puntucion de los numeros
        string = re.sub('^\s+|\s+$', '', string)  # elimina espacios al inicio y al final de la oracion
        string = re.sub('\s+', ' ', string)  # elimina espacios innecesarios
        string = re.sub('^[\w]+@[\w]+\.[\w]+', ' ', string)      # Elimina correos
        string = re.sub('^[\w]+(\\[\w]+)+(\.[\w]+)', '', string)      # Elimina restos de links

        if re.search('^@\w+', string) != None or re.search('(\s+|)(@\w+)$', string) != None or re.search('^[,\.]+',
                                                                                                         string) != None:
            return self.clean(string)
        return string
    
    def _process(self, text:list):
        print('Procesando...')
        ntext = []
        for line in text:
            ntext.append(self._clean(line))
        return ntext
    
    def _save(self, path:str, text:list):
        print('Guardando')
        with open(path, 'w', encoding='utf8', newline='\n') as file:
            writer = csv.writer(file)
            for line in text:
                writer.writerow([line])
        print('Listo')
