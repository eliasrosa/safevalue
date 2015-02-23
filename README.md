# Safe Value

Essa class PHP foi criada para gerar valores seguros, que ao receber o valor, ela verifica se o mesmo foi alterado pelo o usuário.

Sempre será gerado um novo valor.

# Exemplo

Usar em links de e-mails enviados para o usuário.

http://seudominio.com/gerar-boleto?fatura=777555

Para evitar que o usuário fique trocando o ID da fatura, por exemplo, podemos usar...

```
<?php

$id = 777555;

$foo = new SafeValue();
echo "http://seudominio.com/gerar-boleto?fatura=" . $foo->encode($id);
// return VGVzdDE=:fe8a68005c11318:65128ae4e56c186

```

# Recebendo


```
<?php

$id = $_GET['fatura'];

$bar = new SafeValue();
echo $foo->decode($id);
// return 777555

```

# Importante

Lembre-se que esse valor é visível, não é remomendado usar para salvar senhas no banco de dados ou algo parecido.




