import pandas as pd
import numpy as np
import sklearn
from sklearn import preprocessing,linear_model
import matplotlib.pyplot as plt
import requests
import json
import sys

####################################################

# GET Data from Web
result = sys.argv[1]
year = result.get('year')
Kilometers = result.get('Kilometers')
transmission = result.get('transmission')
owner = result.get('owner')
cc = result.get('cc')
power = result.get('power')
seats = result.get('seats')
fuel = result.get('fuel')
####################################################333
#AI
#--------------------load data------------------------
print('-'*30);print("LOAD DATA");print("-"*30)
data=pd.read_csv("train-data.csv",sep=',')
print(data.head())
data=data[['Year','Kilometers_Driven','Fuel_Type','Transmission','Owner_Type','Engine','Power','Seats','Price']]
print(data.head())
print(data.isnull().sum())
"""------process DATA--------------"""
data['Power']=data['Power'].map(lambda i:float((str(i).replace(' bhp','')).replace('null','nan')))
data['Engine']=data['Engine'].map(lambda i:float(str(i).replace(' CC','')))
##########RER
#data['Mileage']=data['Mileage'].map(lambda i:str(i))
#data['Mileage']=data['Mileage'].map(lambda i:i[:i.find(" ")])

le=preprocessing.LabelEncoder()
data['Owner_Type']=le.fit_transform(data['Owner_Type'])#first 0 ,second 2 ,third 3 , fourth and above 1
data['Transmission']=le.fit_transform(data['Transmission'])#Manual 1 ,Automatic 0
data['Fuel_Type']=le.fit_transform(data['Fuel_Type'])#CNG 0 ,Diesel 1, Electric 2, Petrol 4, LPG 3
#data.replace({'Fuel_Type':{'Petrol':0,'Diesel':1,'CNG':2}},inplace=True)

print(data.head())
print('-'*30);print("CHECKING NULL DATA");print("-"*30)
print(data.isnull().sum())
data=  data.dropna()
print(data.isnull().sum())
print('-'*30);print("HEAD");print("-"*30)
print(data.head())
print('-'*30);print("SPLIT DATA");print("-"*30)
x=np.array(data.drop(['Price'],1))
y=np.array(data['Price'])
print("x",x.shape)
print("y",y.shape)

xTrain,xTest,yTrain,yTest=sklearn.model_selection.train_test_split(x,y,test_size=0.2,random_state=50)
print("xTrain",xTrain.shape)
print("xTest",xTest.shape)

print('-'*30);print("TRAINING");print("-"*30)
model =linear_model.LinearRegression()
model.fit(xTrain,yTrain)

accuracy=model.score(xTest,yTest)
print(f"accuracy:{round(accuracy*100,3)}%")

print("cofficients:",model.coef_)
print("Intercept:",model.intercept_)

print('-' * 30);print("Test");print("-" * 30)
XPre=[]
####1
y=int(input("enter the year:"))
XPre.append(y)
####2
dd=int(input("enter the Kilometers_Driven:"))
XPre.append(dd)
####3
Ft=int(input("enter the Fuel_Type (CNG 0 ,Diesel 1, Electric 2, LPG 3,Petrol 4)"))
XPre.append(Ft)
####4
es=int(input('enter Transmission #Manual 1 ,Automatic 0'))
XPre.append(es)
####5
ot=int(input('Owner_Type #first 0 ,second 2 ,third 3 , fourth and above 1'))
XPre.append(ot)
####6
en=int(input(' Engine " cc "'))
XPre.append(en)
####7
p=float(input('Power "bhp"'))
XPre.append(p)
####8
seat=int(input('Seats'))
XPre.append(seat)

print(XPre)
price = int(sum(XPre*model.coef_)+model.intercept_)


###################################################3
# retrive price to web
headers = {'Content-type': 'application/x-www-form-urlencoded', 'Accept': 'text/plain'}

r = requests.post("http://localhost/CarsProject/admin/items.php?do=add", data = price, headers = headers)

#m=[2012,87000,1,1,0,1248,88.76,7]
#test2[2016,36000,1,0,0,2755,171.5,8]
#[2010, 72000, 0, 1, 0, 998, 85.16, 5]
# print(f'rent amount preadictiom is {int(sum(XPre*model.coef_)+model.intercept_)}')
# m1=np.array(XPre).reshape(1,-1)
# print(model.predict(m1))




# training_data_prediction = model.predict(xTrain)
# plt.scatter(yTrain, training_data_prediction)
# plt.xlabel("Actual Price")
# plt.ylabel("Predicted Price")
# plt.title(" Actual Prices vs Predicted Prices")
# plt.show()
# '''
# test_data_prediction = model.predict(xTest)

# plt.scatter(yTest, test_data_prediction)
# plt.xlabel("Actual Price")
# plt.ylabel("Predicted Price")
# plt.title(" Actual Prices vs Predicted Prices")
# plt.show()'''