---
layout: post
title:  Backups - A importância de se manter e a maneira correta de fazer
categories: [General]
excerpt: Aprenda a melhor maneira de se criar backups e o motivo de ser tão importante
---

Você está imerso em seu projeto, criando um belíssimo botão gradiente com tonalidades de azul no CSS. Após adicionar um trecho extenso de código, você o salva, ansioso para exibi-lo na web.

Tudo parece perfeito e, satisfeito, você encerra o dia e se recolhe para descansar. Porém, ao acessar seu projeto no dia seguinte, uma surpresa desagradável te aguarda. Parece que todos os seus esforços foram em vão; as alterações não surtiram efeito, ou pior ainda, todos os arquivos foram inexplicavelmente deletados. E agora?

Em algum momento de nossas jornadas, nos deparamos com situações semelhantes. Seja por erros nossos ou de terceiros, é uma experiência frustrante e devastadora. Um misto de indignação e tristeza nos invade, podendo rapidamente se transformar em desespero, especialmente se não possuirmos uma cópia de segurança recente do projeto.

Falo por experiência própria. Durante o desenvolvimento do Bando de Nerd (https://bandodenerd.com.br), eu estava utilizando o Windows com o Subsistema do Linux (WSL), onde tinha o Apache e o MariaDB. Infelizmente, a falta de uma rotina consistente de backups me levou a perder três meses de trabalho, resultado de incontáveis horas de programação. Em outro incidente (HD deu tilt), perdi quase seis meses de esforço. A partir desse momento, passei a realizar backups diários religiosamente.

Aqueles que se dedicam ao desenvolvimento sabem o quão angustiante é perder um projeto no qual você investiu horas intermináveis de codificação. A perspectiva de recriar todo o trabalho é assustadora.

Hoje, tenho adotado o GitHub como meu aliado na preservação dos meus projetos. Além de ser altamente confiável, oferece um controle de versionamento que me proporciona uma gestão mais eficiente dos arquivos. Através dessa plataforma, encontrei uma solução sólida para evitar as agruras de perdas inesperadas.

### Eu confio no meu host!?

Frequentemente, quando nos deparamos com problemas dessa natureza, a reação inicial das pessoas é buscar assistência junto ao provedor de hospedagem. Não há nada de inadequado nessa abordagem; afinal, se o provedor mantém uma política sólida de cópias de segurança, é sensato aproveitar essa vantagem. No entanto, o verdadeiro erro reside em depender única e exclusivamente desse recurso.

Minha experiência em uma empresa me revelou a importância desse fato. Lá, nos deparamos com projetos de considerável porte, e em casos nos quais, por razões diversas, os arquivos pareciam ter desaparecido, confiava-se nos backups como solução. Porém, por surpresa, descobrimos que essas cópias não mais existiam. Como isso é possível? A resposta é simples: certas empresas estabelecem cláusulas explícitas (ou implícitas) que podem acarretar exclusão do seu sistema das rotinas de backup. Fatores como um grande volume de arquivos, excesso de inodes ou gigabytes, e diversas outras condições com muitos "muitos" podem levar a essa remoção.

Portanto, enquanto é apropriado e prudente confiar na infraestrutura de backup do seu provedor, é igualmente vital não confiar cegamente nesse método. Estar ciente das políticas e condições da empresa de hospedagem, e não deixar a sua preciosa informação à mercê de um único mecanismo de salvaguarda, é um passo fundamental para a segurança dos seus projetos.

### Sistema gerenciado, semi-gerenciado ou quase isto

Em certas situações, especialmente quando o sistema não é completamente gerenciado e a responsabilidade recai sobre o próprio usuário, a necessidade de manter uma rotina de backup torna-se crucial. Infelizmente, é nessas circunstâncias que encontramos indivíduos com um conhecimento limitado, levando a cenários desafiadores. Já testemunhei casos em que um servidor dedicado foi entregue a alguém com pouca compreensão sobre hospedagem, e toda a administração foi delegada a essa pessoa. É como entregar um foguete de alta velocidade nas mãos de alguém que mal sabe o que é pilotar, com votos de boa sorte e risos.

Assim, é vital reconhecer que a administração independente de um sistema requer uma compreensão sólida das práticas de backup e manutenção. Colocar alguém despreparado nessa posição pode ser comparável a dar um veículo potente a alguém sem experiência de direção. Assegurar que as pessoas estejam adequadamente informadas e capacitadas para lidar com as responsabilidades técnicas é essencial para evitar situações indesejadas.

### Meu site tem uma super ferramenta de backup!!

Alguns sistemas de gerenciamento de conteúdo, como WordPress, Joomla, entre outros, disponibilizam plugins que prometem automatizar o processo de backup. No entanto, por uma série de razões, geralmente não é aconselhável realizar backups por meio desses plugins. Eis os motivos:

1. **Dependência do PHP:** Tais plugins fazem uso exclusivo dos processos do PHP para listar, compactar e gerar os arquivos de backup.

2. **Risco de Intervenção:** Qualquer interrupção inesperada no processo do PHP pode resultar na geração de um arquivo de backup defeituoso.

3. **Limitações de Escala:** Em projetos de maior porte, a geração do arquivo de backup pode se tornar praticamente inviável, com timeouts ou até mesmo suspensões devido ao alto consumo de recursos exigido pelo servidor.

4. **Confiabilidade Questionável:** Não se pode garantir 100% de confiabilidade, podendo ocorrer situações em que um ou mais arquivos não sejam incluídos no arquivo de backup compactado.

5. **Maior Tempo de Execução:** Além de ser mais susceptível a falhas, a utilização de tais plugins pode acarretar tempos de execução de 2x ou até 3x mais longos do que os métodos de backup tradicionais.

6. **Formatos Específicos e Dependência:** Alguns plugins geram arquivos de backup em formatos particulares, o que significa que a restauração futura estará totalmente condicionada a esse mesmo plugin.

Considerando esses aspectos, a abordagem tradicional de backup é mais confiável e segura. A utilização de scripts ou ferramentas independentes oferece um controle mais preciso sobre o processo de backup, minimizando riscos de falha e garantindo a portabilidade dos arquivos de backup.

### Qual a melhor forma?

A abordagem mais eficaz para realizar um backup completo é ainda a tradicional e consolidada: gerar um arquivo tarball contendo os arquivos e um dump do banco de dados MySQL, comprimir o pacote resultante e armazená-lo em um local de sua escolha.

**Quais são os requisitos?**

- Acesso shell (convencional ou enjaulado).
- O pacote gzip deve estar instalado no servidor.
- Credenciais de acesso ao banco de dados.

Feitas essas considerações, vamos prosseguir.

Acesse o servidor ou a hospedagem por meio do acesso shell, utilizando um terminal apropriado. Existem várias opções disponíveis, incluindo alternativas para Windows ou o terminal padrão do Linux, que é distribuído junto ao sistema.

Ao estabelecer o acesso via shell, o primeiro passo é criar um dump do banco de dados. Para isso, execute o seguinte comando no terminal:

```shell
mysqldump -u usuario -p nome_do_banco > backup.sql && mv backup.sql /home/USUARIO/public_html
```

Onde:

- "usuario" é o nome de usuário do banco de dados.
- "nome_do_banco" se refere ao nome do banco de dados.

Essa ação gerará um arquivo chamado "backup.sql" contendo todos os dados do banco de dados associado ao seu site. Em seguida, o arquivo será movido para a pasta "public_html".

Em seguida, você criará um arquivo tar.gz contendo todos os arquivos do site com o comando a seguir:

```shell
tar -cvf nome_do_arquivo.tar.gz /home/USUARIO/public_html
```

Com essa instrução, será gerado um arquivo compactado chamado "nome_do_arquivo.tar.gz", contendo todos os recursos do site, como imagens e textos.

Ao seguir corretamente esses comandos, você obterá um pacote que engloba tanto o banco de dados quanto os arquivos do site, armazenados dentro do arquivo "nome_do_arquivo.tar.gz".

O próximo passo envolve o download desse arquivo. Para isso, você pode utilizar um cliente FTP, como o Filezilla, para baixar o arquivo, ou movê-lo para a pasta "public_html" do seu site e, a partir daí, fazer o download via URL associada ao seu domínio.

Uma vez que tenha efetuado o download, é crucial manter esse arquivo seguro. Recomenda-se criar cópias em pendrives e serviços de armazenamento em nuvem, garantindo a preservação do backup mesmo em caso de perda.

### Segmentação de backup?

Essa é uma estratégia de backup que envolve a segmentação dos backups em partes específicas. Por exemplo, um arquivo de backup pode conter apenas os uploads, como imagens e outros tipos de arquivos, enquanto outro arquivo concentra-se exclusivamente no tema e seu desenvolvimento. Essa abordagem, ao separar os componentes do site em backups distintos, tem a vantagem de permitir a restauração seletiva de partes individuais, em vez de exigir a recuperação de todo o projeto, caso ocorra a perda de um arquivo.

### Qual a melhor rotina?

A abordagem de rotina mais recomendada para a realização de backups é a diária. No entanto, caso não deseje executar o processo diariamente, uma alternativa é realizá-lo a cada dois dias ou até mesmo semanalmente.

### Versionamento de backup

É de extrema importância manter arquivos de backup de datas diferentes, pois há o risco de gerar um backup a partir de um arquivo que já esteja comprometido. Ter múltiplas cópias de backup permite recorrer a versões anteriores para restaurar o arquivo, caso seja necessário.

### Backup incremental

Os backups incrementais registram somente as alterações mais recentes feitas após o último backup, representando uma estratégia altamente eficiente para acelerar o processo de backup e otimizar o consumo de dados e o tempo de processamento.

### É possível automatizar?

Certamente, em determinados cenários, algumas ferramentas de painel de controle, como cPanel, Vesta, CentosWebPanel, e outras presentes no mercado, oferecem recursos para criar backups. No entanto, é importante destacar que nesse contexto também surge a questão das limitações, uma vez que algumas hospedagens impõem restrições, como um limite de 5GB para a geração de arquivos e processos.

Outra alternativa viável é automatizar o procedimento por meio de scripts. Em breve, compartilharei uma série de scripts voltados para a automação de backups em plataformas como WordPress e outras ferramentas. Essa iniciativa visa simplificar e agilizar a realização de backups, proporcionando maior conveniência no processo.

Fique de olho em :

https://github.com/percioandrade/wpcollection : scripts para WordPress
https://github.com/percioandrade/joomcollection : scripts para Joomla

A medida que novos scripts forem saído para novas plataformas vou adicionado a este artigo.

### Considerações

Agora que você compreende plenamente o sistema de backup e sua relevância, é crucial que você leia atentamente os termos de serviço da sua hospedagem para se familiarizar com o sistema de backups que eles oferecem. Além disso, tome a iniciativa de garantir seus próprios backups, evitando surpresas desagradáveis no futuro.