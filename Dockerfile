FROM postgres:15.2


ENV POSTGRES_USER user105
ENV POSTGRES_PASSWORD pg_password
COPY restore.sh /docker-entrypoint-initdb.d/
COPY dump.sql /


EXPOSE 5432

