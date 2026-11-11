CREATE TABLE CatContaOrden (
    id INT IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    estado TINYINT DEFAULT 1 NOT NULL, -- 1: Activo, 0: Inactivo
    
    -- Campos de Bitácora / Auditoría (Usuario logueado)
    cod_usuario_crea_aud VARCHAR(50) NOT NULL,
    fec_usuario_crea_aud DATETIME DEFAULT GETDATE() NOT NULL,
    cod_usuario_modif_aud VARCHAR(50) NULL,
    fec_usuario_modif_aud DATETIME NULL
);

CREATE TABLE ubicacionContaOrden (
    id INT IDENTITY(1,1) PRIMARY KEY,
    ubicacion VARCHAR(250) NOT NULL,
    estado TINYINT DEFAULT 1 NOT NULL, -- 1: Activo, 0: Inactivo
    
    -- Campos de Bitácora / Auditoría (Usuario logueado)
    cod_usuario_crea_aud VARCHAR(50) NOT NULL,
    fec_usuario_crea_aud DATETIME DEFAULT GETDATE() NOT NULL,
    cod_usuario_modif_aud VARCHAR(50) NULL,
    fec_usuario_modif_aud DATETIME NULL
);
