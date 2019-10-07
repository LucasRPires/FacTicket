
Vue.component('menuAplicacao', {
    template: `
        <nav id="header">
            <div class="nav-wrapper">
                <a class="brand-logo">
                    Abertura de chamados
                </a>
                <a class="waves-effect waves-light btn modal-trigger btn-success center" style="float:right;margin-right:15px;margin-top:15px" data-target="abrirChamado">Novo Chamado</a>
            </div>
        </nav>
    `
});

let root = new Vue({
    el: "#root",
    component: [
        'menuAplicacao'
    ],
    data() {
        return {
            clients: [],
            reasons: [],
            tickets: [],
            errors: [],
            ticketId: 0,
            ticket: {
                client: '',
                reason: '',
                description: '',
                status: false
            },
            editedTicket: {
                id: '',
                client: {},
                reason: {},
                description: '',
                dateOpen: '',
                dateClosed: '',
                status: false
            },
            modalTicket: ''
        }
    },
    mounted: function () {
        var modalEl = document.querySelectorAll('.modal');
        var modalInstance = M.Modal.init(modalEl, {});

        var selectEl = document.querySelectorAll('select');
        this.modalTicket = M.FormSelect.init(selectEl, {});

        var pickerEl = document.querySelectorAll('.datepicker');
        var pickerInstance = M.Datepicker.init(pickerEl, {});

        $.get('./App/Controllers/GetClientController.php', (data) => {
            this.clients = JSON.parse(data);
        });

        $.get('./App/Controllers/GetReasonController.php', (data) => {
            this.reasons = JSON.parse(data);
        });

        $.get('./App/Controllers/GetTicketController.php', (data) => {
            this.tickets = JSON.parse(data);
        });
    },
    methods: {
        enviarTicket() {
            this.errors = [];
            this.validarFormulario();
            if (this.errors.length <= 0) {
                this.postTicket();
            }
        },
        getTickets() {
            $.get('./App/Controllers/GetTicketController.php', (data) => {
                this.tickets = JSON.parse(data);
            });
        },
        validarFormulario() {
            if (this.ticket.client == 0 || this.ticket.client == '')
                this.errors.push({ message: 'Por favor, selecione um cliente.' })

            if (this.ticket.reason == 0 || this.ticket.reason == '')
                this.errors.push({ message: 'Por favor, selecione um motivo.' })

            if (this.ticket.description == '')
                this.errors.push({ message: 'Por favor, informe um descritivo do ticket.' })
        },
        postTicket() {
            $.post("./App/Controllers/AddTicketController.php", { ticket: this.ticket }, (data) => {
                if (JSON.parse(data)) {
                    M.toast({ html: 'Ticket cadastrado com sucesso' });
                    M.Modal.getInstance(document.getElementById('abrirChamado')).close();
                }
                this.getTickets();
                this.resetForm();
            }).fail(function (data) {
                M.toast({ html: data });
            });

        },
        updateTicket() {
            this.editedTicket.dateOpen = moment(document.getElementById('dateOpen').value).format('YYYY-MM-DD h:mm:s');
            this.editedTicket.dateClosed = document.getElementById('dateClosed').value == '' ? null : moment(document.getElementById('dateClosed').value).format('YYYY-MM-DD h:mm:s');

            $.ajax({
                url: './App/Controllers/UpdateTicketController.php',
                type: 'PUT',
                data: { ticket: this.editedTicket },
                success: (data) => {
                    if (JSON.parse(data)) {
                        M.toast({ html: 'Ticket atualizado com sucesso' });
                        M.Modal.getInstance(document.getElementById('editarChamado')).close();
                    }
                    this.getTickets();
                    this.resetForm();
                },
                error: (data) => {
                    M.toast({ html: JSON.parse(data) });
                }
            });

        },
        resetForm() {
            this.ticket.client = '';
            this.ticket.reason = '';
            this.ticket.description = '';
            this.editedTicket.id = '';
            this.editedTicket.client = '';
            this.editedTicket.reason = '';
            this.editedTicket.description = '';
            this.editedTicket.dateOpen = '';
            this.editedTicket.dateClosed = '';
            this.editedTicket.status = '';
        },
        edit(ticket) {
            this.editedTicket.id = ticket.id;
            this.editedTicket.client = ticket.client;
            this.editedTicket.reason = ticket.reason;
            this.editedTicket.description = ticket.description;
            this.editedTicket.dateOpen = ticket.dateOpen;
            this.editedTicket.dateClosed = ticket.dateClosed;
            this.editedTicket.status = ticket.status;
            M.Modal.getInstance(document.getElementById('editarChamado')).open();
        },
        removeTicket() {
            $.ajax({
                url: `./App/Controllers/DeleteTicketController.php?ticketId=${this.ticketId}`,
                type: 'DELETE',
                success: (data) => {
                    if (JSON.parse(data)) {
                        M.toast({ html: 'Ticket excluido com sucesso.' });
                        M.Modal.getInstance(document.getElementById('removerChamado')).close();
                    }
                    this.getTickets();
                },
                error: (data) => {
                    M.toast({ html: JSON.parse(data) });
                }
            });
        },
        areyousure(id) {
            this.ticketId = id;
            M.Modal.getInstance(document.getElementById('removerChamado')).open();
        }
    },
    filters: {
        date: (date) => {
            return date == null ? '#' : moment(date).format('DD/MM/YYYY h:mm:s');
        }
    }
});
