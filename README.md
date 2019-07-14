# Transparent AES

## Functional Specs

### Upload Image
- upload scanned A4-size image via /api/image/upload end-point
- validate image

### Process Image
- transfuse qr_code from image to model

### Persist Electronic Ballot
- sync unique qr_code with ballot
- save image in storage
- post image storage path in database

### Appreciate Ballot Image
- Image processing
- OMR processing
- OMR map generation

### Messaging
- can send SMS





