// Création de la connexion WebSocket sur le port 8080
const conn = new WebSocket('ws://localhost:8080');
const messagesDiv = document.getElementById('chat-messages');
const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');

const buttonAttaque = document.getElementById('attaque');
const buttonSuperAttaque = document.getElementById('SuperAttaque');
let msg;

buttonAttaque.addEventListener("click", function() {
    msg = '{"action" : "attaque"}';
    console.log("a");
    conn.send(msg);
    
    buttonAttaque.disabled=true;
    buttonSuperAttaque.disabled=true;
  

})


buttonSuperAttaque.addEventListener("click", function() {
    msg = '{"action" : "SuperAttaque"}';
    console.log("b");    
    conn.send(msg);

    buttonAttaque.disabled=true;
    buttonSuperAttaque.disabled=true;
  
  })

  buttonAttaque.disabled=true;
  buttonSuperAttaque.disabled=true;


// Actions à effectuer lorsque la connexion est établie
conn.onopen = function(e) {
    console.log("Connexion établie!");
};

// Actions à effectuer lorsqu'un message est reçu
conn.onmessage = function(e) {
    if(e.data == "your turn"){
        buttonAttaque.disabled=false;
        buttonSuperAttaque.disabled=false;
        console.log(e.data);
      
    }
    else{

        const message = document.createElement('div');
        message.textContent = e.data;
        message.className = 'message received';
        messagesDiv.appendChild(message);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
};

// Actions à effectuer lorsqu'une erreur survient
conn.onerror = function(e) {
    console.error("Erreur de connexion WebSocket : ", e);
};

// // Actions à effectuer le message est envoyé
// messageForm.onsubmit = function(e) {
//     e.preventDefault();
    
    
//     msg ='{"action" : "attaque"}';
    
//     conn.send(msg);

// };
