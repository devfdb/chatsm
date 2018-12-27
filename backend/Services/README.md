CHATBOT SERVICES
============================

> Convenciones a cumplir al nombrar y organizar el proyecto.

### Elementos en el primer nivel del proyecto
    .
    └── services.py            # Colección de los servicios definidos en sus respectivas carpetas

### Archivos para reconocimiento de nombres de entidades

Los archivos con el codigo fuente de un proyecto de software se ubican en el 
directorio `engine`. En el caso que se desarrollase una biblioteca, iran en 
un directorio `lib`, y  si no fuese necesario compilar los archivos, estos 
irían en un directorio `app`.

    .
    ├── ...
    ├── NER                                      # Carpeta de procesamiento interno
    │   ├── crf_ner.py                           # Programa de prueba para ejecución del algoritmo NER
    │   ├── crf_trainer.py                       # Entrenamiento de un modelo NER dadas las oraciones, entidades y etiquetas POS
    │   ├── functions.py                         # Archivo de funciones generales aplicadas en los distintos procesos
    │   └── ner_training_generator.py            # Generador de archivo .csv utilizado como datos de entrada para la generación de modelo NER
    └── ...

### Archivos para etiquetado gramatical (POS tagging)

Corresponde a los archivos con el código fuente aplicados en el proceso de POS tagging, que han sido utilizado en etapas experimentales
del proyecto.

    .
    ├── ...
    ├── POS_tagger                    # Carpeta de archivos para POS tagging
    │   └── POS_trainer.py            # Algoritmo de generación de archivo de etiquetas POS
    └── ...
