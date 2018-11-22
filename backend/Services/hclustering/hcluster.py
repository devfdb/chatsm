import pandas as pd
import matplotlib.pyplot as plt

from gensim.models import Word2Vec
from scipy.cluster.hierarchy import dendrogram, linkage
from collections import defaultdict

class HierarchicClustering:
    
    def __init__(self, input_path:str, output_path:str, params:dict):
        print('Cargando modelo Word2Vec...')
        model = Word2Vec.load(input_path)
        data = pd.DataFrame(model[model.wv.vocab])
        Z = linkage(data.values, 'ward')
        R = self._create_dendrogram(output_path, model.wv.vocab, Z)
        self._create_color_model(params['color_path'], R)
        print('Listo.')
    
    def _create_dendrogram(path:str, vocab:dict, Z:numpy.ndarray):
        print('Creando dendrograma...')
        plt.figure(figsize=(30, 100))
        plt.title('Dendrograma Clustering Jerárquico')
        plt.xlabel('Hojas')
        plt.ylabel('Palabras')
        R = dendrogram(
            Z,
            orientation="right",
            show_leaf_counts=True,
            labels=list(vocab),
            leaf_rotation=0.,  # rotates the y axis labels
            leaf_font_size=12.,  # font size for the y axis labels
        )
        plt.savefig(path,format='png')
        return R
    
    def _create_color_model(path:str, R:dict):
        print('Creando modelo de colores...')
        cluster_idxs = defaultdict(list)
        for c, pi in zip(R['color_list'], R['icoord']):
            for leg in pi[1:3]:
                i = (leg - 5.0) / 10.0
                if abs(i - int(i)) < 1e-5:
                    cluster_idxs[c].append(int(i))
        cluster_classes = {}
        for c, l in cluster_idxs.items():
            i_l = [R['ivl'][i] for i in l]
            cluster_classes[c] = i_l
        word_color=pd.DataFrame.from_dict(cluster_classes, orient='index').reset_index()
        color=word_color.transpose()
        color.to_csv(path, encoding='utf-8', index=False, header=False)