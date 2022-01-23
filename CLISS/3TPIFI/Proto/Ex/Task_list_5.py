charList = ["a", "b", "c", "d", "e", "f"]

charList[-1] = ("y")
print(charList)

charList[0] = ("x")
print(charList)

charList.pop(2)
print(charList)

charList.remove("d")
print(charList)

charList = ["a", "b", "c", "d", "e", "f"]
charList.append("g")
print(charList)

charList.append("i")
charList.append("h")
print(charList)

charList.insert(1, "h")
print(charList)

charList.sort()
print(charList)
