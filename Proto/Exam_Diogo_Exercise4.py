temperatureList = [int(input("Enter the temperatures: ")) for i in range(5)]
print(temperatureList)

numericalValue = sum(temperatureList)

print(numericalValue)

averageTemperature = (numericalValue/5)
print(averageTemperature)

minimalValue = min(temperatureList)
maximalValue = max(temperatureList)

print(minimalValue)
print(maximalValue)

if averageTemperature < maximalValue:
      print("The entered value", averageTemperature ,"is below the average temperature")

if averageTemperature > maximalValue:
      print("The entered value", averageTemperature ,"is above the average temperature")

if averageTemperature == maximalValue:
      print("The entered value is equal to the average temperature")
