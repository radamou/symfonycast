FROM postgres:9.6-alpine

COPY files/. /

HEALTHCHECK --interval=10s --timeout=3s --start-period=120s --retries=3 CMD pg_isready -U postgres -p 5432 -h 0.0.0.0
