charList = ["a", "x", "b", "y", "c", "z", "d", "e", "f", "1", "2", "3", "4"]

charList[8] = ("y")
print(charList)

charList[9] = ("j")
print(charList)

charList.pop(-1)
print(charList)

charList.pop(5)
print(charList)


print(charList)

charList.append("k")
print(charList)

charList.append("m")
print(charList)
charList.append("n")
print(charList)

charList[4] = ("o")
print(charList)

charList.sort()
print(charList)
