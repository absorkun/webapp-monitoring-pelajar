#!/bin/bash

ENV_FILE=".env"

if [ ! -f "$ENV_FILE" ]; then
  echo "$ENV_FILE tidak ditemukan!"
  exit 1
fi

sed -i 's/^APP_ENV=.*/APP_ENV=production/' "$ENV_FILE"
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' "$ENV_FILE"

echo "Environment diubah ke production."
