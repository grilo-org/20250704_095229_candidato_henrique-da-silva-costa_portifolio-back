# Projeto barbearias BACK-END

## DESCRIÇÃO

Esse projeto é um sistema voltado para barbearias.

Nesse sistema você pode criar um usuário master (barbeiro) e assim você consegue cadastrar barbearias e administrá-las como, por exemplo, modificar, excluir e adicionar serviços e horários a suas barbearias cadastradas pelo seu usuário.

E você também pode criar um usuário comum(cliente) que pode fazer a reserva nas barbearias disponíveis, que são as que tem horários e serviços cadastrados.

Nesse sistema na parte de fazer a reserva tem uma integração de pagamento usando a API do PagSeguro, mas não está homologada, sendo assim faz o pagamento, mas não é pago realmente só é aprovado dentro do ambiente do PagSeguro que eu tenho acesso.

## Para iniciar projeto

Tenha o composer instalado em sua maquina.

Em seguida abra o projeto e rode no teminal (composer install).

Depois tem um arquivo .env.example, renomeie para .env.

Agora nesse arquivo .env você vai configurar o seu banco aqui onde mostra na imagem abaixo


![image](https://github.com/user-attachments/assets/c7df2030-0cdd-485e-9772-38a8220b21e8)

O banco para baixar está no arquivo SQL.sql

Após isso, rode (php artisan key:generate), (php artisan storage:link), (php artisan optimize) depois (php artisan serve)

Por fim, inicie o front-end -> https://github.com/henrique-da-silva-costa/portifolio-front
