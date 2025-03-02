# Sistema de Gestão Hospitalar e de Serviços de Saúde (SGHSS)

Este projeto é um sistema de gestão hospitalar desenvolvido em PHP, seguindo o modelo MVC (Model-View-Controller). Ele foi criado para gerenciar hospitais, clínicas, laboratórios e equipes de home care, com funcionalidades como cadastro de pacientes, gestão de profissionais de saúde, administração hospitalar, telemedicina e conformidade com a LGPD.

## Tecnologias Utilizadas

- PHP (sem uso de frameworks)
- JWT para autenticação
- MySQL para banco de dados
- Composer para gerenciar dependências
- Apache (recomendado usar o XAMPP para facilitar o setup)

## Pré-requisitos

Antes de começar, certifique-se de ter os seguintes requisitos instalados:

1. **Composer**: O Composer é uma ferramenta de dependências para PHP. Para instalá-lo, siga os passos abaixo:

   - Baixe o Composer [aqui](https://getcomposer.org/download/).
   - Após o download, execute o comando para verificar se o Composer foi instalado corretamente:
     ```bash
     composer --version
     ```

2. **Servidor Web**: O projeto pode ser rodado em Apache, Nginx ou outro servidor compatível. Para facilitar, recomendamos usar o **XAMPP**, que já inclui o Apache e o MySQL:

   - Baixe o XAMPP [aqui](https://www.apachefriends.org/index.html).
   - Após a instalação, inicie os serviços do Apache e MySQL.

## Configuração do Projeto

### Instalação das Dependências

Clone este repositório no seu ambiente local:

```bash
git clone https://github.com/EduardoReolon/gestao_hospitalar.git
cd gestao_hospitalar
```

#### Instale as dependências usando o Composer
composer install

### Arquivo de Configuração

Crie um arquivo chamado config.php na raiz do projeto com base no arquivo config.php.model que se encontra no repositório. Esse arquivo contém as configurações do banco de dados e outras configurações do sistema.

### Banco de Dados

O projeto utiliza MySQL para armazenar dados. Na raiz do repositório, você encontrará o arquivo script-mysql.sql. Execute este script no seu banco de dados para criar a estrutura necessária

### Configuração do .htaccess

O arquivo .htaccess está incluído no projeto para permitir o roteamento adequado de URLs e garantir a segurança das rotas. Se você estiver usando Apache, certifique-se de que o módulo mod_rewrite está ativado. Para habilitar o mod_rewrite, edite o arquivo de configuração do Apache (httpd.conf) e descomente a linha:

```bash
LoadModule rewrite_module modules/mod_rewrite.so
```

Se você estiver usando Nginx ou outro servidor, configure o arquivo de configuração para permitir o roteamento adequado de URLs conforme a necessidade.

## Primeira Execução

1. Após configurar o banco de dados e o ambiente, inicie o servidor web (Apache ou outro).

2. Acesse a aplicação pela URL configurada no seu servidor (por exemplo, `http://localhost`).

3. A primeira vez que acessar o sistema, utilize o usuário e senha abaixo para fazer login:
   - **Usuário**: admin@admin.com
   - **Senha**: 123456

   Esse usuário será criado automaticamente na primeira execução, facilitando o teste.

## Como Testar

1. Após fazer login, você pode acessar as funcionalidades do sistema, como cadastro de pacientes, profissionais de saúde, e muito mais.

2. Todas as páginas incluem, ao final, um conjunto de testes pré-configurados para facilitar a identificação de erros. Para visualizar as mensagens de erro, basta clicar em "Salvar" em cada linha de teste.

# Estrutura de Pastas

A estrutura de pastas do projeto segue o padrão MVC, com subpastas de configuração e classes base.

# Logs

Os logs são registradas em arquivos .txt dentro da pasta logs. Todas as requisições, erros e alterações são armazenados em subpastas para facilitar a organização.