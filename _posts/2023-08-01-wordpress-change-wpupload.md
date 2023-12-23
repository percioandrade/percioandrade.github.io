---
layout: post
title:  WordPress change wp-uploads directory
categories: [WordPress,Code]
excerpt: Aprenda a como alterar o diretório padrão de uploads do WordPress
---

Para melhorar a segurança do WordPress temos uma opção de alteração do diretório wp-uploads, para tal siga o procedimento abaixo:

*Crie a nova pasta de uploads:*

Acesse o servidor via FTP ou através do gerenciador de arquivos do painel de controle do seu provedor de hospedagem. Crie uma nova pasta onde deseja armazenar os arquivos de mídia, por exemplo, /public_html/novo-diretorio/uploads/. Lembre-se de ajustar as permissões da pasta para permitir o upload de arquivos pelo WordPress.

Edite o arquivo *wp-config.php*: Acesse a pasta raiz do seu site WordPress e encontre o arquivo *wp-config.php*. Abra-o para edição.

Adicione a constante no arquivo *wp-config.php*: Adicione a seguinte linha no arquivo *wp-config.php*, logo antes da linha que contém /* That's all, stop editing! Happy publishing. */:

    define('UPLOADS', 'novo-diretorio/uploads');

Substitua novo-diretorio/uploads pelo caminho relativo à nova pasta de uploads que você criou.

Salve as alterações: Salve o arquivo wp-config.php com a alteração feita.

Migre os arquivos existentes: Se você já possui arquivos de mídia no diretório de uploads padrão (/wp-content/uploads/), é necessário transferi-los para o novo diretório que você criou. Para fazer isso, basta copiar os arquivos e pastas da pasta /wp-content/uploads/ para a nova pasta de uploads que você definiu.

Verifique se tudo está funcionando: Após realizar a mudança, verifique se o site continua funcionando normalmente e se os arquivos de mídia estão sendo carregados corretamente.

Lembre-se de fazer um backup completo do seu site antes de realizar qualquer alteração em arquivos importantes, como o wp-config.php.

Com isto robôs que fazem varredura automatizada nestes diretórios deixarão de funcionar em seu site.