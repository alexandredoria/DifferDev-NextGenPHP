# Desafio Aula02

### Criar um ambiente NGINX + PHP-FPM + Postgres
1. O ambiente PHPFPM deve ter o ```php.ini``` sendo lido e configurado para desenvolvimento
2. Criar uma imagem Docker com as extensões habilitadas: pdo_pgsql, opcache e xdebug
3. As extensões devem ser configuradas por um Dockerfile
4. Hospede sua imagem PHP-FPM no Docker Hub com as extensões ativas
5. Monte sua configuração pelo docker-compose.yml subindo NGINX / PHPFPM / Postgres
6. Atente-se às boa práticas vistas na aula

Envie na plataforma um print do servidor rodando e os arquivos do projeto(Dockerfile e docker-compose.yml)