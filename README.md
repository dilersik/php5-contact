# php5-contact

Requisitos do servidor:
- Linux ou WampServer 3.0.6 em Windows;
- Apache + 2.4;
rewrite_module (habilitado); 
- PHP + 5.6;
shortopentag (habilitado); PHP PDO MySQL (habilitado);
- MySQL + 5.7;


Passo a passo:

1-	Extrair pasta para diretório root (www ou public_html); <br> <br>
2-	Criar banco de dados UTF-8 chamado “contactproject”;
*usuário do banco deve ter permissões de criar, editar, excluir tabelas; inserir, alterar e selecionar registros*; <br> <br>
3-	Abrir arquivo “includes/define.inc.php” e configurar as conexões com o banco de dados; <br><br>
4-	Acessar o seguinte comando (com domínio do servidor) para criar todas as tabelas no banco: http://localhost/contactproject/executeAllSQL&token=K1283-KLASP57-MCPQPOO-44KJSJKDA8-MCP554NASJ490 <br> <br>
5-	Acessar o sistema: http://localhost/contactproject/admin_loginVP  <br>
> Login: teste  <br>
> Senha: teste1 
