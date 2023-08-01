---
layout: post
title:  WordPress wp-config.php top level
categories: [WordPress,Code]
excerpt: Aprenda a deixar seu WordPress mais seguro movendo o arquivo wp-config.php um level acima.
---

Uma forma de melhorarmos a segurança do WordPress é movermos o arquivo wp-config.php um level acima do seu diretorio atual.

Para isto execute o procedimento abaixo:

Acesse o seu servidor via FTP ou através do gerenciador de arquivos do painel de controle do seu provedor de hospedagem.

Navegue até a pasta raiz do seu site WordPress, onde estão localizados os diretórios wp-admin, wp-includes, e os arquivos como wp-login.php.

Localize o arquivo wp-config.php.

Crie uma nova pasta um nível acima da pasta raiz do WordPress. Por exemplo, se a pasta raiz do WordPress estiver em /public_html/, você pode criar uma pasta chamada /config/ nesse mesmo nível.

Mova o arquivo wp-config.php para a nova pasta /config/.

Após mover o arquivo, verifique se o site ainda está funcionando corretamente. Você pode encontrar um erro neste momento, pois o WordPress não conseguirá localizar o arquivo de configuração na sua localização original.

Abra o arquivo index.php, que está na pasta raiz do WordPress, para editar.

Localize a linha que define o caminho do arquivo wp-config.php. Essa linha normalmente se parece com esta:

    require_once( dirname( __FILE__ ) . '/wp-config.php' );

Modifique essa linha para apontar para a nova localização do arquivo wp-config.php. Por exemplo, se você criou a pasta /config/, a linha deve ser alterada para algo assim:

    require_once( dirname( __FILE__ ) . '/config/wp-config.php' );

Salve as alterações no arquivo index.php.

Verifique novamente se o site está funcionando normalmente. Se tudo estiver correto, o WordPress agora usará o arquivo wp-config.php na nova localização.

Por fim, verifique se o site ainda está funcionando corretamente e se não há erros. Teste a funcionalidade do WordPress para garantir que tudo esteja em ordem.
