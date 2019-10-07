<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MadeiraMadeira</title>
    <link rel="stylesheet" type="text/css" href="./App/assests/css/index.css">

    <!-- vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!-- Materialize Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Moment JS -->
    <script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>

</head>

<body>
    <div id="root">
        <menu-aplicacao></menu-aplicacao>

        <table class="striped centered responsive-table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Cliente</th>
                    <th>Motivo</th>
                    <th>Data de Abertura</th>
                    <th>Data de Fechamento</th>
                    <th>Status</th>
                    <th>#</th>
                    <th>#</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(ticket, index) in tickets">
                    <td>{{ticket.description}}</td>
                    <td>{{ticket.client.name}}</td>
                    <td>{{ticket.reason.name}}</td>
                    <td>{{ticket.dateOpen | date}}</td>
                    <td>{{ticket.dateClosed | date}}</td>
                    <td>
                        <span v-if="ticket.status == 1" class="new badge blue" data-badge-caption="">Resolvido</span>
                        <span v-else class="new badge red" data-badge-caption="">Não-Resolvido</span>
                    </td>
                    <td @click="edit(ticket)"><i class="material-icons clickable">create</i></td>
                    <td @click="areyousure(ticket.id)"><i class="material-icons clickable">delete</i></td>
                </tr>
            </tbody>
        </table>

        <div id="abrirChamado" class="modal">
            <div class="modal-content">
                <h4>Abertura de chamados</h4>
                <hr />
                <div class="center-text">
                    <p v-if="errors.length">
                        <b>Por favor, corrija o(s) seguinte(s) erro(s):</b>
                        <div class="row center-text" v-for="error in errors">
                            <span>
                                <div class="row mg-bottom">
                                    {{ error.message }} 
                                </div>
                            </span>
                        </div>
                    </p>
                </div>
                <p>
                    <div class="row">
                        <div class="input-field col s6">
                            <select class="browser-default" name="client" v-model="ticket.client" required>
                                <option value="" selected disabled>Selecione o cliente</option>
                                <option v-for="client in clients" :value="client.id">
                                    {{ client.name }}
                                </option>
                            </select>
                        </div>
                        <div class="input-field col s6">
                            <select class="browser-default" name="client" v-model="ticket.reason" required>
                                <option value="" selected disabled>Selecione o Motivo</option>
                                <option v-for="reason in reasons" :value="reason.id">
                                    {{ reason.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </p>
                <p>
                    <div class="row">
                        <div class="input-field col s6">
                            <textarea id="textarea1" class="materialize-textarea" data-length="120" v-model="ticket.description" required ></textarea>
                            <label for="textarea1">Informe o motivo do chamado</label>
                        </div>
                        <div class="input-field col s6">
                            <div class="switch">
                                <label>
                                    Não Resolvido
                                    <input type="checkbox" v-model="ticket.status">
                                    <span class="lever"></span>
                                    Resolvido
                                </label>
                            </div>
                        </div>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-green btn" @click="enviarTicket()">Salvar</a>
                <a class="modal-close waves-effect waves-green btn fechar">Fechar</a>

            </div>
        </div>
        <div id="editarChamado" class="modal">
            <div class="modal-content">
                <h4>Editar Chamado</h4>
                <hr />
                <div class="center-text">
                    <p v-if="errors.length">
                        <b>Por favor, corrija o(s) seguinte(s) erro(s):</b>
                        <div class="row center-text" v-for="error in errors">
                            <span>
                                <div class="row mg-bottom">
                                    {{ error.message }} 
                                </div>
                            </span>
                        </div>
                    </p>
                </div>
                <p>
                    <div class="row">
                        <div class="input-field col s6">
                            <select class="browser-default" name="client" v-model="editedTicket.client.id" required>
                                <option value="" selected disabled>Selecione o cliente</option>
                                <option v-for="client in clients" :value="client.id">
                                    {{ client.name }}
                                </option>
                            </select>
                        </div>
                        <div class="input-field col s6">
                            <select class="browser-default" name="client" v-model="editedTicket.reason.id" required>
                                <option value="" selected disabled>Selecione o Motivo</option>
                                <option v-for="reason in reasons" :value="reason.id">
                                    {{ reason.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </p>
                <p>
                    <div class="row">
                        <div class="input-field col s6">
                            <textarea id="textarea1" class="materialize-textarea" data-length="120" v-model="editedTicket.description" required placeholder="Informe um motivo"></textarea>
                        </div>
                        <div class="input-field col s6">
                            <div class="switch">
                                <label>
                                    Não Resolvido
                                    <input type="checkbox" v-model="editedTicket.status">
                                    <span class="lever"></span>
                                    Resolvido
                                </label>
                            </div>
                        </div>
                    </div>
                </p>
                <p>
                    <div class="row">
                        <div class="input-field col s6">
                             <input type="text" class="datepicker" id="dateOpen" v-model="editedTicket.dateOpen" placeholder="Data Abertura">
                        </div>
                        <div class="input-field col s6">
                              <input type="text" class="datepicker" id="dateClosed" v-model="editedTicket.dateClosed" :value="editedTicket.dateClosed" placeholder="Data Fechamento">
                        </div>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-green btn" @click="updateTicket()">Atualizar</a>
                <a class="modal-close waves-effect waves-green btn fechar">Fechar</a>

            </div>
        </div>
        <div id="removerChamado" class="modal">
            <div class="modal-content center-text">
                <h6>Você tem certeza que deseja excluir este chamado?</h6>
            <div class="modal-footer center-text">
                <a class="waves-effect waves-green btn" @click="removeTicket()">Excluir</a>
                <a class="modal-close waves-effect waves-green btn fechar">Fechar</a>
            </div>
        </div>
    </div>
</body>
<script>
</script>

</html>
<script src="./App/assests/js/index.js" ></script>