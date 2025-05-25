#!/bin/bash

# ----------------------------
# Veebilehe ja andmebaasi varukoopia skript
# Autor: Mart Mäekask
# Käivitub iga 2 tunni järel croniga
# ----------------------------

# Määratle muutujad
BACKUP_DIR="/var/backups"
WEB_DIR="/var/www/html/uuemoisa_miil"
DB_NAME="uuemoisa_miil"
DB_USER="miiluser"
DB_PASS="miilparool"
DATE=$(date +"%Y-%m-%d_%H-%M")
BACKUP_NAME="backup_$DATE.tar.gz"

# Loo ajutine kaust varukoopia jaoks
TMP_DIR="/tmp/backup_$DATE"
mkdir -p "$TMP_DIR"

# 1. Salvesta andmebaas .sql faili
mysqldump --no-tablespaces -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$TMP_DIR/db.sql"

# 2. Kopeeri veebifailid varukoopiasse
cp -r "$WEB_DIR" "$TMP_DIR/html"

# 3. Paki kõik kokku üheks .tar.gz failiks
tar -czf "$BACKUP_DIR/$BACKUP_NAME" -C "$TMP_DIR" .

# 4. Kustuta ajutine kaust
rm -rf "$TMP_DIR"

# 5. Kustuta varukoopiad, mis on vanemad kui 7 päeva
find "$BACKUP_DIR" -name "backup_*.tar.gz" -type f -mtime +7 -exec rm {} \;

# 6. Logi (valikuline)
echo "[$(date)] Varukoopia loodud: $BACKUP_NAME" >> /var/log/backup.log

