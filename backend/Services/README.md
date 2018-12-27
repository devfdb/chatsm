CHATBOT BACKEND
============================

> Convenciones a cumplir al nombrar y organizar el proyecto.

### Elementos en el primer nivel del proyecto
    .
    ├── crf_ner.py                           # Programa principal, indica las intenciones a utilizar, crea los modelos y realiza pruebas con ejemplos definidos
    ├── crf_trainer.py                       # Genera y entrena modelos para todas las intenciones definidas en el archivo 'intents.json'
    ├── functions.py                         # Vectoriza una oración y realiza un análisis a través de los modelos generados para clasificar el mensaje entregado
    └── ner_training_generator.py            # Documentación del sistema (archivo actual)



### Archivos del motor del chatbot

Los archivos con el codigo fuente de un proyecto de software se ubican en el 
directorio `engine`. En el caso que se desarrollase una biblioteca, iran en 
un directorio `lib`, y  si no fuese necesario compilar los archivos, estos 
irían en un directorio `app`.

    .
    ├── ...
    ├── NER                                      # Carpeta de procesamiento interno
    │   ├── crf_ner.py                           # Generador de datasets en base a clasificación de intenciones realizadas preliminarmente en la base de datos
    │   ├── crf_trainer.py                       # Algoritmo auxiliar que retorna todas las intenciones del árbol que se encuentran al mismo nivel dada una que sea parte de éste
    │   ├── functions.py                         # ASFDSG
    │   └── ner_training_generator.py            # Representación del árbol de intenciones, definiendo los tipos de modelo a construir y sus parámetros
    └── ...

### Archivos antiguos

Corresponde a los archivos antiguos, que han sido utilizado en etapas experimentales
del proyecto. Se encuentra en el directorio `old_files`.

    .
    ├── ...
    ├── POS_tagger                    # Carpeta de archivos antiguos
    │   └── POS_trainer.py            # Generador de datasets en base a reglas definidas dentro de la carpeta 'rules' en formato JSON
    └── ...

### Documentación
La documentación detallada del proyecto, se encuentra en el directorio `docs`.

    .
    ├── ...
    ├── docs                    # Documentation files (alternatively `doc`)
    │   ├── TOC.md              # Table of contents
    │   ├── faq.md              # Frequently asked questions
    │   ├── misc.md             # Miscellaneous information
    │   ├── usage.md            # Getting started guide
    │   └── ...                 # etc.
    └── ...
