<link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/chat-widget.css">

<div id="chat-widget" class="chat-widget-collapsed">
    <button id="chat-toggle" class="chat-toggle-btn" onclick="toggleChat()">
        💬
    </button>
    
    <div id="chat-window" class="chat-window">
        <div class="chat-header">
            <span>Chat con Administración</span>
            <button onclick="toggleChat()" class="chat-close">&times;</button>
        </div>
        
        <div id="chat-messages" class="chat-messages"></div>
        
        <div class="chat-input-area">
            <input type="text" id="chat-input" placeholder="Escribe tu mensaje..." 
                   onkeypress="handleChatKeyPress(event)">
            <button onclick="sendChatMessage()" class="chat-send-btn">Enviar</button>
        </div>
    </div>
</div>

<script>
var chatConversacionId = 0;
var chatClienteCi = '<?php echo $clienteCi ?? ""; ?>';
var chatRemitente = chatClienteCi;
var lastMessageId = 0;
var chatPollInterval = null;
var chatBaseUrl = '<?php echo $baseUrl; ?>';

function toggleChat() {
    var widget = document.getElementById('chat-widget');
    if (widget.classList.contains('chat-widget-collapsed')) {
        widget.classList.remove('chat-widget-collapsed');
        widget.classList.add('chat-widget-expanded');
        if (!chatConversacionId) {
            initChat();
        } else {
            startPolling();
        }
    } else {
        widget.classList.remove('chat-widget-expanded');
        widget.classList.add('chat-widget-collapsed');
        stopPolling();
    }
}

function initChat() {
    if (!chatClienteCi) {
        showChatError('Inicia sesión para usar el chat');
        return;
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', chatBaseUrl + '/control/chat/c-chat-api.php?action=init', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var resp = JSON.parse(xhr.responseText);
            if (resp.success) {
                chatConversacionId = resp.conversacion_id;
                loadMessages();
                startPolling();
            }
        }
    };
    xhr.send('cliente_ci=' + encodeURIComponent(chatClienteCi) + '&admin=admin');
}

function sendChatMessage() {
    var input = document.getElementById('chat-input');
    var contenido = input.value.trim();
    
    if (!contenido || !chatConversacionId) return;
    
    var xhr = new XMLHttpRequest();
            xhr.open('POST', chatBaseUrl + '/control/chat/c-chat-api.php?action=send', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            input.value = '';
            loadMessages();
        }
    };
    xhr.send('conversacion_id=' + chatConversacionId + '&remitente=' + encodeURIComponent(chatRemitente) + 
             '&tipo=cliente&contenido=' + encodeURIComponent(contenido));
}

function loadMessages() {
    if (!chatConversacionId) return;
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', chatBaseUrl + '/control/chat/c-chat-api.php?action=poll&conversacion_id=' + chatConversacionId + '&desde_id=' + lastMessageId, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var resp = JSON.parse(xhr.responseText);
            if (resp.mensajes && resp.mensajes.length > 0) {
                renderMessages(resp.mensajes);
            }
            markAsRead();
        }
    };
    xhr.send();
}

function renderMessages(mensajes) {
    var container = document.getElementById('chat-messages');
    if (lastMessageId === 0) {
        container.innerHTML = '';
    }
    if (!mensajes || mensajes.length === 0) {
        container.innerHTML = '<div class="chat-no-conv">No hay mensajes</div>';
        return;
    }
    mensajes.forEach(function(msg) {
        if (msg.id > lastMessageId) {
            lastMessageId = msg.id;
            var div = document.createElement('div');
            div.className = 'chat-message ' + msg.tipo;
            var time = new Date(msg.fechaHora).toLocaleTimeString('es-BO', {hour: '2-digit', minute: '2-digit'});
            div.innerHTML = msg.contenido + '<span class="msg-time">' + time + '</span>';
            container.appendChild(div);
        }
    });
    container.scrollTop = container.scrollHeight;
}

function markAsRead() {
    if (!chatConversacionId || !chatRemitente) return;
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', chatBaseUrl + '/control/chat/c-chat-api.php?action=check&conversacion_id=' + chatConversacionId + '&remitente=' + encodeURIComponent(chatRemitente), true);
    xhr.send();
}

function handleChatKeyPress(e) {
    if (e.key === 'Enter') {
        sendChatMessage();
    }
}

function startPolling() {
    if (chatPollInterval) return;
    chatPollInterval = setInterval(loadMessages, 3000);
}

function stopPolling() {
    if (chatPollInterval) {
        clearInterval(chatPollInterval);
        chatPollInterval = null;
    }
}

function showChatError(msg) {
    var container = document.getElementById('chat-messages');
    container.innerHTML = '<div class="chat-no-conv">' + msg + '</div>';
}
</script>
