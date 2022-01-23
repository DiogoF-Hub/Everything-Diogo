charList = ["a","x","b","y","c","z","d","e","f","1","2","3","4"]

charList[8] = ("y")
print(charList)

charList[0] = ("j")
print(charList)

charList.remove("4")
print(charList)

charList.append("k")
print(charList)

charList.append("m")
charList.append("n")
print(charList)

charList.insert(3, "k")
print(charList)

charList.sort()
print(charList)