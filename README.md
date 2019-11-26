# Kafka Author

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/96e04c67f5634700bfb89766c2589346)](https://app.codacy.com/app/mikebywater/kafka-author?utm_source=github.com&utm_medium=referral&utm_content=mikebywater/kafka-author&utm_campaign=Badge_Grade_Dashboard)

# Getting Started

```bash
composer create-project mikebywater/kafka-author

composer start
```
Navigate to

`http://localhost:8088`

Note you will need php with the RDKafka extension installed locally. Alternatively if you have docker compose installed you can simply run

```bash
docker-compose up -d
```
And again, navigate to

`http://localhost:8088`


# Fake Data

When producing there is a limited ability to create fake data. The following substitutions are possible.

```php
!!NAME!!       // returns as full name eg. Mike Bywater
!!FIRST_NAME!! // returns a first name eg. Tom
!!LAST_NAME!!  // returns a surname eg. Barnes
!!EMAIL!!      // returns an email eg. mike.bywater@cityfibre.com

!!NUMBER!!     // returns a single digit eg. 1

!!STREET!!     // returns a street name eg. Coach Lane
!!POSTCODE!!   // returns a UK postcode eg. MK9 3NZ
!!CITY!!       // returns a city eg. Milton keynes
 
```


