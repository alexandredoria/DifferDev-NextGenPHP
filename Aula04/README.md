# Desafio Aula04

## Ajustar um componente validador, para que fique mais inteligente segundo a problemática a seguir
Seu usuário do componente ```Validator``` quer poder armazenar um conjunto de validações e posteriormente valida-lo 
sobre alguns valores, veja abaixo como está a atual implementação:

```php

$value = '302';
$result1 = Validator::validateInteger($value);
$result2 = Validator::validateGreaterThan($value, 200);
$result3 = Validator::validateEven($value);

var_dump($result1, $result2, $result3);

```
Veja que na implementação atual não tem como ```salvar``` um conjunto de validação
Ache uma forma de implementar um design semelhante o exemplo abaixo:
```php
// Esse é um exemplo, você pode criar uma interface completamente diferente!
// Desde que a funcionalidade de agregar validações funciona semelhante com
// o teste, use sua criatividade!
$validationGroup = $validator->addValidation(new IsInteger())
                             ->addValidation(new IsGreaterThan(200))
                             ->addValidation(new IsEven())
                   ;
$result = $validationGroup->validate('304');  
```
Olhe o teste para se guiar, ao alterar a classe Validator, lembre-se de atualizar os testes e se preciso fazer novos
teste, mas lembre-se que no momento o mais importante é resolver o teste principal da classe Validator.

Extra: Se criar um teste de integração será adicionado pontos extras da plataforma ao desafio!

Comandos:
```bash
# Subir container
$ make up

# instalar deps
$ ./shell/compose install

# rodar os testes
$ make test
```

Bons estudos!
