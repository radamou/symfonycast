#!/bin/bash
set -e

if [ "$POSTGRES_EXTRA_DATABASE" != "" ]; then
    psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" -c "
        CREATE USER $POSTGRES_EXTRA_USER WITH PASSWORD '$POSTGRES_EXTRA_PASSWORD';
    "
    # Create database cannot be executed from a function or multi-command string
    psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" -c "CREATE DATABASE $POSTGRES_EXTRA_DATABASE OWNER $POSTGRES_EXTRA_USER"
fi
