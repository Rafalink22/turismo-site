# 🚐 É de Maceió - Sistema de Turismo e Receptivo

Sistema web desenvolvido para gestão de agência de turismo, permitindo o cadastro de passeios, exibição de catálogo, otimização para SEO e integração com WhatsApp para vendas.

## 🚀 Tecnologias Utilizadas

- **Linguagem:** PHP 8+ (Estrutura MVC Personalizada)
- **Banco de Dados:** MySQL (PDO com Prepared Statements)
- **Frontend:** HTML5, CSS3, Bootstrap 5
- **Javascript:** Vanilla JS + TinyMCE (Editor de Texto)
- **Design Pattern:** MVC (Model-View-Controller)

## ✨ Funcionalidades

### 🔐 Painel Administrativo
- **Dashboard:** Visão geral com estatísticas de passeios ativos/inativos.
- **CRUD de Passeios:** Criar, Ler, Atualizar e Deletar passeios turísticos.
- **Editor Rico:** Uso do TinyMCE para descrições detalhadas com formatação HTML.
- **Gestão de Galeria:** Upload múltiplo de fotos para cada passeio.
- **Configurações Gerais:** Gerenciamento de telefone, redes sociais e SEO via painel.

### 🌍 Área Pública (Cliente)
- **Catálogo:** Listagem de passeios com paginação e cards interativos.
- **Busca:** Sistema de pesquisa interna por título ou descrição.
- **Página de Detalhes:** Carrossel de fotos, informações completas e botão flutuante de compra.
- **SEO & Share:** Otimização com Open Graph para cards bonitos no WhatsApp/Facebook.
- **URLs Amigáveis:** Uso de `.htaccess` para limpeza de URLs.

## 🛠️ Como rodar o projeto

1. Clone o repositório.
2. Importe o arquivo `database.sql` (se houver) ou crie o banco `turismo_db`.
3. Renomeie `config/database.example.php` para `config/database.php` e configure suas credenciais.
4. Inicie o servidor Apache (XAMPP/WAMP) apontando para a pasta do projeto.

---
Desenvolvido por **Bruno Rafael** - Estudante de Ciência da Computação.