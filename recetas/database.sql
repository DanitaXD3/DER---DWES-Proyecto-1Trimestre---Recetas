CREATE DATABASE IF NOT EXISTS recetas;
USE recetas;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS recetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    pais_origen VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    estrellas INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO recetas (id, nombre, pais_origen, descripcion, estrellas) VALUES
(1, 'Paella Valenciana', 'España', 'Arroz con marisco, pollo, conejo y verduras, típico de Valencia.', 2),
(2, 'Pizza Margherita', 'Italia', 'ESTO ES UNA PRUEBA DE EDICIÓN', 1),
(3, 'Sushi', 'Japón', 'Arroz avinagrado con pescado crudo y algas, presentación en rollos o nigiri.', 5),
(4, 'Croissant', 'Francia', 'Pastel hojaldrado y mantecoso. Y ESTÁ DELICIOSO, ESTO ESTÁ EDITADO', 4),
(5, 'Baklava', 'Turquía', 'Postre de masa filo rellena de nueces y bañado en miel.', 4),
(11, 'Feijoada', 'Brasil', 'Estofado de frijoles negros con carne de cerdo y especias.', 5),
(12, 'Kimchi', 'Corea del Sur', 'Col fermentada con picante y ajo, plato tradicional coreano.', 4),
(13, 'Moussaka', 'Grecia', 'Pastel de berenjena con carne picada y bechamel.', 4),
(14, 'Biryani', 'India', 'Arroz con especias, carne o verduras, muy aromático y colorido.', 5),
(15, 'Pierogi', 'Polonia', 'Empanadillas rellenas de patata, queso, carne o fruta, hervidas o fritas.', 3),
(16, 'Shakshuka', 'Túnez', 'Huevos escalfados en salsa de tomate picante con pimientos y especias.', 4),
(17, 'Paella de Marisco', 'España', 'Arroz con mariscos variados como gambas, mejillones y calamares.', 5),
(18, 'Churros', 'España', 'Masa frita espolvoreada con azúcar, ideal para desayunos o meriendas.', 4),
(19, 'Couscous', 'Marruecos', 'Sémola de trigo acompañada de verduras y carne cocinadas al vapor.', 4),
(20, 'Lasagna', 'Italia', 'Capas de pasta, carne, salsa de tomate y queso gratinado al horno.', 5),
(21, 'Gnocchi', 'Italia', 'Bolitas de patata cocidas y servidas con salsa de tomate o pesto.', 4),
(22, 'Empanadas', 'Argentina', 'Masa rellena de carne, pollo o verduras, horneadas o fritas.', 4),
(23, 'Ramen', 'Japón', 'Sopa de fideos con caldo, carne, huevo y verduras.', 5),
(24, 'Pad Kra Pao', 'Tailandia', 'Salteado de carne con albahaca tailandesa, servido con arroz y huevo.', 4),
(25, 'Falafel', 'Líbano', 'Croquetas fritas de garbanzo y especias, se sirven en pita con vegetales.', 4),
(26, 'Tom Yum', 'Tailandia', 'Sopa picante y ácida con gambas, hierbas aromáticas y champiñones.', 5),
(27, 'Pasta Carbonara para Antonio :)', 'CPIFP ALAN TURING', '2 DAW DANA', 2),
(28, 'Pavlova', 'Australia', 'Merengue crujiente por fuera, suave por dentro, con crema y fruta fresca.', 4),
(29, 'Gaspacho', 'España', 'Sopa fría de tomate, pepino, pimiento, aceite y vinagre.', 3);

CREATE TABLE IF NOT EXISTS recetas_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    receta_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (receta_id) REFERENCES recetas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
