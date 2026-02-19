-- =============================================
-- TABLA: conversacion_asistente
-- Almacena el historial de conversaciones del chatbot por usuario
-- =============================================

-- Para SQL Server:
IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = 'conversacion_asistente')
BEGIN
    CREATE TABLE conversacion_asistente (
        id INT IDENTITY(1,1) PRIMARY KEY,
        usuario_id VARCHAR(50) NOT NULL,       -- VARCHAR para IDs alfanuméricos
        rol VARCHAR(20) NOT NULL,              -- 'user' o 'assistant'
        mensaje NVARCHAR(MAX) NOT NULL,
        ai_mode VARCHAR(50) NULL,              -- 'Claude AI', 'Local', etc.
        tipo_consulta VARCHAR(50) NULL,        -- 'aggregate', 'ranking', etc.
        filtros NVARCHAR(MAX) NULL,            -- JSON con los filtros aplicados
        created_at DATETIME DEFAULT GETDATE(),
        updated_at DATETIME DEFAULT GETDATE(),
        
        INDEX IX_conversacion_usuario (usuario_id),
        INDEX IX_conversacion_fecha (created_at)
    );
    
    PRINT 'Tabla conversacion_asistente creada exitosamente';
END
ELSE
BEGIN
    PRINT 'La tabla conversacion_asistente ya existe';
END
GO

-- =============================================
-- Alternativa para MySQL:
-- =============================================
/*
CREATE TABLE IF NOT EXISTS conversacion_asistente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    rol VARCHAR(20) NOT NULL,
    mensaje TEXT NOT NULL,
    ai_mode VARCHAR(50) NULL,
    tipo_consulta VARCHAR(50) NULL,
    filtros JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX IX_conversacion_usuario (usuario_id),
    INDEX IX_conversacion_fecha (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
*/
