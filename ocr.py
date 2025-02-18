from paddleocr import PaddleOCR
import sys
import json

# Obtener la ruta de la imagen desde los argumentos
image_path = sys.argv[1]

# Inicializar PaddleOCR en español con logs desactivados
ocr = PaddleOCR(lang="es", show_log=False)  # Desactiva logs de depuración

# Realizar OCR
result = ocr.ocr(image_path, cls=False)

# Extraer solo el texto reconocido
extracted_text = [line[1][0] for block in result for line in block]

# Imprimir el resultado en formato JSON para PHP (asegurando solo JSON limpio)
print(json.dumps(extracted_text, ensure_ascii=False))

