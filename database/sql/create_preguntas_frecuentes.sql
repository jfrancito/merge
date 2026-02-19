-- =============================================
-- TABLA: preguntas_frecuentes_asistente
-- Almacena las preguntas favoritas de cada usuario
-- =============================================

-- Para SQL Server:
IF NOT EXISTS (SELECT * FROM sys.tables WHERE name = 'preguntas_frecuentes_asistente')
BEGIN
    CREATE TABLE preguntas_frecuentes_asistente (
        id INT IDENTITY(1,1) PRIMARY KEY,
        usuario_id VARCHAR(50) NOT NULL,
        pregunta NVARCHAR(500) NOT NULL,
        etiqueta NVARCHAR(100) NULL,         -- Etiqueta opcional como "Mensual", "Proveedores"
        uso_count INT DEFAULT 1,              -- Contador de uso
        created_at DATETIME DEFAULT GETDATE(),
        
        INDEX IX_preguntas_usuario (usuario_id)
    );
    
    PRINT 'Tabla preguntas_frecuentes_asistente creada exitosamente';
END
GO
