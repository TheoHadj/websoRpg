// Création de la connexion WebSocket sur le port 8080
const conn = new WebSocket('ws://localhost:8080');
const messagesDiv = document.getElementById('chat-messages');
const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');

const buttonAttaque = document.getElementById('attaque');
const buttonSuperAttaque = document.getElementById('SuperAttaque');
const buttonProvoke = document.getElementById('Taunt');
const buttonHeal = document.getElementById('Heal');
let msg;

buttonAttaque.addEventListener("click", function() {
    msg = '{"action" : "attaque"}';
    conn.send(msg);
    
    buttonAttaque.disabled=true;
    buttonSuperAttaque.disabled=true;
    buttonProvoke.disabled=true;
    buttonHeal.disabled=true;

  

})


buttonSuperAttaque.addEventListener("click", function() {
    msg = '{"action" : "SuperAttaque"}';
    conn.send(msg);

    buttonAttaque.disabled=true;
    buttonSuperAttaque.disabled=true;
    buttonProvoke.disabled=true;
    buttonHeal.disabled=true;


  
  })

buttonProvoke.addEventListener("click", function() {
    msg = '{"action" : "Provoquer"}';
    conn.send(msg);

    buttonAttaque.disabled=true;
    buttonSuperAttaque.disabled=true;
    buttonProvoke.disabled=true;
    buttonHeal.disabled=true;



})

buttonHeal.addEventListener("click", function() {
    msg = '{"action" : "Heal"}';
    conn.send(msg);

    buttonAttaque.disabled=true;
    buttonSuperAttaque.disabled=true;
    buttonProvoke.disabled=true;
    buttonHeal.disabled=true;



})

buttonAttaque.disabled=true;
buttonSuperAttaque.disabled=true;
buttonProvoke.disabled=true;
buttonHeal.disabled=true;




// Actions à effectuer lorsque la connexion est établie
conn.onopen = function(e) {
    console.log("Connexion établie!");
};

// Actions à effectuer lorsqu'un message est reçu
conn.onmessage = function(e) {
    if(e.data == "your turn"){
        buttonAttaque.disabled=false;
        buttonSuperAttaque.disabled=false;
        buttonProvoke.disabled=false;
        buttonHeal.disabled=false;
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
