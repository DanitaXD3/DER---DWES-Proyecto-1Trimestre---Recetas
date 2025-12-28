CREATE DATABASE IF NOT EXISTS recetas;
USE recetas;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios (id, email, name, password) VALUES
(1, 'juan@example.com', 'Juan', '1234'),
(2, 'maria@example.com', 'Maria', 'abcd'),
(3, 'pedro@example.com', 'Pedro', 'qwerty');


CREATE TABLE IF NOT EXISTS recetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    pais_origen VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    estrellas INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO recetas (id, nombre, pais_origen, descripcion, estrellas) VALUES
(10, 'Paella Valenciana', 'España', 'Arroz con mariscos y pollo típico de Valencia', 5),
(11, 'Tacos al Pastor', 'México', 'Tacos de cerdo marinados con piña y especias', 4),
(12, 'Sushi', 'Japón', 'Arroz con pescado crudo, algas y vegetales', 5),
(13, 'Poutine', 'Canadá', 'Patatas fritas con queso y salsa gravy', 3),
(14, 'Croissant', 'Francia', 'Panecillo hojaldrado y mantecoso típico francés', 4),
(15, 'Curry de Pollo', 'India', 'Pollo cocinado con especias y salsa de curry', 5),
(16, 'Spaghetti Carbonara', 'Italia', 'Pasta con huevo, queso y panceta', 5),
(17, 'Chow Mein', 'China', 'Fideos salteados con vegetales y carne', 4),
(18, 'Baklava', 'Turquía', 'Postre de hojaldre con nueces y miel', 5),
(19, 'Goulash', 'Hungría', 'Estofado de carne y paprika', 4);

CREATE TABLE IF NOT EXISTS recetas_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    receta_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (receta_id) REFERENCES recetas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO recetas_usuario (usuario_id, receta_id) VALUES
(1, 10),
(1, 12);

INSERT INTO recetas_usuario (2, 11),
(2, 15);

INSERT INTO recetas_usuario (3, 16),
(3, 18);
