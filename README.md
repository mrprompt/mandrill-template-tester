# Mandrill Template Tester

[![Build Status](https://travis-ci.org/mrprompt/mandrill-template-tester.svg?branch=master)](https://travis-ci.org/mrprompt/mandrill-template-tester)

Uma forma simples de testar seus templates do Mandrill

### Instalação

Basta criar o arquivo .env no diretório da aplicação, com o conteúdo:

```
MANDRILL_API_KEY="meu-token-do-mandrill"
```

### Uso

```
$ php console.php template:test 'template-id' 'email-de-destino' 'email-de-origem' '[tags]'
```