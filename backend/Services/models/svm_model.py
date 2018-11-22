from sklearn.model_selection import train_test_split
from sklearn import svm
from sklearn.externals import joblib

def svm_method(name, data, feature_words):
    X = data[feature_words].values
    y = data["intents"]
    
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.25, random_state = 0)
    
    svc = svm.SVC(kernel='rbf', C=1.0, gamma='auto', probability=True)
    svc.fit(X_train, y_train)
    
    filename = (name) + ".sav"
    joblib.dump(svc, filename)