import fitz  # PyMuPDF
import os

pdf_path = r"public\assets\images\GETREADY (12).pdf"
output_path = r"public\assets\images\invoice-header.png"

doc = fitz.open(pdf_path)
page = doc[0]

# Get full page dimensions
rect = page.rect
print(f"Page size: {rect.width} x {rect.height} points")

# Crop to just the dark header portion (top 22% of the page)
header_height = rect.height * 0.22
clip = fitz.Rect(0, 0, rect.width, header_height)

# Render at high DPI for quality
mat = fitz.Matrix(3, 3)  # 3x zoom = ~216 DPI
pix = page.get_pixmap(matrix=mat, clip=clip, colorspace=fitz.csRGB)
pix.save(output_path)

print(f"Header saved to: {output_path}")
print(f"Output size: {pix.width} x {pix.height} px")
doc.close()
