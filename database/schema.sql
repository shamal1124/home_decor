-- USERS TABLE
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'designer') NOT NULL
);

-- DESIGNS TABLE
CREATE TABLE designs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    designer_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,      -- Updated field to store Cloudinary URL
    title VARCHAR(100) NOT NULL,
    description TEXT,
    room_type ENUM('kitchen', 'hall', 'bedroom', 'bathroom', 'office', 'other') NOT NULL,
    FOREIGN KEY (designer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- REQUESTS TABLE
CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    designer_id INT NOT NULL,
    design_id INT NOT NULL,
    message TEXT,
    request_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (designer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (design_id) REFERENCES designs(id) ON DELETE CASCADE
);