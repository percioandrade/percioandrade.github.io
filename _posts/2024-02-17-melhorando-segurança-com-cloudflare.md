---
layout: post
title:  Melhorando a segurança do WordPress com Cloudflare
categories: [WordPress,Security]
excerpt: Aprenda a como utilizar da melhor maneira o WAF e RateLimite do WordPress
---

<img src="https://percioandrade.github.io/images/waf_000.png" style="text-align:center;"/>

Se o seu site estava funcionando normalmente e, de repente, você começa a notar acessos vindos de países como China, Rússia, Taiwan, Índia e outros acessos suspeitos, provavelmente está lidando com bots.

No entanto, nem todos esses acessos são gerados por bots. Às vezes, são pessoas com más intenções, buscando roubar informações ou prejudicar o seu projeto.

Se você perceber o seu site ficando lento ou recebendo um grande volume de requisições para uma única página ou arquivo, é possível que esteja sendo alvo de um ataque, como força bruta ou inundação de requisições.

Uma maneira de lidar com isso é utilizando o plano gratuito do Cloudflare para reforçar a segurança do seu site. Vamos aprender como fazer isso.

# WAF o que é isto?

Um Web Application Firewall (WAF) é um tipo de firewall que protege os aplicativos da web contra vários tipos de ataques, como hackers, injeção de SQL e cross-site scripting (XSS), entre outros. Aqui estão as principais características do WAF:

- **Filtragem de Tráfego:** Monitora o tráfego da web para identificar padrões suspeitos.
- **Regras de Segurança Personalizadas:** Permite criar regras para bloquear tráfego indesejado.
- **Prevenção de Injeção de SQL:** Detecta e bloqueia tentativas de injeção de SQL.
- **Proteção contra XSS:** Previne ataques de cross-site scripting.
- **Monitoramento de Protocolo:** Analisa os cabeçalhos HTTP e outras informações para identificar comportamentos suspeitos.
- **Mitigação de DDOS:** Alguns WAFs ajudam a mitigar ataques de negação de serviço distribuído (DDoS).
- **Logging e Relatórios:** Registra atividades para análise e geração de relatórios.
- **Integração com SIEM:** Integra-se com sistemas de segurança para uma visão abrangente da postura de segurança.

O WAF é crucial para proteger aplicativos da web contra uma variedade de ameaças. O CloudFlare oferece essa ferramenta em seu plano gratuito, embora de forma limitada, mas ainda eficaz na maioria dos casos.

## Configurando

Acesse seu domínio na Cloudflare

<img src="https://percioandrade.github.io/images/waf_001.png" />

Em seguida na janela do WAF vamos começar a cadastrar algumas regras, para isto clique no botão "Create Rule".

### Regras

#### Bloqueando acessos diretos WordPress

Objetivo: Está regra tem como objetivo bloquear acessos não autorizados a caminhos do WordPress sem o referenciador principal sendo o domínio.

Ela pode ser adaptada para outros aplicativos não é necessariamente estrita para o WordPress.

Configure da forma abaixo:

| Campo     | Operador      | Valor          | Tipo |
| --------- | ------------- | -------------- | ---- |
| URl       | é igual       | /xmlrpc.php    | OU   |
| OU        |               |                |      |
| URI       | contém        | /wp-content/   | e    |
| Referente | não é igual a | dominio.com.br |      |
| OU        |               |                |      |
| URI       | contém        | /wp-includes/  | e    |
| Referente | não é igual a | dominio.com.br |      |

Em escolher ação selecione: Desafio gerenciado

Observação: Altere domínio.com.br para o domínio seu site.

Caso queira facilitar você pode copiar a expressão abaixo e inserir no editar expressão:
<pre>
(http.request.uri eq "/xmlrpc.php") or (http.request.uri contains "/wp-content/" and http.referer ne "dominio.com.br") or (http.request.uri contains "/wp-includes/" and http.referer ne "dominio.com.br")
</pre>

Para ativar clique em "Implantar"


#### Permitir apenas IP nacional no wp-admin

Objetivo: Está regra tem como objetivo bloquear acessos de endereços de IP de fora do Brasil ao painel administrativo do WordPress.

Configure da forma abaixo:

| Campo     | Operador      | Valor          | Tipo |
| --------- | ------------- | -------------- | ---- |
| País      | não é igual   | Brazil         | e   |
| Caminho da URl | está em | /wp-admin |      |

Expressão:

<pre>(ip.geoip.country ne "BR" and http.request.uri.path in {"/wp-admin/"})</pre>

Em escolher ação selecione: Bloquear

#### Bloquear bots nos formulários de contato

Objetivo: Está regra tem como objetivo bloquear bots conhecidos nos formulários de contatos.

| Campo     | Operador      | Valor          | Tipo |
| --------- | ------------- | -------------- | ---- |
| Bots conhecidos       | é igual       | DESMARCADO   | e   |
| Caminho do URI       | contém        | /wp-admin/admin-ajax.php   | e    |
| Método de solicitação | é igual | POST | e   |
| Referente | não contém | dominio.com.br |      |

Observação: Altere domínio.com.br para o domínio seu site.

Expressão:
<pre>(not cf.client.bot and http.request.uri.path contains "/wp-admin/admin-ajax.php" and http.request.method eq "POST" and not http.referer contains "dominio.com.br")</pre>

Em escolher ação selecione: Desafio gerenciado

#### Bloquear bots maliciosos

Objetivo: Está regra tem como objetivo bloquear bots maliciosos que porventura acessam seu site.

Configure da forma abaixo:

| Campo     | Operador      | Valor          | Tipo |
| --------- | ------------- | -------------- | ---- |
| Bots conhecidos       | é igual       | DESMARCADO   | e   |
| Método de solicitação       | é igual        | POST   | e    |
| Referente | não é igual a | dominio.com.br |      |

Observação: Altere domínio.com.br para o domínio seu site.

Expressão:
<pre>(not cf.client.bot and http.request.method eq "POST" and http.referer ne "dominio.com.br")
</pre>

Em escolher ação selecione: Desafio gerenciado

Com as regras acima o site ficará muito mais seguro, veja alguns exemplos de solicitação sem referer, direta com curl

Sem proteção:

<img src="https://percioandrade.github.io/images/waf_002.png" />

Com proteção:

<img src="https://percioandrade.github.io/images/waf_003.png" />

Com estas regras vamos conseguir proteger e adicionar uma camada maior de segurança ao WordPress.

### Rate-Limit

Mesmo com as regras acima, uma pessoa má intencionada conseguirá fazer um ataque de requisição no site afim de compromete-lo ou mesmo deixa-lo lento ou sem acesso.

Para tal, vamos criar um limite de requisições para o WordPress.

Acesse em seu Cloudflare "Regras de Rate Limiting"

<img src="https://percioandrade.github.io/images/waf_004.png" />

Clique em "Criar Regra"

Configure da forma abaixo:

#### Rate Limit WordPress

| Campo     | Operador      | Valor          | Tipo |
| --------- | ------------- | -------------- | ---- |
| Caminho do URI       | é igual       | /wp-admin/admin-ajax.php    | OU   |
| OU        |               |                |      |
| Caminho do URI       | é igual        | /wp-login.php   | OU    |
| OU        |               |                |      |
| Caminho do URI       | é igual        | /wp-admin/   | OU    |
| OU        |               |                |      |
| URI       | contém        | /wp-includes/  | e    |
| Referente | não é igual a | dominio.com.br |      |

Expressão:
<pre>(http.request.uri.path eq "/wp-admin/admin-ajax.php") or (http.request.uri.path eq "/wp-login.php") or (http.request.uri.path contains "/wp-admin/")</pre>

Com as mesmas características: IP

Quando a taxa excede...

- Solicitações (necessário): 130
- Ponto final (necessário): 10 segundos

Então, aja...

- Escolher ação (necessário): Bloquear
- Com tipo de resposta: Texto personalizado
- Com código de resposta: 429

- Corpo da resposta: Insira um texto que queira exibir.

Por duração...

Duração (necessário): 10 segundos

Feito isto, clique em "Salvar"

Veja como fica o rate-limite com e sem proteção.

Sem proteção:

rodei um stress no site no wp-login.php sem a proteção e após 500 acessos direto sem limite o acesso caiu no servidor.

<img src="https://percioandrade.github.io/images/waf_005.png" />

Com proteção:

Já com a proteção após o acesso direto 191 houve um bloqueio com o retorno de código 429

<img src="https://percioandrade.github.io/images/waf_006.png" />

Com isto conseguimos realizar grande parte de abusos de bloqueios diretos tanto autenticados e não autenticados.

Mantendo assim o site muito mais seguro.