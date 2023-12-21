---
layout: post
title:  Resolvendo problemas com assinatura de drive revogada
categories: [Windows,Fix]
excerpt: Seu drive parou de funcionar? Veja como resolver
---

<img src="https://percioandrade.github.io/images/certificado__000.webp" style="text-align:center;"/>

Você está utilizando seu computador normalmente quando, de repente, surge uma notificação:

* É necessário atualizar o Windows.

Entusiasmado, você clica alegremente em "Aceitar" e permite a atualização, desligando o computador para utilizá-lo no dia seguinte.

Ao acordar e ligar o computador, o Bluetooth não está mais funcionando e o Wireless não dá nenhum sinal de vida. Tudo parece ter parado de funcionar. E agora?

Pois bem, isso aconteceu comigo! Fiquei perplexo, tentando descobrir o que poderia ter ocorrido. Será que algo deu errado? Houve um problema? O computador está se despedindo? Queimou?

O suor escorria na testa, ainda tinha uma reunião para realizar e agora?

Se você já se viu nessa situação, eu entendo completamente. Aqui está minha história e como resolvi esse problema inesperado.

# Motivo

A Microsoft tem se empenhado continuamente na identificação e combate de métodos de hackeamento em seu sistema operacional. Recentemente, a empresa descobriu uma vulnerabilidade relacionada aos drives em low-code, que permitia a realização de monitoramento de rede nos sistemas Windows. Esse exploit possibilitava a obtenção de informações dos usuários. Diante dessa ameaça, a Microsoft agiu proativamente em sua última atualização, revogando o certificado de mais de 100 provedores, incluindo o Ralink, responsável pelo Bluetooth em meu computador.

# Diagnóstico

Iniciando o processo de diagnóstico, examinei minuciosamente os componentes, registros e relatórios disponíveis para identificar a origem do problema. Foi durante essa análise que percebi um erro no driver Bluetooth, conforme indicado pelo seguinte arquivo:

<img src="https://percioandrade.github.io/images/certificado__001.webp" />

Agora, munidos do conhecimento sobre a causa do contratempo, é crucial iniciar o processo de correção. Para isso, temos duas opções viáveis:

* Utilizar as ferramentas nativas do Windows, como o certmake/signtool.
* Optar por ferramentas de terceiros.

Dada a necessidade de uma solução ágil, escolheremos a abordagem de ferramentas de terceiros. Para isso, empregaremos o utilitário '''dseo13b.exe'''.

* Baixe aqui: https://www.majorgeeks.com/mg/getmirror/driver_signature_enforcement_overrider,1.html

## Iniciando a correção

### Baixando os Drivers para o Seu Computador

Esta etapa é relativamente simples, embora dependa em grande parte de sua disposição e da empresa que desenvolveu o driver. No meu caso, a Ralink foi a criadora, então, ao realizar uma pesquisa no Google por "Ralink bluetooth driver windows 11", encontrei facilmente o driver nas versões Windows 8, 10 da data de 2015 (como é antigo =O)

Normalmente, ele é baixado compactado em um arquivo zip, mas pode estar em outros formatos, como cab.

Crie uma pasta no diretório C: para salvar esses arquivos. Por exemplo:

* C:\Drivers

No meu caso, a estrutura ficou assim:

Diretório: C:\Drivers
* Arquivo: C:\Drivers\123.bin
* Arquivo: C:\Drivers\123.cert
* Arquivo: C:\Drivers\123.sys

### Iniciando o DSEO13b

Ao abrir o arquivo dseo13b.exe, você será apresentado à seguinte tela:

<img src="https://percioandrade.github.io/images/certificado__002.webp" />

Aliás, se você entender inglês, vale a pena ler o texto contido nesta caixa, que é uma crítica bem apropriada à Microsoft, rs.

Clique em "Avançar".

<img src="https://percioandrade.github.io/images/certificado__003.webp" />

Na próxima tela, aceite os termos de serviço. Quero deixar claro que não me responsabilizo por nada; faça tudo por sua conta e risco.

Escolha entre "Yes" ou "No".

Se optar por "Yes", você será direcionado para a tela seguinte:

<img src="https://percioandrade.github.io/images/certificado__004.webp" />

### Ativando o Modo de Teste

O primeiro passo é ativar a opção "Enable Test Mode" e, em seguida, clicar em "Next".

<img src="https://percioandrade.github.io/images/certificado__005.webp" />

Uma confirmação será exibida em seguida.

<img src="https://percioandrade.github.io/images/certificado__006.webp" />

Este aviso indica que o modo de teste foi ativado. Portanto, reinicie seu computador e abra novamente o dseo13b.exe.

### Assinando os Arquivos

Após ativar o modo de teste, reiniciar o computador e abrir novamente o programa, habilite a opção "Sign a System File" e clique em "Next".

Uma nova janela aparecerá, solicitando a localização exata do arquivo. Se você moveu os arquivos para o C:, será fácil localizá-los. Nesta caixa, digite o nome exato do arquivo:

Exemplo: C:\Drivers\123.bin

Ao inserir o nome do arquivo CORRETAMENTE, clique em "Next". Um aviso aparecerá informando que o driver foi assinado:

<img src="https://percioandrade.github.io/images/certificado__008.webp" />

Repita esse processo para todos os arquivos do driver.

Observação:

* Se você já ativou o modo de teste, pode prosseguir com a instalação. Caso contrário, ative-o e reinicie o computador novamente.

### Verificação da Assinatura

Antes de prosseguir, vamos assegurar-nos de que tudo ocorreu conforme o esperado. Para fazer isso, clique com o botão direito em um dos arquivos que foram assinados e vá até "Propriedades do Arquivo". Em seguida, acesse a aba "Assinaturas Digitais".

Na janela que se abre, verifique se está assinado pela entidade "NGO". Se estiver, significa que o processo ocorreu sem problemas.

### Instalação do Driver Auto-Assinado

Agora que temos o driver assinado, vamos proceder com a instalação. Para isso, clique com o botão direito no ícone do Windows e selecione "Gerenciador de Dispositivos".

<img src="https://percioandrade.github.io/images/certificado__010.webp" />

Dentro do Gerenciador de Dispositivos, localize o componente com problema. Pode ser necessário ativar a opção de "Exibir Arquivos Ocultos".

Selecione o dispositivo com o botão direito e escolha a opção "Atualizar Driver".

<img src="https://percioandrade.github.io/images/certificado__011.webp" />

Em seguida, escolha "Procurar Drivers no Meu Computador".

<img src="https://percioandrade.github.io/images/certificado__012.webp" />

Opte por "Permitir que eu Escolha uma Lista de Drivers Disponíveis em Meu Computador".

<img src="https://percioandrade.github.io/images/certificado__014.webp" />

O Windows tentará localizar drivers compatíveis. Caso não encontre, apresentará uma tela onde precisamos escolher o tipo de dispositivo que estamos atualizando, como no caso do Bluetooth.

<img src="https://percioandrade.github.io/images/certificado__015.webp" />

Na nova tela, clique em "Com Disco".

<img src="https://percioandrade.github.io/images/certificado__016.webp" />

Uma nova janela será exibida. Nela, procure o arquivo do driver e clique em "Procurar".

<img src="https://percioandrade.github.io/images/certificado__017.webp" />

Selecione o arquivo do driver assinado, por exemplo:

<img src="https://percioandrade.github.io/images/certificado__018.webp" />

Escolha o arquivo .inf que está incluído nos pacotes do driver. Após a seleção, clique em "Avançar".

Um aviso informará que o driver não é assinado. Escolha "Instalar este Software de Driver Mesmo Assim".

<img src="https://percioandrade.github.io/images/certificado__020.webp" />

Aguarde a conclusão da instalação. Se tudo ocorrer conforme o esperado, uma janela será exibida informando que o driver foi instalado com sucesso.

<img src="https://percioandrade.github.io/images/certificado__021.webp" />

É muito provavel que a partir deste momento tudo volte a funcionar como antes.

# Estou vendo algumas info no meu painel

É se você reparou bem, você vai notar que vai aparecer alguns detalhes do seu sistema operacional na área de trabalho

<img src="https://percioandrade.github.io/images/certificado__022.webp" />

Para remover, vamos seguir o procedimento abaixo

* Acesse o seguinte site: http://deepxw.blogspot.com/2008/12/remove-watermark-v03-build-20081210.html
* Baixe o arquivo Download Universal Watermark Disabler : https://winaero.com/downloads/uwd.zip
* Extraia o arquivo para seu computador e execute o arquivo.

Com o aplicativo aberto, basta clicar em Install

<img src="https://percioandrade.github.io/images/certificado__023.webp" />

Se aparecer algum aviso clique em avançar, testei o aplicativo e está funcional até a ultima versão recente do Windows 22631.2506

Seu usuário será deslogado ao termino e assim que retornar a mensagem já não mais aparecerá em seu desktop :)

E pronto, espero que isto resolva os problemas.

