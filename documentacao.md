# Estrutura

Foi usado o padrão MVC, mas aqui estão somente os Models, Controllers e Rotas.

A View(FRONT-END) esta separada em outro repositório.

Eu organizei nesse padrão, pois é mais fácil para entender e trabalhar.

# Importante

O recuperar a senha foi feito sem envio de email.

Ele só verifica se o email existe, ele existindo vai para a página onde você redefine a senha.

## Models

### Barbearia

* todos  ->Lista todas as barbearias trazendo (nome e id)
* todasDisponiveis ->Lista todas as barbiérias com horário e serviço cadastrado
* pegarReservasFeitas ->Lista todas as reservas de cada barbearia pelo parâmetro(barbearia_id)
* pegarBarbeariasPorId ->Retorna a barbearia pelo parâmetro(id)
* pegarBarbeariasPorFiltro ->Lista todas as barbiérias com horário e serviço cadastrado, filtrando por nome, cep, estado e cidade
* pegarBarbeariaPorUsuarioId ->Retorna a barbearia do usuário logado, no login de barbeiro
* cadastrar ->Cadastra uma barbearia
* exsiteBarbeariaComEssasCondicoes ->Verifica se existe Barbearia com as condições passadas
* exsiteBarbeariaVinculada ->Verifica se existe barbearia vinculada a serviço, horário ou reserva.
* editar ->Edita uma barbearia.
* excluir ->Exclui uma barbearia.

### Horário

* todosNormal  ->Lista todos os horários pelo parâmetro(barbearia_id)
* todos ->Lista todos os horários pelo parâmetro(barbearia_id) fazendo uma paginação.
* pegarPorId  ->Retorna o horário pelo parâmetro(id)
* cadastrar ->Cadastra um horário
* existe  ->Verifica se esse horário já existe pelo parâmetro(barbearia_id)
* editar ->Edita um horário parâmetro(id)

* excluir ->Exclui um horário parâmetro(id)


### Reservas
* todos ->Lista todas as reservas
* pegarPorId ->Retorna uma reserva pelo parâmetro(id)
* todosHorarios ->Lista todos os horários
* todosServicos ->Lista todos os serviços
* existeDataEHora ->Verifica se já existe data e hora passada por parâmetro
* cadastrar  ->Cadastra uma reserva
* editar ->Edita uma reserva parâmetro(id)

* excluir ->Exclui uma reserva parâmetro(id)


### Serviço
* todosNormal  ->Lista todos os serviços pelo parâmetro(barbearia_id)
* todos ->Lista todos os serviços pelo parâmetro(barbearia_id) mas fazendo paginação.
* pegarPorId ->Retorna o serviço pelo parâmetro(id)
* cadastrar ->Cadastra um serviço
* existe ->Verifica se o serviço existe
* exsiteServicoVinculado ->Verifica se existe serviço  na tabela reserva
* editar ->Edita um serviço pelo parâmetro(id)
* excluir ->Excluir um serviço parâmetro(id)


### Usuário
* pegarPorId     ->Retorna o usuário pelo parâmetro(id)
* cadastro ->cadastra um usuário
* existeUsuario ->Verifica se o usuário já existe
* existeUsuarioMaster ->Verifica se o usuário Master já existe
* existeEmail ->Verifica se o e-mail já existe
* existeSenha ->Verifica se a senha já existe.
* recuperarSenha ->Verifica se o email passa por parâmetro existe, caso exista, a senha será editada.

## Views - FRONT-END

Está separada no f -> https://github.com/henrique-da-silva-costa/portifolio-front

## Controllers

### BarbeariaController

* reservas ->Lista todas as reservas de cada barbearia pelo parâmetro(barbearia_id)
* todos ->Lista todas as barbearias trazendo (nome e id)
* pegarBarbeariasPorId ->Retorna a barbearia pelo parâmetro(id)
* pegarBarbeariasPorFiltro ->Lista todas as barbiérias com horário e serviço cadastrado, filtrando por nome, cep, estado e cidade
* pegarBarbeariaPorUsuarioId ->Retorna a barbearia do usuário logado, no login de barbeiro
* cadastrar ->Valida os campos(usuarios_id,nome,cep,logradouro,bairro,localidade,estado,numero,telefone), verifica se a barbearia já existe caso não exista, cadastra a barbearia.
* editar ->Valida os campos(usuarios_id,nome,cep,logradouro,bairro,localidade,estado,numero,telefone), verifica se a barbearia já existe caso não exista, edita a barbearia.
* excluir ->Verifica se existe a barbearia, caso ele não exista.
    ele é excluído.

### HorarioController
* horariosNormal ->Lista todos os horarios pelo parametro(barbearia_id)
* horários ->Lista todos os horarios pelo parametro(barbearia_id) fazendo uma paginação
* horário ->Retorna o horário pelo parâmetro(id)
* cadastrar ->Valida os campos(barbearia_id,horario), verifica se o horário já existe, caso não exista cadastra o horário.
* editar ->Valida os campos(barbearia_id,horario), verifica se o horário já existe, caso não existe, edita o horário.
* excluir ->Verifica se existe o horário, caso ele não exista é excluído.

### PagamentoController
* pagamentoCartao ->Valida as informações do catão, faz uma requisição para a API do PagSeguro, dando tudo certo faz o pagamento.
* pagamentoPix ->Gera um qrCode PIX caso ele seja escaneado da um erro pois não está homologado, mas ele funciona e aprece no painel de desenvolvimento do PagSeguro.  

### ReservasController
* todasReservas ->Lista todas as reservas
* reserva ->Retorna uma reserva pelo parâmetro(id)  
* todosHorarios ->Lista todos os horários
* todosServicos ->Lista todos os serviços
* existeReserva ->Verifica se a reserva já existe pela data e hora
* cadastrar ->Valida os campos(nome_reserva,data,hora,servico,usuarios_id,barbearia_id) e cadastra a reserva.
* editar ->Valida os campos(nome_reserva,data,hora,servico,usuarios_id,barbearia_id) e edita a reserva.
* excluir ->Verifca se existe a reserva, caso ela não exista
    ela é excluída.

### ServicoController
* servicosNormal ->Lista todos os serviços pelo parâmetro(barbearia_id).
* serviços ->Lista todos os serviços pelo parâmetro(barbearia_id) mas fazendo paginação.
* serviço ->Retorna o serviço pelo parâmetro(id).
* cadastrar ->Valida os campos(barbearia_id, nome, valor), verifica se o serviço existe, se existir não pode ser cadastrado, caso exista o serviço é cadastrado.
* editar ->Valida os campos(barbearia_id, nome, valor), verifica se o serviço existe, se existir não pode ser editado, caso exista o serviço é editado.
* excluir ->Verifica se existe o serviço, caso ele não exista, é excluído.

### UsuarioController
* pegarUsuario ->Retorna o usuário pelo parâmetro(id).
* cadastrar ->Valida o tipo de imagem, os campos(nome, email, senha) e cadastra o usuário
* login  ->Valida os campos(email,senha), verifica se existe o usuário, caso o usuário exista, faz o login.
* loginMaster ->Valida os campos(email,senha), verifica se existe o usuário, caso o usuário exista, faz o login.
* recuperarsenhaemail ->Valida o email e verifica se o email existe, se não existir retorna uma mensagem de erro
* recuperarsenha ->Valida os campos(senha, novasenha) verifica se eles são iguais, caso sejam a senha do usuário é alterada

## ROTAS

### LOGIN
get(usu ->UsuarioContr ->pegarUsuario
post(cadastrar/usu ->UsuarioContr ->cadastrar
post(l ->UsuarioContr ->login
post(loginma ->UsuarioContr ->loginMaster
post(recuperars ->UsuarioContr ->recuperarsenha
post(recuperarsenha/e ->UsuarioContr ->recuperarsenhaemail

### RESERVAS
get(/reservas/hora ->ReservasContr ->todosHorarios
get(/reservas/serv ->ReservasContr ->todosServicos
get(/rese ->ReservasContr ->todasReservas
get(/res ->ReservasContr ->reserva
post(/res ->ReservasContr ->cadastrar
put(/res ->ReservasContr ->editar
delete(/res ->ReservasContr ->excluir
post(/reserva/verif ->ReservasContr ->existeReserva

### PAGAMMENTO
get(/c ->PagamentoContr ->chevePuvblica
post(/pagamentoca ->PagamentoContr ->pagamentoCartao
get(/pagament ->PagamentoContr ->pagamentoPix

### BARBEARIA
get(/barbearia/rese ->BarbeariaCont ->reservas
get(/barbe ->BarbeariaCont ->pegarBarbeariasPorId
get(/barbea ->BarbeariaCont ->todos
get(/barbearias/fil ->BarbeariaCont ->pegarBarbeariasPorFiltro
get(/barbearias/usu ->BarbeariaCont ->pegarBarbeariaPorUsuarioId
post(/barbearia/cadas ->BarbeariaCont ->cadastrar
delete(/barbearia/exc ->BarbeariaCont ->excluir
put(/barbearia/ed ->BarbeariaCont ->editar

### HORÁRIO
get(/hor ->HorarioContr ->horario
get(/barbearia/horarios/no ->HorarioContr ->horariosNormal
get(/barbearia/hora ->HorarioContr ->horarios
post(/barbearia/cadastrar/hor ->HorarioContr ->cadastrar
put(/barbearia/horarios/ed ->HorarioContr ->editar
delete(/barbearia/horarios/exc ->HorarioContr ->excluir

### SERVIÇO
get(/ser ->ServicoContr ->servico
get(/barbearia/servicos/no ->ServicoContr ->servicosNormal
get(/barbearia/serv ->ServicoContr ->servicos
post(/barbearia/cadastrar/ser ->ServicoContr ->cadastrar
put(/barbearia/servicos/ed ->ServicoContr ->editar
delete(/barbearia/servicos/exc ->ServicoContr ->excluir
