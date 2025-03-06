# 🐉 Proyecto D&D - Generador de Personajes

📜 **Bienvenido a mi proyecto de Dungeons & Dragons** 🎲, una aplicación web que permite a los usuarios **crear su personaje** en base a sus respuestas en un cuestionario. Se generan su **raza, clase, habilidades y arma**, todo de manera dinámica según las reglas del juego. 

## ✨ Características principales

- 📌 **Selección de raza y clase** basada en respuestas del usuario.
- 🎲 **Generación automática de características** (Fuerza, Destreza, Constitución, etc.).
- 🏹 **Asignación de armas** según la clase del personaje.
- 📖 **Habilidades seleccionables** (Acrobacias, Percepción, Conocimiento Arcano, etc.).
- 💾 **Almacenamiento de datos en sesiones** para mantener el progreso.
- 🔀 **Elección aleatoria en caso de empate** en la raza o clase.
- 🚀 **Interfaz dinámica e intuitiva**.

---

## 🛠️ Tecnologías utilizadas

- **Frontend:** HTML5, CSS3, JavaScript.
- **Backend:** PHP 8+.
- **Control de versiones:** Git y GitHub.

---

## 📥 Instalación y configuración

Para ejecutar el proyecto en tu entorno local:

1. **Clona este repositorio**
   ```sh
   git clone https://github.com/LivanAG/D-D.git


📂 Estructura del Proyecto
📁 d&d/
│── 📄 index.php                # Página de inicio
│── 📄 pagina1.php              # Selección de raza
│── 📄 pagina2.php              # Selección de clase y arma
│── 📄 pagina3.php              # Generación de características
│── 📄 pagina4.php              # Selección de habilidades
│── 📄 resultado.php            # Muestra los datos finales del personaje
│── generarCaracteristicas.php  # Funciones y lógica del backend
│── 📁 imgs/                    # Archivos e imágenes
│── 📄 README.md                # Documentación del proyecto




🎭 Razas y Clases en el Proyecto

🏹 Razas Disponibles
Humano, Enano, Elfo, Gnomo, Semielfo, Dracónido, Mediano, Semiorco, Tiflin.

⚔️ Clases Jugables
Bárbaro, Bardo, Clérigo, Druida, Guerrero, Hechicero, Explorador, Paladín, Pícaro, Mago, Monje, Brujo.

🛡️ Armas según la Clase
Cada clase tiene armas asignadas de forma lógica:
Guerrero → Espada larga, Lanza, Arco largo, Hacha de batalla.
Pícaro → Daga, Espada corta, Ballesta ligera, Látigo.
Mago → Bastón, Daga, Honda.
(Ver más detalles en el código fuente)
