CHATBOT SERVICES
============================

> Convenciones a cumplir al nombrar y organizar el proyecto.

### Elementos en el primer nivel del proyecto
    .
    └── services.py            # Colección de los servicios definidos en sus respectivas carpetas

### Archivos para reconocimiento de nombres de entidades

Los archivos con el codigo fuente utilizado para la creación de modelos NER, junto con los datos necesarios para su procesamiento. Se ubican en el directorio `NER`.

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
del proyecto. Se ubican en la carpeta `POS_tagger`.

    .
    ├── ...
    ├── POS_tagger                    # Carpeta de archivos para POS tagging
    │   └── POS_trainer.py            # Algoritmo de generación de archivo de etiquetas POS
    └── ...
