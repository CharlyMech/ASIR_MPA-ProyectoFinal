import matplotlib.pyplot as plt

x = [18.57,6.25,12.5,6.25,20,31.25,5]
labels = ['Paso 1', 'Paso 2', 'Paso 3', 'Paso 4', 'Paso 5', 'Paso 6', 'Paso 7',]
colors = ['tab:blue', 'tab:cyan', 'tab:gray', 'tab:orange', 'tab:red', 'tab:pink', 'tab:green']

fig, ax = plt.subplots()
ax.pie(x, labels=labels, colors=colors, autopct='%.0f%%')
# ax.set_title('Tiempo invertido en cada paso')
plt.show()
