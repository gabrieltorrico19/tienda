<?php
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/tienda/tienda-admin';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/main.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="<?php echo $baseUrl; ?>/control/admin/c-admin-panel.php" class="sidebar-brand">
                    <span>🌿</span> Tienda Admin
                </a>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">Principal</div>
                <a href="<?php echo $baseUrl; ?>/control/admin/c-admin-panel.php" class="nav-item">
                    <span class="nav-icon">📊</span> Dashboard
                </a>
                <div class="nav-section">Gestión</div>
                <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-list.php" class="nav-item">
                    <span class="nav-icon">📦</span> Productos
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Categoria/c-categoria-list.php" class="nav-item">
                    <span class="nav-icon">🏷️</span> Categorías
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-list.php" class="nav-item">
                    <span class="nav-icon">🏅</span> Marcas
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Industria/c-industria-list.php" class="nav-item">
                    <span class="nav-icon">🏭</span> Industrias
                </a>
                <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-list.php" class="nav-item">
                    <span class="nav-icon">💳</span> Formas de Pago
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-list.php" class="nav-item">
                    <span class="nav-icon">🏪</span> Sucursales
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-list.php" class="nav-item">
                    <span class="nav-icon">📋</span> Inventario
                </a>
                <div class="nav-section">Comunicación</div>
                <a href="<?php echo $baseUrl; ?>/control/chat/c-chat-panel.php" class="nav-item active">
                    <span class="nav-icon">💬</span> Chat
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="<?php echo $baseUrl; ?>/control/auth/c-login.php" class="logout-btn">
                    <span class="nav-icon">🚪</span> Cerrar Sesión
                </a>
            </div>
        </aside>
        
        <main class="main-content">
            <div class="page-header">
                <div class="page-title">
                    <div class="page-title-icon">💬</div>
                    Chat
                </div>
            </div>
            
            <div class="chat-layout">
                <div class="chat-conversations-list">
                    <div class="chat-list-header">Conversaciones</div>
                    <div id="chat-conversation-list" class="chat-list-body">
                        <div class="empty-state-icon">Cargando...</div>
                    </div>
                </div>
                
                <div class="chat-messages-area">
                    <div id="chat-admin-welcome" class="chat-empty">
                        <p>Selecciona una conversación para comenzar</p>
                    </div>
                    
                    <div id="chat-admin-content" class="chat-messages-area" style="display: none; flex: 1;">
                        <div class="chat-header">
                            <span id="chat-current-cliente" class="chat-header-title">Cliente: -</span>
                            <button onclick="closeCurrentChat()" class="chat-close-btn">Cerrar Chat</button>
                        </div>
                        
                        <div id="chat-admin-messages" class="chat-messages"></div>
                        
                        <div class="chat-input-area">
                            <input type="text" id="chat-admin-input" class="chat-input" placeholder="Escribe tu respuesta..." onkeypress="handleAdminChatKeyPress(event)">
                            <button onclick="sendAdminMessage()" class="chat-send-btn">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<script>
var adminUsuario = '<?php echo $adminUsuario ?? "admin"; ?>';
var adminBaseUrl = '<?php echo $baseUrl; ?>';
var currentConversacionId = 0;
var lastMessageId = 0;
var chatPollInterval = null;

function loadConversations() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', adminBaseUrl + '/control/chat/c-chat-api.php?action=list&admin=' + encodeURIComponent(adminUsuario), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var resp = JSON.parse(xhr.responseText);
            renderConversations(resp.conversaciones || []);
        }
    };
    xhr.send();
}

function renderConversations(conversaciones) {
    var container = document.getElementById('chat-conversation-list');
    if (conversaciones.length === 0) {
        container.innerHTML = '<div class="empty-state-text">No hay conversaciones</div>';
        return;
    }
    
    container.innerHTML = '';
    conversaciones.forEach(function(conv) {
        var div = document.createElement('div');
        div.className = 'conv-item' + (conv.id === currentConversacionId ? ' active' : '');
        div.onclick = function() { selectConversation(conv.id, conv.cliente_ci); };
        
        var badge = conv.mensajes_sin_leer > 0 ? '<span class="conv-badge">' + conv.mensajes_sin_leer + '</span>' : '';
        var time = conv.fechaInicio ? new Date(conv.fechaInicio).toLocaleDateString('es-BO') : '';
        
        div.innerHTML = '<div class="conv-item-header"><span class="conv-cliente">'+conv.cliente_ci+'</span>'+badge+'</div>' +
                      '<div class="conv-preview">'+(conv.ultimo_mensaje || 'Sin mensajes')+'</div>' +
                      '<div class="conv-time">'+time+'</div>';
        container.appendChild(div);
    });
}

function selectConversation(convId, clienteCi) {
    currentConversacionId = convId;
    lastMessageId = 0;
    document.getElementById('chat-admin-messages').innerHTML = '';
    
    document.getElementById('chat-current-cliente').textContent = 'Cliente: ' + clienteCi;
    document.getElementById('chat-admin-welcome').style.display = 'none';
    document.getElementById('chat-admin-content').style.display = 'flex';
    
    loadConversations();
    loadAdminMessages();
    
    if (!chatPollInterval) {
        chatPollInterval = setInterval(loadAdminMessages, 3000);
    }
}

function loadAdminMessages() {
    if (!currentConversacionId) return;
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', adminBaseUrl + '/control/chat/c-chat-api.php?action=messages&conversacion_id=' + currentConversacionId, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var resp = JSON.parse(xhr.responseText);
            renderAdminMessages(resp.mensajes || []);
            markAdminAsRead();
            loadConversations();
        }
    };
    xhr.send();
}

function renderAdminMessages(mensajes) {
    var container = document.getElementById('chat-admin-messages');
    if (!mensajes || mensajes.length === 0) {
        if (lastMessageId === 0) {
            container.innerHTML = '<div class="empty-state-text">No hay mensajes</div>';
        }
        return;
    }
    if (lastMessageId === 0) {
        container.innerHTML = '';
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

function sendAdminMessage() {
    var input = document.getElementById('chat-admin-input');
    var contenido = input.value.trim();
    
    if (!contenido || !currentConversacionId) return;
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', adminBaseUrl + '/control/chat/c-chat-api.php?action=send', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            input.value = '';
            loadAdminMessages();
        }
    };
    xhr.send('conversacion_id=' + currentConversacionId + '&remitente=' + encodeURIComponent(adminUsuario) + 
             '&contenido=' + encodeURIComponent(contenido));
}

function markAdminAsRead() {
    if (!currentConversacionId) return;
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', adminBaseUrl + '/control/chat/c-chat-api.php?action=mark&conversacion_id=' + currentConversacionId + '&remitente=' + encodeURIComponent(adminUsuario), true);
    xhr.send();
}

function handleAdminChatKeyPress(e) {
    if (e.key === 'Enter') {
        sendAdminMessage();
    }
}

function closeCurrentChat() {
    if (!currentConversacionId) return;
    
    if (!confirm('¿Cerrar esta conversación?')) return;
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', adminBaseUrl + '/control/chat/c-chat-api.php?action=close', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            currentConversacionId = 0;
            lastMessageId = 0;
            document.getElementById('chat-admin-welcome').style.display = 'flex';
            document.getElementById('chat-admin-content').style.display = 'none';
            if (chatPollInterval) {
                clearInterval(chatPollInterval);
                chatPollInterval = null;
            }
            loadConversations();
        }
    };
    xhr.send('conversacion_id=' + currentConversacionId);
}

loadConversations();
setInterval(loadConversations, 5000);
</script>
</body>
</html>