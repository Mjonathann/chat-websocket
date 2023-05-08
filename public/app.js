var messages = [];

var conn = new WebSocket('ws://localhost:8085');

conn.onopen = function(e) {
    console.log('Conectado al socket: ', conn);
}

conn.onerror = function(e) {
    console.log('Error: No se pudo conectar al servidor');
}

conn.onclose = function(e) {
    console.log('Conecion cerrada');
}

conn.onmessage = function(e){
    let message = JSON.parse(e.data);
    console.log('mensaje', message);

    let li = '<li>' + message.text + '</li>';
    $('#message-list').prepend(li);
}

sendMsg = () => {
    
    let inputMsg = document.getElementById('msg');

    let message = {
        type: 'message',
        text: inputMsg.value
    }

    conn.send(JSON.stringify(message));
    inputMsg.value = '';
}


document.addEventListener('DOMContentLoaded', function () {
    let formMsg = document.getElementById('message_form');

    formMsg.addEventListener('submit', function(event){
        event.preventDefault();
         sendMsg()
    });

  }, false);

