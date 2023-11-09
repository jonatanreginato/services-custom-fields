# Services Custom Fields

[![Technology][php-image]][php-url]
[![Technology][mezzio-image]][mezzio-url]
[![Technology][nginx-image]][nginx-url]
[![Technology][docker-image]][docker-url]
[![Technology][elastic-image]][elastic-url]


[php-url]: https://www.php.net/

[php-image]: https://img.shields.io/badge/PHP-8.2-grey?style=for-the-badge&logo=PHP&logoColor=white&labelColor=blue

[jsonapi-image]: https://img.shields.io/badge/json:api-v1.1-5a5a5a?style=for-the-badge&labelColor=0b4e22

[jsonapi-url]: https://jsonapi.org/

[mezzio-url]: https://docs.mezzio.dev/

[mezzio-image]: https://img.shields.io/badge/mezzio-v3-013755?style=for-the-badge&labelColor=009655

[psr7-url]: https://www.php-fig.org/psr/psr-7/

[psr7-image]: https://img.shields.io/badge/PSR_7-f09f47?style=for-the-badge

[psr15-url]: https://www.php-fig.org/psr/psr-15/

[psr15-image]: https://img.shields.io/badge/PSR_15-f09f47?style=for-the-badge

[nginx-url]: https://www.nginx.com/

[nginx-image]: https://img.shields.io/badge/nginx-009639?style=for-the-badge&logo=nginx&logoColor=white

[docker-url]: https://www.docker.com/

[docker-image]: https://img.shields.io/badge/Docker-blue?style=for-the-badge&logo=Docker&logoColor=white

[elastic-url]: https://www.elastic.co/pt/elastic-stack

[elastic-image]: https://img.shields.io/badge/elastic_stack-005571?style=for-the-badge&logo=elasticstack&logoColor=white

Application developed to manage custom fields for various Nuvemshop (Tiendanube) business domains.
A custom field allows the store owner/merchant to expand their experience and control their own business through personalized and unique custom fields for orders, products, product variants, categories or customers.
This is an REST API built with PHP 8.2 driven by [Mezzio framework][mezzio-url], using the [PSR-7][psr7-url] and [PSR-15][psr7-url] specifications.

**Índice**

* [services-custom-fields](#services-custom-fields)
    * [Team](#team)
    * [Resources](#resources)
    * [Requirements](#requirements)
    * [Development environment setup](#development-environment-setup)
    * [Accessing the application](#accessing-the-application)
    * [Contribution](#contribution)
    * [Versioning](#versioning)
    * [API documentation](#api-documentation)
    * [Other information](#other-information)
    * [License](#license)

## Team

**[Squad Cross Business — Nuvemshop](https://github.com/orgs/TiendaNube/teams/cross-business)**

<img align="middle" width="80px;" style="margin: 20px 0; border-radius: 10%;" src="https://github.com/mshibata-nuvemshop.png" /> <img align="middle" width="80px;" style="margin: 20px 0; border-radius: 10%;" src="https://github.com/LuizHonorato.png" /> <img align="middle" width="80px;" style="margin: 20px 0; border-radius: 10%;" src="https://github.com/jonathanbraznuvem.png" /> <img align="middle" width="80px;" style="margin: 20px 0; border-radius: 10%;" src="https://github.com/marianadasilvanuvem.png" /> <img align="middle" width="80px;" style="margin: 20px 0; border-radius: 10%;" src="https://github.com/jnreginato.png" />

## Resources:

* [NGINX](https://www.nginx.com/) — High performance load balancer, web server and reverse proxy.

* [PHP](https://www.php.net/) — A popular general-purpose scripting language that is especially suited to web development.

* [MySQL](https://www.mysql.com/) — The world's most popular open source database.

## Requirements:

+ [Docker](https://www.docker.com/)
+ [Docker Compose](https://docs.docker.com/compose/install/)

## Development environment setup

The application provides a [`compose.yaml`](compose.yaml) for use with [Docker Compose](https://docs.docker.com/compose/).

Build and launch the images by running the script:

```shell
$ sudo ./bin/runenv.sh
```

The following services will be performed:

+ **services-custom-fields-nginx**: image: nginx:alpine
+ **services-custom-fields-php**: image: php:8.2.7-fpm-alpine
+ **services-custom-fields-elk**: image: sebp/elk:latest

After the image provisioning confirmation message, you can visit http://localhost:8181 (HTTP/HTTP1.1) or http://localhost:8282 (HTTPS/ HTTP2.0) to test the environment setup.

If everything went well, voilà, you are ready to use the application!

## Accessing the application

- [**Development**](http://localhost:8181/)
- [**Staging**]() TODO
- [**Production**]() TODO

## Contribution

1. Please read the [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md).
2. See the [CODING_STANDARDS.md](CODING_STANDARDS.md) to know our basic coding standard.
3. Please read the [COMMIT_STANDARD.md](COMMIT_STANDARD.md).
4. Please read the [CONTRIBUTING.md](CONTRIBUTING.md) for details on the pull requests submission process.
5. See the [CONTRIBUTION_CHEATSHEET.md](CONTRIBUTION_CHEATSHEET.md) for a contribution quick guide.

## Versioning

For available versions, access [link](https://github.com/jonatanreginato/services-custom-fields/releases).

## API documentation

TODO

## Other information

TODO

## License

See the [LICENSE.md](LICENSE.md) file for details.
