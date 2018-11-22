from sklearn.model_selection import train_test_split
from sklearn.neural_network import MLPClassifier
from sklearn.externals import joblib

def mlp_method(name, data, feature_words):
    X = data[feature_words].values
    y = data["intents"]
    
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.25, random_state = 0)
    
    mlp = MLPClassifier(solver="sgd",random_state=0,max_iter=10000)
    mlp.fit(X_train, y_train)
    
    filename = (name) + ".sav"
    joblib.dump(mlp, filename)