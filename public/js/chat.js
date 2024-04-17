 
/*    const picker= new EmojiPicker({
    trigger:[
    {
    insertInto: [".message-content"],
    selector:"#emoji-picker-button"
    }
],
closeButton:true,
dragButton:true,
})
*/

    // Your web app's Firebase configuration
    // For Firebase JS SDK v7.20.0 and later, measurementId is optional
    const firebaseConfig = {
        apiKey: "AIzaSyDK4qMKQI6r_ccCliKLROS-GwPi0gxlCTE",
        authDomain: "symfonychatproject.firebaseapp.com",
        projectId: "symfonychatproject",
        storageBucket: "symfonychatproject.appspot.com",
        messagingSenderId: "733766792191",
        appId: "1:733766792191:web:1ee1ff64f409cbeebdadca",
        measurementId: "G-K06QPJ9069"
      };
    
      // Initialize Firebase
      const app = firebase.initializeApp(firebaseConfig);
      var firebaseref=firebase.database().ref('emails');
      // Référence à la base de données
      const database = firebase.database();
  
  
  
      const socket = new WebSocket('ws://localhost:3001');
      socket.addEventListener('open', function (event) {
          console.log('Connected to WebSocket server');
          console.log(event.data);
      });
          // Maintenant que la connexion est ouverte, écouter les événements de réception de messages
     
  
      
          
          socket.addEventListener('message', function (event) { 
              const message = JSON.parse(event.data);
              console.log('Received message from server:', message);
              
              // Récupérer le nom de l'utilisateur qui a envoyé le message
              $.ajax({
                  url: "{{ path('get_user_name', {'userId': app.user.id}) }}",
                  type: 'GET',
                  success: function(response) {
                      const userName = response.nom;
                      
                      // Mettre à jour l'interface utilisateur avec le nouveau message reçu
                      const messageList = document.querySelector('.message-list');
                      const messageItem = document.createElement('div');
                      messageItem.classList.add('message');
                      if (message.data.mine) {
                          messageItem.classList.add('sent');
                      }
                      
                      if (message.data.isImage) { // Vérifier si le message est une image
                          // Créer un élément img pour afficher l'image
                          const image = document.createElement('img');
                          image.src = message.data.contenu; // Le chemin de l'image est stocké dans contenu
                          image.alt = 'Image message';
                          messageItem.appendChild(image);
                      } else {
                          // Le message est du texte
                          messageItem.innerHTML = `
                              <div class="user-name">${userName}</div>
                              <div class="message-content">${message.data.contenu}</div>
                              <div class="message-date">${message.data.createdAt}</div>
                          `;
                      }
                      
                      messageList.appendChild(messageItem);
                  },
                  error: function(error) {
                      console.error("Erreur lors de la récupération du nom de l'utilisateur :", error);
                  }
              });
          });
          
          
  
  
      // Écouter les événements WebSocket
      socket.addEventListener('error', function (event) {
          console.error('WebSocket error:', event);
      });
  
  
  // Écouter l'événement de soumission du formulaire
  document.getElementById('message-form').addEventListener('submit', function(event) {
      event.preventDefault(); // Empêcher le rechargement de la page
  
      // Récupérer le contenu du message
      const messageContent = document.querySelector('textarea[name="message_content"]').value;
  
      // Vérifier s'il y a un fichier image sélectionné
      const imageFile = document.getElementById('image_upload').files[0];
      if (imageFile) {
          // Si un fichier image est sélectionné, l'envoyer en tant qu'image
          uploadImage(imageFile)
              .then(imageURL => {
                  // Une fois que l'image est téléchargée avec succès, envoyer le message avec l'URL de l'image
                  sendMessage(imageURL);
              })
              .catch(error => {
                  console.error('Erreur lors de l\'envoi de l\'image :', error);
              });
      } else {
          // Si aucun fichier image n'est sélectionné, envoyer le message texte
          sendMessage(messageContent);
      }
  });
  
  // Fonction pour envoyer un message avec le contenu spécifié
  function sendMessage(content) {
      // Créer un nouvel objet message avec les données à envoyer
      const messageData = {
          contenu: content,
          createdAt: new Date().toISOString(), // Date de création actuelle
          utilisateur_id: {{ app.user.id }},
          conversation_id: {{ conversation.id }},
          mine: true // C'est votre propre message
      };
  
      // Envoyer le message au serveur via WebSocket
      const message = {
          type: 'new_message',
          data: messageData
      };
  
      // Stocker les données du message dans Firebase
      firebaseref.push().set(messageData)
          .then(function() {
              console.log("Message stocké avec succès dans Firebase !");
          })
          .catch(function(error) {
              console.error("Erreur lors du stockage du message dans Firebase :", error);
          });
  
      socket.send(JSON.stringify(message));
  
      // Effacer le champ de saisie du message après l'envoi
      document.querySelector('textarea[name="message_content"]').value = '';
  }
  
  // Fonction pour télécharger une image sur Firebase Storage et retourner son URL
  function uploadImage(imageFile) {
      return new Promise((resolve, reject) => {
          // Créer une référence de stockage dans Firebase
          const storageRef = firebase.storage().ref();
          
          // Créer une référence de fichier dans Firebase Storage
          const imageRef = storageRef.child('images/' + imageFile.name);
          
          // Envoyer le fichier image à Firebase Storage
          imageRef.put(imageFile)
              .then(snapshot => {
                  // Récupérer l'URL de l'image téléchargée
                  imageRef.getDownloadURL()
                      .then(imageURL => {
                          // Résoudre la promesse avec l'URL de l'image
                          resolve(imageURL);
                      })
                      .catch(error => {
                          // Rejeter la promesse en cas d'erreur lors de la récupération de l'URL de l'image
                          reject(error);
                      });
              })
              .catch(error => {
                  // Rejeter la promesse en cas d'erreur lors de l'envoi du fichier image à Firebase Storage
                  reject(error);
              });
      });
  }
  
  
  // Script de recherche dynamique
  document.addEventListener('DOMContentLoaded', function () {
  // Écouter l'événement de saisie dans le champ de recherche
  document.getElementById('search-input').addEventListener('input', function () {
      const query = this.value.toLowerCase(); // Convertir la valeur en minuscules
      
      // Parcourir la liste des utilisateurs
      document.querySelectorAll('.user-list ul li').forEach(function (user) {
          const userName = user.textContent.toLowerCase(); // Convertir le nom d'utilisateur en minuscules
          
          // Afficher ou masquer l'utilisateur en fonction de la correspondance avec la requête de recherche
          if (userName.includes(query)) {
              user.style.display = 'block';
          } else {
              user.style.display = 'none';
          }
      });
  });
  });